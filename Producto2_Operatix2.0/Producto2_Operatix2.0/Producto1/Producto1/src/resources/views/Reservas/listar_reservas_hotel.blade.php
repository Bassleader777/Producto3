<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas del Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="reservas">
    <h2 class="titulo-reservas">Reservas Asignadas a tu Hotel</h2>

    @if (!empty($reservas) && $reservas->count())
        @foreach ($reservas as $reserva)
            <div class="reserva">
                <h3>Reserva: {{ $reserva->localizador }}</h3>
                <p><strong>Cliente:</strong> {{ $reserva->email_cliente }}</p>
                <p><strong>Fecha de Entrada:</strong> {{ $reserva->fecha_entrada }} {{ $reserva->hora_entrada }}</p>
                <p><strong>Número de Viajeros:</strong> {{ $reserva->num_viajeros }}</p>
                <p><strong>Origen del Vuelo:</strong> {{ $reserva->origen_vuelo_entrada }}</p>
                <p><strong>Hora Vuelo Salida:</strong> {{ $reserva->hora_vuelo_salida ?? 'No especificada' }}</p>
                <p><strong>Fecha de Reserva:</strong> {{ $reserva->fecha_reserva }}</p>
                <p><strong>Precio:</strong> {{ number_format($reserva->precio, 2) }} €</p>
            </div>
        @endforeach
    @else
        <p>No hay reservas asociadas a tu hotel aún.</p>
    @endif

    <div class="volver-menu">
        <a href="{{ route('hotel.home') }}">← Volver al Panel Corporativo</a>
    </div>
</div>

</body>
</html>
