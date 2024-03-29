<?php
// Incluir o arquivo de conexão e as funções de manipulação de clientes
include_once('php/conexao.php'); 
include_once('php/funcoes_clientes.php');

// Verificar se o ID do cliente foi passado via GET
if(isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    
    // Consultar o cliente pelo ID
    $cliente = buscarClientePorId($conexao, $id_cliente);
    
    // Verificar se o cliente foi encontrado
    if($cliente) {
        // Processar os dados do formulário de edição se o formulário foi submetido
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obter os dados do formulário
            $id_cliente = $_POST['id_cliente'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            
            // Atualizar os dados do cliente
            $atualizado = atualizarCliente($conexao, $id_cliente, $nome, $email, $telefone);
            
            // Verificar se a atualização foi bem-sucedida
            if($atualizado) {
                // Redirecionar de volta para a lista de clientes
                header("Location: listar_clientes.php");
                exit;
            } else {
                // Exibir uma mensagem de erro
                $erro = "Erro ao atualizar o cliente. Por favor, tente novamente.";
            }
        }
    } else {
        // Se o cliente não foi encontrado, exibir uma mensagem de erro
        $erro = "Cliente não encontrado.";
    }
} else {
    // Se o ID do cliente não foi passado, redirecionar de volta para a lista de clientes
    header("Location: listar_clientes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Editar Clientes</title>
    <style>
        body {
            background-color: #343a40; /* Cor de fundo escura */
            color: #fff; /* Cor do texto */
            padding: 20px; /* Espaçamento interno */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6; /* Cor da linha inferior */
        }

        th {
            background-color: #343a40; /* Cor de fundo do cabeçalho */
            color: #fff; /* Cor do texto do cabeçalho */
        }

        tbody tr:nth-child(odd) {
            background-color: #495057; /* Cor de fundo das linhas ímpares */
        }

        tbody tr:hover {
            background-color: #6c757d; /* Cor de fundo ao passar o mouse */
        }

        .btn-action {
            padding: 5px 10px; /* Espaçamento interno */
            border: none; /* Remover borda */
            cursor: pointer; /* Alterar cursor ao passar o mouse */
            border-radius: 5px; /* Arredondar bordas */
            margin-right: 5px; /* Margem à direita */
        }

        .btn-edit {
            background-color: #007bff; /* Cor de fundo azul */
            color: #fff; /* Cor do texto */
        }

        .btn-delete {
            background-color: #dc3545; /* Cor de fundo vermelha */
            color: #fff; /* Cor do texto */
        }

        .btn-back {
            margin-top: 10px; /* Margem superior */
        }

        .btn-container {
            text-align: center; /* Centralizar botões */
        }
    </style>
</head>
<body>
    <h1>Editar Cliente</h1>
    
    <?php if(isset($erro)): ?>
        <p><?php echo $erro; ?></p>
    <?php else: ?>
        <form method="POST">
            <!-- Adicione um campo oculto para passar o ID do cliente -->
            <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
            
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>"><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>"><br>
            
            <label for="telefone">Telefone:</label><br>
            <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>"><br>
            
            <input type="submit" value="Salvar">
        </form>
    <?php endif; ?>
    
    <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='admin.php'">Voltar</button>
</body>
</html>
