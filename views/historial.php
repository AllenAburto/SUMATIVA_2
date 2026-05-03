<?php
$pageTitle = 'Mis Órdenes — TechHub Store';
include __DIR__ . '/layout/header.php';

$estadoClases = [
    'pendiente'  => 'is-warning',
    'completada' => 'is-success',
    'cancelada'  => 'is-danger',
];
?>

<section class="section">
    <div class="container">
        <h1 class="title is-3">
            <span class="icon has-text-primary"><i class="fas fa-list-alt"></i></span>
            Mis Órdenes
        </h1>

        <?php if (empty($ordenes)): ?>
            <div class="notification is-info is-light has-text-centered py-6">
                <p style="font-size:3rem;">📦</p>
                <h3 class="title is-5 mt-3">Aún no tienes órdenes</h3>
                <a href="index.php?page=catalogo" class="button is-primary mt-3">
                    Ir al catálogo
                </a>
            </div>
        <?php else: ?>
            <div class="box p-0" style="overflow:hidden;">
                <table class="table is-fullwidth is-hoverable mb-0">
                    <thead class="has-background-light">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th class="has-text-right">Total</th>
                            <th class="has-text-centered">Estado</th>
                            <th class="has-text-centered">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordenes as $orden): ?>
                        <tr>
                            <td><strong>#<?= $orden['id'] ?></strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($orden['fecha_orden'])) ?></td>
                            <td class="has-text-right has-text-weight-semibold">
                                $<?= number_format($orden['total'], 0, ',', '.') ?>
                            </td>
                            <td class="has-text-centered">
                                <span class="tag <?= $estadoClases[$orden['estado']] ?? 'is-light' ?>">
                                    <?= ucfirst($orden['estado']) ?>
                                </span>
                            </td>
                            <td class="has-text-centered">
                                <a href="index.php?page=orden_detalle&id=<?= $orden['id'] ?>"
                                   class="button is-small is-info is-outlined">
                                    <span class="icon"><i class="fas fa-eye"></i></span>
                                    <span>Ver</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>