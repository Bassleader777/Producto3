<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    @if(session('mensaje'))
        <p style="color:green">{{ session('mensaje') }}</p>
    @elseif(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form action="{{ route('admin.hoteles.crear') }}" method="POST">
        @csrf
        <h2>Registrar Nuevo Hotel</h2>

        <label for="id_zona">Zona:</label>
        <select name="id_zona" id="id_zona" required>
            <option value="">Seleccione una zona</option>
            @foreach($zonas as $zona)
                <option value="{{ $zona->id_zona }}">{{ $zona->nombre_zona }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="comision">Comisión (%):</label>
        <input type="text" name="comision" id="comision" required><br><br>

        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Registrar Hotel</button>

        <div class="volver-menu">
            <a href="{{ route('admin.hoteles.index') }}">← Volver a la gestión de hoteles</a>
        </div>
    </form>

</body>
</html>
