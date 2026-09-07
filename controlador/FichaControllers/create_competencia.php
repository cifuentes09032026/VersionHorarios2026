<?php
include("../../confi/conexion.php");
session_start();

$correo = $_SESSION['ema'];

if (!isset($correo)) {
    header("location:../../index.php");
}
$rol = $_SESSION['rol'];
if ($rol == 2) {
    header('location:../../horarios.php');
}
$idfi = $_GET['ubP'];
$competencias_programa = $_POST['competencias'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$instructor = $_POST['instructor'];

$dataCode = count($competencias_programa);
if ($dataCode > 0) {
    for ($i = 0; $i < $dataCode; $i++) {
        $sqlCode  = ("SELECT *  FROM competencias WHERE competencias='$competencias_programa[$i]' ");
        $queryCode      = mysqli_query($conn, $sqlCode);
        if (mysqli_num_rows($queryCode) > 0) {
        } else {
            $queryInsertCode = "INSERT INTO `competencias` (`id`, `competencias`, 
            `fecha_ini`, `fecha_fin`,`instructor`,`Ficha_id`) 
            VALUES (null,'$competencias_programa[$i]', 
            '$fecha_inicio[$i]', '$fecha_fin[$i]','$instructor[$i]','$idfi');";
            $resultado = mysqli_query($conn, $queryInsertCode);
        }
    }


        header("location:../../vista/competencias-resultados.php?ubP=$idfi");
    }
    ?>