<?php
// Incluir o arquivo de conexão e as funções de manipulação de clientes
include_once('conexao.php');

// Verifica se há erros na conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Insere uma nova visita no banco de dados
$sql = "INSERT INTO contador_visitas () VALUES ()";
$conn->query($sql);

// Fecha a conexão
$conexao->close();
?>
