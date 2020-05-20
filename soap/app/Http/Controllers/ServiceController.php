<?php

namespace App\Http\Controllers;

use App\Token;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function uppercaseUserName($userName)
    {
        $data = [
            'status' => 'success',
            'data' => [
                'first_name' => 'John',
                'last_name' => 'Smith',
            ]
        ];
        return response()->xml($data);
        return response()->xml(['status' => 'success', 'value' => ['id' => $userName, 'name' => 'Sam']], 200);
    }
    public function getStudentName($userName)
    {
        $data = [
            'status' => 'success',
            'data' => [
                'first_name' => 'John',
                'last_name' => 'Smith',
            ]
        ];
        // return response()->xml($data);
        return response()->xml(['status' => 'success', 'value' => ['id' => $userName, 'name' => 'Sam']], 200);
    }

    public function registroCliente($name, $dni, $email, $phone)
    {
        $array = ['name' => $name, 'dni' => $dni, 'email' => $email, 'phone' => $phone];

        $validator = Validator::make($array, [
            "name" => "required|alpha",
            "dni" => "required|unique:users,dni",
            "email" => "email|required|unique:users,email",
            "phone" => "required",

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->xml(['status' => 'error', 'value' => $errors->all()], 422);
        }

        $user = User::create($array);


        return response()->xml(['status' => 'success', 'value' => $user]);
    }

    public function rechargeWallet($dni, $phone, $amount)
    {
        $array = ['dni' => $dni, 'amount' => $amount, 'phone' => $phone];

        $validator = Validator::make($array, [

            "dni" => "required",
            "amount" => "required|numeric|min:0",
            "phone" => "required",

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->xml(['status' => 'error', 'value' => $errors->all()], 406);
        }

        $user = User::where('dni', $dni)->where('phone', $phone)->first();

        if (!$user) {
            return response()->xml(['status' => 'error', 'value' => 'El usuario no existe'], 406);
        }
        $transaction = Transaction::create([
            'type' => 'deposit',
            'user_id' => $user->id,
            'amount' => $amount
        ]);
        if (!$transaction) {
            return response()->xml(['status' => 'error', 'value' => 'Intente nuevamente procesando su deposito'], 406);
        }

        $user->amount = $user->amount + $amount;
        $user->save();
        return response()->xml(['status' => 'success', 'value' => $user]);
    }

    public function checkBalance($dni, $phone)
    {
        $array = ['dni' => $dni, 'phone' => $phone];

        $validator = Validator::make($array, [
            "dni" => "required",
            "phone" => "required",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->xml(['status' => 'error', 'value' => $errors->all()], 406);
        }

        $user = User::where('dni', $dni)->where('phone', $phone)->first();
        if (!$user) {
            return response()->xml(['status' => 'error', 'value' => 'El usuario no existe'], 406);
        }
        return response()->xml(['status' => 'success', 'value' => $user->amount]);
    }

    public function generateToken($dni, $phone, $amount)
    {
        $array = ['dni' => $dni, 'phone' => $phone, 'amount' => $amount];

        $validator = Validator::make($array, [
            "dni" => "required",
            "amount" => "required|numeric|min:0",
            "phone" => "required",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->xml(['status' => 'error', 'value' => $errors->all()], 406);
        }

        $user = User::where('dni', $dni)->where('phone', $phone)->first();
        if (!$user) {
            return response()->xml(['status' => 'error', 'value' => 'El usuario no existe'], 406);
        }
        // return response()->xml(['status' => 'error', 'value' => rand(100000,999999)], 406);

        if ($user->amount < $amount) {
            return response()->xml(['status' => 'error', 'value' => 'Su saldo no es suficiente'], 406);
        }

        $user->token = rand(100000, 999999);

        $token = Token::create([
            'expired_at' => Carbon::now()->addMinutes(5),
            'token' => $user->token,
            'amount' => $amount,
            'user_id' => $user->id
        ]);

        $user->session_id = $token->id;

        if (!$token) {
            return response()->xml(['status' => 'error', 'value' => 'Solicite el token nuevamente'], 406);
        }
        Mail::send('emails.contact', ['data' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->Name)->subject('Tu mensaje fue recibido');
        });
        return response()->xml(['status' => 'success']);
    }

    public function confirmPayment($id, $token)
    {
        $array = ['id' => $id, 'token' => $token];

        $validator = Validator::make($array, [
            "id" => "required",
            "token" => "required",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->xml(['status' => 'error', 'value' => $errors->all()], 406);
        }

        $token = Token::where('id', $id)->where('token', $token)->first();
        if (!$token) {
            return response()->xml(['status' => 'error', 'value' => 'El token no existe'], 406);
        }
        $today = Carbon::now();
        if ($today->greaterThan($token->expired_at) || $token->used_at) {
            return response()->xml(['status' => 'error', 'value' => 'El token expiro'], 406);
        }

        $token->used_at = $today;
        $user = User::find($token->user_id);
        if ($user->amount < $token->amount) {
            return response()->xml(['status' => 'error', 'value' => 'Su saldo no es suficiente'], 406);
        }
        $user->amount = $user->amount - $token->amount;
        $token->save();
        $user->save();
        return response()->xml(['status' => 'success']);
    }
}
