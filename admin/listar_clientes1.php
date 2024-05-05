<?php
// Incluir o arquivo de conexão e as funções de manipulação de clientes
include('../php/conexao.php');
include('../php/funcoes_clientes.php');

// Consultar todos os clientes do banco de dados
$clientes = listarClientes($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <title>Listar Clientes</title>
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
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #0078d4;
            color: #fff;
        }

        tbody tr:nth-child(odd) {
            background-color: #f4f4f4;
        }

        tbody tr:hover {
            background-color: #eaeaea;
        }

        .btn-action {
            padding: 5px 20px;
            background-color: #0078d4;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #0078d4;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #0078d4;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #005a9e;
        }

        .btn-action:hover {
            opacity: 0.8;
        }

        /* Adicionado estilo para os botões ficarem lado a lado */
        .btn-container {
            display: flex;
        }
    </style>
</head>
<body>
<h1>Clientes que entraram em contato</h1>

<!-- Tabela para exibir os clientes -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>                
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($clientes as $cliente): ?>
            <tr>
                <td><?php echo $cliente['id_cliente']; ?></td>
                <td><?php echo $cliente['nome']; ?></td>
                <td><?php echo $cliente['email']; ?></td>
                <td><?php echo $cliente['telefone']; ?></td>                    
                <td class="btn-container">
                    <form action="editar_cliente.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $cliente['id_cliente']; ?>">
                        <button type="submit" class="btn-action btn-edit">Editar</button>
                    </form>
                    <form action="excluir_cliente.php" method="GET" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                        <input type="hidden" name="id" value="<?php echo $cliente['id_cliente']; ?>">
                        <button type="submit" class="btn-action btn-delete">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="button" class="btn-back" onclick="window.location.href='admin.php'">Voltar</button>
</body>
</html>
