<?php
$pageTitle    = 'Gestión de Órdenes — Admin';
$extraScripts = ['admin.js'];
$adminPage    = 'ordenes';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/sidebar.php';

$estadoClases = [
    'pendiente'  => 'is-warning',
    'completada' => 'is-success',
    'cancelada'  => 'is-danger',
];
?>

<div class="columns is-gapless" style="min-height:calc(100vh - 52px);">
    <?php include __DIR__ . '/sidebar_desktop.php'; ?>
    <div class="column p-3">

        <h1 class="title is-4 mb-4">
            <i class="fas fa-receipt mr-2 has-text-primary"></i>Órdenes
        </h1>

        <?php if (empty($ordenes)): ?>
            <div class="notification is-info is-light">No hay órdenes registradas.</div>
        <?php else: ?>

        <div class="is-hidden-touch box p-0" style="overflow-x:auto;">
            <table class="table is-fullwidth is-hoverable mb-0">
                <thead class="has-background-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th class="has-text-right">Total</th>
                        <th class="has-text-centered">Estado</th>
                        <th class="has-text-centered">Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $orden): ?>
                    <tr>
                        <td><strong>#<?= $orden['id'] ?></strong></td>
                        <td><?= htmlspecialchars($orden['nombre_usuario']) ?></td>
                        <td class="is-size-7"><?= htmlspecialchars($orden['email']) ?></td>
                        <td class="is-size-7"><?= date('d/m/Y H:i', strtotime($orden['fecha_orden'])) ?></td>
                        <td class="has-text-right has-text-weight-semibold">
                            $<?= number_format($orden['total'], 0, ',', '.') ?>
                        </td>
                        <td class="has-text-centered">
                            <span class="tag <?= $estadoClases[$orden['estado']] ?>">
                                <?= ucfirst($orden['estado']) ?>
                            </span>
                        </td>
                        <td class="has-text-centered">
                            <form action="index.php?page=admin_orden_estado" method="POST"
                                  style="display:flex;gap:.5rem;align-items:center;justify-content:center;">
                                <input type="hidden" name="id" value="<?= $orden['id'] ?>">
                                <div class="select is-small">
                                    <select name="estado">
                                        <option value="pendiente"  <?= $orden['estado'] === 'pendiente'  ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="completada" <?= $orden['estado'] === 'completada' ? 'selected' : '' ?>>Completada</option>
                                        <option value="cancelada"  <?= $orden['estado'] === 'cancelada'  ? 'selected' : '' ?>>Cancelada</option>
                                    </select>
                                </div>
                                <button type="submit" class="button is-small is-primary is-outlined">
                                    <span class="icon"><i class="fas fa-check"></i></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="is-hidden-desktop">
            <?php foreach ($ordenes as $orden): ?>
            <div class="box mb-3 p-3">
                <div class="is-flex is-justify-content-space-between is-align-items-flex-start mb-2">
                    <div>
                        <p class="has-text-weight-bold">#<?= $orden['id'] ?> — <?= htmlspecialchars($orden['nombre_usuario']) ?></p>
                        <p class="is-size-7 has-text-grey"><?= htmlspecialchars($orden['email']) ?></p>
                        <p class="is-size-7 has-text-grey"><?= date('d/m/Y H:i', strtotime($orden['fecha_orden'])) ?></p>
                    </div>
                    <div class="has-text-right">
                        <p class="has-text-primary has-text-weight-bold">$<?= number_format($orden['total'], 0, ',', '.') ?></p>
                        <span class="tag <?= $estadoClases[$orden['estado']] ?> is-small mt-1">
                            <?= ucfirst($orden['estado']) ?>
                        </span>
                    </div>
                </div>
                <form action="index.php?page=admin_orden_estado" method="POST"
                      style="display:flex;gap:.5rem;align-items:center;">
                    <input type="hidden" name="id" value="<?= $orden['id'] ?>">
                    <div class="select is-small" style="flex:1;">
                        <select name="estado" style="width:100%;">
                            <option value="pendiente"  <?= $orden['estado'] === 'pendiente'  ? 'selected' : '' ?>>Pendiente</option>
                            <option value="completada" <?= $orden['estado'] === 'completada' ? 'selected' : '' ?>>Completada</option>
                            <option value="cancelada"  <?= $orden['estado'] === 'cancelada'  ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="button is-small is-primary">
                        <span class="icon"><i class="fas fa-check"></i></span>
                        <span>Actualizar</span>
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>