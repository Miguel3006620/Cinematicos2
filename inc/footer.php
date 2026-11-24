    </main>

    <footer class="rodape">
        <?php $dt = new DateTime("now", new DateTimeZone("America/Sao_Paulo")); ?>
        &copy; 2026 – <?= $dt->format("Y") ?> · Miguel Cappelli e Luiz Miguel
    </footer>

    <script src="<?= BASEURL ?>js/jquery-4.0.0.min.js"></script>
    <script src="<?= BASEURL ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASEURL ?>js/all.min.js"></script>
    <script src="<?= BASEURL ?>js/main.js"></script>
</body>

</html>