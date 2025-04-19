<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Novo Contato do Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h1 {
            color: #4f46e5;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .contact-info {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #4f46e5;
        }
        .field-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        .message-content {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            white-space: pre-line;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Novo Contato via Site</h1>
        
        <div class="contact-info">
            <p><span class="field-label">Nome:</span> {{ $data['name'] }}</p>
            <p><span class="field-label">Email:</span> {{ $data['email'] }}</p>
            <p><span class="field-label">Data do Envio:</span> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
        
        <p><span class="field-label">Mensagem:</span></p>
        <div class="message-content">
            {{ $data['message'] }}
        </div>
        
        <div class="footer">
            <p>Este e-mail foi enviado automaticamente pelo formulário de contato do site Impacto Visual.</p>
        </div>
    </div>
</body>
</html> 