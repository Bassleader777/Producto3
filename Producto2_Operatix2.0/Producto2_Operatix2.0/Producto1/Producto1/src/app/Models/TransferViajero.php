<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TransferViajero extends Authenticatable
{
    use Notifiable;

    protected $table = 'transfer_viajeros'; // nombre de la tabla

    protected $primaryKey = 'id_viajero'; // clave primaria personalizada

    public $timestamps = false; // si no usas created_at y updated_at

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'direccion',
        'codigoPostal',
        'ciudad',
        'pais',
        'email',
        'password',
        'tipo_cliente',
    ];

    protected $hidden = [
        'password',
    ];
}
