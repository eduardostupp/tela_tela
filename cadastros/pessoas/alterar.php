<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'alterar')) {
    try {
        $stmt = $conn->prepare('UPDATE pessoas SET nome = :nome WHERE id = :id');
        if ($stmt->execute(array('nome' => filter_input(INPUT_POST, 'nome'), 'id' => filter_input(INPUT_GET, 'id')))) {
            unset($_GET['id']);
            include CADASTROS . 'pessoas/listagem.php';
            exit();
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

if ($iIdPessoa = filter_input(INPUT_GET, 'id')) {
    $stmt = $conn->prepare('SELECT * FROM pessoas WHERE id = :id');
    $stmt->bindParam(':id', $iIdPessoa, PDO::PARAM_INT);
}
$stmt->execute();
$r = $stmt->fetchAll();
?>
<form method="post">
    <input type="text" name="nome" value="<?= $r[0]['nome'] ?>">
    <input type="submit" name="alterar" value="Salvar">
</form>
