<?php
session_start();

if (PANEL_PROTEGIDO && !isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . 'vistas/admin/login.php');
    exit();
}