<?php
$lista_categorias = array(
    array('id' => 1,  'nombre' => 'Cuidado personal',    'id_padre' => 0, 'activo' => true),
    array('id' => 2,  'nombre' => 'Dermocosmética',      'id_padre' => 0, 'activo' => true),
    array('id' => 3,  'nombre' => 'Perfumería',          'id_padre' => 0, 'activo' => true),
    array('id' => 4,  'nombre' => 'Cuidado facial',      'id_padre' => 1, 'activo' => true),
    array('id' => 5,  'nombre' => 'Cuidado del cabello', 'id_padre' => 1, 'activo' => true),
    array('id' => 6,  'nombre' => 'Higiene personal',    'id_padre' => 1, 'activo' => true),
    array('id' => 7,  'nombre' => 'Protección solar',    'id_padre' => 2, 'activo' => true),
    array('id' => 8,  'nombre' => 'Hidratación',         'id_padre' => 2, 'activo' => true),
    array('id' => 9,  'nombre' => 'Perfumes',            'id_padre' => 3, 'activo' => true),
    array('id' => 10, 'nombre' => 'Desodorantes',        'id_padre' => 3, 'activo' => true),
    array('id' => 11, 'nombre' => 'Maquillaje',          'id_padre' => 0, 'activo' => false),
    array('id' => 12, 'nombre' => 'Labiales',            'id_padre' => 11, 'activo' => false),
);

$categorias = array();
foreach ($lista_categorias as $principal) {
    if ($principal['id_padre'] === 0 && $principal['activo']) {
        $subs = array();
        foreach ($lista_categorias as $sub) {
            if ($sub['id_padre'] === $principal['id'] && $sub['activo']) {
                array_push($subs, $sub['nombre']);
            }
        }
        $categorias[$principal['nombre']] = $subs;
    }
}