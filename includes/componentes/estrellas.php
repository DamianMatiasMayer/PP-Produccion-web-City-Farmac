<?php
/** @var int|float $valor  Valoración de 0 a 5 */
$llenas = (int) round($valor);
?>
<span class="estrellas" role="img" aria-label="Valoración <?php echo $valor; ?> de 5"><?php
    echo str_repeat('★', $llenas) . str_repeat('☆', 5 - $llenas);
?></span>