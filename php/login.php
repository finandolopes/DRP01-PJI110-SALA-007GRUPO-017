<?php
// Incluir o arquivo de conexão
include_once('../php/conexao.php');

// Verifica se os campos de login foram enviados via POST
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    // Escapa os valores do formulário para evitar injeção de SQL
    $login = mysqli_real_escape_string($con, $_POST['usuario']);
    $senha = mysqli_real_escape_string($con, $_POST['senha']);

    // Consulta SQL para verificar as credenciais do usuário
    $query = "SELECT id_usuario FROM adm WHERE usuario = '$login' AND senha = md5('$senha')";
    $res = mysqli_query($con, $query);

    // Verifica se encontrou um usuário com as credenciais fornecidas
    if (mysqli_num_rows($res) ==  1) {
        // Usuário autenticado com sucesso
        $_SESSION['usuario'] = $login;
        header('Location: ../admin/admin.php'); // Redireciona para admin.php
        exit();
    } else {
        // Credenciais inválidas, redireciona para o index.php com uma mensagem de erro
        $_SESSION['nao_autenticado'] = true;
        header('Location: ../index.php?login=erro'); // Adicionado parâmetro para exibir mensagem de erro
        exit();
    }
} else {
    // Se os campos de login não foram enviados via POST, redireciona para o index.php
    header('Location: ../index.php'); // Redireciona para index.php
    exit();
}
?>
