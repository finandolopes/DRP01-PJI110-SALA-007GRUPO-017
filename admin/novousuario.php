<?php
// Incluir o arquivo de conexão
include_once('../php/conexao.php');
include_once('../php/cadastrar_usuario.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $perfil = $_POST['perfil'];

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = 'assets/img/perfil' . $imagem_nome; // Especifique o caminho onde deseja salvar as imagens

        // Move a imagem para o diretório desejado
        if (move_uploaded_file($imagem_temp, $imagem_destino)) {
            // Insere os dados no banco de dados, incluindo o caminho da imagem
            $sql = "INSERT INTO usuarios (nome, email, senha, telefone, perfil, img_perfil) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssssss", $nome, $email, $senha, $telefone, $perfil, $imagem_destino);

            if ($stmt->execute()) {
                // Redireciona para uma página de sucesso
                header("Location: sucesso.php");
                exit();
            } else {
                // Em caso de erro, exibe uma mensagem de erro
                echo "Erro ao adicionar usuário: " . $conexao->error;
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Por favor, selecione uma imagem.";
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
                <h4>Gerenciar Usuários</h4>
                <h6>Add/Alterar Usuário</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="cadastrar_usuario.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="nome">
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email">
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input" name="senha">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone">
                            </div>
                            <div class="form-group">
                                <label>Perfil</label>
                                <select class="select" name="perfil">
                                    <option value="Selecionar">Selecionar</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Usuário">Usuário</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Confirmar Senha</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-inputs">
                                    <span class="fas toggle-passworda fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Imagem de Perfil</label>
                                <div class="image-upload image-upload-new">
                                    <input type="file" name="img_perfil">
                                    <div class="image-uploads">
                                        <img src="assets/img/icons/upload.svg" alt="img">
                                        <h4>Arraste e solte um arquivo para fazer upload</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Salvar</button>
                            <button type="reset" class="btn btn-cancel">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
