<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>

    <h2>Calendario de Reservas</h2>

    <!-- Formularios para seleccionar día, semana o mes -->
    <form action="{{ route('reserva.calendario') }}" method="GET">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $fecha_inicio ?? '') }}" required>

        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $fecha_fin ?? '') }}" required>

        <button type="submit">Ver Reservas</button>
    </form>

    @if(isset($reservas))
        @if(count($reservas) > 0)
            <table border="1">
                <tr>
                    <th>Localizador</th>
                    <th>Fecha de Entrada</th>
                    <th>Hotel</th>
                    <th>Destino</th>
                </tr>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->localizador }}</td>
                        <td>{{ $reserva->fecha_entrada }}</td>
                        <td>{{ $reserva->id_hotel }}</td>
                        <td>{{ $reserva->id_destino }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No se encontraron reservas para el rango seleccionado.</p>
        @endif
    @endif

</body>
</html>
