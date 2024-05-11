<?php
session_start();
include_once('../php/conexao.php'); // Ajuste no caminho do include_once

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "confinter");

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta SQL para selecionar os depoimentos pendentes de moderação
$sql = "SELECT * FROM depoimentos WHERE aprovado = 0 AND reprovado = 0";
$result = $conn->query($sql);

// Verifica se há depoimentos pendentes
if ($result->num_rows > 0) {
    // Exibe os depoimentos em uma tabela
    while ($row = $result->fetch_assoc()) {
        ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['nome_cliente']; ?></td>
    <td><?php echo $row['mensagem']; ?></td>
    <td><?php echo $row['status_mod']; ?></td>
    <td>
        <form action="" method="post">
            <input type="hidden" name="id_depoimento" value="<?php echo $row['id']; ?>">
            <button type="submit" name="moderar_depoimento" value="aprovado" class="btn btn-success btn-sm">Aprovar</button>
            <button type="submit" name="moderar_depoimento" value="reprovado" class="btn btn-danger btn-sm">Reprovar</button>
        </form>
    </td>
</tr>
        <?php
    }
} else {
    // Se não houver depoimentos pendentes, exibe uma mensagem
    echo "<tr><td colspan='5'>Nenhum depoimento pendente de moderação.</td></tr>";
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
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php if(isset($_SESSION['sucesso_atualizacao']) && $_SESSION['sucesso_atualizacao'] == true): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sucesso!</strong> O depoimento foi moderado com sucesso.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['sucesso_atualizacao']); ?>
                            <?php endif; ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Depoimentos Pendentes de Moderação</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>E-mail</th>
                                                    <th>Mensagem</th>
                                                    <th>Data</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while($row = $result->fetch_assoc()):
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['nome']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['mensagem']; ?></td>
                                                    <td><?php echo $row['data']; ?></td>
                                                    <td>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id_depoimento" value="<?php echo $row['id']; ?>">
                                                            <button type="submit" name="moderar_depoimento" value="aprovado" class="btn btn-success btn-sm">Aprovar</button>
                                                            <button type="submit" name="moderar_depoimento" value="reprovado" class="btn btn-danger btn-sm">Reprovar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
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
