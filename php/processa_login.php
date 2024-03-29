<?php
session_start();
// Verifique as credenciais do usuário
if ($_POST['username'] === 'admin' && $_POST['password'] === 'senha') {
    // Login bem-sucedido, redirecione para o painel de administração
    $_SESSION['username'] = $_POST['username'];
    header('Location: admin.php');
    exit();
} else {
    // Credenciais inválidas, redirecione de volta para a página de login com uma mensagem de erro
    header('Location: login.php?error=1');
    exit();
}
?>