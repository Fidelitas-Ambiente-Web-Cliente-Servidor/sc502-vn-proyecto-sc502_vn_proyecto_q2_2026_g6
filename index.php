<?php

$controller = $_GET['controller'] ?? 'index';
$action = $_GET['action'] ?? 'index';

switch ($controller) {

    case 'index':
        require_once __DIR__ . '/controllers/IndexController.php';
        $obj = new IndexController();
        break;

    case 'inventario':
        require_once __DIR__ . '/controllers/InventarioController.php';
        $obj = new InventarioController();
        break;

    case 'prestamos':
        require_once __DIR__ . '/controllers/PrestamosController.php';
        $obj = new PrestamosController();
        break;

    case 'mantenimiento':
        require_once __DIR__ . '/controllers/MantenimientoController.php';
        $obj = new MantenimientoController();
        break;

    case 'reportes':
        require_once __DIR__ . '/controllers/ReportesController.php';
        $obj = new ReportesController();
        break;

    case 'login':
        require_once __DIR__ . '/controllers/LoginController.php';
        $obj = new LoginController();
        break;

    default:
        require_once __DIR__ . '/controllers/IndexController.php';
        $obj = new IndexController();
        $action = 'index';
        break;
}

if (!method_exists($obj, $action)) {
    http_response_code(404);
    exit('La acción solicitada no existe.');
}

$obj->$action();