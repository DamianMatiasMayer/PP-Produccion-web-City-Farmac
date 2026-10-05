<?php /** @var string $tipo  'exito' o 'error' */ ?>
<?php /** @var string $mensaje */ ?>
<p class="aviso aviso-<?php echo $tipo; ?>" role="<?php echo $tipo === 'error' ? 'alert' : 'status'; ?>">
    <?php echo htmlspecialchars($mensaje); ?>
</p>