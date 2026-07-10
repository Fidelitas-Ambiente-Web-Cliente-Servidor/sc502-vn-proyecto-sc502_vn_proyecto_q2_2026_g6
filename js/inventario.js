document.addEventListener('DOMContentLoaded', () => {
    
    const contenedorTabla = document.querySelector('.tabla');
    const tablaCuerpo = document.querySelector('.tabla tbody');
    const btnGuardar = document.querySelector('.formulario button');

    if (contenedorTabla && tablaCuerpo) {
        const inputBusqueda = document.createElement('input');
        inputBusqueda.setAttribute('type', 'text');
        inputBusqueda.setAttribute('placeholder', 'Buscar recursos...');
        inputBusqueda.style.marginBottom = '20px';
        
        contenedorTabla.insertBefore(inputBusqueda, contenedorTabla.querySelector('table'));

        inputBusqueda.addEventListener('keyup', function() {
            const termino = this.value.toLowerCase();
            const filas = tablaCuerpo.querySelectorAll('tr');

            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();
                fila.style.display = textoFila.includes(termino) ? '' : 'none';
            });
        });
    }

    if (btnGuardar && tablaCuerpo) {
        btnGuardar.addEventListener('click', (e) => {
            e.preventDefault(); 
            
            const inputs = document.querySelectorAll('.formulario input, .formulario select');
            let camposCompletos = true;
            let datosFila = [];

            const conteoFilas = tablaCuerpo.querySelectorAll('tr').length + 1;
            datosFila.push(conteoFilas);

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    camposCompletos = false;
                }
                datosFila.push(input.value);
            });

            if (!camposCompletos) {
                alert("Por favor, complete todos los campos para registrar el recurso.");
                return;
            }

            const nuevaFila = document.createElement('tr');
            datosFila.forEach(dato => {
                const celda = document.createElement('td');
                celda.textContent = dato;
                nuevaFila.appendChild(celda);
            });

            tablaCuerpo.appendChild(nuevaFila);

            inputs.forEach(input => {
                if (input.tagName === 'INPUT') input.value = '';
                if (input.tagName === 'SELECT') input.selectedIndex = 0;
            });

            alert("Recurso guardado con éxito.");
        });
    }
});
aaron