<?php
$titulo = 'Página no encontrada';
require_once '../../config.php';
require_once '../../includes/publico/header.php';
?>

<main class="error-404">
    <h1>Error 404</h1>
    <p class="vacio">La página que buscás no existe o fue movida.</p>
    <a class="boton" href="<?php echo BASE_URL; ?>index.php">Volver al inicio</a>
</main>

<?php require_once '../../includes/publico/footer.php'; ?>