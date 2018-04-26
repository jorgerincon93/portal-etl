<?php

ini_set('max_execution_time', 3000);
define('COMPONENTS_PATH', '../componentes/');
//define('LIB_PATH', '../libraries/');
//define('CLASSES_PATH', '../libraries/classes/');

require_once('DatabaseMySQL.php');
require_once('BDControlador.php');
require_once('adicionales.php');

$db = Database::getInstance(array('localhost', 'meiko', 'meiko', 'meiko'));

/* * ************************************************************** */
/*                                                               */
/*                          INICIALES                            */
/*                                                               */
/* * ************************************************************** */
try {
    echo "Inicio Proceso Conteo Columnas <br>\n";
    ejecutarProcConteo();
    echo "Termina Proceso Conteo Columnas <br>\n";
} catch (Exception $e) {
    echo 'Error - ' . $e;
    //actualizarLog($value["id"], $fila, $columnas - 1, 'Error - ' . $e);
}

/* * ************************************************************** */
/*                                                               */
/*                          FUNCIONES                            */
/*                                                               */
/* * ************************************************************** */



function ejecutarProcConteo() {
    
    
    
    $conteo = consultarTablaConteo();
    
    
foreach ($conteo as $key => $value) {
       
       echo'<pre>';print_r($value);echo'</pre>';
       $valor =  contarCampo($value);
       
       $arreglo["data"]["valor"] = $valor->campo;
       $arreglo["data"]["id"] = $value["id"];
       
       echo'<pre>';print_r($arreglo["data"]);echo'</pre>';
       
        actualizarconteo($arreglo["data"]);
    
    
    
}  
    
    
      
    
    
    
    
    
    /*echo "Inicio Carga OTROS NO TIENE <br>\n";
    //ajustarItems();
    echo "Termina Proceso OTROS NO TIENE <br>\n\n";*/
}


function consultarTablaConteo() {
    global $db;

    $query = "SELECT id,campo,esquema,tabla FROM calidad.conteoTabla ";
    $db->query($query);
    return $db->getArray();
}

function contarCampo($arreglo) {
    global $db;
    $query = "SELECT COUNT("
    . "". $arreglo['campo']. ") campo"
. " FROM ". $arreglo['esquema'] . ""
  . "." ." " . $arreglo['tabla'] . "";
    
    $db->query($query);
    return $db->fetch();
}

function actualizarconteo($arreglo) {
    global $db;

    $query = "UPDATE  calidad.conteoTabla "
            . "SET conteoColumna='" . $arreglo["valor"] . "'"
            . "WHERE id=" . $arreglo["id"] . "";

    $db->query($query);
}


?>