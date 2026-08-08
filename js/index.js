document.addEventListener("DOMContentLoaded", function () {
    configurarTarjetas();
});

function configurarTarjetas() {
    const tarjetas = document.querySelectorAll(".tarjeta");

    const rutas = [
        "index.php?controller=inventario&action=index",
        "index.php?controller=prestamos&action=index",
        "index.php?controller=mantenimiento&action=index",
        "index.php?controller=reportes&action=index"
    ];

    tarjetas.forEach(function (tarjeta, indice) {
        tarjeta.style.cursor = "pointer";

        tarjeta.addEventListener("click", function () {
            window.location.href = rutas[indice];
        });
    });
}