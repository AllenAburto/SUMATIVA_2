<div class="column is-narrow admin-sidebar" style="width:220px;">
    <aside class="menu">
        <p class="menu-label">Administración</p>
        <ul class="menu-list">
            <li><a href="index.php?page=admin" class="<?= ($adminPage ?? '') === 'dashboard' ? 'is-active' : '' ?>">
                <span class="icon"><i class="fas fa-tachometer-alt"></i></span> Dashboard
            </a></li>
            <li><a href="index.php?page=admin_productos" class="<?= ($adminPage ?? '') === 'productos' ? 'is-active' : '' ?>">
                <span class="icon"><i class="fas fa-boxes"></i></span> Productos
            </a></li>
            <li><a href="index.php?page=admin_ordenes" class="<?= ($adminPage ?? '') === 'ordenes' ? 'is-active' : '' ?>">
                <span class="icon"><i class="fas fa-receipt"></i></span> Órdenes
            </a></li>
        </ul>
        <p class="menu-label mt-4">Cuenta</p>
        <ul class="menu-list">
            <li><a href="index.php">
                <span class="icon"><i class="fas fa-store"></i></span> Ver tienda
            </a></li>
            <li><a href="index.php?page=logout" style="color:#f87171;">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span> Salir
            </a></li>
        </ul>
    </aside>
</div>