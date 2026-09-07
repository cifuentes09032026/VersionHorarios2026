<?php
// controlador/guardar_ficha.php
include('../confi/conexion.php');
session_start();

$correo = $_SESSION['ema'] ?? null;
if (!isset($correo)) {
    header("location:../index.php");
    exit;
}
$rol = $_SESSION['rol'] ?? null;
if ($rol == 2) {
    header('location:../horarios.php');
    exit;
}

// --- Recuperar variables (seguras / con defaults)
$id_trim = isset($_SESSION['id_trim']) ? intval($_SESSION['id_trim']) : 0; // id del trimestre
$ficha_ = isset($_GET['f_h']) ? intval($_GET['f_h']) : 0;

$ins = isset($_POST['ins']) ? intval($_POST['ins']) : 0;
$checkdia = isset($_POST['checkdia']) ? $_POST['checkdia'] : array();
$checkhora = isset($_POST['checkhora']) ? $_POST['checkhora'] : array();

$amb = isset($_POST['idAB']) ? intval($_POST['idAB']) : 0;
$hora_i = 2; // valor existente en tu lógica
$descripcion = isset($_POST['descrip']) ? mysqli_real_escape_string($conn, $_POST['descrip']) : '';
$observaciones = isset($_POST['observaciones']) ? mysqli_real_escape_string($conn, $_POST['observaciones']) : '';
$periodo_fi = isset($_POST['perd_cur']) ? intval($_POST['perd_cur']) : 0;
$anio_fi = isset($_POST['year_cur']) ? intval($_POST['year_cur']) : 0;

// Validaciones iniciales: periodo/año y ambiente
if (empty($periodo_fi) || empty($anio_fi)) {
    echo "<script>
              alert('Por favor, selecciona periodo y año curzado.');
              window.history.back();
          </script>";
    exit();
}

if ($amb === 0) {
    echo "<script>
              alert('Por favor, selecciona un ambiente válido.');
              window.history.back();
          </script>";
    exit();
}

// Consulta suma de horas (mantener tu lógica)
$querys = mysqli_query($conn, "
    SELECT SUM(horas_instructor) AS total
    FROM horarios
    WHERE ficha = $ficha_
      AND id_trim_fch = $id_trim
      AND period_fk = $periodo_fi
      AND año_fk = $anio_fi
");
$row = mysqli_fetch_assoc($querys);
$sum = (int)($row['total'] ?? 0);


// Si el total de horas del instructor (o ficha) es menor a 40, permitimos insertar
if ($sum < 40) {

    // Si no hay días u horas seleccionados, avisar
    if (empty($checkdia) || empty($checkhora)) {
        echo "<script>
                  alert('Por favor selecciona al menos un día y una hora.');
                  window.history.back();
              </script>";
        exit();
    }

    // Recorrer días y horas
    foreach ($checkdia as $dia_raw) {
        $dia = intval($dia_raw);
        foreach ($checkhora as $hora_raw) {
            $hora = intval($hora_raw);

            // 1) Verificar si el ambiente está ocupado para ese dia/hora/periodo/año
            $check_query = "SELECT 1 FROM horarios
                            WHERE dia = '$dia'
                              AND hora = '$hora'
                              AND period_fk = '$periodo_fi'
                              AND id_ambiente = '$amb'
                              AND `año_fk` = '$anio_fi'
                            LIMIT 1";
            $check_result = mysqli_query($conn, $check_query);
            if ($check_result && mysqli_num_rows($check_result) > 0) {
                echo "<script>
                          alert('El ambiente ya se encuentra ocupado en ese horario.');
                          window.location= '../vista/admin/horarios_ficha.php?ficha=$ficha_';
                      </script>";
                exit();
            }

            // 2) Verificar si el instructor ya está ocupado en ese dia/hora/periodo/año
            $check_query2 = "SELECT 1 FROM horarios
                             WHERE instructor = '$ins'
                               AND dia = '$dia'
                               AND hora = '$hora'
                               AND period_fk = '$periodo_fi'
                               AND `año_fk` = '$anio_fi'
                             LIMIT 1";
            $check_result2 = mysqli_query($conn, $check_query2);
            if ($check_result2 && mysqli_num_rows($check_result2) > 0) {
                echo "<script>
                          alert('El instructor ya se encuentra ocupado en ese horario.');
                          window.location= '../vista/admin/horarios_ficha.php?ficha=$ficha_';
                      </script>";
                exit();
            }

            // 3) Si pasa validaciones, insertar
            $insert = "INSERT INTO `horarios`
                       (`id_hora`,`dia`,`ficha`,`instructor`,`hora`,`id_ambiente`,`horas_instructor`,`id_trim_fch`,`descripcion`,`observaciones`,`period_fk`,`año_fk`)
                       VALUES (NULL, '$dia', '$ficha_', '$ins', '$hora', '$amb', '$hora_i', '$id_trim', '$descripcion', '$observaciones', '$periodo_fi', $anio_fi)";
            $res_ins = mysqli_query($conn, $insert);
            if (!$res_ins) {
                // Si hay error en la inserción, avisar y detener
                $err = mysqli_error($conn);
                echo "<script>
                        alert('Error al insertar horario: ". addslashes($err) ."');
                        window.location= '../vista/admin/horarios_ficha.php?ficha=$ficha_';
                      </script>";
                exit();
            }
        } // end foreach hora
    } // end foreach dia

    // Todo insertado correctamente (o no hubo conflictos)
    echo "<script>
            alert('Horario(s) guardado(s) correctamente.');
            window.location= '../vista/admin/horarios_ficha.php?ficha=$ficha_';
          </script>";
    exit();

} // 🔓 SIN LÍMITE DE HORAS — SIEMPRE SE PERMITE GUARDAR
foreach ($checkdia as $dia_raw) {
    $dia = intval($dia_raw);
    foreach ($checkhora as $hora_raw) {
        $hora = intval($hora_raw);

        // 1) Validación ambiente ocupado
        $check_query = "SELECT 1 FROM horarios
                        WHERE dia = '$dia'
                          AND hora = '$hora'
                          AND period_fk = '$periodo_fi'
                          AND id_ambiente = '$amb'
                          AND año_fk = '$anio_fi'
                        LIMIT 1";
        $check_result = mysqli_query($conn, $check_query);
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('El ambiente ya está ocupado.'); window.location='../vista/admin/horarios_ficha.php?ficha=$ficha_';</script>";
            exit();
        }

        // 2) Validación instructor ocupado
        $check_query2 = "SELECT 1 FROM horarios
                         WHERE instructor = '$ins'
                           AND dia = '$dia'
                           AND hora = '$hora'
                           AND period_fk = '$periodo_fi'
                           AND año_fk = '$anio_fi'
                         LIMIT 1";
        $check_result2 = mysqli_query($conn, $check_query2);
        if ($check_result2 && mysqli_num_rows($check_result2) > 0) {
            echo "<script>alert('El instructor ya está ocupado.'); window.location='../vista/admin/horarios_ficha.php?ficha=$ficha_';</script>";
            exit();
        }

        // insert always allowed
        $insert = "INSERT INTO horarios
                   (id_hora, dia, ficha, instructor, hora, id_ambiente, horas_instructor, id_trim_fch, descripcion, observaciones, period_fk, año_fk)
                   VALUES (NULL, '$dia', '$ficha_', '$ins', '$hora', '$amb', '$hora_i', '$id_trim', '$descripcion', '$observaciones', '$periodo_fi', '$anio_fi')";
        mysqli_query($conn, $insert);
    }
}

echo "<script>alert('Horario(s) guardado(s) correctamente.'); window.location='../vista/admin/horarios_ficha.php?ficha=$ficha_';</script>";
exit();


?>

