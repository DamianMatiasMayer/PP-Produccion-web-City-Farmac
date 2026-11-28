<?php
$titulo = 'Categorías';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../includes/conexion.php';
require_once '../../modelos/categoria_modelo.php';

/** @var mysqli $conexion */

// ---- Categoría principal elegida (para ver sus subcategorías) ----
$id_padre = isset($_GET['padre']) ? (int) $_GET['padre'] : 0;
$padre = null;
if ($id_padre > 0) {
    $padre = categoria_obtener_principal($conexion, $id_padre);
}
$padre_invalido = ($id_padre > 0 && $padre === null);

if ($padre !== null) {
    $titulo = 'Subcategorías de ' . $padre['nombre'];
}

// ---- Mensajes: vienen de una acción de esta pantalla o del formulario (por ?ok=) ----
$mensajes_ok = array(
    'creada'     => 'Categoría creada correctamente.',
    'modificada' => 'Categoría modificada correctamente.',
);
$tipo = '';
$mensaje = '';
if (isset($_GET['ok']) && isset($mensajes_ok[$_GET['ok']])) {
    $tipo = 'exito';
    $mensaje = $mensajes_ok[$_GET['ok']];
}

// ---- Activar / inactivar (baja lógica) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado']) && !$padre_invalido) {
    $id_cambiar = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nuevo_estado = categoria_cambiar_estado($conexion, $id_cambiar);
    if ($nuevo_estado === null) {
        $tipo = 'error';
        $mensaje = 'No se encontró la categoría.';
    } else {
        $tipo = 'exito';
        $mensaje = $nuevo_estado ? 'Categoría activada correctamente.' : 'Categoría inactivada correctamente.';
    }
}

$filas = $padre_invalido ? array() : categorias_listar($conexion, $id_padre);

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
                                    <td><?php echo $c['cantidad_subcategorias']; ?></td>
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