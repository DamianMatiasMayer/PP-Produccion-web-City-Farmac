<?php
$titulo = 'Registro';
$mostrar_menu = false;
require_once '../../config.php';

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
    $confirmacion = isset($_POST['confirmacion']) ? $_POST['confirmacion'] : '';

    if ($clave !== $confirmacion) {
        $tipo = 'error';
        $mensaje = 'Las contraseñas no coinciden.';
    } else {
        $tipo = 'exito';
        $mensaje = 'Te registraste correctamente.';
    }
}

require_once '../../includes/admin/header.php';
?>

<main class="acceso">
    <h1>Crear cuenta</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <form class="formulario" method="POST" action="registro.php">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required placeholder="Tu nombre">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="tuemail@mail.com" autocomplete="off">
        </div>
        <div class="campo">
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave" required minlength="6" placeholder="Mínimo 6 caracteres">
        </div>
        <div class="campo">
            <label for="confirmacion">Confirmar contraseña</label>
            <input type="password" name="confirmacion" id="confirmacion" required minlength="6" placeholder="Repetí tu contraseña">
        </div>
        <button type="submit" class="boton">Registrarme</button>
    </form>

    <p class="enlace-acceso">¿Ya tenés cuenta? <a href="login.php">Ingresá</a></p>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>