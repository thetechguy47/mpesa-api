<?php
// mpesa-callback.php - Callback real para produção
require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

// Configurações
date_default_timezone_set('Africa/Maputo');
// Verificar ambiente
if (getenv('APP_ENV') !== 'production') {
    registrarLog("❌ AMBIENTE INCORRETO - Este endpoint é apenas para produção", 'ERROR');
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Production environment required']);
    exit;
}

if (!file_exists(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}

function registrarLog($mensagem, $tipo = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[{$timestamp}] [{$tipo}] {$mensagem}\n";
    error_log($log_entry, 3, __DIR__ . '/logs/mpesa_callback_production.log');
}

// Iniciar log
registrarLog("=== 📨 CALLBACK MPESA PRODUÇÃO INICIADO ===");

// Obter dados do callback
$input_data = file_get_contents('php://input');
registrarLog("Dados recebidos: " . $input_data);

if (empty($input_data)) {
    registrarLog("❌ CALLBACK VAZIO", 'ERROR');
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}


$input = json_decode($input_data, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    registrarLog("❌ JSON INVÁLIDO: " . json_last_error_msg(), 'ERROR');
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

try {
    // Extrair dados do callback
    $third_party_ref = $input['output_ThirdPartyReference'] ?? 'N/A';
    $response_code = $input['output_ResponseCode'] ?? 'DESCONHECIDO';
    $response_desc = $input['output_ResponseDesc'] ?? 'Sem descrição';
    $transaction_id = $input['output_TransactionID'] ?? 'N/A';
    $conversation_id = $input['output_ConversationID'] ?? 'N/A';
    $amount = $input['output_Amount'] ?? 'N/A';
    $client_number = $input['output_ClientNumber'] ?? 'N/A';

    registrarLog("📊 DADOS DO CALLBACK:");
    registrarLog("   ThirdPartyReference: " . $third_party_ref);
    registrarLog("   ResponseCode: " . $response_code);
    registrarLog("   ResponseDesc: " . $response_desc);
    registrarLog("   TransactionID: " . $transaction_id);
    registrarLog("   ConversationID: " . $conversation_id);
    registrarLog("   Amount: " . $amount);
    registrarLog("   ClientNumber: " . $client_number);

    // Determinar status
    if ($response_code === 'INS-0') {
        $status = 'completo';
        registrarLog("✅ PAGAMENTO CONFIRMADO", 'SUCCESS');
        
        
        registrarLog("🎓 Acesso ao curso liberado para: " . $client_number);
        
    } else {
        $status = 'falhou';
        registrarLog("❌ PAGAMENTO FALHOU: " . $response_desc, 'ERROR');
       
    }

   
    registrarLog("🎉 CALLBACK PROCESSADO - Status: " . $status);

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Callback processed successfully',
        'payment_status' => $status,
        'transaction_id' => $transaction_id
    ]);

} catch (Exception $e) {
    registrarLog("❌ ERRO NO PROCESSAMENTO: " . $e->getMessage(), 'ERROR');
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

registrarLog("=== 🔚 CALLBACK MPESA PRODUÇÃO FINALIZADO ===");
?>