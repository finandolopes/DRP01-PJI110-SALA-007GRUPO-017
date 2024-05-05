<?php
session_start();

// Verificar se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir o arquivo de conexão com o banco de dados
    include 'conexao.php';

    // Obter os dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; // Verifica se o campo nome está definido
    $mensagem = $_POST['mensagem'];

    // Verificar se o campo de mensagem está vazio
    if (empty($mensagem)) {
        // Definir uma variável de sessão para indicar o erro
        $_SESSION['erro_mensagem'] = "O campo de mensagem não pode estar vazio.";
    } else {
        // Verificar se o campo de nome está vazio
        if (empty($nome)) {
            // Define o nome como "Anônimo" se estiver vazio
            $nome = "Anônimo";
        }

        // Inserir os dados na tabela de depoimentos
        $sql = "INSERT INTO depoimentos (nome_cliente, mensagem, status_mod) VALUES ('$nome', '$mensagem', 'pendente')";
        if (mysqli_query($conexao, $sql)) {
            // Definir uma variável de sessão para indicar sucesso no envio do depoimento
            $_SESSION['sucesso_depoimento'] = true;
        } else {
            // Se houver um erro, você pode tratar de acordo com sua lógica de aplicativo
            $_SESSION['erro_mensagem'] = "Erro ao enviar depoimento: " . mysqli_error($conexao);
        }
    }
}

// Retornar à página de envio de depoimentos
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
