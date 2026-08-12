<?php

require_once __DIR__ . '/../config/conexion.php';

class ReportesModel
{
    private PDO $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function obtenerTotales(): array
    {
        $sql = "SELECT
                    COALESCE(SUM(r.cantidad), 0) +
                    (
                        SELECT COUNT(*)
                        FROM prestamos
                        WHERE estado = 'Prestado'
                    ) AS total_recursos,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Disponible'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS disponibles,

                    (
                        SELECT COUNT(*)
                        FROM prestamos
                        WHERE estado = 'Prestado'
                    ) AS prestados,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Mantenimiento'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS mantenimiento,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Vencido'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS vencidos
                FROM recursos r";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetch();
    }

    public function obtenerResumenPorCategoria(): array
    {
        $sql = "SELECT
                    c.nombre AS categoria,

                    COALESCE(SUM(r.cantidad), 0) +
                    COALESCE(SUM(pa.cantidad_prestada), 0)
                        AS total,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Disponible'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS disponibles,

                    COALESCE(SUM(pa.cantidad_prestada), 0)
                        AS prestados,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Mantenimiento'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS mantenimiento,

                    COALESCE(
                        SUM(
                            CASE
                                WHEN r.estado = 'Vencido'
                                THEN r.cantidad
                                ELSE 0
                            END
                        ),
                        0
                    ) AS vencidos

                FROM categorias c

                LEFT JOIN recursos r
                    ON r.id_categoria = c.id_categoria

                LEFT JOIN (
                    SELECT
                        id_recurso,
                        COUNT(*) AS cantidad_prestada
                    FROM prestamos
                    WHERE estado = 'Prestado'
                    GROUP BY id_recurso
                ) pa
                    ON pa.id_recurso = r.id_recurso

                GROUP BY c.id_categoria, c.nombre
                ORDER BY c.nombre";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }
}