<?php
session_start();
include_once('../php/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - CONFINTER</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f3f2f8;
            font-family: "Segoe UI", sans-serif;
        }

        .navbar-logo {
            max-height: 40px; /* Altura máxima do logo */
            margin-right: 10px; /* Espaçamento entre o logo e o texto */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            padding-top: 60px; /* Ajuste de espaçamento superior */
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            background-color: #fafafa;
            color: #201f1f;
            transition: width 0.3s;
            overflow-y: auto;
            width: 240px;
        }

        .sidebar-collapsed {
            width: 60px;
        }

        .nav-link {
            color: #201f1f !important;
            padding: 12px 10px; /* Ajuste de espaçamento interno */
            transition: background-color 0.2s, color 0.2s;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background-color: #ebedf0 !important;
        }

        .active {
            background-color: #ebedf0 !important;
        }

        main {
            margin-left: 240px;
            padding: 90px 30px 50px;
            transition: margin-left 0.3s;
        }

        .content-container {
            width: calc(100% - 240px);
            float: right;
            padding: 20px;
        }

        #sidebarToggle {
            margin-left: auto;
            display: none;
        }

        .sidebar-collapsed #sidebarToggle {
            display: block;
        }

        /* Outros estilos permanecem inalterados */
    </style>
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="../img/logo01-blue.png" class="navbar-logo" alt="Logo da Empresa">
            Painel Administrativo - CONFINTER
        </a>
        <div class="ml-auto">
            <span class="navbar-text mr-3">Usuário: <?php echo $_SESSION['nome_usuario']; ?></span>
            <a href="../index.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="openFuncionalidade('dashboard.html')">
                        <i class="fa fa-search menu-icon"></i> 
                        <span class="d-none d-sm-inline">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('listar_clientes.html')">
                        <i class="fa fa-users menu-icon"></i> 
                        <span class="d-none d-sm-inline">Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('consultar_requisicoes.html')">
                        <i class="fa fa-users menu-icon"></i> 
                        <span class="d-none d-sm-inline">Requisições</span>
                    </a>
                </li>                
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('gerenciar_usuarios.html')">
                        <i class="fa fa-user menu-icon"></i> 
                        <span class="d-none d-sm-inline">Usuários</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('upload_imagens.html')">
                        <i class="fa fa-image menu-icon"></i> 
                        <span class="d-none d-sm-inline">Alterar imagens</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('admin_depoimentos.html')">
                        <i class="fa fa-comments menu-icon"></i> 
                        <span class="d-none d-sm-inline">Depoimentos</span>
                    </a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openFuncionalidade('acesso_erp.html')">
                        <i class="fa fa-key menu-icon"></i> 
                        <span class="d-none d-sm-inline">Acesso ERP</span>
                    </a>
                </li>                
            </ul>
        </div>
        <button class="btn btn-dark" id="sidebarToggle">
            <i class="fa fa-bars"></i>
        </button>
    </nav>

    <!-- Conteúdo principal -->
    <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
        <div id="funcionalidades" class="content-container">
            <!-- Conteúdo das funcionalidades será carregado aqui -->
        </div>
    </main>

    <!-- Script para carregar as funcionalidades -->
    <script>
        function openFuncionalidade(url) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("funcionalidades").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }

        $(document).ready(function(){
            $('#sidebarToggle').click(function(){
                $('.sidebar').toggleClass('sidebar-collapsed');
                $('main').toggleClass('main-expanded');
                $('.nav-link').toggleClass('collapsed-link');
                $('.sidebar .nav-link').toggleClass('expanded-link');
            });
        });
    </script>

    <!-- Bootstrap e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
