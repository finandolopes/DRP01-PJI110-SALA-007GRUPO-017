<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir arquivo de configuração do banco de dados
require_once 'config.php';

// Recuperar o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// Consulta SQL para obter os dados do usuário logado
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar se encontrou o usuário
if (!$usuario) {
    header('Location: login.php');
    exit();
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
                        <h4>Perfil</h4>
                        <h6>Perfil do Usuário</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="profile-set">
                            <div class="profile-head">
                            </div>
                            <div class="profile-top">
                                <div class="profile-content">
                                    <div class="profile-contentimg">
                                        <img src="assets/img/customer/customer5.jpg" alt="img" id="blah">
                                        <div class="profileupload">
                                            <input type="file" id="imgInp">
                                            <a href="javascript:void(0);"><img src="assets/img/icons/edit-set.svg" alt="img"></a>
                                        </div>
                                    </div>
                                    <div class="profile-contentname">
                                        <h2><?php echo htmlspecialchars($usuario['nome']); ?></h2>
                                        <h4>Atualize sua foto e detalhes pessoais.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" placeholder="Insira seu Nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" placeholder="Insira seu E-mail" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Login</label>
                                <input type="text" placeholder="Insira seu Login" value="<?php echo htmlspecialchars($usuario['login']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Senha</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input" value="<?php echo htmlspecialchars($usuario['senha']); ?>">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="javascript:void(0);" class="btn btn-submit me-2">Salvar</a>
                            <a href="javascript:void(0);" class="btn btn-cancel">Cancelar</a>
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
