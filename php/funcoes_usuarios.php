<?php
    // Função para criar um novo usuário
    function criarUsuario($conexao, $nome, $usuario, $senha, $email) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, usuario, senha, email) VALUES ('$nome', '$usuario', '$senhaHash', '$email')";
        mysqli_query($conexao, $sql);
    }

    // Função para editar um usuário existente
    function editarUsuario($conexao, $id, $nome, $usuario, $senha, $email) {
        // Verificar se a senha foi alterada
        if (!empty($senha)) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome='$nome', usuario='$usuario', senha='$senhaHash', email='$email' WHERE id=$id";
        } else {
            $sql = "UPDATE usuarios SET nome='$nome', usuario='$usuario', email='$email' WHERE id=$id";
        }
        mysqli_query($conexao, $sql);
    }

    // Função para excluir um usuário
    function excluirUsuario($conexao, $id) {
        $sql = "DELETE FROM usuarios WHERE id=$id";
        mysqli_query($conexao, $sql);
    }

    // Função para listar todos os usuários
    function listarUsuarios($conexao) {
        $sql = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexao, $sql);
        $usuarios = array();
        while ($usuario = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }
    // Função para buscar um usuário pelo ID
function buscarUsuarioPorId($conexao, $id) {
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);
    
    // Verificar se houve algum resultado
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null; // Retorna null se o usuário não for encontrado
    }
}
?>
