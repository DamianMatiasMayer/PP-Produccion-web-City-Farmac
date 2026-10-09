<?php
$titulo = 'Usuarios';
require_once '../../config.php';
require_once '../../includes/admin/auth.php';
require_once '../../datosTemporales/usuarios.php';
require_once '../../datosTemporales/perfiles.php';

/** @var array $usuarios */
/** @var array $perfiles */

// Nombre del perfil a partir de su id
$nombres_perfil = array();
foreach ($perfiles as $p) {
    $nombres_perfil[$p['id']] = $p['nombre'];
}

$tipo = '';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $tipo = 'exito';
    $mensaje = 'Estado del usuario actualizado.';
}

require_once '../../includes/admin/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/usuarios-admin.css">

<main class="usuarios-admin">
    <h1>Usuarios</h1>

    <?php if ($mensaje !== '') {
        include '../../includes/componentes/aviso.php';
    } ?>

    <div class="barra-admin">
        <a class="boton" href="usuario_form.php">Nuevo usuario</a>
    </div>

    <?php if (count($usuarios) > 0) { ?>
        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u) { ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td>
                                <?php
                                echo isset($nombres_perfil[$u['perfil_id']])
                                    ? htmlspecialchars($nombres_perfil[$u['perfil_id']])
                                    : 'Sin perfil';
                                ?>
                            </td>
                            <td>
                                <?php
                                $activo = $u['activo'];
                                include '../../includes/componentes/estado.php';
                                ?>
                            </td>
                            <td class="acciones">
                                <a href="usuario_form.php?id=<?php echo $u['id']; ?>">Modificar</a>
                                <?php
                                $id_item = $u['id'];
                                include '../../includes/componentes/boton_estado.php';
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p class="vacio">No hay usuarios para mostrar</p>
    <?php } ?>
</main>

<?php require_once '../../includes/admin/footer.php'; ?>