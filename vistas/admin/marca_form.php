<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/marcas.php';

/** @var array $marcas */

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$marca = null;
if ($id > 0) {
    foreach ($marcas as $m) {
        if ($m['id'] === $id) {
            $marca = $m;
            break;
        }
    }
}
$no_encontrada = ($id > 0 && $marca === null);
$modo_edicion = ($marca !== null);

$nombre = $modo_edicion ? $marca['nombre'] : '';

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrada) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';

    if ($nombre === '') {
        $tipo = 'error';
        $mensaje = 'El nombre es obligatorio.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Marca guardada correctamente.';
    }
}

if ($no_encontrada) {
    $titulo = 'Marca no encontrada';
} else {
    $titulo = $modo_edicion ? 'Editar marca' : 'Nueva marca';
}
require_once '../../includes/admin/header.php';
?>

<main class="pagina-form">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($no_encontrada) { ?>
        <p class="vacio">No existe una marca con ese ID.</p>
        <a class="boton" href="marcas.php">Volver a Marcas</a>
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

            <div class="acciones-form">
                <button type="submit" class="boton">Guardar marca</button>
                <a class="boton boton-secundario" href="marcas.php">Cancelar</a>
            </div>
        </form>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>