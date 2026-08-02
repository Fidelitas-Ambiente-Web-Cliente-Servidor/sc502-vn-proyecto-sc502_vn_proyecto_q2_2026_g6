<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="css/reportes.css">
</head>

<body>

    <header>
        <h1>Sistema de Inventario</h1>

        <nav>
            <a href="index.php?controller=index&action=index">Inicio</a>
            <a href="index.php?controller=inventario&action=index">Inventario</a>
            <a href="index.php?controller=prestamos&action=index">Préstamos</a>
            <a href="index.php?controller=mantenimiento&action=index">Mantenimiento</a>
            <a href="index.php?controller=reportes&action=index" class="activo">Reportes</a>
            <a href="index.php?controller=login&action=index">Iniciar Sesión</a>
        </nav>
    </header>

    <div class="banner">

        <section class="titulo">
            <h2>Reportes del Sistema</h2>
            <p>Resumen general de inventario, préstamos y mantenimientos.</p>
        </section>

        <section class="cards">
            <div class="card">
                <h3>Total Recursos</h3>
                <p>125</p>
            </div>

            <div class="card">
                <h3>Disponibles</h3>
                <p>87</p>
            </div>

            <div class="card">
                <h3>Prestados</h3>
                <p>21</p>
            </div>

            <div class="card">
                <h3>Mantenimiento</h3>
                <p>17</p>
            </div>
        </section>

        <section class="contenedor">

            <div class="tabla">
                <h3>Reporte General</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Total</th>
                            <th>Disponible</th>
                            <th>Prestado</th>
                            <th>Mantenimiento</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Equipo Médico</td>
                            <td>45</td>
                            <td>30</td>
                            <td>10</td>
                            <td>5</td>
                        </tr>

                        <tr>
                            <td>Equipo de Rescate</td>
                            <td>35</td>
                            <td>25</td>
                            <td>5</td>
                            <td>5</td>
                        </tr>

                        <tr>
                            <td>Insumos</td>
                            <td>45</td>
                            <td>32</td>
                            <td>6</td>
                            <td>7</td>
                        </tr>
                    </tbody>
                </table>

                <div class="botones">
                    <button>Exportar PDF</button>
                    <button>Exportar Excel</button>
                    <button>Imprimir</button>
                </div>

            </div>

        </section>

    </div>

    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>
    <script src="js/reportes.js"></script>
</body>

</html>
