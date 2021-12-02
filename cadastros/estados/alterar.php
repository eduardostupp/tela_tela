<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'alterar')) {
    try {
        $stmt = $conn->prepare('update estados set nome = :nome, sigla = :sigla where id = :id');
        if ($stmt->execute(['nome' => filter_input(INPUT_POST, 'nome'), 'sigla' => filter_input(INPUT_POST, 'sigla'), 'id' => filter_input(INPUT_GET, 'id')])) {
            unset($_GET['id']);
            include CADASTROS . 'estados/listagem.php';
            exit();
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

if ($iIdPessoa = filter_input(INPUT_GET, 'id')) {
    $stmt = $conn->prepare('SELECT * FROM estados WHERE id = :id');
    $stmt->bindParam(':id', $iIdPessoa, PDO::PARAM_INT);
}
$stmt->execute();
$oRes = $stmt->fetchObject();
?>
<form method="post">
    <label>Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="<?= $oRes->nome ?>">
    <label>Sigla</label>
    <input type="text" class="form-control" name="sigla" id="sigla" value="<?= $oRes->sigla ?>">

    <input type="submit" name="alterar" value="Salvar">
</form>