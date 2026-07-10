document.addEventListener("DOMContentLoaded", function () {
    actualizarResumen();
    configurarBotones();
});

/**
 * Lee los valores de la tabla y calcula los totales generales.
 */
function actualizarResumen() {
    const filas = document.querySelectorAll("tbody tr");
    const tarjetas = document.querySelectorAll(".card p");

    let totalRecursos = 0;
    let totalDisponibles = 0;
    let totalPrestados = 0;
    let totalMantenimiento = 0;

    filas.forEach(function (fila) {
        const columnas = fila.querySelectorAll("td");

        if (columnas.length < 5) {
            return;
        }

        totalRecursos += convertirNumero(columnas[1].textContent);
        totalDisponibles += convertirNumero(columnas[2].textContent);
        totalPrestados += convertirNumero(columnas[3].textContent);
        totalMantenimiento += convertirNumero(columnas[4].textContent);
    });

    if (tarjetas.length >= 4) {
        tarjetas[0].textContent = totalRecursos;
        tarjetas[1].textContent = totalDisponibles;
        tarjetas[2].textContent = totalPrestados;
        tarjetas[3].textContent = totalMantenimiento;
    }
}

/**
 * Convierte el contenido de una celda en número.
 */
function convertirNumero(valor) {
    const numero = Number(valor.trim());

    if (Number.isNaN(numero)) {
        return 0;
    }

    return numero;
}

/**
 * Agrega las funciones a los botones del reporte.
 */
function configurarBotones() {
    const botones = document.querySelectorAll(".botones button");

    if (botones.length < 3) {
        console.error("No se encontraron todos los botones de reportes.");
        return;
    }

    botones[0].addEventListener("click", exportarPDF);
    botones[1].addEventListener("click", exportarExcel);
    botones[2].addEventListener("click", imprimirReporte);
}

/**
 * Abre la ventana de impresión.
 * El usuario puede seleccionar "Guardar como PDF".
 */
function exportarPDF() {
    const confirmar = confirm(
        'Se abrirá la ventana de impresión. Seleccione "Guardar como PDF".'
    );

    if (!confirmar) {
        return;
    }

    window.print();
}

/**
 * Exporta la tabla como archivo CSV compatible con Excel.
 */
function exportarExcel() {
    const tabla = document.querySelector("table");

    if (!tabla) {
        alert("No se encontró la tabla del reporte.");
        return;
    }

    const filas = tabla.querySelectorAll("tr");
    const contenidoCSV = [];

    filas.forEach(function (fila) {
        const columnas = fila.querySelectorAll("th, td");
        const valores = [];

        columnas.forEach(function (columna) {
            let texto = columna.textContent.trim();

            texto = texto.replace(/"/g, '""');

            valores.push('"' + texto + '"');
        });

        contenidoCSV.push(valores.join(";"));
    });

    const encabezadoUTF8 = "\uFEFF";
    const archivo = new Blob(
        [encabezadoUTF8 + contenidoCSV.join("\n")],
        {
            type: "text/csv;charset=utf-8;"
        }
    );

    const enlaceDescarga = document.createElement("a");
    const urlArchivo = URL.createObjectURL(archivo);

    enlaceDescarga.href = urlArchivo;
    enlaceDescarga.download = generarNombreArchivo("reporte_inventario", "csv");

    document.body.appendChild(enlaceDescarga);
    enlaceDescarga.click();
    document.body.removeChild(enlaceDescarga);

    URL.revokeObjectURL(urlArchivo);

    alert("El reporte fue exportado correctamente.");
}

/**
 * Imprime el contenido del reporte.
 */
function imprimirReporte() {
    window.print();
}

/**
 * Genera un nombre de archivo con la fecha actual.
 */
function generarNombreArchivo(nombre, extension) {
    const fecha = new Date();

    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");

    return `${nombre}_${anio}-${mes}-${dia}.${extension}`;
}
aaron