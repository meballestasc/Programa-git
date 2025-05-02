<?php

declare(strict_types=1);

namespace Models;
require_once realpath(__DIR__ . '/../../autoload.php');
use Database\Conexion;
use PDO;
use Exception;

class Estudiante extends Usuario
{
    private string $tipo_doc;
    private string $num_id_estudiante;

    public function __construct(string $e_mail, string $nombres, string $apellidos,string $gen, int $id,  string $tipo_doc, string $num_id_estudiante)
    {
        parent::__construct($e_mail, '', 'Estudiante', $nombres, $apellidos, $gen, $id);
        $this->tipo_doc = $tipo_doc;
        $this->num_id_estudiante=$num_id_estudiante;
    }

    public function guardarEstudiante(): bool
    {
        try{
            //se verifica que el num_id no esté registrado en la tabla estudiante.
            $conexion = (new Conexion())->getConexion();
            $query = "SELECT COUNT(*) FROM estudiante WHERE num_id_estudiante = :num_id_estudiante";
            $stmt = $conexion->prepare($query);
            $stmt->execute([':num_id_estudiante' => $this->num_id_estudiante]);

            if ((int)$stmt->fetchColumn() > 0) {
                throw new Exception("El estudiante con número de documento {$this->num_id_estudiante} ya existe.");
            }

            $query = "INSERT INTO estudiante (tipo_doc, num_id_estudiante, cod_usu) VALUES (:tipo_doc, :num_id_estudiante, :id)";
            $stmt = $conexion->prepare($query);
            return $stmt->execute([
                ':tipo_doc' => $this->tipo_doc,
                ':num_id_estudiante' => $this->num_id_estudiante,
                ':id' => $this->id
            ]);
            //verifica que la inserción en la tabla estudiante se haya efectuado
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se pudo registrar al estudiante.");
            }
        }catch (Exception $e){
            error_log("Error al guardar el estudiante: " . $e->getMessage());
            return false;
        }
    }
}
?>