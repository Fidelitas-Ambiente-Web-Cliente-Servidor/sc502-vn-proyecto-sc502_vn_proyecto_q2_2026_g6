<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class LoginController
{
    public function index()
    {
        $this->iniciarSesionPHP();

        if (isset($_SESSION['usuario'])) {
            header(
                'Location: index.php?controller=index&action=index'
            );
            exit;
        }

        require_once __DIR__ . '/../views/login.php';
    }

    public function iniciarSesion()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigirLogin();
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        if ($usuario === '' || $contrasena === '') {
            $this->redirigirLogin('campos');
        }

        $modelo = new UsuarioModel();

        $usuarioEncontrado = $modelo->buscarUsuario(
            $usuario,
            $contrasena
        );

        if (!$usuarioEncontrado) {
            $this->redirigirLogin('credenciales');
        }

        $this->iniciarSesionPHP();
        session_regenerate_id(true);

        $_SESSION['usuario'] = $usuarioEncontrado;

        header('Location: index.php?controller=index&action=index');
        exit;
    }

    public function cerrarSesion()
    {
        $this->iniciarSesionPHP();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parametros = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $parametros['path'],
                $parametros['domain'],
                $parametros['secure'],
                $parametros['httponly']
            );
        }

        session_destroy();

        header(
            'Location: index.php?controller=login&action=index&salida=1'
        );
        exit;
    }

    private function iniciarSesionPHP(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private function redirigirLogin(
        string $error = ''
    ): void {
        $url = 'index.php?controller=login&action=index';

        if ($error !== '') {
            $url .= '&error=' . urlencode($error);
        }

        header('Location: ' . $url);
        exit;
    }
}