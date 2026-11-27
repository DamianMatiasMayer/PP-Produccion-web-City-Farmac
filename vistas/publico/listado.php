<?php
$titulo = 'Productos';
require_once '../../config.php';
require_once '../../datosTemporales/productos.php';
require_once '../../datosTemporales/categorias.php';
require_once '../../datosTemporales/marcas.php';

/** @var array $productos */
/** @var array $categorias */
/** @var array $marcas */

// ---- Filtros y orden (por GET), validados contra los datos conocidos ----
$ordenes_validos = array('destacados', 'ranking', 'az', 'za');
$orden = (isset($_GET['orden']) && in_array($_GET['orden'], $ordenes_validos, true)) ? $_GET['orden'] : 'destacados';

$categoria_sel = (isset($_GET['categoria']) && isset($categorias[$_GET['categoria']])) ? $_GET['categoria'] : '';
$sub_sel = '';
if ($categoria_sel !== '' && isset($_GET['subcategoria']) && in_array($_GET['subcategoria'], $categorias[$categoria_sel], true)) {
    $sub_sel = $_GET['subcategoria'];
}

$nombres_marcas = array();
foreach ($marcas as $marca) {
    if ($marca['activo']) {
        $nombres_marcas[] = $marca['nombre'];
    }
}
$marca_sel = (isset($_GET['marca']) && in_array($_GET['marca'], $nombres_marcas, true)) ? $_GET['marca'] : '';

// Arma una URL del listado conservando los filtros actuales y cambiando los indicados
function url_listado($cambios)
{
    global $categoria_sel, $sub_sel, $marca_sel, $orden;
    $params = array_merge(array(
        'categoria'    => $categoria_sel,
        'subcategoria' => $sub_sel,
        'marca'        => $marca_sel,
        'orden'        => $orden,
    ), $cambios);
    $params = array_filter($params, function ($v) { return $v !== ''; });
    return 'listado.php' . (count($params) > 0 ? '?' . http_build_query($params) : '');
}

// ---- Filtrar: solo productos activos que cumplan los filtros ----
$visibles = array();
foreach ($productos as $p) {
    if (!$p['activo']) { continue; }
    if ($categoria_sel !== '' && $p['categoria'] !== $categoria_sel) { continue; }
    if ($sub_sel !== '' && $p['subcategoria'] !== $sub_sel) { continue; }
    if ($marca_sel !== '' && $p['marca'] !== $marca_sel) { continue; }
    $visibles[] = $p;
}

// ---- Ordenar ----
usort($visibles, function ($a, $b) use ($orden) {
    if ($orden === 'az') { return strcasecmp($a['nombre'], $b['nombre']); }
    if ($orden === 'za') { return strcasecmp($b['nombre'], $a['nombre']); }
    if ($orden === 'ranking') { return $b['ranking'] - $a['ranking']; }
    // destacados primero y luego el resto
    if ($a['destacado'] !== $b['destacado']) { return $a['destacado'] ? -1 : 1; }
    return $b['ranking'] - $a['ranking'];
});
$productos = $visibles;

require_once '../../includes/publico/header.php';
?>

<main class="listado">
    <div class="barra-listado">
        <nav class="migas" aria-label="Ruta de navegación">
            <a href="<?php echo BASE_URL; ?>index.php">Inicio</a> / <span>Productos</span>
        </nav>
        <p class="cantidad"><?php echo count($productos); ?> productos encontrados</p>
        <form class="orden" method="GET" action="listado.php">
            <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria_sel); ?>">
            <input type="hidden" name="subcategoria" value="<?php echo htmlspecialchars($sub_sel); ?>">
            <input type="hidden" name="marca" value="<?php echo htmlspecialchars($marca_sel); ?>">
            <label for="orden">Ordenar por</label>
            <select name="orden" id="orden">
                <option value="destacados" <?php echo $orden === 'destacados' ? 'selected' : ''; ?>>Destacados</option>
                <option value="ranking" <?php echo $orden === 'ranking' ? 'selected' : ''; ?>>Ranqueados mayor a menor</option>
                <option value="az" <?php echo $orden === 'az' ? 'selected' : ''; ?>>A-Z</option>
                <option value="za" <?php echo $orden === 'za' ? 'selected' : ''; ?>>Z-A</option>
            </select>
            <button type="submit" class="boton">Ordenar</button>
        </form>
    </div>

    <h1>Productos</h1>

    <div class="contenido-listado">
        <aside class="filtros">
            <h2>Categorías</h2>
            <ul>
                <li><a href="<?php echo url_listado(array('categoria' => '', 'subcategoria' => '')); ?>">Todas</a></li>
                <?php foreach ($categorias as $principal => $subcategorias) { ?>
                    <li class="categoria">
                        <!-- La categoría seleccionada se muestra desplegada; las demás, cerradas -->
                        <details <?php echo $principal === $categoria_sel ? 'open' : ''; ?>>
                            <summary><?php echo htmlspecialchars($principal); ?></summary>
                            <ul class="subcategorias">
                                <li><a href="<?php echo url_listado(array('categoria' => $principal, 'subcategoria' => '')); ?>">Ver todo</a></li>
                                <?php foreach ($subcategorias as $sub) { ?>
                                    <li>
                                        <a href="<?php echo url_listado(array('categoria' => $principal, 'subcategoria' => $sub)); ?>"
                                           <?php echo ($principal === $categoria_sel && $sub === $sub_sel) ? 'class="activo" aria-current="true"' : ''; ?>><?php echo htmlspecialchars($sub); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </details>
                    </li>
                <?php } ?>
            </ul>

            <h2>Marca</h2>
            <form method="GET" action="listado.php">
                <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria_sel); ?>">
                <input type="hidden" name="subcategoria" value="<?php echo htmlspecialchars($sub_sel); ?>">
                <input type="hidden" name="orden" value="<?php echo htmlspecialchars($orden); ?>">
                <label for="marca">Filtrar por marca</label>
                <select name="marca" id="marca">
                    <option value="">Todas las marcas</option>
                    <?php foreach ($nombres_marcas as $nombre) { ?>
                        <option value="<?php echo htmlspecialchars($nombre); ?>" <?php echo $nombre === $marca_sel ? 'selected' : ''; ?>><?php echo htmlspecialchars($nombre); ?></option>
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
            <p class="vacio">No hay productos para mostrar con los filtros elegidos. <a href="listado.php">Quitar filtros</a></p>
        <?php } ?>
    </div>
</main>

<?php require_once '../../includes/publico/footer.php'; ?>