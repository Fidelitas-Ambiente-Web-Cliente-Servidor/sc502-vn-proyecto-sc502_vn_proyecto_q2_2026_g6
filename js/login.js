document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector("form");
    const campoUsuario = document.getElementById("usuario");
    const campoContrasena = document.getElementById("contrasena");

    formulario.addEventListener("submit", function (evento) {
        evento.preventDefault();

        const usuario = campoUsuario.value.trim();
        const contrasena = campoContrasena.value.trim();

        if (usuario === "" || contrasena === "") {
            alert("Debe completar todos los campos.");
            return;
        }

        validarCredenciales(usuario, contrasena);
    });
});

/**
 * Credenciales temporales del sistema.
 * Más adelante pueden reemplazarse por una base de datos.
 */
function validarCredenciales(usuario, contrasena) {
    const usuariosPermitidos = [
        {
            usuario: "admin",
            contrasena: "1234",
            nombre: "Administrador",
            rol: "Administrador"
        },
        {
            usuario: "aaron",
            contrasena: "2026",
            nombre: "Aaron García Basabe",
            rol: "Usuario"
        }
    ];

    const usuarioEncontrado = usuariosPermitidos.find(function (registro) {
        return (
            registro.usuario === usuario &&
            registro.contrasena === contrasena
        );
    });

    if (!usuarioEncontrado) {
        alert("Usuario o contraseña incorrectos.");
        return;
    }

    const sesion = {
        usuario: usuarioEncontrado.usuario,
        nombre: usuarioEncontrado.nombre,
        rol: usuarioEncontrado.rol
    };

    localStorage.setItem("usuarioActivo", JSON.stringify(sesion));

    alert("Inicio de sesión exitoso.");

    window.location.href = "index.html";
}
aaron