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
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <title>Editar Clientes</title>
    <style>
        body {
            background-color: #fff;
            color: #333;
            padding: 20px;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"],
        button {
            padding: 10px 20px;
            background-color: #0078d4;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button {
            margin-top: 10px;
            margin-right: 10px;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #005a9e;
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

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>">

        <input type="submit" value="Salvar">
    </form>
<?php endif; ?>

<button type="button" class="ms-Button ms-Button--primary" onclick="window.location.href='admin.php'">Voltar</button>
</body>
</html>
