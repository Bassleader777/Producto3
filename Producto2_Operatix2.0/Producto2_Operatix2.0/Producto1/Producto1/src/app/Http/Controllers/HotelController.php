<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Zona; 
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    // Listar todos los hoteles
    public function listarHoteles()
    {
        // Usamos Eloquent para obtener todos los hoteles
        $hoteles = Hotel::all();
        return view('admin.gestionar_hoteles', compact('hoteles'));
    }

    // Ver detalles de un hotel específico
    public function verHotel($id_hotel)
    {
        // Usamos Eloquent para buscar el hotel por su ID
        $hotel = Hotel::find($id_hotel);

        if (!$hotel) {
            return redirect()->route('admin.hoteles')->with('error', '❌ Hotel no encontrado.');
        }

        return view('admin.ver_hotel', compact('hotel'));
    }

    // Registrar un nuevo hotel
    public function registrarHotel(Request $request)
    {
        // Validación de datos del formulario
        $request->validate([
            'id_zona' => 'required|integer',
            'comision' => 'required|numeric',
            'usuario' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);

        try {
            // Crear un nuevo hotel usando el modelo Hotel de Laravel
            $hotel = new Hotel();
            $hotel->id_zona = $request->id_zona;
            $hotel->Comision = $request->comision;
            $hotel->usuario = $request->usuario;
            $hotel->password = Hash::make($request->password); // Usamos Laravel para hacer el hash de la contraseña
            $hotel->save();

            return redirect()->route('admin.hoteles')->with('success', 'Hotel registrado con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar el hotel: ' . $e->getMessage());
        }
    }

    // Actualizar un hotel existente
    public function actualizarHotel(Request $request, $id_hotel)
    {
        // Usamos Eloquent para obtener el hotel
        $hotel = Hotel::find($id_hotel);

        if (!$hotel) {
            return redirect()->route('admin.hoteles')->with('error', '❌ Hotel no encontrado.');
        }

        // Validación de datos del formulario
        $request->validate([
            'id_zona' => 'required|integer',
            'comision' => 'required|numeric',
            'usuario' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $hotel->id_zona = $request->id_zona;
        $hotel->Comision = $request->comision;
        $hotel->usuario = $request->usuario;

        // Si se proporciona una nueva contraseña, la actualizamos
        if ($request->filled('password')) {
            $hotel->password = Hash::make($request->password);
        }

        $hotel->save();

        return redirect()->route('admin.hoteles')->with('success', 'Hotel actualizado con éxito.');
    }

    // Obtener las zonas disponibles
    public function obtenerZonas()
    {
        // Usamos Eloquent para obtener las zonas
        $zonas = Zona::all();
        return $zonas;
    }

    // Obtener los últimos hoteles (limite)
    public function obtenerUltimosHoteles($limite = 5)
    {
        // Usamos Eloquent para obtener los últimos hoteles
        $hoteles = Hotel::with('zona')->orderBy('id_hotel', 'desc')->take($limite)->get();
        return $hoteles;
    }

    // Contar el total de hoteles
    public function contarTotalHoteles()
    {
        // Usamos Eloquent para contar el total de hoteles
        return Hotel::count();
    }

    // Eliminar un hotel
    public function eliminarHotel($id_hotel)
    {
        // Usamos Eloquent para encontrar el hotel y eliminarlo
        $hotel = Hotel::find($id_hotel);
        if ($hotel) {
            $hotel->delete();
            return redirect()->route('admin.hoteles')->with('success', 'Hotel eliminado correctamente.');
        } else {
            return redirect()->route('admin.hoteles')->with('error', '❌ No se encontró el hotel.');
        }
    }

    public function formEditar(Request $request)
    {
    $id_hotel = $request->query('id');

    $hotel = Hotel::find($id_hotel);

    if (!$hotel) {
        return redirect()->route('admin.hoteles')->with('error', '❌ Hotel no encontrado.');
    }

    // Ahora usamos el modelo Zona correctamente
    $zonas = Zona::all();

    return view('Reservas.editar_hotel', compact('hotel', 'zonas'));
    }
    


    public function crearHotel()
    {
    // Obtener las zonas para mostrarlas en el formulario
    $zonas = Zona::all();
    
    // Devolver la vista con las zonas
    return view('Reservas.crear_hotel', compact('zonas'));
    }


    public function listarReservas()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
    
        // Obtener las reservas solo asociadas al usuario autenticado por su email
        $reservas = \App\Models\Reserva::where('email_cliente', $usuario->email)->get();
    
        // Pasar las reservas a la vista
        return view('Reservas.listar_reservas_hotel', compact('reservas'));
    }
    
    

// Mostrar formulario para crear reserva (solo vista)
    public function formCrearReserva()
    {
    $hoteles = Hotel::all();
    return view('Reservas.crear_reserva_hotel', compact('hoteles'));
    }

    public function procesarReserva(Request $request)
    {
    // Obtén al usuario autenticado
    $usuario = Auth::user();
    $esCorporativo = $usuario && $usuario->tipo_cliente === 'corporativo';

    // Reglas de validación específicas
    $reglas = [
        'id_tipo_reserva' => 'required|integer',
        'fecha_entrada' => 'required|date',
        'hora_entrada' => 'nullable|date_format:H:i',
        'num_viajeros' => 'required|integer|min:1',
        'precio' => 'required|numeric|min:0',
        'email_cliente' => 'required|email',
        'id_destino' => 'required|integer',
        'fecha_vuelo_salida' => 'required|date',
        'id_vehiculo' => 'nullable|integer',
    ];

    if ($esCorporativo) {
        // Para clientes corporativos, se añaden reglas adicionales
        $reglas['id_hotel'] = 'required|integer';
        $reglas['numero_vuelo_entrada'] = 'required|string|max:50';
        $reglas['origen_vuelo_entrada'] = 'required|string|max:50';
        $reglas['hora_vuelo_salida'] = 'nullable|date_format:H:i';
    }

    // Validar los datos del formulario
    $validated = $request->validate($reglas);

    try {
        // Generar un localizador único
        $localizador = strtoupper(bin2hex(random_bytes(4)));
        $idDestino = $request->id_destino ?? $request->id_hotel;
        $idVehiculo = $request->id_vehiculo ?? null;
        $email = Auth::check() ? Auth::user()->email : null;

        // Si el usuario no está autenticado, redirigir al login
        if (!$email) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para crear una reserva.');
        }

        // Crear la reserva en la base de datos
        $reserva = new Reserva([
            'localizador' => strtoupper(bin2hex(random_bytes(4))),
            'id_hotel' => $validated['id_hotel'] ?? null,
            'id_tipo_reserva' => $validated['id_tipo_reserva'],
            'email_cliente' => $validated['email_cliente'],
            'fecha_entrada' => $validated['fecha_entrada'],
            'hora_entrada' => $validated['hora_entrada'],
            'numero_vuelo_entrada' => $validated['numero_vuelo_entrada'] ?? null,
            'origen_vuelo_entrada' => $validated['origen_vuelo_entrada'] ?? null,
            'fecha_vuelo_salida' => $validated['fecha_vuelo_salida'],
            'hora_vuelo_salida' => $validated['hora_vuelo_salida'] ?? null,
            'num_viajeros' => $validated['num_viajeros'],
            'id_destino' => $validated['id_destino'],
            'id_vehiculo' => $validated['id_vehiculo'] ?? null,
            'precio' => $validated['precio'],
            'fecha_reserva' => now(),
            'fecha_modificacion' => now(),
        ]);

        $reserva->save();

        // Redirigir según el tipo de usuario
        if (Auth::check() && Auth::user()->tipo_cliente === 'administrador') {
            return redirect()->route('admin.reservas.listar')->with('success', 'Reserva creada con éxito.');
        } else {
            return redirect()->route('hotel.reservas')->with('success', 'Reserva creada con éxito.');
        }
        
    } catch (\Exception $e) {
        // Manejar errores
        return back()->with('error', 'Error al crear la reserva: ' . $e->getMessage());
    }
    }
    public function editarPerfil()
    {
    $hotel = Auth::user(); // Ya que el usuario autenticado es el hotel
    return view('Reservas.perfil_hotel', compact('hotel'));

    }

}
