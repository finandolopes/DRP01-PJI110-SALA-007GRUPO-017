<?php
session_start();

// Verificar se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir o arquivo de conexão com o banco de dados
    include 'conexao.php';

    // Obter os dados do formulário
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];

    // Inserir os dados na tabela de depoimentos
    $sql = "INSERT INTO depoimentos (nome_cliente, mensagem, status_mod) VALUES ('$nome', '$mensagem', 'pendente')";
    if (mysqli_query($conexao, $sql)) {
        // Definir uma variável de sessão para indicar sucesso no envio do depoimento
        $_SESSION['sucesso_depoimento'] = true;
    } else {
        // Se houver um erro, você pode tratar de acordo com sua lógica de aplicativo
        echo "<p class='text-danger'>Erro ao enviar depoimento: " . mysqli_error($conexao) . "</p>";
    }

    // Redirecionar de volta para a página de envio de depoimentos
    // Redirecionar de volta para o index.php após o envio de depoimentos
    header("Location: /index.php");
    exit(); // Certifique-se de que o script pare de ser executado após o redirecionamento
}
?>
