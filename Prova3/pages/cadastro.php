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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_repetida = $_POST['senha_repetida'];
    $data_nascimento = $_POST['data_nascimento'];

    $errors = [];

    // Validação do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O email fornecido não é válido.";
    }

    // Verifica se o email já está cadastrado no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $errors[] = "Este email já está registrado.";
    }

    // Validação da senha (mínimo 8 caracteres, 1 maiúscula, 1 minúscula, 1 número e 1 caractere especial)
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $senha)) {
        $errors[] = "A senha deve ter pelo menos 8 caracteres, 1 letra maiúscula, 1 letra minúscula, 1 número e 1 caractere especial.";
    }

    // Verifica se a senha e a repetição de senha são iguais
    if ($senha !== $senha_repetida) {
        $errors[] = "As senhas não coincidem.";
    }

    // Se não houver erros, prossegue com o cadastro
    if (empty($errors)) {
        // Criptografa a senha
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento) VALUES ('$nome', '$email', '$senha_criptografada', '$data_nascimento')";
        
        if ($conn->query($sql) === TRUE) {
            // Redireciona para a página de cadastro com uma mensagem de sucesso
            header("Location: cadastro.php?success=Cadastro realizado com sucesso!");
        } else {
            // Redireciona com uma mensagem de erro
            header("Location: cadastro.php?error=Erro ao cadastrar: " . $conn->error);
        }
    } else {
        // Se houver erros, redireciona para o formulário de cadastro com os erros
        $error_message = implode('<br>', $errors);
        header("Location: cadastro.html?error=$error_message");
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cadastro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='..\main.js'></script>
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>

        <!-- Exibe erros ou sucesso -->
        <?php
        // Exibe mensagens de erro ou sucesso retornadas pelo arquivo PHP
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
        } elseif (isset($_GET['success'])) {
            echo '<div class="alert alert-success">' . $_GET['success'] . '</div>';
        }
        ?>

        <form method="POST" action="cadastro_process.php">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="senha_repetida" class="form-label">Repita a Senha</label>
                <input type="password" class="form-control" id="senha_repetida" name="senha_repetida" required>
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>