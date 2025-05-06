@php
    use Illuminate\Support\Facades\Auth;

    $volverUrl = Auth::check() && Auth::user()->tipo_cliente === 'administrador'
        ? route('admin.home')
        : route('cliente.home');

    $reservasPorDia = [
        '2025-04-01' => 1,
        '2025-04-05' => 2,
        '2025-04-10' => 3,
        '2025-04-15' => 1,
        '2025-04-20' => 2,
        '2025-04-22' => 1,
        '2025-04-30' => 2,
    ];

    $year = 2025;
    $month = 4;
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
    <h2 class="titulo-calendario">📅 Calendario de Reservas - Abril {{ $year }}</h2>
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
                @php
                    $cellCount = 1;
                @endphp

                {{-- Celdas vacías hasta el primer día del mes --}}
                @for ($i = 1; $i < $firstDayOfWeek; $i++, $cellCount++)
                    <td></td>
                @endfor

                {{-- Días del mes con reservas --}}
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

                {{-- Completar última fila si quedan celdas vacías --}}
                @while ($cellCount % 7 !== 1)
                    <td></td>
                    @php $cellCount++ @endphp
                @endwhile
            </tr>
        </tbody>
    </table>

    <div class="volver-menu">
        <a href="{{ $volverUrl }}">&larr; Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
