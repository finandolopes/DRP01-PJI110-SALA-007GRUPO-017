<?php
include_once('../php/conexao.php');
include_once('../php/funcoes_usuarios.php');

// Verifica se o ID do usuário foi fornecido na URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = buscarUsuarioPorId($conexao, $id);
    if(!$usuario) {
        header("Location: gerenciar_usuarios.php");
        exit();
    }
} else {
    header("Location: gerenciar_usuarios.php");
    exit();
}

// Processamento do formulário de edição
if(isset($_POST['editar_usuario'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];

    // Verifica se a senha foi alterada
    $senha = !empty($_POST['senha']) ? $_POST['senha'] : null;

    // Validar entrada (exemplo: campos não vazios)
    if(empty($nome) || empty($usuario) || empty($email)) {
        $error = "Por favor, preencha todos os campos.";
    } else {
        // Prevenir SQL Injection usando prepared statements
        editarUsuario($conexao, $id, $nome, $usuario, $senha, $email);
        header("Location: gerenciar_usuarios.php?edit_success=true");
        exit();
    }
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
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Gerenciar Usuário</h4>
                        <h6>Editar/Atualizar Usuário</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" id="nome" value="<?php echo $usuario['nome']; ?>" required><br>
                            </div>
                            <div class="form-group">
                                <label for="usuario">Usuário:</label>
                                <input type="text" name="usuario" id="usuario" value="<?php echo $usuario['usuario']; ?>" required><br>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" value="<?php echo $usuario['email']; ?>" required><br>
                            </div>
                            <div class="form-group">
                                <label for="senha">Nova Senha:</label>
                                <input type="password" name="senha" id="senha">
                            </div>
                            <button type="submit" name="editar_usuario" class="btn btn-primary">Salvar</button>
                            <a href="gerenciar_usuarios.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script>
        function togglePassword() {
            var senhaInput = document.getElementById("senha");
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
            } else {
                senhaInput.type = "password";
            }
        }
    </script>


    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
