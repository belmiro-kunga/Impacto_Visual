<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Impacto Visual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0a0f1c;
            --secondary-color: #4f46e5;
            --accent-color: #06b6d4;
            --text-color: #ffffff;
            --text-secondary: #94a3b8;
            --dark-color: #111827;
            --light-color: #f3f4f6;
            --card-border-radius: 1.25rem;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        
        .login-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .login-image {
            width: 50%;
            background-image: url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&q=80&w=1000');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 15, 28, 0.7), rgba(79, 70, 229, 0.7));
        }
        
        .login-image-content {
            position: relative;
            color: white;
            text-align: center;
            z-index: 1;
        }
        
        .login-image-content img {
            max-width: 120px;
            margin-bottom: 1.5rem;
        }
        
        .login-image-content h2 {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .login-image-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .login-form {
            width: 50%;
            background-color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-form h2 {
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .login-form p {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-primary:hover {
            background-color: #4338CA;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .login-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: #4338CA;
            text-decoration: underline;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }
            
            .login-image, .login-form {
                width: 100%;
            }
            
            .login-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="login-image-content">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiByeD0iOCIgZmlsbD0iIzBhMGYxYyIvPgo8cGF0aCBkPSJNMjkuNSA3MC41TDQ5LjUgMzBMNjkuNSA3MC41SDI5LjVaIiBzdHJva2U9IiM0ZjQ2ZTUiIHN0cm9rZS13aWR0aD0iMyIvPgo8Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSIyNSIgc3Ryb2tlPSIjMDZiNmQ0IiBzdHJva2Utd2lkdGg9IjMiLz4KPC9zdmc+Cg==" alt="Logo Impacto Visual">
                <h2>Impacto Visual</h2>
                <p>Painel de administração para gerenciar seu site, projetos e clientes.</p>
            </div>
        </div>
        <div class="login-form">
            <h2>Bem-vindo de volta!</h2>
            <p>Entre com seus dados para acessar o painel administrativo</p>
            
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html> 