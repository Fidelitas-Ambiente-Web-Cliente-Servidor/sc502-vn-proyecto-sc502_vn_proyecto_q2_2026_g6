<?php
require_once __DIR__ . '/../config/conexion.php';

class InventarioModel
{
    private PDO $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function crearCategoriasPorDefecto(): void
    {
        $categorias = [
            'Equipo Médico',
            'Equipo de Rescate',
            'Insumo Médico',
            'Equipo de Protección Personal',
            'Comunicaciones'
        ];

        foreach ($categorias as $nombre) {
            $sql = "INSERT INTO categorias (nombre) VALUES (:nombre) ON DUPLICATE KEY UPDATE nombre = nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);
        }
    }

    public function obtenerCategorias(): array
    {
        $sql = "SELECT * FROM categorias ORDER BY nombre ASC";
        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll();
    }

    public function listarRecursos(): array
    {
        $sql = "
            SELECT r.*, c.nombre AS categoria
            FROM recursos r
            INNER JOIN categorias c ON c.id_categoria = r.id_categoria
            ORDER BY r.id_recurso DESC
        ";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll();
    }

    public function guardarRecurso(array $datos): bool
    {
        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $cantidad = (int) ($datos['cantidad'] ?? 0);
        $idCategoria = (int) ($datos['id_categoria'] ?? 0);
        $estado = trim((string) ($datos['estado'] ?? 'Disponible'));

        if ($nombre === '' || $idCategoria <= 0 || $cantidad < 0) {
            return false;
        }

        $sql = "
            INSERT INTO recursos (nombre, cantidad, id_categoria, estado)
            VALUES (:nombre, :cantidad, :id_categoria, :estado)
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':cantidad' => $cantidad,
            ':id_categoria' => $idCategoria,
            ':estado' => $estado,
        ]);
    }

    public function eliminarRecurso(int $id): bool
    {
        $sql = "DELETE FROM recursos WHERE id_recurso = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
