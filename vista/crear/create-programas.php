<?php
$pageTitle = 'Subir programas';
include("../plantillas/parte_superior.php");
require_once("excel/excelprogramas.php");

// —— Normalizador de encabezados
function limpiar($s){
  $s = trim((string)$s);
  // Quitar BOM UTF-8 si lo tuviera:
  $s = preg_replace('/\x{FEFF}/u','',$s);
  $s = mb_strtoupper($s,'UTF-8');
  $s = strtr($s, ['Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','Ñ'=>'N']);
  $s = preg_replace('/\s+/',' ',$s);
  return $s;
}

if(isset($_POST['enviar'])){
    $tmp = $_FILES['archivo']['tmp_name'];
    if(!$tmp){
        echo "<div class='alert alert-danger'>No se recibió archivo</div>";
    } else {
        $f = fopen($tmp,"r");
        $enc = fgetcsv($f,0,";");
        if(!$enc){
            echo "<div class='alert alert-danger'>Archivo vacío</div>";
        } else {
            // Normalizar
            $hNorm = array_map('limpiar',$enc);

            // ===== DIAGNÓSTICO (MOSTRAR QUÉ ENCABEZADOS DETECTÓ) ====
            //echo "<pre>Encabezados detectados:\n";
            //print_r($hNorm);
            
            //echo "</pre>";
            //exit;//
            // =========================================================

            $idxNombre = null; 
            $idxNivel  = null;
            $posNombre = ['NOMBRE_PROGRAMA_FORMACION','NOMBRE PROGRAMA FORMACION','PROGRAMA'];
            $posNivel  = ['NIVEL_FORMACION','NIVEL FORMACION','NIVEL'];

            foreach($hNorm as $i=>$col){
                if($idxNombre===null && in_array($col,$posNombre)){ $idxNombre=$i; }
                if($idxNivel===null  && in_array($col,$posNivel)){  $idxNivel=$i; }
            }

            if($idxNombre===null||$idxNivel===null){
                echo "<div class='alert alert-danger'>Encabezados requeridos no encontrados.<br>Necesitamos columna de <b>Nombre del programa</b> y <b>Nivel_formacion</b></div>";
            }else{
                $ok=0;$exist=0;$err=0;
                while(($row=fgetcsv($f,0,";"))!==false){
                    $nombre = $row[$idxNombre]??'';
                    $nivel  = $row[$idxNivel]??'';
                    $r = insertar_programa($nombre,$nivel);
                    if($r['ok']){
                        if($r['msg']=='ya existe'){ $exist++; } else { $ok++; }
                    } else { $err++; }
                }
                echo "<script>alert('Insertados: $ok / existentes: $exist / errores: $err'); window.location='../show-programa.php';</script>";
            }
        }
        fclose($f);
    }
}
?>

<div class="row mt-4">
<div class="container border" style="padding:5%; background-color:#a2a1a5a8;">
<form method="POST" enctype="multipart/form-data">
    <label>Subir archivo CSV de Programas (delimitado por punto y coma ;):</label><br>
    <input type="file" name="archivo" accept=".csv" required>
    <br><br>
    <a class="btn btn-secondary" href="../show-programa.php">Atrás</a>
    <button type="submit" name="enviar" class="btn btn-success">Subir CSV</button>
</form>
</div>
</div>
<div style="height: 250px;"></div>
<?php include("../plantillas/parte_inferior.php"); ?>