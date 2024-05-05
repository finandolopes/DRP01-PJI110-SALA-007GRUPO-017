<?php
    // Incluir o arquivo de conexão e as funções de manipulação de usuários
    include('../php/conexao.php');
    include('../php/funcoes_usuarios.php');

    // Verificar se o formulário de criação de usuário foi enviado
    if(isset($_POST['criar_usuario'])) {
        // Processar os dados do formulário e criar um novo usuário
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];

        criarUsuario($conexao, $nome, $usuario, $senha, $email);
    }

    // Verificar se o formulário de edição de usuário foi enviado
    if(isset($_POST['editar_usuario'])) {
        // Processar os dados do formulário e atualizar o usuário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];

        editarUsuario($conexao, $id, $nome, $usuario, $senha, $email);
    }

    // Verificar se há uma solicitação para excluir um usuário
    if(isset($_GET['excluir_id'])) {
        $id = $_GET['excluir_id'];
        excluirUsuario($conexao, $id);
    }
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
            background-color: #fff;
            color: #333;
            padding: 20px;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="date"],
        input[type="submit"],
        button {
            margin-top: 10px;
        }

        button {
            background-color: #0078d4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

            button:hover {
                background-color: #005a9e;
            }

        /* Remover estilos de tabela */
        table,
        th,
        td {
            border: none;
        }

        th {
            background-color: transparent;
            color: #333;
            border-bottom: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 8px;
            text-align: left;
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
                    <a href="../admin/admin_depoimentos.php">
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


            <!-- ================ Listar Requisições Recentes ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <div class="page-title">
                            <h1>Gerenciar Usuários</h1>

                            <!-- Formulário para criar um novo usuário -->
                            <h2>Criar Novo Usuário</h2>
                            <form action="" method="post">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" id="nome" required>
                                <label for="usuario">Usuário:</label>
                                <input type="text" name="usuario" id="usuario" required>
                                <label for="senha">Senha:</label>
                                <div class="input-icon">
                                    <input type="password" name="senha" id="senha" required>
                                    <i class="fas fa-eye" onclick="togglePassword('senha')"></i> <!-- Ícone para exibir a senha -->
                                </div>
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" required>
                                <input type="submit" name="criar_usuario" value="Criar Usuário">
                            </form>

      <style>
        /* Estilos adicionais para aumentar a área ocupada pela tabela */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: transparent;
            color: #333;
            padding: 12px; /* Aumentando o padding do cabeçalho */
        }

        td {
            padding: 12px; /* Aumentando o padding das células */
        }

        /* Estilos para tornar a tabela responsiva */
        @media (max-width: 768px) {
            table {
                width: 100%;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Seu conteúdo HTML aqui -->

    <?php
    // Consultar e exibir a lista de usuários
    $usuarios = listarUsuarios($conexao);

    // Verificar se há usuários para exibir
    if ($usuarios && count($usuarios) > 0) {
        ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Usuário</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php
            foreach($usuarios as $usuario) {
                echo "
                <tr>
                    <td>" . $usuario['nome'] . "</td>
                    <td>" . $usuario['usuario'] . "</td>
                    <td>" . $usuario['email'] . "</td>
                    <td>" . $usuario['perfil'] . "</td>
                    <td>
                        <button class='ms-Button ms-Button--primary' onclick=\"window.location.href ='editar_usuario.php?id=" . $usuario['id'] . "'\">Editar</button>
                        <button class='ms-Button ms-Button--primary' onclick=\"if(confirm('Tem certeza que deseja excluir este usuário?')) window.location.href='gerenciar_usuarios.php?excluir_id=" . $usuario['id'] . "'\">Excluir</button>
                    </td>
                </tr>";
            }
            ?>
        </table>
    <?php } else {
        echo "<p>Não há usuários cadastrados.</p>";
    } ?>
                            </table>

                            <button type="button" class="ms-Button ms-Button--primary" onclick="window.location.href='admin.php'">Voltar</button>

                            <script>
                                function togglePassword(inputId) {
                                    var input = document.getElementById(inputId);
                                    if (input.type === "password") {
                                        input.type = "text";
                                    } else {
                                        input.type = "password";
                                    }
                                }
                            </script>
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
