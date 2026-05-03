document.addEventListener('DOMContentLoaded', () => {

    const burger = document.getElementById('navbarBurger');
    const menu   = document.getElementById('mainNavbar');

    if (burger && menu) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }

    updateCartBadge();
});

function showToast(message, type = 'success', duration = 3500) {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const icons = { success: 'fa-check-circle', error: 'fa-times-circle', info: 'fa-info-circle' };
    const toast  = document.createElement('div');
    toast.className = `toast toast--${type}`;
    toast.innerHTML = `<i class="fas ${icons[type] || icons.info}"></i> ${message}`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        toast.addEventListener('animationend', () => toast.remove());
    }, duration);
}

function updateCartBadge() {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;

    fetch('Backend/ajax/carrito_obtener.php')
        .then(r => r.json())
        .then(data => {
            if (data.success && data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(() => {});
}

function formatPrice(value) {
    return '$' + Number(value).toLocaleString('es-CL');
}