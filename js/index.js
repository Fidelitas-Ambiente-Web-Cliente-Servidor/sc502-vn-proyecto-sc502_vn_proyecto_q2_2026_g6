document.addEventListener('DOMContentLoaded', () => {
    
    const tarjetas = document.querySelectorAll('.tarjeta');
    
    tarjetas.forEach(tarjeta => {
        tarjeta.style.opacity = '0';
        tarjeta.style.transform = 'translateY(40px)';
        tarjeta.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
    });

    setTimeout(() => {
        tarjetas.forEach((tarjeta, index) => {
            setTimeout(() => {
                tarjeta.style.opacity = '1';
                tarjeta.style.transform = 'translateY(0)';
            }, index * 200); 
        });
    }, 150);

});