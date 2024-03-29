<?php
session_start();
include_once('php/conexao.php');

// Verificar se foi enviado um formulário para moderar um depoimento
if(isset($_POST['moderar_depoimento'])) {
    $id_depoimento = $_POST['id_depoimento'];
    $status_mod = $_POST['status_mod'];

    // Atualizar o status de moderação no banco de dados
    $sql = "UPDATE depoimentos SET status_mod = ?, ";
    if ($status_mod == "aprovado") {
        $sql .= "aprovado = 1, reprovado = 0 ";
    } elseif ($status_mod == "reprovado") {
        $sql .= "aprovado = 0, reprovado = 1 ";
    }
    $sql .= "WHERE id = ?";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $status_mod, $id_depoimento);
    $stmt->execute();

    // Definir uma variável de sessão para armazenar a mensagem de sucesso
    $_SESSION['sucesso_atualizacao'] = true;
}

// Consultar os depoimentos pendentes de moderação
$sql = "SELECT * FROM depoimentos WHERE status_mod = 'pendente'";
$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Listar Clientes</title>
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
    <h1>Moderação de Depoimentos</h1>

    <h2>Depoimentos Pendentes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Mensagem</th>
            <th>Ação</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome_cliente']; ?></td>
            <td><?php echo $row['mensagem']; ?></td>
            <td>
                <form action="admin_depoimentos.php" method="post">
                    <input type="hidden" name="id_depoimento" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="nome_cliente" value="<?php echo $row['nome_cliente']; ?>">
                    <input type="hidden" name="mensagem" value="<?php echo $row['mensagem']; ?>">
                    <input type="hidden" name="nome" value="<?php echo $row['nome']; ?>">
                    <select name="status_mod">
                        <option value="aprovado">Aprovar</option>
                        <option value="reprovado">Rejeitar</option>
                    </select>
                    <button type="submit" name="moderar_depoimento">Moderar</button>
                    <button type="submit" name="excluir_depoimento">Excluir</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button type="button" onclick="window.location.href='admin.php'">Voltar</button>
</body>
</html>
