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
    <title>Perfil</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #95f8ff, #5A89E8);
            padding:20px;
            overflow: hidden;
        }

        .credencial {
            width: 580px;
            background: #fff;
            border: 2px solid #333;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .credencial img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #30279C;
        }

        .credencial h2 {
            margin: 10px 0;
            font-size: 1.5em;
            color: #30279C;
        }

        .credencial p {
            margin: 5px 0;
            font-size: 1em;
            color: #333;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            position: relative;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 0px;
        }

        #customers th {
            border: none;
            padding: 2px;
            font-weight: normal;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #30279C;
            color: white;
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            width: 80px;
            height: auto;
            margin-left: 20px;
            margin-right: 20px;
        }

        .superpose-images {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .superpose-images img {
            width: 60px;
            height: 60px;
        }

        .button {
            position: relative;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            padding-block: 0.5rem;
            padding-inline: 1.25rem;
            background-color: rgb(0 107 179);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            gap: 10px;
            font-weight: bold;
            border: 3px solid #ffffff4d;
            outline: none;
            overflow: hidden;
            font-size: 15px;
        }

        .icon {
            width: 24px;
            height: 24px;
            transition: all 0.3s ease-in-out;
        }

        .button:hover {
            transform: scale(1.05);
            border-color: #fff9;
        }

        .button:hover .icon {
            transform: translate(4px);
        }

        .button:hover::before {
            animation: shine 1.5s ease-out infinite;
        }

        .button::before {
            content: "";
            position: absolute;
            width: 100px;
            height: 100%;
            background-image: linear-gradient(
                120deg,
                rgba(255, 255, 255, 0) 30%,
                rgba(255, 255, 255, 0.8),
                rgba(255, 255, 255, 0) 70%
            );
            top: 0;
            left: -100px;
            opacity: 0.6;
        }

        @keyframes shine {
            0% {
                left: -100px;
            }

            60% {
                left: 100%;
            }

            to {
                left: 100%;
            }
        }
            /* estilos del cerrar sesion */
        .cerrar_sesion {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 9999px;
            font-weight: bold;
        }

        .cerrar_sesion:hover {
            background-color: #c82333;
        }
            /*ACA ESTA EL GIL/CRACK DEL MEDIA QUE HACE QUE LA CREDENCIAL SEA ACEPTABLE EN CELULARES, BODY PUTO*/

        @media (max-width: 700px) {
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #95f8ff, #5A89E8);
            padding: 20px;
            flex-direction: column;
            align-items: center;
            overflow-y: hidden;
        }            

           
        }

        @media (max-width: 700px) {
            .credencial {
                width: 100%;
                height: auto;
                padding: 10px;
            }

            .superpose-images img {
                width: 30px;
            }
            .superpose img {
                width: 30px;
            }
            .logo-container img {
                width: 60px;
            }
        }
    </style>

</head>
<body>
    
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
                Boleto Estudiantil Digital
            </th>
        </tr>
    </table><br>

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
                    <img style="width: 64px;height: 63px;;" src="../../public/img/eest1.png"  alt="">
                   
                </div><br>
                
            </th>
        </tr>
    </table><br>

</div> 
<br>
<section class="top-buttons buttons">
  <div class="container">
    <button id="descargarBtn" class="button"> Descargar <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
    <path clip-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" fill-rule="evenodd"></path>
  </svg>
</button><br><br>
<button class="cerrar_sesion">Cerrar Sesion</button></div>
</section>

<section id="qrcode">

</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.3.2/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="../../public/js/jquery.js"></script>
<script src="../../public/js/buttons.js"></script>
<script src="../../public/js/generador_qr.js"></script>

</body>
</html>