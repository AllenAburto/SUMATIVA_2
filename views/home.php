<?php
$pageTitle    = 'TechHub Store — Tecnología al mejor precio';
$extraScripts = ['carrito.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="hero-techhub">
    <div class="container" style="position:relative;z-index:1;">
        <div class="columns is-vcentered">
            <div class="column is-7">
                <h1 class="title is-1 has-text-white mb-4" style="line-height:1.15;">
                    La mejor tecnología<br>
                    <span class="has-text-primary">al alcance de todos</span>
                </h1>
                <p class="subtitle has-text-grey-light mb-5" style="font-size:1.1rem;">
                    Notebooks, tablets, accesorios y más.<br>Envío rápido a todo Chile.
                </p>
                <div class="buttons">
                    <a href="index.php?page=catalogo" class="button is-primary is-medium is-rounded">
                        <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                        <span>Ver Catálogo</span>
                    </a>
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <a href="index.php?page=registro" class="button is-medium is-rounded"
                       style="background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.3);">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span>Crear cuenta</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="column is-5 has-text-centered is-hidden-mobile">
                <span style="font-size:8rem;opacity:.5;filter:drop-shadow(0 0 40px rgba(0,209,178,.4));">🖥️</span>
            </div>
        </div>
    </div>
</section>

<section class="section pb-2">
    <div class="container">
        <h2 class="section-title">
            <span class="icon has-text-primary"><i class="fas fa-th-large"></i></span>
            Categorías
        </h2>
        <div class="columns is-multiline">
            <?php
            $cats = [
                ['slug' => 'notebooks',   'icon' => 'fa-laptop',     'label' => 'Notebooks',   'bg' => '#e8f4fd', 'color' => '#1a73e8'],
                ['slug' => 'tablets',     'icon' => 'fa-tablet-alt', 'label' => 'Tablets',     'bg' => '#e8fdf5', 'color' => '#00a67e'],
                ['slug' => 'accesorios',  'icon' => 'fa-headphones', 'label' => 'Accesorios',  'bg' => '#fff8e1', 'color' => '#f59e0b'],
                ['slug' => 'monitores',   'icon' => 'fa-desktop',    'label' => 'Monitores',   'bg' => '#f3e8ff', 'color' => '#7c3aed'],
                ['slug' => 'perifericos', 'icon' => 'fa-keyboard',   'label' => 'Periféricos', 'bg' => '#ffe8e8', 'color' => '#ef4444'],
            ];
            foreach ($cats as $cat): ?>
            <div class="column is-one-fifth-desktop is-half-tablet">
                <a href="index.php?page=catalogo&categoria=<?= $cat['slug'] ?>"
                   class="box has-text-centered is-clickable"
                   style="border:2px solid transparent;transition:all .2s ease;"
                   onmouseover="this.style.borderColor='<?= $cat['color'] ?>'"
                   onmouseout="this.style.borderColor='transparent'">
                    <div style="width:56px;height:56px;border-radius:14px;background:<?= $cat['bg'] ?>;
                         display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                        <i class="fas <?= $cat['icon'] ?> fa-lg" style="color:<?= $cat['color'] ?>"></i>
                    </div>
                    <p class="has-text-weight-semibold is-size-6"><?= $cat['label'] ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">
            <span class="icon has-text-warning"><i class="fas fa-star"></i></span>
            Productos Destacados
        </h2>

        <?php if (empty($destacados)): ?>
            <div class="notification is-info is-light">No hay productos destacados por el momento.</div>
        <?php else: ?>
        <div class="products-grid products-grid--featured">
            <?php foreach ($destacados as $p): ?>
            <div class="product-card">
                <div class="product-card__img-wrap">
                    <?= productoImg($p['imagen'] ?? '', $p['nombre']) ?>
                    <span class="product-card__badge tag is-warning is-small">
                        <i class="fas fa-star mr-1"></i>Destacado
                    </span>
                </div>
                <div class="product-card__body">
                    <p class="product-card__title"><?= htmlspecialchars($p['nombre']) ?></p>
                    <p class="product-card__brand"><?= htmlspecialchars($p['marca'] ?? '') ?></p>
                    <p class="product-card__price">$<?= number_format($p['precio'], 0, ',', '.') ?></p>
                </div>
                <div class="product-card__footer">
                    <a href="index.php?page=producto&id=<?= $p['id'] ?>" class="button is-light is-small">
                        <span class="icon"><i class="fas fa-eye"></i></span>
                        <span>Ver</span>
                    </a>
                    <?php if ($p['stock'] > 0): ?>
                    <button class="button is-primary is-small" onclick="addToCart(<?= $p['id'] ?>)">
                        <span class="icon"><i class="fas fa-cart-plus"></i></span>
                        <span>Agregar</span>
                    </button>
                    <?php else: ?>
                    <button class="button is-danger is-small" disabled>
                        <span class="icon"><i class="fas fa-times-circle"></i></span>
                        <span>Sin stock</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="has-text-centered mt-6">
            <a href="index.php?page=catalogo" class="button is-primary is-medium is-rounded px-6">
                <span>Ver todos los productos</span>
                <span class="icon ml-2"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>