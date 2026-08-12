<?php

require_once __DIR__ . '/../config/conexion.php';

class MantenimientoModel
{
    private PDO $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function obtenerMantenimientos(): array
    {
        $sql = "SELECT
                    m.id_mantenimiento,
                    m.id_recurso,
                    r.nombre AS equipo,
                    m.problema,
                    m.fecha,
                    m.estado
                FROM mantenimientos m
                INNER JOIN recursos r
                    ON m.id_recurso = r.id_recurso
                ORDER BY m.id_mantenimiento DESC";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }
}