<<<<<<< Updated upstream
document.addEventListener('DOMContentLoaded', () => {
    
    const loginBox = document.querySelector('.login-box');
    
    if (loginBox) {
        loginBox.style.opacity = '0';
        loginBox.style.transform = 'translateY(30px)';
        loginBox.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        
        setTimeout(() => {
            loginBox.style.opacity = '1';
            loginBox.style.transform = 'translateY(0)';
        }, 100);
    }

    const formulario = document.querySelector('.login-box form');
    
    if (formulario) {
        formulario.addEventListener('submit', (e) => {
            e.preventDefault(); 
            
            
            const usuarioInput = document.getElementById('usuario');
            const contrasenaInput = document.getElementById('contrasena');
            const botonIngresar = formulario.querySelector('button[type="submit"]');

            const usuario = usuarioInput.value.trim();
            const contrasena = contrasenaInput.value.trim();

            if (usuario === '' || contrasena === '') {
                alert('Por favor, complete todos los campos obligatorios.');
                return;
            }

            const textoOriginal = botonIngresar.innerText;
            botonIngresar.innerText = 'Validando credenciales...';
            botonIngresar.disabled = true;

            setTimeout(() => {
                
                if (usuario.toLowerCase() === 'admin' && contrasena === 'admin123') {
                    alert('¡Inicio de sesión exitoso!\nBienvenido al Sistema de Inventario.');
                    window.location.href = 'index.html';
                } else {
                    alert('Credenciales incorrectas.\n\nNota de prueba:\nPuedes ingresar usando:\nUsuario: admin\nContraseña: admin123');
                    
                    botonIngresar.innerText = textoOriginal;
                    botonIngresar.disabled = false;
                    
                    contrasenaInput.value = '';
                    contrasenaInput.focus();
                }

            }, 1200);
        });
    }
});
=======
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

    localStorage.setItem(
        "usuarioActivo",
        JSON.stringify(sesion)
    );

    alert("Inicio de sesión exitoso.");

    window.location.href = "index.html";
}
>>>>>>> Stashed changes
