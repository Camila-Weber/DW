const light = document.querySelector('.light');

document.addEventListener('mousemove', (e) => {
    light.style.left = `${e.pageX}px`;
    light.style.top = `${e.pageY}px`;
    light.style.display = 'block'; // Exibe a luz ao mover o mouse
});

document.addEventListener('mouseleave', () => {
    light.style.display = 'none'; // Esconde a luz ao sair da página
});

function changeSkill(skill) {
    const description = document.getElementById('skill-description');
    switch (skill) {
        case 'comunicacao':
            description.innerHTML = `
                <h3>Comunicação</h3>
                <p>Possuo habilidades de comunicação que me permitem colaborar efetivamente em equipes e compartilhar ideias de forma clara.</p>
            `;
            break;
        case 'trabalhoEquipe':
            description.innerHTML = `
                <h3>Trabalho em Equipe</h3>
                <p>Valorizo a colaboração e a diversidade de ideias, trabalhando com colegas para alcançar objetivos comuns.</p>
            `;
            break;
        case 'resolucaoProblemas':
            description.innerHTML = `
                <h3>Resolução de Problemas</h3>
                <p>Busco soluções criativas para desafios, explorando diferentes abordagens para encontrar a melhor resposta.</p>
            `;
            break;
        default:
            description.innerHTML = `
                <h3>Selecione uma habilidade</h3>
                <p>Escolha um ícone para ver mais sobre minhas soft skills.</p>
            `;
            break;
    }
}
