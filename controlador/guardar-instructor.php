<?php 
include ('../confi/conexion.php');
session_start();
$correo=$_SESSION['ema'];

if (!isset($correo)) {
    header("location:../index.php");
}
$rol=$_SESSION['rol'];
if ($rol == 2) {
    header('location:../horarios.php');
}

// 1. Recibir datos básicos
$id_ins = $_GET['instructor'];  // ID del instructor
$ins = $_POST['ins'];
$ficha_ = $_POST['f_c'];
$checkdia = $_POST['checkdia2'];
$checkhora = $_POST['checkhora2'];
$amb = $_POST['idAB'];
$descripcion = $_POST['descrip'];
$observaciones = $_POST['observaciones'];
$Periodo = $_POST['perd_cur'];
$año = $_POST['year_cur'];

// 2. OBTENER TRIMESTRE ACTIVO
$qTrim = mysqli_query($conn, 
    "SELECT id_T 
     FROM tb_trimestre 
     WHERE estatus_trim_H = 0 
     LIMIT 1"
);

if (mysqli_num_rows($qTrim) == 0) {
    echo "<script>
        alert('❌ No existe un trimestre activo. Activa uno antes de continuar.');
        window.location='../vista/admin/horarios_ins.php?instructor=$id_ins';
    </script>";
    exit();
}

$rowTrim = mysqli_fetch_assoc($qTrim);
$tbTrim = $rowTrim['id_T']; // ← trimestre activo detectado

// 3. POR DEFECTO NO VAMOS A LIMITAR HORAS
//    PERMITIR QUE SIEMPRE SE GUARDEN HORARIOS

foreach ($checkdia as $dia) {
    foreach ($checkhora as $hora) {

        $query = "INSERT INTO horarios
        (id_hora, dia, ficha, instructor, hora, id_ambiente, horas_instructor, id_trim_fch, descripcion, observaciones, period_fk, año_fk)
        VALUES (
            NULL,
            '$dia',
            '$ficha_',
            '$id_ins',
            '$hora',
            '$amb',
            '2',
            '$tbTrim',
            '$descripcion',
            '$observaciones',
            '$Periodo',
            '$año'
        )";

        mysqli_query($conn, $query) or die(mysqli_error($conn));
    }
}

// 4. Confirmación final
echo "<script>
    alert('✅ Horario creado correctamente.');
    window.location='../vista/admin/horarios_ins.php?instructor=$id_ins';
</script>";
exit();
?>
