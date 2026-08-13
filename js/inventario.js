document.addEventListener('DOMContentLoaded', () => {
    const contenedorTabla = document.querySelector('.tabla');
    const tablaCuerpo = document.querySelector('.tabla tbody');

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
});
