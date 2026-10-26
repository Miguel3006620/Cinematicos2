<?php
ob_start(); //output buffer aberto, para não dar erro de header location

include('../config.php');
include(DBAPI);

$filmes = null;
$filme = null;

/**
 *  Formatar as datas
 */
function formatData($data, $formato)
{
	$dt = new Datetime($data, new DateTimeZone("America/Sao_Paulo")); // "-0300"
	return $dt->format($formato);
}

/**
 *  Listagem de filmes
 */
function index()
{
	global $filmes;
	$filmes = find_all("filmes");
	//find_all e find é a mesma coisa, resulta na mesma coisa
}

/**
 *  Visualização de um Cliente
 */
function view($id = null)
{
	global $filme;
	$filme = find('filmes', $id);
}

/**
 *  Cadastro de Clientes
 */
function add()
{
	if (!empty($_POST['filme'])) {
		$arquivo = $_FILES['filme'];

		$nome = basename($arquivo['name']['capa']);
		$destino = "../imgs/" . $nome;

		if (move_uploaded_file($arquivo['tmp_name']['capa'], $destino)) {
			$customer = $_POST['filme'];
			$customer['capa'] = $nome;

			save('filmes', $customer);

			header('Location: index.php');
			exit;
		}

		echo "Erro ao salvar a imagem.";
	}
}

/**
 *	Atualizacao/Edicao de Cliente
 */
function edit()
{
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        if (isset($_POST['filme'])) {

            $customer = $_POST['filme'];

            if (
                isset($_FILES['filme']) &&
                isset($_FILES['filme']['error']['capa']) &&
                $_FILES['filme']['error']['capa'] === UPLOAD_ERR_OK
            ) {

                $arquivo = $_FILES['filme'];

                $nome = basename($arquivo['name']['capa']);
                $destino = "../imgs/" . $nome;

                if (move_uploaded_file($arquivo['tmp_name']['capa'], $destino)) {
                    $customer['capa'] = $nome;
                }
            }

            update("filmes", $id, $customer);

            header("Location: index.php");
            exit;

        } else {

            global $customer;
            $customer = find("filmes", $id);
        }

    } else {

        header("Location: index.php");
        exit;
    }
}

/**
 *  Exclusão de um Cliente
 */
function delete($id = null)
{

	global $customer;
	$customer = remove('filmes', $id);

	header("location: index.php");
}
