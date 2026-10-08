<?php
/** @var string $titulo */
$mostrar_menu = isset($mostrar_menu) ? $mostrar_menu : true;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?> | Panel <?php echo NOMBRE_SITIO; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
</head>
<body>
    <header class="panel-header">
        <a href="<?php echo BASE_URL; ?>vistas/admin/inicio.php"><?php echo NOMBRE_SITIO; ?> - Panel</a>
        <?php if ($mostrar_menu) { ?>
            <nav aria-label="Secciones del panel">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>vistas/admin/salir.php">Salir</a></li>
                </ul>
            </nav>
        <?php } ?>
    </header>