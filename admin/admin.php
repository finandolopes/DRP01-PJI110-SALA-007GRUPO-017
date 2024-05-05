<?php
session_start();
include_once('../php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Função para obter dados do banco de dados com consulta preparada
function fetch_data($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Função para contar registros do banco de dados
function count_records($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0 ? $result->fetch_assoc()['count'] : 0;
}

// Recupera o nome de usuário da sessão
$username = $_SESSION['username'];

// Consulta o banco de dados para obter o nome do usuário específico
$sql_nome_usuario = "SELECT nome FROM usuarios WHERE usuario = ?";
$nome_usuario = fetch_data($conexao, $sql_nome_usuario, ['s', $username]);
$nome_usuario = $nome_usuario ? $nome_usuario['nome'] : "Nome de Usuário";

// Consulta o banco de dados para obter a média de tempo que o visitante fica no site
$sql_media_tempo = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(tempo))) AS media_tempo FROM contador_visitas";
$media_tempo = fetch_data($conexao, $sql_media_tempo);

// Consulta o total de visitas
$total_visitas = count_records($conexao, "SELECT COUNT(*) AS count FROM contador_visitas");

// Consulta o total de dias
$total_dias = count_records($conexao, "SELECT COUNT(DISTINCT DATE(data_visita)) AS count FROM contador_visitas");

// Calcula a porcentagem de visitas
$porcentagem = $total_dias > 0 ? ($total_visitas / $total_dias) * 100 : 0;

// Consulta o número total de requisições realizadas
$total_requisicoes_realizadas = count_records($conexao, "SELECT COUNT(*) AS count FROM requisicoes");

// Consulta o número total de clientes
$total_clientes = count_records($conexao, "SELECT COUNT(*) AS count FROM clientes");

// Calcula a porcentagem de requisições realizadas
$porcentagem_requisicoes = $total_clientes > 0 ? ($total_requisicoes_realizadas / $total_clientes) * 100 : 0;

// Formata a porcentagem de requisições
$porcentagem_formatada = number_format($porcentagem_requisicoes, 1);

// Consulta o banco de dados para obter as informações do usuário
$sql_usuario = "SELECT * FROM usuarios WHERE usuario = ?";
$usuario = fetch_data($conexao, $sql_usuario, ['s', $username]);

// Consulta o número total de depoimentos aprovados
$total_depoimentos = count_records($conexao, "SELECT COUNT(*) AS count FROM depoimentos");

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

                <div class="user">
                    <img src="assets/imgs/perfil/1.png" alt="">
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-md rounded-circle" src="../assets/img/perfil/1.png" alt="Profile image">
                            <p class="mb-1 mt-3 font-weight-semibold"><?php echo htmlspecialchars($usuario['nome']); ?></p>
                            <p class="fw-light text-muted mb-0"><?php echo htmlspecialchars($usuario['email']); ?></p>
                        </div>
                        <a class="dropdown-item" href="perfil.php?nome=<?php echo htmlspecialchars($usuario['nome'] ?? ''); ?>&email=<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Meu perfil</a>
                        <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sair</a>
                    </div>
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <p class="statistics-title">Visualização do Site</p>
                        <h3 class="rate-percentage"><?php echo htmlspecialchars($total_visitas); ?></h3>
                        <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+<?php echo htmlspecialchars(number_format($porcentagem, 1)); ?>%</span></p>
                        <div class="cardName">Visualizações Diárias</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h3 class="rate-percentage"><?php echo isset($porcentagem_requisicoes_realizadas) ? round($porcentagem_requisicoes_realizadas, 1) : '0.0'; ?>%</h3>
                        <h3 class="rate-percentage"><?php echo isset($total_requisicoes_realizadas) ? $total_requisicoes_realizadas : '0'; ?></h3>
                        <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span><?php echo isset($porcentagem_formatada) ? $porcentagem_formatada : '0.0'; ?>%</span></p>
                        <div class="cardName">Requisições de Análise de Crédito</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"></div>
                        <div class="cardName">Depoimentos</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="font-weight-semibold"><?php echo isset($media_tempo) ? htmlspecialchars($media_tempo) : ''; ?></div>
                        <div class="cardName">Tempo Médio no Site</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="timer"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Listar Requisições Recentes ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Requisições Recentes</h2>
                        <a href="#" class="btn">Visualizar Todas</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Nome</td>
                                <td>E-mail</td>
                                <td>Telefone</td>
                                <td>Status</td>
                                <td>Horário para Contato</td>
                                <td>Categoria</td>
                                <td>Outros</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Consulta as últimas 5 requisições com informações dos clientes
                            $sql = "SELECT r.*, c.nome AS nome_cliente, c.email AS email_cliente, c.telefone AS telefone_cliente FROM requisicoes r JOIN clientes c ON r.id_cliente = c.id_cliente ORDER BY r.data_requisicao DESC LIMIT 5";
                            $result = $conexao->query($sql);

                            // Exibe os resultados na tabela HTML
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row["nome_cliente"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["email_cliente"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["telefone_cliente"]) . "</td>";
                                    echo "<td><span class=\"status\">" . htmlspecialchars($row["status"]) . "</span></td>";
                                    echo "<td>" . htmlspecialchars($row["horario_contato"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["outros_info"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>Nenhuma requisição encontrada.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Contatos Recentes</h2>
                </div>

                <table>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>João da Silva <br> <span>São Paulo</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Mario Andrade <br> <span>São Paulo</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Felipe Costa <br> <span>São Paulo</span></h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- =================== Scripts =================== -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/feather/feather.js"></script>
    <script src="js/template.js"></script>
</body>

</html>
