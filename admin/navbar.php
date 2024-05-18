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
        