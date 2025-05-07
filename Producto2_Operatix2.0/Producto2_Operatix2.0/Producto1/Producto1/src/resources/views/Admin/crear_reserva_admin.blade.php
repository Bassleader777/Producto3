<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="formulario-reserva">
    <h2>Crear Nueva Reserva</h2>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reserva.crear') }}" method="POST">
        @csrf

        <label for="id_tipo_reserva">Tipo de Trayecto:</label>
        <select id="id_tipo_reserva" name="id_tipo_reserva" required>
            <option value="1">De Aeropuerto a Hotel</option>
            <option value="2">De Hotel a Aeropuerto</option>
            <option value="3">Ida y Vuelta</option>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" value="{{ old('fecha_entrada') }}" required max="2099-12-31">

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" value="{{ old('hora_entrada') }}" required>

        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" value="{{ old('num_viajeros') }}" required min="1">

        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
                @foreach ($hoteles as $hotel)
                    <option value="{{ $hotel->id_hotel }}">{{ $hotel->nombre }}</option>
                @endforeach

        </select>

        <label for="numero_vuelo_entrada">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo_entrada" name="numero_vuelo_entrada" value="{{ old('numero_vuelo_entrada') }}" required>

        <label for="hora_vuelo_salida">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo_salida" name="hora_vuelo_salida" value="{{ old('hora_vuelo_salida') }}">

        <label for="origen_vuelo_entrada">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo_entrada" name="origen_vuelo_entrada" value="{{ old('origen_vuelo_entrada') }}">

        @php use Illuminate\Support\Facades\Auth; @endphp

        @if (Auth::check())
            <input type="hidden" name="email_cliente" value="{{ Auth::user()->email }}">
        @else
            <p class="alert error">⚠️ No hay correo en la sesión. Por favor vuelve a iniciar sesión.</p>
        @endif

        <input type="hidden" name="id_destino" value="1">
        <input type="hidden" name="fecha_vuelo_salida" value="{{ now()->format('Y-m-d') }}">
        <input type="hidden" name="id_vehiculo" value="1">

        <label for="precio">Precio (€):</label>
        <input type="number" id="precio" name="precio" step="0.01" value="{{ old('precio') }}" required>

        <button type="submit" name="submit">Crear Reserva</button>
    </form>

    <div class="volver-menu">
        <a href="{{ $volver_url }}">← Volver al Panel</a>
    </div>
</div>

</body>
</html>
