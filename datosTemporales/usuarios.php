<?php
// Datos de ejemplo de usuarios del panel (Instancia 1: sin base de datos).
// 'perfil_id' coincide con el 'id' de datosTemporales/perfiles.php.
// Las contraseñas NO se guardan acá: en esta instancia el formulario no persiste nada.
$usuarios = array(
    array('id' => 1, 'nombre' => 'Administrador del sistema', 'email' => 'admin@cityfarmac.com',         'perfil_id' => 1, 'activo' => true),
    array('id' => 2, 'nombre' => 'Laura Fernández',           'email' => 'laura.fernandez@cityfarmac.com', 'perfil_id' => 2, 'activo' => true),
    array('id' => 3, 'nombre' => 'Martín Gómez',              'email' => 'martin.gomez@cityfarmac.com',    'perfil_id' => 3, 'activo' => true),
    array('id' => 4, 'nombre' => 'Sofía Ramírez',             'email' => 'sofia.ramirez@cityfarmac.com',   'perfil_id' => 2, 'activo' => false),
    array('id' => 5, 'nombre' => 'Carlos Díaz',               'email' => 'carlos.diaz@cityfarmac.com',     'perfil_id' => 3, 'activo' => false),
);