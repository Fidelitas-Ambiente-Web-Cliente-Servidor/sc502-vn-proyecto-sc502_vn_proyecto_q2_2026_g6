<?php

require_once __DIR__ . '/../models/ReportesModel.php';
require_once __DIR__ . '/../config/Autenticacion.php';

class ReportesController
{
    private ReportesModel $modelo;

    public function __construct()
    {
        Autenticacion::requerirSesion();

        $this->modelo = new ReportesModel();
    }

    public function index()
    {
        $totales = $this->modelo->obtenerTotales();

        $resumenCategorias = $this->modelo
            ->obtenerResumenPorCategoria();

        require_once __DIR__ . '/../views/reportes.php';
    }
}