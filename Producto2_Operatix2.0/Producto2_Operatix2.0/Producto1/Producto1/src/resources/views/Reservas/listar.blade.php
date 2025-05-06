<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="reservas">
    <h2 class="titulo-reservas">Lista de Reservas</h2>

    @if (!empty($reservas) && is_iterable($reservas))
        @foreach ($reservas as $reserva)
            @if (
                session('tipo_cliente') === 'administrador' ||
                (session('email') && $reserva->email_cliente === session('email'))
            )
                <div class="reserva">
                    <h3>Reserva: {{ $reserva->localizador ?? '' }}</h3>
                    <p><strong>Hotel:</strong> {{ $reserva->id_hotel ?? '' }}</p>
                    <p><strong>Fecha de Reserva:</strong> {{ $reserva->fecha_reserva ?? '' }}</p>
                    <p><strong>Fecha de Modificación:</strong> {{ $reserva->fecha_modificacion ?? '' }}</p>
                    <p><strong>Fecha de Entrada:</strong> {{ $reserva->fecha_entrada ?? '' }} {{ $reserva->hora_entrada ?? '' }}</p>
                    <p><strong>Origen del Vuelo:</strong> {{ $reserva->origen_vuelo_entrada ?? '' }}</p>
                    <p><strong>Fecha de Vuelo de Salida:</strong> {{ $reserva->fecha_vuelo_salida ?? '' }}</p>
                    <p><strong>Hora del Vuelo de Salida:</strong> {{ $reserva->hora_vuelo_salida ?? '' }}</p>
                    <p><strong>Hora de Recogida:</strong> {{ $reserva->hora_recogida ?? 'N/A' }}</p>
                    <p><strong>Número de Viajeros:</strong> {{ $reserva->num_viajeros ?? '' }}</p>
                    <p><strong>Vehículo:</strong> {{ $reserva->id_vehiculo ?? '' }}</p>
                    <p><strong>Número de Vuelo:</strong> {{ $reserva->numero_vuelo_entrada ?? '' }}</p>

                    <div class="reserva-botones">
                        @if (!empty($reserva->cancelable))
                            <a href="{{ route('reserva.eliminar', ['id' => $reserva->id_reserva]) }}">
                                <button>Cancelar Reserva</button>
                            </a>
                            <a href="{{ route('reserva.modificar.form', ['id' => $reserva->id_reserva]) }}">
                                <button>Modificar Reserva</button>
                            </a>
                        @else
                            <button disabled>Cancelar no disponible (menos de 48 horas)</button>
                            <button disabled>Modificar no disponible (menos de 48 horas)</button>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p>No tienes reservas disponibles.</p>
    @endif

    <div class="volver-menu">
        @if (session('tipo_cliente') === 'administrador')
            <a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a>
        @else
            <a href="{{ route('cliente.home') }}">← Volver al Panel del Usuario</a>
        @endif
    </div>
</div>

</body>
</html>

