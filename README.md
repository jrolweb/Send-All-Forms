# Send-All-Forms PHP

Simply send any form via email with SMTP authentication.

## PT-BR

Envie qualquer formulário de forma simples com autenticação SMTP usando PHP.

## Pré-requisitos

* PHP 7+

## Licença

* MIT

## Instalação

* Inclua o arquivo `send-all-forms.php` no diretório raiz do seu projeto.
* Crie a pasta `PHPMailer` no diretório raiz do seu projeto e inclua as classes `PHPMailer`, `SMTP` e `Exeption` do PHPMailer. (https://github.com/PHPMailer/PHPMailer/tree/master/src)

## 1. Configurando o Script

### 1.1. Configuração de E-mail

No arquivo `send-all-forms.php` preencha as variáveis com as configurações do seu serviço de e-mail.

```php
//Config
$host_smtp  = "";   // Specify main and backup SMTP servers
$user       = "";   // SMTP username
$pass       = "";   // SMTP password
$from_email = "";
$from_name  = "My Website";
$to         = "";
$port       = "465";   // TCP port to connect to
$sec        = "ssl";   // tls or ssl
```

### 1.2. Autorizar Formulário

Registre o nome formulários permitidos na array `$allowed_forms`.

```php
$allowed_forms = array(
    'contact-form',
    'contact-form-2',
);
```
## 2. Configurando o Formulário

### 2.1. Action

```html
<form action="send-all-forms.php" method="post">
```

### 2.2. Campos de configuração

Adicione ao seu formulário, os campos de configuração do tipo `hidden`

```html
<!-- informa o nome do formulario -->
<input type="hidden" name="form" value="contact-form"/>

<!-- informa o assunto do e-mail -->
<input type="hidden" name="ignore-subject" value="Formulário de Contato"/>

<!-- Informa a página de agradecimento para onde o usuário será redirecionado após o envio do formulário-->
<input type="hidden" name="ignore-page-redrect" value="agradecimento.html"/>
```

### 2.3. Nome dos campos

O valor usado na propriedade `name` será usado para identificar no corpo do e-mail o que foi preenchido pelo usuário no formulário. 

```html
<input type="email" name="E-mail" />
```

### 2.4. Atributos Adicionais

#### 2.4.1. `ignore-`

Para ignorar um campo inicie o `name` com `ignore-`

```html
<input type="hidden" name="ignore-nome" value="Este campo será ignorado"/>
```