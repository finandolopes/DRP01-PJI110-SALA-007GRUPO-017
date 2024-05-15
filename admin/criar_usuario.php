<?php
include '..php/config.php';

// Use $conn para interagir com o banco de dados
// Função para criar um novo usuário
function criarUsuario($conexao, $nome, $usuario, $senha, $telefone, $email, $perfil) {
    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Query SQL para inserir o novo usuário
    $sql = "INSERT INTO usuarios (nome, usuario, senha, telefone, email, perfil) VALUES ('$nome', '$usuario', '$senhaHash', '$telefone', '$email', '$perfil')";
    
    // Executa a query
    if (mysqli_query($conexao, $sql)) {
        return true; // Retorna verdadeiro se a inserção for bem-sucedida
    } else {
        return false; // Retorna falso se houver algum erro na inserção
    }
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtém os valores do formulário
    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $perfil = $_POST["perfil"];

    // Chama a função criarUsuario para inserir o novo usuário no banco de dados
    if (criarUsuario($conn, $nome, $usuario, $senha, $telefone, $email, $perfil)) {
        echo "Usuário criado com sucesso";
    } else {
        echo "Erro ao criar usuário";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
}
?>
