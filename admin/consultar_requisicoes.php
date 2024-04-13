<?php
// Incluir o arquivo de conexão e as funções de manipulação de requisições
include_once('../php/conexao.php');
include_once('../php/funcoes_requisicoes.php');

// Verificar se o formulário de filtro foi submetido
if(isset($_POST['filtrar'])) {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consultar requisições filtradas por data
    $requisicoes = listarRequisicoesPorData($conexao, $data_inicio, $data_fim);
} else {
    // Consultar todas as requisições do banco de dados
    $requisicoes = listarRequisicoes($conexao);
}

// Verificar se o formulário foi enviado e se há requisições para exportar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exportar']) && !empty($requisicoes)) {
    // Inicializar o objeto SimpleXMLElement para criar o XML
    $xml = new SimpleXMLElement('<requisicoes></requisicoes>');

    // Iterar sobre as requisições para adicionar cada uma ao XML
    foreach ($requisicoes as $requisicao) {
        // Criar um novo elemento "requisicao"
        $requisicaoXML = $xml->addChild('requisicao');

        // Adicionar os dados da requisição como elementos filho do elemento "requisicao"
        $requisicaoXML->addChild('id', $requisicao['id_requisicao']);
        $requisicaoXML->addChild('nome', $requisicao['nome']);
        $requisicaoXML->addChild('data_nascimento', isset($requisicao['data_nascimento']) ? $requisicao['data_nascimento'] : '');
        $requisicaoXML->addChild('email', $requisicao['email']);
        $requisicaoXML->addChild('telefone', $requisicao['telefone']);
        $requisicaoXML->addChild('horario_contato', $requisicao['horario_contato']);
        $requisicaoXML->addChild('tipo', $requisicao['tipo']);
        $requisicaoXML->addChild('categoria', $requisicao['categoria']);
        $requisicaoXML->addChild('outros_info', $requisicao['outros_info']);
        $requisicaoXML->addChild('data_requisicao', $requisicao['data_requisicao']);
    }

    // Definir cabeçalhos para forçar o download do XML
    header('Content-Disposition: attachment; filename="requisicoes.xml"');
    header('Content-Type: text/xml');

    // Imprimir o XML
    echo $xml->asXML();
    exit; // Parar a execução do script após gerar o XML
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <title>Consultar Requisições</title>
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

        h2 {
            color: #333;
            margin-top: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="date"],
        input[type="submit"],
        button {
            margin-top: 10px;
        }

        button {
            background-color: #0078d4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #005a9e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tbody tr:nth-child(odd) {
            background-color: #495057;
        }

        tbody tr:hover {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
<h1>Consultar Requisições</h1>

<!-- Formulário de filtro por data -->
<form method="post">
    <label for="data_inicio">Data de Início:</label>
    <input type="date" name="data_inicio" id="data_inicio">
    <label for="data_fim">Data Fim:</label>
    <input type="date" name="data_fim" id="data_fim">
    <button type="submit" name="filtrar" class="ms-Button ms-Button--primary">Filtrar</button>
</form>

<!-- Botão para exportar em XML -->
<?php if(!empty($requisicoes)): ?>
    <form method="post">
        <button type="submit" name="exportar" class="ms-Button ms-Button--primary">Exportar em XML</button>
    </form>
<?php endif; ?>

<!-- Verificar se existem requisições a serem exibidas -->
<?php if($requisicoes): ?>
    <!-- Tabela para exibir as requisições -->
    <table class="ms-Table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Horário de Contato</th>
            <th>Tipo</th>
            <th>Categoria</th>
            <th>Outras Informações</th>
            <th>Data da Requisição</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($requisicoes as $requisicao): ?>
            <tr>
                <td><?php echo $requisicao['id_requisicao']; ?></td>
                <td><?php echo $requisicao['nome']; ?></td>
                <td><?php echo isset($requisicao['data_nascimento']) ? $requisicao['data_nascimento'] : ''; ?></td>
                <td><?php echo $requisicao['email']; ?></td>
                <td><?php echo $requisicao['telefone']; ?></td>
                <td><?php echo $requisicao['horario_contato']; ?></td>
                <td><?php echo $requisicao['tipo']; ?></td>
                <td><?php echo $requisicao['categoria']; ?></td>
                <td><?php echo $requisicao['outros_info']; ?></td>
                <td><?php echo $requisicao['data_requisicao']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center;">Não há requisições para exibir.</p>
<?php endif; ?>

<button type="submit" class="ms-Button ms-Button--primary" onclick="window.location.href='admin.php'">Voltar</button>

</body>
</html>
