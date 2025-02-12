document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        let successBox = document.getElementById("success-message");
        let errorBox = document.getElementById("error-message");

        if (successBox) {
            successBox.style.opacity = "0";
            setTimeout(() => successBox.remove(), 500); // Remove após a animação
        }

        if (errorBox) {
            errorBox.style.opacity = "0";
            setTimeout(() => errorBox.remove(), 500);
        }
    }, 3000); // 3 segundos antes de sumir
});
