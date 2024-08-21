document.addEventListener("DOMContentLoaded", function () {
    // Defina a data final da contagem regressiva
    const countdownDate = new Date("Nov 04, 2024 00:00:00").getTime();

    // Atualiza o temporizador a cada segundo
    const timerInterval = setInterval(function() {
        // Data e hora atuais
        const now = new Date().getTime();

        // Distância entre a data atual e a data de contagem regressiva
        const distance = countdownDate - now;

        // Cálculos de dias, horas, minutos e segundos
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Exibe os valores calculados nos elementos HTML correspondentes
        document.getElementById("days").textContent = days.toString().padStart(2, '0');
        document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
        document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');

        // Se a contagem regressiva terminar, parar o intervalo
        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("countdown").textContent = "Tempo Esgotado!";
        }
    }, 1000);
});
