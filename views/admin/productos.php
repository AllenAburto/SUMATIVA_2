<?php
$pageTitle    = 'Gestión de Productos — Admin';
$extraScripts = ['admin.js'];
$adminPage    = 'productos';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/sidebar.php';
?>

<div class="columns is-gapless" style="min-height:calc(100vh - 52px);">
    <?php include __DIR__ . '/sidebar_desktop.php'; ?>
    <div class="column p-3">

        <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h1 class="title is-4 mb-0">
                <i class="fas fa-boxes mr-2 has-text-primary"></i>Productos
            </h1>
            <a href="index.php?page=admin_producto_form" class="button is-primary is-small">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span class="is-hidden-mobile">Nuevo producto</span>
                <span class="is-hidden-tablet">Nuevo</span>
            </a>
        </div>

        <div class="is-hidden-touch box p-0" style="overflow-x:auto;">
            <table class="table is-fullwidth is-hoverable mb-0">
                <thead class="has-background-light">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th class="has-text-right">Precio</th>
                        <th class="has-text-centered">Stock</th>
                        <th class="has-text-centered">Estado</th>
                        <th class="has-text-centered">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr data-product-id="<?= $p['id'] ?>" <?= !$p['activo'] ? 'style="opacity:.5"' : '' ?>>
                        <td class="is-size-7"><?= $p['id'] ?></td>
                        <td>
                            <div class="is-flex is-align-items-center" style="gap:.75rem">
                                <?php
                                $imgFile = !empty($p['imagen']) && file_exists(__DIR__ . '/../../Frontend/img/productos/' . $p['imagen']);
                                ?>
                                <div style="width:40px;height:40px;flex-shrink:0;border-radius:8px;overflow:hidden;background:#f5f6fa;display:flex;align-items:center;justify-content:center;">
                                    <?php if ($imgFile): ?>
                                        <img src="Frontend/img/productos/<?= htmlspecialchars($p['imagen']) ?>"
                                             style="width:100%;height:100%;object-fit:contain;padding:4px;">
                                    <?php else: ?>
                                        <i class="fas fa-laptop has-text-grey-light"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="has-text-weight-semibold is-size-7"><?= htmlspecialchars($p['nombre']) ?></p>
                                    <p class="is-size-7 has-text-grey"><?= htmlspecialchars($p['marca'] ?? '') ?></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="tag is-small tag-categoria-<?= $p['categoria'] ?>"><?= ucfirst($p['categoria']) ?></span></td>
                        <td class="has-text-right is-size-7">$<?= number_format($p['precio'], 0, ',', '.') ?></td>
                        <td class="has-text-centered">
                            <span class="tag <?= $p['stock'] > 0 ? 'is-success' : 'is-danger' ?> is-small"><?= $p['stock'] ?></span>
                        </td>
                        <td class="has-text-centered">
                            <span class="tag is-small <?= $p['activo'] ? 'is-success' : 'is-light' ?>"><?= $p['activo'] ? 'Activo' : 'Inactivo' ?></span>
                            <?php if ($p['destacado'] && $p['activo']): ?>
                                <span class="tag is-warning is-small ml-1"><i class="fas fa-star"></i></span>
                            <?php endif; ?>
                        </td>
                        <td class="has-text-centered">
                            <div style="display:flex;gap:.25rem;justify-content:center;flex-wrap:nowrap;">
                                <a href="index.php?page=admin_producto_form&id=<?= $p['id'] ?>"
                                   class="button is-info is-small is-outlined">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <button class="button is-danger is-small is-outlined"
                                        data-delete-id="<?= $p['id'] ?>"
                                        data-delete-name="<?= htmlspecialchars($p['nombre']) ?>">
                                    <span class="icon"><i class="fas fa-trash"></i></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="is-hidden-desktop">
            <?php foreach ($productos as $p): ?>
            <?php $imgFile = !empty($p['imagen']) && file_exists(__DIR__ . '/../../Frontend/img/productos/' . $p['imagen']); ?>
            <div class="box mb-3 p-3" data-product-id="<?= $p['id'] ?>"
                 style="<?= !$p['activo'] ? 'opacity:.55;' : '' ?>">
                <div class="is-flex is-align-items-center" style="gap:.75rem;">
                    <div style="width:52px;height:52px;flex-shrink:0;border-radius:10px;
                                background:#f5f6fa;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        <?php if ($imgFile): ?>
                            <img src="Frontend/img/productos/<?= htmlspecialchars($p['imagen']) ?>"
                                 style="width:100%;height:100%;object-fit:contain;padding:4px;">
                        <?php else: ?>
                            <i class="fas fa-laptop has-text-grey-light fa-lg"></i>
                        <?php endif; ?>
                    </div>

                    <div style="flex:1;min-width:0;">
                        <p class="has-text-weight-semibold is-size-7" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <?= htmlspecialchars($p['nombre']) ?>
                        </p>
                        <div style="display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.3rem;align-items:center;">
                            <span class="tag is-small tag-categoria-<?= $p['categoria'] ?>"><?= ucfirst($p['categoria']) ?></span>
                            <span class="tag is-small <?= $p['stock'] > 0 ? 'is-success' : 'is-danger' ?>"><?= $p['stock'] ?> uds</span>
                            <?php if ($p['destacado']): ?>
                                <span class="tag is-warning is-small"><i class="fas fa-star"></i></span>
                            <?php endif; ?>
                        </div>
                        <p class="has-text-primary has-text-weight-bold is-size-7 mt-1">
                            $<?= number_format($p['precio'], 0, ',', '.') ?>
                        </p>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:.3rem;flex-shrink:0;">
                        <a href="index.php?page=admin_producto_form&id=<?= $p['id'] ?>"
                           class="button is-info is-small is-outlined">
                            <span class="icon"><i class="fas fa-edit"></i></span>
                        </a>
                        <button class="button is-danger is-small is-outlined"
                                data-delete-id="<?= $p['id'] ?>"
                                data-delete-name="<?= htmlspecialchars($p['nombre']) ?>">
                            <span class="icon"><i class="fas fa-trash"></i></span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Confirmar eliminación</p>
            <button id="modalCancel" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <p>¿Desactivar el producto <strong id="modalProductName"></strong>?</p>
            <p class="is-size-7 has-text-grey mt-2">El producto quedará inactivo (soft delete).</p>
        </section>
        <footer class="modal-card-foot">
            <button id="modalConfirm" class="button is-danger">
                <span class="icon"><i class="fas fa-trash"></i></span>
                <span>Eliminar</span>
            </button>
            <button class="button" onclick="document.getElementById('deleteModal').classList.remove('is-active')">
                Cancelar
            </button>
        </footer>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>