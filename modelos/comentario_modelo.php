<?php


/** Ejecuta una consulta preparada y devuelve todas las filas como arrays. */
function comentario_consultar($conexion, $sql, $tipos = '', $parametros = array())
{
    $stmt = mysqli_prepare($conexion, $sql);
    if ($tipos !== '') {
        mysqli_stmt_bind_param($stmt, $tipos, ...$parametros);
    }
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $filas;
}

/**
 * Lista comentarios con el nombre del producto, del más nuevo al más viejo.
 * $estado: 'todos' | 'activos' (aprobados) | 'inactivos' (pendientes)
 * $id_producto: 0 para no filtrar por producto.
 */
function comentarios_listar($conexion, $estado = 'todos', $id_producto = 0)
{
    $sql = 'SELECT c.id, c.producto_id, p.nombre AS producto, c.email, c.comentario,
                   c.ranking, c.ip, c.aprobado, c.fecha_creacion
            FROM comentarios c
            INNER JOIN productos p ON p.id = c.producto_id
            WHERE 1 = 1';
    $tipos = '';
    $parametros = array();

    if ($estado === 'activos') {
        $sql .= ' AND c.aprobado = 1';
    } elseif ($estado === 'inactivos') {
        $sql .= ' AND c.aprobado = 0';
    }
    if ($id_producto > 0) {
        $sql .= ' AND c.producto_id = ?';
        $tipos .= 'i';
        $parametros[] = $id_producto;
    }
    $sql .= ' ORDER BY c.fecha_creacion DESC, c.id DESC';

    return comentario_consultar($conexion, $sql, $tipos, $parametros);
}

/** Nombre de un producto (para mostrar el filtro "Comentarios del producto: ..."), o '' si no existe. */
function comentarios_nombre_producto($conexion, $id_producto)
{
    $filas = comentario_consultar($conexion, 'SELECT nombre FROM productos WHERE id = ?', 'i', array($id_producto));
    return count($filas) > 0 ? $filas[0]['nombre'] : '';
}

/**
 * Aprueba (true) o desaprueba (false) un comentario.
 * Devuelve true si el comentario existe, false si no.
 */
function comentario_cambiar_aprobacion($conexion, $id, $aprobar)
{
    $existe = comentario_consultar($conexion, 'SELECT id FROM comentarios WHERE id = ?', 'i', array($id));
    if (count($existe) === 0) {
        return false;
    }
    $valor = $aprobar ? 1 : 0;
    $stmt = mysqli_prepare($conexion, 'UPDATE comentarios SET aprobado = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $valor, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

/** Comentarios APROBADOS de un producto (para el detalle público), del más nuevo al más viejo. */
function comentarios_aprobados_de_producto($conexion, $id_producto)
{
    return comentario_consultar(
        $conexion,
        'SELECT id, email, comentario, ranking, fecha_creacion
         FROM comentarios WHERE producto_id = ? AND aprobado = 1
         ORDER BY fecha_creacion DESC, id DESC',
        'i',
        array($id_producto)
    );
}

/**
 * Ranking promedio de un producto, calculado SOLO con comentarios aprobados.
 * Devuelve array('promedio' => float|null, 'cantidad' => int); promedio es null si no hay ninguno.
 */
function comentarios_ranking_promedio($conexion, $id_producto)
{
    $filas = comentario_consultar(
        $conexion,
        'SELECT AVG(ranking) AS promedio, COUNT(*) AS cantidad
         FROM comentarios WHERE producto_id = ? AND aprobado = 1',
        'i',
        array($id_producto)
    );
    $cantidad = (int) $filas[0]['cantidad'];
    return array(
        'promedio' => $cantidad > 0 ? round((float) $filas[0]['promedio'], 1) : null,
        'cantidad' => $cantidad,
    );
}