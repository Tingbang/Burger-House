<?php
require 'vendor/';

define("SITE_URL", '');


$ClientId=""; //Private API Key
$ClientSecret ="";

$paypal = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            '*',     // ClientID
            '*'      // ClientSecret
        )
);