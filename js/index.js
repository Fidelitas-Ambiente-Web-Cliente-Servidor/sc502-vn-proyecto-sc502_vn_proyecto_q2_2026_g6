document.addEventListener("DOMContentLoaded", function () {
    configurarTarjetas();
    verificarSesion();
});

/**
 * Permite ingresar a los módulos haciendo clic
 * en cualquier parte de cada tarjeta.
 */
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

/**
 * Verifica si existe un usuario guardado
 * en el almacenamiento local del navegador.
 */
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
            "Bienvenido, " + usuario.nombre + " — Gestión Integral de Recursos";
    }

    if (enlaceSesion) {
        enlaceSesion.textContent = "Cerrar Sesión";
        enlaceSesion.href = "#";

        enlaceSesion.addEventListener("click", cerrarSesion);
    }
}

/**
 * Elimina la sesión guardada y dirige al login.
 */
function cerrarSesion(evento) {
    evento.preventDefault();

    const confirmar = confirm("¿Desea cerrar la sesión?");

    if (!confirmar) {
        return;
    }

    localStorage.removeItem("usuarioActivo");
    window.location.href = "login.html";
}
