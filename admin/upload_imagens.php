<?php
session_start();
include_once('../php/conexao.php');

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

// Verificar se o formulário de upload de imagem foi enviado
if(isset($_POST["submit"])) {
    $diretorio_destino = "../assets/img/slider/"; // Diretório onde as imagens serão armazenadas
    $nome_arquivo = basename($_FILES["imagem"]["name"]);
    $caminho_completo = $diretorio_destino . $nome_arquivo;

    // Move a imagem para o diretório de destino
    if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_completo)) {
        // Insira o nome do arquivo no banco de dados
        $sql = "INSERT INTO imagens_carrossel (nome_arquivo) VALUES (?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $nome_arquivo);
        $stmt->execute();
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}

// Verificar se há uma solicitação para excluir uma imagem
if(isset($_POST['excluir_imagem'])) {
    $nome_arquivo = $_POST['nome_arquivo'];
    $caminho_arquivo = "../assets/img/slider/" . $nome_arquivo;

    // Excluir o arquivo do diretório
    if(file_exists($caminho_arquivo)) {
        unlink($caminho_arquivo);

        // Excluir o registro do banco de dados
        $sql = "DELETE FROM imagens_carrossel WHERE nome_arquivo = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $nome_arquivo);
        $stmt->execute();
    } else {
        echo "Arquivo não encontrado.";
    }
}

// Consulta ao banco de dados para recuperar as imagens do carrossel
$sql = "SELECT * FROM imagens_carrossel";
$result = mysqli_query($conexao, $sql);
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
    <div class="page-wrapper cardhead">
            <div class="content">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Alterar Slides</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Alterar Slides</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Slides</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    // Loop através de cada linha de resultado
                                    while ($row = $result->fetch_assoc()) {
                                    echo '
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <a href="../assets/img/slider/' . $row["nome_arquivo"] . '" class="image-popup">
                                            <img src="../assets/img/slider/' . $row["nome_arquivo"] . '" class="img-fluid" alt="Slide">
                                        </a>
                                    </div>
                                    ';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário para adicionar slide -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Adicionar Slide</div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="imagem">Selecione uma imagem para o slide:</label>
                                        <input type="file" class="form-control" id="imagem" name="imagem" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Adicionar Slide</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário para excluir slide -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Excluir Slide</div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="nome_arquivo">Selecione o slide a ser excluído:</label>
                                        <select class="form-control" id="nome_arquivo" name="nome_arquivo" required>
                                            <option value="">Selecione o slide</option>
                                            <?php
                                            // Reinicie a consulta para exibir novamente os slides
                                            $result = mysqli_query($conexao, $sql);
                                            // Loop através de cada linha de resultado
                                            while ($row = $result->fetch_assoc()) {
                                            echo '
                                            <option value="' . $row[" nome_arquivo"] . '">' . $row["nome_arquivo"] . '</option>' ;
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger" name="excluir_imagem">Excluir Slide</button>
                                </form>
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
