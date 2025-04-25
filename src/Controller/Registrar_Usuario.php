<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Conexion;
use PDO;
use PDOException;
use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Profesor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = (new Conexion())->getConexion();

    try {
        // Iniciar transacción
        $conexion->beginTransaction();

        // Crear usuario
        $usuario = new Usuario($_POST['e_mail'], $_POST['contraseña'], $_POST['tipo'],$_POST['nombres'], $_POST['apellidos'], $_POST['género']);
        if (!$usuario->guardar()) {
            throw new PDOException('Error al registrar usuario.');
        }

        $id = $conexion->lastInsertId();

        // Crear estudiante o profesor según el tipo
        if ($_POST['tipo'] === 'estudiante') {
            $estudiante = new Estudiante($id, $_POST['tipo_doc'], $_POST['num_id']);
            if (!$estudiante->guardar()) {
                throw new PDOException('Error al registrar estudiante.');
            }
        } else {
            $profesor = new Profesor($id, $_POST['tipo_doc'], $_POST['num_id'], $_POST['escalafon'], $_POST['fecha_ingreso'] $_POST['especialidad']);
            if (!$profesor->guardar()) {
                throw new PDOException('Error al registrar profesor.');
            }
        }

        //Confirmar la transacción
        $conexion->commit();
        echo 'Registro exitoso.';
    } catch (PDOException $e) {
        //Revertir la transacción en caso de error
        $conexion->rollBack();
        echo 'Error: ' . $e->getMessage();
    }
}
?>