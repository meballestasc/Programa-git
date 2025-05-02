<?php

declare(strict_types=1);

namespace Database;

use PDO;
use PDOException;
class Conexion
{
    private PDO $conexion;
    public function __construct()
    {

        $config = require realpath(__DIR__ . '/../../config/database.php');
        try {
            //$dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $dsn="mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            $this->conexion = new PDO($dsn,$config['user'],$config['password'],
                /*'mysql:host=localhost;dbname=SER;charset=utf8',
                'root',
                '',//Este sería el código necesario sin archivo de configuración ni propiedades de clase*/
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