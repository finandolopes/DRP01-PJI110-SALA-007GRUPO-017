<?php
// Incluir o arquivo de conexão
include_once('../php/conexao.php');
include_once('../php/cadastrar_usuario.php');
// Verificar se a URL contém o parâmetro de sucesso
if(isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p>Usuário inserido com sucesso!</p>";
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
                <h6>Add/Atualizar Usuário</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="../php/cadastrar_usuario.php"> <!-- Adicionei aqui -->
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="nome">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Usuário</label>
                                <input type="text" name="usuario">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
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
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="email">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Perfil</label>
                                <select class="select" name="perfil">
                                    <option value="">Selecionar</option>
                                    <option value="admin">Admin</option>
                                    <option value="usuario">Usuário</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
    <div class="form-group">
        <label> Imagem de Perfil</label>
        <div class="image-upload">
            <input type="file" name="img_perfil" id="img_perfil_input" accept="image/*"> <!-- Adicionei o id "img_perfil_input" -->
            <div class="image-uploads">
                <img src="assets/img/icons/upload.svg" alt="img" id="img_preview"> <!-- Adicionei o id "img_preview" -->
                <h4>Arraste e solte um arquivo para fazer upload</h4>
            </div>
        </div>
    </div>
</div>

<script>
    const imgPerfilInput = document.getElementById('img_perfil_input');
    const imgPreview = document.getElementById('img_preview');

    imgPerfilInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function() {
                imgPreview.src = reader.result;
            };

            reader.readAsDataURL(file);
        } else {
            imgPreview.src = 'assets/img/icons/upload.svg'; // Se nenhum arquivo for selecionado, exibir o ícone padrão
        }
    });
</script>

                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Salvar</button>
                        <a href="userlist.html" class="btn btn-cancel">Cancelar</a>
                    </div>
                </form> <!-- Fechei aqui -->
            </div>
        </div>
    </div>
</div>

    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
