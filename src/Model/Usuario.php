<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Conexion;
use PDO;

class Usuario
{
    protected int $id;
    protected string $e_mail;
    protected string $contraseña;
    protected string $tipo;
    protected string $nombres;
    protected string $apellidos;
    protected string $género;

    public function __construct(?int $id = null, string $e_mail, string $contraseña, string $tipo, string $nombres,string $apellidos,  string $género)
    {
        if ($id) {
            $this->id = $id;
        }
        $this->e_mail = $e_mail;
        $this->contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
        $this->tipo = $tipo;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->género = $género;
    }

    public function guardar(): bool
    {
        $conexion = (new Conexion())->getConexion();
        $query = "INSERT INTO usuario (e_mail, contraseña, tipo, nombres, apellidos, género) VALUES (:e_mail, :contraseña, :tipo, :nombres, :apellidos, :género)";
        $stmt = $conexion->prepare($query);
        return $stmt->execute([
            ':e_mail' => $this->e_mail,
            ':contraseña' => $this->contraseña,
            ':tipo' => $this->tipo,
            ':nombres' => $this->nombres,
            ':apellidos' =>$this->apellidos,
            ':género' =>$this->género
        ]);
    }

    public static function autenticar(string $e_mail, string $contraseña): ?Usuario
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM usuario WHERE e_mail = :e_mail";
        $stmt = $conexion->prepare($query);
        $stmt->execute([':e_mail' => $e_mail]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return new self((int) $usuario['id'], $usuario['e_mail'], $usuario['contraseña'], $usuario['tipo'], $nombres['nombres'], $apellidos['apellidos'], $género['género']);
        }

        return null;
    }
}
?>