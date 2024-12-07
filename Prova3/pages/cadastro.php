<?php
session_start(); // Inicia a sessão para acessar as mensagens de erro ou sucesso

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

// **Processamento do Cadastro**
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_repetida = $_POST['senha_repetida'];
    $data_nascimento = $_POST['data_nascimento'];
    
    // Definir um caminho padrão para a foto de perfil
    $foto_perfil = 'default-avatar.png'; 

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

    // Verifica se o arquivo de foto foi enviado
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
    $file_tmp_name = $_FILES['foto_perfil']['tmp_name'];
    $file_name = $_FILES['foto_perfil']['name'];
    $file_size = $_FILES['foto_perfil']['size'];
    $file_error = $_FILES['foto_perfil']['error'];
    
    // Definir as extensões permitidas
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Verifica se a extensão do arquivo é válida
    if (!in_array($file_ext, $allowed_extensions)) {
        $errors[] = "A foto deve ser uma imagem (JPG, PNG ou GIF).";
    }
    
    // Verifica se o arquivo não é muito grande (limite de 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        $errors[] = "O tamanho da foto não pode ser maior que 2MB.";
    }
    
    // Se não houver erros, move o arquivo para o diretório de fotos
    if (empty($errors)) {
        $foto_perfil = 'fotos/' . uniqid() . '.' . $file_ext; // Cria um nome único para a foto
        if (!move_uploaded_file($file_tmp_name, $foto_perfil)) {
            $errors[] = "Erro ao mover a foto para o diretório de destino.";
        }
    }
} else {
    // Se não houver foto, define a foto padrão
    $foto_perfil = 'fotos/perfil_padrao.png'; // Caminho para a foto padrão
}


    // Se não houver erros, prossegue com o cadastro
    if (empty($errors)) {
        // Criptografa a senha
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento) VALUES ('$nome', '$email', '$senha_criptografada', '$data_nascimento')";
        
        if ($conn->query($sql) === TRUE) {
            // Obtém o ID do usuário recém-criado
            $usuario_id = $conn->insert_id;

            // Insere um registro padrão na tabela pagina_usuarios
            $tema_default = 'tema1'; // Tema padrão
            $frase_personalizada = ''; // Frase personalizada vazia

            $insert_pagina_usuarios = "INSERT INTO pagina_usuarios (id_usuario, tema_escolhido, foto_perfil, frase_personalizada) 
                                       VALUES ('$usuario_id', '$tema_default', '$foto_perfil', '$frase_personalizada')";

            if ($conn->query($insert_pagina_usuarios) === TRUE) {
                $_SESSION['success'] = "Cadastro realizado com sucesso!";
                header("Location: login.php"); // Redireciona para o login após cadastro
                exit();
            } else {
                $_SESSION['error'] = "Erro ao cadastrar dados na página de usuário: " . $conn->error;
            }
        } else {
            $_SESSION['error'] = "Erro ao cadastrar: " . $conn->error;
        }
    } else {
        // Se houver erros, armazena na sessão e redireciona
        $_SESSION['errors'] = $errors;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cadastro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='..\main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="pagCadastrar">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card" style="width: 100%; max-width: 400px; padding-top = 0;">
            <div class="card-body">
                <h2 class="card-title text-center">Cadastro</h2>

                <!-- Exibe erros ou sucesso -->
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['errors'])) {
                    foreach ($_SESSION['errors'] as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                    unset($_SESSION['errors']);
                }
                ?>

                <!-- Formulário de Cadastro -->
                <form method="POST" action="" enctype="multipart/form-data">
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

                    <button type="submit" class="cadastrar btn">CADASTRAR</button>
                </form>
                <!-- Link para login -->
                <div class="texto text-center mt-3">
                    <a href="login.php" class="btn btn-link">Já tem uma conta? Faça login</a>
                </div>
            </div>
        </div>
    </div>
    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
