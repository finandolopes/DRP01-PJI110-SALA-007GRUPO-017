<?php 
    session_start();
    include_once('conexao.php');

    $login = mysqli_real_escape_string($con, $_POST['usuario']);
    $senha = mysqli_real_escape_string($con, $_POST['senha']);

    $query = "SELECT usuario, id_usuario FROM adm WHERE usuario = '$login' AND senha = md5('$senha')";
    $res = mysqli_query($con, $query);
    $row = mysqli_num_rows($res) or die('erro');

    if($row ==  1){
        $_SESSION['usuario'] = $login or die('erro');
        header('Location: admin.php');
        exit();
    }else{
        $_SESSION['nao_autenticado'] = true;
        header('Location:index.php');
        exit();
    }

?>
