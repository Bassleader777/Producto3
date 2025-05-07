


@section('title', 'Iniciar Sesión')

@section('content')
    <h2>Iniciar Sesión</h2>

    <!-- Formulario de inicio de sesión -->
    <form action="{{ route('login') }}" method="POST">
        @csrf {{-- Token CSRF para proteger contra ataques --}}
        
        <!-- Campo para el correo electrónico -->
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <!-- Campo para la contraseña -->
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <!-- Campo para seleccionar el tipo de usuario -->
        <label for="tipo_usuario">Tipo de Usuario:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="cliente" {{ old('tipo_usuario') == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="hotel" {{ old('tipo_usuario') == 'hotel' ? 'selected' : '' }}>Hotel</option>
            <option value="admin" {{ old('tipo_usuario') == 'admin' ? 'selected' : '' }}>Administrador</option>
        </select>

        <!-- Botón para iniciar sesión -->
        <button type="submit">Iniciar sesión</button>
    </form>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <p style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </p>
    @endif

    <!-- Enlace para ir al registro -->
    <p>Aún no tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
@endsection
