<?php

require __DIR__ . "/../vendor/autoload.php";

use thetechguy\Mpesa;

// Tira limite de tempo de execução
set_time_limit(0);

// Define as credenciais
$api_key = "TUA_API_KEY_AQUI";
$public_key = "TUA_PUBLIC_KEY_AQUI";
$environment = "development"; // ou "production"

// Inicializa a instância do M-PESA
$mpesa = Mpesa::init($api_key, $public_key, $environment);

// Dados para transferir para o cliente
$data = [
    "value" => 10, // valor em Meticais
    "client_number" => "258846746589", // número do cliente que vai receber
    "agent_id" => 171717, // teu shortcode real da Vodacom
    "third_party_reference" => "REF12345", // referência do teu sistema
    "transaction_reference" => "TX1234567", // referência da transação
];

// Executa a operação B2C
$response = $mpesa->b2c($data);

// Mostra a resposta
print_r($response);
