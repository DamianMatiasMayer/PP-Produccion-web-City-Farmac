<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/perfiles.php';

/** @var array $perfiles */
/** @var array $secciones_panel */



$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$perfil = null;
if ($id > 0) {
    foreach ($perfiles as $p) {
        if ($p['id'] === $id) {
            $perfil = $p;
            break;
        }
    }
}
$no_encontrado = ($id > 0 && $perfil === null);
$modo_edicion = ($perfil !== null);

$nombre = $modo_edicion ? $perfil['nombre'] : '';
$seleccionadas = $modo_edicion ? $perfil['secciones'] : array();

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrado) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $enviadas = (isset($_POST['secciones']) && is_array($_POST['secciones'])) ? $_POST['secciones'] : array();
    // Solo se aceptan secciones que existen en el panel
    $seleccionadas = array_values(array_intersect(array_keys($secciones_panel), $enviadas));

    if ($nombre === '') {
        $tipo = 'error';
        $mensaje = 'El nombre del perfil es obligatorio.';
    } elseif (count($seleccionadas) === 0) {
        $tipo = 'error';
        $mensaje = 'Seleccioná al menos una sección del panel.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Perfil guardado correctamente.';
    }
}

if ($no_encontrado) {
    $titulo = 'Perfil no encontrado';
} else {
    $titulo = $modo_edicion ? 'Editar perfil' : 'Nuevo perfil';
}
require_once '../../includes/admin/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/usuarios-admin.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/perfiles-admin.css">

<main class="pagina-form usuarios-admin">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($no_encontrado) { ?>
        <p class="vacio">No existe un perfil con ese ID.</p>
        <a class="boton" href="perfiles.php">Volver a Perfiles</a>
    <?php } else { ?>

        <?php if ($mensaje !== '') {
            include '../../includes/componentes/aviso.php';
        } ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre del perfil</label>
                <input type="text" name="nombre" id="nombre" required maxlength="60"
                       value="<?php echo htmlspecialchars($nombre); ?>">
            </div>

            <fieldset class="secciones-acceso">
                <legend>Secciones del panel con acceso</legend>
                <?php foreach ($secciones_panel as $clave => $nombre_seccion) { ?>
                    <div class="campo-check">
                        <input type="checkbox" name="secciones[]"
                               id="seccion-<?php echo $clave; ?>"
                               value="<?php echo $clave; ?>"
                               <?php echo in_array($clave, $seleccionadas, true) ? 'checked' : ''; ?>>
                        <label for="seccion-<?php echo $clave; ?>"><?php echo htmlspecialchars($nombre_seccion); ?></label>
                    </div>
                <?php } ?>
            </fieldset>

            <div class="acciones-form">
                <button type="submit" class="boton">Guardar perfil</button>
                <a class="boton boton-secundario" href="perfiles.php">Cancelar</a>
            </div>
        </form>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>