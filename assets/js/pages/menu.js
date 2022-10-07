
let menudash = document.getElementById('menudash')
let abrirmenucliente = document.getElementById('abrirmenuclientes')
let menuclientes = document.getElementById('menuclientes')
let marcaritemcliente = document.getElementById('marcaritemcliente')





marcaritemcliente.addEventListener('click', clicarcliente)

function clicarcliente() {
    abrirmenucliente.classList.toggle('menu-open')
    menuclientes.classList.toggle('active')
    marcaritemcliente.classList.toggle('active')
    menudash.classList.toggle('active')
}
