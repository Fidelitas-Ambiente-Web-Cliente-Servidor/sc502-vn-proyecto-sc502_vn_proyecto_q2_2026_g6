document.addEventListener('DOMContentLoaded', () => {
    
    const loginBox = document.querySelector('.login-box');
    
    if (loginBox) {
        loginBox.style.opacity = '0';
        loginBox.style.transform = 'translateY(30px)';
        loginBox.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        
        setTimeout(() => {
            loginBox.style.opacity = '1';
            loginBox.style.transform = 'translateY(0)';
        }, 100);
    }

    const formulario = document.querySelector('.login-box form');
    
    if (formulario) {
        formulario.addEventListener('submit', (e) => {
            e.preventDefault(); 
            
            
            const usuarioInput = document.getElementById('usuario');
            const contrasenaInput = document.getElementById('contrasena');
            const botonIngresar = formulario.querySelector('button[type="submit"]');

            const usuario = usuarioInput.value.trim();
            const contrasena = contrasenaInput.value.trim();

            if (usuario === '' || contrasena === '') {
                alert('Por favor, complete todos los campos obligatorios.');
                return;
            }

            const textoOriginal = botonIngresar.innerText;
            botonIngresar.innerText = 'Validando credenciales...';
            botonIngresar.disabled = true;

            setTimeout(() => {
                
                if (usuario.toLowerCase() === 'admin' && contrasena === 'admin123') {
                    alert('¡Inicio de sesión exitoso!\nBienvenido al Sistema de Inventario.');
                    window.location.href = 'index.html';
                } else {
                    alert('Credenciales incorrectas.\n\nNota de prueba:\nPuedes ingresar usando:\nUsuario: admin\nContraseña: admin123');
                    
                    botonIngresar.innerText = textoOriginal;
                    botonIngresar.disabled = false;
                    
                    contrasenaInput.value = '';
                    contrasenaInput.focus();
                }

            }, 1200);
        });
    }
});