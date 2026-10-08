<?php
$titulo = 'Inicio';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../includes/admin/header.php';
?>

<main>
    <h1>Bienvenido al panel</h1>
    <p>Sesión iniciada como <strong><?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'invitado'; ?></strong>.</p>

    <ul class="accesos">
        <li><a href="productos.php">Productos</a></li>
        <li><a href="categorias.php">Categorías</a></li>
        <li><a href="marcas.php">Marcas</a></li>
        <li><a href="comentarios.php">Comentarios</a></li>
        <li><a href="usuarios.php">Usuarios</a></li>
        <li><a href="perfiles.php">Perfiles</a></li>
    </ul>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>