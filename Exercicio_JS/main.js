
function mudarTexto(){
    document.getElementById("texto").innerHTML = "Texto alterado!";
}

var num = 0;
function contar(){
    num++;
    document.getElementById("incremento").innerHTML = "Número de cliques " + num;
}

function escrever(){
    var nome = document.getElementById("nome");
    var email = document.getElementById("email");
    document.getElementById("escrever").innerHTML = "Nome: " + nome.value + "<br>Email: " + email.value;
}
