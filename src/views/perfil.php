<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/img/logo.ico" />
    <link rel="stylesheet" href="../../public/css/perfil.css">
    <title>Perfil</title>
</head>
<body>
    <div class="carousel" id="carousel">
        <div class="carousel-container">
            <div class="carousel-item">
                <div class="credential-card" id="credencial">
                    <?php
                    if(isset($_SESSION['id_usuario'])){
                        $id_usuario = $_SESSION['id_usuario'];
                    } else if(isset($_GET['id_usuario'])){
                        $id_usuario = $_GET['id_usuario'];
                    }

                    $sql = "SELECT * FROM estudiante WHERE DNI='$id_usuario'";
                    $result = mysqli_query($conexion, $sql);
                    ?>
                    <div class="header">
                        <section class="qr-code" id="qrcode">
                            
                        </section>
                        <h1 class="boleto">BOLETO ESTUDIANTIL 2024</h1>
                    </div>

                    <?php
                    while ($row = mysqli_fetch_assoc($result)){
                        $dni_query = $conexion->query("SELECT * FROM estudiante WHERE DNI = $row[DNI]");
                        $dni_resultado = $dni_query->fetch_assoc();
                        $dni = $dni_resultado['DNI'];

                        $establecimiento_query = $conexion->query("SELECT establecimiento_educativo FROM establecimiento_educativo WHERE id_establecimiento_educativo = $row[establecimiento_educativo]");
                        $establecimiento_resultado = $establecimiento_query->fetch_assoc();
                        $establecimiento = $establecimiento_resultado['establecimiento_educativo'];

                        $localidad_desde_query = $conexion->query("SELECT localidad FROM localidades WHERE id_localidad = $row[desde]");
                        $localidad_desde_resultado = $localidad_desde_query->fetch_assoc();
                        $localidad_desde = $localidad_desde_resultado['localidad'];

                        $localidad_hasta_query = $conexion->query("SELECT localidad FROM localidades WHERE id_localidad = $row[hasta]");
                        $localidad_hasta_resultado = $localidad_hasta_query->fetch_assoc();
                        $localidad_hasta = $localidad_hasta_resultado['localidad'];
                    ?>
                    <div class="main-content">
                            <img src="<?php echo $row['img_estudiante']; ?>" class="profile-image" />
                        <div class="info-section">
                            <h2 class="name"><?php echo $row['nombre_apellido']; ?></h2>
                            <p class="dni" style='padding-top: 5px;'>DNI: <?php echo $dni; ?></p>
                            <p class="dni">Establecimiento Educativo: <?php echo $establecimiento; ?></p>
                            <p class="address">Dirección: <?php echo $row['direccion']; ?></p>
                            <p class="address">Viaja Desde: <?php echo $localidad_desde; ?></p>
                            <p class="address">Hasta: <?php echo $localidad_hasta; ?></p>            
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                       <div class="logo"><img style="height:40px; weight:40px;" src="../../public/img/logomuni.png" alt="Logo Muni">
                       </div>
                    <div class="footer">
                        <p class="join">Ingreso: 2024</p>
                        <p class="expiry">Vencimiento: 12/2025</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">

                <div class="credential-card-reverse">
                    <div class="header-reverse">
                        <div class="logo-reverse"><img src="../../public/img/cos.png" alt="" style="border-radius: 50%;"></div>
                        <div class="logo-reverse"><img src="../../public/img/cesop.png" alt="" style="border-radius: 50%;"></div>
                        <div class="logo-reverse"><img src="../../public/img/cosyc.png" alt="" style="border-radius: 50%;"></div>
                    </div>
                    <div class="header-reverse">
                        <div class="logo-reverse-firma">
                            <img src="../../public/img/firma.png" alt=""></div>
                        <div class="logo-reverse-firma">
                            <img src="../../public/img/firma.png" alt=""></div>
                        <div class="logo-reverse-firma"><img src="../../public/img/firma.png" alt=""></div>
                    </div>
                    <div class="main-content-reverse">
                    <div class="info-section-reverse">
                        <br><br><br><br><br>
                    </div>  
                    </div>
                    <div class="footer">
                    <p class="join">Ingreso: 2024</p>
                    <p class="expiry">Vencimiento: 12/2025</p>
                    </div>
                </div>

            </div>

            <div class="carousel-item" id="contenedor-qr">
                <section class="carousel-qr" id="qrcode2">

                </section>

                <section class="top-buttons buttons">
                    <div class="container" style="padding-left: 50px;">
                        <button id="descargarBtn" class="button"> Descargar <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
                            <path clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" fill-rule="evenodd"></path></svg>
                        </button><br><br>
                        <button id="downloadPdfBtn" class="button">Descargar PDF</button><br><br>
                        <button class="cerrar_sesion">Cerrar Sesion</button>
                    </div>
                </section>
            </div>
        </div>
        <button class="prev" onclick="prevSlide()">&#10094;</button>
        <button class="next" onclick="nextSlide()">&#10095;</button>
    </div>

    <script>
        // Función para descargar como PNG con escala ajustada
        document.getElementById('descargarBtn')..onclick('click', function () {
            html2canvas(document.querySelector('#credencial')).then(canvas => {
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'credencial.png';
                link.click();
            });
        });

        // Función para descargar como PDF con escala ajustada
     document.getElementById("downloadPdfBtn").addEventListener("click", function() {
            const credencial = document.getElementById("credencial");
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            canvas.width = credencial.offsetWidth;
            canvas.height = credencial.offsetHeight;
            context.fillStyle = "#FFFFFF";
            context.fillRect(0, 0, canvas.width, canvas.height);
            context.drawImage(credencial, 0, 0, canvas.width, canvas.height);

            const pdfWindow = window.open("");
            pdfWindow.document.write(`
                <html>
                    <head><title>Credencial PDF</title></head>
                    <body>
                        <img src="${canvas.toDataURL("image/png")}" style="width:100%;"/>
                    </body>
                </html>
            `);
            pdfWindow.document.close();
        });
    </script>

    <script>
        let index = 0;

        function showSlide(i) {
            const slides = document.querySelector('.carousel-container');
            const totalSlides = document.querySelectorAll('.carousel-item').length;
            index = (i + totalSlides) % totalSlides;
            slides.style.transform = `translateX(${-index * 100}%)`;
        }

        function prevSlide() {
            showSlide(index - 1);
        }

        function nextSlide() {
            showSlide(index + 1);
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.3.2/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/buttons.js"></script>
    <script src="../../public/js/generador_qr.js"></script>

    <script>
        function checkOrientation() {
            if (window.innerHeight > window.innerWidth) {
                alert("Para una mejor experiencia, por favor, gira tu dispositivo a modo horizontal.");
            }
        }

        // Check orientation on load
        window.onload = checkOrientation;

        // Check orientation on resize
        window.onresize = checkOrientation;
    </script>
</body>
</html>
