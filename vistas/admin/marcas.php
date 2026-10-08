<?php
$titulo = 'Marcas';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/marcas.php';

/** @var array $marcas */

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $tipo = 'exito';
    $mensaje = 'Estado de la marca actualizado.';
}

require_once '../../includes/admin/header.php';
?>

<main>
    <h1>Marcas</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <div class="barra-admin">
        <a class="boton" href="marca_form.php">Nueva marca</a>
    </div>

    <?php if (count($marcas) > 0) { ?>
        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marcas as $m) { ?>
                        <tr>
                            <td><?php echo $m['id']; ?></td>
                            <td><?php echo htmlspecialchars($m['nombre']); ?></td>
                            <td>
                                <?php
                                $activo = $m['activo'];
                                include '../../includes/componentes/estado.php';
                                ?>
                            </td>
                            <td class="acciones">
                                <a href="marca_form.php?id=<?php echo $m['id']; ?>">Modificar</a>
                                <?php
                                $id_item = $m['id'];
                                include '../../includes/componentes/boton_estado.php';
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="vacio">No hay marcas para mostrar</p>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>