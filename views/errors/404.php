<?php
$pageTitle = 'Página no encontrada — TechHub Store';
include __DIR__ . '/../layout/header.php';
?>

<section class="section">
    <div class="container">
        <div class="has-text-centered py-6">
            <p style="font-size:6rem;line-height:1;">🔍</p>
            <h1 class="title is-1 has-text-grey-light mt-3">404</h1>
            <h2 class="title is-4">Página no encontrada o no Creada</h2>
            <p class="has-text-grey mb-5">La página que buscas no existe o no ha sido creada, favor volver al home.</p>
            <div class="buttons is-centered">
                <a href="index.php" class="button is-primary">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span>Ir al Home</span>
                </a>
                <a href="index.php?page=catalogo" class="button is-light">
                    <span class="icon"><i class="fas fa-laptop"></i></span>
                    <span>Ver catálogo</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>