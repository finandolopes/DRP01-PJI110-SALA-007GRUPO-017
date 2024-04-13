<?php
session_start();
include_once('../php/conexao.php'); // Ajuste no caminho do include_once

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
$result = $conexao->query($sql); // Executar a consulta SQL

// Verificar se a consulta foi bem-sucedida
if ($result) {
    // Início da geração de HTML utilizando os resultados da consulta
    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <title>Moderação de Depoimentos</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #fff;
            padding: 20px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            background-color: #0078d4;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #005a9e;
        }

        select {
            background-color: #fff;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Moderação de Depoimentos</h1>
    <h2>Depoimentos Pendentes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Mensagem</th>
            <th>Ação</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
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


    <?php
    // Fim da geração de HTML utilizando os resultados da consulta
} else {
    // Caso a consulta tenha falhado
    echo "Erro na consulta SQL: " . $conexao->error;
}
?>
