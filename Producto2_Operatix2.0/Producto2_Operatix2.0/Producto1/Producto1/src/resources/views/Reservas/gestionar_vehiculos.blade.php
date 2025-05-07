
@section('title', 'Gestión de Vehículos')

@section('content')
<div class="gestion-vehiculos-container">
    <h2>Gestión de Vehículos</h2>

    <p><a href="{{ url('/admin/vehiculos/crear') }}">+ Añadir nuevo vehículo</a></p>

    <table>
        <thead>
            <tr>
                <th>ID Vehículo</th>
                <th>Descripción</th>
                <th>Email Conductor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($vehiculos) && count($vehiculos) > 0)
                @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->id_vehiculo ?? 'No disponible' }}</td>
                        <td>{{ $vehiculo->description ?? 'No disponible' }}</td>
                        <td>{{ $vehiculo->email_conductor ?? 'No disponible' }}</td>
                        <td>
                            <a href="{{ url('/admin/vehiculos/editar?id=' . urlencode($vehiculo->id_vehiculo)) }}">Editar</a> |
                            <a href="{{ url('/admin/vehiculos/eliminar?id=' . urlencode($vehiculo->id_vehiculo)) }}"
                               onclick="return confirm('¿Deseas eliminar este vehículo?')">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="4">No hay vehículos registrados.</td></tr>
            @endif
        </tbody>
    </table>

    <div class="volver-panel">
        <a href="{{ url('/admin/home') }}">← Volver al Panel de Administración</a>
    </div>
</div>
@endsection
