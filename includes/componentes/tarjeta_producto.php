<?php /** @var array $producto */ ?>
<article class="tarjeta">
    <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $producto['imagen']; ?>"
         alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
    <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
    <p class="marca"><?php echo htmlspecialchars($producto['marca']); ?></p>
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
</article>