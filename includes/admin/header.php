<?php
/** @var string $titulo */
$mostrar_menu = isset($mostrar_menu) ? $mostrar_menu : true;


$pagina_actual = basename($_SERVER['SCRIPT_NAME']);
$secciones_menu = array(
    'inicio.php'      => array('Inicio',      array('inicio.php')),
    'productos.php'   => array('Productos',   array('productos.php', 'producto_form.php')),
    'categorias.php'  => array('Categorías',  array('categorias.php', 'categoria_form.php')),
    'marcas.php'      => array('Marcas',      array('marcas.php', 'marca_form.php')),
    'comentarios.php' => array('Comentarios', array('comentarios.php')),
    'usuarios.php'    => array('Usuarios',    array('usuarios.php', 'usuario_form.php')),
    'perfiles.php'    => array('Perfiles',    array('perfiles.php', 'perfil_form.php')),
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?> | Panel <?php echo NOMBRE_SITIO; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
</head>
<body>
    <header class="panel-header">
        <a href="<?php echo BASE_URL; ?>vistas/admin/inicio.php"><?php echo NOMBRE_SITIO; ?> · Panel</a>
        <?php if ($mostrar_menu) { ?>
        <nav aria-label="Secciones del panel">
            <ul>
                <?php foreach ($secciones_menu as $archivo => $seccion) { ?>
                    <?php $activa = in_array($pagina_actual, $seccion[1], true); ?>
                    <li>
                        <a href="<?php echo BASE_URL; ?>vistas/admin/<?php echo $archivo; ?>"
                           <?php if ($activa) { echo 'class="activo" aria-current="page"'; } ?>><?php echo $seccion[0]; ?></a>
                    </li>
                <?php } ?>
                <li><a href="<?php echo BASE_URL; ?>vistas/admin/salir.php">Salir</a></li>
            </ul>
        </nav>
        <?php } ?>
    </header>