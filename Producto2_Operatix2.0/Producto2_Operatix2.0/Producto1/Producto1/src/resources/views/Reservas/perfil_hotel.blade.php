<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <!-- Formulario para editar el perfil del hotel -->
    <form action="{{ route('hotel.updatePerfil') }}" method="POST">
        <h2>🏨 Perfil del Hotel</h2>
        <p>Desde aquí puedes editar los datos del hotel (usuario, contraseña, etc.).</p>
        @csrf
        @method('PUT')

        <label for="nombre_hotel">Nombre del Hotel:</label>
        <input type="text" id="nombre_hotel" name="nombre_hotel" value="{{ old('nombre_hotel', $hotel->nombre_hotel) }}" required>

        <label for="email_hotel">Correo Electrónico:</label>
        <input type="email" id="email_hotel" name="email_hotel" value="{{ old('email_hotel', $hotel->email_hotel) }}" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">

        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <button type="submit">Actualizar Perfil</button>
        <p><a href="{{ route('hotel.home') }}">← Volver al Panel del Hotel</a></p>
    </form>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    

</body>
</html>
