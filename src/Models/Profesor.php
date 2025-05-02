<?php

declare(strict_types=1);

namespace Models;
require_once realpath(__DIR__ . '/../../autoload.php');
use Database\Conexion;
use PDO;
use DateTime;

class Profesor extends Usuario
{
    private string $tipo_doc;
    private string $num_id_profesor;
    private int $escalafon;
    private DateTime $fecha_ingreso;
    private string $especialidad;

    public function __construct(int $id, string $e_mail, string $nombres, string $apellidos, string $gen, string $tipo_doc,  string $num_id_profesor, int $escalafon,  string $fecha_ingreso, string $especialidad)
    {
        if (!strtotime($fecha_ingreso)) {
            throw new InvalidArgumentException("Formato de fecha inválido: $fecha_ingreso");
        }
    
        parent::__construct($id, $e_mail, '', 'profesor', $nombres, $apellidos, $gen);
        $this->tipo_doc = $tipo_doc;
        $this->num_id_profesor = $num_id_profesor;
        $this->escalafon = $escalafon;
        $this->fecha_ingreso = new DateTime ($fecha_ingreso);
        $this->especialidad = $especialidad;
    }

    public function getFechaIngreso():string {
        return $this->fecha_ingreso->format('Y-m-d');
    }

    public function guardar(): bool{
        try {
            $conexion = (new Conexion())->getConexion();
            // Validar si el profesor ya está registrado
            $query = "SELECT COUNT(*) FROM profesor WHERE num_id_profesor = :num_id_profesor";
            $stmt = $conexion->prepare($query);
            $stmt->execute([':num_id_profesor' => $this->num_id_profesor]);

            if ((int)$stmt->fetchColumn() > 0) {
                throw new Exception("El profesor con ID {$this->num_id_profesor} ya existe.");
            }

            $query = "INSERT INTO profesor (tipo_doc, num_id_profesor, escalafon, fecha_ingreso, cod_usu, especialidad) VALUES (:tipo_doc, :num_id_profesor, :escalafon, :fecha_ingreso, :id, :especialidad)";
            $stmt = $conexion->prepare($query);
            return $stmt->execute([
                ':tipo_doc' => $this->tipo_doc,
                ':num_id_profesor' => $this->num_id_profesor,
                ':escalafon' => $this->escalafon,
                ':fecha_ingreso' => $this->fecha_ingreso->format('Y-m-d'),
                ':id' => $this->id,
                ':especialidad' => $this->especialidad
            ]);
        } catch (Exception $e) {
            error_log("Error al guardar el profesor: " . $e->getMessage());
            return false;
        }
    }
}
?>