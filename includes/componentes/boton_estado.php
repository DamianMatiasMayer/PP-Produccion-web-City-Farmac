<?php /** @var int $id_item */ ?>
<?php /** @var bool $activo */ ?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $id_item; ?>">
    <button type="submit" name="cambiar_estado" class="boton-texto">
        <?php echo $activo ? 'Inactivar' : 'Activar'; ?>
    </button>
</form>