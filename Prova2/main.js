
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


function changeSkill2(skill, element) {
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
                <h3>Git e GitHub</h3>
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

var num1 = 10;
var num2 = 2;
var num3 = 9;
var num4 = 9;
var num5 = 1;
var num6 = 7;
var num7 = 9;
var num8 = 0;
var num9 = 10;
var num10 = 5;
var num11 = 2;
var num12 = 3;
var num13 = 1;
var num14 = 2;
var num15 = 1;

function contar(icon){
    num1++;
    icon.classList.toggle('selected');
    document.getElementById("like").innerHTML = num1;
}

function contar2(icon){
    num2++;
    icon.classList.toggle('selected');
    document.getElementById("deslike").innerHTML = num2;
}

function contar3(icon){
    num3++;
    icon.classList.toggle('selected');
    document.getElementById("coracao").innerHTML = num3;
}

function contar4(icon){
    num4++;
    icon.classList.toggle('selected');
    document.getElementById("like2").innerHTML = num4;
}

function contar5(icon){
    num5++;
    icon.classList.toggle('selected');
    document.getElementById("deslike2").innerHTML = num5;
}

function contar6(icon){
    num6++;
    icon.classList.toggle('selected');
    document.getElementById("coracao2").innerHTML = num6;
}

function contar7(icon){
    num7++;
    icon.classList.toggle('selected');
    document.getElementById("like3").innerHTML = num7;
}

function contar8(icon){
    num8++;
    icon.classList.toggle('selected');
    document.getElementById("deslike3").innerHTML = num8;
}

function contar9(icon){
    num9++;
    icon.classList.toggle('selected');
    document.getElementById("coracao3").innerHTML = num9;
}

function contar10(icon){
    num10++;
    icon.classList.toggle('selected');
    document.getElementById("like4").innerHTML = num10;
}

function contar11(icon){
    num11++;
    icon.classList.toggle('selected');
    document.getElementById("deslike4").innerHTML = num11;
}

function contar12(icon){
    num12++;
    icon.classList.toggle('selected');
    document.getElementById("coracao4").innerHTML = num12;
}

function contar13(icon){
    num13++;
    icon.classList.toggle('selected');
    document.getElementById("like5").innerHTML = num13;
}

function contar14(icon){
    num14++;
    icon.classList.toggle('selected');
    document.getElementById("deslike5").innerHTML = num14;
}

function contar15(icon){
    num15++;
    icon.classList.toggle('selected');
    document.getElementById("coracao5").innerHTML = num15;
}


document.getElementById("commentForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const name = document.getElementById("nameInput").value;
    const email = document.getElementById("emailInput").value;
    const rating = document.getElementById("rating").value;
    const recommend = document.getElementById("recommendInput").value;
    const userComment = document.getElementById("commentInput").value;
    
    const selectedProjects = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                                  .map(checkbox => checkbox.value);
    
    addComment(name, email, rating, recommend, selectedProjects, userComment);

    document.getElementById("commentForm").reset();
});

function addComment(name, email, rating, recommend, projects, userComment) {
    const commentsList = document.getElementById("commentsList");
    const commentItem = document.createElement("li");

    commentItem.innerHTML = `<strong>${name}</strong> (${email})<br>
                             Nota: ${rating} | Recomendaria: ${recommend}<br>
                             Melhores Projetos: ${projects.join(", ") || "Nenhum"}<br>
                             Comentário: ${userComment}`;

    commentsList.appendChild(commentItem);
}
