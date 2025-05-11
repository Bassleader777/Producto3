<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Corporativo</title>
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
</head>
<body>
<h1 class="titulo-secundario">Isla Transfers</h1>

<div class="panel-container"> {{-- Usa el mismo estilo que home_cliente --}}
    <h2>Bienvenido al Panel Corporativo</h2>
    <p>Desde este panel, puedes gestionar las reservas de los clientes y ver la información relevante de tu hotel.</p>

    <ul class="panel-links">
        <li><a href="{{ route('hotel.reservas') }}">📋 Ver Reservas</a></li>
        <li><a href="{{ route('hotel.reserva.form') }}">➕ Realizar Nueva Reserva</a></li>
        <li><a href="{{ route('hotel.perfil') }}">👤 Editar Perfil del Hotel</a></li>
        <li><a href="{{ route('cliente.logout') }}">🚪 Cerrar sesión</a></li>
    </ul>


    <h3>Resumen de comisiones mensuales</h3>
    <ul>
        @if (!empty($comisionesPorMes))
            @foreach ($comisionesPorMes as $mes => $importe)
                <li>{{ $mes }}: {{ number_format($importe, 2) }} €</li>
            @endforeach
        @else
            <li>No tienes comisiones registradas aún.</li>
        @endif
    </ul>
</div>

</body>
</html>