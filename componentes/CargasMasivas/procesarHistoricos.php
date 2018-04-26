<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 600000);
define('COMPONENTS_PATH', '../componentes/');
define('LIB_PATH', '../../libraries/');
define('CLASSES_PATH', '../../libraries/classes/');
define('MASIVOS_PATH', 'archivos/');

require_once(CLASSES_PATH . 'DatabaseMySQL.php');
require_once(CLASSES_PATH . 'BDControlador.php');
require_once(CLASSES_PATH . 'reglas.php');
require_once(CLASSES_PATH . 'PHPExcel/IOFactory.php');

$db = Database::getInstance(array('localhost', 'meiko', 'meiko', 'meiko'));

//$listaArchivos = listadoArchivos();

echo "INICIO: " . date('Y-m-d h:i:s A ') . "\n";

$arraySi = array('Si', 'SI', 'VERDADERO', 'Verdadero', 'TRUE', 'True', 'YES', 'Yes');
$arrayNo = array('No', 'NO', 'FALSO', 'Falso', 'FALSE', 'False');


//foreach ($listaArchivos as $key => $value) {
$value['nombreArchivo'] = "migracion.csv";

try {
    echo "INICIA LECTURA ARCHIVO " . $value['nombreArchivo'] . " - " . date('Y-m-d h:i:s A ') . "\n";

    //actualizarLog($value["id"], 0, 0, 'En Proceso');

    $fila = 1;
    $columnas = 0;
    $idEncuesta = "";
    $arregloCol = array();
    $arregloRegistros = "";
    //ARMAR REGISTRO DINAMICO PENDIENTE        

    $inputFileName = MASIVOS_PATH . $value['nombreArchivo'];
    echo $inputFileName;
    //  Read your Excel workbook
    try {
    
        //ARMAR REGISTRO DINAMICO PENDIENTE
        $listaTablas = listadoTablas();

        $tablasArray = array();  
        foreach ($listaTablas as $key => $row) {
            array_push($tablasArray, $row["tabla"]);
        }

        if (($gestor = fopen($inputFileName, "r")) !== FALSE) {

            //PRIMERA LINEA
            if (($datos = fgetcsv($gestor, 0, "|"))) {
                $numero = count($datos);
                $columnas = $numero;
                //echo "<p> $numero de campos en la linea $fila: <br /></p>";
                for ($c = 0; $c < $numero; $c++) {
                    echo $datos[$c] . "<br />\n";
                    $resCampo = consultarCampo($datos[$c], "calidad");

                    if (isset($resCampo->id)) {

                        if ($resCampo->campo == "ResponseID") {
                            $posRespId = $c;
                        }
                        $arregloCol[$c]["id"] = $resCampo->id;
                        $arregloCol[$c]["campo"] = $resCampo->campo;
                        $arregloCol[$c]["tabla"] = $resCampo->tabla;
                        $arregloCol[$c]["tipo"] = $resCampo->tipo;
                        $arregloCol[$c]["codError"] = "";
                        $arregloCol[$c]["error"] = "";
                    } else {
                        $arregloCol[$c]["campo"] = "El campo $datos[$c] no existe en mapeo";
                        $arregloCol[$c]["id"] = "0";
                        $arregloCol[$c]["tabla"] = "0";
                        $arregloCol[$c]["codError"] = "1";
                        $arregloCol[$c]["error"] = "El campo $datos[$c] no existe en mapeo";
                    }
                }
                $fila++;
            }

            //PRIMERA LINEA

            echo '<pre>';print_r($arregloCol);echo '</pre>';

            if (isset($posRespId)) {

                while (($datos = fgetcsv($gestor, 0, "|")) !== FALSE) {

                    $registro = array();
                    $arregloEncuesta = array();
                    $arregloIdTablas = array();

                    $numeroReg = count($datos);
                    $fila++;                    

                    $registroResponse = consultarResponseId($datos[$posRespId]);

                    
                    if (isset($registroResponse->idRegistro)) {
                        $idRegistroEncuesta = $registroResponse->idRegistro;
                        $existeResponse=1;
                    } else {
                        //GRABAR LOS DATOS BASICOS DEL REGISTRO Y OBTENER EL ID
                        $idRegistroEncuesta = insertarRegistroEncuesta($idEncuesta);
                        $existeResponse=0;
                    }

                    //CREAR LOS ID'S DE REGISTROS BASICOS DE LAS TABLAS DESTINO
                    $arregloIdTablas["ext_registro_encuesta"] = $idRegistroEncuesta;

                    foreach ($listaTablas as $key => $row) {
                        if ($row["tabla"] != 'ext_registro_encuesta') {
                            if($existeResponse == 0){
                                $arregloIdTablas[$row["tabla"]] = insertarAtomizacionInicial($idRegistroEncuesta, $row["tabla"]);
                            }else{
                                 $idRegistroTabla = consultarIdTabla($idRegistroEncuesta, $row["tabla"]);
                                 $arregloIdTablas[$row["tabla"]] = $idRegistroTabla ->idRegistro;
                            }
                        }
                    }

                    for ($j = 0; $j < $numeroReg; $j++) {

                        $registro = $arregloCol[$j];
                        $registro["valor"] = $datos[$j];

                        if (in_array($registro["valor"], $arraySi)) {
                            $registro["valor"] = 1;
                        } elseif (in_array($registro["valor"], $arrayNo)) {
                            $registro["valor"] = 0;
                        }

                        $colReal = $j + 1;

                        //echo $registro["tabla"];
                        if (in_array($registro["tabla"], $tablasArray)) {
                            if (($registro != NULL) && ($registro != '')) {
                                actualizarRegistroAtomizacion($arregloIdTablas, $registro);
                            }
                        } else {
                            insertarVarRegEncuesta($idRegistroEncuesta, $registro, $colReal);
                        }
                        //
                    }
                }
            } else {
                //actualizarLog($value["id"], 0, $columnas - 1, 'Error - Archivo sin ID');
                echo 'Error - Archivo sin ResponseId';
            }
            fclose($gestor);
        }

    } catch (Exception $e) {
        echo "FIN: ERROR EN LECTURA ARCHIVO " . $value['nombreArchivo'] . " - " . date('Y-m-d h:i:s A ') . "\n";
        echo $e;
        //actualizarLog($value["id"], 0, 0, 'Error - No se pudo leer archivo');
    }


    //$copiado = shell_exec('php copiaCalidad.php idEncuesta=' . $idEncuesta . ' >> log/log_calidad.log &');
} catch (Exception $e) {
    echo 'Error - ' . $e;
    //actualizarLog($value["id"], $fila, $columnas - 1, 'Error - ' . $e);
}
//}

echo "FIN: " . date('Y-m-d h:i:s A ');

/* * ************************************************************** */
/*                                                               */
/*                          FUNCIONES                            */
/*                                                               */
/* * ************************************************************** */

function consultarCampo($nomCampo, $esquema) {
    global $db;
    $query = "SELECT distinct * FROM meiko.mapeo_datos mp WHERE mp.esquema='" . $esquema . "' AND ( mp.label='" . $nomCampo . "' OR mp.campo='" . $nomCampo . "')";
    $db->query($query);
    return $db->fetch();
}

function listadoArchivos() {
    global $db;
    $query = "SELECT lc.*,lv.texto,lv.valor FROM calidad.logcargamasiva lc,meiko.listavalor lv WHERE lc.estado='Pendiente' AND lc.tipoCarga=lv.valor";
    $db->query($query);
    return $db->getArray();
}

function consultarResponseId($responseId) {
    global $db;

    $query = "SELECT MAX(id) as idRegistro FROM resultante.ext_registro_encuesta "
            . " WHERE responseId = '" . $responseId . "'";

    $db->query($query);
    return $db->fetch();
}

function consultarIdTabla($idRegistroEncuesta ,$tabla){
    global $db;

    $query = "SELECT MAX(id) as idRegistro FROM resultante." . $tabla . ""
            . " WHERE idRegistroEncuesta = '" . $idRegistroEncuesta . "'";

    $db->query($query);
    return $db->fetch();
}

function insertarRegistroEncuesta() {
    global $db;

    $idEncuesta = 0;

    $query = "INSERT INTO resultante.ext_registro_encuesta("
            . "fecha,"
            . "idEncuesta)VALUES("
            . "now(),"
            . "" . $idEncuesta . ""
            . ")";

    $db->query($query);
    $idRegistro = $db->getInsertID();
    return $idRegistro;
}

function insertarAtomizacionInicial($idRegistroEncuesta, $tabla) {
    global $db;
    $query = "INSERT INTO resultante." . $tabla . " ("
            . " idRegistroEncuesta"
            . ")VALUES("
            . "" . $idRegistroEncuesta . ")";
    $db->query($query);
    $idRegistroTabla = $db->getInsertID();
    return $idRegistroTabla;
}

function listadoTablas(){
  global $db;
    $query = "SELECT distinct tabla as tabla FROM meiko.mapeo_datos md WHERE md.extraccion='SI'";
    $db->query($query);
    return $db->getArray();  
}

function actualizarRegistroAtomizacion($idTablas, $registro) {
    global $db;
    $query = "UPDATE resultante." . $registro["tabla"] . " "
            . " SET " . $registro["campo"] . "='" . $db->escapeString($registro["valor"]) . "' "
            . " WHERE id = " . $idTablas[$registro["tabla"]] . "";
    $db->query($query);
}

function insertarVarRegEncuesta($idRegEncuesta, $registoEncuesta, $col) {
    global $db;
    $query = "INSERT INTO resultante.ext_variables_reg_encuesta("
            . "idRegistroEncuesta,"
            . "idMapeo,"
            . "valor,"
            . "codigoError,"
            . "descripcionError,"
            . " numeroColumna)"
            . "VALUES("
            . "" . $idRegEncuesta . ","
            . "'" . $registoEncuesta["id"] . "',"
            . "'" . $db->escapeString($registoEncuesta["valor"]) . "',"
            . "'" . $registoEncuesta["codError"] . "',"
            . "'" . $registoEncuesta["error"] . "',"
            . "" . $col . ")";
    $db->query($query);
}

function insertarLog($id, $filas, $columnas, $estado) {
    global $db;
    $query = "UPDATE resultante.logcargahistorico SET "
            . "fechaProceso = now(), "
            . "filas = " . $filas . ", "
            . "columnas = " . $columnas . ", "
            . "estado = '" . $estado . "' "
            . "WHERE id=" . $id;

    $db->query($query);
}

function actualizarLog($id, $filas, $columnas, $estado) {
    global $db;
    $query = "UPDATE resultante.logcargahistorico SET "
            . "fechaProceso = now(), "
            . "filas = " . $filas . ", "
            . "columnas = " . $columnas . ", "
            . "estado = '" . $estado . "' "
            . "WHERE id=" . $id;

    $db->query($query);
}

?>