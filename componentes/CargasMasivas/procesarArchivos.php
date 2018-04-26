<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', 9000);
define('COMPONENTS_PATH', '../componentes/');
define('LIB_PATH', '../../libraries/');
define('CLASSES_PATH', '../../libraries/classes/');
define('MASIVOS_PATH', 'archivos/');

require_once(CLASSES_PATH . 'DatabaseMySQL.php');
require_once(CLASSES_PATH . 'BDControlador.php');
require_once(CLASSES_PATH . 'reglas.php');
require_once(CLASSES_PATH . 'PHPExcel/IOFactory.php');

$db = Database::getInstance(array('localhost','mlimpieza','mundolimpieza','mundolimpieza'));

$listaArchivos = listadoArchivos();

echo "INICIO: " . date('Y-m-d h:i:s A ') . "\n";

$arraySi = array('Si', 'SI', 'VERDADERO', 'Verdadero', 'TRUE', 'True', 'YES', 'Yes');
$arrayNo = array('No', 'NO', 'FALSO', 'Falso', 'FALSE', 'False');

 
foreach ($listaArchivos as $key => $value) {

    try {
        echo "INICIA LECTURA ARCHIVO " . $value['nombreArchivo'] . " - " . date('Y-m-d h:i:s A ') . "\n";

        actualizarLog($value["id"], 0, 0, 'En Proceso');
        

        $fila = 1;
        $columnas = 0;
        $contador = 1;
        $idEncuesta = "";
        $arregloCol = array();
        $camposInsert ="";
        //ARMAR REGISTRO DINAMICO PENDIENTE        
        
        $inputFileName = MASIVOS_PATH . $value['nombreArchivo'];
        echo $inputFileName;
        //  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        
            
        //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
            
            //PRIMERA LINEA

            $primeraLinea = $sheet->rangeToArray('A1:' . $highestColumn . '1',
                                        NULL,
                                        TRUE,
                                        FALSE);
            $datosColumna = $primeraLinea[0];            
            
            
            
            if($value["valor"] == "Productos Insumos"){
               
                $numero = count($datosColumna);
                $columnas = $numero;
                
                
                
                /*for ($c = 0; $c < $columnas; $c++) {
                    
                    $resCampo = consultarCampoCount("producto",$datosColumna[$c]);
                    //echo'<pre>';print_r($resCampo);echo'</pre>';
                    if(isset($resCampo->id)) {
                        $arregloCol[$c]["id"] = $resCampo->id;
                        $arregloCol[$c]["campo"] = $resCampo->campo;
                        $arregloCol[$c]["tabla"] = $resCampo->tabla;
                        $arregloCol[$c]["tipo"] = $resCampo->tipo;
                        $arregloCol[$c]["codError"] = "";
                        $arregloCol[$c]["error"] = "";
                    } else {  
                                    
                        
                        
                    }
                       
                    
                    
                    
                }*/
                    
                    echo '<pre>';print_r($arregloCol);echo '</pre>';
                   
                    actualizarLog($value["id"], 0, $columnas, 'En Proceso');                    
                        
                for($row =2; $row<= $highestRow;$row++){
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                       // echo'<pre>';print_r($rowData);echo'</pre>';
                        $registro = array();
                          
                        for($columna=0;$columna<$columnas;$columna++){
                                
                            foreach($rowData as $key => $valueData) {
                                
                                if($datosColumna[$columna] == "Nombre Producto"){
                                   
                                    $datosColumna[$columna] = "nombre";
                                    
                                }elseif($datosColumna[$columna] == "Marca"){
                                    
                                    $datosColumna[$columna] = "idMarca";
                                    
                                }elseif($datosColumna[$columna] == "Tamaño"){
                                    
                                    $datosColumna[$columna] = "tamano";
                                    
                                }
                                
                                $registro["valores"][$datosColumna[$columna]] = $valueData[$columna];
                                
                            } 
                            
                            
                            
                             //$campo = campoMapeo($datosColumna[$columna]);
                           
                           
                        }
                        echo'<pre>';print_r($registro);echo'</pre>';
                        $fila++; 
                        
                        actualizarLog($value["id"], $fila, $columnas, 'En Proceso');
                        insertarTabla($registro["valores"]);
                        
                        
                }
                
            
             
                                 
                
            }
        
        } catch(Exception $e) {            
            echo "FIN: ERROR EN LECTURA ARCHIVO " . $value['nombreArchivo'] . " - " . date('Y-m-d h:i:s A ') . " ERROR: " . $e . "\n";
            actualizarLog($value["id"], $fila, $columnas, 'Error - No se pudo leer archivo');
        }


        //$copiado = shell_exec('php copiaCalidad.php idEncuesta=' . $idEncuesta . ' >> log/log_calidad.log &');
    } catch (Exception $e) {
        actualizarLog($value["id"], $fila, $columnas - 1, 'Error - ' . $e);
    }
    
    echo "FIN: LECTURA ARCHIVO " . $value['nombreArchivo'] . " - " . date('Y-m-d h:i:s A ') . "\n";
    actualizarLog($value["id"], $fila, $columnas, 'Procesado');
    
}

 
/*****************************************************************/
/*                                                               */
/*                          FUNCIONES                            */
/*                                                               */
/*****************************************************************/

function consultarCampo($nomCampo,$esquema) {
    global $db;
    $query = "SELECT distinct * FROM meiko.mapeo_datos mp WHERE mp.esquema='" . $esquema . "' AND mp.label='" . $nomCampo . "'";
    $db->query($query);
    return $db->fetch();
}

function consultarRegistroMapeo($tabla,$nomCampo) {
    global $db;
    $query = "SELECT COUNT(0) AS contador FROM meiko.mapeo_datos mp WHERE mp.tabla='" . $tabla . "' AND mp.campo ='" . $nomCampo . "'";
    $db->query($query);
    return $db->fetch();
}

function consultarRegistroMapeoTabla($tabla) {
    global $db;
    $query = "SELECT COUNT(0) AS contador FROM meiko.mapeo_datos mp WHERE mp.tabla='" . $tabla . "'";
    $db->query($query);
    return $db->fetch();
}

function consultarCampoShema($tabla) {
    global $db;
    $query = "SELECT COUNT(COLUMN_NAME) AS campo FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='calidad' AND COLUMN_NAME ='" .$tabla. "'";
    $db->query($query);
    return $db->fetch();
}

function listadoArchivos() {
    global $db;
    $query = "SELECT lc.*,lv.texto,lv.valor FROM mundolimpieza.logcargamasiva lc,mundolimpieza.listavalor lv WHERE lc.estado='Pendiente' AND lc.tipoCarga=lv.valor ORDER BY lc.id LIMIT 1";
    $db->query($query);
    return $db->getArray();
}

function actualizarLog($id, $filas, $columnas, $estado) {
    global $db;
    $query = "UPDATE mundolimpieza.logcargamasiva SET "
            . "fechaProceso = now(), "
            . "filas = " . $filas . ", "
            . "columnas = " . $columnas . ", "
            . "estado = '" . $db->escapeString($estado) . "' "
            . "WHERE id=" . $id;

    $db->query($query);
}

function listadoTablasConteoReg(){
  global $db;
        $query = "SELECT distinct tabla as tabla FROM meiko.mapeo_datos md WHERE md.tabla like 'conteoregla%' ";
    $db->query($query);
    return $db->getArray();  
}

function consultarTabla($nomTabla){
    global $db;
        $query = "SELECT count(0) as contador FROM information_schema.tables WHERE table_schema = 'calidad' AND table_name = '" . $nomTabla . "'";
    $db->query($query);
    return $db->fetch();    
}

function consultarColumnas($nomTabla){
    global $db;
    $query = "SELECT count(0) as contador FROM information_schema.columns WHERE table_schema = 'calidad' AND table_name = '" . $nomTabla . "'";
    $db->query($query);
    return $db->fetch();    
}

function consultarCampoCount($nomTabla,$nomCampo){
   
    global $db;
        $query = "SELECT COUNT(COLUMN_NAME) AS campo
                    FROM INFORMATION_SCHEMA.COLUMNS
                   WHERE TABLE_SCHEMA = 'mundolimpieza'
                     AND table_name = '" . $nomTabla . "'
                     AND COLUMN_NAME = '" . $nomCampo ."'";
        
    $db->query($query);    
    return $db->fetch();    
}

function consultarCampoMapeo($nomCampo){
    global $db;
    $query = "SELECT count(0) as contador FROM meiko.mapeo_datos WHERE campo ='" . $nomCampo . "'";
    $db->query($query);
    return $db->fetch();    
}

function campoMapeo($campo){
    
    global $db;
    $query = "SELECT tabla,campo FROM meiko.mapeo_datos WHERE campo ='" . $campo . "' GROUP BY tabla,campo";
    $db->query($query);
    return $db->fetch();    
}

function agregarCampoTabla($esquema,$nomTabla,$campos){
    global $db;
    $query="ALTER TABLE " . $esquema . "." . $nomTabla . " "
            . "ADD COLUMN " . $campos . " INT NULL DEFAULT NULL";
    echo $query;
    echo '\n';
    $db->query($query);    

}

function agregarRegistroMapeo($label,$campo,$esquema,$nomTabla){
    global $db;
    $query="INSERT INTO meiko.mapeo_datos(label,campo,esquema,tabla)"
           . " VALUES('". $label . "',"
           . " '" . $campo . "',"
           . " '" . $esquema . "'," 
           . " '" . $nomTabla . "')";
    
    $db->query($query);    

}

function crearTabla($esquema,$nomTabla,$campos){
    global $db;
    $query="CREATE TABLE " . $esquema . "." . $nomTabla . " ( "
        . "id int(11) NOT NULL AUTO_INCREMENT, "
        . $campos . ", "
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB ROW_FORMAT=COMPRESSED AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; ";
    echo $query;
    echo '\n';
    $db->query($query);
}

function crearTablaMapeo($esquema,$nomTabla){
    global $db;
    $query="CREATE TABLE " . $esquema . "." . $nomTabla . " ( "
        . "id int(11) NOT NULL AUTO_INCREMENT, "
        . "idRegistroEncuesta int(11), "
        . "PRIMARY KEY (id) "
        . ") ENGINE=InnoDB ROW_FORMAT=COMPRESSED AUTO_INCREMENT=1 DEFAULT CHARSET=latin1; ";
    echo $query;
    echo '\n';
    $db->query($query);
}

function insertarTabla($registro){
    global $db;
    
          $idCateBieAseCafe = traerIdCategoriaBienAseCafe($registro["Categoria"]);
          $idTipoCate = traerIdTipoCate($registro["Tipo"]);
          $idMarca = traerIdMarca($registro["idMarca"]);
          $idEstadoProd = traerIdEstadoProd($registro["Estado"]);
          
            $query = "INSERT INTO mundolimpieza.producto("
                    . "" . "nombre" . ","
                    . "" . "referencia" . ","
                    . "" . "categoria" . ","
                    . "" . "tipo" . ","
                    . "" . "idMarca" . ","
                    . "" . "tamano" . ","
                    . "" . "empaque" . ","
                    . "" . "olor" . ","
                    . "" . "presentacion" . ","
                    . "" . "descripcion" . ","
                    . "" . "referenciaRC" . ""
                    . ")VALUES("
                    . "'" . $registro["nombre"] . "',"
                    . "'" . $registro["Referencia"] . "',"
                    . "'" . $idCateBieAseCafe->id . "',"
                    . "'" . $idTipoCate->id . "',"
                    . "'" . $idMarca->id . "',"
                    . "'" . $registro["Tamano"] . "',"
                    . "'" . $registro["Empaque"] . "',"
                    . "'" . $registro["Olor"] . "',"
                    . "'" . $registro["Presentacion"] . "',"
                    . "'" . $registro["Descripcion"] . "',"
                    . "'" . $registro["Referencia RC"] . "')";
            
             $db->query($query);   
             $idProductoInsert = $db->getInsertID();
             
           // echo '<pre>';print_r($query);echo '</pre>';
            echo '<pre>';print_r($idProductoInsert);echo '</pre>';
            
            $queryDet = "INSERT INTO mundolimpieza.detalleproducto("
                    . "" . "serial" . ","
                    . "" . "estado" . ","
                    . "" . "idProducto" . ","
                    . "" . "serialRC" . ""
                    . ")VALUES("
                    . "'" . $registro["SERIAL"] . "',"
                    . "'" . $idEstadoProd->id . "',"
                    . "'" . $idProductoInsert . "',"
                    . "'" . $registro["SERIAL RC"] . "')";
                
          $db->query($queryDet);  
          //echo '<pre>';print_r($queryDet);echo '</pre>';
   
}

function consultarCamposMapeo($nomTabla){
        global $db;
        $query = "SELECT * FROM meiko.mapeo_datos mp WHERE mp.tabla ='".$nomTabla."' "; 
        $db->query($query);
        return $db->getArray();
}


function consultarColumnasInfSchema($nomTabla){
        global $db;
        $query = "SELECT COLUMN_NAME as campo "
                . "FROM INFORMATION_SCHEMA.COLUMNS "
                . "WHERE TABLE_NAME = '" . $nomTabla . "' "
                . "AND TABLE_SCHEMA = 'calidad' "
                . "AND COLUMN_NAME NOT IN ('id') "; 
        $db->query($query);
        return $db->getArray();
}

function traerIdCategoriaBienAseCafe($nombreCate){
        global $db;
        
        $query="SELECT id FROM mundolimpieza.listavalor WHERE valor = '" . $nombreCate . "'";
	$db->query($query);
        return $db->fetch();
    }
    
function traerIdTipoCate($nombreCate){
        global $db;
        
        $query="SELECT id FROM mundolimpieza.listavalor WHERE valor = '" . $nombreCate . "'";
	$db->query($query);
        return $db->fetch();
    }
    
function traerIdMarca($nombreMarca){
        global $db;
        
        $query="SELECT id FROM mundolimpieza.marca WHERE nombre = '" . $nombreMarca . "'";
	$db->query($query);
        return $db->fetch();
    }
    
function traerIdEstadoProd($nombreEstado){
        global $db;
        
        $query="SELECT id FROM mundolimpieza.listavalor WHERE tipo = 'EstadoProducto' AND valor = '" . $nombreEstado . "'";
	$db->query($query);
        return $db->fetch();
    }

?>