<?php
session_start();
include_once('../php/conexao.php');
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
    <div class="content">
        <div class="row">
            <!-- Bloco de estatísticas: Total de Visitas no Site -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h3 class="rate-percentage"><?php echo isset($totalVisitas) ? htmlspecialchars($totalVisitas) : '0'; ?></h3>
                        <h5>Total de Visitas no Site</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <!-- Fim do bloco de estatísticas: Total de Visitas no Site -->

            <!-- Bloco de estatísticas: Total de Depoimentos no Site -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h3 class="rate-percentage"><?php echo isset($totalDepoimentos) ? htmlspecialchars($totalDepoimentos) : '0'; ?></h3>
                        <h5>Total de Depoimentos no Site</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user-check"></i>
                    </div>
                </div>
            </div>
            <!-- Fim do bloco de estatísticas: Total de Depoimentos no Site -->

            <!-- Bloco de estatísticas: Total de Requisições pelo Site -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h3 class="rate-percentage"><?php echo isset($porcentagem_requisicoes_realizadas) ? round($porcentagem_requisicoes_realizadas, 1) : '0.0'; ?>%</h3>
                        <h3 class="rate-percentage"><?php echo isset($total_requisicoes_realizadas) ? $total_requisicoes_realizadas : '0'; ?></h3>
                        <h5>Total de Requisições pelo Site</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                </div>
            </div>
            <!-- Fim do bloco de estatísticas: Total de Requisições pelo Site -->

            <!-- Bloco de estatísticas: Total de tempo no Site -->
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <div class="font-weight-semibold"><?php echo isset($media_tempo) ? htmlspecialchars($media_tempo) : ''; ?></div>
                        <h5>Total de tempo no Site</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="clock"></i>
                    </div>
                </div>
            </div>
            <!-- Fim do bloco de estatísticas: Total de tempo no Site -->
        </div>
        
        <!-- Tabela de dados recentes: Requisições Recentes -->
        <div class="card mb-0">
            <div class="card-body">
                <h4 class="card-title">Requisições Recentes</h4>
                <div class="table-responsive dataview">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Categoria</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta SQL para obter as últimas 5 requisições
                            $sql = "SELECT c.nome, c.email, c.telefone, r.categoria, r.data_requisicao
                                    FROM clientes c
                                    INNER JOIN requisicoes r ON c.id_cliente = r.id_cliente
                                    ORDER BY r.data_requisicao DESC
                                    LIMIT 5";
                            // Executa a consulta
                            $resultado = mysqli_query($conexao, $sql);
                            // Verifica se existem resultados
                            if ($resultado && mysqli_num_rows($resultado) > 0) {
                                // Itera sobre os resultados e exibe os dados
                                while ($row = mysqli_fetch_assoc($resultado)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["telefone"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["data_requisicao"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Nenhuma requisição encontrada.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fim da Tabela de dados recentes: Requisições Recentes -->
    </div>
</div>

    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
