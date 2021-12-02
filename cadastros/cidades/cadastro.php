<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'gravar')) {
    try {
        $stmt = $conn->prepare('INSERT INTO cidades (codigo, nome, estado) values (:codigo, :nome, :estado)');
        // Processa o cadastro da cidade no sistema
        if ($stmt->execute(array('codigo' => filter_input(INPUT_POST, 'codigo'), 'nome' => filter_input(INPUT_POST, 'nome'), 'estado' => filter_input(INPUT_POST, 'estado')))) {
            include CADASTROS . 'cidades/listagem.php';
            exit();
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
?>
<form method="post">
    <div class="form-group">
        <label for="nome">Código</label>
        <input type="number" class="form-control" name="codigo" id="codigo" placeholder="Nome" required>
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
        <label for="nome">Estado</label>
        <select class="form-control" name="estado" required>
            <?php
            $stmt = $conn->prepare('select id,' . ENTER .
                                   '       nome' . ENTER .
                                   '  from estados');
            $stmt->execute();

            $sOptions = '<option value="">Selecione...</option>';
            while ($oRes = $stmt->fetchObject()) {
                $sOptions .= '<option value="' . $oRes->id . '">' . $oRes->nome . '</option>';
            }
            echo $sOptions;
            ?>
        </select>
    </div>
    <input type="submit" name="gravar" value="Gravar">
</form>
