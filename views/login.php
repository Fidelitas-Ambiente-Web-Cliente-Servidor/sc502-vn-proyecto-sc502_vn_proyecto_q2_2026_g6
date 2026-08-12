<?php

$error = $_GET['error'] ?? '';
$salida = isset($_GET['salida']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <header>
        <h1>Sistema de Inventario</h1>

        <nav>
            <a href="index.php?controller=index&action=index">
                Inicio
            </a>
            <a
                href="index.php?controller=login&action=index"
                class="activo"
            >
                Iniciar Sesión
            </a>
        </nav>
    </header>

    <div class="banner">

        <section class="login-box">
            <h2>Inicio de Sesión</h2>

            <?php if ($error === 'credenciales'): ?>
                <div class="mensaje error">
                    El usuario o la contraseña son incorrectos.
                </div>
            <?php endif; ?>

            <?php if ($error === 'campos'): ?>
                <div class="mensaje error">
                    Debe completar todos los campos.
                </div>
            <?php endif; ?>

            <?php if ($salida): ?>
                <div class="mensaje exito">
                    La sesión se cerró correctamente.
                </div>
            <?php endif; ?>

            <form
                action="index.php?controller=login&action=iniciarSesion"
                method="POST"
            >
                <label for="usuario">Usuario</label>
                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    maxlength="50"
                    autocomplete="username"
                    placeholder="Ingrese su usuario"
                    required
                >

                <label for="contrasena">Contraseña</label>
                <input
                    type="password"
                    id="contrasena"
                    name="contrasena"
                    autocomplete="current-password"
                    placeholder="Ingrese su contraseña"
                    required
                >

                <button type="submit">
                    Ingresar
                </button>

                <button type="reset" class="secundario">
                    Limpiar
                </button>
            </form>
        </section>

    </div>

    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>

    <script src="js/login.js"></script>
</body>

</html>