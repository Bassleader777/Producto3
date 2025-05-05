<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="login-container">

        {{-- Mensajes de error generales --}}
        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        {{-- Error de autenticación --}}
        @if($errors->has('login_error'))
            <p class="error">{{ $errors->first('login_error') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST">
            <h1>Iniciar sesión</h1>
            @csrf

            <label for="email">Correo:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Ingresar</button>

            <p class="register-link">
                ¿No tienes cuenta? <a href="{{ route('cliente.registro.form') }}">Regístrate aquí</a>
            </p>
        </form>
    </div>
</body>
</html>
