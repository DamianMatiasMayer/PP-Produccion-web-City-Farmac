<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?> | <?php echo NOMBRE_SITIO; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/publico.css">
</head>
<body>
    <header>
        <a href="<?php echo BASE_URL; ?>index.php"><?php echo NOMBRE_SITIO; ?></a>
        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>
                <li><a href="<?php echo BASE_URL; ?>vistas/publico/listado.php">Productos</a></li>
                <li><a href="<?php echo BASE_URL; ?>vistas/publico/contacto.php">Contáctenos</a></li>
            </ul>
        </nav>
    </header>