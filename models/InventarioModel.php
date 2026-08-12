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

    public function obtenerRecursos(): array
    {
        $sql = "SELECT
                    r.id_recurso,
                    r.nombre,
                    r.cantidad,
                    r.id_categoria,
                    c.nombre AS categoria,
                    r.estado
                FROM recursos r
                INNER JOIN categorias c
                    ON r.id_categoria = c.id_categoria
                ORDER BY r.id_recurso DESC";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function obtenerCategorias(): array
    {
        $sql = "SELECT id_categoria, nombre
                FROM categorias
                ORDER BY nombre";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function obtenerRecursoPorId(int $idRecurso)
    {
        $sql = "SELECT
                    id_recurso,
                    nombre,
                    cantidad,
                    id_categoria,
                    estado
                FROM recursos
                WHERE id_recurso = :id_recurso";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_recurso' => $idRecurso
        ]);

        return $consulta->fetch();
    }

    public function registrarRecurso(
        string $nombre,
        int $cantidad,
        int $idCategoria,
        string $estado
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $sql = "INSERT INTO recursos
                        (nombre, cantidad, id_categoria, estado)
                    VALUES
                        (:nombre, :cantidad, :id_categoria, :estado)";

            $consulta = $this->conexion->prepare($sql);

            $consulta->execute([
                ':nombre' => $nombre,
                ':cantidad' => $cantidad,
                ':id_categoria' => $idCategoria,
                ':estado' => $estado
            ]);

            $idRecurso = (int) $this->conexion->lastInsertId();

            if ($estado === 'Mantenimiento') {
                $this->registrarMantenimientoAutomatico($idRecurso);
            }

            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }

    public function actualizarRecurso(
        int $idRecurso,
        string $nombre,
        int $cantidad,
        int $idCategoria,
        string $estado
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $sql = "UPDATE recursos
                    SET nombre = :nombre,
                        cantidad = :cantidad,
                        id_categoria = :id_categoria,
                        estado = :estado
                    WHERE id_recurso = :id_recurso";

            $consulta = $this->conexion->prepare($sql);

            $consulta->execute([
                ':id_recurso' => $idRecurso,
                ':nombre' => $nombre,
                ':cantidad' => $cantidad,
                ':id_categoria' => $idCategoria,
                ':estado' => $estado
            ]);

            if (
                $estado === 'Mantenimiento' &&
                !$this->tieneMantenimientoActivo($idRecurso)
            ) {
                $this->registrarMantenimientoAutomatico($idRecurso);
            }

            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }

    public function eliminarRecurso(int $idRecurso): bool
    {
        $sql = "DELETE FROM recursos
                WHERE id_recurso = :id_recurso";

        $consulta = $this->conexion->prepare($sql);

        return $consulta->execute([
            ':id_recurso' => $idRecurso
        ]);
    }

    private function tieneMantenimientoActivo(int $idRecurso): bool
    {
        $sql = "SELECT COUNT(*)
                FROM mantenimientos
                WHERE id_recurso = :id_recurso
                AND estado = 'En revisión'";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_recurso' => $idRecurso
        ]);

        return (int) $consulta->fetchColumn() > 0;
    }

   private function registrarMantenimientoAutomatico(
    int $idRecurso
): void {
    $sql = "INSERT INTO mantenimientos
                (id_recurso, problema, fecha, estado)
            SELECT
                id_recurso,
                CONCAT(nombre, ' en mantenimiento'),
                CURDATE(),
                'En revisión'
            FROM recursos
            WHERE id_recurso = :id_recurso";

    $consulta = $this->conexion->prepare($sql);

    $consulta->execute([
        ':id_recurso' => $idRecurso
    ]);
}}
