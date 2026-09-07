<?php
// ✅ exportar_horarios_excel.php
// Ubicación sugerida: C:\xampp\htdocs\horarios\vista\exportar_horarios_excel.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ✅ AUTOLOAD de PhpSpreadsheet
require __DIR__ . '/../vendor/autoload.php';

// ✅ Conexión a la BD
require __DIR__ . '/../confi/conexion.php';   // $conn

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html as HtmlReader;

// ✅ Tipo: fichas | ambientes | instructores
$tipo = $_GET['tipo'] ?? 'fichas';
$filterId = isset($_GET['id']) ? intval($_GET['id']) : null;
$periodo = isset($_GET['ped']) ? intval($_GET['ped']) : null;

// ✅ Consultas según tipo
switch ($tipo) {
    case 'ambientes':
        $sql = "SELECT id_A AS id, Nombre_ambiente AS label FROM ambiente";
        if ($filterId) $sql .= " WHERE id_A = $filterId";
        $tituloArchivo = "Horarios_Ambientes.xlsx";
        break;

    case 'instructores':
        $sql = "SELECT ID AS id, CONCAT(Nombre,' ',Apellido) AS label FROM instructor";
        if ($filterId) $sql .= " WHERE ID = $filterId";
        $tituloArchivo = "Horarios_Instructores.xlsx";
        break;

    default:
        // ✅ Fichas
        $sql = "SELECT ID_F AS id, `Nº ficha` AS label FROM ficha";
        if ($filterId) $sql .= " WHERE ID_F = $filterId";
        $tituloArchivo = "Horarios_Fichas.xlsx";
        break;
}

$res = mysqli_query($conn, $sql);
if (!$res) die("Error SQL: " . mysqli_error($conn));

// ✅ Crear archivo Excel
$spreadsheet = new Spreadsheet();
$spreadsheet->removeSheetByIndex(0);

// ✅ Lector HTML (si está disponible)
$canUseHtmlReader = class_exists('\PhpOffice\PhpSpreadsheet\Reader\Html');

$readerHtml = $canUseHtmlReader ? new HtmlReader() : null;

// ✅ Limpia nombres de hojas
function safeSheetName($name) {
    $forbidden = ['[',']','*',':','/','\\','?'];
    $s = str_replace($forbidden, '-', $name);
    return mb_substr($s, 0, 31) ?: "Hoja";
}

// ✅ Recorrer cada item y generar su hoja
while ($row = mysqli_fetch_assoc($res)) {

    $itemId = $row['id'];
    $label  = $row['label'];

    // ✅ CAPTURAR HTML DE LA PLANTILLA REAL (SIN MODIFICAR NADA)
    ob_start();

    // ✅ Rutas exactas de tus plantillas:
    // C:\xampp\htdocs\horarios\vista\imprimir\horarios_X_Im.php
    $rutaPlantillas = __DIR__ . '/imprimir/';

    if ($tipo === 'ambientes') {
        $_GET['amb'] = $itemId;
        if ($periodo) $_GET['ped'] = $periodo;
        include $rutaPlantillas . 'horarios_Amb_Im.php';

    } elseif ($tipo === 'instructores') {
        $_GET['ins'] = $itemId;
        if ($periodo) $_GET['ped'] = $periodo;
        include $rutaPlantillas . 'horarios_Ins_Im.php';

    } else {
        $_GET['fich'] = $itemId;
        if ($periodo) $_GET['ped'] = $periodo;
        include $rutaPlantillas . 'horarios_ficha_Im.php';
    }

    $html = ob_get_clean();

    // ✅ Nombre de la hoja
    $sheetName = safeSheetName($label);

    // ✅ Si PhpSpreadsheet puede convertir HTML → Excel
    if ($readerHtml) {
        try {
            // Algunos tienen loadFromString
            if (method_exists($readerHtml, 'loadFromString')) {
                $tempSpreadsheet = $readerHtml->loadFromString($html);
            } else {
                // Fallback temporal
                $tmpfile = sys_get_temp_dir() . '/horario_' . uniqid() . '.html';
                file_put_contents($tmpfile, $html);
                $tempSpreadsheet = $readerHtml->load($tmpfile);
                @unlink($tmpfile);
            }

            // ✅ Tomamos la primera hoja del HTML
            $tempSheet = $tempSpreadsheet->getSheet(0);

            // ✅ Crear hoja real
            $newSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheetName);
            $spreadsheet->addSheet($newSheet);

            // ✅ Copiar valores básicos (simple, pero funcional)
            $highestRow = $tempSheet->getHighestRow();
            $highestCol = $tempSheet->getHighestColumn();
            $maxColIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestCol);

            for ($r = 1; $r <= $highestRow; $r++) {
                for ($c = 1; $c <= $maxColIndex; $c++) {

                    $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($c) . $r;
                    $val  = $tempSheet->getCell($cell)->getValue();

                    $newSheet->setCellValue($cell, $val);
                }
            }

        } catch (Exception $e) {
            // ✅ Si falla el parser → fallback
            $fallbackSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheetName);
            $spreadsheet->addSheet($fallbackSheet);

            $plain = strip_tags($html);
            $lines = explode("\n", $plain);

            $i = 1;
            foreach ($lines as $ln) {
                if (trim($ln) !== "") {
                    $fallbackSheet->setCellValue('A'.$i, trim($ln));
                    $i++;
                }
            }
        }

    } else {
        // ✅ PHPSpreadsheet sin HTML reader → copia texto plano
        $fallbackSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheetName);
        $spreadsheet->addSheet($fallbackSheet);

        $plain = strip_tags($html);
        $lines = explode("\n", $plain);

        $i = 1;
        foreach ($lines as $ln) {
            if (trim($ln) !== "") {
                $fallbackSheet->setCellValue('A'.$i, trim($ln));
                $i++;
            }
        }
    }
}

// ✅ Seguridad: si no se creó ninguna hoja
if ($spreadsheet->getSheetCount() === 0) {
    $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, "Vacio");
    $spreadsheet->addSheet($sheet);
}

// ✅ Descargar archivo Excel
$writer = new Xlsx($spreadsheet);

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"$tituloArchivo\"");
header("Cache-Control: max-age=0");

$writer->save("php://output");
exit;
