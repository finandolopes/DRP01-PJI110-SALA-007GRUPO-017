<?php
    include('../php/verifica_login.php');
    include('../php/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Excluir logins?</title>
    </head>
    <body>
        <form action="" method="POST">
            <label>Você tem certeza que deseja excluir todos os logins de usuários?</label>
            <input type="text" id="valor" name="valor"/>
            <button type="submit" name="botão" class="btn">Excluir</button>
            <a href="admin.php">Não, voltar</a>
        </form>
    </body>
</html>
<?php 
    if(!empty($_POST)){
        $query = "DELETE FROM adm";
        $res = mysqli_query($con, $query) or die('erro');
        if($res == 1){
            echo "excluído com sucesso";
        }
    }
?>