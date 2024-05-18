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
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Listar Usuários</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Listar Usuários</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Usuários Cadastrados</h4>
                                <a href="novousuario.php" class="btn btn-primary">Cadastrar Novo Usuário</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped data-table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <label class="checkboxs">
                                                        <input type="checkbox">
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </th>
                                                <th>Nome</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>Perfil</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Consultar usuários no banco de dados
                                            $usuarios = listarUsuarios($conexao);

                                            // Verificar se há usuários cadastrados
                                            if(count($usuarios) > 0) {
                                            // Loop através dos usuários e exibir os dados
                                            foreach($usuarios as $usuario) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <label class="checkboxs">
                                                        <input type="checkbox">
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </td>
                                                <td><?php echo $usuario['nome']; ?></td>
                                                <td><?php echo isset($usuario['telefone']) ? $usuario['telefone'] : ''; ?></td>
                                                <td><?php echo $usuario['email']; ?></td>
                                                <td><?php echo ucfirst($usuario['perfil']); ?></td>
                                                <td>
                                                    <a class="me-3" href="editusuario.php?id=<?php echo $usuario['id']; ?>">
                                                        <img src="assets/img/icons/edit.svg" alt="Editar">
                                                    </a>

                                                    <a class="me-3 confirm-text" href="#" onclick="confirmarExclusao(<?php echo $usuario['id']; ?>);">
                                                        <img src="assets/img/icons/delete.svg" alt="Excluir">
                                                    </a>

                                                    <script>
                                                        function confirmarExclusao(id) {
                                                            if (confirm('Tem certeza que deseja excluir este usuário?')) {
                                                                window.location.href = 'deleteusuario.php?id=' + id;
                                                            }
                                                        }</script>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            } else {
                                            echo "
                                            <tr><td colspan='6'>Nenhum usuário cadastrado.</td></tr>";
                                            }
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
