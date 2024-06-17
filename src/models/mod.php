<?php
    include('../config/db-connection.php');
//include('../db-connection.php');

$query="SELECT * FROM `estudiante` WHERE `nombre_apellido` LIKE '%".$_POST["dato"]."%'";
$res=mysqli_query($conexion,$query);


while($row=mysqli_fetch_array($res)){
    echo '<tr><td>'.$row['DNI'].'</td>
    <td>'.$row['nombre_apellido'].'</td>
    <td>'.$row['estado_credencial'].'</td>
    </tr>'; 

};



?>