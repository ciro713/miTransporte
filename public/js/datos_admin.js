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

$(function(){
    $.ajax({
        url: '../src/models/admin.php',
        type: 'GET',
        success: function(res){
            if (res.status === 'success'){
                const usuario = `${res.usuario}`;
                const alumns_habilitados = `${res.habilitados}`;
                const alumns_habilitados_user = `${res.habilitados_user}`;
                const alumns_no_habilitados = `${res.no_habilitados}`;

                $(".name").html(`${usuario}`);
                
                if(`${alumns_habilitados}` == 0){
                    document.getElementById('total-credentials').textContent = 0;
                    console.log("no hay credenciales");
                }else if(`${alumns_habilitados}` == 'undefined'){
                    document.getElementById('total-credentials').textContent = 0;
                    console.log("no hay credenciales");
                }else{
                    animateCounter('total-credentials', 0, `${alumns_habilitados}`, 2000); 
                    console.log("hay credenciales");
                }

                if(`${alumns_habilitados_user}` == 0){
                    document.getElementById('school-credentials').textContent = 0;
                    console.log("no hay credenciales de esta escuela");
                }else if(`${alumns_habilitados_user}` == 'undefined'){
                    document.getElementById('school-credentials').textContent = 0;
                    console.log("no hay credenciales de esta escuela");
                }else{
                    animateCounter('school-credentials', 0, `${alumns_habilitados_user}`, 2000);
                    console.log("hay credenciales de esta escuela");
                }
            
                const ctx = document.getElementById('usersChart').getContext('2d');
                const data = {
                    labels: [/*'Usuarios Eliminados', */'Usuarios a Confirmar', 'Usuarios Confirmados'],
                    datasets: [{
                        data: [/*10,*/ `${alumns_no_habilitados}`, `${alumns_habilitados_user}`],
                        backgroundColor: ['#4087ff', '#040fd9']
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

            } else {
                // Muestra un mensaje de error
                console.log(res.message);
            }
        }
    })
})