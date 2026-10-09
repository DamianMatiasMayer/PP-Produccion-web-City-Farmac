<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../datosTemporales/productos.php';
require_once __DIR__ . '/../../datosTemporales/detalle_productos.php';

/** @var array $productos */
/** @var array $detalles */
/** @var array $comentarios */

// El producto se elige por la URL: detalle.php?id=3
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

$producto = null;
foreach ($productos as $item) {
    if ($item['id'] === $id) {
        $producto = $item;
        break;
    }
}

// Producto inexistente: aviso simple.
if ($producto === null) {
    http_response_code(404);
    $titulo = 'Producto no encontrado';
    require_once __DIR__ . '/../../includes/publico/header.php';
    ?>
    <main>
        <h1>Producto no encontrado</h1>
        <p><a href="<?php echo BASE_URL; ?>index.php">Volver al inicio</a></p>
    </main>
    <?php
    require_once __DIR__ . '/../../includes/publico/footer.php';
    exit;
}

$detalle = isset($detalles[$id])
    ? $detalles[$id]
    : array('modelo' => 'No disponible', 'descripcion' => 'Sin descripción disponible.');
$lista   = isset($comentarios[$id]) ? $comentarios[$id] : array();

// Ranking promedio: se calcula con los comentarios aprobados.
// Si todavía no hay ninguno, se usa el ranking de ejemplo del producto.
if (count($lista) > 0) {
    $suma = 0;
    foreach ($lista as $comentario) {
        $suma += $comentario['valoracion'];
    }
    $promedio = round($suma / count($lista), 1);
} else {
    $promedio = $producto['ranking'];
}

// Mensaje simulado: en esta instancia el formulario no se envía a ningún lado.
$enviado = ($_SERVER['REQUEST_METHOD'] === 'POST');

$titulo = $producto['nombre'];
require_once __DIR__ . '/../../includes/publico/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/detalle.css">

<main>
    <nav class="migas" aria-label="Ruta de navegación">
        <a href="<?php echo BASE_URL; ?>index.php">Inicio</a> &rsaquo;
        <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
    </nav>

    <article class="detalle-producto">
        <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $producto['imagen']; ?>"
             alt="<?php echo htmlspecialchars($producto['nombre']); ?>">

        <div class="detalle-info">
            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>

            <dl class="detalle-datos">
                <dt>Marca</dt>
                <dd><?php echo htmlspecialchars($producto['marca']); ?></dd>
                <dt>Modelo</dt>
                <dd><?php echo htmlspecialchars($detalle['modelo']); ?></dd>
            </dl>

            <p class="detalle-ranking">
                <?php
                $valor = $promedio;
                include __DIR__ . '/../../includes/componentes/estrellas.php';
                ?>
                <span><?php echo number_format($promedio, 1, ',', '.'); ?> / 5</span>
            </p>

            <p class="detalle-precio">$<?php echo $producto['precio']; ?></p>

            <h2>Descripción</h2>
            <p><?php echo htmlspecialchars($detalle['descripcion']); ?></p>
        </div>
    </article>

    <section class="comentarios" aria-labelledby="titulo-comentarios">
        <h2 id="titulo-comentarios">Comentarios</h2>

        <?php if (count($lista) === 0) { ?>
            <p>Todavía no hay comentarios para este producto.</p>
        <?php } ?>

        <?php foreach ($lista as $comentario) { ?>
            <article class="comentario">
                <p class="comentario-cabecera">
                    <strong><?php echo htmlspecialchars($comentario['email']); ?></strong>
                    <time datetime="<?php echo $comentario['fecha']; ?>">
                        <?php echo date('d/m/Y', strtotime($comentario['fecha'])); ?>
                    </time>
                </p>
                <p>
                    <?php
                    $valor = $comentario['valoracion'];
                    include __DIR__ . '/../../includes/componentes/estrellas.php';
                    ?>
                </p>
                <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
            </article>
        <?php } ?>
    </section>

    <section class="nuevo-comentario" aria-labelledby="titulo-nuevo-comentario">
        <h2 id="titulo-nuevo-comentario">Dejá tu comentario</h2>

        <?php
        if ($enviado) {
            $tipo    = 'exito';
            $mensaje = '¡Gracias por tu comentario! Será publicado cuando sea aprobado.';
            include __DIR__ . '/../../includes/componentes/aviso.php';
        }
        ?>

        <form action="" method="post" class="formulario-comentario">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required maxlength="120"
                       autocomplete="email">
            </div>

            <div class="campo">
                <label for="valoracion">Valoración (1 a 5)</label>
                <input type="number" id="valoracion" name="valoracion" required
                       min="1" max="5" step="1">
            </div>

            <div class="campo">
                <label for="comentario">Comentario</label>
                <textarea id="comentario" name="comentario" rows="4" required
                          minlength="5" maxlength="500"></textarea>
            </div>

            <button type="submit">Enviar comentario</button>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../../includes/publico/footer.php'; ?>