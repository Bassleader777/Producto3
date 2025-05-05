<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('Clientes.login');
    }

    // Maneja el inicio de sesión (autenticación manual)
    public function login(Request $request)
    {
        // Validación
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Buscar cliente por email
        $cliente = Cliente::where('email', $request->email)->first();

        if (!$cliente) {
            return back()->withErrors(['login_error' => 'No se encontró el cliente.'])->withInput();
        }

        // Verificar contraseña
        if (!Hash::check($request->password, $cliente->password)) {
            return back()->withErrors(['login_error' => 'Contraseña incorrecta.'])->withInput();
        }

        // Iniciar sesión manual
        Auth::login($cliente);
        $request->session()->regenerate();

        // Redirección según tipo de cliente
        switch ($cliente->tipo_cliente) {
            case 'administrador':
                return redirect()->route('admin.home');
            case 'particular':
            case 'corporativo':
                return redirect()->route('cliente.home');
            default:
                return redirect('/')->with('error', 'Tipo de cliente no reconocido.');
        }
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
