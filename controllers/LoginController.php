<?php
require_once __DIR__ . '/../models/UsuarioModel.php';

class LoginController
{
    public function index()
    {
        require_once __DIR__ . '/../views/login.php';
    }

    public function iniciarSesion()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=login&action=index');
            exit;
        }

        $usuario = $_POST['usuario'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        $modelo = new UsuarioModel();
        $usuarioEncontrado = $modelo->buscarUsuario($usuario, $contrasena);

        if ($usuarioEncontrado) {
            session_start();
            $_SESSION['usuario'] = $usuarioEncontrado;

            header('Location: index.php?controller=index&action=index');
            exit;
        }

        header('Location: index.php?controller=login&action=index&error=1');
        exit;
    }
}