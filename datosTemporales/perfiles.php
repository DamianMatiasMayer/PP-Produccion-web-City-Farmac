<?php
// Datos de ejemplo de perfiles (sin base de datos).

$secciones_panel = array(
    'productos'   => 'Productos',
    'categorias'  => 'Categorías',
    'marcas'      => 'Marcas',
    'comentarios' => 'Comentarios',
    'usuarios'    => 'Usuarios',
    'perfiles'    => 'Perfiles',
);

$perfiles = array(
    array('id' => 1, 'nombre' => 'Administrador',            'activo' => true,  'secciones' => array('productos', 'categorias', 'marcas', 'comentarios', 'usuarios', 'perfiles')),
    array('id' => 2, 'nombre' => 'Editor de catálogo',       'activo' => true,  'secciones' => array('productos', 'categorias', 'marcas')),
    array('id' => 3, 'nombre' => 'Moderador de comentarios', 'activo' => true,  'secciones' => array('comentarios')),
    array('id' => 4, 'nombre' => 'Consulta',                 'activo' => false, 'secciones' => array('productos', 'categorias', 'marcas')),
);