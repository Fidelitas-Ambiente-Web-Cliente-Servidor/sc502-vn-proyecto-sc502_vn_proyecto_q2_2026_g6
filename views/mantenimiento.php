<?php
$mantenimientos = $mantenimientos ?? [];
$recursos = $recursos ?? [];
$tipoMensaje = ($_GET['tipo'] ?? '') === 'exito' ? 'exito' : 'error';
$mensaje = trim($_GET['mensaje'] ?? '');
$estados = ['En revisión', 'Reparado', 'Fuera de servicio', 'Vencido'];
?>

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
            <a href="index.php?controller=login&action=cerrarSesion">Cerrar sesión</a>
        </nav>
    </header>

    <div class="banner">
        <section class="titulo">
            <h2>Mantenimiento de Equipos</h2>
            <p>Registro de equipos dañados, vencidos o en revisión.</p>
        </section>

        <section class="contenedor">
            <?php if ($mensaje !== ''): ?>
                <div class="mensaje <?= $tipoMensaje ?>">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <div class="formulario">
                <h3>Registrar Mantenimiento</h3>

                <form action="index.php?controller=mantenimiento&action=registrar" method="POST">
                    <label for="id_recurso">Equipo</label>
                    <select id="id_recurso" name="id_recurso" required>
                        <option value="">Seleccione un equipo</option>
                        <?php foreach ($recursos as $recurso): ?>
                            <option value="<?= (int) $recurso['id_recurso'] ?>">
                                <?= htmlspecialchars(
                                    $recurso['nombre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                                - <?= htmlspecialchars(
                                    $recurso['estado'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="problema">Detalle del problema</label>
                    <input
                        type="text"
                        id="problema"
                        name="problema"
                        maxlength="255"
                        placeholder="Describa el problema"
                        required
                    >

                    <label for="fecha">Fecha</label>
                    <input
                        type="date"
                        id="fecha"
                        name="fecha"
                        value="<?= date('Y-m-d') ?>"
                        required
                    >

                    <label for="estado">Estado inicial</label>
                    <select id="estado" name="estado" required>
                        <option value="En revisión">En revisión</option>
                        <option value="Fuera de servicio">Fuera de servicio</option>
                        <option value="Vencido">Vencido</option>
                    </select>

                    <button type="submit" <?= empty($recursos) ? 'disabled' : '' ?>>
                        Guardar mantenimiento
                    </button>
                </form>

                <?php if (empty($recursos)): ?>
                    <p class="aviso-formulario">
                        No hay equipos disponibles para registrar mantenimiento.
                    </p>
                <?php endif; ?>
            </div>

            <div class="tabla">
                <h3>Historial de Mantenimientos</h3>
                <input
                    type="text"
                    id="buscarMantenimiento"
                    placeholder="Buscar mantenimientos..."
                >

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Equipo</th>
                            <th>Problema</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Actualizar</th>
                        </tr>
                    </thead>
                    <tbody id="tablaMantenimientos">
                        <?php if (empty($mantenimientos)): ?>
                            <tr>
                                <td colspan="6">No hay mantenimientos registrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($mantenimientos as $mantenimiento): ?>
                                <tr>
                                    <td><?= (int) $mantenimiento['id_mantenimiento'] ?></td>
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
                                    <td class="acciones">
                                        <form
                                            action="index.php?controller=mantenimiento&action=actualizarEstado"
                                            method="POST"
                                        >
                                            <input
                                                type="hidden"
                                                name="id_mantenimiento"
                                                value="<?= (int) $mantenimiento['id_mantenimiento'] ?>"
                                            >
                                            <select name="estado" aria-label="Nuevo estado">
                                                <?php foreach ($estados as $estado): ?>
                                                    <option
                                                        value="<?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>"
                                                        <?= $mantenimiento['estado'] === $estado ? 'selected' : '' ?>
                                                    >
                                                        <?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit">Guardar</button>
                                        </form>
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
