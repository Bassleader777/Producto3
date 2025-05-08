<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function reservasPorZona()
    {
        // Total de todas las reservas
        $total = DB::table('transfer_reservas')->count();

        // Agregado por zona
        $zonas = DB::table('transfer_reservas')
            ->join('tranfer_hotel', 'transfer_reservas.id_hotel', '=', 'tranfer_hotel.id_hotel')
            ->join('transfer_zona', 'tranfer_hotel.id_zona', '=', 'transfer_zona.id_zona')
            ->select(
                'transfer_zona.nombre_zona as zona',
                DB::raw('COUNT(transfer_reservas.id_reserva) as reservas')
            )
            ->groupBy('transfer_zona.nombre_zona')
            ->get();

        // Añadir % del total a cada zona
        $zonas = $zonas->map(function ($zona) use ($total) {
            $zona->porcentaje = $total > 0 ? round(($zona->reservas / $total) * 100, 1) : 0;
            return $zona;
        });

        return response()->json($zonas);
    }
}
