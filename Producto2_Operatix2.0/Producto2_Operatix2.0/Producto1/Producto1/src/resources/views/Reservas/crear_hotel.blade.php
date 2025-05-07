@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  

    <form action="{{ route('hoteles.store') }}" method="POST">
        @csrf

        <h2>Añadir Nuevo Hotel</h2>
        <label for="id_zona">Zona:</label>
        <select name="id_zona" id="id_zona" required>
            @foreach ($zonas as $zona)
                <option value="{{ $zona->id_zona }}">{{ $zona->nombre_zona }}</option>
            @endforeach
        </select>

        <label for="comision">Comisión:</label>
        <input type="number" id="comision" name="comision" required>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Registrar Hotel</button>
        <p><a href="/admin/hoteles">← Volver a la lista de hoteles</a></p>
    </form>

    

</body>
</html>
