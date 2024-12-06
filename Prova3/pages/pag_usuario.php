<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nome_do_banco";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Busca os dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, frase, data_nascimento FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = $user['nome'];
    $foto_perfil = $user['foto_perfil'];
    $frase = $user['frase'];
    $data_nascimento = $user['data_nascimento'];

    // Calculando os dias até o próximo aniversário
    $data_atual = new DateTime();
    $aniversario = new DateTime($data_nascimento);
    $aniversario->setDate($data_atual->format('Y'), $aniversario->format('m'), $aniversario->format('d')); // Define o aniversário para o ano atual

    if ($aniversario < $data_atual) {
        $aniversario->modify('+1 year'); // Se o aniversário já passou neste ano, configura para o próximo
    }

    $dias_para_aniversario = $data_atual->diff($aniversario)->days;
} else {
    echo "Usuário não encontrado!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?= $nome ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='..\main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container profile-card">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Foto de perfil -->
                        <img src="<?= $foto_perfil ?: 'default-avatar.png' ?>" alt="Foto de Perfil" class="img-fluid">
                        <h3 class="mt-3"><?= $nome ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Frase do usuário -->
                <div class="card">
                    <div class="card-body">
                        <h4>Frase Personalizada</h4>
                        <p><?= $frase ?: 'Nenhuma frase personalizada ainda.' ?></p>
                    </div>
                </div>

                <!-- Contagem de dias para o aniversário -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h4>Faltam <?= $dias_para_aniversario ?> dias para o seu aniversário!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='..\main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>