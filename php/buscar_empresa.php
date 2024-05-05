<?php
include_once('php/conexao.php');

// Query para buscar os dados da empresa
$query = "SELECT * FROM empresa WHERE id_empresa = 1"; // Altere o ID da empresa conforme necessário
$result = mysqli_query($conexao, $query);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    // Retorna os dados da empresa como um array associativo
    $row_empresa = mysqli_fetch_assoc($result);
} else {
    echo "Erro ao buscar os dados da empresa: " . mysqli_error($conexao);
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
