<?php
session_start();
include_once('../php/conexao.php'); // Ajuste no caminho do include_once

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
// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Função para executar uma consulta preparada e retornar o resultado
function executarConsulta($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    if (!$stmt->execute()) {
        // Tratamento de erro, se a consulta não for bem-sucedida
        return false;
    }
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Função para contar registros retornados por uma consulta
function contarRegistros($conexao, $sql, $params = null) {
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(...$params);
    }
    if (!$stmt->execute()) {
        // Tratamento de erro, se a consulta não for bem-sucedida
        return 0;
    }
    $result = $stmt->get_result();
    return $result->num_rows;
}

// Recupera o nome de usuário da sessão
$username = $_SESSION['username'];

// Consulta o banco de dados para obter informações do usuário
$sqlUsuario = "SELECT * FROM usuarios WHERE usuario = ?";
$usuario = executarConsulta($conexao, $sqlUsuario, ['s', $username]);

// Verifica se o usuário foi encontrado
if ($usuario) {
    // Use as informações do usuário
    $nome = htmlspecialchars($usuario['nome']);
    $email = htmlspecialchars($usuario['email']);
    // e assim por diante...
} else {
    // Trate o caso em que o usuário não foi encontrado
    $nome = "Usuário Desconhecido";
    $email = "email@example.com";
    // ou qualquer valor padrão que você preferir
}
// Consulta o perfil do usuário
$sqlPerfilUsuario = "SELECT perfil FROM usuarios WHERE usuario = ?";
$perfilUsuario = executarConsulta($conexao, $sqlPerfilUsuario, ['s', $username]);
$perfil_usuario = $perfilUsuario ? $perfilUsuario['perfil'] : "Perfil do Usuário";// Consulta o banco de dados para obter a média de tempo que o visitante fica no site
$sqlMediaTempo = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(tempo))) AS media_tempo FROM contador_visitas";
$mediaTempo = executarConsulta($conexao, $sqlMediaTempo);
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

    <!-- include do footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
