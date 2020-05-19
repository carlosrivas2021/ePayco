<?php

class client
{

    public function __construct()
    {
        $params = array(
            'location' => 'http://localhost/payco/soap/public/api/server',
            'uri' => 'urn://localhost/payco/soap/public/api/server',
            'trace' => 1
        );
        $this->instance = new SoapClient(NULL, $params);
    }

    public function getName($id_array)
    {
        return $this->instance->__soapCall('getStudentName', $id_array);
    }

    public function registerUser($cliente)
    {
        echo '<br>';

        return $this->instance->__soapCall('registroCliente', $cliente);
    }

    public function rechargeWallet($cliente)
    {
        echo '<br>';

        return $this->instance->__soapCall('rechargeWallet', $cliente);
    }

    public function checkBalance($cliente)
    {
        echo '<br>';

        return $this->instance->__soapCall('checkBalance', $cliente);
    }

    public function generateToken($cliente)
    {
        echo '<br>';

        return $this->instance->__soapCall('generateToken', $cliente);
    }

    public function confirmPayment($cliente)
    {
        echo '<br>';

        return $this->instance->__soapCall('confirmPayment', $cliente);
    }
}


$client = new client;