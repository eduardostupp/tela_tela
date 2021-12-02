<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

if (filter_input(INPUT_POST, 'deletar')) {
    try {
        $stmt = $conn->prepare('delete from cidades where id = :id');
        $stmt->execute(['id' => filter_input(INPUT_GET, 'id')]);
        ?>
        <div class="alert alert-success" role="alert">
            Sucesso! O registro foi deletado.
        </div>
        <?php
        exit();
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}

if ($iId = filter_input(INPUT_GET, 'id')) {
    $stmt = $conn->prepare('select * from cidades where id = :id');
    $stmt->bindParam(':id', $iId, PDO::PARAM_INT);
}
$stmt->execute();
$oRes = $stmt->fetchObject();
?>
<form method="post">
    <input type="text" name="nome" value="<?= $oRes->nome ?>" disabled>
    Deseja realmente excluír esse cadastro?
    <input type="submit" name="deletar" value="Confirmar">
</form>
