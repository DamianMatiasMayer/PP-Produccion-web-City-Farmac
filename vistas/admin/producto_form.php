<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/productos.php';
require_once '../../datosTemporales/detalle_productos.php';
require_once '../../datosTemporales/categorias.php';
require_once '../../datosTemporales/marcas.php';

/** @var array $productos */
/** @var array $detalles */
/** @var array $categorias */
/** @var array $marcas */

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$producto = null;
if ($id > 0) {
    foreach ($productos as $p) {
        if ($p['id'] === $id) {
            $producto = $p;
            break;
        }
    }
}
$no_encontrado = ($id > 0 && $producto === null);
$modo_edicion = ($producto !== null);

$valores = array(
    'nombre'       => '',
    'descripcion'  => '',
    'precio'       => '',
    'subcategoria' => '',
    'marca'        => '',
    'modelo'       => '',
    'destacado'    => false,
);

if ($modo_edicion) {
    $valores['nombre']       = $producto['nombre'];
    $valores['descripcion']  = isset($detalles[$id]) ? $detalles[$id]['descripcion'] : '';
    $valores['precio']       = $producto['precio'];
    $valores['subcategoria'] = $producto['subcategoria'];
    $valores['marca']        = $producto['marca'];
    $valores['modelo']       = isset($detalles[$id]) ? $detalles[$id]['modelo'] : '';
    $valores['destacado']    = $producto['destacado'];
}


$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrado) {
    $valores['nombre']       = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $valores['descripcion']  = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $valores['precio']       = isset($_POST['precio']) ? trim($_POST['precio']) : '';
    $valores['subcategoria'] = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : '';
    $valores['marca']        = isset($_POST['marca']) ? $_POST['marca'] : '';
    $valores['modelo']       = isset($_POST['modelo']) ? trim($_POST['modelo']) : '';
    $valores['destacado']    = isset($_POST['destacado']);

    if ($valores['nombre'] === '') {
        $tipo = 'error';
        $mensaje = 'El nombre es obligatorio.';
    } elseif (!is_numeric($valores['precio']) || $valores['precio'] <= 0) {
        $tipo = 'error';
        $mensaje = 'El precio debe ser un número mayor a cero.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Producto guardado correctamente.';
    }
}

if ($no_encontrado) {
    $titulo = 'Producto no encontrado';
} else {
    $titulo = $modo_edicion ? 'Editar producto' : 'Nuevo producto';
}
require_once '../../includes/admin/header.php';
?>

<main class="pagina-form">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($no_encontrado) { ?>
        <p class="vacio">No existe un producto con ese ID.</p>
        <a class="boton" href="productos.php">Volver a Productos</a>
    <?php } else { ?>

        <?php if ($mensaje !== '') {
            include '../../includes/componentes/aviso.php';
        } ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required maxlength="100"
                       value="<?php echo htmlspecialchars($valores['nombre']); ?>">
            </div>

            <div class="campo">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" required><?php echo htmlspecialchars($valores['descripcion']); ?></textarea>
            </div>

            <div class="campo">
                <label for="precio">Precio</label>
                <input type="number" name="precio" id="precio" required min="1" step="1"
                       value="<?php echo htmlspecialchars($valores['precio']); ?>">
            </div>

            <div class="campo">
                <label for="subcategoria">Categoría</label>
                <select name="subcategoria" id="subcategoria" required>
                    <option value="">Seleccioná una categoría</option>
                    <?php foreach ($categorias as $principal => $subcategorias) { ?>
                        <optgroup label="<?php echo htmlspecialchars($principal); ?>">
                            <?php foreach ($subcategorias as $sub) { ?>
                                <option value="<?php echo htmlspecialchars($sub); ?>"
                                    <?php echo ($sub === $valores['subcategoria']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($sub); ?>
                                </option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>

            <div class="campo">
                <label for="marca">Marca</label>
                <select name="marca" id="marca" required>
                    <option value="">Seleccioná una marca</option>
                    <?php foreach ($marcas as $marca) { ?>
                        <option value="<?php echo htmlspecialchars($marca); ?>"
                            <?php echo ($marca === $valores['marca']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($marca); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="campo">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" maxlength="80"
                       value="<?php echo htmlspecialchars($valores['modelo']); ?>">
            </div>

            <div class="campo">
                <label for="imagen">Imagen</label>
                <?php if ($modo_edicion) { ?>
                    <img class="vista-previa"
                         src="<?php echo BASE_URL; ?>assets/img/<?php echo $producto['imagen']; ?>"
                         alt="Imagen actual de <?php echo htmlspecialchars($producto['nombre']); ?>">
                <?php } ?>
                <input type="file" name="imagen" id="imagen" accept="image/png, image/jpeg, image/webp"
                       <?php echo $modo_edicion ? '' : 'required'; ?>>
            </div>

            <div class="campo campo-check">
                <input type="checkbox" name="destacado" id="destacado"
                       <?php echo $valores['destacado'] ? 'checked' : ''; ?>>
                <label for="destacado">Producto destacado</label>
            </div>

            <div class="acciones-form">
                <button type="submit" class="boton">Guardar producto</button>
                <a class="boton boton-secundario" href="productos.php">Cancelar</a>
            </div>
        </form>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>