<?php /** @var array $producto */ ?>
<article class="tarjeta">
    <div class="imagen">
        <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $producto['imagen']; ?>"
             alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
    </div>
    <p class="marca"><?php echo htmlspecialchars($producto['marca']); ?></p>
    <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
    <p class="precio">$<?php echo $producto['precio']; ?></p>
    <p class="ranking" aria-label="Ranking <?php echo $producto['ranking']; ?> de 5">
        <?php
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $producto['ranking']) {
                echo '★';
            } else {
                echo '☆';
            }
        }
        ?>
    </p>
    <a class="ver" href="<?php echo BASE_URL; ?>vistas/publico/detalle.php?id=<?php echo $producto['id']; ?>">Ver producto</a>
</article>