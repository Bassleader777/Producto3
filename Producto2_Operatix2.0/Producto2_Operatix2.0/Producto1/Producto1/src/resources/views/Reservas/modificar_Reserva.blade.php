

@section('title', 'Modificar Reserva')

@section('content')
    <h2>Modificar Reserva</h2>

    <!-- Formulario para modificar reserva -->
    <form action="{{ route('reservas.update', $reserva->id_reserva) }}" method="POST">
        @csrf {{-- Token CSRF para proteger contra ataques --}}
        @method('PUT') {{-- Indica que se trata de una actualización de recurso --}}
        
        <label for="tipo_reserva">Tipo de Trayecto:</label>
        <select id="tipo_reserva" name="tipo_reserva" required>
            <option value="aeropuerto_hotel" {{ $reserva->tipo_reserva == 'aeropuerto_hotel' ? 'selected' : '' }}>De Aeropuerto a Hotel</option>
            <option value="hotel_aeropuerto" {{ $reserva->tipo_reserva == 'hotel_aeropuerto' ? 'selected' : '' }}>De Hotel a Aeropuerto</option>
            <option value="ida_vuelta" {{ $reserva->tipo_reserva == 'ida_vuelta' ? 'selected' : '' }}>Ida y vuelta</option>
        </select>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" value="{{ old('fecha_entrada', $reserva->fecha_entrada) }}" required>

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" value="{{ old('hora_entrada', $reserva->hora_entrada) }}" required>

        <label for="num_viajeros">Número de Viajeros:</label>
        <input type="number" id="num_viajeros" name="num_viajeros" value="{{ old('num_viajeros', $reserva->num_viajeros) }}" required>

        <label for="id_hotel">Hotel de Destino:</label>
        <select id="id_hotel" name="id_hotel" required>
            <option value="1" {{ $reserva->id_hotel == 1 ? 'selected' : '' }}>Hotel Playa</option>
            <option value="2" {{ $reserva->id_hotel == 2 ? 'selected' : '' }}>Hotel Centro</option>
            <option value="3" {{ $reserva->id_hotel == 3 ? 'selected' : '' }}>Hotel Montaña</option>
        </select>

        <label for="numero_vuelo">Número de Vuelo:</label>
        <input type="text" id="numero_vuelo" name="numero_vuelo" value="{{ old('numero_vuelo', $reserva->numero_vuelo) }}">

        <label for="hora_vuelo">Hora del Vuelo:</label>
        <input type="time" id="hora_vuelo" name="hora_vuelo" value="{{ old('hora_vuelo', $reserva->hora_vuelo) }}">

        <label for="origen_vuelo">Origen del Vuelo:</label>
        <input type="text" id="origen_vuelo" name="origen_vuelo" value="{{ old('origen_vuelo', $reserva->origen_vuelo) }}">

        <input type="hidden" name="id_reserva" value="{{ $reserva->id_reserva }}">

        <button type="submit">Modificar Reserva</button>
    </form>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <p style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </p>
    @endif

    {{-- Volver según tipo de cliente --}}
    @if (session('tipo_cliente') === 'administrador')
        <p><a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a></p>
    @else
        <p><a href="{{ route('cliente.home') }}">← Volver al Menú del Cliente</a></p>
    @endif
@endsection
