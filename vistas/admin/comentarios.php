<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../includes/admin/auth.php';
require_once __DIR__ . '/../../includes/conexion.php';
require_once __DIR__ . '/../../modelos/comentario_modelo.php';

/** @var mysqli $conexion */

// ---- Filtros (por GET): estado = todos | activos | inactivos, producto = id ----
$estadosValidos = array('todos', 'activos', 'inactivos');
$estado = (isset($_GET['estado']) && in_array($_GET['estado'], $estadosValidos, true))
    ? $_GET['estado']
    : 'todos';
$productoId = isset($_GET['producto']) ? (int) $_GET['producto'] : 0;

$nombreProducto = $productoId > 0 ? comentarios_nombre_producto($conexion, $productoId) : '';

// ---- Acción Aprobar / Desaprobar (se guarda en la base) ----
$mensaje = '';
$tipo = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'], $_POST['id'])) {
    $idComentario = (int) $_POST['id'];
    $aprobar = ($_POST['accion'] === 'aprobar');
    if (comentario_cambiar_aprobacion($conexion, $idComentario, $aprobar)) {
        $tipo = 'exito';
        $mensaje = 'El comentario #' . $idComentario . ' fue ' . ($aprobar ? 'aprobado' : 'desaprobado') . ' correctamente.';
    } else {
        $tipo = 'error';
        $mensaje = 'No se encontró el comentario.';
    }
}

// Se lee después de la acción, así la tabla ya refleja el cambio
$lista = comentarios_listar($conexion, $estado, $productoId);

$titulo = 'Comentarios';

require_once __DIR__ . '/../../includes/admin/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/comentarios-admin.css">

<main class="comentarios-admin">
    <h1>Comentarios</h1>

    <?php
    if ($mensaje !== '') {
        include __DIR__ . '/../../includes/componentes/aviso.php';
    }
    ?>

    <form action="" method="get" class="filtros">
        <div class="campo">
            <label for="estado">Mostrar</label>
            <select id="estado" name="estado">
                <option value="todos"     <?php echo $estado === 'todos' ? 'selected' : ''; ?>>Todos</option>
                <option value="activos"   <?php echo $estado === 'activos' ? 'selected' : ''; ?>>Activos (aprobados)</option>
                <option value="inactivos" <?php echo $estado === 'inactivos' ? 'selected' : ''; ?>>Inactivos (pendientes)</option>
            </select>
        </div>

        <?php if ($productoId > 0) { ?>
            <input type="hidden" name="producto" value="<?php echo $productoId; ?>">
        <?php } ?>

        <button type="submit">Filtrar</button>
    </form>

    <?php if ($productoId > 0 && $nombreProducto !== '') { ?>
        <p class="filtro-producto">
            Comentarios del producto: <strong><?php echo htmlspecialchars($nombreProducto); ?></strong>
            &mdash; <a href="<?php echo BASE_URL; ?>vistas/admin/comentarios.php">Ver todos</a>
        </p>
    <?php } ?>

    <?php if (count($lista) === 0) { ?>
        <p>No hay comentarios para mostrar.</p>
    <?php } else { ?>
        <div class="tabla-contenedor">
            <table class="tabla-admin">
                <caption class="solo-lectores">Listado de comentarios</caption>
                <thead>
                    <tr>
                        <th scope="col">Comentario</th>
                        <th scope="col">Ranking</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $c) { ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($c['comentario']); ?>
                                <small class="autor"><?php echo htmlspecialchars($c['email']); ?></small>
                            </td>
                            <td>
                                <?php
                                $valor = $c['ranking'];
                                include __DIR__ . '/../../includes/componentes/estrellas.php';
                                ?>
                            </td>
                            <td>
                                <time datetime="<?php echo $c['fecha_creacion']; ?>">
                                    <?php echo date('d/m/Y', strtotime($c['fecha_creacion'])); ?>
                                </time>
                            </td>
                            <td><?php echo htmlspecialchars($c['producto']); ?></td>
                            <td>
                                <span class="estado <?php echo $c['aprobado'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                    <?php echo $c['aprobado'] ? 'Aprobado' : 'Pendiente'; ?>
                                </span>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                    <?php if ($c['aprobado']) { ?>
                                        <button type="submit" name="accion" value="desaprobar" class="btn-tabla btn-desaprobar"
                                                aria-label="Desaprobar comentario <?php echo $c['id']; ?>">Desaprobar</button>
                                    <?php } else { ?>
                                        <button type="submit" name="accion" value="aprobar" class="btn-tabla btn-aprobar"
                                                aria-label="Aprobar comentario <?php echo $c['id']; ?>">Aprobar</button>
                                    <?php } ?>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</main>

<?php require_once __DIR__ . '/../../includes/admin/footer.php'; ?>