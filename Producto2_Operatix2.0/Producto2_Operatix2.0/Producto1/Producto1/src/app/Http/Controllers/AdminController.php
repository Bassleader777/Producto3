<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Hotel;
use App\Models\Reserva;

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
    public function calendarioReservas()
    {
        $reservasPorDia = [
            '2025-04-01' => 1,
            '2025-04-05' => 2,
            '2025-04-10' => 3,
            '2025-04-15' => 1,
            '2025-04-20' => 2,
            '2025-04-22' => 1,
            '2025-04-30' => 2,
        ];

        $year = 2025;
        $month = 4;

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

}
