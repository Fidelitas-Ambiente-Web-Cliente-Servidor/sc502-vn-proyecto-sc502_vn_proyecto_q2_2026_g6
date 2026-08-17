<?php

class Autenticacion
{
    public static function iniciarSesion(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function usuarioActual(): ?array
    {
        self::iniciarSesion();

        return $_SESSION['usuario'] ?? null;
    }

    public static function requerirSesion(): void
    {
        self::iniciarSesion();

        if (!isset($_SESSION['usuario'])) {
            header(
                'Location: index.php?controller=login&action=index'
            );
            exit;
        }
    }

    public static function esAdministrador(): bool
    {
        $usuario = self::usuarioActual();

        return $usuario !== null &&
            ($usuario['rol'] ?? '') === 'Administrador';
    }
}