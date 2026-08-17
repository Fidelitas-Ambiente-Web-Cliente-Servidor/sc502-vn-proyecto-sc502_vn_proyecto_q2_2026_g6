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

    public function obtenerRecursosParaMantenimiento(): array
    {
        $sql = "SELECT r.id_recurso, r.nombre, r.estado
                FROM recursos r
                WHERE r.cantidad > 0
                AND r.estado <> 'Prestado'
                AND NOT EXISTS (
                    SELECT 1
                    FROM mantenimientos m
                    WHERE m.id_recurso = r.id_recurso
                    AND m.estado IN ('En revisión', 'Fuera de servicio')
                )
                ORDER BY r.nombre";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function registrarMantenimiento(
        int $idRecurso,
        string $problema,
        string $fecha,
        string $estado
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $consultaRecurso = $this->conexion->prepare(
                'SELECT id_recurso
                 FROM recursos
                 WHERE id_recurso = :id_recurso
                 FOR UPDATE'
            );
            $consultaRecurso->execute([':id_recurso' => $idRecurso]);

            if (!$consultaRecurso->fetch()) {
                throw new RuntimeException('El recurso indicado no existe.');
            }

            $consultaActiva = $this->conexion->prepare(
                "SELECT COUNT(*)
                 FROM mantenimientos
                 WHERE id_recurso = :id_recurso
                 AND estado IN ('En revisión', 'Fuera de servicio')"
            );
            $consultaActiva->execute([':id_recurso' => $idRecurso]);

            if ((int) $consultaActiva->fetchColumn() > 0) {
                throw new RuntimeException(
                    'El recurso ya tiene un mantenimiento activo.'
                );
            }

            $consulta = $this->conexion->prepare(
                'INSERT INTO mantenimientos
                    (id_recurso, problema, fecha, estado)
                 VALUES
                    (:id_recurso, :problema, :fecha, :estado)'
            );
            $consulta->execute([
                ':id_recurso' => $idRecurso,
                ':problema' => $problema,
                ':fecha' => $fecha,
                ':estado' => $estado,
            ]);

            $estadoRecurso = $estado === 'Vencido'
                ? 'Vencido'
                : 'Mantenimiento';

            $this->actualizarEstadoRecurso($idRecurso, $estadoRecurso);
            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }

    public function actualizarEstado(
        int $idMantenimiento,
        string $estado
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $consulta = $this->conexion->prepare(
                'SELECT id_recurso
                 FROM mantenimientos
                 WHERE id_mantenimiento = :id_mantenimiento
                 FOR UPDATE'
            );
            $consulta->execute([
                ':id_mantenimiento' => $idMantenimiento
            ]);
            $mantenimiento = $consulta->fetch();

            if (!$mantenimiento) {
                throw new RuntimeException(
                    'El mantenimiento indicado no existe.'
                );
            }

            $actualizacion = $this->conexion->prepare(
                'UPDATE mantenimientos
                 SET estado = :estado
                 WHERE id_mantenimiento = :id_mantenimiento'
            );
            $actualizacion->execute([
                ':estado' => $estado,
                ':id_mantenimiento' => $idMantenimiento,
            ]);

            $idRecurso = (int) $mantenimiento['id_recurso'];

            if ($estado === 'Reparado') {
                $consultaActivos = $this->conexion->prepare(
                    "SELECT COUNT(*)
                     FROM mantenimientos
                     WHERE id_recurso = :id_recurso
                     AND estado IN ('En revisión', 'Fuera de servicio')"
                );
                $consultaActivos->execute([':id_recurso' => $idRecurso]);
                $estadoRecurso = (int) $consultaActivos->fetchColumn() > 0
                    ? 'Mantenimiento'
                    : 'Disponible';
            } elseif ($estado === 'Vencido') {
                $estadoRecurso = 'Vencido';
            } else {
                $estadoRecurso = 'Mantenimiento';
            }

            $this->actualizarEstadoRecurso($idRecurso, $estadoRecurso);
            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }

    private function actualizarEstadoRecurso(
        int $idRecurso,
        string $estado
    ): void {
        $consulta = $this->conexion->prepare(
            'UPDATE recursos
             SET estado = :estado
             WHERE id_recurso = :id_recurso'
        );
        $consulta->execute([
            ':estado' => $estado,
            ':id_recurso' => $idRecurso,
        ]);
    }
}
