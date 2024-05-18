<?php
// Incluir o arquivo de conexão e as funções de manipulação de requisições
include_once('../php/conexao.php');
include_once('../php/funcoes_requisicoes.php');


// Verificar se o formulário de filtro foi submetido
if(isset($_POST['filtrar'])) {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consultar requisições filtradas por data
    require_once('../php/funcoes_requisicoes.php');
    $requisicoes = listarRequisicoesPorData($conexao, $data_inicio, $data_fim);
} else {
    // Consultar todas as requisições do banco de dados
    require_once('../php/funcoes_requisicoes.php');
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
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="CONFINTER - Painel Administrativo">
    <meta name="robots" content="noindex, nofollow">
    <title>CONFINTER - Painel Administrativo</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- include da navbar -->
    <?php include 'navbar.php'; ?>

    <!-- include da sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- conteúdo principal -->
    <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h4 class="page-title">Lista de Requisições</h4>
                    </div>
                </div>
                <!-- Formulário de filtro por data -->
                <form method="post">
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" name="data_inicio" id="data_inicio">
                    <label for="data_fim">Data Fim:</label>
                    <input type="date" name="data_fim" id="data_fim">
                    <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
                </form>

                <!-- Opções de exportação e impressão -->
                <div class="export-options">
                    <form method="post" action="">
                        <button type="submit" name="exportar" class="btn btn-primary">Exportar XML</button>    <i class="fa fa-print" style="font-size: 24px;" onclick="window.print()" aria-hidden="true"></i> Imprimir
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th>Nome do Cliente</th>
                                                <th>E-mail</th>
                                                <th>Telefone</th>
                                                <th>Tipo</th>
                                                <th>Categoria</th>
                                                <th>Horário para Contato</th>
                                                <th>Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Consulta SQL para buscar as requisições
                                            $sql = "SELECT r.id_requisicao, c.nome AS nome_cliente, c.email, c.telefone, r.tipo, r.categoria, r.horario_contato, r.data_requisicao FROM requisicoes r INNER JOIN clientes c ON r.id_cliente = c.id_cliente";
                                            $result = $conn->query($sql);

                                            // Verifica se há resultados da consulta
                                            if ($result->num_rows > 0) {
                                            // Loop através de cada linha de resultado
                                            while($row = $result->fetch_assoc()) {
                                            echo "
                                            <tr>
                                                ";
                                                echo "
                                                <td>" . $row["nome_cliente"] . "</td>";
                                                echo "
                                                <td>" . $row["email"] . "</td>";
                                                echo "
                                                <td>" . $row["telefone"] . "</td>";
                                                echo "
                                                <td>" . $row["tipo"] . "</td>";
                                                echo "
                                                <td>" . $row["categoria"] . "</td>";
                                                echo "
                                                <td>" . $row["horario_contato"] . "</td>";
                                                echo "
                                                <td>" . $row["data_requisicao"] . "</td>";
                                                echo "
                                            </tr>";
                                            }
                                            } else {
                                            echo "
                                            <tr><td colspan='6'>Nenhuma requisição encontrada</td></tr>";
                                            }

                                            // Fecha a conexão com o banco de dados
                                            $conexao->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
