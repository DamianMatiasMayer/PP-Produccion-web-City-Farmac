<?php
$titulo = 'Productos';
require_once '../../config.php';
require_once '../../datosTemporales/productos.php';
require_once '../../datosTemporales/categorias.php';
require_once '../../datosTemporales/marcas.php';
require_once '../../includes/publico/header.php';
?>

<main class="listado">
    <?php /** @var array $productos */ ?>
    <?php /** @var array $categorias */ ?>
    <?php /** @var array $marcas */ ?>

    <div class="barra-listado">
        <nav class="migas" aria-label="Ruta de navegación">
            <a href="<?php echo BASE_URL; ?>index.php">Inicio</a> / <span>Productos</span>
        </nav>
        <p class="cantidad"><?php echo count($productos); ?> productos encontrados</p>
        <form class="orden" method="GET" action="listado.php">
            <label for="orden">Ordenar por</label>
            <select name="orden" id="orden">
                <option value="destacados">Destacados</option>
                <option value="ranking">Ranqueados mayor a menor</option>
                <option value="az">A-Z</option>
                <option value="za">Z-A</option>
            </select>
            <button type="submit" class="boton">Ordenar</button>
        </form>
    </div>

    <h1>Productos</h1>

    <div class="contenido-listado">
        <aside class="filtros">
            <h2>Categorías</h2>
            <ul>
                <?php foreach ($categorias as $principal => $subcategorias) { ?>
                    <li class="categoria">
                        <a href="#"><?php echo htmlspecialchars($principal); ?></a>
                        <ul class="subcategorias">
                            <?php foreach ($subcategorias as $sub) { ?>
                                <li><a href="#"><?php echo htmlspecialchars($sub); ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>

            <h2>Marca</h2>
            <form method="GET" action="listado.php">
                <label for="marca">Filtrar por marca</label>
                <select name="marca" id="marca">
                    <option value="">Todas las marcas</option>
                    <?php foreach ($marcas as $marca) { ?>
                        <?php if ($marca['activo']) { ?>
                            <option value="<?php echo htmlspecialchars($marca['nombre']); ?>"><?php echo htmlspecialchars($marca['nombre']); ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <button type="submit" class="boton">Filtrar</button>
            </form>
        </aside>

        <?php if (count($productos) > 0) { ?>
            <div class="grilla">
                <?php foreach ($productos as $producto) {
                    include '../../includes/componentes/tarjeta_producto.php';
                } ?>
            </div>
        <?php } else { ?>
            <p class="vacio">No hay productos para mostrar</p>
        <?php } ?>
    </div>
</main>

<?php require_once '../../includes/publico/footer.php'; ?>