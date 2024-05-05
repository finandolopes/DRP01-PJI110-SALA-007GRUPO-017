<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];
    
    // Verifica se um arquivo foi enviado
    if (isset($_FILES['imagemPerfil']) && $_FILES['imagemPerfil']['error'] === UPLOAD_ERR_OK) {
        // Move o arquivo para o diretório desejado
        $diretorio_destino = 'caminho/para/o/diretorio/onde/salvar/a/imagem/';
        $nome_arquivo = $_FILES['imagemPerfil']['name'];
        $caminho_arquivo = $diretorio_destino . $nome_arquivo;
        move_uploaded_file($_FILES['imagemPerfil']['tmp_name'], $caminho_arquivo);
        
        // Agora você pode salvar o caminho do arquivo no banco de dados
        // Você precisará adicionar o código para inserir/atualizar os dados no banco de dados aqui
    }

    // Após processar os dados, você pode redirecionar o usuário para outra página
    header("Location: admin.php");
    exit();
}
?>
