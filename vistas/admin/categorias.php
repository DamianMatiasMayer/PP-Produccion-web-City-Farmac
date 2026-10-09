<?php
$titulo = 'Categorías';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/categorias.php';

/** @var array $lista_categorias */

$id_padre = isset($_GET['padre']) ? (int) $_GET['padre'] : 0;
$padre = null;
if ($id_padre > 0) {
    foreach ($lista_categorias as $c) {
        if ($c['id'] === $id_padre && $c['id_padre'] === 0) {
            $padre = $c;
            break;
        }
    }
}
$padre_invalido = ($id_padre > 0 && $padre === null);

if ($padre !== null) {
    $titulo = 'Subcategorías de ' . $padre['nombre'];
}

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $tipo = 'exito';
    $mensaje = 'Estado de la categoría actualizado (simulado).';
}

$filas = array();
foreach ($lista_categorias as $c) {
    if ($c['id_padre'] === $id_padre) {
        array_push($filas, $c);
    }
}

require_once '../../includes/admin/header.php';
?>

<main>
    <h1><?php echo htmlspecialchars($titulo); ?></h1>

    <?php if ($padre_invalido) { ?>
        <p class="vacio">No existe una categoría principal con ese ID.</p>
        <a class="boton" href="categorias.php">Volver a Categorías</a>
    <?php } else { ?>

        <?php if ($mensaje !== '') {
            include '../../includes/componentes/aviso.php';
        } ?>

        <div class="barra-admin">
            <?php if ($padre !== null) { ?>
                <a class="boton boton-secundario" href="categorias.php">Volver a categorías</a>
                <a class="boton" href="categoria_form.php?padre=<?php echo $padre['id']; ?>">Nueva subcategoría</a>
            <?php } else { ?>
                <a class="boton" href="categoria_form.php">Nueva categoría</a>
            <?php } ?>
        </div>

        <?php if (count($filas) > 0) { ?>
            <div class="tabla-contenedor">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <?php if ($padre === null) { ?>
                                <th scope="col">Subcategorías</th>
                            <?php } ?>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filas as $c) { ?>
                            <tr>
                                <td><?php echo $c['id']; ?></td>
                                <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                                <?php if ($padre === null) { ?>
                                    <td>
                                        <?php
                                        $cantidad = 0;
                                        foreach ($lista_categorias as $s) {
                                            if ($s['id_padre'] === $c['id']) {
                                                $cantidad++;
                                            }
                                        }
                                        echo $cantidad;
                                        ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php
                                    $activo = $c['activo'];
                                    include '../../includes/componentes/estado.php';
                                    ?>
                                </td>
                                <td class="acciones">
                                    <a href="categoria_form.php?id=<?php echo $c['id']; ?>">Modificar</a>
                                    <?php
                                    $id_item = $c['id'];
                                    include '../../includes/componentes/boton_estado.php';
                                    ?>
                                    <?php if ($padre === null) { ?>
                                        <a href="categorias.php?padre=<?php echo $c['id']; ?>">Ver subcategorías</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p class="vacio">No hay categorías para mostrar</p>
        <?php } ?>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>