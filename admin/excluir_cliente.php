<?php
// Incluir o arquivo de conexão e as funções de manipulação de clientes
include_once('php/conexao.php'); 
include_once('php/funcoes_clientes.php');
include_once('verifica_login.php');
// Verificar se o ID do cliente foi passado via GET
if(isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    
    // Excluir o cliente pelo ID
    $excluido = excluirCliente($conexao, $id_cliente);
    
    // Verificar se o cliente foi excluído com sucesso
    if($excluido) {
        // Redirecionar de volta para a lista de clientes
        header("Location: listar_clientes.php");
        exit;
    } else {
        // Exibir uma mensagem de erro
        $erro = "Erro ao excluir o cliente. Por favor, tente novamente.";
    }
} else {
    // Se o ID do cliente não foi passado, redirecionar de volta para a lista de clientes
    header("Location: listar_clientes.php");
    exit;
}
?>
