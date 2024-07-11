// ANIMACION PARA EL SLIDEBAR

function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}

// ANIMACION PARA LOS CONTADORES

document.addEventListener('DOMContentLoaded', () => {
    function animateCounter(id, start, end, duration) {
        const element = document.getElementById(id);
        const range = end - start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));
        let current = start;
        const timer = setInterval(() => {
            current += increment;
            element.textContent = current;
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    animateCounter('total-credentials', 0, 1500, 2000);  // Ejemplo de 1500 credenciales
    animateCounter('school-credentials', 0, 1200, 2000); // Ejemplo de 1200 credenciales usadas

    const ctx = document.getElementById('usersChart').getContext('2d');
    const data = {
        labels: ['Usuarios Eliminados', 'Usuarios a Confirmar', 'Usuarios Confirmados'],
        datasets: [{
            data: [10, 20, 70], // Ejemplos de datos, ajusta según sea necesario
            backgroundColor: ['#ff5252', '#ffca28', '#66bb6a']
        }]
    };

    const usersChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});

function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}
