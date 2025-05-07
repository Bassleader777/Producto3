<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="login-container">
    <form action="{{ route('reserva.crear') }}" method="POST">
        <h2>Crear nueva Reserva</h2>
        @csrf

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <div class="form-grid">
            <div>
                <label for="id_hotel">Hotel id:</label>
                <input type="number" id="id_hotel" name="id_hotel" value="{{ old('id_hotel') }}" required>
            </div>

            <div>
                <label for="id_tipo_reserva">Tipo de reserva:</label>
                <input type="number" id="id_tipo_reserva" name="id_tipo_reserva" value="{{ old('id_tipo_reserva') }}" required>
            </div>

            <div>
                <label for="email_cliente">Correo electrónico:</label>
                <input type="email" id="email_cliente" name="email_cliente" value="{{ old('email_cliente') }}">
            </div>

            <div>
                <label for="fecha_entrada">Fecha de ingreso:</label>
                <input type="date" id="fecha_entrada" name="fecha_entrada" value="{{ old('fecha_entrada') }}" required>
            </div>

            <div>
                <label for="hora_entrada">Hora de ingreso:</label>
                <input type="datetime-local" id="hora_entrada" name="hora_entrada" value="{{ old('hora_entrada') }}" >
            </div>

            <div>
                <label for="num_viajeros">Cantidad de viajeros:</label>
                <input type="text" id="num_viajeros" name="num_viajeros" value="{{ old('num_viajeros') }}" required>
            </div>

            <div>
                <label for="numero_vuelo_entrada">Número de vuelo:</label>
                <input type="text" id="numero_vuelo_entrada" name="numero_vuelo_entrada" value="{{ old('numero_vuelo_entrada') }}" required>
            </div>

        </div>

        <button type="submit">Reservar</button>
    </form>
    <div class="volver-menu">
        <a href="{{ route('cliente.home') }}">← Volver al panel</a>
    </div>
</div>

</body>
</html>
