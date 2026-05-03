<?php
$pageTitle = 'Checkout — TechHub Store';
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="title is-3">
            <span class="icon has-text-primary"><i class="fas fa-credit-card"></i></span>
            Finalizar Compra
        </h1>

        <?php if (!empty($error)): ?>
            <div class="notification is-danger mb-4" style="border-left:4px solid #f14668;">
                <p class="has-text-weight-bold mb-2">
                    <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
                    No se pudo procesar el pedido
                </p>
                <p class="mb-3"><?= htmlspecialchars($error) ?></p>
                <a href="index.php?page=carrito" class="button is-white is-small">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Volver al carrito para ajustar cantidades</span>
                </a>
            </div>
        <?php endif; ?>

        <div class="columns is-variable is-6">

            <div class="column is-7">
                <div class="box">
                    <h3 class="title is-5 mb-4">
                        <i class="fas fa-map-marker-alt mr-2 has-text-primary"></i>
                        Datos de envío
                    </h3>

                    <form action="index.php?page=checkout" method="POST">

                        <div class="field">
                            <label class="label">Nombre completo</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text"
                                       value="<?= htmlspecialchars($_SESSION['nombre']) ?>" readonly>
                                <span class="icon is-left"><i class="fas fa-user"></i></span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email"
                                       value="<?= htmlspecialchars($_SESSION['email']) ?>" readonly>
                                <span class="icon is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Dirección de envío <span class="has-text-danger">*</span></label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="direccion"
                                       placeholder="Calle, número, ciudad"
                                       value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>"
                                       required>
                                <span class="icon is-left"><i class="fas fa-home"></i></span>
                            </div>
                        </div>

                        <div class="notification is-warning is-light is-size-7 mt-4">
                            <i class="fas fa-info-circle mr-2"></i>
                            Pago contra entrega. Este es un proyecto académico.
                        </div>

                        <button type="submit" class="button is-primary is-fullwidth is-medium mt-4">
                            <span class="icon"><i class="fas fa-check-circle"></i></span>
                            <span>Confirmar Pedido</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="column is-5">
                <div class="box">
                    <h3 class="title is-5 mb-4">
                        <i class="fas fa-list-alt mr-2 has-text-primary"></i>
                        Tu pedido
                    </h3>

                    <table class="table is-fullwidth is-narrow">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="has-text-centered">Cant.</th>
                                <th class="has-text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="is-size-7"><?= htmlspecialchars($item['nombre']) ?></td>
                                <td class="has-text-centered is-size-7"><?= $item['cantidad'] ?></td>
                                <td class="has-text-right is-size-7">
                                    $<?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th class="has-text-right has-text-primary">
                                    $<?= number_format($total, 0, ',', '.') ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="has-text-centered mt-3 is-size-7 has-text-grey">
                        <i class="fas fa-truck mr-1"></i> Envío gratis a todo Chile
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>