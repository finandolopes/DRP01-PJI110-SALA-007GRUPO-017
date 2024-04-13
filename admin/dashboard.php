<?php
// Incluir a conexão com o banco de dados
include_once('../php/conexao.php');

// Consulta SQL para obter o número de requisições mensais
$sqlRequisicoes = "SELECT MONTH(data_requisicao) AS mes, COUNT(*) AS total_requisicoes FROM requisicoes GROUP BY MONTH(data_requisicao)";
$resultRequisicoes = mysqli_query($conexao, $sqlRequisicoes);

// Consulta SQL para obter o número de novos clientes mensais
$sqlClientes = "SELECT MONTH(data_nascimento) AS mes, COUNT(*) AS total_clientes FROM clientes GROUP BY MONTH(data_nascimento)";
$resultClientes = mysqli_query($conexao, $sqlClientes);

// Inicialização dos arrays de dados
$requisicoesMensais = array_fill(0, 12, 0); // Inicializa com 0 para todos os meses
$clientesMensais = array_fill(0, 12, 0); // Inicializa com 0 para todos os meses

// Preenchimento dos arrays com os dados do banco de dados
while ($row = mysqli_fetch_assoc($resultRequisicoes)) {
    $mes = intval($row['mes']) - 1; // Meses são 1-indexed em SQL
    $requisicoesMensais[$mes] = intval($row['total_requisicoes']);
}

while ($row = mysqli_fetch_assoc($resultClientes)) {
    $mes = intval($row['mes']) - 1; // Meses são 1-indexed em SQL
    $clientesMensais[$mes] = intval($row['total_clientes']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Inclua a biblioteca Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Dashboard</h1>
    <div style="width: 50%;">
        <canvas id="requisicoesChart"></canvas>
    </div>
    <div style="width: 50%;">
        <canvas id="clientesChart"></canvas>
    </div>

    <script>
        // Dados para o gráfico de requisições mensais
        var requisicoesMensaisData = {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                label: 'Requisições Mensais',
                data: <?php echo json_encode($requisicoesMensais); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Dados para o gráfico de clientes mensais
        var clientesMensaisData = {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                label: 'Novos Clientes Mensais',
                data: <?php echo json_encode($clientesMensais); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configurações dos gráficos
        var chartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Crie os gráficos
        var requisicoesChart = new Chart(document.getElementById('requisicoesChart'), {
            type: 'bar',
            data: requisicoesMensaisData,
            options: chartOptions
        });

        var clientesChart = new Chart(document.getElementById('clientesChart'), {
            type: 'bar',
            data: clientesMensaisData,
            options: chartOptions
        });
    </script>
</body>
</html>
