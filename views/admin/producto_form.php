<?php
$esEdicion    = !empty($producto['id']);
$pageTitle    = ($esEdicion ? 'Editar' : 'Nuevo') . ' Producto — Admin';
$extraScripts = ['admin.js'];
$adminPage    = 'productos';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/sidebar.php';
?>

<div class="columns is-gapless" style="min-height:calc(100vh - 52px);">
    <?php include __DIR__ . '/sidebar_desktop.php'; ?>

    <div style="display:none;">
        <aside class="menu">
            <p class="menu-label">Administración</p>
            <ul class="menu-list">
                <li><a href="index.php?page=admin">
                    <span class="icon"><i class="fas fa-tachometer-alt"></i></span> Dashboard
                </a></li>
                <li><a href="index.php?page=admin_productos" class="is-active">
                    <span class="icon"><i class="fas fa-boxes"></i></span> Productos
                </a></li>
                <li><a href="index.php?page=admin_ordenes">
                    <span class="icon"><i class="fas fa-receipt"></i></span> Órdenes
                </a></li>
            </ul>
            <p class="menu-label mt-4">Cuenta</p>
            <ul class="menu-list">
                <li><a href="index.php">
                    <span class="icon"><i class="fas fa-store"></i></span> Ver tienda
                </a></li>
                <li><a href="index.php?page=logout" class="has-text-danger">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span> Salir
                </a></li>
            </ul>
        </aside>
    </div>

    <div class="column p-4">
        <div class="is-flex is-align-items-center mb-5" style="gap:1rem;">
            <a href="index.php?page=admin_productos" class="button is-light">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
            </a>
            <h1 class="title is-4 mb-0">
                <i class="fas <?= $esEdicion ? 'fa-edit' : 'fa-plus' ?> mr-2 has-text-primary"></i>
                <?= $esEdicion ? 'Editar Producto' : 'Nuevo Producto' ?>
            </h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="notification is-danger is-light mb-4">
                <button class="delete" onclick="this.parentElement.remove()"></button>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="box" style="max-width:700px;">
            <form action="index.php?page=admin_producto_save" method="POST">
                <?php if ($esEdicion): ?>
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                <?php endif; ?>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Nombre <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input" type="text" name="nombre"
                                       placeholder="Nombre del producto"
                                       value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">
                            <label class="label">Marca</label>
                            <div class="control">
                                <input class="input" type="text" name="marca"
                                       placeholder="Apple, Samsung..."
                                       value="<?= htmlspecialchars($producto['marca'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Descripción</label>
                    <div class="control">
                        <textarea class="textarea" name="descripcion" rows="3"
                                  placeholder="Descripción del producto..."><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Precio (CLP) <span class="has-text-danger">*</span></label>
                            <div class="control has-icons-left">
                                <input class="input" type="number" name="precio" min="0" step="0.01"
                                       placeholder="0"
                                       value="<?= $producto['precio'] ?? '' ?>" required>
                                <span class="icon is-left"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Stock <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <input class="input" type="number" name="stock" min="0"
                                       value="<?= $producto['stock'] ?? 0 ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Categoría <span class="has-text-danger">*</span></label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="categoria" required>
                                        <?php foreach ($categorias as $c): ?>
                                            <option value="<?= $c ?>"
                                                <?= ($producto['categoria'] ?? '') === $c ? 'selected' : '' ?>>
                                                <?= ucfirst($c) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="imagenInput" name="imagen"
                       value="<?= htmlspecialchars($producto['imagen'] ?? '') ?>">

                <div class="field">
                    <label class="label">Imagen del producto</label>

                    <div id="uploadZone" class="upload-zone" onclick="document.getElementById('fileInput').click()">
                        <span class="icon is-large has-text-grey-light"><i class="fas fa-cloud-upload-alt fa-2x"></i></span>
                        <p class="mt-2 has-text-grey">Arrastra una imagen o Haz clic para seleccionar y cargar la imagen</p>
                        <p class="is-size-7 has-text-grey-light">Formatos aceptados: JPG, PNG, WEBP</p>
                        <p class="is-size-7 has-text-grey-light">Peso máximo: 3MB</p>
                    </div>

                    <input type="file" id="fileInput" accept="image/jpeg,image/png,image/webp,image/gif"
                           style="display:none;">

                    <progress id="uploadProgress" class="progress is-primary mt-2" value="0" max="100"
                              style="display:none;"></progress>

                    <div id="imgPreviewWrap" style="display:<?= !empty($producto['imagen']) ? 'flex' : 'none' ?>;
                         align-items:center;gap:1rem;margin-top:.75rem;padding:1rem;
                         background:#f9faff;border-radius:10px;border:1px solid #eee;">
                        <img id="imgPreview"
                             src="<?= !empty($producto['imagen']) ? 'Frontend/img/productos/' . htmlspecialchars($producto['imagen']) : '' ?>"
                             style="height:90px;object-fit:contain;border-radius:8px;background:#fff;padding:.4rem;">
                        <div>
                            <p class="is-size-7 has-text-weight-semibold" id="imgFilename">
                                <?= htmlspecialchars($producto['imagen'] ?? '') ?>
                            </p>
                            <button type="button" class="button is-danger is-small is-outlined mt-2"
                                    onclick="clearImage()">
                                <span class="icon"><i class="fas fa-trash"></i></span>
                                <span>Quitar imagen</span>
                            </button>
                        </div>
                    </div>

                    <p id="uploadMsg" class="help mt-1"></p>
                </div>

                <div class="columns">
                    <div class="column">
                        <label class="checkbox">
                            <input type="checkbox" name="destacado" value="1"
                                   <?= ($producto['destacado'] ?? 0) ? 'checked' : '' ?>>
                            &nbsp;<strong>Producto destacado</strong>
                            <p class="help">Aparece en la sección de inicio.</p>
                        </label>
                    </div>
                    <div class="column">
                        <label class="checkbox">
                            <input type="checkbox" name="activo" value="1"
                                   <?= ($producto['activo'] ?? 1) ? 'checked' : '' ?>>
                            &nbsp;<strong>Producto activo</strong>
                            <p class="help">Visible en el catálogo.</p>
                        </label>
                    </div>
                </div>

                <div class="field mt-5">
                    <div class="buttons">
                        <button type="submit" class="button is-primary is-medium">
                            <span class="icon"><i class="fas fa-save"></i></span>
                            <span><?= $esEdicion ? 'Guardar cambios' : 'Crear producto' ?></span>
                        </button>
                        <a href="index.php?page=admin_productos" class="button is-light is-medium">
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>