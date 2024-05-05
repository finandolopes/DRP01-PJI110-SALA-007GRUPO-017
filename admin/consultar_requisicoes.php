<?php
// Incluir o arquivo de conexão e as funções de manipulação de requisições
include_once('../php/conexao.php');
include_once('../php/funcoes_requisicoes.php');

// Verificar se o formulário de filtro foi submetido
if(isset($_POST['filtrar'])) {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consultar requisições filtradas por data
    require_once('../php/funcoes_requisicoes.php');
    $requisicoes = listarRequisicoesPorData($conexao, $data_inicio, $data_fim);
} else {
    // Consultar todas as requisições do banco de dados
    require_once('../php/funcoes_requisicoes.php');
    $requisicoes = listarRequisicoes($conexao);


    // Consultar requisições filtradas por data
    $requisicoes = listarRequisicoesPorData($conexao, $data_inicio, $data_fim);
} else {
    // Consultar todas as requisições do banco de dados
    $requisicoes = listarRequisicoes($conexao);
}

// Verificar se o formulário foi enviado e se há requisições para exportar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exportar']) && !empty($requisicoes)) {
    // Inicializar o objeto SimpleXMLElement para criar o XML
    $xml = new SimpleXMLElement('<requisicoes></requisicoes>');

    // Iterar sobre as requisições para adicionar cada uma ao XML
    foreach ($requisicoes as $requisicao) {
        // Criar um novo elemento "requisicao"
        $requisicaoXML = $xml->addChild('requisicao');

        // Adicionar os dados da requisição como elementos filho do elemento "requisicao"
        $requisicaoXML->addChild('id', $requisicao['id_requisicao']);
        $requisicaoXML->addChild('nome', $requisicao['nome']);
        $requisicaoXML->addChild('data_nascimento', isset($requisicao['data_nascimento']) ? $requisicao['data_nascimento'] : '');
        $requisicaoXML->addChild('email', $requisicao['email']);
        $requisicaoXML->addChild('telefone', $requisicao['telefone']);
        $requisicaoXML->addChild('horario_contato', $requisicao['horario_contato']);
        $requisicaoXML->addChild('tipo', $requisicao['tipo']);
        $requisicaoXML->addChild('categoria', $requisicao['categoria']);
        $requisicaoXML->addChild('outros_info', $requisicao['outros_info']);
        $requisicaoXML->addChild('data_requisicao', $requisicao['data_requisicao']);
    }

    // Definir cabeçalhos para forçar o download do XML
    header('Content-Disposition: attachment; filename="requisicoes.xml"');
    header('Content-Type: text/xml');

    // Imprimir o XML
    echo $xml->asXML();
    exit; // Parar a execução do script após gerar o XML
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tbody tr:nth-child(odd) {
            background-color: #495057;
        }

        tbody tr:hover {
            background-color: #6c757d;
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

             <div class="container">
        <h1>Consultar Requisições</h1>
        
        <!-- Formulário de filtro por data -->
        <form method="post">
            <label for="data_inicio">Data de Início:</label>
            <input type="date" name="data_inicio" id="data_inicio">
            <label for="data_fim">Data Fim:</label>
            <input type="date" name="data_fim" id="data_fim">
            <button type="submit" name="filtrar">Filtrar</button>
        </form>
        
        <!-- Tabela para exibir as requisições -->
        <?php if ($requisicoes): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Horário para Contato</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Outras Informações</th>
                        <th>Data da Requisição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requisicoes as $requisicao): ?>
                        <tr>
                            <td><?php echo $requisicao['id_requisicao']; ?></td>
                            <td><?php echo $requisicao['nome']; ?></td>
                            <td><?php echo isset($requisicao['data_nascimento']) ? $requisicao['data_nascimento'] : ''; ?></td>
                            <td><?php echo $requisicao['email']; ?></td>
                            <td><?php echo $requisicao['telefone']; ?></td>
                            <td><?php echo $requisicao['horario_contato']; ?></td>
                            <td><?php echo $requisicao['tipo']; ?></td>
                            <td><?php echo $requisicao['categoria']; ?></td>
                            <td><?php echo $requisicao['outros_info']; ?></td>
                            <td><?php echo $requisicao['data_requisicao']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há requisições para exibir.</p>
        <?php endif; ?>

        <button onclick="window.location.href='admin.php'">Voltar</button>
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
