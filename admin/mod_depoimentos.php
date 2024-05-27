<?php
session_start();
include_once('../php/conexao.php'); 

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Consulta SQL para selecionar os depoimentos pendentes de moderação
$sql = "SELECT * FROM depoimentos WHERE aprovado = 0 AND reprovado = 0";
$result = $conexao->query($sql);

// Restante do código...
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
                                            if ($result->num_rows > 0) {
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
                                            <?php } else { ?>
                                                <tr><td colspan='6'>Nenhum depoimento pendente de moderação.</td></tr>
                                            <?php } ?>
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
