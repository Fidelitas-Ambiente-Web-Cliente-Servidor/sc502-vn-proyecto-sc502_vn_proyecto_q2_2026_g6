<?php
class IndexController
{
    public function index()
    {
        session_start();

        $usuario = $_SESSION['usuario'] ?? null;

        require_once __DIR__ . '/../views/index.php';
    }
}