<?php

require __DIR__."/../autoload.php";

use thetechguy\Mpesa;

set_time_limit(0);

$api_key = "";
$public_key = "";
$environment = "development";
$mpesa = Mpesa::init($api_key, $public_key, $environment);

/* Customer name */
$data = [
	"client_number" => "258840000000",
	"agent_id" => 171717,
	"third_party_reference" => 33333,
];
$response = $mpesa->customer_name($data);
print_r($response);
