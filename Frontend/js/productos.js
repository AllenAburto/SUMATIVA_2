document.addEventListener('DOMContentLoaded', () => {

    const searchInput  = document.getElementById('searchInput');
    const catSelect    = document.getElementById('categoriaSelect');
    const ordenSelect  = document.getElementById('ordenSelect');
    const gridContainer = document.getElementById('productsGrid');

    if (!gridContainer) return;

    let debounceTimer;

    function doSearch() {
        const q        = searchInput  ? searchInput.value.trim()  : '';
        const categoria = catSelect   ? catSelect.value           : '';
        const orden     = ordenSelect ? ordenSelect.value         : 'nombre_asc';

        const params = new URLSearchParams({ q, categoria, orden });

        gridContainer.innerHTML = `
            <div class="loading-overlay">
                <span class="icon is-large has-text-primary">
                    <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                </span>
            </div>`;

        fetch(`Backend/ajax/buscar_productos.php?${params}`)
            .then(r => r.json())
            .then(data => {
                if (!data.success) throw new Error(data.mensaje);
                renderProducts(data.productos);
            })
            .catch(err => {
                gridContainer.innerHTML = `
                    <div class="notification is-danger is-light" style="grid-column:1/-1">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error al cargar productos: ${err.message}
                    </div>`;
            });
    }

    function renderProducts(productos) {
        if (!productos.length) {
            gridContainer.innerHTML = `
                <div class="notification is-warning is-light" style="grid-column:1/-1;text-align:center;">
                    <span class="icon is-large"><i class="fas fa-search fa-2x"></i></span>
                    <p class="mt-2">No se encontraron productos con esos criterios.</p>
                </div>`;
            return;
        }

        gridContainer.innerHTML = productos.map(p => `
            <div class="product-card fade-in">
                <div class="product-card__img-wrap">
                    <img src="Frontend/img/productos/${escapeHtml(p.imagen)}"
                         alt="${escapeHtml(p.nombre)}"
                         onerror="this.parentElement.innerHTML='<div class=\'img-placeholder\'><i class=\'fas fa-laptop\'></i><span>Sin imagen</span></div>'">
                    ${p.destacado == 1 ? '<span class="product-card__badge tag is-warning is-small"><i class="fas fa-star mr-1"></i>Destacado</span>' : ''}
                    ${p.stock == 0 ? '<span class="product-card__badge tag is-danger is-small">Sin stock</span>' : ''}
                </div>
                <div class="product-card__body">
                    <p class="product-card__title">${escapeHtml(p.nombre)}</p>
                    <p class="product-card__brand">${escapeHtml(p.marca || '')}</p>
                    <span class="tag is-small tag-categoria-${escapeHtml(p.categoria)}">${p.categoria.charAt(0).toUpperCase() + p.categoria.slice(1)}</span>
                    <p class="product-card__price">${formatPrice(p.precio)}</p>
                </div>
                <div class="product-card__footer">
                    <a href="index.php?page=producto&id=${p.id}" class="button is-light is-small">
                        <span class="icon"><i class="fas fa-eye"></i></span>
                        <span>Ver</span>
                    </a>
                    ${p.stock > 0
                        ? `<button class="button is-primary is-small" onclick="addToCart(${p.id})">
                               <span class="icon"><i class="fas fa-cart-plus"></i></span>
                               <span>Agregar</span>
                           </button>`
                        : `<button class="button is-danger is-small" disabled>
                               <span class="icon"><i class="fas fa-times-circle"></i></span>
                               <span>Sin stock</span>
                           </button>`
                    }
                </div>
            </div>
        `).join('');
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(doSearch, 300);
        });
    }

    if (catSelect)   catSelect.addEventListener('change', doSearch);
    if (ordenSelect) ordenSelect.addEventListener('change', doSearch);
});