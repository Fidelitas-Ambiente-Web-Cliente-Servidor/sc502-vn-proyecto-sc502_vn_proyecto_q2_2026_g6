<?php

require_once __DIR__ . '/../models/InventarioModel.php';
require_once __DIR__ . '/../config/Autenticacion.php';

class InventarioController
{
    private InventarioModel $modelo;

    public function __construct()
    {
        Autenticacion::requerirSesion();

        $this->modelo = new InventarioModel();
    }

    public function index()
    {
        $recursos = $this->modelo->obtenerRecursos();
        $categorias = $this->modelo->obtenerCategorias();
        $recursoEditar = null;
        $usuario = Autenticacion::usuarioActual();

        $idEditar = filter_var(
            $_GET['editar'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($idEditar !== false && $idEditar !== null) {
            $recursoEditar = $this->modelo->obtenerRecursoPorId($idEditar);
        }

        require_once __DIR__ . '/../views/inventario.php';
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $cantidad = filter_var(
            $_POST['cantidad'] ?? null,
            FILTER_VALIDATE_INT
        );
        $idCategoria = filter_var(
            $_POST['id_categoria'] ?? null,
            FILTER_VALIDATE_INT
        );
        $estado = trim($_POST['estado'] ?? '');

        if (
            $nombre === '' ||
            $cantidad === false ||
            $cantidad < 0 ||
            $idCategoria === false ||
            $idCategoria <= 0 ||
            !$this->estadoValido($estado)
        ) {
            $this->redirigir(
                'Complete correctamente todos los campos.',
                'error'
            );
        }

        try {
            $this->modelo->registrarRecurso(
                $nombre,
                $cantidad,
                $idCategoria,
                $estado
            );
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible registrar el recurso.',
                'error'
            );
        }

        $this->redirigir('Recurso registrado correctamente.', 'exito');
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $idRecurso = filter_var(
            $_POST['id_recurso'] ?? null,
            FILTER_VALIDATE_INT
        );
        $nombre = trim($_POST['nombre'] ?? '');
        $cantidad = filter_var(
            $_POST['cantidad'] ?? null,
            FILTER_VALIDATE_INT
        );
        $idCategoria = filter_var(
            $_POST['id_categoria'] ?? null,
            FILTER_VALIDATE_INT
        );
        $estado = trim($_POST['estado'] ?? '');

        if (
            $idRecurso === false ||
            $idRecurso <= 0 ||
            $nombre === '' ||
            $cantidad === false ||
            $cantidad < 0 ||
            $idCategoria === false ||
            $idCategoria <= 0 ||
            !$this->estadoValido($estado)
        ) {
            $this->redirigir(
                'Los datos enviados no son válidos.',
                'error'
            );
        }

        try {
            $this->modelo->actualizarRecurso(
                $idRecurso,
                $nombre,
                $cantidad,
                $idCategoria,
                $estado
            );
        } catch (Throwable $error) {
            $this->redirigir(
                'No fue posible actualizar el recurso.',
                'error'
            );
        }

        $this->redirigir('Recurso actualizado correctamente.', 'exito');
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('Solicitud no permitida.', 'error');
        }

        $idRecurso = filter_var(
            $_POST['id_recurso'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($idRecurso === false || $idRecurso <= 0) {
            $this->redirigir('El recurso indicado no es válido.', 'error');
        }

        try {
            $this->modelo->eliminarRecurso($idRecurso);
            $this->redirigir('Recurso eliminado correctamente.', 'exito');
        } catch (PDOException $error) {
            $this->redirigir(
                'No se puede eliminar porque tiene préstamos o mantenimientos asociados.',
                'error'
            );
        }
    }

    private function estadoValido(string $estado): bool
    {
        $estadosPermitidos = [
            'Disponible',
            'En uso',
            'Prestado',
            'Mantenimiento',
            'Vencido'
        ];

        return in_array($estado, $estadosPermitidos, true);
    }

    private function redirigir(string $mensaje, string $tipo): void
    {
        $url = 'index.php?controller=inventario&action=index';
        $url .= '&tipo=' . urlencode($tipo);
        $url .= '&mensaje=' . urlencode($mensaje);

        header('Location: ' . $url);
        exit;
    }
}
