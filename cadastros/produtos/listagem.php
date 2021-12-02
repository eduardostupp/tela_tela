<?php
if (!isset($_SESSION['usuario'])) {
    include SISTEMA . 'login.php';
    exit();
}

try {
    $stmt = $conn->prepare('select id,' . ENTER .
                           '       marca,' . ENTER .
                           '       nome,' . ENTER .
                           '       quantidade,' . ENTER .
                           '       valorunitario,' . ENTER .
                           '       round((valorunitario * quantidade), 2) as valortotal' . ENTER .
                           'from produtos');
    $stmt->execute();

    $result = $stmt->fetchAll();
    $iNroPaginacao = ceil(count($result) / 10);
    ?>
    <table border="1" class="table table-striped">
        <tr>
            <td>ID</td>
            <td>Marca</td>
            <td>Nome</td>
            <td>Quantidade</td>
            <td>Valor Unitário</td>
            <td>Valor Total</td>
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
                        <td><?= $row['marca'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td><?= $row['quantidade'] ?></td>
                        <td><?= $row['valorunitario'] ?></td>
                        <td><?= $row['valortotal'] ?></td>
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
            $sPaginacao .= '<li class="page-item"><a class="page-link" href="?paginacao=' . $i . '">' . ($i + 1) . '</a></li>' . ENTER;
        }
        $sPaginacao .= '</ul>';

        echo $sPaginacao;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
