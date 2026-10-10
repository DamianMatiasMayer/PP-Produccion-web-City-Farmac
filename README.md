# City Farmac

Maquetado del sitio público y del panel de administración de City Farmac (PHP, HTML, CSS y JS).
**PP: Producción Web · Análisis de Sistemas — Da Vinci · Instancia 1 de 3 (Template y vistas)**
**Integrantes:** Damian Mayer · Franco Di Giovanni

En esta instancia no hay base de datos: los contenidos salen de `datosTemporales/` y los formularios muestran un mensaje simulado.

## Cómo abrir el proyecto

1. Instalar XAMPP (PHP 8 o superior) y copiar el proyecto en:
   `C:\xampp\htdocs\ProduccionWeb\PP-Produccion-web-City-Farmac\`
2. En el XAMPP Control Panel, iniciar **Apache**.
3. Abrir `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/`

Abrir siempre por `http://localhost/...`, no con doble clic en el archivo.

## Dónde se configura la ruta base

En `config.php`, constante `BASE_URL`. Todos los links, imágenes, CSS y JS se arman a partir de ella; si el proyecto cambia de carpeta, solo hay que editar esa línea:

```php
define('BASE_URL', '/ProduccionWeb/PP-Produccion-web-City-Farmac/');
```

## Acceso al panel

URL del panel: `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/vistas/admin/login.php`

Ingresar con las credenciales de demostración de `config.php`: `admin@cityfarmac.com` / `admin123`.
Con `PANEL_PROTEGIDO` en `false` (en `config.php`) las vistas del panel se abren sin iniciar sesión.

## Vistas y URL

URL base: `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/`

**Sitio público**

| Vista | URL |
|---|---|
| Home | `index.php` |
| Listado de productos | `vistas/publico/listado.php` |
| Detalle de producto | `vistas/publico/detalle.php?id=1` (ids del 1 al 6) |
| Contáctenos | `vistas/publico/contacto.php` |
| Error 404 | `vistas/publico/404.php` |

**Panel de administración** (URL base del panel: `http://localhost/ProduccionWeb/PP-Produccion-web-City-Farmac/vistas/admin/`)

| Vista | URL |
|---|---|
| Login / Registro | `login.php` / `registro.php` |
| Inicio del panel | `inicio.php` |
| Productos | `productos.php` · formulario: `producto_form.php` |
| Categorías | `categorias.php` · formulario: `categoria_form.php` |
| Marcas | `marcas.php` · formulario: `marca_form.php` |
| Comentarios | `comentarios.php` |
| Usuarios | `usuarios.php` · formulario: `usuario_form.php` |
| Perfiles | `perfiles.php` · formulario: `perfil_form.php` |
| Cerrar sesión | `salir.php` |

Los formularios de edición reciben el id por URL (por ejemplo, `usuario_form.php?id=2`).

## Estructura

```
assets/ (css, js, img)   Estilos, scripts e imágenes
datosTemporales/         Datos de ejemplo
includes/                publico/ y admin/ (header y footer de cada layout) y componentes/ (piezas reutilizables)
vistas/                  publico/ y admin/
config.php               Ruta base y configuración
index.php                Home
```