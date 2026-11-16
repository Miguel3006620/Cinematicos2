<?php
    require "config.php";
    include_once DBAPI;
    if (!isset($_SESSION)) session_start();
    include(HEADER_TEMPLATE);
    $db = open_database();
?>
        <h1>Dashboard</h1>
        <hr>

        <?php if ($db) : ?>

            <div class="row">
                <div class="col-lg-2 col-sm-3 col-md-2"><!-- Customers/Clientes -->
                    <a href="<?php echo BASEURL; ?>customers/add.php" class="btn btn-secondary">
                        <div class="row">
                            <div class="col-xl-12 text-center">
                                <!-- <i class="fa fa-plus fa-5x"></i> -->
                                <i class="fa-solid fa-user-plus fa-5x"></i>
                            </div>
                            <div class="col-xl-12 text-center">
                                <p>Novo Cliente</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-3 col-md-2">
                    <a href="<?php echo BASEURL; ?>customers" class="btn btn-light">
                        <div class="row">
                            <div class="col-xl-12 text-center">
                                <!-- <i class="fa fa-user fa-5x"></i> -->
                                <i class="fa-solid fa-users fa-5x"></i>
                            </div>
                            <div class="col-xl-12 text-center">
                                <p>Clientes</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <br>
            <div class="row" id="actions"><!-- Linha dos produtos -->
                <div class="col-lg-2 col-sm-3 col-md-2">
                    <a href="<?php echo BASEURL; ?>filmes/add.php" class="btn btn-secondary">
                        <div class="row">
                            <div class="col-xl-12 text-center">
                                <!-- <i class="fa fa-plus fa-5x"></i> -->
                                <i class="fa-solid fa-box fa-5x"></i>
                            </div>
                            <div class="col-xl-12 text-center">
                                <p>Novo filme</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-3 col-md-2">
                    <a href="<?php echo BASEURL; ?>filmes" class="btn btn-light">
                        <div class="row">
                            <div class="col-xl-12 text-center">
                                <!-- <i class="fa fa-user fa-5x"></i> -->
                                <i class="fa-solid fa-boxes-stacked fa-5x"></i>
                            </div>
                            <div class="col-xl-12 text-center">
                                <p>Filmes</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <br>
            <?php if (isset($_SESSION['user'])) : //Verifica se está existe usuário ?>
                <?php if ($_SESSION['user'] == "admin") : //Verifica se está logado como admin ?>
                    <div class="row" id="actions"><!-- Linha dos usuários -->
                        <div class="col-lg-2 col-sm-3 col-md-2">
                            <a href="<?php echo BASEURL; ?>usuarios/add.php" class="btn btn-secondary">
                                <div class="row">
                                    <div class="col-xl-12 text-center">
                                        <!-- <i class="fa fa-plus fa-5x"></i> -->
                                        <i class="fa-solid fa-user-tie fa-5x"></i>
                                    </div>
                                    <div class="col-xl-12 text-center">
                                        <p>Novo Usuário</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-2 col-sm-3 col-md-2">
                            <a href="<?php echo BASEURL; ?>usuarios" class="btn btn-light">
                                <div class="row">
                                    <div class="col-xl-12 text-center">
                                        <!-- <i class="fa fa-user fa-5x"></i> -->
                                        <i class="fa-solid fa-user-lock fa-5x"></i>
                                    </div>
                                    <div class="col-xl-12 text-center">
                                        <p>Usuários</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php else : ?>
            <!-- Comentei a DIV abaixo -->
            <!--
            <div class="alert alert-danger" role="alert">
                <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
            </div> -->
            <?php if (!empty($_SESSION['message'])) : ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                    <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!<br>
                    <?php echo $_SESSION['message']; ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php clear_messages(); ?>
            <?php endif; ?>
        <?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>