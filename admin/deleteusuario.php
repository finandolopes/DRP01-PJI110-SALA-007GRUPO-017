<?php
// Incluir o arquivo de conexão
include_once('conexao.php');

// Verificar se o ID do usuário a ser excluído foi fornecido
if(isset($_GET['id'])) {
    // Capturar o ID do usuário a ser excluído
    $id = $_GET['id'];

    // Preparar a consulta SQL para excluir o usuário com o ID fornecido
    $sql = "DELETE FROM usuarios WHERE id = ?";

    // Preparar a declaração SQL
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        // Bind do parâmetro e execução da consulta
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Exclusão bem-sucedida
            echo "Usuário excluído com sucesso!";
        } else {
            // Erro ao executar a consulta
            echo "Erro ao excluir usuário: " . $stmt->error;
        }
        // Fechar declaração
        $stmt->close();
    } else {
        // Erro na preparação da consulta
        echo "Erro na preparação da consulta: " . $conexao->error;
    }

    // Fechar conexão
    $conexao->close();
} else {
    // Se o ID do usuário não foi fornecido, exibir uma mensagem de erro
    echo "ID do usuário não fornecido.";
}
?>
