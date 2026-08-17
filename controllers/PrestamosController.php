<?php

require_once __DIR__ . '/../models/PrestamoModel.php';
require_once __DIR__ . '/../config/Autenticacion.php';

class PrestamosController
{
    private PrestamoModel $modelo;

    public function __construct()
    {
        Autenticacion::requerirSesion();

        $this->modelo = new PrestamoModel();
    }

    public function index()
    {
        $prestamos = $this->modelo->obtenerPrestamos();
        $recursos = $this->modelo->obtenerRecursosDisponibles();
        $usuarios = $this->modelo->obtenerUsuarios();
        $usuario = Autenticacion::usuarioActual();

        require_once __DIR__ . '/../views/prestamos.php';
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $idRecurso = filter_var(
            $_POST['id_recurso'] ?? null,
            FILTER_VALIDATE_INT
        );

        $idUsuario = filter_var(
            $_POST['id_usuario'] ?? null,
            FILTER_VALIDATE_INT
        );

        $fechaPrestamo = trim($_POST['fecha_prestamo'] ?? '');

        if (
            $idRecurso === false ||
            $idRecurso <= 0 ||
            $idUsuario === false ||
            $idUsuario <= 0 ||
            !$this->fechaValida($fechaPrestamo)
        ) {
            $this->redirigir(
                'Complete correctamente todos los campos.',
                'error'
            );
        }

        try {
            $this->modelo->registrarPrestamo(
                $idRecurso,
                $idUsuario,
                $fechaPrestamo
            );

            $this->redirigir(
                'Préstamo registrado correctamente.',
                'exito'
            );
        } catch (RuntimeException $error) {
            $this->redirigir($error->getMessage(), 'error');
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible registrar el préstamo.',
                'error'
            );
        }
    }

    public function devolver()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $idPrestamo = filter_var(
            $_POST['id_prestamo'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($idPrestamo === false || $idPrestamo <= 0) {
            $this->redirigir('El préstamo indicado no es válido.', 'error');
        }

        try {
            $this->modelo->devolverPrestamo($idPrestamo);

            $this->redirigir(
                'Recurso devuelto correctamente.',
                'exito'
            );
        } catch (RuntimeException $error) {
            $this->redirigir($error->getMessage(), 'error');
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible registrar la devolución.',
                'error'
            );
        }
    }

    private function fechaValida(string $fecha): bool
    {
        $fechaConvertida = DateTime::createFromFormat(
            'Y-m-d',
            $fecha
        );

        return $fechaConvertida !== false &&
            $fechaConvertida->format('Y-m-d') === $fecha;
    }

    private function redirigir(string $mensaje, string $tipo): void
    {
        $url = 'index.php?controller=prestamos&action=index';
        $url .= '&tipo=' . urlencode($tipo);
        $url .= '&mensaje=' . urlencode($mensaje);

        header('Location: ' . $url);
        exit;
    }
}
