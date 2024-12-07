<?php
session_start(); // Inicia a sessão

// Destruir todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar para a página inicial ou de login
header("Location: ..\index.php");
exit();
?>
