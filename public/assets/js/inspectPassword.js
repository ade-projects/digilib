// const togglePassword = document.querySelector(".togglePassword");
// const password = document.querySelector(".password");

// togglePassword.addEventListener("click", function (e) {
//     const type =
//         password.getAttribute("type") === "password" ? "text" : "password";
//     password.setAttribute("type", type);

//     this.classList.toggle("fa-eye-slash");
// });

document.querySelectorAll(".toggle-password").forEach((item) => {
    item.addEventListener("click", function () {
        // Cari input yang ditargetkan oleh data-target (misal #password atau #password_confirmation)
        const targetId = this.getAttribute("data-target");
        const input = document.querySelector(targetId);

        // Toggle type
        const type =
            input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);

        // Toggle icon
        this.classList.toggle("fa-eye-slash");
    });
});
