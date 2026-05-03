function addToCart(productoId, cantidad = 1) {
    const body = new FormData();
    body.append('producto_id', productoId);
    body.append('cantidad', cantidad);

    fetch('Backend/ajax/carrito_agregar.php', { method: 'POST', body })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast(data.mensaje, 'success');
                updateCartBadge();
            } else {
                showToast(data.mensaje, 'error');
            }
        })
        .catch(() => showToast('Error de conexion.', 'error'));
}

document.addEventListener('DOMContentLoaded', () => {
    const cartBody = document.getElementById('cartBody');
    if (!cartBody) return;

    loadCart();
});

function loadCart() {
    fetch('Backend/ajax/carrito_obtener.php')
        .then(r => r.json())
        .then(data => {
            if (data.success) renderCart(data.items, data.total, data.count);
        })
        .catch(() => showToast('Error al cargar el carrito.', 'error'));
}

function renderCart(items, total, count) {
    const cartBody   = document.getElementById('cartBody');
    const cartTotal  = document.getElementById('cartTotal');
    const cartEmpty  = document.getElementById('cartEmpty');
    const cartTable  = document.getElementById('cartTable');
    const checkoutBtn = document.getElementById('checkoutBtn');

    const btnVaciar = document.getElementById('btnVaciarWrap');

    if (!items.length) {
        if (cartTable)  cartTable.style.display  = 'none';
        if (cartEmpty)  cartEmpty.style.display  = 'block';
        if (checkoutBtn) checkoutBtn.disabled = true;
        if (cartTotal) cartTotal.textContent = '$0';
        if (btnVaciar) btnVaciar.style.display = 'none';
        updateCartBadge();
        return;
    }

    if (cartTable) cartTable.style.display = '';
    if (cartEmpty) cartEmpty.style.display = 'none';
    if (checkoutBtn) checkoutBtn.disabled = false;
    if (btnVaciar) btnVaciar.style.display = 'block';

    cartBody.innerHTML = items.map(item => `
        <tr class="fade-in">
            <td>
                <div class="is-flex is-align-items-center gap-3" style="gap:.75rem">
                    <figure class="image is-48x48" style="flex-shrink:0">
                        <img src="Frontend/img/productos/${item.imagen || 'placeholder.png'}"
                             alt="${escapeHtml(item.nombre)}"
                             style="object-fit:contain;height:48px;"
                             onerror="this.src='Frontend/img/productos/placeholder.png'">
                    </figure>
                    <div>
                        <p class="has-text-weight-semibold">${escapeHtml(item.nombre)}</p>
                        <p class="is-size-7 ${item.cantidad >= item.stock ? 'has-text-warning' : 'has-text-grey'}">
                            ${item.cantidad >= item.stock
                                ? `<i class="fas fa-exclamation-triangle"></i> Máximo disponible: ${item.stock} uds`
                                : `Stock disponible: ${item.stock} uds`}
                        </p>
                    </div>
                </div>
            </td>
            <td class="has-text-right">${formatPrice(item.precio)}</td>
            <td>
                <div class="cart-qty-control">
                    <button class="button is-small" onclick="changeQty(${item.producto_id}, ${parseInt(item.cantidad) - 1})"
                            ${parseInt(item.cantidad) <= 1 ? 'disabled' : ''}>
                        <i class="fas fa-minus"></i>
                    </button>
                    <input class="input is-small" type="number" min="1" max="${item.stock}"
                           value="${item.cantidad}"
                           onchange="changeQty(${item.producto_id}, this.value)"
                           style="width:60px;text-align:center;">
                    <button class="button is-small" onclick="changeQty(${item.producto_id}, ${parseInt(item.cantidad) + 1})"
                            ${parseInt(item.cantidad) >= parseInt(item.stock) ? 'disabled' : ''}>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </td>
            <td class="has-text-right has-text-weight-semibold">${formatPrice(item.subtotal)}</td>
            <td class="has-text-centered">
                <button class="button is-danger is-small is-outlined" onclick="removeItem(${item.producto_id})">
                    <span class="icon"><i class="fas fa-trash"></i></span>
                </button>
            </td>
        </tr>
    `).join('');

    if (cartTotal) cartTotal.textContent = '$' + total;
    updateCartBadge();
}

function changeQty(productoId, nuevaCantidad) {
    nuevaCantidad = parseInt(nuevaCantidad);
    if (isNaN(nuevaCantidad) || nuevaCantidad < 1) return;

    const body = new FormData();
    body.append('producto_id', productoId);
    body.append('cantidad', nuevaCantidad);

    fetch('Backend/ajax/carrito_actualizar.php', { method: 'POST', body })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                renderCart(data.items, data.total, data.count);
                if (data.aviso) showToast(data.aviso, 'info');
            } else {
                showToast(data.mensaje, 'error');
            }
        })
        .catch(() => showToast('Error al actualizar.', 'error'));
}

function removeItem(productoId) {
    const body = new FormData();
    body.append('producto_id', productoId);

    fetch('Backend/ajax/carrito_eliminar.php', { method: 'POST', body })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                renderCart(data.items, data.total, data.count);
                showToast('Producto eliminado del carrito.', 'info');
            } else {
                showToast(data.mensaje, 'error');
            }
        })
        .catch(() => showToast('Error al eliminar.', 'error'));
}

function vaciarCarrito() {
    if (!confirm('¿Estás seguro de que deseas vaciar el carrito?')) return;

    fetch('Backend/ajax/carrito_vaciar.php', { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                renderCart([], '0', 0);
                showToast('Carrito vaciado.', 'info');
            } else {
                showToast('Error al vaciar el carrito.', 'error');
            }
        })
        .catch(() => showToast('Error de conexión.', 'error'));
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}