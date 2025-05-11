<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ApiController;

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
    
    // Rutas para las reservas del hotel
    Route::get('/reservas/crear', [HotelController::class, 'formCrearReserva'])->name('hotel.reserva.form'); // Formulario de crear reserva (Hotel)
    Route::post('/reservas/crear', [HotelController::class, 'procesarReserva'])->name('hotel.reserva.crear'); // Procesar reserva (Hotel)

    // Rutas para listar las reservas del hotel
    Route::get('/reservas', [HotelController::class, 'listarReservas'])->name('hotel.reservas'); // Listar reservas (Hotel)
});

Route::get('/hotel/registro', [HotelController::class, 'formularioRegistro'])->name('hotel.registro.form');
Route::post('/hotel/registro', [HotelController::class, 'registrar'])->name('hotel.registro');

// === RESERVAS ===
Route::prefix('reserva')->middleware('auth')->group(function () {
    // Rutas para la creación de reservas (Cliente)
    Route::get('/crear', [ReservaController::class, 'formCrear'])->name('reserva.crear.form'); // Formulario de crear reserva
    Route::post('/crear', [ReservaController::class, 'crearReserva'])->name('reserva.crear'); // Procesar la reserva

    // Rutas para listar reservas (Cliente)
    Route::get('/listar', [ReservaController::class, 'listarReservas'])->name('reserva.listar');

    // Rutas para ver detalles de la reserva
    Route::get('/detalle/{id}', [ReservaController::class, 'verReserva'])->name('reserva.detalle');

    // Rutas para modificar reservas (Cliente)
    Route::get('/modificar/{id_reserva}', [ReservaController::class, 'formModificar'])->name('reserva.modificar.form'); // Formulario de modificación
    Route::post('/modificar/{id_reserva}', [ReservaController::class, 'modificarReserva'])->name('reserva.modificar'); // Procesar modificación

    // Ruta para eliminar reserva
    Route::post('/eliminar', [ReservaController::class, 'eliminarReserva'])->name('reserva.eliminar'); // Eliminar reserva

    // Rutas para calendario de reservas (Cliente)
    Route::get('/calendario', [ReservaController::class, 'mostrarCalendario'])->name('reserva.calendario');
});


    // === ADMINISTRACIÓN ===

    Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/home', fn() => view('Admin.home_admin'))->name('admin.home');
    Route::get('/reportes', [AdminController::class, 'verReportesActividad'])->name('admin.reportes');
    Route::get('/reservas/calendario', [AdminController::class, 'calendarioReservasAdmin'])->name('admin.reservas.calendario');
    Route::get('/comisiones', [AdminController::class, 'verResumenComisiones'])->name('admin.comisiones.resumen');





    // Gestión de USUARIOS
    Route::get('/usuarios', [AdminController::class, 'obtenerTodosLosUsuarios'])->name('admin.usuarios');
    Route::get('/usuarios/{id}/editar', [AdminController::class, 'editarUsuario'])->name('admin.usuarios.editar');
    Route::post('/usuarios/{id}/actualizar', [AdminController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');
    Route::get('/usuarios/{id}/eliminar', [AdminController::class, 'eliminarUsuario'])->name('admin.usuarios.eliminar');

    // Registro de Usuarios Corporativos
    Route::get('/corporativos/crear', [AdminController::class, 'showformRegistrarCorporativo'])->name('admin.corporativos.form');
    Route::post('/corporativos/crear', [AdminController::class, 'registrarCorporativo'])->name('admin.corporativos.store');




    // Gestión de HOTELES (corregido sin duplicar '/admin')
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
    Route::get('/reservas/calendario', [AdminController::class, 'calendarioReservasAdmin'])->name('admin.reservas.calendario');
    Route::get('/reservas/crear', [AdminController::class, 'formCrearReserva'])->name('admin.reservas.crear');
    Route::get('/reservas', [AdminController::class, 'listarReservas'])->name('admin.reservas.listar');

    //Listar Hotel
    Route::get('/hotel/reservas', [HotelController::class, 'listarReservas'])->name('hotel.reservas');
    Route::get('/reservas', [HotelController::class, 'listarReservas'])->name('hotel.reservas');


    //USUARIO CORPORATIVO
    Route::get('/perfil', [HotelController::class, 'editarPerfil'])->name('hotel.perfil');
    Route::put('/hotel/perfil', [HotelController::class, 'updatePerfil'])->name('hotel.updatePerfil');
});


