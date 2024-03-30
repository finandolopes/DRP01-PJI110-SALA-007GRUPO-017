<?php
// Incluir o arquivo de conexão e as funções de manipulação de requisições
include_once('config/conexao.php');
include_once('php/funcoes_requisicoes.php');
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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Consultar Requisições</title>
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

        button {
            background-color: #007bff; /* Cor de fundo do botão */
            color: #fff; /* Cor do texto do botão */
            padding: 10px 20px; /* Espaçamento interno */
            border: none; /* Remover borda */
            cursor: pointer; /* Alterar cursor ao passar o mouse */
            border-radius: 5px; /* Arredondar bordas */
        }

        button:hover {
            background-color: #0056b3; /* Cor de fundo ao passar o mouse */
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
    <button type="submit" name="filtrar">Filtrar</button>
</form>

<!-- Botão para exportar em XML -->
<?php if(!empty($requisicoes)): ?>
    <form method="post">
        <button type="submit" name="exportar">Exportar em XML</button>
    </form>
<?php endif; ?>

<!-- Verificar se existem requisições a serem exibidas -->
<?php if($requisicoes): ?>
    <!-- Tabela para exibir as requisições -->
    <table border="1">
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
    <p>Não há requisições para exibir.</p>
<?php endif; ?>

<button type="button" class="btn btn-sm btn-success" onclick="window.location.href='admin.php'">Voltar</button>

</body>
</html>
