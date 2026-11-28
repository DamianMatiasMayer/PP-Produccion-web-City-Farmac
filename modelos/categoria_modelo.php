<?php

function categoria_consultar($conexion, $sql, $tipos = '', $parametros = array())
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
 * Lista las categorías principales (id_padre = 0) o las subcategorías de un padre.
 * Cada fila trae 'cantidad_subcategorias'.
 */
function categorias_listar($conexion, $id_padre = 0)
{
    $campos = 'SELECT c.id, c.nombre, c.categoria_padre_id, c.activo,
                      (SELECT COUNT(*) FROM categorias s WHERE s.categoria_padre_id = c.id) AS cantidad_subcategorias
               FROM categorias c ';
    if ($id_padre === 0) {
        return categoria_consultar($conexion, $campos . 'WHERE c.categoria_padre_id IS NULL ORDER BY c.nombre');
    }
    return categoria_consultar($conexion, $campos . 'WHERE c.categoria_padre_id = ? ORDER BY c.nombre', 'i', array($id_padre));
}

/** Devuelve una categoría (principal o sub) por id, o null si no existe. */
function categoria_obtener($conexion, $id)
{
    $filas = categoria_consultar(
        $conexion,
        'SELECT id, nombre, categoria_padre_id, activo FROM categorias WHERE id = ?',
        'i',
        array($id)
    );
    return count($filas) > 0 ? $filas[0] : null;
}

/** Devuelve la categoría solo si es principal (sin padre), o null. */
function categoria_obtener_principal($conexion, $id)
{
    $categoria = categoria_obtener($conexion, $id);
    if ($categoria !== null && $categoria['categoria_padre_id'] === null) {
        return $categoria;
    }
    return null;
}

/** valida que la categoria exista, que el nombre no se repita, ingresar un noimbre obligatorio */
function categoria_validar($conexion, $nombre, $id_padre, $id_excluir = 0)
{
    $nombre = trim($nombre);
    if ($nombre === '') {
        return 'El nombre es obligatorio.';
    }
    if (mb_strlen($nombre) > 100) {
        return 'El nombre no puede superar los 100 caracteres.';
    }
    if ($id_padre !== null && categoria_obtener_principal($conexion, $id_padre) === null) {
        return 'La categoría principal elegida no existe.';
    }
    // Nombre repetido dentro del mismo padre (<=> compara también NULL con NULL)
    $repetidas = categoria_consultar(
        $conexion,
        'SELECT id FROM categorias WHERE nombre = ? AND categoria_padre_id <=> ? AND id <> ?',
        'sii',
        array($nombre, $id_padre, $id_excluir)
    );
    if (count($repetidas) > 0) {
        return $id_padre === null
            ? 'Ya existe una categoría con ese nombre.'
            : 'Ya existe una subcategoría con ese nombre dentro de esta categoría.';
    }
    return '';
}

/** Crea una categoría (id_padre null) o subcategoría. Devuelve el id nuevo. */
function categoria_crear($conexion, $nombre, $id_padre = null)
{
    $nombre = trim($nombre);
    $stmt = mysqli_prepare($conexion, 'INSERT INTO categorias (nombre, categoria_padre_id, activo) VALUES (?, ?, 1)');
    mysqli_stmt_bind_param($stmt, 'si', $nombre, $id_padre);
    mysqli_stmt_execute($stmt);
    $id = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    return $id;
}

/** Modifica el nombre. Devuelve true si la categoría existe. */
function categoria_actualizar($conexion, $id, $nombre)
{
    $nombre = trim($nombre);
    $stmt = mysqli_prepare($conexion, 'UPDATE categorias SET nombre = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $nombre, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return categoria_obtener($conexion, $id) !== null;
}

/** Activa o inactiva (baja lógica). Devuelve el nuevo estado (1/0) o null si no existe. */
function categoria_cambiar_estado($conexion, $id)
{
    $categoria = categoria_obtener($conexion, $id);
    if ($categoria === null) {
        return null;
    }
    $nuevo = $categoria['activo'] ? 0 : 1;
    $stmt = mysqli_prepare($conexion, 'UPDATE categorias SET activo = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'ii', $nuevo, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $nuevo;
}

/** arma ewl menu del sitio con solo las categorias activas. */
function categorias_menu_publico($conexion)
{
    $filas = categoria_consultar(
        $conexion,
        'SELECT p.id AS id_principal, p.nombre AS principal, s.id AS id_sub, s.nombre AS sub
         FROM categorias p
         LEFT JOIN categorias s ON s.categoria_padre_id = p.id AND s.activo = 1
         WHERE p.categoria_padre_id IS NULL AND p.activo = 1
         ORDER BY p.nombre, s.nombre'
    );
    $menu = array();
    foreach ($filas as $fila) {
        if (!isset($menu[$fila['principal']])) {
            $menu[$fila['principal']] = array();
        }
        if ($fila['id_sub'] !== null) {
            $menu[$fila['principal']][] = array('id' => $fila['id_sub'], 'nombre' => $fila['sub']);
        }
    }
    return $menu;
}