function perfil(){
    var perfil = document.getElementById('options-perfil');
    perfil.classList.toggle('active');
}

ScrollReveal().reveal('.linha', {
    origin: 'top',
    duration: 2000,
    distance: '10%',
});

ScrollReveal().reveal('.reveal-left', {
    origin: 'left',
    duration: 2000,
    distance: '10%',
});

ScrollReveal().reveal('.promocoes-produtos', {
    origin: 'rigth',
    duration: 2000,
    distance: '10%',
});