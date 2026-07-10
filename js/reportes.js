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