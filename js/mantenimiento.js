document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscarMantenimiento");
    const tabla = document.getElementById("tablaMantenimientos");

    if (!buscador || !tabla) {
        return;
    }

    buscador.addEventListener("input", function () {
        const termino = buscador.value.trim().toLowerCase();

        tabla.querySelectorAll("tr").forEach(function (fila) {
            const contenido = fila.textContent.toLowerCase();
            fila.style.display = contenido.includes(termino) ? "" : "none";
        });
    });
});
