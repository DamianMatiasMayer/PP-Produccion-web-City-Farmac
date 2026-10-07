<?php
$titulo = 'Ingresar';
$mostrar_menu = false;
require_once '../../config.php';
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: inicio.php');
    exit();
}

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';

    if ($email === ADMIN_EMAIL && $clave === ADMIN_CLAVE) {
        $_SESSION['usuario'] = $email;
        header('Location: inicio.php');
        exit();
    } else {
        $tipo = 'error';
        $mensaje = 'Email o contraseña incorrectos.';
    }
}

require_once '../../includes/admin/header.php';
?>

<main class="acceso">
    <h1>Ingresar</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <form class="formulario" method="POST" action="login.php">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="tuemail@mail.com" autocomplete="off">
        </div>
        <div class="campo">
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave" required placeholder="Ingresá tu contraseña">
        </div>
        <button type="submit" class="boton">Ingresar</button>
    </form>

    <p class="enlace-acceso">¿No tenés cuenta? <a href="registro.php">Registrate</a></p>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>