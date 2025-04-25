<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Conexion
{
    private PDO $conexion;
    
    //$config = require __DIR__ . '/../../config/database.php';
    public function __construct()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $this->conexion = new PDO(
                /*$dsn,
                $config['user'],
                $config['password'],*/
                'mysql:host=localhost;dbname=SER;charset=utf8',
                'root',
                '',//Este sería el código necesario sin archivo de configuración ni propiedades de clase
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException("Error en la conexión: " . $e->getMessage());
        }
    }

    public function getConexion(): PDO
    {
        return $this->conexion;
    }
}