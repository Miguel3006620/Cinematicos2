    </main>

    <footer class="bg-dark text-light text-center py-3 mt-4">
        <?php $dt = new DateTime("now", new DateTimeZone("America/Sao_Paulo")); ?>
        <p class="mb-0" style="letter-spacing: 2px;">&copy; 2026 – <?= $dt->format("Y") ?> · Miguel Cappelli e Luiz Miguel</p>
    </footer>

    <script src="<?= BASEURL ?>js/jquery-4.0.0.min.js"></script>
    <script src="<?= BASEURL ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASEURL ?>js/all.min.js"></script>
    <script src="<?= BASEURL ?>js/main.js"></script>
</body>

</html>