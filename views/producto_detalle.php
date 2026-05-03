<?php
$pageTitle    = htmlspecialchars($producto['nombre']) . ' — TechHub Store';
$extraScripts = ['carrito.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">

        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.php?page=catalogo">Catálogo</a></li>
                <li><a href="index.php?page=catalogo&categoria=<?= htmlspecialchars($producto['categoria']) ?>"><?= ucfirst($producto['categoria']) ?></a></li>
                <li class="is-active"><a><?= htmlspecialchars($producto['nombre']) ?></a></li>
            </ul>
        </nav>

        <div class="columns is-variable is-8">

            <div class="column is-5">
                <img class="product-detail__img"
                     src="Frontend/img/productos/<?= htmlspecialchars($producto['imagen'] ?? '') ?>"
                     alt="<?= htmlspecialchars($producto['nombre']) ?>"
                     onerror="this.src='';this.alt='Sin imagen'">
            </div>

            <div class="column is-7">
                <?php if ($producto['destacado']): ?>
                    <span class="tag is-warning mb-3"><i class="fas fa-star mr-1"></i> Producto Destacado</span>
                <?php endif; ?>

                <h1 class="title is-3"><?= htmlspecialchars($producto['nombre']) ?></h1>

                <div class="tags mb-3">
                    <span class="tag is-light is-medium">
                        <i class="fas fa-tag mr-1"></i><?= ucfirst($producto['categoria']) ?>
                    </span>
                    <?php if ($producto['marca']): ?>
                    <span class="tag is-light is-medium">
                        <i class="fas fa-industry mr-1"></i><?= htmlspecialchars($producto['marca']) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <p class="product-detail__price mb-4">
                    $<?= number_format($producto['precio'], 0, ',', '.') ?>
                </p>

                <?php if ($producto['descripcion']): ?>
                <div class="content mb-5">
                    <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
                </div>
                <?php endif; ?>

                <div class="box" style="background:#f9f9f9;">
                    <div class="columns is-mobile">
                        <div class="column">
                            <p class="is-size-7 has-text-grey">Disponibilidad</p>
                            <?php if ($producto['stock'] > 0): ?>
                                <p class="has-text-success has-text-weight-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    En stock (<?= $producto['stock'] ?> unidades)
                                </p>
                            <?php else: ?>
                                <p class="has-text-danger has-text-weight-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Sin stock
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($producto['stock'] > 0): ?>
                <div class="field has-addons mt-4">
                    <div class="control">
                        <input id="cantidadInput" class="input" type="number"
                               min="1" max="<?= $producto['stock'] ?>" value="1"
                               style="width:80px;">
                    </div>
                    <div class="control">
                        <button class="button is-primary is-medium"
                                onclick="addToCart(<?= $producto['id'] ?>, parseInt(document.getElementById('cantidadInput').value) || 1)">
                            <span class="icon"><i class="fas fa-cart-plus"></i></span>
                            <span>Agregar al carrito</span>
                        </button>
                    </div>
                </div>
                <?php else: ?>
                    <button class="button is-danger is-medium mt-4" disabled>
                        <span class="icon"><i class="fas fa-times"></i></span>
                        <span>Sin stock</span>
                    </button>
                <?php endif; ?>

                <div class="mt-4">
                    <a href="index.php?page=catalogo" class="has-text-grey is-size-7">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>