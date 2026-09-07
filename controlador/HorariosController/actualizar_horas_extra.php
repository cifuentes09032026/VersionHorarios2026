<?php
include('../../confi/conexion.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $horas = intval($_POST['horas']);
    $redirect = $_POST['redirect'] ?? '../../vista/horarios.php';

    $sql = "UPDATE horas_extra SET tipo='$tipo', horas=$horas WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: $redirect");
    exit;
}
