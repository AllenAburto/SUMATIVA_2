</main>

<footer class="footer mt-4">
    <div class="content has-text-centered">
        <p>
            <strong>TechHub Store</strong> — Tu tienda de tecnología en línea. <br>
        </p>
        <p class="has-text-grey">Evaluacion Sumativa 2 - AIEP</p>
        <p class="is-size-7 has-text-grey">
            &copy; <?= date('Y') ?> TechHub Store. Todos los derechos reservados.
        </p>
    </div>
</footer>

<script src="<?= BASE_URL ?>Frontend/js/app.js"></script>

<?php if (isset($extraScripts)): ?>
    <?php foreach ($extraScripts as $script): ?>
        <script src="<?= BASE_URL ?>Frontend/js/<?= $script ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
