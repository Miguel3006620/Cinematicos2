<?php
// DBAPI: acesso ao banco com prepared statements

$mysqli = new mysqli_driver();
$mysqli->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

function open_database()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn->set_charset("utf8");
        return $conn;
    } catch (Exception $e) {
        throw new Exception("Erro ao conectar no banco de dados\n " . $e->getMessage());
    }
}

function close_database($conn)
{
    if ($conn instanceof mysqli) {
        $conn->close();
    }
}

/**
 *  Nomes de tabela e coluna não podem ser passados com "?".
 *  Por isso validamos com regex (só letras, números e _) e colocamos entre crases.
 */
function nome_tabela($table)
{
    if (!is_string($table) || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $table)) {
        throw new Exception("Nome de tabela inválido.");
    }
    return "`$table`";
}

function nome_coluna($coluna)
{
    if (!is_string($coluna) || !preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $coluna)) {
        throw new Exception("Nome de coluna inválido.");
    }
    return "`$coluna`";
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela (ou todos, se não houver ID)
 */
function find($table = null, $id = null)
{
    $found = null;
    $database = null;

    try {
        $tabela = nome_tabela($table);
        $database = open_database();

        if ($id !== null && $id !== '') {
            $idInt = (int) $id;
            $stmt = $database->prepare("SELECT * FROM $tabela WHERE id = ?");
            $stmt->bind_param("i", $idInt);
            $stmt->execute();
            $found = $stmt->get_result()->fetch_assoc() ?: null;
        } else {
            $result = $database->query("SELECT * FROM $tabela");
            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
    return $found;
}

/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all($table)
{
    return find($table);
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null)
{
    $database = null;

    try {
        $tabela = nome_tabela($table);

        if (empty($data)) {
            throw new Exception("Nenhum dado para salvar.");
        }

        $colunas = [];
        $marcas = [];
        $valores = [];

        foreach ($data as $key => $value) {
            $colunas[] = nome_coluna($key);
            $marcas[] = '?';
            $valores[] = $value;
        }

        $sql = "INSERT INTO $tabela (" . implode(',', $colunas) . ") VALUES (" . implode(',', $marcas) . ")";

        $database = open_database();
        $stmt = $database->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($valores)), ...$valores);
        $stmt->execute();

        $_SESSION["message"] = "Registro cadastrado com sucesso.";
        $_SESSION["type"] = "success";
    } catch (Exception $e) {
        $_SESSION["message"] = "Nao foi possivel realizar a operacao.";
        $_SESSION["type"] = "danger";
    }

    close_database($database);
}

/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null, $id = 0, $data = null)
{
    $database = null;

    try {
        $tabela = nome_tabela($table);

        if (empty($data)) {
            throw new Exception("Nenhum dado para atualizar.");
        }

        $sets = [];
        $valores = [];

        foreach ($data as $key => $value) {
            $sets[] = nome_coluna($key) . " = ?";
            $valores[] = $value;
        }

        $valores[] = (int) $id;
        $tipos = str_repeat('s', count($valores) - 1) . 'i';

        $sql = "UPDATE $tabela SET " . implode(', ', $sets) . " WHERE id = ?";

        $database = open_database();
        $stmt = $database->prepare($sql);
        $stmt->bind_param($tipos, ...$valores);
        $stmt->execute();

        $_SESSION["message"] = "Registro atualizado com sucesso.";
        $_SESSION["type"] = "success";
    } catch (Exception $e) {
        $_SESSION["message"] = "Nao foi possivel realizar a operacao.";
        $_SESSION["type"] = "danger";
    }

    close_database($database);
}

/**
 *  Remove um registro por ID
 */
function remove($table = null, $id = null)
{
    $database = null;

    try {
        $tabela = nome_tabela($table);

        if ($id !== null && $id !== '') {
            $idInt = (int) $id;
            $database = open_database();
            $stmt = $database->prepare("DELETE FROM $tabela WHERE id = ?");
            $stmt->bind_param("i", $idInt);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION["message"] = "Registro Removido com Sucesso.";
                $_SESSION["type"] = "success";
            }
        }
    } catch (Exception $e) {
        $_SESSION["message"] = "Não foi possível realizar a operação:<br>" . $e->getMessage();
        $_SESSION["type"] = "danger";
    }

    close_database($database);
}

/**
 *  Busca registros cujo campo contém o termo (LIKE seguro).
 *  Substitui o antigo filter(), que recebia SQL pronto e era injetável.
 */
function buscar_por_nome($table = null, $termo = '', $campo = 'nome')
{
    $database = null;
    $found = null;

    try {
        $tabela = nome_tabela($table);
        $colunaBusca = nome_coluna($campo);

        $database = open_database();
        $stmt = $database->prepare("SELECT * FROM $tabela WHERE $colunaBusca LIKE ?");
        $padrao = "%" . $termo . "%";
        $stmt->bind_param("s", $padrao);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $_SESSION['message'] = "Não foram encontrados registros de dados!";
            $_SESSION['type'] = "danger";
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "Ocorreu um erro:" . $e->getMessage();
        $_SESSION['type'] = "danger";
    }

    close_database($database);
    return $found;
}