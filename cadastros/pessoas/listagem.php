<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

$id = filter_input(INPUT_GET, 'id');
try {
    if (isset($id) & $id !== false) {
        $stmt = $conn->prepare('SELECT * FROM pessoas WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare('SELECT * FROM pessoas');
    }
    $stmt->execute();

    $result = $stmt->fetchAll();
    $iNroPaginacao = ceil(count($result) / 10);
    ?>
    <table border="1" class="table table-striped">
        <tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Ação</td>
        </tr>
        <?php
        if (count($result)) {
            if ($iPaginacao = filter_input(INPUT_GET, 'paginacao')) {
                $iInicioRegistros = $iPaginacao * 10;
                $iFinalRegistros = $iInicioRegistros + 9;
            } else {
                $iInicioRegistros = 0;
                $iFinalRegistros  = 9;
            }
            foreach ($result as $iIndice => $row) {
                if ($iIndice >= $iInicioRegistros && $iIndice <= $iFinalRegistros) {
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td>
                            <a href="?modulo=pessoas&pagina=alterar&id=<?= $row['id'] ?>">Alterar</a>
                            <a href="?modulo=pessoas&pagina=deletar&id=<?= $row['id'] ?>">Excluír</a>
                        </td>
                    </tr>
                    <?php
                }
            }
        } else {
            echo "Nenhum resultado retornado.";
        }
        ?>
    </table>
    <?php
    if ($iNroPaginacao > 0) {
        $sPaginacao = '<ul class="pagination">' . ENTER;
        for ($i = 0; $i < $iNroPaginacao; $i++) {
            $sPaginacao .= '<li class="page-item"><a class="page-link" href="?modulo=pessoas&pagina=listagem&paginacao=' . $i . '">' . ($i + 1) . '</a></li>' . ENTER;
        }
        $sPaginacao .= '</ul>';

        echo $sPaginacao;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
