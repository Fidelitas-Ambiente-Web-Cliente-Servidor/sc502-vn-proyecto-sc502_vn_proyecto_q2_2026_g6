<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <div class="banner">
        <header>
            <h1>Sistema de Inventario</h1>

            <nav>
                <a href="index.php?controller=index&action=index" class="activo">Inicio</a>
                <a href="index.php?controller=inventario&action=index">Inventario</a>
                <a href="index.php?controller=prestamos&action=index">Préstamos</a>
                <a href="index.php?controller=mantenimiento&action=index">Mantenimiento</a>
                <a href="index.php?controller=reportes&action=index">Reportes</a>
                <a href="index.php?controller=login&action=index">Iniciar Sesión</a>
            </nav>
        </header>

        <section class="inicio">
            <h2>Gestión Integral de Recursos Operativos</h2>

            <p>
                Sistema web para el control de equipos médicos, recursos de rescate,
                mantenimientos, préstamos y reportes institucionales.
            </p>

            <a href="inventario.html">
                <button>Explorar Sistema</button>
            </a>
        </section>

        <section class="contenedor">

            <div class="tarjeta">
                <h3>Inventario</h3>
                <p>Registro y control de equipos e insumos.</p>
            </div>

            <div class="tarjeta">
                <h3>Préstamos</h3>
                <p>Control de préstamos y devoluciones.</p>
            </div>

            <div class="tarjeta">
                <h3>Mantenimiento</h3>
                <p>Seguimiento de equipos dañados o vencidos.</p>
            </div>

            <div class="tarjeta">
                <h3>Reportes</h3>
                <p>Consulta de datos importantes del sistema.</p>
            </div>
        </section>
    </div>

    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>
<script src="js/index.js"></script>
</body>

</html>
