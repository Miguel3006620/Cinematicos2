<?php
require_once __DIR__ . '/../config.php';
require_once DBAPI;

const EXTENSOES_FOTO = ['jpg', 'jpeg', 'png', 'gif'];
const FOTO_PADRAO    = 'usuario-generico.jpg';

/* ---------- Consultas ---------- */

function listar_usuarios(): ?array
{
    if (!empty($_POST['users'])) {
        return buscar_por_nome("usuarios", trim($_POST['users']));
    }
    return find_all("usuarios");
}

function buscar_usuario(int $id): ?array
{
    return $id > 0 ? (find("usuarios", $id) ?: null) : null;
}

// Verifica se o login já existe. $ignorarId evita comparar com o próprio usuário na edição.
function usuario_existe(string $login, ?int $ignorarId = null): bool
{
    $bd = open_database();

    if ($ignorarId !== null) {
        $stmt = $bd->prepare("SELECT id FROM usuarios WHERE user = ? AND id <> ? LIMIT 1");
        $stmt->bind_param("si", $login, $ignorarId);
    } else {
        $stmt = $bd->prepare("SELECT id FROM usuarios WHERE user = ? LIMIT 1");
        $stmt->bind_param("s", $login);
    }

    $stmt->execute();
    $existe = $stmt->get_result()->num_rows > 0;
    close_database($bd);

    return $existe;
}

/* ---------- Senha ---------- */

function criptografia($senha)
{
    /*
        ==> Criptografia Blowfish
        http://www.linhadecodigo.com.br/artigo/3532/criptografando-senhas-usando-bcrypt-blowfish-no-php.aspx
    */
    $custo = "08";
    $salt = "Cf1f11ePArK1BJomM0F6aJ";

    return crypt($senha, "$2a$" . $custo . "$" . $salt . "$");
}

/* ---------- Foto ---------- */

// Valida e salva a foto em Usuarios/imagens. Retorna o nome do arquivo ou null (com mensagem).
function salvar_foto(array $arquivo): ?string
{
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        flash("Não foi possível enviar a foto. Tente outra imagem.");
        return null;
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        flash("A foto é muito grande (máximo 5 MB).");
        return null;
    }

    $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, EXTENSOES_FOTO, true)) {
        flash("Só são permitidos arquivos JPG, JPEG, PNG e GIF.");
        return null;
    }

    if (@getimagesize($arquivo['tmp_name']) === false) {
        flash("O arquivo enviado não é uma imagem válida.");
        return null;
    }

    $nome = uniqid() . "." . $ext;

    if (!move_uploaded_file($arquivo['tmp_name'], __DIR__ . "/imagens/" . $nome)) {
        flash("Não foi possível salvar a foto no servidor.");
        return null;
    }

    return $nome;
}

/* ---------- Cadastro ---------- */

// Visitante (cadastro público) sempre cria cliente comum.
// Admin logado pode escolher o nível.
function add(): bool
{
    $dados = $_POST['usuario'] ?? [];
    $nome  = trim($dados['nome'] ?? '');
    $user  = trim($dados['user'] ?? '');
    $senha = $dados['password'] ?? '';

    if ($nome === '' || $user === '' || $senha === '') {
        flash("Preencha nome, usuário e senha.");
        return false;
    }

    if (mb_strlen($nome) > 50 || mb_strlen($user) > 50) {
        flash("Nome e usuário podem ter no máximo 50 caracteres.");
        return false;
    }

    if (usuario_existe($user)) {
        flash("Esse nome de usuário já está em uso. Escolha outro.");
        return false;
    }

    if (empty($_FILES['foto']['name'])) {
        flash("Você precisa selecionar uma foto de perfil.");
        return false;
    }

    $foto = salvar_foto($_FILES['foto']);
    if ($foto === null) {
        return false;
    }

    $nivel = NIVEL_USUARIO;
    if (is_admin() && in_array($dados['nivel'] ?? '', [NIVEL_ADMIN, NIVEL_USUARIO], true)) {
        $nivel = $dados['nivel'];
    }

    save('usuarios', [
        'nome'     => $nome,
        'user'     => $user,
        'password' => criptografia($senha),
        'nivel'    => $nivel,
        'foto'     => $foto,
    ]);

    return ($_SESSION['type'] ?? '') === 'success';
}

/* ---------- Edição ---------- */

// Atualiza dados. Senha em branco mantém a atual. Nível só muda por admin.
function atualizar_usuario(int $id): bool
{
    $atual = buscar_usuario($id);
    if (!$atual) {
        flash("Usuário não encontrado.");
        return false;
    }

    $dados = $_POST['usuario'] ?? [];
    $nome  = trim($dados['nome'] ?? '');
    $user  = trim($dados['user'] ?? '');
    $senha = $dados['password'] ?? '';

    if ($nome === '' || $user === '') {
        flash("Nome e usuário são obrigatórios.");
        return false;
    }

    if (mb_strlen($nome) > 50 || mb_strlen($user) > 50) {
        flash("Nome e usuário podem ter no máximo 50 caracteres.");
        return false;
    }

    if (usuario_existe($user, $id)) {
        flash("Esse nome de usuário já está em uso. Escolha outro.");
        return false;
    }

    $alterar = ['nome' => $nome, 'user' => $user];

    if (is_admin()) {
        $nivel = $dados['nivel'] ?? $atual['nivel'];
        if (!in_array($nivel, [NIVEL_ADMIN, NIVEL_USUARIO], true)) {
            $nivel = $atual['nivel'];
        }

        // Ninguém remove o próprio acesso de admin
        if ($id === (int) ($_SESSION['id'] ?? 0) && $nivel !== NIVEL_ADMIN) {
            flash("Você não pode remover o seu próprio acesso de administrador.");
            return false;
        }

        $alterar['nivel'] = $nivel;
    }

    if ($senha !== '') {
        $alterar['password'] = criptografia($senha);
    }

    $fotoNova = null;
    if (!empty($_FILES['foto']['name'])) {
        $fotoNova = salvar_foto($_FILES['foto']);
        if ($fotoNova === null) {
            return false;
        }
        $alterar['foto'] = $fotoNova;
    }

    clear_messages();
    update('usuarios', $id, $alterar);

    if (($_SESSION['type'] ?? '') !== 'success') {
        return false;
    }

    // Apaga a foto antiga, se foi trocada (nunca apaga a foto padrão)
    if ($fotoNova !== null && !empty($atual['foto']) && $atual['foto'] !== FOTO_PADRAO) {
        @unlink(__DIR__ . "/imagens/" . basename($atual['foto']));
    }

    // Se o admin editou a própria conta, atualiza a sessão
    if ($id === (int) ($_SESSION['id'] ?? 0)) {
        $_SESSION['nome'] = $nome;
        $_SESSION['user'] = $user;
    }

    return true;
}