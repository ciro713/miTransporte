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

document.addEventListener('DOMContentLoaded', () => {
    const alertasBtn = document.getElementById('alertasBtn');
    const noticiasBtn = document.getElementById('noticiasBtn');
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.querySelector('.sidebar');
    const popup = document.getElementById('popup');
    const closePopup = document.getElementById('closePopup');
    const popupTitle = document.getElementById('popupTitle');
    const alertForm = document.getElementById('alertForm');
    const newsForm = document.getElementById('newsForm');

    // Función para mostrar la ventana emergente con el formulario correspondiente
    function showPopup(title, formToShow) {
        popupTitle.textContent = title;
        alertForm.style.display = 'none';
        newsForm.style.display = 'none';
        formToShow.style.display = 'block';
        popup.style.display = 'flex';

        // Si el ancho de la ventana es pequeño y se abre una alerta o noticia, se cierra el sidebar
        if (window.innerWidth <= 800) {
            sidebar.classList.remove('open');
        }
    }

    // Evento click para el botón de Alertas
    alertasBtn.addEventListener('click', () => {
        showPopup('Crear Alerta', alertForm);
    });

    // Evento click para el botón de Noticias
    noticiasBtn.addEventListener('click', () => {
        showPopup('Crear Noticia', newsForm);
    });

    // Evento click para el botón de toggle del sidebar
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    // Evento click para cerrar la ventana emergente
    closePopup.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    // Evento click fuera de la ventana emergente para cerrarla
    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });

    // Evento click en los enlaces del menú para cerrar el sidebar en dispositivos móviles
    const navLinks = document.querySelectorAll('.nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 800) {
                sidebar.classList.remove('open');
            }
        });
    });
});