<?php
$pageTitle = 'Orden #' . $orden['id'] . ' — TechHub Store';
include __DIR__ . '/layout/header.php';

$estadoClases = [
    'pendiente'  => 'is-warning',
    'completada' => 'is-success',
    'cancelada'  => 'is-danger',
];
?>

<section class="section">
    <div class="container">

        <?php if (isset($_GET['exito'])): ?>
        <div class="notification is-success mb-5">
            <button class="delete" onclick="this.parentElement.remove()"></button>
            <i class="fas fa-check-circle mr-2"></i>
            <strong>¡Pedido realizado con éxito!</strong>
            Tu orden <strong>#<?= $orden['id'] ?></strong> ha sido registrada.
        </div>
        <?php endif; ?>

        <div class="is-flex is-align-items-center is-justify-content-space-between mb-5">
            <h1 class="title is-3 mb-0">
                <span class="icon has-text-primary"><i class="fas fa-receipt"></i></span>
                Orden #<?= $orden['id'] ?>
            </h1>
            <a href="index.php?page=historial" class="button is-light">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Mis órdenes</span>
            </a>
        </div>

        <div class="columns">
            <div class="column is-4">
                <div class="box">
                    <h3 class="title is-6 mb-3">Información del pedido</h3>
                    <table class="table is-narrow is-fullwidth">
                        <tr>
                            <td class="has-text-grey is-size-7">Fecha</td>
                            <td class="is-size-7"><?= date('d/m/Y H:i', strtotime($orden['fecha_orden'])) ?></td>
                        </tr>
                        <tr>
                            <td class="has-text-grey is-size-7">Estado</td>
                            <td>
                                <span class="tag <?= $estadoClases[$orden['estado']] ?? 'is-light' ?>">
                                    <?= ucfirst($orden['estado']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="has-text-grey is-size-7">Dirección</td>
                            <td class="is-size-7"><?= htmlspecialchars($orden['direccion_envio']) ?></td>
                        </tr>
                        <tr>
                            <td class="has-text-grey is-size-7">Total</td>
                            <td class="has-text-weight-bold has-text-primary">
                                $<?= number_format($orden['total'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="column is-8">
                <div class="box p-0" style="overflow:hidden;">
                    <table class="table is-fullwidth mb-0">
                        <thead class="has-background-light">
                            <tr>
                                <th>Producto</th>
                                <th class="has-text-centered">Cant.</th>
                                <th class="has-text-right">Precio unit.</th>
                                <th class="has-text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orden['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="is-flex is-align-items-center" style="gap:.75rem">
                                        <figure class="image is-32x32" style="flex-shrink:0;">
                                            <img src="Frontend/img/productos/<?= htmlspecialchars($item['imagen'] ?? '') ?>"
                                                 alt="<?= htmlspecialchars($item['nombre']) ?>"
                                                 style="object-fit:contain;height:32px;">
                                        </figure>
                                        <span><?= htmlspecialchars($item['nombre']) ?></span>
                                    </div>
                                </td>
                                <td class="has-text-centered"><?= $item['cantidad'] ?></td>
                                <td class="has-text-right">
                                    $<?= number_format($item['precio_unitario'], 0, ',', '.') ?>
                                </td>
                                <td class="has-text-right has-text-weight-semibold">
                                    $<?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="has-text-right">Total</th>
                                <th class="has-text-right has-text-primary">
                                    $<?= number_format($orden['total'], 0, ',', '.') ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>