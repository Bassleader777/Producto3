

@section('title', 'Perfil del Hotel')

@section('content')
    <h2>🏨 Perfil del Hotel</h2>
    <p>Desde aquí puedes editar los datos del hotel (usuario, contraseña, etc.).</p>

    <!-- Formulario para editar el perfil del hotel -->
    <form action="{{ route('hotel.updatePerfil') }}" method="POST">
        @csrf
        @method('PUT') {{-- Indica que es una actualización de recurso --}}
        
        <label for="nombre_hotel">Nombre del Hotel:</label>
        <input type="text" id="nombre_hotel" name="nombre_hotel" value="{{ old('nombre_hotel', $hotel->nombre_hotel) }}" required>

        <label for="email_hotel">Correo Electrónico:</label>
        <input type="email" id="email_hotel" name="email_hotel" value="{{ old('email_hotel', $hotel->email_hotel) }}" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">

        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <button type="submit">Actualizar Perfil</button>
    </form>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Volver al panel del hotel --}}
    <p><a href="{{ route('hotel.home') }}">← Volver al Panel del Hotel</a></p>
@endsection
