<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// header("Content-type: text/xml");

include './client.php';
$id_array = array('id' => '1');
$res = $client->getName($id_array);
var_dump($res);
echo '<br>';
$xml = simplexml_load_string($res->content);
var_dump($xml);
echo '<br>';
echo '<br>';
$cliente = array("name" => "Carlos", "dni" => "19269578", "email" => "carlos@rivas.com", "phone" => "123456");
var_dump($cliente);
echo '<br>';
echo '<br>';
$res = $client->registerUser($cliente);
var_dump($res);
echo '<br>';
echo '<br>';
if ($res->content) {

    $xml = simplexml_load_string($res->content);
    var_dump($xml);
}
echo '<br>';
echo '<br>';
$cliente = array("dni" => "19269578", "phone" => "123456", "amount" => 0.33);
var_dump($cliente);
echo '<br>';
echo '<br>';
$res = $client->rechargeWallet($cliente);
var_dump($res);
echo '<br>';
echo '<br>';
if ($res->content) {

    $xml = simplexml_load_string($res->content);
    var_dump($xml);
}
echo '<br>';
echo '<br>';
$cliente = array("dni" => "19269578", "phone" => "123456");
var_dump($cliente);
echo '<br>';
echo '<br>';
$res = $client->checkBalance($cliente);
var_dump($res);
echo '<br>';
echo '<br>';
if ($res->content) {

    $xml = simplexml_load_string($res->content);
    var_dump($xml);
}
echo '<br>';
echo '<br>';
$cliente = array("dni" => "19269578", "phone" => "123456", "amount" => 12);
var_dump($cliente);
echo '<br>';
echo '<br>';
$res = $client->generateToken($cliente);
var_dump($res);
echo '<br>';
echo '<br>';
if ($res->content) {

    $xml = simplexml_load_string($res->content);
    var_dump($xml);
}
echo '<br>';
echo '<br>';
$cliente = array("id" => "6", "token" => "538712");
var_dump($cliente);
echo '<br>';
echo '<br>';
$res = $client->confirmPayment($cliente);
var_dump($res);
echo '<br>';
echo '<br>';
if ($res->content) {

    $xml = simplexml_load_string($res->content);
    var_dump($xml);
}
