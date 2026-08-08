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
            <a href="index.php?controller=index&action=index">Inicio</a>
            <a href="index.php?controller=inventario&action=index">Inventario</a>
            <a href="index.php?controller=prestamos&action=index">Préstamos</a>
            <a href="index.php?controller=mantenimiento&action=index">Mantenimiento</a>
            <a href="index.php?controller=reportes&action=index">Reportes</a>
            <a href="index.php?controller=login&action=index" class="activo">Iniciar Sesión</a>
        </nav>
    </header>
    <div class="banner">
        <section class="login-box">
            <h2>Inicio de Sesión</h2>
            <form action="index.php?controller=login&action=iniciarSesion" method="POST">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                <button type="submit">Ingresar</button>
                <button type="reset" class="secundario">Cancelar</button>
            </form>
        </section>
    </div>
    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>
    <script src="js/login.js"></script>
</body>
</html>