    <hr>
    </main> <!-- /container -->
    <style>
        p{
            color:whitesmoke;
            letter-spacing: 2px;
            margin: 1%;
        }
    </style>
    <foo class="navbar navbar-expand-lg bg-body-tertiary fixed-end container mb-3 " data-bs-theme="dark">
        <?php $dt = new DateTime("now", new DateTimeZone("America/Sao_Paulo")); ?>
        <p >&copy;2026 à <?= $dt->format("Y")?> - Miguel Cappelli e Luiz Miguel</p>
    </footer>

    <script src="<?php echo BASEURL; ?>js/jquery-4.0.0.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/all.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/main.js"></script>
    </body>

</html>