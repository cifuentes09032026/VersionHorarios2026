<?php
$pageTitle = 'Subir instructores';
include("../plantillas/parte_superior.php");

// Para insertar
require_once("excel/excelinstructores.php");

// Normaliza encabezados: mayúsculas, sin tildes, espacios únicos, sin puntos finales
function norm($s) {
  $s = trim((string)$s);
  // Pasar a UTF-8 (el archivo viene en ISO-8859-1)
  $s = iconv('ISO-8859-1', 'UTF-8//IGNORE', $s);
  $s = mb_strtoupper($s, 'UTF-8');
  // Quitar acentos
  $s = strtr($s, [
    'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','Ü'=>'U','Ñ'=>'N'
  ]);
  // Reemplazar múltiples espacios por uno
  $s = preg_replace('/\s+/', ' ', $s);
  // Quitar punto final suelto tipo "NO."
  $s = rtrim($s, ". \t");
  return $s;
}

// Dado el texto de vinculación, devolver ID de contrato
// 1 = Contrato (40h), 2 = Planta (32h)
function mapContratoId($txt) {
  $t = norm($txt);
  if (strpos($t, 'PLANTA') !== false) return 2;
  if (strpos($t, 'CONTRATO') !== false) return 1;
  // Si llega un 1 o 2 como número, úsalo
  if (ctype_digit($t)) {
    $num = (int)$t;
    if ($num === 1 || $num === 2) return $num;
  }
  return null; // desconocido
}

// Separar nombre y apellido a partir de “NOMBRE DEL CONTRATISTA”
function splitNombreApellido($nombreCompleto) {
  $nc = trim(iconv('ISO-8859-1', 'UTF-8//IGNORE', $nombreCompleto));
  $nc = preg_replace('/\s+/', ' ', $nc);
  // Heurística simple: primer token como Nombre, resto como Apellido
  $parts = explode(' ', $nc);
  if (count($parts) >= 2) {
    $nombre = array_shift($parts);
    $apellido = implode(' ', $parts);
  } else {
    $nombre = $nc;
    $apellido = '';
  }
  return [$nombre, $apellido];
}

if (isset($_POST["enviar"])) {
  if (!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] !== UPLOAD_ERR_OK) {
    echo '<script>alert("No se recibió el archivo o llegó con error.");</script>';
  } else {
    $archivoTmp = $_FILES["archivo"]["tmp_name"];
    $archivoguardado = "copia_" . basename($_FILES["archivo"]["name"]);
    if (!move_uploaded_file($archivoTmp, $archivoguardado)) {
      echo '<script>alert("No se pudo guardar el archivo subido.");</script>';
    } else {
      // Abrir y leer
      $fp = fopen($archivoguardado, "r");
      if (!$fp) {
        echo '<script>alert("No se pudo abrir el archivo.");</script>';
      } else {
        $linea0 = fgets($fp);
        if ($linea0 === false) {
          echo '<script>alert("El archivo está vacío.");</script>';
        } else {
          // Encabezados
          $encRaw = str_getcsv($linea0, ';');
          $headers = array_map('norm', $encRaw);

          // Ubicar índices: toleramos variantes y espacios finales
          $idxNombre = null;
          $idxCorreo = null;
          $idxVinc  = null;

          foreach ($headers as $i => $h) {
            if ($idxNombre === null && (strpos($h, 'NOMBRE DEL CONTRATISTA') !== false || strpos($h, 'NOMBRE CONTRATISTA') !== false)) {
              $idxNombre = $i;
            }
            if ($idxCorreo === null && strpos($h, 'CORREO') !== false) {
              $idxCorreo = $i;
            }
            if ($idxVinc === null && (strpos($h, 'TIPO DE VINCULACION') !== false || strpos($h, 'TIPO VINCULACION') !== false || strpos($h, 'CONTRATO') !== false || strpos($h, 'VINCULACION') !== false)) {
              $idxVinc = $i;
            }
          }

          if ($idxNombre === null || $idxCorreo === null || $idxVinc === null) {
            echo '<div class="alert alert-danger mt-3">
                    Encabezados requeridos no encontrados. Verifica que existan (o alguna variante): 
                    <strong>NOMBRE DEL CONTRATISTA</strong>, <strong>CORREO</strong> y <strong>TIPO VINCULACIÓN</strong>.
                  </div>';
          } else {
            $insertados = 0;
            $omitidos   = 0;

            while (($line = fgets($fp)) !== false) {
              $cols = str_getcsv($line, ';');
              // Rellenar por si vienen menos columnas en alguna fila
              if (count($cols) < max($idxNombre, $idxCorreo, $idxVinc)+1) {
                $omitidos++;
                continue;
              }

              $nombreCompleto = $cols[$idxNombre] ?? '';
              $correoRaw      = $cols[$idxCorreo] ?? '';
              $vincRaw        = $cols[$idxVinc] ?? '';

              // Normalizar correo a UTF-8 y quitar espacios
              $correo = trim(iconv('ISO-8859-1', 'UTF-8//IGNORE', $correoRaw));

              // Mapear contrato a ID
              $contratoId = mapContratoId($vincRaw);
              if ($contratoId === null) {
                echo "<p style='color:#c00'>❌ Vinculación desconocida para: ".htmlspecialchars($correo)."</p>";
                $omitidos++;
                continue;
              }

              // Nombre y apellido
              list($nombre, $apellido) = splitNombreApellido($nombreCompleto);

              // Rol por defecto (2 suele ser “instructor”)
              $rol = 2;

              // Insertar
              if (insertar_instructor($nombre, $apellido, $correo, $rol, $contratoId)) {
                $insertados++;
              } else {
                $omitidos++;
              }
            }
            fclose($fp);

            echo "<div class='alert alert-success mt-3'>✅ Insertados: $insertados &nbsp;&nbsp; | &nbsp;&nbsp; Omitidos: $omitidos</div>";
            echo "<script>setTimeout(()=>{ window.location = '../show-instructor.php'; }, 1500);</script>";
          }
        }
      }
    }
  }
}
?>

<div class="row">
  <div class="container border" style="padding:5%; background-color: #a2a1a5a8;">
    <form action="create-instructores.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="formFile" class="form-label">Subir archivo CSV con instructores</label><br>
        <input type="file" name="archivo" accept=".csv" required /><br><br>
        <a class="btn btn-secondary" href="../show-instructor.php">Atrás</a>
        <input type="submit" value="Subir CSV" class="btn btn-success" name="enviar">
      </div>
    </form>
  </div>
</div>
<div style="height: 280px;"></div>
<?php include("../plantillas/parte_inferior.php") ?>