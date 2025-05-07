<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            background-color: #e9fbe6;
            font-family: Arial, sans-serif;
        }
        .contenedor {
            max-width: 900px;
            margin: 40px auto;
            background: #f9fff7;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 30px;
        }
        .reserva {
            border: 1px solid #c9e2c2;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #ffffff;
        }
        .reserva p {
            margin: 5px 0;
        }
        .reserva h3 {
            color: #388e3c;
        }
        .reserva-botones {
            margin-top: 10px;
        }
        .reserva-botones button {
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            background-color: #66bb6a;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .reserva-botones button:disabled {
            background-color: #c8e6c9;
            color: #555;
            cursor: not-allowed;
        }
        .volver-menu {
            text-align: center;
            margin-top: 30px;
        }
        .volver-menu a {
            color: #2e7d32;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Lista de Reservas</h2>

    @if (!empty($reservas) && is_iterable($reservas))
        @foreach ($reservas as $reserva)
            <div class="reserva">
                <h3>Reserva: {{ $reserva->localizador ?? '---' }}</h3>
                <p><strong>Hotel:</strong> {{ $reserva->id_hotel ?? '---' }}</p>
                <p><strong>Fecha de Entrada:</strong> {{ $reserva->fecha_entrada ?? '' }} {{ $reserva->hora_entrada ?? '' }}</p>
                <p><strong>Origen del Vuelo:</strong> {{ $reserva->origen_vuelo_entrada ?? '' }}</p>
                <p><strong>Vuelo Salida:</strong> {{ $reserva->fecha_vuelo_salida ?? '' }} {{ $reserva->hora_vuelo_salida ?? '' }}</p>
                <p><strong>Vuelo Entrada:</strong> {{ $reserva->numero_vuelo_entrada ?? '' }}</p>
                <p><strong>Viajeros:</strong> {{ $reserva->num_viajeros ?? 1 }}</p>
                <p><strong>Vehículo:</strong> {{ $reserva->id_vehiculo ?? '---' }}</p>
                <p><strong>Modificada:</strong> {{ $reserva->fecha_modificacion ?? '' }}</p>

                <div class="reserva-botones">
                    @if (!empty($reserva->cancelable))
                        <a href="{{ route('reserva.eliminar', ['id' => $reserva->id_reserva]) }}">
                            <button>Cancelar Reserva</button>
                        </a>
                        <a href="{{ route('reserva.modificar.form', ['id' => $reserva->id_reserva]) }}">
                            <button>Modificar Reserva</button>
                        </a>
                    @else
                        <button disabled>Cancelar no disponible</button>
                        <button disabled>Modificar no disponible</button>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>No hay reservas disponibles.</p>
    @endif

    <div class="volver-menu">
        @php $tipo = session('tipo_cliente') ?? (Auth::check() ? Auth::user()->tipo_cliente : 'cliente'); @endphp
        @if ($tipo === 'administrador')
            <a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a>
        @else
            <a href="{{ route('cliente.home') }}">← Volver al Panel del Usuario</a>
        @endif
    </div>
</div>

</body>
</html>
