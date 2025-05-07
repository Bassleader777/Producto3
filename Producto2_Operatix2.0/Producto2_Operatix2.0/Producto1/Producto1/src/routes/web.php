<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VehiculoController;

// Página de inicio → login
Route::get('/', fn() => redirect()->route('login.form'));

// Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Vista tras login (cliente)
Route::get('/home', fn() => view('Reservas.home_cliente'))->name('home')->middleware('auth');

// === CLIENTE ===
Route::prefix('cliente')->middleware('auth')->group(function () {
    Route::get('/home', fn() => view('Reservas.home_cliente'))->name('cliente.home');

    // Perfil
    Route::get('/perfil', [ClienteController::class, 'viewProfile'])->name('cliente.perfil');
    Route::post('/perfil', [ClienteController::class, 'actualizarPerfil'])->name('cliente.perfil.actualizar');

    Route::get('/logout', [ClienteController::class, 'logout'])->name('cliente.logout');
});

// Registro (público)
Route::get('/cliente/registro', [ClienteController::class, 'formRegistro'])->name('cliente.registro.form');
Route::post('/cliente/registro', [ClienteController::class, 'registrarCliente'])->name('cliente.registro');

// === HOTEL ===
Route::prefix('hotel')->middleware('auth')->group(function () {
    Route::get('/home', fn() => view('Reservas.home_hotel'))->name('hotel.home');
});

Route::get('/hotel/registro', [HotelController::class, 'formularioRegistro'])->name('hotel.registro.form');
Route::post('/hotel/registro', [HotelController::class, 'registrar'])->name('hotel.registro');

// === RESERVAS ===
Route::prefix('reserva')->middleware('auth')->group(function () {
    Route::get('/crear', [ReservaController::class, 'formCrear'])->name('reserva.crear.form');
    Route::post('/crear', [ReservaController::class, 'crearReserva'])->name('reserva.crear');

    Route::get('/listar', [ReservaController::class, 'listarReservas'])->name('reserva.listar');
    Route::get('/detalle/{id}', [ReservaController::class, 'detalle'])->name('reserva.detalle');

    Route::get('/modificar', [ReservaController::class, 'formModificar'])->name('reserva.modificar.form');
    Route::post('/modificar', [ReservaController::class, 'modificar'])->name('reserva.modificar');

    Route::post('/eliminar', [ReservaController::class, 'eliminar'])->name('reserva.eliminar');

    Route::get('/calendario', [ReservaController::class, 'mostrarCalendario'])->name('reserva.calendario');

    Route::get('/gestionar/hoteles', fn() => view('Reservas.gestionar_hoteles'))->name('reserva.hoteles.gestionar');
    Route::get('/gestionar/vehiculos', fn() => view('Reservas.gestionar_vehiculos'))->name('reserva.vehiculos.gestionar');

    Route::get('/editar/hotel', fn() => view('Reservas.editar_hotel'))->name('reserva.editar.hotel');
    Route::get('/editar/vehiculos', fn() => view('Reservas.editar_vehiculos'))->name('reserva.editar.vehiculo');

    Route::get('/eliminar', fn() => view('Reservas.eliminar_reserva'))->name('reserva.eliminar.form');
    Route::get('/modificar/cliente', fn() => view('Reservas.modificar_Reserva'))->name('reserva.modificar.cliente');
});

    // === ADMINISTRACIÓN ===
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/home', fn() => view('Admin.home_admin'))->name('admin.home');
    Route::get('/reportes', fn() => view('Admin.reportes_actividad'))->name('admin.reportes');

    // Gestión de USUARIOS
    Route::get('/usuarios', [AdminController::class, 'obtenerTodosLosUsuarios'])->name('admin.usuarios');
    Route::get('/usuarios/{id}/editar', [AdminController::class, 'editarUsuario'])->name('admin.usuarios.editar');
    Route::post('/usuarios/{id}/actualizar', [AdminController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');
    Route::get('/usuarios/{id}/eliminar', [AdminController::class, 'eliminarUsuario'])->name('admin.usuarios.eliminar');

    // ✅ Gestión de HOTELES (corregido sin duplicar '/admin')
    Route::get('/hoteles', [AdminController::class, 'gestionarHoteles'])->name('admin.hoteles');
    Route::get('/hoteles/editar', [HotelController::class, 'formEditar'])->name('admin.hoteles.editar');
    Route::put('/hoteles/{id_hotel}/actualizar', [HotelController::class, 'actualizarHotel'])->name('hotel.actualizar');
    // Ruta para procesar el formulario de creación de hotel
    Route::post('/hoteles', [HotelController::class, 'registrarHotel'])->name('hoteles.store');
    // Ruta para mostrar el formulario de añadir nuevo hotel
    Route::get('/hoteles/crear', [HotelController::class, 'crearHotel'])->name('hoteles.create');
    // Ruta para eliminar un hotel
    Route::get('/hoteles/eliminar/{id_hotel}', [HotelController::class, 'eliminarHotel'])->name('hotel.eliminar');

    // Gestión de VEHICULOS
    // Mostrar todos los vehículos
    Route::get('/vehiculos', [VehiculoController::class, 'listarVehiculos'])->name('vehiculo.listar');

    // Mostrar formulario de edición con ?id=...
    Route::get('/vehiculos/editar', [VehiculoController::class, 'formEditarVehiculo'])->name('admin.vehiculos.editar');

    // Actualizar un vehículo (requiere campo hidden con id en el form)
    Route::post('/vehiculos/actualizar', [VehiculoController::class, 'actualizarVehiculo'])->name('admin.vehiculos.actualizar');

    // Eliminar vehículo (mediante ?id=...)
    Route::get('/vehiculos/eliminar', [VehiculoController::class, 'eliminarVehiculo'])->name('admin.vehiculos.eliminar');

    // Mostrar formulario para crear vehículo
    Route::get('/vehiculos/crear', fn() => view('Reservas.crear_vehiculo'))->name('admin.vehiculos.crear.form');

    // Procesar formulario de creación
    Route::post('/vehiculos/crear', [VehiculoController::class, 'crearVehiculo'])->name('admin.vehiculos.crear');



    // Gestión de RESERVAS
    Route::get('/reservas/calendario', fn() => view('Admin.calendario_reservas_admin'))->name('admin.reservas.calendario');
    Route::get('/reservas/crear', fn() => view('Admin.crear_reserva_admin'))->name('admin.reservas.crear');
});


