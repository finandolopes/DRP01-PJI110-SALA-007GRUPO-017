<?php
session_start();
include_once('../php/conexao.php');

// Verificar se o formulário de upload de imagem foi enviado
if(isset($_POST["submit"])) {
    $diretorio_destino = "../img/slider/"; // Diretório onde as imagens serão armazenadas
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
    $caminho_arquivo = "../img/slider/" . $nome_arquivo;

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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.min.css">
    <link rel="stylesheet" href="https://static2.sharepointonline.com/files/fabric/office-ui-fabric-core/11.0.0/css/fabric.components.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Alterar imagens do Carrossel</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .container {
            margin: 0 auto;
            max-width: 800px;
        }

        .img-thumbnail {
            width: 270px;
            height: 200px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .modal-dialog {
            max-width: 800px;
        }

        .modal-content {
            width: 100%;
        }

        .img-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
        }

        .img-card {
            width: calc(48% - 10px);
            text-align: center;
        }

        .btn-back {
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Estilizar botões */
        .btn-primary, .btn-danger, .btn-secondary {
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #0078d4;
            border-color: #0078d4;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-secondary {
            background-color: #eaeaea;
            border-color: #eaeaea;
            color: #333;
        }

        .btn-primary:hover, .btn-danger:hover, .btn-secondary:hover {
            background-color: #005a9e;
            border-color: #005a9e;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Upload de Imagens</h2>
    <form action="upload_imagens.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="imagem">Selecione uma imagem:</label>
            <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/*">
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-lg">Enviar Imagem</button>
    </form>

    <h2>Imagens no Carrossel</h2>
    <div class="img-container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="img-card">
                <img src="../img/slider/<?php echo $row['nome_arquivo']; ?>" class="img-thumbnail" alt="Imagem do Carrossel" data-toggle="modal" data-target="#imagemModal<?php echo $row['id']; ?>">
                <form action="upload_imagens.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta imagem?')">
                    <input type="hidden" name="nome_arquivo" value="<?php echo $row['nome_arquivo']; ?>">
                    <button type="submit" name="excluir_imagem" class="btn btn-danger btn-lg">Excluir</button>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="imagemModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="../img/slider/<?php echo $row['nome_arquivo']; ?>" class="img-fluid" alt="Imagem do Carrossel" style="max-width: 600px;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <button type="button" class="btn-back btn-lg" onclick="window.location.href='admin.php'">Voltar</button>
</div>

<script src="../script/jquery.js"></script>
<script src="../script/bootstrap.js"></script>

</body>
</html>

