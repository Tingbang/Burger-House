<?php
require 'app/paypal.php';
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
if(!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'])){
    die();
}


if(filter_var($_GET['success'] ===false, FILTER_VALIDATE_BOOLEAN)){
    header("Location: index.php");
}



$paymentid =$_GET['paymentId'];
$payerId=$_GET['PayerID'];

$payment = Payment::get($paymentid, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);



try{
    $result =$payment->execute($execute, $paypal);
    
}catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode(); // Prints the Error Code
    echo $ex->getData(); // Prints the detailed error message 
    die($ex);
} 



catch(Exception $e){
    die($e);
}


//unsets the session
unset($_SESSION['shopping_cart']);
header("Location: index.php");

?>