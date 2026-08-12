<?php

require_once __DIR__ . '/../config/conexion.php';

class PrestamoModel
{
    private PDO $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function obtenerPrestamos(): array
    {
        $sql = "SELECT
                    p.id_prestamo,
                    r.nombre AS recurso,
                    u.nombre AS responsable,
                    p.fecha_prestamo,
                    p.fecha_devolucion,
                    p.estado
                FROM prestamos p
                INNER JOIN recursos r
                    ON p.id_recurso = r.id_recurso
                INNER JOIN usuarios u
                    ON p.id_usuario = u.id_usuario
                ORDER BY p.id_prestamo DESC";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function obtenerRecursosDisponibles(): array
    {
        $sql = "SELECT id_recurso, nombre, cantidad
                FROM recursos
                WHERE cantidad > 0
                AND estado = 'Disponible'
                ORDER BY nombre";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function obtenerUsuarios(): array
    {
        $sql = "SELECT id_usuario, nombre, rol
                FROM usuarios
                ORDER BY nombre";

        $consulta = $this->conexion->query($sql);

        return $consulta->fetchAll();
    }

    public function registrarPrestamo(
        int $idRecurso,
        int $idUsuario,
        string $fechaPrestamo
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $sqlRecurso = "SELECT cantidad, estado
                           FROM recursos
                           WHERE id_recurso = :id_recurso
                           FOR UPDATE";

            $consultaRecurso = $this->conexion->prepare($sqlRecurso);

            $consultaRecurso->execute([
                ':id_recurso' => $idRecurso
            ]);

            $recurso = $consultaRecurso->fetch();

            if (
                !$recurso ||
                (int) $recurso['cantidad'] <= 0 ||
                $recurso['estado'] !== 'Disponible'
            ) {
                throw new RuntimeException(
                    'El recurso seleccionado no está disponible.'
                );
            }

            $sqlPrestamo = "INSERT INTO prestamos
                                (
                                    id_recurso,
                                    id_usuario,
                                    fecha_prestamo,
                                    fecha_devolucion,
                                    estado
                                )
                            VALUES
                                (
                                    :id_recurso,
                                    :id_usuario,
                                    :fecha_prestamo,
                                    NULL,
                                    'Prestado'
                                )";

            $consultaPrestamo = $this->conexion->prepare($sqlPrestamo);

            $consultaPrestamo->execute([
                ':id_recurso' => $idRecurso,
                ':id_usuario' => $idUsuario,
                ':fecha_prestamo' => $fechaPrestamo
            ]);

            $nuevaCantidad = (int) $recurso['cantidad'] - 1;

            $nuevoEstado = $nuevaCantidad === 0
                ? 'Prestado'
                : 'Disponible';

            $sqlInventario = "UPDATE recursos
                              SET cantidad = :cantidad,
                                  estado = :estado
                              WHERE id_recurso = :id_recurso";

            $consultaInventario = $this->conexion->prepare($sqlInventario);

            $consultaInventario->execute([
                ':cantidad' => $nuevaCantidad,
                ':estado' => $nuevoEstado,
                ':id_recurso' => $idRecurso
            ]);

            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }

    public function devolverPrestamo(int $idPrestamo): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sqlPrestamo = "SELECT id_recurso, estado
                            FROM prestamos
                            WHERE id_prestamo = :id_prestamo
                            FOR UPDATE";

            $consultaPrestamo = $this->conexion->prepare($sqlPrestamo);

            $consultaPrestamo->execute([
                ':id_prestamo' => $idPrestamo
            ]);

            $prestamo = $consultaPrestamo->fetch();

            if (!$prestamo || $prestamo['estado'] !== 'Prestado') {
                throw new RuntimeException(
                    'El préstamo ya fue devuelto o no existe.'
                );
            }

            $sqlDevolucion = "UPDATE prestamos
                              SET fecha_devolucion = CURDATE(),
                                  estado = 'Devuelto'
                              WHERE id_prestamo = :id_prestamo";

            $consultaDevolucion = $this->conexion->prepare(
                $sqlDevolucion
            );

            $consultaDevolucion->execute([
                ':id_prestamo' => $idPrestamo
            ]);

            $sqlInventario = "UPDATE recursos
                              SET cantidad = cantidad + 1,
                                  estado = 'Disponible'
                              WHERE id_recurso = :id_recurso";

            $consultaInventario = $this->conexion->prepare($sqlInventario);

            $consultaInventario->execute([
                ':id_recurso' => $prestamo['id_recurso']
            ]);

            $this->conexion->commit();

            return true;
        } catch (Throwable $error) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $error;
        }
    }
}