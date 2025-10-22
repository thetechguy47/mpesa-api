
                <?php
                // processa-mpesa.php - Backend M-Pesa (ambientes: sandbox por padrão)
                require __DIR__ . '/vendor/autoload.php';
                use thetechguy\Mpesa;

                header('Content-Type: application/json; charset=utf-8');
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Methods: POST, OPTIONS');
                header('Access-Control-Allow-Headers: Content-Type');

                // Ambiente (ler da variável de ambiente MPESA_ENV ou usar "sandbox ambiente de teste neste caso")
                $environment = getenv('MPESA_ENV') ?: 'sandbox'; // "production" ou "sandbox"

                // Chaves / API tens criar a conta obteras aqui trocar com suas (https://developer.mpesa.vm.co.mz/)
                $api_key = getenv('MPESA_API_KEY') ?: "l436a989wdkjkvuponsj02lhqkiel8skjjkrpb17o6t";
                $public_key = <<<EOD
                -----BEGIN PUBLIC KEY-----
                 MIICIjANBgkqhkiG9w0BAQEFAAOCAgHS8AMIICCgKsmnmsCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==
                -----END PUBLIC KEY-----
                EOD;

                // Configurações por ambiente
                if ($environment === 'production') {
                    $agent_id = getenv('MPESA_AGENT_ID') ?: "171717"; // substituir por produção esse e de deste meu caro kkkk
                    $callback_url = getenv('MPESA_CALLBACK_URL') ?: "https://seu-dominio.com/mpesa-callback.php";
                } else {
                    // sandbox / desenvolvimento
                    $agent_id = getenv('MPESA_AGENT_ID') ?: "171717";
                    $callback_url = getenv('MPESA_CALLBACK_URL') ?: "sandbox-callback.php";
                }

               
                if (!file_exists(__DIR__ . '/logs')) {
                    mkdir(__DIR__ . '/logs', 0777, true);
                }
                if (!file_exists(__DIR__ . '/storage')) {
                    mkdir(__DIR__ . '/storage', 0777, true);
                }
                
                if (!file_exists(__DIR__ . '/storage/notifications.log')) {
                    file_put_contents(__DIR__ . '/storage/notifications.log', "");
                }
                if (!file_exists(__DIR__ . '/storage/payments.log')) {
                    file_put_contents(__DIR__ . '/storage/payments.log', "");
                }

                // Função para registrar logs incluindo o ambiente
                function registrarLog($mensagem, $tipo = 'INFO') {
                    global $environment;
                    $timestamp = date('Y-m-d H:i:s');
                    $log_entry = "[{$timestamp}] [{$tipo}] [{$environment}] {$mensagem}\n";
                    error_log($log_entry, 3, __DIR__ . '/logs/mpesa_' . $environment . '.log');
                }

                // Iniciar log
                registrarLog("=== 🚀 INICIO PROCESSAMENTO MPESA ({$environment}) ===");

                if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                    http_response_code(200);
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'mensagem' => 'Método não permitido']);
                    exit;
                }

                try {
                    // Validar dados de entrada
                    if (empty($_POST['action']) || $_POST['action'] !== 'processar_mpesa') {
                        throw new Exception('Ação inválida');
                    }

                    if (empty($_POST['phone']) || empty($_POST['valor'])) {
                        throw new Exception('Dados incompletos');
                    }

                    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
                    $valor = floatval($_POST['valor']);
                    $tipo_pagamento = $_POST['tipo_pagamento'] ?? 'outro';
                    $descricao = $_POST['descricao'] ?? 'Pagamento via M-Pesa';

                    if (strlen($phone) !== 9) {
                        throw new Exception('Número M-Pesa inválido (deve ter 9 dígitos)');
                    }

                    if ($valor < 10) {
                        throw new Exception('Valor mínimo é 10 MZN');
                    }

                    if ($valor > 10000) {
                        throw new Exception('Valor máximo é 10,000 MZN');
                    }

                    registrarLog("📞 Processando pagamento:");
                    registrarLog("   Número: +258{$phone}");
                    registrarLog("   Valor: {$valor} MZN");
                    registrarLog("   Tipo: {$tipo_pagamento}");
                    registrarLog("   Descrição: {$descricao}");

             
                    if ($environment === 'production') {
                        $ssl_opts = [
                            'verify_peer' => true,
                            'verify_peer_name' => true,
                            'allow_self_signed' => false
                        ];
                        $curl_ssl_verify_host = 2;
                        $curl_ssl_verifypeer = 1;
                    } else {
                        // sandbox / desenvolvimento - desativei verificações SSL em producao activar 
                        $ssl_opts = [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ];
                        $curl_ssl_verify_host = 0;
                        $curl_ssl_verifypeer = 0;
                    }

                    $mpesa = Mpesa::init($api_key, $public_key, $environment, [
                        'stream_context_options' => [
                            'ssl' => $ssl_opts,
                            'http' => [
                                'timeout' => 60,
                                'ignore_errors' => true
                            ]
                        ],
                        'curl_options' => [
                            CURLOPT_SSL_VERIFYHOST => $curl_ssl_verify_host,
                            CURLOPT_SSL_VERIFYPEER => $curl_ssl_verifypeer,
                            CURLOPT_TIMEOUT => 60,
                            CURLOPT_CONNECTTIMEOUT => 30,
                            CURLOPT_RETURNTRANSFER => true
                        ]
                    ]);

                    // Gerar referências únicas
                    $transacao_id = 'TXN' . time() . rand(100, 999);
                    $referencia_pagamento = strtoupper(substr($tipo_pagamento, 0, 3)) . time() . rand(100, 999);

                    // Dados para M-Pesa
                    $data = [
                        'value' => $valor,
                        'client_number' => '258' . $phone,
                        'agent_id' => $agent_id,
                        'third_party_reference' => $referencia_pagamento,
                        'transaction_reference' => $transacao_id,
                        'callback_url' => $callback_url
                    ];

                    registrarLog("📤 Enviando para M-Pesa: " . json_encode($data));

                    // Processar pagamento
                    $response = $mpesa->c2b($data);

                    registrarLog("📥 Resposta M-Pesa: " . var_export($response, true));

                    // Processar resposta
                    $response_data = $response;

                    if (is_string($response)) {
                        $decoded = json_decode($response, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $response_data = $decoded;
                        }
                    }

                    if (is_array($response_data)) {
                        if (isset($response_data['output_ResponseCode'])) {
                            $response_code = $response_data['output_ResponseCode'];
                            $response_desc = $response_data['output_ResponseDesc'] ?? 'Sem descrição';

                            if ($response_code === 'INS-0') {
                                // Sucesso - solicitação aceita
                                registrarLog("✅ SOLICITAÇÃO ACEITA - Aguardando confirmação");

                                echo json_encode([
                                    'status' => 'success',
                                    'mensagem' => 'Solicitação de pagamento enviada com sucesso',
                                    'conversation_id' => $response_data['output_ConversationID'] ?? 'N/A',
                                    'transaction_id' => $response_data['output_TransactionID'] ?? 'N/A',
                                    'response_code' => $response_code,
                                    'response_desc' => $response_desc,
                                    'referencia' => $referencia_pagamento,
                                    'transacao_id' => $transacao_id,
                                    'valor' => $valor,
                                    'tipo_pagamento' => $tipo_pagamento
                                ]);

                            } else {
                                registrarLog("❌ ERRO MPESA: {$response_desc} (Código: {$response_code})", 'ERROR');
                                throw new Exception("M-Pesa: {$response_desc} (Código: {$response_code})");
                            }
                        } else {
                            throw new Exception('Resposta inválida da M-Pesa');
                        }
                    } else {
                        throw new Exception('Resposta inesperada da M-Pesa');
                    }

                } catch (Exception $e) {
                    registrarLog("❌ ERRO: " . $e->getMessage(), 'ERROR');

                    http_response_code(400);
                    echo json_encode([
                        'status' => 'error',
                        'mensagem' => $e->getMessage()
                    ]);
                }

                registrarLog("=== 🔚 FIM PROCESSAMENTO ({$environment}) ===");
                ?>
        