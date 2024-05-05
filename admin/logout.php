<?php
session_start();
// Destruir todas as variáveis de sessão
$_SESSION = array();
// Se você deseja encerrar completamente a sessão, apague também o cookie de sessão.
// Nota: Isto destruirá a sessão e não o cookie de sessão.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finalmente, destrua a sessão
session_destroy();
// Redirecionar para a página de login
header("location: ../index.php");
exit();
?>
