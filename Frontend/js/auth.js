document.addEventListener('DOMContentLoaded', () => {

    const loginForm    = document.getElementById('loginForm');
    const registroForm = document.getElementById('registroForm');

    if (loginForm) {
        loginForm.addEventListener('submit', e => {
            clearErrors();
            let valid = true;

            const email    = loginForm.querySelector('[name="email"]');
            const password = loginForm.querySelector('[name="password"]');

            if (!email.value.trim()) {
                setError(email, 'El email es obligatorio.');
                valid = false;
            } else if (!isValidEmail(email.value)) {
                setError(email, 'Ingresa un email valido.');
                valid = false;
            }

            if (!password.value) {
                setError(password, 'La contrasena es obligatoria.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    if (registroForm) {
        registroForm.addEventListener('submit', e => {
            clearErrors();
            let valid = true;

            const nombre    = registroForm.querySelector('[name="nombre"]');
            const email     = registroForm.querySelector('[name="email"]');
            const password  = registroForm.querySelector('[name="password"]');
            const confirmar = registroForm.querySelector('[name="confirmar_password"]');

            if (!nombre.value.trim() || nombre.value.trim().length < 2) {
                setError(nombre, 'El nombre debe tener al menos 2 caracteres.');
                valid = false;
            }

            if (!email.value.trim()) {
                setError(email, 'El email es obligatorio.');
                valid = false;
            } else if (!isValidEmail(email.value)) {
                setError(email, 'Ingresa un email valido (ej: usuario@correo.com).');
                valid = false;
            }

            if (!password.value || password.value.length < 6) {
                setError(password, 'La contrasena debe tener al menos 6 caracteres.');
                valid = false;
            }

            if (confirmar.value !== password.value) {
                setError(confirmar, 'Las contrasenas no coinciden.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        const pw  = registroForm.querySelector('[name="password"]');
        const cpw = registroForm.querySelector('[name="confirmar_password"]');
        if (pw && cpw) {
            cpw.addEventListener('input', () => {
                if (cpw.value && cpw.value !== pw.value) {
                    cpw.classList.add('is-danger');
                } else {
                    cpw.classList.remove('is-danger');
                    cpw.classList.add('is-success');
                }
            });
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
    }

    function setError(input, message) {
        input.classList.add('is-danger');
        const help = document.createElement('p');
        help.className = 'help is-danger';
        help.textContent = message;
        input.closest('.field, .control') ?
            input.closest('.field').appendChild(help) :
            input.parentNode.appendChild(help);
    }

    function clearErrors() {
        document.querySelectorAll('.help.is-danger').forEach(el => el.remove());
        document.querySelectorAll('.is-danger').forEach(el => el.classList.remove('is-danger'));
        document.querySelectorAll('.is-success').forEach(el => el.classList.remove('is-success'));
    }
});