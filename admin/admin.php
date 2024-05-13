<?php
session_start();
include_once('../php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Função para executar uma consulta preparada e retornar o resultado
function executarConsulta($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    if (!$stmt->execute()) {
        // Tratamento de erro, se a consulta não for bem-sucedida
        return false;
    }
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Função para contar registros retornados por uma consulta
function contarRegistros($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    if (!$stmt->execute()) {
        // Tratamento de erro, se a consulta não for bem-sucedida
        return 0;
    }
    $result = $stmt->get_result();
    return $result->num_rows;
}

// Recupera o nome de usuário da sessão
$username = $_SESSION['username'];

// Consulta o banco de dados para obter informações do usuário
$sqlUsuario = "SELECT * FROM usuarios WHERE usuario = ?";
$usuario = executarConsulta($conexao, $sqlUsuario, ['s', $username]);

// Verifica se o usuário foi encontrado
if ($usuario) {
    // Use as informações do usuário
    $nome = htmlspecialchars($usuario['nome']);
    $email = htmlspecialchars($usuario['email']);
    // e assim por diante...
} else {
    // Trate o caso em que o usuário não foi encontrado
    $nome = "Usuário Desconhecido";
    $email = "email@example.com";
    // ou qualquer valor padrão que você preferir
}
// Consulta o perfil do usuário
$sqlPerfilUsuario = "SELECT perfil FROM usuarios WHERE usuario = ?";
$perfilUsuario = executarConsulta($conexao, $sqlPerfilUsuario, ['s', $username]);
$perfil_usuario = $perfilUsuario ? $perfilUsuario['perfil'] : "Perfil do Usuário";// Consulta o banco de dados para obter a média de tempo que o visitante fica no site
$sqlMediaTempo = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(tempo))) AS media_tempo FROM contador_visitas";
$mediaTempo = executarConsulta($conexao, $sqlMediaTempo);

// Consulta o total de visitas
$sqlTotalVisitas = "SELECT COUNT(*) AS count FROM contador_visitas";
$totalVisitas = contarRegistros($conexao, $sqlTotalVisitas);

// Consulta o total de dias
$sqlTotalDias = "SELECT COUNT(DISTINCT DATE(data_visita)) AS count FROM contador_visitas";
$totalDias = contarRegistros($conexao, $sqlTotalDias);

// Calcula a porcentagem de visitas
$porcentagem = $totalDias > 0 ? ($totalVisitas / $totalDias) * 100 : 0;

// Consulta o número total de requisições realizadas
$sqlTotalRequisicoesRealizadas = "SELECT COUNT(*) AS count FROM requisicoes";
$totalRequisicoesRealizadas = contarRegistros($conexao, $sqlTotalRequisicoesRealizadas);

// Consulta o número total de clientes
$sqlTotalClientes = "SELECT COUNT(*) AS count FROM clientes";
$totalClientes = contarRegistros($conexao, $sqlTotalClientes);

// Calcula a porcentagem de requisições realizadas
$porcentagemRequisicoes = $totalClientes > 0 ? ($totalRequisicoesRealizadas / $totalClientes) * 100 : 0;

// Formata a porcentagem de requisições
$porcentagemFormatada = number_format($porcentagemRequisicoes, 1);

// Consulta o número total de depoimentos aprovados
$sqlTotalDepoimentos = "SELECT COUNT(*) AS count FROM depoimentos";
$totalDepoimentos = contarRegistros($conexao, $sqlTotalDepoimentos);

// Obter o total de depoimentos
$sqlTotalDepoimentos = "SELECT COUNT(*) AS total_depoimentos FROM depoimentos";
$totalDepoimentos = executarConsulta($conexao, $sqlTotalDepoimentos);
$totalDepoimentos = $totalDepoimentos ? $totalDepoimentos['total_depoimentos'] : 0;
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
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="">
                </a>
                </a>
            </div>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <ul class="nav user-menu">
                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Procure Aqui ...">
                                <div class="search-addon">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv"><img src="assets/img/icons/search.svg" alt="img"></a>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="assets/img/perfil/1.png" alt="">
                            <span class="status online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                <img class="img-md rounded-circle" ssrc="assets/img/perfil/1.png" alt="Profile image">
                                    <p class="mb-1 mt-3 font-weight-semibold"><?php echo htmlspecialchars($usuario['nome']); ?></p>
                                    <p class="fw-light text-muted mb-0"><?php echo htmlspecialchars($usuario['email']); ?></p>
                                    <span class="status online"></span>
                                </span>
                                <div class="profilesets">
                                    <a class="dropdown-item" href="perfil.php?nome=<?php echo htmlspecialchars($usuario['nome'] ?? ''); ?>&email=<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Meu perfil</a>
                                    <h5><?php echo $perfil_usuario; ?></h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="perfil.php"> <i class="me-2" data-feather="user"></i> Meu Perfil</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="../index.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Sair</a>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="perfil.php">Meu Perfil</a>
                    <a class="dropdown-item" href="../index.php">Sair</a>
                </div>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="admin.php"><img src="assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                                </svg><span> Requisições</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="requisicoes.php">Requisições</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
                                </svg><span> Clientes</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="listaclientes.php">Lista de Clientes</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-stack" viewBox="0 0 16 16">
                                    <path d="M4.5 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1M6 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                    <path d="M12 1a2 2 0 0 1 2 2 2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2 2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zM2 12V5a2 2 0 0 1 2-2h9a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1m1-4v5a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V8zm12-1V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2z" />
                                </svg><span> Acesso ao ERP</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="https://login.consigsystem.com.br/">ERP</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                </svg><span> Gerenciar Usuários</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="listarusuario.php">Listar Usuários</a></li>
                                <li><a href="addusuario.php">Adicionar Usuário</a></li>
                            </ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                                    <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                    <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z" />
                                </svg><span> Alterar Slides</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="upload_imagens.php">Alterar Slides</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                                </svg><span> Moderar Depoimentos</span> <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="mod_depoimentos.php">Moderar Depoimentoss</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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

        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/feather.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
        <script src="assets/plugins/apexchart/chart-data.js"></script>
        <script src="assets/js/script.js"></script>
</body>
</html>
