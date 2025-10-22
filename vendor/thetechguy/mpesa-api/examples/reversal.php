<?php

require __DIR__."/../autoload.php";

use thetechguy\Mpesa;

set_time_limit(0);

$api_key = "";
$public_key = "";
$environment = "development";
$mpesa = Mpesa::init($api_key, $public_key, $environment);

/* Reversal */
$data = [
	"value" => 10,
	"security_credential" => "",
	"indicator_identifier" => "",
	"transaction_id" => "",
	"agent_id" => 171717,
	"third_party_reference" => 33333,
	"transaction_id" => "",
];
$response = $mpesa->reversal($data);
print_r($response);
