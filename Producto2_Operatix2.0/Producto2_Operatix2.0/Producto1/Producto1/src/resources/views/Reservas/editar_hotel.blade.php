<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<form action="{{ route('hotel.actualizar', ['id_hotel' => $hotel->id_hotel]) }}" method="POST">
    @csrf
    @method('PUT')

    <h2>Editar Hotel</h2>

    <input type="hidden" name="id_hotel" value="{{ old('id_hotel', $hotel->id_hotel) }}">

    <p>
        <label for="id_zona">Zona:</label>
        <select name="id_zona" id="id_zona" required>
            @foreach ($zonas as $zona)
                <option value="{{ $zona['id_zona'] }}"
                    {{ $zona['id_zona'] == $hotel->id_zona ? 'selected' : '' }}>
                    {{ $zona['nombre_zona'] }}
                </option>
            @endforeach
        </select>
    </p>

    <p>
        <label for="comision">Comisión (%):</label>
        <input type="text" name="comision" id="comision"
               value="{{ old('comision', $hotel->Comision) }}" required>
    </p>

    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario"
               value="{{ old('usuario', $hotel->usuario) }}" required>
    </p>

    <p>
        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" name="password" id="password" placeholder="Deja en blanco si no cambia">
    </p>

    <p>
        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
    </p>

    <p>
        <button type="submit">Guardar Cambios</button>
    </p>

    <div class="volver-menu">
        <a href="{{ route('admin.hoteles') }}">← Volver a la gestión de hoteles</a>
    </div>
</form>

</body>
</html>
