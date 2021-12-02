<?php
if (filter_input(INPUT_POST, 'login')) {
    try {
        $stmt = $conn->prepare('select *' . ENTER .
                               '  from usuarios' .
                               ' where email = :email' . ENTER .
                               '   and password = :senha');
        if ($stmt->execute(array('email' => filter_input(INPUT_POST, 'email'), 'senha' => md5(filter_input(INPUT_POST, 'senha'))))) {
            if ($oRes = $stmt->fetchObject()) {
                $_SESSION['id']      = $oRes->id;
                $_SESSION['usuario'] = $oRes->login;
                $_SESSION['email']   = $oRes->email;
                $_SESSION['nome']    = $oRes->nome;

                include LAYOUTS . 'header.php';
                include LAYOUTS . 'menu.php';
                include LAYOUTS . 'home.php';
                include LAYOUTS . 'footer.php';


                exit();
            }
        } else {
            include SISTEMA . 'login.php';
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

}
?>
<form method="post">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
        <label for="senha">Senha</label>
        <input type="password" class="form-control" name="senha" id="senha" required>
    </div>
    <input type="submit" class="btn btn-success" name="login" value="Login">
    <a href="cadastros/sistema/registrar.php" class="btn btn-primary">Registrar</a>
</form>
