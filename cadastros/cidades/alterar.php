<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'alterar')) {
    try {
        $stmt = $conn->prepare('update cidades set codigo = :codigo, nome = :nome, estado = :estado where id = :id');
        if ($stmt->execute(['codigo' => filter_input(INPUT_POST, 'codigo'), 'nome' => filter_input(INPUT_POST, 'nome'), 'estado' => filter_input(INPUT_POST, 'estado'), 'id' => filter_input(INPUT_GET, 'id')])) {
            unset($_GET['id']);
            include CADASTROS . 'cidades/listagem.php';
            exit();
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

if ($iIdPessoa = filter_input(INPUT_GET, 'id')) {
    $stmt = $conn->prepare('select * from cidades where id = :id');
    $stmt->bindParam(':id', $iIdPessoa, PDO::PARAM_INT);
}
$stmt->execute();
$oRes = $stmt->fetchObject();
?>
<form method="post">
    <div class="form-group">
        <label for="nome">Código</label>
        <input type="number" class="form-control" name="codigo" id="codigo" placeholder="Nome" value="<?= $oRes->codigo ?>" required>
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="<?= $oRes->nome ?>" required>
        <label for="nome">Estado</label>
        <select class="form-control" name="estado" required>
            <?php
            $stmt = $conn->prepare('select id,' . ENTER .
                                   '       nome' . ENTER .
                                   '  from estados');
            $stmt->execute();

            $sOptions = '<option value="">Selecione...</option>';
            while ($oRegistroEstado = $stmt->fetchObject()) {
                $sOptions .= '<option ' . ($oRegistroEstado->id == $oRes->estado ? 'selected' : '') . ' value="' . $oRegistroEstado->id . '">' . $oRegistroEstado->nome . '</option>';
            }
            echo $sOptions;
            ?>
        </select>
    </div>
    <input type="submit" name="alterar" value="Salvar">
</form>