<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Usuario;
use Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $usuario = Usuario::autenticar($_POST['e_mail'], $_POST['contraseña']);
        if ($usuario) {
            $_SESSION['id'] = $usuario->id;
            $_SESSION['tipo'] = $usuario->tipo;

            header("Location: " . ($usuario->tipo === 'estudiante' ? 'estudiante_menu.php' : 'profesor_menu.php'));
            exit;
        }

        throw new Exception("e_mail o contraseña incorrectos.");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}