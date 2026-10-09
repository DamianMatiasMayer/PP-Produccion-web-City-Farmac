<?php
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/usuarios.php';
require_once '../../datosTemporales/perfiles.php';

/** @var array $usuarios */
/** @var array $perfiles */

// usuario_form.php        -> alta de un usuario nuevo
// usuario_form.php?id=2   -> modificación del usuario 2
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$usuario = null;
if ($id > 0) {
    foreach ($usuarios as $u) {
        if ($u['id'] === $id) {
            $usuario = $u;
            break;
        }
    }
}
$no_encontrado = ($id > 0 && $usuario === null);
$modo_edicion = ($usuario !== null);

$nombre = $modo_edicion ? $usuario['nombre'] : '';
$email = $modo_edicion ? $usuario['email'] : '';
$perfil_id = $modo_edicion ? $usuario['perfil_id'] : 0;

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$no_encontrado) {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
    $perfil_id = isset($_POST['perfil']) ? (int) $_POST['perfil'] : 0;

    if ($nombre === '') {
        $tipo = 'error';
        $mensaje = 'El nombre es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $tipo = 'error';
        $mensaje = 'Ingresá un email válido.';
    } elseif (!$modo_edicion && strlen($clave) < 8) {
        $tipo = 'error';
        $mensaje = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($modo_edicion && $clave !== '' && strlen($clave) < 8) {
        $tipo = 'error';
        $mensaje = 'La nueva contraseña debe tener al menos 8 caracteres.';
    } elseif ($perfil_id === 0) {
        $tipo = 'error';
        $mensaje = 'Seleccioná un perfil.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Usuario guardado correctamente.';
    }
}

if ($no_encontrado) {
    $titulo = 'Usuario no encontrado';
} else {
    $titulo = $modo_edicion ? 'Editar usuario' : 'Nuevo usuario';
}
require_once '../../includes/admin/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/usuarios-admin.css">

<main class="pagina-form usuarios-admin">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($no_encontrado) { ?>
        <p class="vacio">No existe un usuario con ese ID.</p>
        <a class="boton" href="usuarios.php">Volver a Usuarios</a>
    <?php } else { ?>

        <?php if ($mensaje !== '') {
            include '../../includes/componentes/aviso.php';
        } ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required maxlength="100"
                       autocomplete="name"
                       value="<?php echo htmlspecialchars($nombre); ?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required maxlength="120"
                       autocomplete="email"
                       value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="campo">
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" minlength="8" maxlength="60"
                       autocomplete="new-password"
                       <?php echo $modo_edicion ? '' : 'required'; ?>>
                <?php if ($modo_edicion) { ?>
                    <small>Dejala vacía para mantener la contraseña actual.</small>
                <?php } ?>
            </div>

            <div class="campo">
                <label for="perfil">Perfil</label>
                <select name="perfil" id="perfil" required>
                    <option value="">Seleccioná un perfil</option>
                    <?php foreach ($perfiles as $p) { ?>
                        <option value="<?php echo $p['id']; ?>"
                            <?php echo ($p['id'] === $perfil_id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($p['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="acciones-form">
                <button type="submit" class="boton">Guardar usuario</button>
                <a class="boton boton-secundario" href="usuarios.php">Cancelar</a>
            </div>
        </form>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>