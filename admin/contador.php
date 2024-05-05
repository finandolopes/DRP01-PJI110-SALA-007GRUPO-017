<?php
// Conexão com o banco de dados (substitua os valores conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "confinter";

$conexao = new mysqli($servername, $username, $password, $dbname);

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
