<?php
session_start();

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

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); // Redireciona para a página inicial se não estiver logado
    exit();
}

// Obtém o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Busca os dados do usuário e as configurações de personalização de página
$sql = "
    SELECT u.nome, u.email, u.senha, u.data_nascimento, p.foto_perfil, p.frase_personalizada, p.tema_escolhido
    FROM usuarios u
    LEFT JOIN pagina_usuarios p ON u.id = p.id_usuario
    WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Valores padrão para foto e tema
$foto_perfil_default = 'fotos/perfil_padrao.png';
$tema_default = 'tema1';

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = $user['nome'];
    $email = $user['email'];
    $senha = $user['senha'];
    $data_nascimento = $user['data_nascimento'];
    $foto_perfil = $user['foto_perfil'] ?? $foto_perfil_default;
    $frase = $user['frase_personalizada'] ?? '';
    $tema_escolhido = $user['tema_escolhido'] ?? $tema_default;
} else {
    echo "Usuário não encontrado!";
    exit();
}

// Processando a edição do perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $nova_frase = $_POST['frase_personalizada'];
    $novo_tema = $_POST['tema_escolhido'];
    $nova_data_nascimento = $_POST['data_nascimento'];  // Captura a nova data de nascimento

    // Verifica se a senha foi alterada e se a confirmação de senha é válida
    if (!empty($_POST['nova_senha']) && $_POST['nova_senha'] === $_POST['confirmar_senha']) {
        $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_BCRYPT); // Criptografa a nova senha
    } else {
        $nova_senha = $senha; // Mantém a senha atual se não foi alterada
    }

    // Verificando se a foto foi alterada
    if ($_FILES['foto_perfil']['error'] === 0) {
        // Sanitizando e validando a foto
        $foto_perfil_name = $_FILES['foto_perfil']['name'];
        $foto_perfil_tmp_name = $_FILES['foto_perfil']['tmp_name'];
        $foto_perfil_ext = strtolower(pathinfo($foto_perfil_name, PATHINFO_EXTENSION));
        
        // Extensões permitidas para imagens
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($foto_perfil_ext, $extensoes_permitidas)) {
            // Gerando nome único para a foto
            $foto_perfil = 'fotos/' . uniqid() . '.' . $foto_perfil_ext;
            
            // Movendo o arquivo para o diretório de upload
            if (move_uploaded_file($foto_perfil_tmp_name, $foto_perfil)) {
                // Foto carregada com sucesso
            } else {
                echo "Erro ao fazer upload da foto.";
                exit();
            }
        } else {
            echo "Apenas arquivos de imagem (JPG, PNG, GIF) são permitidos.";
            exit();
        }
    }

    // Atualizando os dados no banco de dados
    $update_sql = "
        UPDATE usuarios u
        LEFT JOIN pagina_usuarios p ON u.id = p.id_usuario
        SET u.nome = ?, u.email = ?, u.senha = ?, u.data_nascimento = ?, p.foto_perfil = ?, p.frase_personalizada = ?, p.tema_escolhido = ?
        WHERE u.id = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", $novo_nome, $novo_email, $nova_senha, $nova_data_nascimento, $foto_perfil, $nova_frase, $novo_tema, $usuario_id);
    $stmt->execute();

    // Redireciona de volta para a página de perfil após a atualização
    header("Location: pag_usuario.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\main.css">
</head>
<body class="pagEditar">
    <div class="container">
        <h2>Editar Perfil</h2>
        <form method="POST" enctype="multipart/form-data">
            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <!-- Senha e Confirmar Senha -->
            <div class="mb-3">
                <label for="nova_senha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Deixe em branco para manter a senha atual">
            </div>

            <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="Confirmar nova senha">
            </div>

            <!-- Data de Nascimento -->
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($data_nascimento) ?>" required>
            </div>

            <!-- Foto de Perfil -->
            <div class="mb-3">
                <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
                <small>Foto atual: <img src="<?= htmlspecialchars($foto_perfil) ?>" alt="Foto de Perfil" width="100"></small>
            </div>

            <!-- Frase Personalizada -->
            <div class="mb-3">
                <label for="frase_personalizada" class="form-label">Frase Personalizada</label>
                <input type="text" class="form-control" id="frase_personalizada" name="frase_personalizada" value="<?= htmlspecialchars($frase) ?>">
            </div>

            <!-- Tema Escolhido -->
            <label for="tema_escolhido" class="form-label">Escolha o Tema</label><br>
            <div class="tema mb-3">
                <input type="radio" id="tema1" name="tema_escolhido" value="tema1" <?= ($tema_escolhido === 'tema1') ? 'checked' : '' ?>>
                <label for="tema1">Tema 1</label>
                <input type="radio" id="tema2" name="tema_escolhido" value="tema2" <?= ($tema_escolhido === 'tema2') ? 'checked' : '' ?>>
                <label for="tema2">Tema 2</label>
                <input type="radio" id="tema3" name="tema_escolhido" value="tema3" <?= ($tema_escolhido === 'tema3') ? 'checked' : '' ?>>
                <label for="tema3">Tema 3</label>
                <input type="radio" id="tema4" name="tema_escolhido" value="tema4" <?= ($tema_escolhido === 'tema4') ? 'checked' : '' ?>>
                <label for="tema4">Tema 4</label>
            </div>

            <!-- Botões -->
            <div class="mb-3">
                <button type="submit" class="btn">SALVAR</button>
                <a href="pag_usuario.php" class="cancelar btn">CANCELAR</a>
            </div>
        </form>
    </div>
    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
