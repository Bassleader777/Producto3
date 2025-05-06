<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="editar-usuario-container">
    <h2>Editar Usuario</h2>

    {{-- Mensajes de éxito o error --}}
    @if (session('mensaje'))
        <div class="alert-success">✅ {{ session('mensaje') }}</div>
    @elseif (session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.actualizar', ['id' => $usuario->id_viajero]) }}" method="POST" id="editarUsuarioForm">
        @csrf

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required>

        <label for="password">Nueva contraseña (opcional):</label>
        <input type="password" name="password" id="password">

        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation">

        <button type="submit">Guardar Cambios</button>
    </form>

    <div class="volver-menu">
        <a href="{{ route('admin.usuarios') }}">← Volver a la gestión de usuarios</a>
    </div>
</div>

<script>
    document.getElementById("editarUsuarioForm").addEventListener("submit", function(e) {
        const pass = document.getElementById("password").value;
        const confirm = document.getElementById("password_confirmation").value;

        if (pass && pass !== confirm) {
            alert("⚠️ Las contraseñas no coinciden.");
            e.preventDefault();
        }
    });
</script>

</body>
</html>
