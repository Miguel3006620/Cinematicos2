
<?php
include 'config.php';
include DBAPI;
include HEADER_TEMPLATE;
$erro = null;
try {
	$db = open_database();
} catch (Exception $e) {
	$erro = $e->getMessage();
}
?>
 
<h1>Inicio:</h1>
<hr>

<?php if (!$erro): ?>

	<div class="row" style="margin: 2%; ">
		<div class="col-xs-2 col-sm-3 col-md-4">
			<a href="filmes/add.php" class="btn btn-secondary">
				<div class="row">
					<div class="col-xs-12 text-center">
						<i class="fa-solid fa-user-plus fa-10x"></i>
					</div>
					<div class="col-xs-2 text-center">
						<p>Novo filme</p>
					</div>
				</div>
			</a>
		</div>

		<div class="col-xs-2 col-sm-3 col-md-5" >
			<a href="filmes" class="btn btn-light">
				<div class="row">
					<div class="col-xs-12 text-center">
						<i class="fa fa-user-group fa-10x"></i>
					</div>
					<div class="col-xs-2 text-center">
						<p>Filmes</p>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="row" style="margin: 2%; ">
	<div class="col-xs-2 col-sm-3 col-md-4" >
			<a href="Usuarios" class="btn btn-light">
				<div class="row">
					<div class="col-xs-12 text-center">
						<i class="fa fa-user-group fa-10x"></i>
					</div>
					<div class="col-xs-24 text-center">
						<p>Usuarios</p>
					</div>
				</div>
			</a>
		</div>
	<div class="col-xs-2 col-sm-3 col-md-5" >
			<a href="Login_e_Validacao/login.php" class="btn btn-light">
				<div class="row">
					<div class="col-xs-12 text-center">
						<i class="fa fa-user-group fa-10x"></i>
					</div>
					<div class="col-xs-24 text-center">
						<p>login</p>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>

<?php else: ?>
	<div class="alert alert-danger" role="alert">
		<p><b>ERRO:</b> Não foi possível Conectar ao Banco de Dados!<br>
			<?= $erro ?>
		</p>
	</div>

<?php endif; ?>

<?php include FOOTER_TEMPLATE; ?>