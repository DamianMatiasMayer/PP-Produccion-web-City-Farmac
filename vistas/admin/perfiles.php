<?php
$titulo = 'Perfiles';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/perfiles.php';

/** @var array $perfiles */
/** @var array $secciones_panel */

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $tipo = 'exito';
    $mensaje = 'Estado del perfil actualizado.';
}

require_once '../../includes/admin/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/usuarios-admin.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/perfiles-admin.css">

<main class="usuarios-admin">
    <h1>Perfiles</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <div class="barra-admin">
        <a class="boton" href="perfil_form.php">Nuevo perfil</a>
    </div>

    <?php if (count($perfiles) > 0) { ?>
        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Secciones con acceso</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perfiles as $p) { ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                            <td>
                                <?php
                                $nombres_secciones = array();
                                foreach ($p['secciones'] as $clave) {
                                    if (isset($secciones_panel[$clave])) {
                                        $nombres_secciones[] = $secciones_panel[$clave];
                                    }
                                }
                                echo count($nombres_secciones) > 0
                                    ? htmlspecialchars(implode(', ', $nombres_secciones))
                                    : 'Sin acceso';
                                ?>
                            </td>
                            <td>
                                <?php
                                $activo = $p['activo'];
                                include '../../includes/componentes/estado.php';
                                ?>
                            </td>
                            <td class="acciones">
                                <a href="perfil_form.php?id=<?php echo $p['id']; ?>">Modificar</a>
                                <?php
                                $id_item = $p['id'];
                                include '../../includes/componentes/boton_estado.php';
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="vacio">No hay perfiles para mostrar</p>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>