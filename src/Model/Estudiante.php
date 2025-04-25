<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Conexion;
use PDO;

class Estudiante extends Usuario
{
    private string $tipo_doc;
    private string $num_id_estudiante;

    public function __construct(int $id, string $e_mail, string $nombres, string $apellidos,string $género, string $tipo_doc, string $num_id_estudiante)
    {
        parent::__construct($e_mail, '', 'estudiante', $id, $nombres, $apellidos, $género);
        $this->tipo_doc = $tipo_doc;
        $this->num_id_estudiante=$num_id_estudiante;
    }

    public function guardar(): bool
    {
        try{
            $conexion = (new Conexion())->getConexion();
            $query = "SELECT COUNT(*) FROM estudiante WHERE num_id_estudiante = :num_id_estudiante";
            $stmt = $conexion->prepare($query);
            $stmt->execute([':num_id_estudiante' => $this->num_id_profesor]);

            if ($stmt->fetchColumn() > 0) {
                throw new Exception("El estudiante con ID {$this->num_id_profesor} ya existe.");
            }

            $query = "INSERT INTO estudiante (tipo_doc, num_id_estudiante, cod_usu) VALUES (:tipo_doc, :num_id_estudiante, :id)";
            $stmt = $conexion->prepare($query);
            return $stmt->execute([
                ':id' => $this->id,
                ':tipo_doc' => $this->tipo_doc,
                ':num_id_estudiante' => $this->num_id_estudiante,
            ]);
        }catch(Exception $e){
            error_log("Error al guardar el profesor: " . $e->getMessage());
            return false;
        }
    }
}
?>