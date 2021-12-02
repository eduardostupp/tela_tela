<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'gravar')) {
    try {
        $stmt = $conn->prepare('insert into estados (nome, sigla) values (:nome, :sigla)');
        if ($stmt->execute(['nome' => filter_input(INPUT_POST, 'nome'), 'sigla' => filter_input(INPUT_POST, 'sigla')])) {
            include CADASTROS . 'estados/listagem.php';
            exit();
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
?>
<form method="post">
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
        <label for="nome">Sigla</label>
        <input type="text" class="form-control" name="sigla" id="sigla" placeholder="Sigla">
    </div>
    <input type="submit" name="gravar" value="Gravar">
</form>
