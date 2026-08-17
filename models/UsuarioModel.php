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

    public function buscarUsuario(
        string $usuario,
        string $contrasena
    ) {
        $sql = "SELECT
                    id_usuario,
                    usuario,
                    contrasena,
                    nombre,
                    rol
                FROM usuarios
                WHERE usuario = :usuario";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':usuario' => $usuario
        ]);

        $usuarioEncontrado = $consulta->fetch();

        if (!$usuarioEncontrado) {
            return false;
        }

        if (
            !password_verify(
                $contrasena,
                $usuarioEncontrado['contrasena']
            )
        ) {
            return false;
        }

        unset($usuarioEncontrado['contrasena']);

        return $usuarioEncontrado;
    }

    public function registrarUsuario(
        string $usuario,
        string $contrasena,
        string $nombre,
        string $rol
    ): bool {
        $sql = "INSERT INTO usuarios
                    (usuario, contrasena, nombre, rol)
                VALUES
                    (:usuario, :contrasena, :nombre, :rol)";

        $consulta = $this->conexion->prepare($sql);

        return $consulta->execute([
            ':usuario' => $usuario,
            ':contrasena' => password_hash(
                $contrasena,
                PASSWORD_DEFAULT
            ),
            ':nombre' => $nombre,
            ':rol' => $rol
        ]);
    }
}