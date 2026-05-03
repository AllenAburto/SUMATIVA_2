<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'TechHub Store' ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>Frontend/css/styles.css">
</head>
<body>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?= BASE_URL ?>index.php">
            <span class="icon mr-2"><i class="fas fa-microchip"></i></span>
            <strong class="has-text-primary">TechHub</strong>&nbsp;Store
        </a>

        <a role="button" class="navbar-burger" id="navbarBurger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="mainNavbar" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item <?= ($page === 'home') ? 'is-active' : '' ?>" href="<?= BASE_URL ?>index.php">
                <span class="icon"><i class="fas fa-home"></i></span>&nbsp;Inicio
            </a>
            <a class="navbar-item <?= ($page === 'catalogo') ? 'is-active' : '' ?>" href="<?= BASE_URL ?>index.php?page=catalogo">
                <span class="icon"><i class="fas fa-laptop"></i></span>&nbsp;Catalogo
            </a>
        </div>

        <div class="navbar-end">
            <a class="navbar-item" href="<?= BASE_URL ?>index.php?page=carrito">
                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                &nbsp;Carrito
                <span class="tag is-primary is-rounded ml-1" id="cartBadge" style="display:none;">0</span>
            </a>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <span class="icon"><i class="fas fa-user-circle"></i></span>
                        &nbsp;<?= htmlspecialchars($_SESSION['nombre']) ?>
                    </a>
                    <div class="navbar-dropdown is-right">
                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                            <a class="navbar-item" href="<?= BASE_URL ?>index.php?page=admin">
                                <span class="icon"><i class="fas fa-tachometer-alt"></i></span>&nbsp;Panel Admin
                            </a>
                            <hr class="navbar-divider">
                        <?php else: ?>
                            <a class="navbar-item" href="<?= BASE_URL ?>index.php?page=historial">
                                <span class="icon"><i class="fas fa-list-alt"></i></span>&nbsp;Mis Ordenes
                            </a>
                            <hr class="navbar-divider">
                        <?php endif; ?>
                        <a class="navbar-item has-text-danger" href="<?= BASE_URL ?>index.php?page=logout">
                            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>&nbsp;Cerrar Sesion
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary" href="<?= BASE_URL ?>index.php?page=registro">
                            <span class="icon"><i class="fas fa-user-plus"></i></span>
                            <span>Registrarse</span>
                        </a>
                        <a class="button is-light" href="<?= BASE_URL ?>index.php?page=login">
                            <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                            <span>Ingresar</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div id="toastContainer" style="position:fixed;top:5rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;"></div>

<main>