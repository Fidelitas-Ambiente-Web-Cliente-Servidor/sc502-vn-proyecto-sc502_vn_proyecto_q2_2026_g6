document.addEventListener("DOMContentLoaded", function () {
    const loginBox = document.querySelector(".login-box");

    if (loginBox) {
        loginBox.style.opacity = "0";
        loginBox.style.transform = "translateY(30px)";
        loginBox.style.transition = "opacity 0.6s ease-out, transform 0.6s ease-out";

        setTimeout(function () {
            loginBox.style.opacity = "1";
            loginBox.style.transform = "translateY(0)";
        }, 100);
    }

    const formulario = document.querySelector(".login-box form");
    if (!formulario) return;

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

        validarCredenciales(usuario, contrasena, formulario);
    });
});

function validarCredenciales(usuario, contrasena, formulario) {
    const botonIngresar = formulario.querySelector('button[type="submit"]');
    const textoOriginal = botonIngresar ? botonIngresar.innerText : "";

    if (botonIngresar) {
        botonIngresar.innerText = "Validando credenciales...";
        botonIngresar.disabled = true;
    }

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

    setTimeout(function () {
        const usuarioEncontrado = usuariosPermitidos.find(function (registro) {
            return registro.usuario === usuario && registro.contrasena === contrasena;
        });

        if (!usuarioEncontrado) {
            alert("Usuario o contraseña incorrectos.");

            if (botonIngresar) {
                botonIngresar.innerText = textoOriginal;
                botonIngresar.disabled = false;
            }

            const contrasenaInput = document.getElementById("contrasena");
            if (contrasenaInput) {
                contrasenaInput.value = "";
                contrasenaInput.focus();
            }

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
    }, 1200);
}

