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

        require_once __DIR__ . '/../views/mantenimiento.php';
    }
}