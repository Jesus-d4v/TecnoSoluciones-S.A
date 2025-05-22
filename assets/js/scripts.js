 //funcion del ojo para mostrar y ocultar la contraseña
document
    .getElementById("togglePassword")
    .addEventListener("click", function () {
        const passwordInput = document.getElementById("password");
        const icono = document.getElementById("icono-ojo");
        this.style.transform = "scale(1.2)";
        setTimeout(() => (this.style.transform = "scale(1)"), 100);

        const mostrar = passwordInput.type === "password";
        passwordInput.type = mostrar ? "text" : "password";

        icono.classList.toggle("bi-eye");
        icono.classList.toggle("bi-eye-slash");
    });

    