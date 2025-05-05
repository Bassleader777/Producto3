<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    // REGISTRO DE NUEVO CLIENTE
    public function registrarCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'direccion' => 'required|string',
            'codigoPostal' => 'required|string|max:10',
            'ciudad' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'email' => 'required|email|unique:transfer_viajeros,email',
            'password' => 'required|string|min:8|confirmed',
            'tipo_cliente' => 'required|string'
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2 ?? '',
            'direccion' => $request->direccion,
            'codigoPostal' => $request->codigoPostal,
            'ciudad' => $request->ciudad,
            'pais' => $request->pais,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_cliente' => $request->tipo_cliente,
        ]);

        Log::info('Nuevo cliente creado: ', ['cliente' => $cliente]);

        return redirect()->route('login.form')->with('success', 'Cliente registrado con éxito. ¡Ahora puedes iniciar sesión!');
    }

    // FORMULARIO DE REGISTRO
    public function formRegistro()
    {
        return view('Clientes.registro');
    }

    // FORMULARIO DE LOGIN
    public function showLogin()
    {
        return view('Clientes.login');
    }

    // LOGIN DE CLIENTE
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();

        if ($cliente && Hash::check($request->password, $cliente->password)) {
            Auth::login($cliente);
            $request->session()->regenerate();

            return redirect($cliente->tipo_cliente === 'administrador' ? route('admin.home') : route('cliente.home'));
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    // PERFIL DEL CLIENTE (formulario)
    public function viewProfile()
    {
        $cliente = Auth::user();
        return view('Clientes.editar_perfil', compact('cliente'));
    }

    // ACTUALIZACIÓN DE PERFIL DEL CLIENTE
    public function actualizarPerfil(Request $request)
    {
        $cliente = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'email' => 'required|email|unique:transfer_viajeros,email,' . $cliente->id_viajero . ',id_viajero',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $cliente->nombre = $request->nombre;
        $cliente->apellido1 = $request->apellido1;
        $cliente->email = $request->email;

        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return redirect()->route('cliente.perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    // GESTIÓN PARA ADMINISTRADOR
    public function obtenerTodosLosClientes()
    {
        $clientes = Cliente::all();
        return view('Admin.gestionar_usuarios', compact('clientes'));
    }

    public function obtenerClientePorId($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }
        return $cliente;
    }

    public function modificarCliente(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:transfer_viajeros,email,' . $id . ',id_viajero',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('admin.usuarios')->with('error', '❌ Usuario no encontrado.');
        }

        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;

        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return redirect()->route('admin.usuarios')->with('success', '✅ Usuario actualizado correctamente.');
    }

    public function eliminarCliente($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->delete();
            return redirect()->route('admin.usuarios')->with('success', '✅ Cliente eliminado correctamente.');
        } else {
            return redirect()->route('admin.usuarios')->with('error', '❌ No se encontró el cliente.');
        }
    }
}
