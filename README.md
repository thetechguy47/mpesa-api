# BIBLIOTECA PARA INTEGRAÇÃO DO MPESA API PARA PAGAMENTOS ONLINE

Este repositório contém um exemplo simples de integração com M-Pesa para pagamentos via C2B em PHP. O objectivo deste README é explicar, passo a passo, o que é necessário para executar o projecto localmente (WAMP/XAMPP) e em produção, como configurar credenciais e como testar pagamentos.

## Estrutura principal

- `index.php` - Página frontend onde o utilizador preenche número, valor e envia a solicitação de pagamento.
- `processa-mpesa.php` - Script servidor que recebe a requisição do frontend e interage com a API M-Pesa (C2B). Ai colocar suas credencias fornecidas na (https://developer.mpesa.vm.co.mz)
- `mpesa-callback.php` - Endpoint para receber notificações (callbacks) da M-Pesa com o resultado da transação.
- `vendor/` - Dependências gerenciadas pelo Composer. Inclui `thetechguy/mpesa-api` que contém classes para facilitar chamadas à API M-Pesa.
- `logs/` e `storage/` - Pastas para armazenar logs e arquivos temporários.

> Observação: O pacote `thetechguy/mpesa-api` está incluído em `vendor/thetechguy/mpesa-api` como dependência do Composer. Revise `vendor/thetechguy/mpesa-api/README.md` e `examples/` se precisar de referências específicas.

## Pré-requisitos

- PHP 7.4+ (recomendado PHP 8.x)
- Composer (para gerenciar dependências)
- Servidor web (WAMP no Windows, LAMP, ou um servidor com SSL em produção)
- Certificado SSL (recomendado para produção; callbacks normalmente exigem HTTPS ai desativei pois e ambiente de teste teras que depois habilitar)
- Credenciais M-Pesa (Consumer Key, Consumer Secret, Shortcode...) fornecidas pela Vodacom

## Passo a passo — Instalação e configuração local (WAMP)

1. Coloque o Projecto na pasta do seu servidor web (ex.: `c:\wamp64\www\mpesa`).
2. Certifique-se de que o Apache e o MySQL (se necessário) do WAMP estão em execução.
3. Instale o Composer localmente se ainda não o fez: https://getcomposer.org/
4. Se você alterou o composer.json ou quiser actualizar dependências, rode no PowerShell:

```powershell
cd c:\wamp64\www\mpesa; composer install
```

5. Configure variáveis de ambiente ou edite o arquivo de configuração usado pelos scripts (se houver). Este projeto busca `MPESA_ENV` usando `getenv('MPESA_ENV')` e assume `sandbox` por padrão. Você pode definir variáveis de ambiente no Windows (sistema) ou em um arquivo `.env` se preferir (atenção: este projecto não inclui parser .env por padrão).

Exemplo (PowerShell - sessão atual):

```powershell
$env:MPESA_ENV = 'sandbox'
$env:MPESA_CONSUMER_KEY = 'SEU_CONSUMER_KEY'
$env:MPESA_CONSUMER_SECRET = 'SEU_CONSUMER_SECRET'
$env:MPESA_SHORTCODE = '123456'
$env:MPESA_PASSKEY = 'SUA_PASSKEY'
```

6. Garanta que `processa-mpesa.php` e `mpesa-callback.php` estejam configurados para ler essas variáveis ou para carregar um arquivo de configuração com as credenciais.

## Como funciona o fluxo (resumido)

1. O utilizador preenche número M-Pesa (+258xxxxxxxxx), valor e tipo no `index.php` e clica em PAGAR.
2. O frontend JavaScript envia uma requisição POST para `processa-mpesa.php` com os dados do pagamento.
3. `processa-mpesa.php` usa as classes do pacote `thetechguy/mpesa-api` (ou outra implementação) para criar a solicitação  C2B para a Vodacom.
4. A operadora processa a solicitação e envia um callback para `mpesa-callback.php` com o resultado (sucesso/erro, transação, reference id, etc.).
5. O sistema deve registrar (log) o callback e actualizar o estado do pedido/transação no seu sistema.

## Ajustes importantes no servidor

- Callbacks: a M-Pesa normalmente exige um endpoint HTTPS público para callbacks. Para testes locais você pode usar ferramentas como `ngrok` para expor seu servidor local via HTTPS.
- Firewalls/Ports: permita conexões de entrada (HTTPS) se você estiver em produção.
- Logs: configure `logs/` com permissões de escrita pelo servidor web.

## Testando (sandbox)

1. Use as credenciais de sandbox fornecidas pela Vodacom
2. Defina `MPESA_ENV` para `sandbox`.
3. Abra `index.php` no navegador (ex.: `http://localhost/mpesa/index.php`).
4. Preencha os dados (o frontend já possui exemplos/valores padrão) e clique em PAGAR.
5. Verifique os logs no frontend (`response-log`) e nos arquivos de `logs/` do servidor.

## Exemplo de integração em `processa-mpesa.php`

- Certifique-se de usar o autoload do Composer no topo do arquivo:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

- Em seguida, carregue as credenciais via `getenv()` ou outro método seguro e inicialize a classe do provedor M-Pesa conforme a biblioteca disponibiliza (consulte `vendor/thetechguy/mpesa-api/src/Mpesa.php`).


## Exemplos incluídos e como executá-los

O pacote `thetechguy/mpesa-api` já traz exemplos práticos na pasta `vendor/thetechguy/mpesa-api/examples`. Nessa pasta você encontrará, entre outros, os seguintes exemplos:

- `b2b.php` — exemplo de Business-to-Business
- `b2c.php` — exemplo de Business-to-Customer
- `c2b.php` — exemplo de Customer-to-Business 

Como instalar o pacote com Composer (adicionar ao seu projeto):

```powershell
cd C:\wamp64\www\mpesa
composer require thetechguy/mpesa-api
```
