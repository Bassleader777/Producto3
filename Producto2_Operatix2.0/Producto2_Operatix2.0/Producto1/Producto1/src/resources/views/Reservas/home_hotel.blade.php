
@section('title', 'Panel del Hotel')

@section('content')
    <h2>Bienvenido al Panel del Hotel</h2>
    <p>Desde este panel, puedes gestionar las reservas de los clientes y ver la información relevante de tu hotel.</p>

    <div class="menu">
        <ul>
            <li><a href="{{ url('/hotel/reservas') }}">Ver Reservas</a></li>
            <li><a href="{{ url('/hotel/crear_reserva') }}">Realizar Nueva Reserva</a></li>
            <li><a href="{{ url('/hotel/perfil') }}">Editar Perfil del Hotel</a></li>
        </ul>
    </div>

    <p><a href="{{ url('/cliente/logout') }}">Cerrar sesión</a></p>

    <h3>Resumen de comisiones mensuales</h3>
    <ul>
        @if (!empty($comisionesPorMes))
            @foreach ($comisionesPorMes as $mes => $importe)
                <li>{{ $mes }}: {{ number_format($importe, 2) }} €</li>
            @endforeach
        @else
            <li>No tienes comisiones registradas aún.</li>
        @endif
    </ul>
@endsection
