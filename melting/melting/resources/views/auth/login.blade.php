<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="telcored" />
    <meta name="description" content="CRM Melting Metal SPA" />
    <link rel="icon" href="{{ asset('img/login.png') }}" />

    <title>Login - CRM Melting</title>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animación de fondo */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-header .logo-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: inline-block;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
            margin-bottom: 0;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .form-floating > label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .form-floating.mb-3 {
            margin-bottom: 20px !important;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 4px solid #c53030;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left: 4px solid #166534;
        }

        .login-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
        }

        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            font-size: 13px;
            color: #999;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }

        .divider span {
            background: white;
            padding: 0 10px;
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #667eea;
            font-size: 16px;
            z-index: 10;
        }

        .form-floating-wrapper {
            position: relative;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: #667eea;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                border-radius: 15px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-body {
                padding: 30px 20px;
            }

            .login-footer {
                padding: 15px 20px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="login-card">
                    <!-- Encabezado -->
                    <div class="login-header">
                        <div class="logo-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h1>CRM Melting</h1>
                        <p>Acceso seguro a tu sistema</p>
                    </div>

                    <!-- Cuerpo -->
                    <div class="login-body">
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('authUser') }}" method="post" autocomplete="off">
                            @csrf

                            <!-- recibir email -->
                            <div class="form-floating mb-3">
                                <input 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    placeholder="correo@ejemplo.com"
                                    required
                                    autofocus
                                />
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Correo electrónico
                                </label>
                            </div>

                            <!-- recibir contraseña -->
                            <div class="form-floating mb-3">
                                <input 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    placeholder="Contraseña"
                                    required
                                />
                                <label for="password">
                                    <i class="fas fa-key"></i> Contraseña
                                </label>
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </span>
                            </div>

                            <!-- boton inicio sesion -->
                            <button class="btn btn-login" type="submit">
                                <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                            </button>
                        </form>
                    </div>

                    <!-- pie -->
                    <div class="login-footer">
                        <div>
                            &copy; 2025 <strong>CRM Melting</strong> - Todos los derechos reservados
                        </div>
                        <div style="margin-top: 10px;">
                            Desarrollado por 
                            <a href="https://telcored.cl" target="_blank">
                                <i class="fab fa-github"></i> telcored
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>