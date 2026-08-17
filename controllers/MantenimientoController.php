<?php

require_once __DIR__ . '/../models/MantenimientoModel.php';
require_once __DIR__ . '/../config/Autenticacion.php';

class MantenimientoController
{
    private MantenimientoModel $modelo;

    public function __construct()
    {
        Autenticacion::requerirSesion();

        $this->modelo = new MantenimientoModel();
    }

    public function index()
    {
        $mantenimientos = $this->modelo->obtenerMantenimientos();
        $recursos = $this->modelo->obtenerRecursosParaMantenimiento();
        $usuario = Autenticacion::usuarioActual();

        require_once __DIR__ . '/../views/mantenimiento.php';
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
        $problema = trim($_POST['problema'] ?? '');
        $fecha = trim($_POST['fecha'] ?? '');
        $estado = trim($_POST['estado'] ?? '');

        if (
            $idRecurso === false ||
            $idRecurso <= 0 ||
            $problema === '' ||
            strlen($problema) > 255 ||
            !$this->fechaValida($fecha) ||
            !in_array(
                $estado,
                ['En revisión', 'Fuera de servicio', 'Vencido'],
                true
            )
        ) {
            $this->redirigir(
                'Complete correctamente todos los campos.',
                'error'
            );
        }

        try {
            $this->modelo->registrarMantenimiento(
                $idRecurso,
                $problema,
                $fecha,
                $estado
            );
            $this->redirigir(
                'Mantenimiento registrado correctamente.',
                'exito'
            );
        } catch (RuntimeException $error) {
            $this->redirigir($error->getMessage(), 'error');
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible registrar el mantenimiento.',
                'error'
            );
        }
    }

    public function actualizarEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $idMantenimiento = filter_var(
            $_POST['id_mantenimiento'] ?? null,
            FILTER_VALIDATE_INT
        );
        $estado = trim($_POST['estado'] ?? '');

        if (
            $idMantenimiento === false ||
            $idMantenimiento <= 0 ||
            !in_array(
                $estado,
                ['En revisión', 'Reparado', 'Fuera de servicio', 'Vencido'],
                true
            )
        ) {
            $this->redirigir('Los datos enviados no son válidos.', 'error');
        }

        try {
            $this->modelo->actualizarEstado(
                $idMantenimiento,
                $estado
            );
            $this->redirigir(
                'Estado actualizado correctamente.',
                'exito'
            );
        } catch (RuntimeException $error) {
            $this->redirigir($error->getMessage(), 'error');
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible actualizar el mantenimiento.',
                'error'
            );
        }
    }

    private function fechaValida(string $fecha): bool
    {
        $fechaConvertida = DateTime::createFromFormat('Y-m-d', $fecha);

        return $fechaConvertida !== false &&
            $fechaConvertida->format('Y-m-d') === $fecha;
    }

    private function redirigir(string $mensaje, string $tipo): void
    {
        $url = 'index.php?controller=mantenimiento&action=index';
        $url .= '&tipo=' . urlencode($tipo);
        $url .= '&mensaje=' . urlencode($mensaje);

        header('Location: ' . $url);
        exit;
    }
}
