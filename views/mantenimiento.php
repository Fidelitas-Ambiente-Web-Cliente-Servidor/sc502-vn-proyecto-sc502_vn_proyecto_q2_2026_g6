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
            <a href="index.php?controller=index&action=index">Inicio</a>
            <a href="index.php?controller=inventario&action=index">Inventario</a>
            <a href="index.php?controller=prestamos&action=index">Préstamos</a>
            <a href="index.php?controller=mantenimiento&action=index" class="activo">Mantenimiento</a>
            <a href="index.php?controller=reportes&action=index">Reportes</a>
            <a href="index.php?controller=login&action=index">Iniciar Sesión</a>
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

                        <?php if (empty($mantenimientos)): ?>
                            <tr>
                                <td colspan="5">
                                    No hay mantenimientos registrados.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($mantenimientos as $mantenimiento): ?>
                                <tr>
                                    <td>
                                        <?= (int) $mantenimiento['id_mantenimiento'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $mantenimiento['equipo'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $mantenimiento['problema'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $mantenimiento['fecha'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $mantenimiento['estado'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>

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