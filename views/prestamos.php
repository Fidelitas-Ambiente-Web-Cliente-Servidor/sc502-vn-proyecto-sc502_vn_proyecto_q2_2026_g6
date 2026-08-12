<?php

$prestamos = $prestamos ?? [];
$recursos = $recursos ?? [];
$usuarios = $usuarios ?? [];

$tipoMensaje = ($_GET['tipo'] ?? '') === 'exito'
    ? 'exito'
    : 'error';
$mensaje = trim($_GET['mensaje'] ?? '');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos</title>
    <link rel="stylesheet" href="css/prestamos.css">
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
            <a href="index.php?controller=prestamos&action=index" class="activo">
                Préstamos
            </a>
            <a href="index.php?controller=mantenimiento&action=index">
                Mantenimiento
            </a>
            <a href="index.php?controller=reportes&action=index">
                Reportes
            </a>
            <a href="index.php?controller=login&action=index">
                Iniciar Sesión
            </a>
        </nav>
    </header>

    <div class="banner">

        <section class="titulo">
            <h2>Gestión de Préstamos</h2>
            <p>Control de recursos prestados y devoluciones.</p>
        </section>

        <section class="contenedor">

            <?php if ($mensaje !== ''): ?>
            <div class="mensaje <?= $tipoMensaje ?>">
                <?= htmlspecialchars(
                        $mensaje,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
            </div>
            <?php endif; ?>

            <div class="formulario">
                <h3>Registrar Préstamo</h3>

                <form action="index.php?controller=prestamos&action=registrar" method="POST">
                    <label for="id_recurso">Recurso disponible</label>
                    <select id="id_recurso" name="id_recurso" required>
                        <option value="">Seleccione un recurso</option>

                        <?php foreach ($recursos as $recurso): ?>
                        <option value="<?= (int) $recurso['id_recurso'] ?>">
                            <?= htmlspecialchars(
                                    $recurso['nombre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            - Disponibles:
                            <?= (int) $recurso['cantidad'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="id_usuario">Persona responsable</label>
                    <select id="id_usuario" name="id_usuario" required>
                        <option value="">Seleccione un usuario</option>

                        <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= (int) $usuario['id_usuario'] ?>">
                            <?= htmlspecialchars(
                                    $usuario['nombre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            -
                            <?= htmlspecialchars(
                                    $usuario['rol'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="fecha_prestamo">Fecha del préstamo</label>
                    <input type="date" id="fecha_prestamo" name="fecha_prestamo" value="<?= date('Y-m-d') ?>" required>

                    <button type="submit" <?= empty($recursos) || empty($usuarios)
                            ? 'disabled'
                            : ''
                        ?>>
                        Guardar préstamo
                    </button>
                </form>

                <?php if (empty($usuarios)): ?>
                <p class="aviso-formulario">
                    Debe existir al menos un usuario para registrar
                    préstamos.
                </p>
                <?php endif; ?>

                <?php if (empty($recursos)): ?>
                <p class="aviso-formulario">
                    No hay recursos disponibles para prestar.
                </p>
                <?php endif; ?>
            </div>

            <div class="tabla">
                <h3>Lista de Préstamos</h3>

                <input type="text" id="buscarPrestamo" placeholder="Buscar préstamos...">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Recurso</th>
                            <th>Responsable</th>
                            <th>Fecha préstamo</th>
                            <th>Fecha devolución</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody id="tablaPrestamos">

                        <?php if (empty($prestamos)): ?>
                        <tr>
                            <td colspan="7">
                                No hay préstamos registrados.
                            </td>
                        </tr>
                        <?php else: ?>

                        <?php foreach ($prestamos as $prestamo): ?>
                        <tr>
                            <td>
                                <?= (int) $prestamo['id_prestamo'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $prestamo['recurso'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $prestamo['responsable'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $prestamo['fecha_prestamo'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td>
                                <?= $prestamo['fecha_devolucion']
                                            ? htmlspecialchars(
                                                $prestamo[
                                                    'fecha_devolucion'
                                                ],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                            : 'Pendiente'
                                        ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                            $prestamo['estado'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                            </td>

                            <td class="acciones">

                                <?php if (
                                            $prestamo['estado'] === 'Prestado'
                                        ): ?>
                                <form action="index.php?controller=prestamos&action=devolver" method="POST"
                                    onsubmit="return confirm('¿Registrar la devolución?');">
                                    <input type="hidden" name="id_prestamo"
                                        value="<?= (int) $prestamo['id_prestamo'] ?>">

                                    <button type="submit" class="boton-devolver">
                                        Devolver
                                    </button>
                                </form>
                                <?php else: ?>
                                <span class="completado">
                                    Completado
                                </span>
                                <?php endif; ?>

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
<script src="js/prestamos.js"></script>

</body>

</html>s