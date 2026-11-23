<?php
ob_start();

require_once __DIR__ . '/../config.php';
require_once DBAPI;

/**
 *  Formatar as datas
 */
function formatadata($data, $formato)
{
    $dt = new DateTime($data, new DateTimeZone("America/Sao_Paulo"));
    return $dt->format($formato);
}

/**
 *  Formatar os telefones
 */
function telefone($tel)
{
    return "(" . substr($tel, 0, 2) . ")" . substr($tel, 2, 5)
        . "-" . substr($tel, 7, 4);
}

/**
 *  Formatar os CEPs
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

function index()
{
    global $usuarios;
    if (!empty($_POST['users'])) {
        $usuarios = buscar_por_nome("usuarios", $_POST['users']);
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
    $custo = "08";
    $salt = "Cf1f11ePArK1BJomM0F6aJ";

    $hash = crypt($senha, "$2a$" . $custo . "$" . $salt . "$");

    return $hash;
}

/**
 *  Upload de imagens
 */
function upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo)
{
    try {
        $nomearquivo = basename($arquivo_destino);

        // Verifica sempre se o arquivo é uma imagem de verdade
        $check = @getimagesize($nome_temp);
        if ($check === false) {
            throw new Exception("O arquivo não é uma imagem!");
        }

        // Verifica se o arquivo já existe na pasta
        if (file_exists($arquivo_destino)) {
            throw new Exception("Desculpe, o arquivo já existe!");
        }

        // Verifica o tamanho do arquivo (5 MB)
        if ($tamanho_arquivo > 5000000) {
            throw new Exception("Desculpe, mas o arquivo é muito grande!");
        }

        // Formatos permitidos
        if (!in_array($tipo_arquivo, ["jpg", "png", "jpeg", "gif"], true)) {
            throw new Exception("Desculpe, mas só são permitidos arquivos de imagem JPG, JPEG, PNG e GIF!");
        }

        if (move_uploaded_file($nome_temp, $arquivo_destino)) {
            $_SESSION['message'] = "O arquivo " . htmlspecialchars($nomearquivo) . " foi armazenado.";
            $_SESSION['type'] = "success";
        } else {
            throw new Exception("Desculpe, mas o arquivo não pode ser enviado.");
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}

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

    $usuario['foto']  = $nomearquivo;
    $usuario['nivel'] = NIVEL_USUARIO; // cadastro público sempre cria cliente

    if (!empty($usuario['password'])) {
        $usuario['password'] = criptografia($usuario['password']);
    }

    save('usuarios', $usuario);

    return ($_SESSION['type'] ?? '') === 'success';
}

/**
 *  Atualização/Edição de Usuários
 */
function edit()
{
    try {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (isset($_POST['usuario'])) {

                $usuario = $_POST['usuario'];

                // Impede que o formulário altere campos sensíveis
                unset($usuario['id'], $usuario['nivel'], $usuario['foto']);

                // Criptografa a senha, se foi informada
                if (!empty($usuario['password'])) {
                    $usuario['password'] = criptografia($usuario['password']);
                } else {
                    unset($usuario['password']); // campo vazio = mantém a senha atual
                }

                if (!empty($_FILES["foto"]["name"])) {
                    $pasta_destino = __DIR__ . "/imagens/";
                    $nomeoriginal  = basename($_FILES["foto"]["name"]);
                    $tipo_arquivo  = strtolower(pathinfo($nomeoriginal, PATHINFO_EXTENSION));
                    $nomearquivo   = uniqid() . "." . $tipo_arquivo;
                    $arquivo_destino = $pasta_destino . $nomearquivo;

                    upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $_FILES["foto"]["tmp_name"], $_FILES["foto"]["size"]);

                    if (($_SESSION['type'] ?? '') !== 'danger') {
                        $usuario['foto'] = $nomearquivo;
                    }
                }

                update('usuarios', $id, $usuario);
                header('Location: index.php');
                exit;
            } else {
                global $usuario;
                $usuario = find("usuarios", $id);
            }
        } else {
            header("Location: index.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}

/**
 *  Visualização de um Usuário
 */
function view($id = null)
{
    global $usuario;
    $usuario = find("usuarios", $id);
}

/**
 *  Exclusão de um Usuário
 */
function delete($id = null)
{
    global $usuarios;
    $usuarios = remove("usuarios", $id);

    header("Location: index.php");
    exit;
}