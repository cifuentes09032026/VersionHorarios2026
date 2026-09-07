<?php

    function insertar_datos($competencias,$fecha_ini,$fecha_fin,$instructor,$crearCompetencia){
        global $conn;
        
        $crearCompetencia = $_GET['ubP'];

        $sentencia = "INSERT INTO `competencias`(`id`, `competencias`, `fecha_ini`, `fecha_fin`, `instructor`,`Ficha_id`)
        VALUES (null,'$competencias','$fecha_ini','$fecha_fin','$instructor','$crearCompetencia')";
        
        $ejecutar = mysqli_query($conn,$sentencia);
        return $ejecutar;


}

?>