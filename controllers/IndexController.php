<?php
require_once __DIR__ . '/../config/Autenticacion.php';

class IndexController
{
    public function index()
    {
        $usuario = Autenticacion::usuarioActual();

        require_once __DIR__ . '/../views/index.php';
    }
}
