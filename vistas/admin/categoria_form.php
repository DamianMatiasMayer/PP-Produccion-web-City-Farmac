<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../includes/conexion.php';
require_once '../../modelos/categoria_modelo.php';

/** @var mysqli $conexion */

// ---- Modo: modificar (?id=) o alta (con ?padre= opcional) ----
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = null;
if ($id > 0) {
    $categoria = categoria_obtener($conexion, $id);
}
$no_encontrada = ($id > 0 && $categoria === null);
$modo_edicion = ($categoria !== null);

// ---- Valores iniciales del formulario ----
$nombre = '';
$id_padre_sel = 0;
if ($modo_edicion) {
    $nombre = $categoria['nombre'];
    $id_padre_sel = (int) $categoria['categoria_padre_id'];
} elseif (isset($_GET['padre'])) {
    $id_padre_sel = (int) $_GET['padre'];
}

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrada) {
    // Los datos ingresados se conservan si la validación falla
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    if (!$modo_edicion) {
        $id_padre_sel = isset($_POST['id_padre']) ? (int) $_POST['id_padre'] : 0;
    }
    $id_padre_guardar = ($id_padre_sel > 0) ? $id_padre_sel : null;

    $error = categoria_validar($conexion, $nombre, $id_padre_guardar, $modo_edicion ? $id : 0);

    if ($error !== '') {
        $tipo = 'error';
        $mensaje = $error;
    } else {
        if ($modo_edicion) {
            categoria_actualizar($conexion, $id, $nombre);
            $ok = 'modificada';
        } else {
            categoria_crear($conexion, $nombre, $id_padre_guardar);
            $ok = 'creada';
        }
        $destino = 'categorias.php?ok=' . $ok;
        if ($id_padre_sel > 0) {
            $destino .= '&padre=' . $id_padre_sel;
        }
        header('Location: ' . $destino);
        exit;
    }
}

$volver = 'categorias.php';
if ($id_padre_sel > 0) {
    $volver = 'categorias.php?padre=' . $id_padre_sel;
}

if ($no_encontrada) {
    $titulo = 'Categoría no encontrada';
} else {
    $titulo = $modo_edicion ? 'Editar categoría' : 'Nueva categoría';
}

$principales = $no_encontrada ? array() : categorias_listar($conexion, 0);
require_once '../../includes/admin/header.php';
?>

<main class="pagina-form">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($no_encontrada) { ?>
        <p class="vacio">No existe una categoría con ese ID.</p>
        <a class="boton" href="categorias.php">Volver a Categorías</a>
    <?php } else { ?>

        <?php if ($mensaje !== '') {
            include '../../includes/componentes/aviso.php';
        } ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required maxlength="100"
                       value="<?php echo htmlspecialchars($nombre); ?>">
            </div>

            <div class="campo">
                <label for="id_padre">Categoría padre (opcional)</label>
                <!-- Al modificar, el padre no se cambia: el campo se muestra bloqueado -->
                <select name="id_padre" id="id_padre" <?php echo $modo_edicion ? 'disabled' : ''; ?>>
                    <option value="0">Ninguna (es una categoría principal)</option>
                    <?php foreach ($principales as $c) { ?>
                        <?php if ($c['id'] !== $id) { ?>
                            <option value="<?php echo $c['id']; ?>"
                                <?php echo ($c['id'] === $id_padre_sel) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['nombre']); ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="acciones-form">
                <button type="submit" class="boton">Guardar categoría</button>
                <a class="boton boton-secundario" href="<?php echo $volver; ?>">Cancelar</a>
            </div>
        </form>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>