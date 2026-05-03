<?php
$pageTitle    = 'Catálogo — TechHub Store';
$extraScripts = ['productos.js', 'carrito.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="title is-3">
            <span class="icon has-text-primary"><i class="fas fa-laptop"></i></span>
            Catálogo de Productos
        </h1>

        <div class="filter-bar">
            <div class="filter-bar__search">
                <div class="control has-icons-left">
                    <input id="searchInput" class="input" type="text"
                           placeholder="Buscar productos..."
                           value="<?= htmlspecialchars($query ?? '') ?>">
                    <span class="icon is-left"><i class="fas fa-search"></i></span>
                </div>
            </div>

            <div class="filter-bar__selects">
                <div class="select">
                    <select id="categoriaSelect">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= $c ?>" <?= ($categoria ?? '') === $c ? 'selected' : '' ?>>
                                <?= ucfirst($c) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="select">
                    <select id="ordenSelect">
                        <option value="nombre_asc"  <?= ($orden ?? '') === 'nombre_asc'  ? 'selected' : '' ?>>Nombre A-Z</option>
                        <option value="nombre_desc" <?= ($orden ?? '') === 'nombre_desc' ? 'selected' : '' ?>>Nombre Z-A</option>
                        <option value="precio_asc"  <?= ($orden ?? '') === 'precio_asc'  ? 'selected' : '' ?>>Precio menor</option>
                        <option value="precio_desc" <?= ($orden ?? '') === 'precio_desc' ? 'selected' : '' ?>>Precio mayor</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="productsGrid" class="products-grid">
            <?php if (empty($productos)): ?>
                <div class="notification is-warning is-light" style="grid-column:1/-1;text-align:center;">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <p>No se encontraron productos.</p>
                </div>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                <div class="product-card fade-in">
                    <div class="product-card__img-wrap">
                        <?= productoImg($p['imagen'] ?? '', $p['nombre']) ?>
                        <?php if ($p['destacado']): ?>
                            <span class="product-card__badge tag is-warning is-small">
                                <i class="fas fa-star mr-1"></i>Destacado
                            </span>
                        <?php elseif ($p['stock'] == 0): ?>
                            <span class="product-card__badge tag is-danger is-small">Sin stock</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-card__body">
                        <p class="product-card__title"><?= htmlspecialchars($p['nombre']) ?></p>
                        <p class="product-card__brand"><?= htmlspecialchars($p['marca'] ?? '') ?></p>
                        <span class="tag is-small tag-categoria-<?= $p['categoria'] ?>"><?= ucfirst($p['categoria']) ?></span>
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
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>