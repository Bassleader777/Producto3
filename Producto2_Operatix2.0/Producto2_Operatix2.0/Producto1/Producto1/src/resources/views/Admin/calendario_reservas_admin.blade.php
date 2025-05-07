@php
    use Illuminate\Support\Facades\Auth;

    $volverUrl = Auth::check() && Auth::user()->tipo_cliente === 'administrador'
        ? route('admin.home')
        : route('cliente.home');

    // Navegación de mes actual
    $monthName = ucfirst(\Carbon\Carbon::create()->month($month)->locale('es')->monthName);

    // Cálculos de mes anterior y siguiente
    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;
    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;

    $daysInMonth = date('t', strtotime("$year-$month-01"));
    $firstDayOfWeek = date('N', strtotime("$year-$month-01"));
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Reservas</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="calendario-container">
    <h2 class="titulo-calendario">📅 Calendario de Reservas - {{ $monthName }} {{ $year }}</h2>

    <div class="calendario-navegacion" style="margin-bottom: 15px;">
        <a href="{{ route('admin.reservas.calendario', ['year' => $prevYear, 'month' => $prevMonth]) }}">← Mes anterior</a> |
        <a href="{{ route('admin.reservas.calendario', ['year' => $nextYear, 'month' => $nextMonth]) }}">Mes siguiente →</a>
    </div>

    <p>Como administrador, puedes ver las reservas de los usuarios en el calendario.</p>

    <table class="tabla-calendario">
        <thead>
            <tr>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mié</th>
                <th>Jue</th>
                <th>Vie</th>
                <th>Sáb</th>
                <th>Dom</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php $cellCount = 1; @endphp

                {{-- Celdas vacías antes del 1er día --}}
                @for ($i = 1; $i < $firstDayOfWeek; $i++, $cellCount++)
                    <td></td>
                @endfor

                {{-- Días del mes --}}
                @for ($day = 1; $day <= $daysInMonth; $day++, $cellCount++)
                    @php
                        $fecha = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $reservaCount = $reservasPorDia[$fecha] ?? 0;
                        $class = $reservaCount > 0 ? 'reserva' : '';
                        $label = $reservaCount > 0 ? "$day ($reservaCount)" : $day;
                    @endphp
                    <td class="{{ $class }}">{{ $label }}</td>

                    @if ($cellCount % 7 === 0)
                        </tr><tr>
                    @endif
                @endfor

                {{-- Celdas vacías para completar fila final --}}
                @while ($cellCount % 7 !== 1)
                    <td></td>
                    @php $cellCount++ @endphp
                @endwhile
            </tr>
        </tbody>
    </table>

    <div class="volver-menu" style="margin-top: 20px;">
        <a href="{{ $volverUrl }}">&larr; Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
