<?php
require_once __DIR__ . '/../config/conexion.php';

class UsuarioModel
{
    private PDO $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function buscarUsuario(string $usuario, string $contrasena)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND contrasena = :contrasena";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':usuario' => $usuario,
            ':contrasena' => $contrasena
        ]);

        return $stmt->fetch();
    }
}