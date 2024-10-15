<?php

include("email.php");
enviarCorreo(
    "facundoaragon05@hotmail.com",
    "miTransporte",
    "anachuchu309@gmail.com",
    "Su credencial ha sido habilitada",

    "

    <h1 style='text-align: center;'>miTransporte</h1>
    <img src='https://www.tecnica1lacosta.edu.ar/mitransporte/public/img/logo.png' alt='Logo' />
    <h3 style='text-align: center;'>Su credencial ha sido habilitada, ya está apto para poder iniciar sesión y utilizar su credencial</h3>
    <h4 style='text-align: center;'>¡Gracias por su espera!</h4>
    <h4 style='text-align: center;'>¡Visita nuestra pagina web!</h4>
    <center>
    <a href='https://www.tecnica1lacosta.edu.ar/mitransporte/' style='background-color: #007bff; color: white; padding: 10px 20px; 
        text-decoration: none; display: inline-block; border-radius: 5px; align-items: center'>Ingresar</a>
    </center>
    <footer style='text-align: center; font-size: 12px; color: #777;'>
        <p>© 2024 miTransporte. Todos los derechos reservados.</p>
    </footer>
    
    "
);