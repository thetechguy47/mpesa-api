
<!-- ===============================================================================
Aquele que não busca pelo conhecimento, se torna dependente da sabedoria dos outros.
  ==================================================================================
* Criador: Vicente de Paulo
  * Contacto & Whatsapp: 846746589 
  * Portfolio: https://vchauque47.com
==================================================================================-->

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento M-Pesa - Produção</title>
     <meta name="description" content="Vicente Chauque - Licenciado em Administração de Sistemas e Informação. Programador Web Fullstack, Designer, Especialista em Bases de Dados e Cibersegurança.">
    <meta name="keywords" content="Vicente Chauque, vchauque47, Programador Web, Fullstack, HTML, CSS, JavaScript, PHP, MySQL, Cibersegurança, Designer, Moçambique">
    <meta name="author" content="Vicente Chauque">    
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicone-the-tech-guy.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: #DD1D25;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .input-group {
            display: flex;
            align-items: center;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }
        
        .input-group:focus-within {
            border-color: #00A650;
        }
        
        .input-group-prepend {
            background: #f8f9fa;
            padding: 12px 15px;
            border-right: 2px solid #e1e5e9;
            font-weight: 600;
            color: #666;
        }
        
        .input-group input {
            flex: 1;
            border: none;
            padding: 12px 15px;
            font-size: 16px;
            outline: none;
        }
        
        .input-group select {
            flex: 1;
            border: none;
            padding: 12px 15px;
            font-size: 16px;
            outline: none;
            background: white;
        }
        
        .price-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .price-display .amount {
            font-size: 32px;
            font-weight: bold;
            color: #00A650;
            margin-bottom: 5px;
        }
        
        .price-display .label {
            color: #666;
            font-size: 14px;
        }
        
        .btn-mpesa {
            width: 100%;
            background: #DD1D25;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-mpesa:hover {
            background: #008c45;
        }
        
        .btn-mpesa:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #00A650;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        .response-log {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            max-height: 200px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
            display: none;
        }
        
        .success { color: #00A650; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .feature {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .feature i {
            font-size: 24px;
            color: #00A650;
            margin-bottom: 8px;
        }
        
        .feature span {
            font-size: 12px;
            color: #666;
        }
        
        .security-badge {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: #e8f5e8;
            border-radius: 8px;
            border: 1px solid #00A650;
        }
        
        .security-badge i {
            color: #00A650;
            margin-right: 5px;
        }
        
        .valor-input {
            font-size: 18px;
            font-weight: 600;
        }
        
        .curso-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }
        
        .curso-info h3 {
            margin: 0 0 10px 0;
            color: #1976d2;
            font-size: 16px;
        }
        
        .curso-info p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-mobile-alt"></i> Pagamento M-Pesa</h1>
            <p>Ambiente de Produção Real</p>
        </div>
        
        <div class="content">
            <div class="curso-info">
                <h3><i class="fas fa-book"></i> Informações do Curso</h3>
                <p><strong>Curso:</strong> <span id="curso-nome">Programação Web Avançada</span></p>
                <p><strong>Instrutor:</strong> Vicente Chauque</p>
                <p><strong>Duração:</strong> 6 meses</p>
            </div>
            
            <div class="features">
                <div class="feature">
                    <i class="fas fa-bolt"></i>
                    <div>Instantâneo</div>
                </div>
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <div>Seguro</div>
                </div>
                <div class="feature">
                    <i class="fas fa-clock"></i>
                    <div>24/7</div>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <div>Sem Taxas</div>
                </div>
            </div>
            
            <?php
            
            $env = getenv('MPESA_ENV') ?: 'sandbox';
            ?>
            <div style="text-align:right; margin-bottom:10px; font-size:12px; color:#666;">
                Ambiente: <strong><?php echo htmlspecialchars($env); ?></strong>
            </div>

            <form id="mpesa-form">
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone-alt"></i> Número M-Pesa</label>
                    <div class="input-group">
                        <span class="input-group-prepend">+258</span>
                        <input type="tel" id="phone" name="phone" placeholder="841234567" maxlength="9"  value="846746589">
                    </div>
                    <small style="color: #666; font-size: 12px;">Digite o número associado à sua conta M-Pesa</small>
                </div>
                
                <div class="form-group">
                    <label for="valor"><i class="fas fa-money-bill-wave"></i> Valor do Pagamento (MZN)</label>
                    <div class="input-group">
                        <span class="input-group-prepend">MZN</span>
                        <input type="number" id="valor" name="valor" placeholder="500.00" min="10" max="10000" step="0.01"  class="valor-input">
                    </div>
                    <small style="color: #666; font-size: 12px;">Digite o valor que deseja pagar (mínimo: 10 MZN)</small>
                </div>
                
                <div class="form-group">
                    <label for="tipo-pagamento"><i class="fas fa-credit-card"></i> Tipo de Pagamento</label>
                    <div class="input-group">
                        <span class="input-group-prepend"><i class="fas fa-list"></i></span>
                        <select id="tipo-pagamento" name="tipo-pagamento" >
                            <option value="">Selecione o tipo...</option>
                            <option value="curso">Pagamento de Curso</option>
                            <option value="mensalidade">Mensalidade</option>
                            <option value="matricula">Taxa de Matrícula</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="descricao"><i class="fas fa-file-alt"></i> Descrição (Opcional)</label>
                    <div class="input-group">
                        <span class="input-group-prepend"><i class="fas fa-pencil-alt"></i></span>
                        <input type="text" id="descricao" name="descricao" placeholder="Ex: Curso de Programação Web">
                    </div>
                </div>
                
                <button type="submit" class="btn-mpesa" id="submit-btn">
                    <i class="fas fa-mobile-alt"></i> PAGAR COM M-PESA
                </button>
            </form>
            
            <div class="security-badge">
                <i class="fas fa-lock"></i>
                <small>Pagamento seguro via M-Pesa • SSL Ativo</small>
            </div>
            
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>Processando pagamento...</p>
                <p style="font-size: 12px; color: #666;">Aguarde a confirmação no seu telefone</p>
            </div>
            
            <div class="response-log" id="response-log"></div>
        </div>
    </div>

    <script>
     
        const form = document.getElementById('mpesa-form');
        const phoneInput = document.getElementById('phone');
        const valorInput = document.getElementById('valor');
        const tipoPagamentoInput = document.getElementById('tipo-pagamento');
        const descricaoInput = document.getElementById('descricao');
        const submitBtn = document.getElementById('submit-btn');
        const loading = document.getElementById('loading');
        const responseLog = document.getElementById('response-log');

       
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 9) value = value.substring(0, 9);
            e.target.value = value;
        });

    
        valorInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d.]/g, '');
            
         
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
           
            if (parts.length === 2 && parts[1].length > 2) {
                value = parts[0] + '.' + parts[1].substring(0, 2);
            }
            
            e.target.value = value;
        });

    
        valorInput.addEventListener('blur', function(e) {
            const valor = parseFloat(e.target.value);
            if (valor < 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Valor Mínimo',
                    text: 'O valor mínimo para pagamento é 10 MZN',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                e.target.value = '10.00';
            }
        });

   
        function addLog(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const logEntry = document.createElement('div');
            logEntry.innerHTML = `<span class="${type}">[${timestamp}] ${message}</span>`;
            responseLog.appendChild(logEntry);
            responseLog.scrollTop = responseLog.scrollHeight;
            responseLog.style.display = 'block';
        }

      
        function showLoading() {
            loading.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PROCESSANDO...';
        }

        function hideLoading() {
            loading.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-mobile-alt"></i> PAGAR COM M-PESA';
        }

      
        function formatarValor(valor) {
            return new Intl.NumberFormat('pt-MZ', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(valor);
        }

        async function processarPagamentoMpesa(dadosPagamento) {
     
            const isProduction = window.location.hostname !== 'localhost' && 
                               window.location.hostname !== '127.0.0.1';
            
            addLog(`🔍 Iniciando processo de pagamento em ambiente ${isProduction ? 'PRODUÇÃO' : 'TESTE'}...`, 'info');
            
            if (!isProduction) {
                addLog('⚠️ AVISO: Executando em ambiente de teste', 'warning');
            }
            
            try {
                addLog('🔄 Conectando com API M-Pesa...', 'warning');
                
                const response = await fetch('processa-mpesa.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'action': 'processar_mpesa',
                        'phone': dadosPagamento.phone,
                        'valor': dadosPagamento.valor,
                        'tipo_pagamento': dadosPagamento.tipoPagamento,
                        'descricao': dadosPagamento.descricao
                    })
                });

        
                const contentType = response.headers.get('content-type') || '';
                addLog(`📡 Content-Type recebido: ${contentType}`, 'info');

                const text = await response.text();

                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseError) {
                  
                    addLog('❌ Resposta inesperada do servidor (não é JSON):', 'error');
                 
                    const preview = text.length > 1000 ? text.substring(0, 1000) + '... (truncated)' : text;
                    addLog(preview, 'error');

                    Swal.fire({
                        icon: 'error',
                        title: 'Resposta Inválida do Servidor',
                        html: `<div style="text-align:left;"><p>O servidor retornou uma resposta inesperada. Verifique o log de resposta para mais detalhes.</p></div>`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });

                    throw new Error('Resposta inválida do servidor: não foi possível parsear JSON');
                }
                
                if (!response.ok) {
                    throw new Error(data.mensagem || 'Erro na comunicação com o servidor');
                }

                if (data.status === 'success') {
                    addLog('✅ SOLICITAÇÃO ACEITA PELA M-PESA', 'success');
                    addLog(`📞 ConversationID: ${data.conversation_id}`, 'info');
                    addLog(`💳 TransactionID: ${data.transaction_id}`, 'info');
                    addLog(`🆔 ResponseCode: ${data.response_code}`, 'info');
                    addLog(`💰 Valor: ${formatarValor(dadosPagamento.valor)} MZN`, 'info');

                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitação Enviada!',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>📱 Aguarde a confirmação no seu telefone</strong></p>
                                <p>Você receberá um pedido de confirmação no seu M-Pesa.</p>
                                <p><strong>Número:</strong> +258${dadosPagamento.phone}</p>
                                <p><strong>Valor:</strong> ${formatarValor(dadosPagamento.valor)} MZN</p>
                                <p><strong>Tipo:</strong> ${dadosPagamento.tipoPagamento}</p>
                                <p><strong>Referência:</strong> ${data.referencia}</p>
                                <p style="color: #00A650; font-weight: bold;">
                                    <i class="fas fa-check-circle"></i> Após confirmar no telefone, o pagamento será processado automaticamente
                                </p>
                            </div>
                        `,
                        confirmButtonText: 'Entendi',
                        confirmButtonColor: '#00A650',
                        width: 600
                    });

                    return {
                        success: true,
                        data: data
                    };

                } else {
                    addLog(`❌ ERRO: ${data.mensagem}`, 'error');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro no Pagamento',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>Erro: ${data.mensagem}</strong></p>
                                <p>Por favor, verifique os dados e tente novamente.</p>
                            </div>
                        `,
                        confirmButtonText: 'Tentar Novamente',
                        confirmButtonColor: '#dc3545'
                    });

                    return {
                        success: false,
                        error: data.mensagem
                    };
                }

            } catch (error) {
                addLog(`❌ ERRO NA COMUNICAÇÃO: ${error.message}`, 'error');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de Comunicação',
                    text: 'Erro ao conectar com o servidor. Tente novamente.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });

                return {
                    success: false,
                    error: error.message
                };
            }
        }

     
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const phoneNumber = phoneInput.value.trim();
            const valor = parseFloat(valorInput.value);
            const tipoPagamento = tipoPagamentoInput.value;
            const descricao = descricaoInput.value.trim();

    
            if (!phoneNumber || phoneNumber.length !== 9) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Número Inválido',
                    text: 'Por favor, insira um número M-Pesa válido (9 dígitos)',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            if (!valor || valor < 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Valor Inválido',
                    text: 'O valor mínimo para pagamento é 10 MZN',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            if (!tipoPagamento) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tipo de Pagamento',
                    text: 'Por favor, selecione o tipo de pagamento',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            const dadosPagamento = {
                phone: phoneNumber,
                valor: valor,
                tipoPagamento: tipoPagamento,
                descricao: descricao || 'Pagamento via M-Pesa'
            };

       
            responseLog.innerHTML = '';
            
         
            showLoading();
         
            const resultado = await processarPagamentoMpesa(dadosPagamento);
            
       
            hideLoading();
            
            if (resultado.success) {
                addLog('🎉 Processo concluído com sucesso!', 'success');
                addLog('📱 Aguarde a confirmação no seu telefone M-Pesa', 'info');
                addLog('⏳ O sistema irá verificar automaticamente a confirmação', 'info');
                
         
                form.reset();
            } else {
                addLog('💥 Processo falhou', 'error');
            }
        });

     
        addLog('🚀 Sistema M-Pesa PRODUÇÃO inicializado', 'success');
        addLog('📍 Ambiente: PRODUÇÃO REAL', 'warning');
        addLog('💡 Preencha os dados e clique em PAGAR', 'info');

        // Preenchedo os valores padrão para teste
        valorInput.value = '500.00';
        tipoPagamentoInput.value = 'curso';
        descricaoInput.value = 'Curso de Programação Web Avançada';
    </script>
</body>
</html>