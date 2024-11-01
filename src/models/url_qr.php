<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');

    $id_usuario = $_SESSION['id_usuario'];

    echo json_encode($id_usuario);
?>