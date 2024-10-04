
function mudarTexto(){
    document.getElementById("texto").innerHTML = "Texto alterado!";
}

var num = 0;
function contar(){
    num++;
    document.getElementById("like").innerHTML = num + " gostei";
}

var num2 = 0;
function contar2(){
    num2++;
    document.getElementById("deslike").innerHTML = num2 + " não gostei";
}

var resultado = document.getElementById("resultado");
resultado.style.display = "none";
function escrever(){
    var nome = document.getElementById("nome");
    var email = document.getElementById("email");
    var comentario = document.getElementById("comentario");
    resultado.innerHTML = "Comentário de " + nome.value + ";<br>" + email.value + ";<br><br><br>'" + comentario.value + "'";
    resultado.style.display = "block";
}
