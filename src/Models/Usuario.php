<?php

declare(strict_types=1);

namespace Models;

use Database\Conexion;
use PDO;

class Usuario
{
    protected string $e_mail;
    protected string $password;
    protected string $tipo;
    protected string $nombres;
    protected string $apellidos;
    protected string $gender;
    protected ?int $id = null;

    public function __construct(
        string $e_mail,
        string $password,
        string $tipo,
        string $nombres,
        string $apellidos,
        string $gender,
        ?int $id = null)
    {
        $this->e_mail = $e_mail;
        $this->tipo = $tipo;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->gender = $gender;
        if ($id !== null) {
            $this->id = $id;
            $this->password = $password; // ya viene hasheada si viene de la BD
        } else {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        }
    }

    public function guardar(): int
    {
        $conexion = (new Conexion())->getConexion();
    
        $query = "INSERT INTO usuario (id, e_mail, password, tipo, nombres, apellidos, gender)
                  VALUES (null, :e_mail, :password, :tipo, :nombres, :apellidos, :gender)";
    
        $stmt = $conexion->prepare($query);
    
        $resultado = $stmt->execute([
            ':e_mail' => $this->e_mail,
            ':password' => $this->password,
            ':tipo' => $this->tipo,
            ':nombres' => $this->nombres,
            ':apellidos' => $this->apellidos,
            ':gender' => $this->gender
        ]);
        
        if (!$resultado) {
            // Imprime el error exacto de SQL
            $error = $stmt->errorInfo();
            print_r($error);
            die(); // detener ejecución para ver el error
        }
        $this->id=(int)$conexion->lastInsertId();
        $id=$this->id;
        return $id;
        //return $resultado;
    }
    
    public function obtenerUsuario(int $id){

        $conexion = (new Conexion())->getConexion();
        $query2="select * from usuario where id=:id;";
        $stmt2=$conexion->prepare($query2);
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$stmt2->execute()) {
            throw new Exception("Error al ejecutar la consulta para obtener el usuario.");
        }

        $resultado2=$stmt2->fetchAll(PDO::FETCH_ASSOC);
        return $resultado2;
    }
    public static function autenticar(string $e_mail, string $password): ?Usuario
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM usuario WHERE e_mail = :e_mail";
        $stmt = $conexion->prepare($query);
        $stmt->execute([':e_mail' => $e_mail]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            return new self($usuario['e_mail'], $usuario['password'], $usuario['tipo'], $usuario['nombres'], $usuario['apellidos'], $usuario['gender'],(int) $usuario['id']);
        }

        return null;
    }
}
?>