<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
        }

        .form-grid > div {
            display: flex;
            flex-direction: column;
        }

        .form-actions {
            grid-column: span 2;
            text-align: center;
            margin-top: 20px;
        }

        .error ul {
            list-style: none;
            padding: 0;
        }

        .login-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: #e6f8e6;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        input, label {
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <form action="{{ route('cliente.registro') }}" method="POST">
        <h2 style="text-align: center;">Registro de Usuario</h2>
        @csrf

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <div class="form-grid">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div>
                <label for="apellido1">Primer Apellido:</label>
                <input type="text" id="apellido1" name="apellido1" value="{{ old('apellido1') }}" required>
            </div>

            <div>
                <label for="apellido2">Segundo Apellido:</label>
                <input type="text" id="apellido2" name="apellido2" value="{{ old('apellido2') }}">
            </div>

            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
            </div>

            <div>
                <label for="codigoPostal">Código Postal:</label>
                <input type="text" id="codigoPostal" name="codigoPostal" value="{{ old('codigoPostal') }}" required>
            </div>

            <div>
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required>
            </div>

            <div>
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="{{ old('pais') }}" required>
            </div>

            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirmar contraseña:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit">Registrarse</button>
            </div>
        </div>

        <p class="register-link">
            ¿Ya tienes una cuenta? <a href="{{ route('login.form') }}">Inicia sesión</a>
        </p>
    </form>
</div>

</body>
</html>
