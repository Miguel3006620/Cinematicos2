<?php
ob_start();

require_once __DIR__ . '/../config.php';
require_once DBAPI;
/**
 *  Fomatar as datas
 */
function formatadata($data, $formato)
{
    $dt = new DateTime($data, new DateTimeZone("America/Sao_Paulo")); // "-0300"
    return $dt->format($formato);
}

/**
 *  Fomatar as telefones
 */
function telefone($tel)
{ //15997332244
    return "(" . substr($tel, 0, 2) . ")" . substr($tel, 2, 5)
        . "-" . substr($tel, 7, 4);
}

/**
 *  Fomatar as telefones
 */
function cep($cep)
{
    // Se vira para fazer
}

/**
 *  Listagem de Usuários
 */
$usuario = null;
$usuarios = null;

/**
 *  Listagem de Usuários
 */
function index()
{
    global $usuarios;
    if (!empty($_POST['users'])) {
        $usuarios = filter("usuarios", "nome like '%" . $_POST['users'] . "%'");
    } else {
        $usuarios = find_all("usuarios");
    }
}
function clear_messages()
{
    $_SESSION['message'] = null;
    $_SESSION['type'] = null;
}
/**
 *  Criptografia
 */
function criptografia($senha)
{
    /*
        ==> Criptografia Blowfish
        http://www.linhadecodigo.com.br/artigo/3532/criptografando-senhas-usando-bcrypt-blowfish-no-php.aspx
    */
    // Aplicando criptografia na senha
    $custo = "08";
    $salt = "Cf1f11ePArK1BJomM0F6aJ";

    // Gera um hash baseado em bcrypt
    $hash = crypt($senha, "$2a$" . $custo . "$" . $salt . "$");

    return $hash; // retorna a senha criptografada

}

/**
 *  Upload de imagens
 */
function upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo)
{
    /*
    ==> Upload de arquivos no PHP
    https://www.w3schools.com/php/php_file_upload.asp
    */
    // Upload da foto
    try {
        $nomearquivo = basename($arquivo_destino); // nome do arquivo
        $uploadOk = 1;
        // Verificando se o arquivo é uma imagem
        if (isset($_POST["submit"])) {
            $check = getimagesize($nome_temp);
            if ($check !== false) {
                $_SESSION['message'] = "File is an image - " . $check["mime"] . ".";
                $_SESSION['type'] = "info";
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                throw new Exception("O arquivo não é uma imagem!");
                //echo "O arquivo não é uma imagem!";
            }
        }

        // Verificando se o arquivo já existe na pasta
        if (file_exists($arquivo_destino)) {
            $uploadOk = 0;
            throw new Exception("Desculpe, o arquivo já existe!");
            //echo "Desculpe, o arquivo já existe.";
        }

        // Verificando se o tamanho do arquivo
        if ($tamanho_arquivo > 5000000) {
            $uploadOk = 0;
            throw new Exception("Desculpe, mas o arquivo é muito grande!");
            //echo "Desculpe, mas o arquivo é muito grande!";
        }

        // Allow certain file formats
        if (
            $tipo_arquivo != "jpg" && $tipo_arquivo != "png" && $tipo_arquivo != "jpeg"
            && $tipo_arquivo != "gif"
        ) {
            $uploadOk = 0;
            throw new Exception("Desculpe, mas só são permitidos arquivos de imagem JPG, JPEG, PNG e GIF!");
            //echo "Desculpe, mas só são permitidos arquivos de imagem JPG, JPEG, PNG e GIF!";
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            throw new Exception("Desculpe, mas o arquivo não pode ser enviado.");
            //echo "Desculpe, mas o arquivo não pode ser enviado.";
        } else {
            // Se tudo estiver OK, tentamos fazer o upload do arquivo
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $arquivo_destino)) {
                //colocando o nome do arquivo da foto do usuário no vetor
                $_SESSION['message'] = "O arquivo " . htmlspecialchars($nomearquivo) . " foi armazenado.";
                $_SESSION['type'] = "success";
                //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
                throw new Exception("Desculpe, mas o arquivo não pode ser enviado.");
                //echo "Sorry, there was an error uploading your file.";
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}
/**
 *  Cadastro de Usuários
 */
/**
 *  Cadastro de Usuários. Retorna true se gravou, false se falhou.
 */
function add()
{
    $_SESSION['type'] = null;

    if (empty($_POST['usuario'])) {
        $_SESSION['message'] = "Preencha os dados do cadastro.";
        $_SESSION['type'] = "danger";
        return false;
    }

    if (empty($_FILES["foto"]["name"]) || $_FILES["foto"]["error"] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = "Você precisa selecionar uma foto de perfil.";
        $_SESSION['type'] = "danger";
        return false;
    }

    $usuario = $_POST['usuario'];

    $pasta_destino = __DIR__ . "/imagens/";
    $nomeoriginal = basename($_FILES["foto"]["name"]);
    $tipo_arquivo = strtolower(pathinfo($nomeoriginal, PATHINFO_EXTENSION));
    $nomearquivo = uniqid() . "." . $tipo_arquivo;
    $arquivo_destino = $pasta_destino . $nomearquivo;

    upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $_FILES["foto"]["tmp_name"], $_FILES["foto"]["size"]);

    if (($_SESSION['type'] ?? '') === 'danger') {
        return false;
    }

    $usuario['foto'] = $nomearquivo;
    $usuario['nivel'] = 'usuario';

    if (!empty($usuario['password'])) {
        $usuario['password'] = criptografia($usuario['password']);
    }

    save('usuarios', $usuario);

    return ($_SESSION['type'] ?? '') === 'success';
}

/**
 *  Atualizacao/Edicao de Usuários
 */
function edit()
{

    //$now = new DateTime("now");
    try {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (isset($_POST['usuario'])) {

                $usuario = $_POST['usuario'];

                //criptografando a senha
                if (!empty($usuario['password'])) {
                    $senha = criptografia($usuario['password']);
                    $usuario['password'] = $senha;
                }

                if (!empty($_FILES["foto"]["name"])) {
                    // Upload da foto
                    $pasta_destino = "imagens/"; //pasta onde ficam as fotos
                    $arquivo_destino = $pasta_destino . basename($_FILES["foto"]["name"]); //Caminho completo até o arquivo que será gravado
                    $nomearquivo = basename($_FILES["foto"]["name"]); // nome do arquivo
                    $resolucao_arquivo = getimagesize($_FILES["foto"]["tmp_name"]);
                    $tamanho_arquivo = $_FILES["foto"]["size"]; //tamanho do arquivo em bytes
                    $nome_temp = $_FILES["foto"]["tmp_name"]; // nome e caminho do arquivo no servidor
                    $tipo_arquivo = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION)); // extensão do arquivo

                    upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo);

                    $usuario['foto'] = $nomearquivo;
                }

                update('usuarios', $id, $usuario);
                header('Location: index.php');
            } else {
                global $usuario;
                $usuario = find("usuarios", $id);
            }
        } else {
            header("Location: index.php");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}

/**
 *  Visualização de um Usuários
 */
function view($id = null)
{
    global $usuario;
    $usuario = find("usuarios", $id);
}

/**
 *  Exclusão de um Usuários
 */

function delete($id = null)
{

    global $usuarios;
    $usuarios = remove("usuarios", $id);

    header("Location: index.php");
}
