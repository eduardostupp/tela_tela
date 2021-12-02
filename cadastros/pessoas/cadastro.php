<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'gravar')) {
    try {
        $stmt = $conn->prepare(
                'INSERT INTO pessoas (nome) values (:nome)');
        if ($stmt->execute(array('nome' => filter_input(INPUT_POST, 'nome')))) {
            include CADASTROS . 'pessoas/listagem.php';
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
    </div>
    <input type="submit" name="gravar" value="Gravar">
</form>
