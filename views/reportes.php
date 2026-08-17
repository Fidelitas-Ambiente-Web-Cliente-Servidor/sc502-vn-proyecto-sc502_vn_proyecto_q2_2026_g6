<?php

$totales = $totales ?? [
    'total_recursos' => 0,
    'disponibles' => 0,
    'prestados' => 0,
    'mantenimiento' => 0,
    'vencidos' => 0
];

$resumenCategorias = $resumenCategorias ?? [];
?>

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
            <a href="index.php?controller=index&action=index">
                Inicio
            </a>
            <a href="index.php?controller=inventario&action=index">
                Inventario
            </a>
            <a href="index.php?controller=prestamos&action=index">
                Préstamos
            </a>
            <a href="index.php?controller=mantenimiento&action=index">
                Mantenimiento
            </a>
            <a href="index.php?controller=reportes&action=index" class="activo">
                Reportes
            </a>
            <a href="index.php?controller=login&action=cerrarSesion">
                Cerrar sesión
            </a>
        </nav>
    </header>

    <div class="banner">

        <section class="titulo">
            <h2>Reportes del Sistema</h2>
            <p>
                Resumen real del inventario, préstamos y mantenimientos.
            </p>
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
                <p><?= (int) $totales['mantenimiento'] ?></p>
            </div>

            <div class="card">
                <h3>Vencidos</h3>
                <p><?= (int) $totales['vencidos'] ?></p>
            </div>

        </section>

        <section class="contenedor">

            <div class="tabla">
                <h3>Reporte por Categoría</h3>

                <table id="tablaReporte">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Total</th>
                            <th>Disponible</th>
                            <th>Prestado</th>
                            <th>Mantenimiento</th>
                            <th>Vencido</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($resumenCategorias)): ?>
                        <tr>
                            <td colspan="6">
                                No hay información disponible.
                            </td>
                        </tr>
                        <?php else: ?>

                        <?php foreach (
                                $resumenCategorias as $resumen
                            ): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars(
                                            $resumen['categoria'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= (int) $resumen['total'] ?>
                            </td>

                            <td>
                                <?= (int) $resumen['disponibles'] ?>
                            </td>

                            <td>
                                <?= (int) $resumen['prestados'] ?>
                            </td>

                            <td>
                                <?= (int) $resumen['mantenimiento'] ?>
                            </td>

                            <td>
                                <?= (int) $resumen['vencidos'] ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>
                </table>

                <div class="botones">
                    <button type="button" id="exportarPDF">
                        Exportar PDF
                    </button>

                    <button type="button" id="exportarExcel">
                        Exportar Excel
                    </button>

                    <button type="button" id="imprimirReporte">
                        Imprimir
                    </button>
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
