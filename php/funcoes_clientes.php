<?php
// Função para listar todos os clientes do banco de dados
function listarClientes($conexao) {
    // Consulta SQL para selecionar todos os clientes
    $sql = "SELECT * FROM clientes";

    // Executar a consulta
    $resultado = mysqli_query($conexao, $sql);

    // Verificar se a consulta foi bem-sucedida
    if ($resultado) {
        // Inicializar um array para armazenar os clientes
        $clientes = array();

        // Loop através dos resultados da consulta e adicionar cada cliente ao array
        while ($cliente = mysqli_fetch_assoc($resultado)) {
            $clientes[] = $cliente;
        }

        // Retornar o array de clientes
        return $clientes;
    } else {
        // Se a consulta falhar, retornar um array vazio
        return array();
    }
}
// Função para buscar cliente por ID
function buscarClientePorId($conexao, $id_cliente) {
    // Consulta SQL para selecionar o cliente pelo ID
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_cliente);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificar se há resultados
    if(mysqli_num_rows($resultado) > 0) {
        $cliente = mysqli_fetch_assoc($resultado);
        return $cliente;
    } else {
        return false;
    }
}
// Função para buscar cliente por nome
function buscarClientePorNome($conexao, $nome) {
    // Consulta SQL para selecionar o cliente pelo nome
    $sql = "SELECT * FROM clientes WHERE nome = ?";
    
    // Preparar a consulta
    $stmt = mysqli_prepare($conexao, $sql);
    
    // Bind o parâmetro
    mysqli_stmt_bind_param($stmt, "s", $nome);
    
    // Executar a consulta
    mysqli_stmt_execute($stmt);
    
    // Obter os resultados
    $resultado = mysqli_stmt_get_result($stmt);
    
    // Verificar se há resultados
    if(mysqli_num_rows($resultado) > 0) {
        $cliente = mysqli_fetch_assoc($resultado);
        return $cliente;
    } else {
        return false;
    }
}
// Função para atualizar os dados do cliente
function atualizarCliente($conexao, $id_cliente, $nome, $email, $telefone) {
    // Query SQL para atualizar os dados do cliente
    $query = "UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id_cliente = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $nome, $email, $telefone, $id_cliente);
    $resultado = mysqli_stmt_execute($stmt);
    
    // Verificar se a atualização foi bem-sucedida
    if($resultado) {
        return true;
    } else {
        return false;
    }
}
// Função para excluir um cliente pelo ID
function excluirCliente($conexao, $id_cliente) {
    // Query SQL para excluir o cliente pelo ID
    $query = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_cliente);
    $resultado = mysqli_stmt_execute($stmt);
    
    // Verificar se a exclusão foi bem-sucedida
    if($resultado) {
        return true;
    } else {
        return false;
    }
}

?>
