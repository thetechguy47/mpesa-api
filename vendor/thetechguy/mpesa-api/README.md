# mpesa-api
API escrita em PHP para M-PESA (Moçambique)

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

Esta API (Aplication programing interface), permite efectuar transações no m-pesa usando o PHP.

## Instalação
```bash
composer require thetechguy/mpesa-api
```
## Implementação

Primeiramente crie uma conta no site https://developer.mpesa.vm.co.mz/ e obtenha a **api key** e o **public key**
```php
use thetechguy\Mpesa;

$api_key = "";		# Aqui introduz a api key disponibilizada no site
$public_key = "";	# Aqui introduz o public key disponibilizado no site
$environment = "development";		# production/development

# Inicialização e criação do objecto
$mpesa = Mpesa::init($api_key, $public_key, $environment);
```
