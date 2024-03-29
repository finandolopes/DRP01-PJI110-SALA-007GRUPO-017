<?php
    include_once('../php/verifica_login.php');
    include_once('../php/conexao.php');
    $id_cliente = $_GET['id'];
    $query = "SELECT id_cliente, nome FROM cliente WHERE id_cliente = '$id_cliente'";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_array($res);
    if(!empty($_POST)){
        $cliente = $_POST['cliente'];
        $excluir = "DELETE FROM cliente WHERE id_cliente = '$cliente'";
        $res2 = mysqli_query($con, $excluir);
        if($res2 == 1){
            header('Location: pessoas.php');

        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../script/jquery.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script src="../script/bootstrap.js"></script>
        <title>Excluir - <?php echo $row['nome']; ?></title>
    </head>
    <body>
        <form action="" method="POST">
            <div class="text-center">
                <h2>Tem certeza que deseja excluir <?php echo $row['nome']; ?>?</h2>
                <input type="hidden" name="cliente" id="cliente" value="<?php echo $row['id_cliente']; ?>"/>
                <button type="submit" class="btn btn-success">Sim</button>
                <a href="pessoas.php"><button type="button" class="btn btn-danger">Não</button></a>
            </div>
        </form>
    </body>
</html>