# PP-Produccion-web-City-Farmac
City Farmac - Maquetado y templates del sitio público y panel de administración en PHP, HTML, CSS y JS.

# City Farmac — Instancia 1: Template y vistas

Maquetado del sitio público y del panel de administración de una farmacia online.

Integrantes: Franco Di Giovanni y Damián Matías Mayer

## Alcance

Esta instancia es solo maquetado: no hay base de datos. Los datos son arrays de ejemplo
(`datosTemporales/`) y los formularios muestran un mensaje simulado, salvo el login del panel,
que valida contra credenciales de prueba definidas en `config.php`.

## Tecnologías

PHP 8+, HTML5, CSS3 (Flexbox, Grid y media queries) y JavaScript.

## Cómo abrir el proyecto

1. Copiar la carpeta del proyecto dentro de `htdocs` (XAMPP).
2. Configurá la ruta base.
	En `config.php`, en la constante `BASE_URL`. Es la ruta de la carpeta del proyecto
	dentro del servidor, empezando y terminando con `/`. Todos los links, imágenes, CSS y
	redirecciones parten de ella, así que es el único lugar que hay que cambiar.

Ejemplos:

- Proyecto en `htdocs/PP-Produccion-web-City-Farmac/` → `define('BASE_URL', '/PP-Produccion-web-City-Farmac/');`
- Proyecto en `htdocs/ProduccionWeb/PP-Produccion-web-City-Farmac/` → `define('BASE_URL', '/ProduccionWeb/PP-Produccion-web-City-Farmac/');`

3. Iniciá Apache y abrí `localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/index.php` en el navegador.



## Acceso al panel

El panel está protegido por sesión. Credenciales de prueba:

- **Email:** `admin@cityfarmac.com`
- **Contraseña:** `admin123`

Se definen en `config.php` (`ADMIN_EMAIL` y `ADMIN_CLAVE`). Para abrir las vistas del panel
sin loguearse, poné `PANEL_PROTEGIDO` en `false`. El registro muestra un aviso de éxito, pero
no guarda usuarios.
