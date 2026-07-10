<<<<<<< Updated upstream
document.addEventListener('DOMContentLoaded', () => {
    
    const tarjetas = document.querySelectorAll('.card p');
    
    tarjetas.forEach(tarjeta => {
        const valorFinal = parseInt(tarjeta.innerText);
        let valorActual = 0;
        const duracion = 1200; 
        const incremento = valorFinal / (duracion / 16); 

        tarjeta.innerText = '0';

        const animarContador = () => {
            valorActual += incremento;
            if (valorActual < valorFinal) {
                tarjeta.innerText = Math.ceil(valorActual);
                requestAnimationFrame(animarContador);
            } else {
                tarjeta.innerText = valorFinal; 
            }
        };

        animarContador();
    });

    const botones = document.querySelectorAll('.botones button');
    
    botones.forEach(boton => {
        boton.addEventListener('click', function() {
            const accion = this.innerText;
            
            alert(`Ejecutando acción: ${accion}\n\nNota: En proceso...`);
        });
    });
});
=======
document.addEventListener("DOMContentLoaded", function () {
    actualizarResumen();

    configurarBotones();
});

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

        totalRecursos += convertirNumero(
            columnas[1].textContent
        );

        totalDisponibles += convertirNumero(
            columnas[2].textContent
        );

        totalPrestados += convertirNumero(
            columnas[3].textContent
        );

        totalMantenimiento += convertirNumero(
            columnas[4].textContent
        );
    });

    if (tarjetas.length >= 4) {
        tarjetas[0].textContent = totalRecursos;

        tarjetas[1].textContent = totalDisponibles;

        tarjetas[2].textContent = totalPrestados;

        tarjetas[3].textContent = totalMantenimiento;
    }
}

function convertirNumero(valor) {
    const numero = Number(valor.trim());

    if (Number.isNaN(numero)) {
        return 0;
    }

    return numero;
}

function configurarBotones() {
    const botones = document.querySelectorAll(
        ".botones button"
    );

    if (botones.length < 3) {
        console.error(
            "No se encontraron todos los botones de reportes."
        );

        return;
    }

    botones[0].addEventListener(
        "click",
        exportarPDF
    );

    botones[1].addEventListener(
        "click",
        exportarExcel
    );

    botones[2].addEventListener(
        "click",
        imprimirReporte
    );
}

function exportarPDF() {
    const confirmar = confirm(
        'Se abrirá la ventana de impresión. Seleccione "Guardar como PDF".'
    );

    if (!confirmar) {
        return;
    }

    window.print();
}

function exportarExcel() {
    const tabla = document.querySelector("table");

    if (!tabla) {
        alert("No se encontró la tabla del reporte.");

        return;
    }

    const filas = tabla.querySelectorAll("tr");

    const contenidoCSV = [];

    filas.forEach(function (fila) {
        const columnas = fila.querySelectorAll(
            "th, td"
        );

        const valores = [];

        columnas.forEach(function (columna) {
            let texto = columna.textContent.trim();

            texto = texto.replace(/"/g, '""');

            valores.push('"' + texto + '"');
        });

        contenidoCSV.push(
            valores.join(";")
        );
    });

    const encabezadoUTF8 = "\uFEFF";

    const archivo = new Blob(
        [
            encabezadoUTF8 +
            contenidoCSV.join("\n")
        ],
        {
            type: "text/csv;charset=utf-8;"
        }
    );

    const enlaceDescarga =
        document.createElement("a");

    const urlArchivo =
        URL.createObjectURL(archivo);

    enlaceDescarga.href = urlArchivo;

    enlaceDescarga.download =
        generarNombreArchivo(
            "reporte_inventario",
            "csv"
        );

    document.body.appendChild(
        enlaceDescarga
    );

    enlaceDescarga.click();

    document.body.removeChild(
        enlaceDescarga
    );

    URL.revokeObjectURL(urlArchivo);

    alert(
        "El reporte fue exportado correctamente."
    );
}

function imprimirReporte() {
    window.print();
}

function generarNombreArchivo(nombre, extension) {
    const fecha = new Date();

    const anio = fecha.getFullYear();

    const mes = String(
        fecha.getMonth() + 1
    ).padStart(2, "0");

    const dia = String(
        fecha.getDate()
    ).padStart(2, "0");

    return (
        nombre +
        "_" +
        anio +
        "-" +
        mes +
        "-" +
        dia +
        "." +
        extension
    );
}
>>>>>>> Stashed changes
