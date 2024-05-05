<?php
session_start();
include_once('../php/conexao.php');

// Verifica se a sessão está iniciada e se a chave 'username' está definida
if (!isset($_SESSION['username'])) {
    // Se a sessão não estiver iniciada ou a chave 'username' não estiver definida, redirecione para a página de login
    header('Location: login.php');
    exit();
}

// Recupera o nome de usuário da sessão
$username = $_SESSION['username'];

// Consulta o banco de dados para obter o nome do usuário específico
$sql_nome_usuario = "SELECT nome FROM usuarios WHERE usuario = '$username'";
$result_nome_usuario = $conexao->query($sql_nome_usuario);

if ($result_nome_usuario->num_rows > 0) {
    $row_nome_usuario = $result_nome_usuario->fetch_assoc();
    $nome_usuario = $row_nome_usuario['nome'];
} else {
    // Se não encontrar o nome do usuário no banco de dados, use o nome de usuário padrão
    $nome_usuario = "Nome de Usuário";
}

/// Função para obter a saudação com base no horário do dia
function getGreeting() {
    $hour = date("H");
    if ($hour >= 5 && $hour < 12) {
        return "Bom dia";
    } else if ($hour >= 12 && $hour < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}

// Exibe a saudação e o nome do usuário
function displayGreetingAndUserName($nome_usuario) {
    echo "<h1 class='welcome-text'>" . getGreeting() . ", <span class='text-black fw-bold'>$nome_usuario</span></h1>";
    echo "<h3 class='welcome-sub-text'>Resumo de desempenho do Site</h3>";
}

// Consulta o banco de dados para obter a média de tempo que o visitante fica no site
$sql_media_tempo = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(tempo))) AS media_tempo FROM contador_visitas";
$result_media_tempo = $conexao->query($sql_media_tempo);

if ($result_media_tempo->num_rows > 0) {
    $row_media_tempo = $result_media_tempo->fetch_assoc();
    $media_tempo = $row_media_tempo["media_tempo"];
} else {
    $media_tempo = "0:00"; // Define um valor padrão caso não haja registros no banco de dados
}

// Consulta o total de visitas
$sql_visitas = "SELECT COUNT(*) AS total_visitas FROM contador_visitas";
$result_visitas = $conexao->query($sql_visitas);

if ($result_visitas->num_rows > 0) {
    $row_visitas = $result_visitas->fetch_assoc();
    $total_visitas = $row_visitas["total_visitas"];
} else {
    $total_visitas = 0;
}

// Consulta o total de dias
$sql_total_dias = "SELECT COUNT(DISTINCT DATE(data_visita)) AS total_dias FROM contador_visitas";
$result_total_dias = $conexao->query($sql_total_dias);

if ($result_total_dias->num_rows > 0) {
    $row_total_dias = $result_total_dias->fetch_assoc();
    $total_dias = $row_total_dias["total_dias"];
} else {
    $total_dias = 0;
}

// Calcula a porcentagem de visitas
if ($total_dias > 0) {
    $media_visitas_por_dia = $total_visitas / $total_dias;
    $porcentagem = ($media_visitas_por_dia / $total_visitas) * 100;
} else {
    // Se $total_dias for zero, defina $porcentagem como zero para evitar a divisão por zero
    $porcentagem = 0;
}

// Consulta o banco de dados para obter o número total de requisições realizadas
$sql_total_requisicoes_realizadas = "SELECT COUNT(*) AS total_requisicoes_realizadas FROM requisicoes";
$result_total_requisicoes_realizadas = $conexao->query($sql_total_requisicoes_realizadas);

if ($result_total_requisicoes_realizadas->num_rows > 0) {
    $row_total_requisicoes_realizadas = $result_total_requisicoes_realizadas->fetch_assoc();
    $total_requisicoes_realizadas = $row_total_requisicoes_realizadas["total_requisicoes_realizadas"];
} else {
    $total_requisicoes_realizadas = 0; // Define um valor padrão caso não haja registros no banco de dados
}

// Consulta o banco de dados para obter o número total de clientes
$sql_total_clientes = "SELECT COUNT(*) AS total_clientes FROM clientes";
$result_total_clientes = $conexao->query($sql_total_clientes);

if ($result_total_clientes->num_rows > 0) {
    $row_total_clientes = $result_total_clientes->fetch_assoc();
    $total_clientes = $row_total_clientes["total_clientes"];
} else {
    $total_clientes = 0; // Define um valor padrão caso não haja registros no banco de dados
}

// Calcula a porcentagem de requisições realizadas
if ($total_requisicoes_realizadas > 0) {
    $porcentagem_requisicoes = ($total_requisicoes_realizadas / $total_clientes) * 100;
} else {
    // Se não houver requisições realizadas, a porcentagem de requisições será zero
    $porcentagem_requisicoes = 0;
}

// Formata a porcentagem de requisições
$porcentagem_formatada = number_format($porcentagem_requisicoes, 1);

// Consulta o banco de dados para obter as informações do usuário
$sql_usuario = "SELECT * FROM usuarios WHERE usuario = '$username'";
$result_usuario = $conexao->query($sql_usuario);

if ($result_usuario->num_rows > 0) {
    $usuario = $result_usuario->fetch_assoc();
} else {
    // Se não encontrar o usuário no banco de dados, defina uma array vazia para evitar erros
    $usuario = array();
}

// Exibe a saudação e o nome do usuário
displayGreetingAndUserName($nome_usuario);
// Verifica se os parâmetros foram passados na URL
if(isset($_GET['nome']) && isset($_GET['email'])) {
    // Atribui os valores passados na URL à variável $usuario
    $usuario['nome'] = $_GET['nome'];
    $usuario['email'] = $_GET['email'];
} else {
    // Se os parâmetros não foram passados na URL, define a variável $usuario como vazia
    $usuario = array();
}
// Verifica se os parâmetros foram passados na URL
if(isset($_GET['nome']) && isset($_GET['email'])) {
    // Atribui os valores passados na URL à variável $usuario
    $usuario['nome'] = $_GET['nome'];
    $usuario['email'] = $_GET['email'];
} else {
    // Se os parâmetros não foram passados na URL, define a variável $usuario como vazia
    $usuario = array();
}

// Fecha a conexão com o banco de dados após todas as consultas necessárias
$conexao->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CONFINTER - Painel Administrativo </title>
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/typicons/typicons.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="js/select.dataTables.min.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="../assets/img/favicon.png" />
</head>
<body>
    <div class="container-scroller">
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="../assets/img/logo01-black.png" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="index.html">
                        <img src="../assets/img/logo01-black.png" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                       <h1 class="welcome-text"><?php $saudacao = getGreeting();displayGreetingAndUserName($nome_usuario);?></h1>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                            <a class="dropdown-item py-3">
                                <p class="mb-0 font-weight-medium float-left">Selecione uma Categoria</p>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Bootstrap Bundle </p>
                                    <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Angular Bundle</p>
                                    <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">VUE Bundle</p>
                                    <p class="fw-light small-text mb-0">Bundle of 6 Premium Vue Admin Dashboard</p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">React Bundle</p>
                                    <p class="fw-light small-text mb-0">Bundle of 8 Premium React Admin Dashboard</p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </li>
                    <li class="nav-item">
                        <form class="search-form" action="#">
                            <i class="icon-search"></i>
                            <input type="search" class="form-control" placeholder="Procure aqui" title="Procure aqui">
                        </form>
                    </li>
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle" src="../assets/img/perfil/1.png" alt="Profile image">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="../assets/img/perfil/1.png" alt="Profile image">
                                <p class="mb-1 mt-3 font-weight-semibold"><?php echo $usuario['nome']; ?></p>
                                <p class="fw-light text-muted mb-0"><?php echo $usuario['email']; ?></p>
                            </div>
                            <a class="dropdown-item" href="perfil.php?nome=<?php echo $usuario['nome']; ?>&email=<?php echo $usuario['email']; ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Meu perfil</a>

                            <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sair</a>

                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">Cor Sidebar</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border me-3"></div>Claro</div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border me-3"></div>Escuro</div>
                    <p class="settings-heading mt-2">Cor Cabeçalho</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Team review meeting at 3.00 PM
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Prepare for presentation
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Schedule meeting for next week
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                                <li class="completed">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" checked>
                                            Project review
                                        </label>
                                    </div>
                                    <i class="remove ti-close"></i>
                                </li>
                            </ul>
                        </div>
                        <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary me-2"></i>
                                <span>Feb 11 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                            <p class="text-gray mb-0">The total number of sessions</p>
                        </div>
                        <div class="events pt-4 px-3">
                            <div class="wrapper d-flex mb-2">
                                <i class="ti-control-record text-primary me-2"></i>
                                <span>Feb 7 2018</span>
                            </div>
                            <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                            <p class="text-gray mb-0 ">Call Sarah Graves</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                            <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
                        </div>
                        <ul class="chat-list">
                            <li class="list active">
                                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Thomas Douglas</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">19 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <div class="wrapper d-flex">
                                        <p>Catherine</p>
                                    </div>
                                    <p>Away</p>
                                </div>
                                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                                <small class="text-muted my-auto">23 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Daniel Russell</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">14 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                                <div class="info">
                                    <p>James Richardson</p>
                                    <p>Away</p>
                                </div>
                                <small class="text-muted my-auto">2 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Madeline Kennedy</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">5 min</small>
                            </li>
                            <li class="list">
                                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                                <div class="info">
                                    <p>Sarah Graves</p>
                                    <p>Available</p>
                                </div>
                                <small class="text-muted my-auto">47 min</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">Clientes</li>
          <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                  <i class="menu-icon mdi mdi-chart-line"></i>
                  <span class="menu-title">Contatos pelo Site</span>
                  <i class="menu-arrow"></i>
              </a>              
              <div class="collapse" id="ui-basic">
                  <ul class="nav flex-column sub-menu">
                      <li class="nav-item"> <a class="nav-link" href="../admin/listar_clientes.php">Listar Clientes</a></li>
                      <li class="nav-item"> <a class="nav-link" href="../admin/consultar_requisicoes.php">Requisições Realizadas</a></li>
                      <li class="nav-item"> <a class="nav-link" href="../admin/admin_depoimentos.php">Moderar Depoimentos</a></li>

                  </ul>
              </div>
          </li>
          <li class="nav-item nav-category">Acesso ao ERP</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="menu-icon mdi mdi-application"></i>
              <span class="menu-title">ERP</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="https://login.consigsystem.com.br/">Acesso Externo</a></li>
              </ul>
            </div>
          </li>          
          <li class="nav-item nav-category">Configuração</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="menu-icon mdi mdi-account-circle-outline"></i>
                            <span class="menu-title">Gerenciar itens</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="gerenciar_usuarios.php"> Gerenciar Usuários </a></li>
                                <li class="nav-item"> <a class="nav-link" href="upload_imagens.php"> Alterar slides </a></li>
                            </ul>
                        </div>
                    </li>                    
            </nav>

    <div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editar Perfil</h4>
                        <form action="editar_perfil.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Nova Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha">
                            </div>
                            <div class="mb-3">
                                <label for="img_perfil" class="form-label">Imagem de Perfil:</label>
                                <input type="file" class="form-control" id="img_perfil" name="img_perfil">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <footer class="footer">
                                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Confinter- Copyright © 2024.</a> Todos os direitos reservados.</span>
                                            </div>
                                        </footer>
                                    </div>
                                </div>
                            </div>
                            <script src="vendors/js/vendor.bundle.base.js"></script>
                            <script src="vendors/chart.js/Chart.min.js"></script>
                            <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
                            <script src="vendors/progressbar.js/progressbar.min.js"></script>
                            <script src="js/off-canvas.js"></script>
                            <script src="js/hoverable-collapse.js"></script>
                            <script src="js/template.js"></script>
                            <script src="js/settings.js"></script>
                            <script src="js/todolist.js"></script>
                            <script src="js/dashboard.js"></script>
                            <script src="js/Chart.roundedBarCharts.js"></script>
</body>
</html>
