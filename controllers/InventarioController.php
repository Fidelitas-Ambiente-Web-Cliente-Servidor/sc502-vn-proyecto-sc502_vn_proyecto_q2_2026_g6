<?php
require_once __DIR__ . '/../models/InventarioModel.php';

class InventarioController
{
    public function index()
    {
        $modelo = new InventarioModel();

        $categorias = $modelo->obtenerCategorias();
        if (count($categorias) === 0) {
            $modelo->crearCategoriasPorDefecto();
            $categorias = $modelo->obtenerCategorias();
        }

        $recursos = $modelo->listarRecursos();
        $mensaje = $_GET['success'] ?? null;
        $error = $_GET['error'] ?? null;

        require_once __DIR__ . '/../views/inventario.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=inventario&action=index&error=1');
            exit;
        }

        $modelo = new InventarioModel();
        $guardado = $modelo->guardarRecurso($_POST);

        if ($guardado) {
            header('Location: index.php?controller=inventario&action=index&success=1');
            exit;
        }

        header('Location: index.php?controller=inventario&action=index&error=1');
        exit;
    }

    public function eliminar()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $modelo = new InventarioModel();
            $modelo->eliminarRecurso($id);
        }

        header('Location: index.php?controller=inventario&action=index&success=1');
        exit;
    }
}