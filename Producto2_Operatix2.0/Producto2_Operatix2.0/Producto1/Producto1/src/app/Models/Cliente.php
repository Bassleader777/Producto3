<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'transfer_viajeros';
    protected $primaryKey = 'id_viajero';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'apellido1', 'apellido2', 'direccion',
        'codigoPostal', 'ciudad', 'pais', 'email',
        'password', 'tipo_cliente'
    ];

    protected $hidden = [
        'password',
    ];

    public function getId()
    {
        return $this->id_viajero;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

   
}
