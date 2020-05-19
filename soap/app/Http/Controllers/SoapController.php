<?php

namespace App\Http\Controllers;

use App\Providers\MethodsProvider;
use Illuminate\Http\Request;

use WSDL\Annotation\BindingType;
use WSDL\Annotation\SoapBinding;
use WSDL\Builder\WSDLBuilder;
use WSDL\WSDL;

class SoapController extends Controller
{
    public function server()
    {
        $params = array('uri' => 'http://localhost/payco/soap/public/api/server');
        $server = new \SoapServer(Null, $params);
        $server->setClass('App\Http\Controllers\ServiceController');
        $server->handle();

    }
}
