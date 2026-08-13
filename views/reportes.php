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
                <p><?= (int) $totales['total_recursos'] ?></p>
            </div>

            <div class="card">
                <h3>Disponibles</h3>
                <p><?= (int) $totales['disponibles'] ?></p>
            </div>

            <div class="card">
                <h3>Prestados</h3>
                <p><?= (int) $totales['prestados'] ?></p>
            </div>

            <div class="card">
                <h3>Mantenimiento</h3>
                <p><?= (int) $totales['en_mantenimiento'] ?></p>
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
                        <?php foreach ($resumenCategorias as $fila): ?>
                            <tr>
                                <td><?= htmlspecialchars($fila['categoria']) ?></td>
                                <td><?= (int) ($fila['total'] ?? 0) ?></td>
                                <td><?= (int) ($fila['disponible'] ?? 0) ?></td>
                                <td><?= (int) ($fila['prestado'] ?? 0) ?></td>
                                <td><?= (int) ($fila['mantenimiento'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="botones">
                    <button type="button">Exportar PDF</button>
                    <button type="button">Exportar Excel</button>
                    <button type="button">Imprimir</button>
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
