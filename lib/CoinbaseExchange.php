<?php

if(!function_exists('curl_init')) {
    throw new Exception('The Coinbase client library requires the CURL PHP extension.');
}

require_once(dirname(__FILE__) . '/CoinbaseExchange/CoinbaseExchange.php');
require_once(dirname(__FILE__) . '/CoinbaseExchange/Request.php');
