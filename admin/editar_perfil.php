<?php
// Verifica se o formul�rio foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formul�rio
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];
    
    // Verifica se um arquivo foi enviado
    if (isset($_FILES['imagemPerfil']) && $_FILES['imagemPerfil']['error'] === UPLOAD_ERR_OK) {
        // Move o arquivo para o diret�rio desejado
        $diretorio_destino = 'caminho/para/o/diretorio/onde/salvar/a/imagem/';
        $nome_arquivo = $_FILES['imagemPerfil']['name'];
        $caminho_arquivo = $diretorio_destino . $nome_arquivo;
        move_uploaded_file($_FILES['imagemPerfil']['tmp_name'], $caminho_arquivo);
        
        // Agora voc� pode salvar o caminho do arquivo no banco de dados
        // Voc� precisar� adicionar o c�digo para inserir/atualizar os dados no banco de dados aqui
    }

    // Ap�s processar os dados, voc� pode redirecionar o usu�rio para outra p�gina
    header("Location: admin.php");
    exit();
}
?>
