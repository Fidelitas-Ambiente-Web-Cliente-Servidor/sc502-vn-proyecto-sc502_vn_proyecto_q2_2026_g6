<?php

$editando = is_array($recursoEditar);

$accionFormulario = $editando
    ? 'index.php?controller=inventario&action=actualizar'
    : 'index.php?controller=inventario&action=registrar';

$estados = [
    'Disponible',
    'En uso',
    'Prestado',
    'Mantenimiento',
    'Vencido'
];

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
    <title>Inventario</title>
    <link rel="stylesheet" href="css/inventario.css">
</head>

<body>

    <header>
        <h1>Sistema de Inventario</h1>

        <nav>
            <a href="index.php?controller=index&action=index">Inicio</a>
            <a
                href="index.php?controller=inventario&action=index"
                class="activo"
            >
                Inventario
            </a>
            <a href="index.php?controller=prestamos&action=index">
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
            <h2>Gestión de Inventario</h2>
            <p>Registro y control de equipos e insumos.</p>
        </section>

        <section class="contenedor">

            <?php if ($mensaje !== ''): ?>
                <div class="mensaje <?= $tipoMensaje ?>">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <div class="formulario">

                <h3>
                    <?= $editando
                        ? 'Editar Recurso'
                        : 'Registrar Recurso'
                    ?>
                </h3>

                <form action="<?= $accionFormulario ?>" method="POST">

                    <?php if ($editando): ?>
                        <input
                            type="hidden"
                            name="id_recurso"
                            value="<?= (int) $recursoEditar['id_recurso'] ?>"
                        >
                    <?php endif; ?>

                    <label for="nombre">Nombre del recurso</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        maxlength="100"
                        placeholder="Nombre del recurso"
                        value="<?= $editando
                            ? htmlspecialchars(
                                $recursoEditar['nombre'],
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            : ''
                        ?>"
                        required
                    >

                    <label for="cantidad">Cantidad</label>
                    <input
                        type="number"
                        id="cantidad"
                        name="cantidad"
                        min="0"
                        placeholder="Cantidad"
                        value="<?= $editando
                            ? (int) $recursoEditar['cantidad']
                            : ''
                        ?>"
                        required
                    >

                    <label for="id_categoria">Categoría</label>
                    <select
                        id="id_categoria"
                        name="id_categoria"
                        required
                    >
                        <option value="">Seleccione una categoría</option>

                        <?php foreach ($categorias as $categoria): ?>
                            <option
                                value="<?= (int) $categoria['id_categoria'] ?>"
                                <?= $editando &&
                                    (int) $recursoEditar['id_categoria'] ===
                                    (int) $categoria['id_categoria']
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                <?= htmlspecialchars(
                                    $categoria['nombre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>

                        <?php foreach ($estados as $estado): ?>
                            <option
                                value="<?= htmlspecialchars(
                                    $estado,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                <?= $editando &&
                                    $recursoEditar['estado'] === $estado
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                <?= htmlspecialchars(
                                    $estado,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                    <button type="submit">
                        <?= $editando
                            ? 'Actualizar recurso'
                            : 'Guardar recurso'
                        ?>
                    </button>

                    <?php if ($editando): ?>
                        <a
                            class="boton-cancelar"
                            href="index.php?controller=inventario&action=index"
                        >
                            Cancelar edición
                        </a>
                    <?php endif; ?>

                </form>
            </div>

            <div class="tabla">
                <h3>Lista de Recursos</h3>

                <input
                    type="text"
                    id="buscarRecurso"
                    placeholder="Buscar recursos..."
                >

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaRecursos">

                        <?php if (empty($recursos)): ?>
                            <tr>
                                <td colspan="6">
                                    No hay recursos registrados.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php foreach ($recursos as $recurso): ?>
                                <tr>
                                    <td>
                                        <?= (int) $recurso['id_recurso'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $recurso['nombre'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int) $recurso['cantidad'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $recurso['categoria'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $recurso['estado'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td class="acciones">

                                        <a
                                            class="boton-editar"
                                            href="index.php?controller=inventario&action=index&editar=<?= (int) $recurso['id_recurso'] ?>"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            action="index.php?controller=inventario&action=eliminar"
                                            method="POST"
                                            onsubmit="return confirm('¿Desea eliminar este recurso?');"
                                        >
                                            <input
                                                type="hidden"
                                                name="id_recurso"
                                                value="<?= (int) $recurso['id_recurso'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="boton-eliminar"
                                            >
                                                Eliminar
                                            </button>
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

<script src="js/inventario.js"></script>

</body>

</html>