<?php
$titulo = 'Contáctenos';
require_once __DIR__ . '/../../config.php';

// Mensaje simulado(todavia es estatico)
$enviado = ($_SERVER['REQUEST_METHOD'] === 'POST');

require_once __DIR__ . '/../../includes/publico/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/contacto.css">

<main>
    <section>
        <h1>Contáctenos</h1>
        <p>Escribinos tu consulta y te respondemos a la brevedad.</p>

        <?php if ($enviado) {
            $tipo = 'exito';
            $mensaje = '¡Gracias por escribirnos! Recibimos tu mensaje.';
            include __DIR__ . '/../../includes/componentes/aviso.php';
        } ?>

        <form action="" method="post" class="formulario-contacto">
            <div class="campo">
                <label for="nombre">Nombre y apellido</label>
                <input type="text" id="nombre" name="nombre" required maxlength="100"
                       autocomplete="name">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required maxlength="120"
                       autocomplete="email">
            </div>

            <div class="campo">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" required
                       pattern="[0-9+\s\-]{8,20}" maxlength="20" autocomplete="tel"
                       placeholder="Ej: 11 2345-6789">
            </div>

            <div class="campo">
                <label for="area">Área de la empresa</label>
                <select id="area" name="area" required>
                    <option value="">Seleccioná un área</option>
                    <option value="atencion">Atención al cliente</option>
                    <option value="ventas">Ventas</option>
                    <option value="administracion">Administración</option>
                    <option value="rrhh">Recursos humanos</option>
                    <option value="marketing">Marketing</option>
                </select>
            </div>

            <div class="campo">
                <label for="comentario">Comentario</label>
                <textarea id="comentario" name="comentario" rows="5" required
                          minlength="10" maxlength="1000"></textarea>
            </div>

            <button type="submit">Enviar mensaje</button>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../../includes/publico/footer.php'; ?>