document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscarRecurso");
    const tabla = document.getElementById("tablaRecursos");

    if (!buscador || !tabla) {
        return;
    }

    buscador.addEventListener("input", function () {
        const termino = buscador.value.trim().toLowerCase();
        const filas = tabla.querySelectorAll("tr");

        filas.forEach(function (fila) {
            const contenido = fila.textContent.toLowerCase();

            fila.style.display = contenido.includes(termino)
                ? ""
                : "none";
        });
    });
});