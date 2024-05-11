<?php
// Dados de conexão com o banco de dados
$host = "localhost";   // indicar o host do banco de dados
$user = "seu usuário"; // login do banco de dados
$password = "sua senha"; // Senha de acesso ao banco de dados
$database = "seu BD"; // Seu banco de dados criado no phpMyAdmin ou outro gerenciador de banco de dados

// Conexão com o banco de dados
$conexao = mysqli_connect($host, $user, $password, $database);

// Verifica se houve erro na conexão
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>
