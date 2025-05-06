{{-- resources/views/Reservas/home_cliente.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="panel-container">
    <h2>Bienvenido al Panel de Cliente</h2>

    @php
        $tipo = Auth::user()->tipo_cliente ?? 'particular';
    @endphp

    @if ($tipo === 'corporativo')
        <p><strong>Acceso corporativo:</strong> Estás identificado como un cliente corporativo. Disfruta de nuestros servicios especiales.</p>
    @else
        <p>Desde este panel, puedes gestionar tus reservas, editar tu perfil y más.</p>
    @endif

    <ul class="panel-links">
    <li><a href="{{ route('reserva.listar') }}">📋 Mis Reservas</a></li>
    <li><a href="{{ route('reserva.crear.form') }}">✈️ Crear Nueva Reserva</a></li>
    <li><a href="{{ route('cliente.perfil') }}">👤 Editar Perfil</a></li>
    <li><a href="{{ route('cliente.logout') }}">🚪 Cerrar sesión</a></li>
    </ul>
    @yield('content')  <!-- 👈 Añade esto -->
</div>

</body>
</html>
