<?php
$titulo = 'Inicio';
require_once 'config.php';
require_once 'datosTemporales/productos.php';
require_once 'includes/publico/header.php';
?>

<main>
    <section>
        <h1>Productos destacados</h1>
        <div class="grilla">
            <?php /** @var array $productos */ ?>
            <?php foreach ($productos as $producto) {
                include 'includes/componentes/tarjeta_producto.php';
            } ?>
        </div>
    </section>
</main>

<?php require_once 'includes/publico/footer.php'; ?>