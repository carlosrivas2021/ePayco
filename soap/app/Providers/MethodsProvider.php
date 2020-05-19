<?php

/**
 * Copyright (C) 2013-2019
 * Piotr Olaszewski <piotroo89@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Providers;

use WSDL\Builder\Method;
use WSDL\Builder\Parameter;
use WSDL\Lexer\Tokenizer;

/**
 * MethodsProvider
 *
 * @author Piotr Olaszewski <piotroo89@gmail.com>
 */
class MethodsProvider
{
    /**
     * @return Method[]
     * @throws Exception
     */
    public static function get()
    {
        $tokenizer = new Tokenizer();

        $parameters1 = [Parameter::fromTokens($tokenizer->lex('string $userName'))];
        $return1 = Parameter::fromTokens($tokenizer->lex('string $uppercasedUserName'));

        $parameters2 = [Parameter::fromTokens($tokenizer->lex('string $userName'))];
        $return2 = Parameter::fromTokens($tokenizer->lex('string $getStudentName'));

        $parameters3 = [
            Parameter::fromTokens($tokenizer->lex('string $name')),
            Parameter::fromTokens($tokenizer->lex('string $dni')),
            Parameter::fromTokens($tokenizer->lex('string $email')),
            Parameter::fromTokens($tokenizer->lex('string $phone'))
        ];
        $return3 = Parameter::fromTokens($tokenizer->lex('string $registroCliente'));

        $parameters4 = [
            Parameter::fromTokens($tokenizer->lex('string $dni')),
            Parameter::fromTokens($tokenizer->lex('string $phone')),
            Parameter::fromTokens($tokenizer->lex('float $amount'))
        ];
        $return4 = Parameter::fromTokens($tokenizer->lex('string $rechargeWallet'));

        $parameters5 = [
            Parameter::fromTokens($tokenizer->lex('string $dni')),
            Parameter::fromTokens($tokenizer->lex('string $phone'))
        ];
        $return5 = Parameter::fromTokens($tokenizer->lex('string $checkBalance'));

        $parameters6 = [
            Parameter::fromTokens($tokenizer->lex('string $dni')),
            Parameter::fromTokens($tokenizer->lex('string $phone')),
            Parameter::fromTokens($tokenizer->lex('float $amount'))

        ];
        $return6 = Parameter::fromTokens($tokenizer->lex('string $generateToken'));

        $parameters7 = [
            Parameter::fromTokens($tokenizer->lex('string $id')),
            Parameter::fromTokens($tokenizer->lex('string $token'))

        ];
        $return7 = Parameter::fromTokens($tokenizer->lex('string $generateToken'));
        // $parameters2 = [
        //     Parameter::fromTokens($tokenizer->lex('int[] $numbers')),
        //     Parameter::fromTokens($tokenizer->lex('string $prefix'))
        // ];
        // $return2 = Parameter::fromTokens($tokenizer->lex('string[] $numbersWithPrefix'));


        return [
            new Method('uppercaseUserName', $parameters1, $return1),
            new Method('getStudentName', $parameters2, $return2),
            new Method('registroCliente', $parameters3, $return3),
            new Method('rechargeWallet', $parameters4, $return4),
            new Method('checkBalance', $parameters5, $return5),
            new Method('generateToken', $parameters6, $return6),
            new Method('confirmPayment', $parameters7, $return7)
        ];
    }
}
