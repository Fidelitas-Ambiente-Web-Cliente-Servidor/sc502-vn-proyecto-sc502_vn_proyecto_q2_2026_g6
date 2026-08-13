<?php
require_once __DIR__ . '/../models/ReportesModel.php';

class ReportesController
{
    public function index()
    {
        $modelo = new ReportesModel();
        $totales = $modelo->obtenerTotales();
        $resumenCategorias = $modelo->obtenerResumenCategorias();

        require_once __DIR__ . '/../views/reportes.php';
    }
}