<?php
// Dados de conex�o com o banco de dados
$host = "localhost";
$user = "root";
$password = "";
$database = "confinter";

// Conex�o com o banco de dados
$conexao = mysqli_connect($host, $user, $password, $database);

// Verifica se houve erro na conex�o
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>