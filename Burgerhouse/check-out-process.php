<?php

//This page is used to accept PayPal Payments using 
//The paypal API
require 'app/paypal.php';
use PayPal\Api\Payer;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;

use PayPal\Api\RedirectUrls;

include ('Classes/cart.php');

//Create an object of the class Cart()
$obj = new Cart();
//Runs the order summary function class
//To get the order from the cart
$obj->orderSummary();
//Sets the total price so that PayPal knows what to charge
$total = $obj->print_total();
//Set Payment Method
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');
//Set amount to be paid
$amount = new \PayPal\Api\Amount();
$amount->setTotal($total);
$amount->setCurrency('USD');
//Set transaction amount
$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

//Set redirect urls
$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')
    ->setCancelUrl(SITE_URL . '/pay.php?sucess=false');

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);
//ERROR HANDLING
//Check if the payment will successfully go through
//If not carch error.
try {
    $payment->create($paypal);
    
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode(); // Prints the Error Code
    echo $ex->getData(); // Prints the detailed error message 
    die($ex);
} catch (Exception $ex) {
    die($ex);
}


$approvalURL = $payment->getApprovalLink();
header("Location: {$approvalURL}");
//echo $total;

?>