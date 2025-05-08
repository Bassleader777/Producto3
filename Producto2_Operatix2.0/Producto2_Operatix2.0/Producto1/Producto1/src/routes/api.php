<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Ruta API para obtener resumen de reservas por zona
Route::get('/reservas/zonas', [ApiController::class, 'reservasPorZona']);
