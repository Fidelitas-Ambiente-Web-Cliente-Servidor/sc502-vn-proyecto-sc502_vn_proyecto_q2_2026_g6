document.addEventListener("DOMContentLoaded", function () {
    const botonPDF = document.getElementById("exportarPDF");
    const botonExcel = document.getElementById("exportarExcel");
    const botonImprimir = document.getElementById("imprimirReporte");

    if (botonPDF) {
        botonPDF.addEventListener("click", exportarPDF);
    }

    if (botonExcel) {
        botonExcel.addEventListener("click", exportarExcel);
    }

    if (botonImprimir) {
        botonImprimir.addEventListener("click", imprimirReporte);
    }
});

function exportarPDF() {
    alert(
        'En la ventana de impresión seleccione "Guardar como PDF".'
    );

    window.print();
}

function exportarExcel() {
    const tabla = document.getElementById("tablaReporte");

    if (!tabla) {
        alert("No se encontró la tabla del reporte.");
        return;
    }

    const filas = tabla.querySelectorAll("tr");
    const contenido = [];

    filas.forEach(function (fila) {
        const columnas = fila.querySelectorAll("th, td");
        const valores = [];

        columnas.forEach(function (columna) {
            let texto = columna.textContent.trim();

            texto = texto.replace(/"/g, '""');
            valores.push('"' + texto + '"');
        });

        contenido.push(valores.join(";"));
    });

    const archivo = new Blob(
        ["\uFEFF" + contenido.join("\n")],
        {
            type: "text/csv;charset=utf-8;"
        }
    );

    const enlace = document.createElement("a");
    const url = URL.createObjectURL(archivo);

    enlace.href = url;
    enlace.download = generarNombreArchivo();

    document.body.appendChild(enlace);
    enlace.click();
    enlace.remove();

    URL.revokeObjectURL(url);
}

function imprimirReporte() {
    window.print();
}

function generarNombreArchivo() {
    const fecha = new Date();
    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");

    return `reporte_inventario_${anio}-${mes}-${dia}.csv`;
}