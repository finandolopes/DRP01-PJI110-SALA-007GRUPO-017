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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFINTER - Painel Administrativo</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/favicon.png" />
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
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
    <!-- =============== Navegação ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <a class="navbar-brand brand-logo-mini" href="admin.php">
                            <img src="assets/imgs/logo2.png" alt="" />
                            </span>
                            <span class="title"></span>
                        </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="../admin/listar_clientes.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Listar Clientes</span>
                    </a>
                </li>

                <li>
                    <a href="../admin/consultar_requisicoes.php">
                        <span class="icon">
                            <ion-icon name="trending-up"></ion-icon>
                        </span>
                        <span class="title">Requisições Realizadas</span>
                    </a>
                </li>

                <li>
                    <a href="../admin/admin_depoimentos.html">
                        <span class="icon">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                        </span>
                        <span class="title">Moderar Depoimentos</span>
                    </a>
                </li>

                <li>
                    <a href="https://login.consigsystem.com.br/">
                        <span class="icon">
                            <ion-icon name="desktop"></ion-icon>
                        </span>
                        <span class="title">Acesso ao ERP</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/gerenciar_usuarios.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Gerenciar Usuários</span>
                    </a>
                </li>

                <li>
                    <a href="../admin/upload_imagens.php">
                        <span class="icon">
                            <ion-icon name="images"></ion-icon>
                        </span>
                        <span class="title">Alterar Slides</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Principal ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Procure aqui">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="container-scroller">
                    <div class="content-wrapper">
                        <div class="user">
                            <img src="assets/imgs/perfil/1.png" alt="">
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown" style="display: none;">
                                <div class="dropdown-header text-center">
                                    <img class="img-md rounded-circle" src="../assets/img/perfil/1.png" alt="Profile image">
                                    <p class="mb-1 mt-3 font-weight-semibold"><?php echo $usuario['nome']; ?></p>
                                    <p class="fw-light text-muted mb-0"><?php echo $usuario['email']; ?></p>
                                </div>
                                <a class="dropdown-item" href="perfil.php?nome=<?php echo $usuario['nome'] ?? ''; ?>&email=<?php echo $usuario['email'] ?? ''; ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Meu perfil</a>
                                <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sair</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

            <!-- ================ Depoimentos Pendentes ================= -->
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <div class="page-title">
                <h4>Moderar Depoimentos Pendentes</h4>
                <h6>Gerenciar Depoimentos</h6>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
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
                                    <button type="submit" class="btn btn-moderate">Moderar</button>
                                    <button type="submit" class="btn btn-delete">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <button onclick="window.location.href='admin.php'" class="btn btn-back">Voltar</button>
            </div>
        </div>
    </div>
</div>


                

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Scripts -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/todolist.js"></script>
    <!-- Adicionando script para inicializar o Datepicker -->
    <script>
        $(document).ready(function () {
            $('.user').on('click', function () {
                $(this).find('.dropdown-menu').toggle();
            });
        });
    </script>
</body>
</html>


    <?php
    // Fim da geração de HTML utilizando os resultados da consulta
} else {
    // Caso a consulta tenha falhado
    echo "Erro na consulta SQL: " . $conexao->error;
}
?>
