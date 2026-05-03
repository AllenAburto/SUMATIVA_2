<?php
$adminPage = $adminPage ?? '';
?>

<nav class="admin-mobile-nav">
    <a href="index.php?page=admin" class="<?= $adminPage === 'dashboard' ? 'is-active' : '' ?>">
        <i class="fas fa-tachometer-alt"></i>Dashboard
    </a>
    <a href="index.php?page=admin_productos" class="<?= $adminPage === 'productos' ? 'is-active' : '' ?>">
        <i class="fas fa-boxes"></i>Productos
    </a>
    <a href="index.php?page=admin_ordenes" class="<?= $adminPage === 'ordenes' ? 'is-active' : '' ?>">
        <i class="fas fa-receipt"></i>Ordenes
    </a>
    <a href="index.php?page=admin_producto_form">
        <i class="fas fa-plus"></i>Nuevo
    </a>
    <a href="index.php">
        <i class="fas fa-store"></i>Tienda
    </a>
    <a href="index.php?page=logout" style="color:#f87171;">
        <i class="fas fa-sign-out-alt"></i>Salir
    </a>
</nav>