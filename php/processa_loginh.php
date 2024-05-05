<?php
session_start();

// Inclua o arquivo de conexão
include_once('conexao.php');

// Verifique se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os campos de usuário e senha foram preenchidos
    if(isset($_POST['user']) && isset($_POST['senha'])){
        $user = $_POST['user'];
        $senha = $_POST['senha'];

        // Consulta SQL para verificar as credenciais do usuário
        $query = "SELECT * FROM usuarios WHERE usuario = '$user' AND senha = '$senha'";

        // Execute a consulta
        $result = mysqli_query($conexao, $query);

        // Verifique se a consulta retornou algum resultado
        if(mysqli_num_rows($result) == 1){
            // Login bem-sucedido, redirecione para o painel de administração
            $_SESSION['nome_usuario'] = $user; // Correção aqui
            header('Location: ../admin/admin.php'); // Ajuste no caminho do redirecionamento
            exit();
        } else {
            // Credenciais inválidas, redirecione de volta para a página de login com uma mensagem de erro
            header('Location: index.php?error=1');
            exit();
        }
    }
}
?>

