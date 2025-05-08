<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Comisiones</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="panel-container">
        <h2>💼 Resumen de Comisiones por Hotel</h2>

        <form method="GET" action="{{ route('admin.comisiones.resumen') }}">
            <label for="mes">Mes:</label>
            <select name="mes" id="mes">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}" {{ $mes == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endfor
            </select>

            <label for="anio">Año:</label>
            <input type="number" name="anio" id="anio" value="{{ $anio }}" min="2020" max="{{ date('Y') }}">

            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Total Reservas</th>
                    <th>Comisión por Reserva</th>
                    <th>Total Comisión</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservas as $r)
                    <tr>
                        <td>{{ $r->nombre_hotel }}</td>
                        <td>{{ $r->total_reservas }}</td>
                        <td>{{ number_format($r->comision_unitaria, 2) }} €</td>
                        <td><strong>{{ number_format($r->total_comision, 2) }} €</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No hay datos para el periodo seleccionado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="volver-menu">
            <a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a>
        </div>
    </div>
</body>
</html>
