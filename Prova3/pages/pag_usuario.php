<?php
session_start(); // Inicia a sessão para acessar as variáveis de sessão

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

// Busca os dados do usuário e as configurações de personalização de página
$usuario_id = $_SESSION['usuario_id'];
$sql = "
    SELECT u.nome, p.foto_perfil, p.frase_personalizada, u.data_nascimento, p.tema_escolhido 
    FROM usuarios u 
    LEFT JOIN pagina_usuarios p ON u.id = p.id_usuario 
    WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id); // "i" para inteiros
$stmt->execute();
$result = $stmt->get_result();

// Definindo valores padrão para foto e tema
$foto_perfil_default = 'perfil_padrao.png'; // Foto padrão
$tema_default = 'tema1'; // Tema padrão

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = htmlspecialchars($user['nome']); // Escapa os dados para prevenir XSS
    
    // Verificando se a foto de perfil está vazia ou null e atribuindo a foto padrão
    $foto_perfil = htmlspecialchars($user['foto_perfil'] ?? $foto_perfil_default); // Se 'foto_perfil' for null, usa a foto padrão
    
    // Verificando se a frase personalizada está vazia ou null
    $frase = htmlspecialchars($user['frase_personalizada'] ?? ''); // Se 'frase' for null, usa string vazia
    
    // Verificando se o tema está vazio ou null e atribuindo o tema padrão
    $tema_escolhido = $user['tema_escolhido'] ?? $tema_default;

    // Calculando os dias até o próximo aniversário
    $data_nascimento = $user['data_nascimento'];
    $data_atual = new DateTime();
    $aniversario = new DateTime($data_nascimento);
    $aniversario->setDate($data_atual->format('Y'), $aniversario->format('m'), $aniversario->format('d')); // Define o aniversário para o ano atual

    if ($aniversario < $data_atual) {
        $aniversario->modify('+1 year'); // Se o aniversário já passou neste ano, configura para o próximo
    }

    $dias_para_aniversario = $data_atual->diff($aniversario)->days;

    // Verificando se hoje é o dia do aniversário
    $is_aniversario = $data_atual->format('m-d') == $aniversario->format('m-d');
} else {
    echo "Usuário não encontrado!";
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
    <title><?= $nome ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\main.css">
</head>
<body class="<?= $tema_escolhido ?>"> <!-- Aplica a classe de tema conforme a seleção do usuário -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Frase Única</a>
            <div class="d-flex">
                <!-- Botão Alterar -->
                <a href="pag_edicao.php" class="alterar btn me-2">EDITAR</a>
                <!-- Botão Sair -->
                <a href="logout.php" class="sair btn" onclick="return confirmarSaida()">SAIR</a>
                <!-- Botão Excluir -->
                <button class="excluir btn ms-2" onclick="confirmarExclusao()">EXCLUIR</button>
            </div>
        </div>
    </nav>

    <!-- Conteúdo do perfil -->
    <div class="container profile-card mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Foto de perfil -->
                        <img src="<?= !empty($foto_perfil) ? $foto_perfil : 'default-avatar.png' ?>" alt="Foto de Perfil" class="img-fluid">
                        <h3 class="mt-3"><?= $nome ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Frase personalizada -->
                <div class="card" style="min-width: 50vw;">
                    <div class="card-body">
                        <h4>"<?= !empty($frase) ? $frase : 'Nenhuma frase personalizada ainda.' ?>" - <?= $nome ?>.</h4>
                    </div>
                </div>

                <!-- Contagem de dias para o aniversário -->
                <div class="card mt-3" style="min-width: 50vw;">
                    <div class="card-body" >
                        <h4>Faltam <?= $dias_para_aniversario ?> dias para o seu aniversário!</h4>

                        <!-- Se for o aniversário do usuário, exibe a mensagem de parabéns -->
                        <?php if ($is_aniversario): ?>
                            <div class="alert alert-success mt-3">
                                <h4>Parabéns, <?= $nome ?>! 🎉</h4>
                                <p>Feliz aniversário! Que seu dia seja repleto de alegrias!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
