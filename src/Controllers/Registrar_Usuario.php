<?php

declare(strict_types=1);

namespace Controllers;
require_once realpath(__DIR__ . '/../../autoload.php');
use Database\Conexion;
use PDO;
use PDOException;
use Models\Usuario;
use Models\Estudiante;
use Models\Profesor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = (new Conexion())->getConexion();

    try {
        // Iniciar transacción
        $conexion->beginTransaction();

        // Crear usuario
        $usuario = new Usuario(
            $_POST['e_mail'],
            $_POST['password'],
            $_POST['tipo'],
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['gender']);
        $idUsuario=$usuario->guardar();//arreglo del usuario registrado en base de datos
        if ($idUsuario===0) {
            throw new PDOException('Error al registrar usuario.');
        }
        echo "enviado último id" . $idUsuario;
        if ($_POST['tipo'] === 'Estudiante') {
            $estudiante = new Estudiante(
                $_POST['e_mail'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['gender'],
                $idUsuario,
                $_POST['tipo_doc'],
                $_POST['num_id']);
            if (!$estudiante->guardarEstudiante()) {
                throw new PDOException('Error al registrar estudiante.');
                $conexion->rollBack();
            }
        } else {
            $profesor = new Profesor($id, $_POST['tipo_doc'], $_POST['num_id'], $_POST['escalafon'], $_POST['fecha_ingreso'], $_POST['especialidad']);
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