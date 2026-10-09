<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/categorias.php';

/** @var array $lista_categorias */

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = null;
if ($id > 0) {
    foreach ($lista_categorias as $c) {
        if ($c['id'] === $id) {
            $categoria = $c;
            break;
        }
    }
}
$no_encontrada = ($id > 0 && $categoria === null);
$modo_edicion = ($categoria !== null);

// Valores iniciales
$nombre = '';
$id_padre_sel = isset($_GET['padre']) ? (int) $_GET['padre'] : 0;
if ($modo_edicion) {
    $nombre = $categoria['nombre'];
    $id_padre_sel = $categoria['id_padre'];
}

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrada) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $id_padre_sel = isset($_POST['id_padre']) ? (int) $_POST['id_padre'] : 0;

    if ($nombre === '') {
        $tipo = 'error';
        $mensaje = 'El nombre es obligatorio.';
    } elseif ($modo_edicion && $id_padre_sel === $id) {
        $tipo = 'error';
        $mensaje = 'Una categoría no puede ser su propia categoría padre.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Categoría guardada correctamente (simulado)';
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
                <input type="text" name="nombre" id="nombre" required maxlength="60"
                       value="<?php echo htmlspecialchars($nombre); ?>">
            </div>

            <div class="campo">
                <label for="id_padre">Categoría padre (opcional)</label>
                <select name="id_padre" id="id_padre">
                    <option value="0">Ninguna (es una categoría principal)</option>
                    <?php foreach ($lista_categorias as $c) { ?>
                        <?php if ($c['id_padre'] === 0 && $c['id'] !== $id) { ?>
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