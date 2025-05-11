<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vehiculo;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function listarReservas()
    {
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión.');
        }
    
        $usuario = Auth::user();
    
        if ($usuario->tipo_cliente === 'administrador') {
            // El administrador ve todas las reservas
            $reservas = Reserva::all();
        } else {
            // El cliente solo ve sus reservas
            $reservas = Reserva::where('email_cliente', $usuario->email)->get();
        }
    
        return view('reservas.listar', compact('reservas'));
    }
    public function formCrear()
{
    $hoteles = Hotel::all();
    $vehiculos = Vehiculo::all();

    $tipo_cliente = Auth::check() ? Auth::user()->tipo_cliente : 'cliente';
    $volver_url = $tipo_cliente === 'administrador'
        ? route('admin.home')
        : route('cliente.home');

    $email = Auth::check() ? Auth::user()->email : null;

    return view('Reservas.crear_reserva_cliente', compact('hoteles', 'vehiculos', 'volver_url', 'email', 'tipo_cliente'));
}


    public function crearReserva(Request $request)
    {
        $usuario = Auth::user();
        $esCorporativo = $usuario && $usuario->tipo_cliente === 'corporativo';

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
            $reglas['id_hotel'] = 'required|integer';
            $reglas['numero_vuelo_entrada'] = 'required|string|max:50';
            $reglas['origen_vuelo_entrada'] = 'required|string|max:50';
            $reglas['hora_vuelo_salida'] = 'nullable|date_format:H:i';
        }
        
        $validated = $request->validate($reglas);
        

        try {
            $localizador = strtoupper(bin2hex(random_bytes(4)));
            $idDestino = $request->id_destino ?? $request->id_hotel;
            $idVehiculo = $request->id_vehiculo ?? null;
            $email = Auth::check() ? Auth::user()->email : null;

            if (!$email) {
                return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para crear una reserva.');
            }

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
           

            if (Auth::check() && Auth::user()->tipo_cliente === 'administrador') {
                return redirect()->route('admin.reservas.listar')->with('success', 'Reserva creada con éxito.');
            } else {
                return redirect()->route('reserva.listar')->with('success', 'Reserva creada con éxito.');
            }            
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la reserva: ' . $e->getMessage());
        }
    }

    public function verReserva($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);
        return $reserva
            ? view('reservas.detalle', compact('reserva'))
            : redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
    }

    public function modificarReserva(Request $request, $id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (!$reserva) {
            return redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
        }

        $request->validate([
            'fecha_entrada' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'num_viajeros' => 'required|integer|min:1',
        ]);

        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->hora_entrada = $request->hora_entrada;
        $reserva->num_viajeros = $request->num_viajeros;
        $reserva->fecha_modificacion = now();
        $reserva->save();

        return redirect()->route('reserva.listar')->with('success', 'Reserva modificada con éxito.');
    }

    public function eliminarReserva($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if ($reserva) {
            $reserva->delete();
            return redirect()->route('reserva.listar')->with('success', 'Reserva eliminada con éxito.');
        } else {
            return redirect()->route('reserva.listar')->with('error', 'Reserva no encontrada.');
        }
    }

    public function obtenerReservasPorFecha($fecha_inicio, $fecha_fin)
    {
        return Reserva::whereBetween('fecha_entrada', [$fecha_inicio, $fecha_fin])->get();
    }

    public function obtenerUltimasReservas($limite = 5)
    {
        return Reserva::orderBy('id_reserva', 'desc')->take($limite)->get();
    }

    public function contarTotalReservas()
    {
        return Reserva::count();
    }

    public function obtenerReservasPorDia($dias = 7)
    {
        return Reserva::selectRaw('DATE(fecha_reserva) as fecha, COUNT(*) as total')
            ->where('fecha_reserva', '>=', now()->subDays($dias))
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function obtenerZonaMasReservada()
    {
        $zona = DB::table('transfer_reservas')
            ->join('transfer_zona', 'transfer_reservas.id_destino', '=', 'transfer_zona.id_zona')
            ->select('transfer_zona.nombre_zona', DB::raw('count(*) as total'))
            ->groupBy('transfer_zona.nombre_zona')
            ->orderByDesc('total')
            ->limit(1)
            ->first();

        return $zona ?: ['nombre_zona' => 'N/D', 'total' => 0];
    }


    public function mostrarCalendario(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $reservas = [];
    
        if ($fecha_inicio && $fecha_fin) {
            $usuario = Auth::user();
    
            $reservas = Reserva::where('email_cliente', $usuario->email)
                ->whereBetween('fecha_entrada', [$fecha_inicio, $fecha_fin])
                ->get();
        }
    
        return view('Reservas.calendario_reservas', [
            'reservas' => $reservas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
        ]);
    }

}
