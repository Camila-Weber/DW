<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";  // Substitua pelo seu usuário
$password = "";  // Substitua pela sua senha
$dbname = "nome_do_banco";  // Substitua pelo nome do seu banco

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Ações
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Login
if ($action == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            session_start();
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            header("Location: pag_usuario.php"); // Redireciona para a área restrita
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Email não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='..\main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center">Login</h2>
                <form id="login-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="text-center mt-3">
                    <a href="..\index.html" class="btn btn-link">Voltar para a página inicial</a>
                </div>
                <div class="text-center mt-2">
                    <span>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></span>
                </div>
            </div>
        </div>
    </div>

    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>