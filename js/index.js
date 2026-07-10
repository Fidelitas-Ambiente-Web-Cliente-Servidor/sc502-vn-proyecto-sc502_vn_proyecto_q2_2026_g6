<<<<<<< Updated upstream
document.addEventListener('DOMContentLoaded', () => {
    
    const tarjetas = document.querySelectorAll('.tarjeta');
    
    tarjetas.forEach(tarjeta => {
        tarjeta.style.opacity = '0';
        tarjeta.style.transform = 'translateY(40px)';
        tarjeta.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
    });

    setTimeout(() => {
        tarjetas.forEach((tarjeta, index) => {
            setTimeout(() => {
                tarjeta.style.opacity = '1';
                tarjeta.style.transform = 'translateY(0)';
            }, index * 200); 
        });
    }, 150);

});
=======
document.addEventListener("DOMContentLoaded", function () {
    configurarTarjetas();
    verificarSesion();
});

function configurarTarjetas() {
    const tarjetas = document.querySelectorAll(".tarjeta");

    const rutas = [
        "inventario.html",
        "prestamos.html",
        "mantenimiento.html",
        "reportes.html"
    ];

    tarjetas.forEach(function (tarjeta, indice) {
        tarjeta.style.cursor = "pointer";

        tarjeta.addEventListener("click", function () {
            window.location.href = rutas[indice];
        });
    });
}

function verificarSesion() {
    const usuarioGuardado = localStorage.getItem("usuarioActivo");

    const enlaceSesion = document.querySelector('a[href="login.html"]');

    const tituloInicio = document.querySelector(".inicio h2");

    if (!usuarioGuardado) {
        return;
    }

    let usuario;

    try {
        usuario = JSON.parse(usuarioGuardado);
    } catch (error) {
        console.error("No fue posible leer la sesión:", error);

        localStorage.removeItem("usuarioActivo");

        return;
    }

    if (usuario.nombre && tituloInicio) {
        tituloInicio.textContent =
            "Bienvenido, " +
            usuario.nombre +
            " - Gestión Integral de Recursos";
    }

    if (enlaceSesion) {
        enlaceSesion.textContent = "Cerrar Sesión";

        enlaceSesion.href = "#";

        enlaceSesion.addEventListener("click", cerrarSesion);
    }
}

function cerrarSesion(evento) {
    evento.preventDefault();

    const confirmar = confirm("¿Desea cerrar la sesión?");

    if (!confirmar) {
        return;
    }

    localStorage.removeItem("usuarioActivo");

    window.location.href = "login.html";
}
>>>>>>> Stashed changes
