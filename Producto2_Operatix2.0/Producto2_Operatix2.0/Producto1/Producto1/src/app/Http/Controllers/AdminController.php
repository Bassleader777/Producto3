<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

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
        $usuario->email = $request->email;

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
}
