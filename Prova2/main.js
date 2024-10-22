const light = document.querySelector('.light');

document.addEventListener('mousemove', (e) => {
    light.style.left = `${e.pageX}px`;
    light.style.top = `${e.pageY}px`;
    light.style.display = 'block'; // Exibe a luz ao mover o mouse
});

document.addEventListener('mouseleave', () => {
    light.style.display = 'none'; // Esconde a luz ao sair da página
});
