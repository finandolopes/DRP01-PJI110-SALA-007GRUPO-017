<?php
session_start();
include_once('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos necessários estão definidos
    if (isset($_POST["id_depoimento"], $_POST["acao"])) {
        $id_depoimento = $_POST["id_depoimento"];
        $acao = $_POST["acao"]; // Ação pode ser "aprovar" ou "reprovar"

        // Definir o status_mod com base na ação
        $status_mod = ($acao == "aprovar") ? "aprovado" : "reprovado";

        try {
            // Atualizar o status_mod na tabela depoimentos
            $sql_update = "UPDATE depoimentos SET status_mod = ? WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);
            $stmt_update->bind_param("si", $status_mod, $id_depoimento);
            $stmt_update->execute();

            // Definir uma variável de sessão para armazenar a mensagem de sucesso
            $_SESSION['sucesso_atualizacao'] = true;
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }

        // Fechar a conexão com o banco de dados
        $conexao->close();

        // Redirecionar de volta para onde você estava
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Campos obrigatórios não foram definidos.";
    }
}
?>
