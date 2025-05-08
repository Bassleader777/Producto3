<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Hotel;
use App\Models\Reserva;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Mostrar listado de todos los usuarios
    public function obtenerTodosLosUsuarios()
    {
        $usuarios = Cliente::all();
        return view('Admin.gestionar_usuarios', compact('usuarios'));
    }

    // Mostrar formulario para editar un usuario
    public function editarUsuario($id)
    {
        $usuario = Cliente::find($id);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        return view('Admin.editar_usuario', compact('usuario'));
    }

    // Actualizar datos del usuario
    public function actualizarUsuario(Request $request, $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:transfer_viajeros,email,' . $id . ',id_viajero',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $usuario = Cliente::find($id);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        $usuario->nombre = $request->nombre;
        $usuario->email  = $request->email;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios')->with('mensaje', '✅ Usuario actualizado correctamente.');
    }

    // Eliminar un usuario
    public function eliminarUsuario($id)
    {
        $usuario = Cliente::find($id);

        if (!$usuario) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios')->with('mensaje', '✅ Usuario eliminado correctamente.');
    }

// Mostrar el calendario de reservas (vista de administrador)
public function calendarioReservasAdmin(Request $request)
{
    // Importar Carbon si aún no lo tienes en la parte superior del archivo:
    // use Carbon\Carbon;

    // Obtener mes y año desde la URL o usar los actuales
    $year = (int) $request->input('year', now()->year);
    $month = (int) $request->input('month', now()->month);

    // Validación básica del mes y año (evita errores si se pasa mal el mes)
    if ($month < 1 || $month > 12) {
        $month = now()->month;
    }
    if ($year < 2000 || $year > 2100) {
        $year = now()->year;
    }

    // Rango de fechas del mes actual
    $startDate = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
    $endDate = $startDate->copy()->endOfMonth();

    // Obtener total de reservas por fecha
    $datos = Reserva::selectRaw('DATE(fecha_reserva) as fecha, COUNT(*) as total')
        ->whereBetween('fecha_reserva', [$startDate, $endDate])
        ->groupBy('fecha')
        ->get();

    // Convertir resultado en array asociativo para la vista
    $reservasPorDia = [];
    foreach ($datos as $fila) {
        $reservasPorDia[$fila->fecha] = $fila->total;
    }

    // Enviar datos a la vista
    return view('Admin.calendario_reservas_admin', compact('reservasPorDia', 'year', 'month'));
    }



    // Gestión de hoteles
    public function gestionarHoteles()
    {
        $hoteles = Hotel::all();
        return view('Reservas.gestionar_hoteles', compact('hoteles'));
    }




    // Mostrar los reportes de actividad
    public function verReportesActividad()
    {
        // Total de reservas
        $totalReservas = Reserva::count();

        // Total de hoteles
        $totalHoteles = Hotel::count();

        // Zona más reservada (JOIN con zonas)
        $zonaMasReservada = DB::table('transfer_reservas')
            ->join('transfer_zona', 'transfer_reservas.id_destino', '=', 'transfer_zona.id_zona')
            ->select('transfer_zona.nombre_zona', DB::raw('count(*) as total'))
            ->groupBy('transfer_zona.nombre_zona')
            ->orderByDesc('total')
            ->first();

        // Últimas reservas (con nombre de zona)
        $ultimasReservas = DB::table('transfer_reservas')
            ->join('transfer_zona', 'transfer_reservas.id_destino', '=', 'transfer_zona.id_zona')
            ->select(
                'transfer_reservas.id_reserva',
                'transfer_reservas.email_cliente',
                'transfer_reservas.origen_vuelo_entrada',
                'transfer_zona.nombre_zona',
                'transfer_reservas.fecha_reserva'
            )
            ->orderByDesc('transfer_reservas.fecha_reserva')
            ->take(5)
            ->get();

        // Últimos hoteles (con nombre de zona) — tabla corregida
        $ultimosHoteles = DB::table('tranfer_hotel')
            ->join('transfer_zona', 'tranfer_hotel.id_zona', '=', 'transfer_zona.id_zona')
            ->select(
                'tranfer_hotel.id_hotel',
                'transfer_zona.nombre_zona',
                'tranfer_hotel.Comision',
                'tranfer_hotel.usuario'
            )
            ->orderByDesc('tranfer_hotel.id_hotel')
            ->take(5)
            ->get();

        // Reservas por día (últimos 7 días)
        $reservasPorDia = Reserva::select(
                DB::raw('DATE(fecha_reserva) as fecha'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('fecha_reserva', [now()->subDays(7), now()])
            ->groupBy(DB::raw('DATE(fecha_reserva)'))
            ->orderByDesc('fecha')
            ->get();

        return view('Admin.reportes_actividad', compact(
            'totalReservas',
            'totalHoteles',
            'zonaMasReservada',
            'ultimasReservas',
            'ultimosHoteles',
            'reservasPorDia'
        ));
    }
    
        public function formCrearReserva()
    {
        $hoteles = Hotel::all();
        $volver_url = route('admin.home'); // 👈 ruta al panel del admin
        return view('Admin.crear_reserva_admin', compact('hoteles', 'volver_url'));
    }

    //Listar reservas admin
        public function listarReservas()
    {
        $reservas = Reserva::all();
        return view('Admin.listar_reservas', compact('reservas'));
    }


    // Mostrar el formulario para registrar un usuario corporativo
     public function showformRegistrarCorporativo()
    {
            return view('Admin.formRegistrarCorporativo');
    }

   
   
   // registrar cliente corporativo
   public function registrarCorporativo(Request $request)
   {
       $request->validate([
           'nombre'      => 'required|string|max:255',
           'apellido1'   => 'required|string|max:255',
           'apellido2'   => 'required|string|max:255',
           'direccion'   => 'required|string|max:255',
           'codigoPostal'=> 'required|string|max:10',
           'ciudad'      => 'required|string|max:100',
           'pais'        => 'required|string|max:100',
           'email'       => 'required|email|unique:transfer_viajeros,email',
           'password'    => 'required|string|min:8|confirmed',
       ]);
   
       try {
           $cliente = new Cliente();
           $cliente->nombre        = $request->nombre;
           $cliente->apellido1     = $request->apellido1;
           $cliente->apellido2     = $request->apellido2;
           $cliente->direccion     = $request->direccion;
           $cliente->codigoPostal  = $request->codigoPostal;
           $cliente->ciudad        = $request->ciudad;
           $cliente->pais          = $request->pais;
           $cliente->email         = $request->email;
           $cliente->password      = Hash::make($request->password);
           $cliente->tipo_cliente  = 'corporativo';
           $cliente->save();
   
           return redirect()->route('admin.corporativos.form')
                           ->with('success', '✅ Usuario corporativo registrado correctamente.');
       } catch (\Exception $e) {
           return back()->withInput()
               ->with('error', '❌ Error al registrar el usuario corporativo: ' . $e->getMessage());
       }
   }


   //Método para ver el resumen de las comisiones
   public function verResumenComisiones(Request $request)
{
    $mes = $request->input('mes', now()->format('m'));
    $anio = $request->input('anio', now()->format('Y'));

    $reservas = DB::table('transfer_reservas')
        ->join('tranfer_hotel', 'transfer_reservas.id_hotel', '=', 'tranfer_hotel.id_hotel')
        ->select(
            'tranfer_hotel.usuario as nombre_hotel',
            DB::raw('COUNT(transfer_reservas.id_reserva) as total_reservas'),
            DB::raw('tranfer_hotel.Comision as comision_unitaria'),
            DB::raw('COUNT(transfer_reservas.id_reserva) * tranfer_hotel.Comision as total_comision')
        )
        ->whereMonth('transfer_reservas.fecha_reserva', '=', $mes)
        ->whereYear('transfer_reservas.fecha_reserva', '=', $anio)
        ->groupBy('transfer_reservas.id_hotel', 'tranfer_hotel.usuario', 'tranfer_hotel.Comision')
        ->get();

    return view('Admin.resumen_comisiones', compact('reservas', 'mes', 'anio'));
}

   

}
