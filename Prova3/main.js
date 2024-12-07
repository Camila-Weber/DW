/* Mensagem de confimação de saída */
function confirmarSaida() {
    // Exibe a confirmação antes de sair
    return confirm("Você tem certeza que deseja sair?");
}

/* Mensagem de confirmação de exclusão */
function confirmarExclusao() {
    // Exibe a mensagem de confirmação
    if (confirm("Tem certeza de que deseja desativar sua conta? Essa ação não pode ser desfeita.")) {
        // Se o usuário confirmar, redireciona para o script PHP que irá marcar a conta como inativa
        window.location.href = "desativar_conta.php"; // O PHP será responsável por desativar o usuário
    }
}