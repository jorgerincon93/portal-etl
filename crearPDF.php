<?php

$datos = mb_convert_encoding($_POST['datosCertificado'],'UTF-8','UTF-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);
$root = $_SERVER['DOCUMENT_ROOT'];
//echo ($root);
require_once($root . "/portal-etl/libraries/classes/MPDF/mpdf.php");
$mpdf = new mPDF('c','A4');
$css = file_get_contents($root . "/portal-etl/css/estiloportal.css");
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($datos,2);
$mpdf->Output("Remision.pdf","I");
exit;
?>