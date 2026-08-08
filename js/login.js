document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector("form");
    const campoUsuario = document.getElementById("usuario");
    const campoContrasena = document.getElementById("contrasena");

    formulario.addEventListener("submit", function (evento) {
        const usuario = campoUsuario.value.trim();
        const contrasena = campoContrasena.value.trim();

        if (usuario === "" || contrasena === "") {
            evento.preventDefault();
            alert("Debe completar todos los campos.");
        }
    });
});