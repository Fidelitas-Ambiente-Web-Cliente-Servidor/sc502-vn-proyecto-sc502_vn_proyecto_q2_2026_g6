<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <link rel="stylesheet" href="css/mantenimiento.css">
</head>

<body>

    <header>
        <h1>Sistema de Inventario</h1>

        <nav>
            <a href="index.html">Inicio</a>
            <a href="inventario.html">Inventario</a>
            <a href="prestamos.html">Préstamos</a>
            <a href="mantenimiento.html" class="activo">Mantenimiento</a>
            <a href="reportes.html">Reportes</a>
            <a href="login.html">Iniciar Sesión</a>
        </nav>
    </header>

    <div class="banner">

        <section class="titulo">
            <h2>Mantenimiento de Equipos</h2>
            <p>Registro de equipos dañados, vencidos o en revisión.</p>
        </section>

        <section class="contenedor">

            <div class="formulario">
                <h3>Registrar Mantenimiento</h3>

                <input type="text" placeholder="Nombre del equipo">
                <input type="text" placeholder="Detalle del problema">
                <input type="date">

                <select>
                    <option>En revisión</option>
                    <option>Reparado</option>
                    <option>Fuera de servicio</option>
                    <option>Vencido</option>
                </select>

                <button>Guardar mantenimiento</button>
            </div>

            <div class="tabla">
                <h3>Equipos en Mantenimiento</h3>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Equipo</th>
                            <th>Problema</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Botiquín</td>
                            <td>Revisión de insumos vencidos</td>
                            <td>2026-07-01</td>
                            <td>En revisión</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </section>

    </div>

    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>
<script src="js/mantenimiento.js"></script>
</body>

</html>
