<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="login-container">
    <form action="{{ route('cliente.registro') }}" method="POST">
        <h2>Registro de Usuario</h2>
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

            <div>
                <label for="tipo_cliente">Tipo de Cliente:</label>
                <select name="tipo_cliente" id="tipo_cliente" required>
                    <option value="particular" {{ old('tipo_cliente') == 'particular' ? 'selected' : '' }}>Particular</option>
                    <option value="corporativo" {{ old('tipo_cliente') == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
                </select>
            </div>
        </div>

        <button type="submit">Registrarse</button>

        <p class="register-link">
            ¿Ya tienes una cuenta? <a href="{{ route('login.form') }}">Inicia sesión</a>
        </p>
    </form>
</div>

</body>
</html>
