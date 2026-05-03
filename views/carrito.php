<?php
$pageTitle    = 'Carrito de Compras — TechHub Store';
$extraScripts = ['carrito.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="title is-3">
            <span class="icon has-text-primary"><i class="fas fa-shopping-cart"></i></span>
            Carrito de Compras
        </h1>
        <div id="btnVaciarWrap" style="display:none;margin-bottom:1rem;">
            <button onclick="vaciarCarrito()" class="button is-danger is-outlined is-small">
                <span class="icon"><i class="fas fa-trash-alt"></i></span>
                <span>Vaciar carrito</span>
            </button>
        </div>

        <div id="cartEmpty" style="display:none;">
            <div class="notification is-info is-light has-text-centered py-6">
                <p style="font-size:4rem;">🛒</p>
                <h3 class="title is-4 mt-3">Tu carrito está vacío</h3>
                <p class="mb-4">Agrega productos desde el catálogo.</p>
                <a href="index.php?page=catalogo" class="button is-primary">
                    <span class="icon"><i class="fas fa-laptop"></i></span>
                    <span>Ver Catálogo</span>
                </a>
            </div>
        </div>

        <div class="columns is-variable is-6" id="cartTable">
            <div class="column is-8">
                <div class="cart-table-wrap">
                    <table class="table is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="has-text-right">Precio</th>
                                <th>Cantidad</th>
                                <th class="has-text-right">Subtotal</th>
                                <th class="has-text-centered">Quitar</th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="column is-4">
                <div class="cart-summary">
                    <h3 class="title is-5 mb-4">Resumen del pedido</h3>

                    <div class="is-flex is-justify-content-space-between mb-3">
                        <span>Subtotal</span>
                        <span id="cartTotal" class="has-text-weight-semibold">$0</span>
                    </div>
                    <div class="is-flex is-justify-content-space-between mb-4 has-text-grey is-size-7">
                        <span>Envío</span>
                        <span class="has-text-success">Gratis</span>
                    </div>
                    <hr>
                    <div class="is-flex is-justify-content-space-between mb-5">
                        <strong>Total</strong>
                        <strong id="cartTotalFinal" class="has-text-primary is-size-5">$0</strong>
                    </div>

                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a id="checkoutBtn" href="index.php?page=checkout"
                           class="button is-primary is-fullwidth is-medium">
                            <span class="icon"><i class="fas fa-credit-card"></i></span>
                            <span>Proceder al pago</span>
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=login" class="button is-primary is-fullwidth is-medium">
                            <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                            <span>Ingresar para comprar</span>
                        </a>
                    <?php endif; ?>

                    <a href="index.php?page=catalogo" class="button is-light is-fullwidth mt-3">
                        <span class="icon"><i class="fas fa-arrow-left"></i></span>
                        <span>Seguir comprando</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const cartTotal = document.getElementById('cartTotal');
const cartFinal = document.getElementById('cartTotalFinal');
if (cartTotal && cartFinal) {
    new MutationObserver(() => { cartFinal.textContent = cartTotal.textContent; })
        .observe(cartTotal, { childList: true, characterData: true, subtree: true });
}
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>