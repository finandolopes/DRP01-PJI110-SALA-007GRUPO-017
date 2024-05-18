<?php
include_once('../php/conexao.php');

// Consulta SQL para buscar os clientes
$sql = "SELECT r.id_cliente, c.nome AS nome_cliente, c.email, c.telefone FROM clientes r INNER JOIN clientes c ON r.id_cliente = c.id_cliente";
$result = $conn->query($sql);

// Verifica se há resultados da consulta
if ($result->num_rows > 0) {
    // Loop através de cada linha de resultado
    while($row = $result->fetch_assoc()) {
        echo "
<tr>
    <td>" . $row["id_cliente"] . "</td>
    <td>" . $row["nome_cliente"] . "</td>
    <td>" . $row["email"] . "</td>
    <td>" . $row["telefone"] . "</td>
</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nenhum cliente encontrado</td></tr>";
}

// Fecha a conexão com o banco de dados
$conexao->close();
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
                        <h4 class="page-title">Lista de Clientes</h4>
                    </div>
                </div>
                <!-- Opções de exportação e impressão -->
                <div class="export-options">
                    <form method="post" action="">
                        <button type="submit" name="exportar" class="btn btn-primary">Exportar XML</button>    <i class="fa fa-print" style="font-size: 24px;" onclick="window.print()" aria-hidden="true"></i> Imprimir
                    </form>
                </div>
                <div class="page-wrapper">
                    <div class="content container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="page-title">Lista de Clientes</h4>
                            </div>
                        </div>

                        <!-- Tabela de clientes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table datanew">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nome do Cliente</th>
                                                        <th>E-mail</th>
                                                        <th>Telefone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php  
                                                    // Consulta SQL para buscar os clientes
                                                    $sql = "SELECT r.id_cliente, c.nome AS nome_cliente, c.email, c.telefone FROM clientes r INNER JOIN clientes c ON r.id_cliente = c.id_cliente";
                                                    $result = $conexao->query($sql);

                                                    // Verifica se há resultados da consulta
                                                    if ($result->num_rows > 0) {
                                                    // Loop através de cada linha de resultado
                                                    while($row = $result->fetch_assoc()) {
                                                    echo "
                                                    <tr>
                                                        <td>" . $row["id_cliente"] . "</td>
                                                        <td>" . $row["nome_cliente"] . "</td>
                                                        <td>" . $row["email"] . "</td>
                                                        <td>" . $row["telefone"] . "</td>
                                                    </tr>";
                                                    }
                                                    } else {
                                                    echo "
                                                    <tr><td colspan='4'>Nenhum cliente encontrado</td></tr>";
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
