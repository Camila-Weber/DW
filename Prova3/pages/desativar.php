<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); // Redireciona para a página inicial se não estiver logado
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "dw_p3";  
$password = "dw123456";  
$dbname = "sistema_usuarios"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Atualiza o status do usuário para 'inativo' (ativo = false)
$sql = "UPDATE usuarios SET ativo = FALSE WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

// Verifica se a atualização foi bem-sucedida
if ($stmt->affected_rows > 0) {
    // Destrói a sessão do usuário após desativar a conta
    session_destroy();
    // Redireciona para a página inicial com uma mensagem de conta desativada
    header("Location: index.php?mensagem=Conta desativada com sucesso.");
    exit();
} else {
    // Se não houver alterações, redireciona com mensagem de erro
    echo "Erro ao desativar a conta.";
}

$stmt->close();
$conn->close();
?>
