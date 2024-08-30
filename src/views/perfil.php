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
                <div class="credencial" id="credencial">
                <?php
                $id_usuario = $_SESSION['id_usuario'];

                $sql = "SELECT * FROM estudiante WHERE DNI='$id_usuario'";
                $result = mysqli_query($conexion, $sql);
                ?>

                <table id="customers">
                    <tr>
                        <th class="logo-container">
                            <img style=" border-radius:30%;" src="../../public/img/muni.png" alt="Logo Muni">
                            <p style="font-size: 1.3em; color: white;" >Boleto Estudiantil Digital</p>
                                <section class="carousel-qr" id="qrcode" style="float: rgiht;">
                            
                                </section>   
                        </th>
                    </tr>

                </table>
                <br>

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
                    
                    echo "<main class='container'>
                            <section class='seccion-1'>
                                <img src='".$row['img_estudiante']."' class='foto-perfil' />
                                <h2>".$row['nombre_apellido']."</h2>
                            </section>
                            </section>
                                        <b><p>DNI:</b> ".$dni."</p></b>
                                        <b><p>Establecimiento Educativo:</b> ".$establecimiento."</p>
                                        <b><p>Viaja Desde:</b> ".$localidad_desde."</p>
                                        <b><p>Hasta:</b> ".$localidad_hasta."</p>
                                    <b> <p>Direccion:</b> ".$row['direccion']."</p>
                                    </section>
                        </main>";
                }
                ?>

                <table id="customers">
                    <tr>
                        <th>
                            <div class="superpose-images">
                                <img src="../../public/img/cos.png" alt="">
                                <img src="../../public/img/cosyc.png" alt="">
                                <img src="../../public/img/cesop.png" alt="">
                            </div><br>
                            <div class="superpose">
                                <style>
                                    .superpose{
                                        text-align:right;
                                        width: 30px;
                                        height: 60px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: flex-start;
                                        gap: 10px;
                                        position: absolute;
                                        top: 15px;
                                        right: 80px;                
                                    }
                                </style>
                                <img style="width: 64px; height: 63px; border-radius: 50%;" src="../../public/img/eest1.png"  alt="">
                            
                            </div><br>
                            
                        </th>
                    </tr>
                </table><br>
                </div>
            </div>
            <div class="carousel-item">
            <section class="top-buttons buttons">
            <!-- Botones de descarga -->
            <section class="top-buttons buttons">
            <div class="container">
                <button id="descargarPngBtn" class="button">Descargar PNG</button><br><br>
                <button id="descargarPdfBtn" class="button">Descargar PDF</button><br><br>
                <button class="cerrar_sesion">Cerrar Sesion</button></div>
                </div>
            </section>
            </div>
            <div class="carousel-item">
                <section class="carousel-qr" id="qrcode">

                </section>
            </div>
        </div>
        <button class="prev" onclick="prevSlide()">&#10094;</button>
        <button class="next" onclick="nextSlide()">&#10095;</button>
    </div>

    <script>
  // Función para descargar como PNG
  $('#descargarPngBtn').click(function() {
    html2canvas(document.querySelector('#credencial')).then(canvas => {
      const link = document.createElement('a');
      link.href = canvas.toDataURL('image/png');
      link.download = 'credencial.png';
      link.click();
    });
  });

  // Función para descargar como PDF
  $('#descargarPdfBtn').click(function() {
    html2canvas(document.querySelector('#credencial')).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF();
      const imgWidth = 190; // Ajusta el ancho para PDF
      const imgHeight = (canvas.height * imgWidth) / canvas.width;
      pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
      pdf.save('credencial.pdf');
    });
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

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> c302d47acf7054722bd213eb6161e622b5199b3a
