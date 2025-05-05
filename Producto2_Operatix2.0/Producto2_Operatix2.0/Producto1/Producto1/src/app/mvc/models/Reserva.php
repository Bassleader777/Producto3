<?php
// Clase Reserva: representa una reserva realizada por un hotel o cliente

namespace app\mvc\models;


class Reserva
{

    // Atributos privados que coinciden exactamente con los campos de la tabla transfer_reservas
    private $id_reserva;
    private $localizador;
    private $id_hotel;
    private $id_tipo_reserva;
    private $email_cliente;
    private $fecha_reserva;
    private $fecha_modificacion;
    private $id_destino;
    private $fecha_entrada;
    private $hora_entrada;
    private $numero_vuelo_entrada;
    private $origen_vuelo_entrada;
    private $hora_vuelo_salida;
    private $fecha_vuelo_salida;
    private $num_viajeros;
    private $id_vehiculo;

    // Constructor: se ejecuta al crear una nueva instancia de Reserva
    public function __construct($id_reserva, $localizador, $id_hotel, $id_tipo_reserva, $email_cliente,
                                $fecha_reserva, $fecha_modificacion, $id_destino, $fecha_entrada, $hora_entrada,
                                $numero_vuelo_entrada, $origen_vuelo_entrada, $hora_vuelo_salida,
                                $fecha_vuelo_salida, $num_viajeros, $id_vehiculo)
    {

        $this->id_reserva = $id_reserva;
        $this->localizador = $localizador;
        $this->id_hotel = $id_hotel;
        $this->id_tipo_reserva = $id_tipo_reserva;
        $this->email_cliente = $email_cliente;
        $this->fecha_reserva = $fecha_reserva;
        $this->fecha_modificacion = $fecha_modificacion;
        $this->id_destino = $id_destino;
        $this->fecha_entrada = $fecha_entrada;
        $this->hora_entrada = $hora_entrada;
        $this->numero_vuelo_entrada = $numero_vuelo_entrada;
        $this->origen_vuelo_entrada = $origen_vuelo_entrada;
        $this->hora_vuelo_salida = $hora_vuelo_salida;
        $this->fecha_vuelo_salida = $fecha_vuelo_salida;
        $this->num_viajeros = $num_viajeros;
        $this->id_vehiculo = $id_vehiculo;
    }

    public static function obtenerPorEmailCliente($email)
{
    try {
        $pdo = new \PDO("mysql:host=db;dbname=isla_transfers", "root", "adminadmin");
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM transfer_reservas WHERE email_cliente = ?");
        $stmt->execute([$email]);

        $reservas = [];
        while ($fila = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $reservas[] = new Reserva(
                $fila['id_reserva'],
                $fila['localizador'],
                $fila['id_hotel'],
                $fila['id_tipo_reserva'],
                $fila['email_cliente'],
                $fila['fecha_reserva'],
                $fila['fecha_modificacion'],
                $fila['id_destino'],
                $fila['fecha_entrada'],
                $fila['hora_entrada'],
                $fila['numero_vuelo_entrada'],
                $fila['origen_vuelo_entrada'],
                $fila['hora_vuelo_salida'],
                $fila['fecha_vuelo_salida'],
                $fila['num_viajeros'],
                $fila['id_vehiculo']
            );
        }

        return $reservas;

    } catch (\PDOException $e) {
        echo "Error al obtener reservas del cliente: " . $e->getMessage();
        return [];
    }
}


    // Getters (para leer valores)
    public function getIdReserva()
    {
        return $this->id_reserva;
    }

    public function getLocalizador()
    {
        return $this->localizador;
    }

    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    public function getIdTipoReserva()
    {
        return $this->id_tipo_reserva;
    }

    public function getEmailCliente()
    {
        return $this->email_cliente;
    }

    public function getFechaReserva()
    {
        return $this->fecha_reserva;
    }

    public function getFechaModificacion()
    {
        return $this->fecha_modificacion;
    }

    public function getIdDestino()
    {
        return $this->id_destino;
    }

    public function getFechaEntrada()
    {
        return $this->fecha_entrada;
    }

    public function getHoraEntrada()
    {
        return $this->hora_entrada;
    }

    public function getNumeroVueloEntrada()
    {
        return $this->numero_vuelo_entrada;
    }

    public function getOrigenVueloEntrada()
    {
        return $this->origen_vuelo_entrada;
    }

    public function getHoraVueloSalida()
    {
        return $this->hora_vuelo_salida;
    }

    public function getFechaVueloSalida()
    {
        return $this->fecha_vuelo_salida;
    }

    public function getNumViajeros()
    {
        return $this->num_viajeros;
    }

    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }

    // Setters (si necesitas modificar valores en el futuro)
    public function setNumViajeros($num_viajeros)
    {
        $this->num_viajeros = $num_viajeros;
    }

    public function setFechaModificacion($fecha_modificacion)
    {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function setIdVehiculo($id_vehiculo)
    {
        $this->id_vehiculo = $id_vehiculo;
    }
}

?>
