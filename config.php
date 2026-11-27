<?php

function calcular_base_url()
{
    $raiz = str_replace('\\', '/', realpath(__DIR__));

    // Método 1: comparar el archivo ejecutado con su URL
    if (!empty($_SERVER['SCRIPT_FILENAME']) && !empty($_SERVER['SCRIPT_NAME'])) {
        $archivo = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME']));
        $url     = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);

        if ($archivo !== '' && strncasecmp($archivo, $raiz . '/', strlen($raiz) + 1) === 0) {
            $relativa = substr($archivo, strlen($raiz));   // ej: /vistas/admin/inicio.php
            $largo    = strlen($relativa);

            if (strlen($url) >= $largo && strcasecmp(substr($url, -$largo), $relativa) === 0) {
                return rtrim(substr($url, 0, -$largo), '/') . '/';
            }
        }
    }

    // Método 2: ubicar la carpeta del proyecto dentro del DOCUMENT_ROOT
    if (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $docroot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
        if ($docroot !== '' && strncasecmp($raiz, $docroot, strlen($docroot)) === 0) {
            $ruta = trim(substr($raiz, strlen($docroot)), '/');
            return $ruta === '' ? '/' : '/' . $ruta . '/';
        }
    }

    // Último recurso: el proyecto está en la raíz del servidor
    return '/';
}


define('BASE_URL', implode('/', array_map('rawurlencode', explode('/', calcular_base_url()))));
define('NOMBRE_SITIO', 'City Farmac');

define('ADMIN_EMAIL', 'admin@cityfarmac.com');
define('ADMIN_CLAVE', 'admin123');

// Poner en false para abrir las vistas del panel sin loguearse
define('PANEL_PROTEGIDO', true);