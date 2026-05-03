<?php
$pageTitle    = 'Crear Cuenta — TechHub Store';
$extraScripts = ['auth.js'];
include __DIR__ . '/layout/header.php';
?>

<section class="section">
    <div class="container">
        <div class="auth-box" style="max-width:480px;">
            <div class="auth-box__logo">
                <span class="icon is-large has-text-primary" style="font-size:3rem;">
                    <i class="fas fa-user-plus"></i>
                </span>
                <h1 class="title is-4 mt-2">Crear Cuenta</h1>
                <p class="has-text-grey">Únete a TechHub Store</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="notification is-danger is-light mb-4">
                    <button class="delete" onclick="this.parentElement.remove()"></button>
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form id="registroForm" action="index.php?page=registro" method="POST" novalidate>

                <div class="field">
                    <label class="label">Nombre completo</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="nombre"
                               placeholder="Juan Pérez"
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                               required autocomplete="name">
                        <span class="icon is-left"><i class="fas fa-user"></i></span>
                    </div>
                </div>

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
                               placeholder="Mínimo 6 caracteres"
                               required autocomplete="new-password">
                        <span class="icon is-left"><i class="fas fa-lock"></i></span>
                    </div>
                    <p class="help">Mínimo 6 caracteres.</p>
                </div>

                <div class="field">
                    <label class="label">Confirmar Contraseña</label>
                    <div class="control has-icons-left">
                        <input class="input" type="password" name="confirmar_password"
                               placeholder="Repite tu contraseña"
                               required autocomplete="new-password">
                        <span class="icon is-left"><i class="fas fa-lock"></i></span>
                    </div>
                </div>

                <div class="field mt-5">
                    <button type="submit" class="button is-primary is-fullwidth is-medium">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <span>Crear Cuenta</span>
                    </button>
                </div>
            </form>

            <p class="has-text-centered mt-4 is-size-7">
                ¿Ya tienes cuenta?
                <a href="index.php?page=login"><strong>Inicia sesión</strong></a>
            </p>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>