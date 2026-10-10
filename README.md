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

## Listado de vistas y URL

URL base: `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/`

### Sitio público

| Vista | URL |
|---|---|
| Home | `index.php` |
| Listado de productos | `vistas/publico/listado.php` |
| Detalle de producto | `vistas/publico/detalle.php?id=1` (ids del 1 al 6) |
| Contáctenos | `vistas/publico/contacto.php` |
| Error 404 | `vistas/publico/404.php` |

### Panel de administración

URL base del panel: `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/vistas/admin/login.php`

| Vista | URL |
|---|---|
| Login | `vistas/admin/login.php` |
| Registro de usuario | `vistas/admin/registro.php` |
| Inicio del panel | `vistas/admin/inicio.php` |
| Productos | `vistas/admin/productos.php` |
| Productos (alta y edición) | `vistas/admin/producto_form.php` y `producto_form.php?id=1` |
| Categorías | `vistas/admin/categorias.php` |
| Categorías (alta y edición) | `vistas/admin/categoria_form.php` y `categoria_form.php?id=1` |
| Marcas | `vistas/admin/marcas.php` |
| Marcas (alta y edición) | `vistas/admin/marca_form.php` y `marca_form.php?id=1` |
| Comentarios | `vistas/admin/comentarios.php` |
| Comentarios de un producto | `vistas/admin/comentarios.php?producto=1` |
| Usuarios | `vistas/admin/usuarios.php` |
| Usuarios (alta y edición) | `vistas/admin/usuario_form.php` y `usuario_form.php?id=2` |
| Perfiles | `vistas/admin/perfiles.php` |
| Perfiles (alta y edición) | `vistas/admin/perfil_form.php` y `perfil_form.php?id=2` |
| Cerrar sesión | `vistas/admin/salir.php` |
