<?php
$pageTitle    = 'Panel Admin — TechHub Store';
$extraScripts = ['admin.js'];
$adminPage    = 'dashboard';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/sidebar.php';
?>

<div class="columns is-gapless" style="min-height:calc(100vh - 52px);">
    <?php include __DIR__ . '/sidebar_desktop.php'; ?>

    <div class="column p-4">
        <h1 class="title is-4 mb-5">
            <i class="fas fa-tachometer-alt mr-2 has-text-primary"></i>Dashboard
        </h1>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
            <div class="stat-card">
                <div class="stat-card__icon has-background-primary-light">
                    <i class="fas fa-boxes has-text-primary"></i>
                </div>
                <div>
                    <div class="stat-card__value"><?= $totalProductos ?></div>
                    <div class="stat-card__label">Productos activos</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon has-background-info-light">
                    <i class="fas fa-receipt has-text-info"></i>
                </div>
                <div>
                    <div class="stat-card__value"><?= $totalOrdenes ?></div>
                    <div class="stat-card__label">Órdenes totales</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon has-background-success-light">
                    <i class="fas fa-users has-text-success"></i>
                </div>
                <div>
                    <div class="stat-card__value"><?= $totalUsuarios ?></div>
                    <div class="stat-card__label">Clientes</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon has-background-warning-light">
                    <i class="fas fa-dollar-sign has-text-warning"></i>
                </div>
                <div>
                    <div class="stat-card__value" style="font-size:1.3rem;">
                        $<?= number_format($ingresos, 0, ',', '.') ?>
                    </div>
                    <div class="stat-card__label">Ingresos completados</div>
                </div>
            </div>
        </div>

        <div class="box">
            <h3 class="title is-6 mb-4">Acciones rápidas</h3>
            <div class="buttons is-flex-wrap-wrap">
                <a href="index.php?page=admin_producto_form" class="button is-primary">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Agregar producto</span>
                </a>
                <a href="index.php?page=admin_productos" class="button is-info is-outlined">
                    <span class="icon"><i class="fas fa-boxes"></i></span>
                    <span>Ver productos</span>
                </a>
                <a href="index.php?page=admin_ordenes" class="button is-warning is-outlined">
                    <span class="icon"><i class="fas fa-receipt"></i></span>
                    <span>Ver órdenes</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>