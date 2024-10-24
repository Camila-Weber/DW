const light = document.querySelector('.light');

document.addEventListener('mousemove', (e) => {
    light.style.left = `${e.pageX}px`;
    light.style.top = `${e.pageY}px`;
    light.style.display = 'block';
});

document.addEventListener('mouseleave', () => {
    light.style.display = 'none';
});

function changeSkill(skill, element) {
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
        case 'criatividade':
            description.innerHTML = `
                <h3>Criatividade</h3>
                <p>Estou sempre em busca de inspiração e novas ideias que possam enriquecer meu trabalho.</p>
            `;
            break;
        case 'adaptabilidade':
            description.innerHTML = `
                <h3>Adaptabilidade</h3>
                <p>Estou sempre aberta a mudanças e pronta para aprender novas tecnologias e métodos de trabalho.</p>
            `;
            break;
        default:
            description.innerHTML = `
                <h3>Selecione uma habilidade</h3>
                <p>Escolha um ícone para ver mais sobre minhas soft skills.</p>
            `;
            break;
    }

    const icons = document.querySelectorAll('.skill-icons i');
    icons.forEach(icon => {
        icon.classList.remove('active-icon');
    });
    element.classList.add('active-icon');
}


function changeSkill(skill, element) {
    const description = document.getElementById('skill-description2');
    switch (skill) {
        case 'html':
            description.innerHTML = `
                <h3>HTML</h3>
                <p>Possuo uma grande compreensão de HTML, utilizando-o para estruturar páginas web de forma semântica e acessível.</p>
            `;
            break;
        case 'css':
            description.innerHTML = `
                <h3>CSS</h3>
                <p>Tenho experiência em CSS, aplicando estilos para criar layouts responsivos e visualmente atraentes.</p>
            `;
            break;
        case 'js':
            description.innerHTML = `
                <h3>JavaScript</h3>
                <p>Sou iniciante em JavaScript e estou estudando para desenvolver habilidades que me permitam criar interatividade e dinamicidade em páginas web.</p>
            `;
            break;
        case 'bootstrap':
            description.innerHTML = `
                <h3>Bootstrap</h3>
                <p>Utilizo o Bootstrap para acelerar o desenvolvimento de interfaces, aproveitando seus componentes prontos para criar layouts responsivos e amigáveis.</p>
            `;
            break;
        case 'l_c':
            description.innerHTML = `
                <h3>Linguagem C</h3>
                <p>Possuo conhecimento intermediário em C, onde desenvolvi projetos que me ajudaram a entender conceitos fundamentais de programação e estruturas de dados.</p>
            `;
            break;
        case 'java':
            description.innerHTML = `
                <h3>Java</h3>
                <p>Sou iniciante em Java e estou atualmente aprendendo sobre sua sintaxe e como aplicá-lo no desenvolvimento de aplicações.</p>
            `;
            break;
        case 'git':
            description.innerHTML = `
                <h3>Bootstrap</h3>
                <p>Estou em processo de aprendizado do Git, focando em como utilizá-lo para controle de versão e colaborar efetivamente em projetos.</p>
            `;
            break;
        default:
            description.innerHTML = `
                <h3>Selecione uma habilidade</h3>
                <p>Escolha um ícone para ver mais sobre minhas soft skills.</p>
            `;
            break;
    }

    const icons = document.querySelectorAll('.skill-icons i');
    icons.forEach(icon => {
        icon.classList.remove('active-icon');
    });
    element.classList.add('active-icon');
}