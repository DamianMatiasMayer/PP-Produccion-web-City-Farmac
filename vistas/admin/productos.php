<?php
$titulo = 'Productos';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/productos.php';
require_once '../../datosTemporales/categorias.php';

/** @var array $productos */
/** @var array $categorias */

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $tipo = 'exito';
    $mensaje = 'Estado del producto actualizado.';
}

$f_categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$f_sub = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : '';

$filtrados = array();
foreach ($productos as $p) {
    if ($f_categoria !== '' && $p['categoria'] !== $f_categoria) {
        continue;
    }
    if ($f_sub !== '' && $p['subcategoria'] !== $f_sub) {
        continue;
    }
    array_push($filtrados, $p);
}

require_once '../../includes/admin/header.php';
?>

<main>
    <h1>Productos</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <div class="barra-admin">
        <form class="filtros-admin" method="GET" action="productos.php">
            <div class="campo">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $principal => $subcategorias) { ?>
                        <option value="<?php echo htmlspecialchars($principal); ?>"
                            <?php echo ($principal === $f_categoria) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($principal); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="campo">
                <label for="subcategoria">Subcategoría</label>
                <select name="subcategoria" id="subcategoria">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $principal => $subcategorias) { ?>
                        <optgroup label="<?php echo htmlspecialchars($principal); ?>">
                            <?php foreach ($subcategorias as $sub) { ?>
                                <option value="<?php echo htmlspecialchars($sub); ?>"
                                    <?php echo ($sub === $f_sub) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($sub); ?>
                                </option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="boton">Filtrar</button>
        </form>

        <a class="boton" href="producto_form.php">Nuevo producto</a>
    </div>

    <?php if (count($filtrados) > 0) { ?>
        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Subcategoría</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Destacado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtrados as $p) { ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($p['marca']); ?></td>
                            <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($p['subcategoria']); ?></td>
                            <td>$<?php echo $p['precio']; ?></td>
                            <td>
                                <?php if ($p['activo']) { ?>
                                    <span class="estado estado-activo">Activo</span>
                                <?php } else { ?>
                                    <span class="estado estado-inactivo">Inactivo</span>
                                <?php } ?>
                            </td>
                            <td><?php echo $p['destacado'] ? 'Sí' : 'No'; ?></td>
                            <td class="acciones">
                                <a href="producto_form.php?id=<?php echo $p['id']; ?>">Modificar</a>
                                <form method="POST" action="productos.php">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" name="cambiar_estado" class="boton-texto">
                                        <?php echo $p['activo'] ? 'Inactivar' : 'Activar'; ?>
                                    </button>
                                </form>
                                <a href="comentarios.php?producto=<?php echo $p['id']; ?>">Ver comentarios</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="vacio">No hay productos para mostrar</p>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>