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
        $sql = "
            SELECT
                COUNT(*) AS total_recursos,
                SUM(CASE WHEN estado = 'Disponible' THEN 1 ELSE 0 END) AS disponibles,
                SUM(CASE WHEN estado = 'Prestado' THEN 1 ELSE 0 END) AS prestados,
                SUM(CASE WHEN estado = 'Mantenimiento' THEN 1 ELSE 0 END) AS en_mantenimiento
            FROM recursos
        ";

        $stmt = $this->conexion->query($sql);
        $resultado = $stmt->fetch();

        return [
            'total_recursos' => (int) ($resultado['total_recursos'] ?? 0),
            'disponibles' => (int) ($resultado['disponibles'] ?? 0),
            'prestados' => (int) ($resultado['prestados'] ?? 0),
            'en_mantenimiento' => (int) ($resultado['en_mantenimiento'] ?? 0),
        ];
    }

    public function obtenerResumenCategorias(): array
    {
        $sql = "
            SELECT
                c.nombre AS categoria,
                COUNT(r.id_recurso) AS total,
                SUM(CASE WHEN r.estado = 'Disponible' THEN 1 ELSE 0 END) AS disponible,
                SUM(CASE WHEN r.estado = 'Prestado' THEN 1 ELSE 0 END) AS prestado,
                SUM(CASE WHEN r.estado = 'Mantenimiento' THEN 1 ELSE 0 END) AS mantenimiento
            FROM categorias c
            LEFT JOIN recursos r ON r.id_categoria = c.id_categoria
            GROUP BY c.id_categoria, c.nombre
            ORDER BY c.nombre ASC
        ";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll();
    }
}
