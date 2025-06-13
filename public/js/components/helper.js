document.addEventListener("DOMContentLoaded", () => {
    function setupPasswordToggle(button, input, icon) {
        button.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.src = isPassword ? '../icons/open-eye.png' : '../icons/close-eye.png';
            icon.alt = isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña';
            button.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    }

    const singleToggle = document.getElementById('togglePassword');
    if (singleToggle) {
        const passwordInput = document.getElementById('password');
        const icon = singleToggle.querySelector('img');
        if (passwordInput && icon) {
            setupPasswordToggle(singleToggle, passwordInput, icon);
        }
    }

    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
        const targetId = button.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);
        const icon = button.querySelector('img');
        if (passwordInput && icon) {
            setupPasswordToggle(button, passwordInput, icon);
        }
    });

});
