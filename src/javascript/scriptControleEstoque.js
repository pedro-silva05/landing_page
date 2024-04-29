
function addProduto(){
    var esconder = document.getElementById('hidden');
    esconder.classList.toggle('hidden');
    document.getElementById('desfocus').style.display = 'block'; 
}
function voltar(){
    var esconder = document.getElementById('hidden');
    esconder.classList.toggle('hidden');
    document.getElementById('desfocus').style.display = 'none'; 
}
document.getElementById('cod').addEventListener('input', function() {
    if (this.value.length > 13) {
        this.value = this.value.slice(0,13); 
    }
});
