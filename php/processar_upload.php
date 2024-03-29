<?php
// Incluir o arquivo de conexão
include_once('../php/conexao.php');

if(isset($_POST["submit"])) {
    // Verificar se foi enviado um arquivo
    if(isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        $diretorio_destino = "../imgs/"; // Diretório onde as imagens serão armazenadas

        // Verificar se o arquivo é uma imagem
        $tipo_arquivo = exif_imagetype($_FILES["imagem"]["tmp_name"]);
        if($tipo_arquivo === false) {
            echo "O arquivo enviado não é uma imagem.";
            exit();
        }

        // Gerar um nome único para o arquivo
        $nome_arquivo = uniqid() . "_" . basename($_FILES["imagem"]["name"]);
        $caminho_completo = $diretorio_destino . $nome_arquivo;

        // Move a imagem para o diretório de destino
        if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_completo)) {
            // Insira o nome do arquivo no banco de dados
            $sql = "INSERT INTO imagens_carrossel (nome_arquivo) VALUES (?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("s", $nome_arquivo);
            if($stmt->execute()) {
                // Redireciona de volta ao painel após o upload
                header("Location: ../admin.php");
                exit();
            } else {
                echo "Erro ao inserir o nome do arquivo no banco de dados.";
            }
        } else {
            echo "Erro ao mover o arquivo para o diretório de destino.";
        }
    } else {
        echo "Erro no envio do arquivo.";
    }
}
?>
