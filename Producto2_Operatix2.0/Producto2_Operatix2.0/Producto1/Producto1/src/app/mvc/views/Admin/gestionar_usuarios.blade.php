<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="usuarios-container">
    <h1 class="titulo-usuarios">Gestión de Usuarios</h1>
    <p class="subtexto">Aquí el administrador podrá ver, modificar o eliminar usuarios del sistema.</p>

    {{-- Mensajes de éxito o error --}}
    @if (session('mensaje'))
        <div class="alert-success">✅ {{ session('mensaje') }}</div>
    @elseif (session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    <table class="tabla-estilizada">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_viajero }}</td>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <a href="{{ route('admin.usuarios.editar', ['id' => $usuario->id_viajero]) }}">Editar</a>
                    {{-- Eliminar aún no está implementado, solo enlace visual --}}
                    {{-- <a href="{{ route('admin.usuarios.eliminar', ['id' => $usuario->id_viajero]) }}"
                       onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a> --}}
                </td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align: center;">No hay usuarios registrados.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="volver-menu">
        <a href="{{ route('admin.home') }}">&larr; Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
