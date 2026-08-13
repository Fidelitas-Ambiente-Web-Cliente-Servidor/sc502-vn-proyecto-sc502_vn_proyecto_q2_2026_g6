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
            <a href="index.php?controller=inventario&action=index" class="activo">Inventario</a>
            <a href="index.php?controller=prestamos&action=index">Préstamos</a>
            <a href="index.php?controller=mantenimiento&action=index">Mantenimiento</a>
            <a href="index.php?controller=reportes&action=index">Reportes</a>
            <a href="index.php?controller=login&action=index">Iniciar Sesión</a>
        </nav>
    </header>

    <div class="banner">

        <section class="titulo">
            <h2>Gestión de Inventario</h2>
            <p>Registro y control de equipos e insumos.</p>
        </section>

        <section class="contenedor">

            <form class="formulario" method="POST" action="index.php?controller=inventario&action=guardar">
                <h3>Registrar Recurso</h3>

                <input type="text" name="nombre" placeholder="Nombre del recurso" required>
                <input type="number" name="cantidad" placeholder="Cantidad" min="0" value="1" required>

                <select name="id_categoria" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= (int) $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="estado">
                    <option value="Disponible">Disponible</option>
                    <option value="En uso">En uso</option>
                    <option value="Prestado">Prestado</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Vencido">Vencido</option>
                </select>

                <button type="submit">Guardar recurso</button>
            </form>

            <div class="tabla">
                <h3>Lista de Recursos</h3>

                <?php if (!empty($recursos)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($recursos as $recurso): ?>
                                <tr>
                                    <td><?= (int) $recurso['id_recurso'] ?></td>
                                    <td><?= htmlspecialchars($recurso['nombre']) ?></td>
                                    <td><?= (int) $recurso['cantidad'] ?></td>
                                    <td><?= htmlspecialchars($recurso['categoria']) ?></td>
                                    <td><?= htmlspecialchars($recurso['estado']) ?></td>
                                    <td>
                                        <a href="index.php?controller=inventario&action=eliminar&id=<?= (int) $recurso['id_recurso'] ?>" onclick="return confirm('¿Desea eliminar este recurso?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay recursos registrados.</p>
                <?php endif; ?>
            </div>

        </section>

    </div>

    <footer>
        <p>Universidad Fidélitas - Proyecto Cliente Servidor</p>
    </footer>
<script src="js/inventario.js"></script>
</body>

</html>
