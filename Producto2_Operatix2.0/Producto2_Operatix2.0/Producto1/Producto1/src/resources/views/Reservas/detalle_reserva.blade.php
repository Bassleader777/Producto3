<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de la Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <h2>Detalles de la Reserva</h2>

    <table>
        <tr>
            <th>Tipo de Trayecto</th>
            <td>{{ $tipo_reserva ?? '' }}</td>
        </tr>
        <tr>
            <th>Fecha de Entrada</th>
            <td>{{ $fecha_entrada ?? '' }}</td>
        </tr>
        <tr>
            <th>Hora de Entrada</th>
            <td>{{ $hora_entrada ?? '' }}</td>
        </tr>
        <tr>
            <th>Número de Viajeros</th>
            <td>{{ $num_viajeros ?? '' }}</td>
        </tr>
        <tr>
            <th>Hotel de Destino</th>
            <td>{{ $hotel_destino ?? '' }}</td>
        </tr>
        <tr>
            <th>Número de Vuelo</th>
            <td>{{ $numero_vuelo ?? '' }}</td>
        </tr>
        <tr>
            <th>Hora del Vuelo</th>
            <td>{{ $hora_vuelo ?? '' }}</td>
        </tr>
        <tr>
            <th>Origen del Vuelo</th>
            <td>{{ $origen_vuelo ?? '' }}</td>
        </tr>
        <tr>
            <th>Correo del Cliente</th>
            <td>{{ $email_cliente ?? '' }}</td>
        </tr>
    </table>

    <p><strong>Estado de la Reserva:</strong> {{ $estado_reserva ?? 'Pendiente' }}</p>

    @if($is_admin ?? false)
        @if(isset($id_reserva))
            <p>
                <a href="{{ route('admin.reservas.editar', ['id_reserva' => $id_reserva]) }}">Editar Reserva</a> |
                <a href="{{ route('admin.reservas.cancelar', ['id_reserva' => $id_reserva]) }}" 
                   style="color:red;" 
                   onclick="return confirm('¿Estás seguro de cancelar esta reserva?');">
                   Cancelar Reserva
                </a>
            </p>
        @endif
    @endif

    <p><a href="{{ $volver_url }}">← Volver al Panel</a></p>

</body>
</html>
