<?php
$pageTitle    = 'Iniciar Sesión — TechHub Store';
$extraScripts = ['auth.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">
        <div class="auth-box">
            <div class="auth-box__logo">
                <span class="icon is-large has-text-primary" style="font-size:3rem;">
                    <i class="fas fa-microchip"></i>
                </span>
                <h1 class="title is-4 mt-2">TechHub Store</h1>
                <p class="has-text-grey">Inicia sesión en tu cuenta</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="notification is-danger is-light mb-4">
                    <button class="delete" onclick="this.parentElement.remove()"></button>
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" action="index.php?page=login" method="POST" novalidate>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left">
                        <input class="input" type="email" name="email"
                               placeholder="usuario@correo.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required autocomplete="email">
                        <span class="icon is-left"><i class="fas fa-envelope"></i></span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Contraseña</label>
                    <div class="control has-icons-left">
                        <input class="input" type="password" name="password"
                               placeholder="••••••••" required autocomplete="current-password">
                        <span class="icon is-left"><i class="fas fa-lock"></i></span>
                    </div>
                </div>

                <div class="field mt-5">
                    <button type="submit" class="button is-primary is-fullwidth is-medium">
                        <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                        <span>Ingresar</span>
                    </button>
                </div>
            </form>

            <p class="has-text-centered mt-4 is-size-7">
                ¿No tienes cuenta?
                <a href="index.php?page=registro"><strong>Regístrate aquí</strong></a>
            </p>

            <hr>
            <p class="has-text-centered is-size-7 has-text-grey">
                Admin: <strong>admin@techhub.cl</strong> / <strong>admin123</strong>
            </p>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>