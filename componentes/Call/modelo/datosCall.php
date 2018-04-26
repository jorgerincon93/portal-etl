<?php

/**
 * 
 * 
 * @author ammonroyc
 * @package componentes
 */

/**
 * Inclusion Clase BDControlador
 * Permite heredar de la clase BDControlador, esta se encarga de realizar el proceso de CRUD dinamico.
 */
//PENDIENTE
require_once(CLASSES_PATH.'BDControlador.php');

/**
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosCall extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectCall(){
        global $db;
        
     $query="SELECT  a.*
                FROM    calidad.cal_resultado_registro a ";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function datosCall($arreglo){
		global $db;
		$query="SELECT * FROM calidad.cal_resultado_registro WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarCall($arreglo){
        global $db;
       
        $query="SELECT Cal.*
                FROM    calidad.cal_resultado_registro Cal
                WHERE C.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerRegistroCall($idRegistroEncuesta){
        global $db;
           
        $query = "SELECT cade.TelefonoFijo, cade.Celular
                    FROM calidad.ext_demografico cade
                   WHERE cade.idRegistroEncuesta = $idRegistroEncuesta
                     AND cade.TelefonoFijo IS NOT NULL
                     AND cade.TelefonoFijo <> '0'
                     AND cade.Celular IS NOT NULL
                     AND cade.Celular <> '0'";
        
        $db->query($query);
        return $db->getArray();
    } 
    
 
    function retornarNombreUsuarioCall($idUsuarioModificador){
        
        global $db;
        $query = "SELECT us.id, us.nombre FROM usuarios us WHERE us.id = $idUsuarioModificador";
		
	$db->query($query);
	return $db->fetch();
    }
    
    function actualizarCall($arreglo){            
	global $db;
                
		$query="UPDATE calidad.cal_resultado_registro SET "
                            ."res_call = '". $arreglo['res_call'] . "',"
                            . "idUsuarioModificador = '" . $arreglo["idModificador"] . "',"
                            . "fechaModificacion = now()"
                            ." WHERE id = " . $arreglo["id"];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Call", $query, "actualizarCall");
    }
    
    function actualizarRegistroCall($arreglo){            
	global $db;
                
		$query="UPDATE calidad.ext_demografico SET "
                            ."TelefonoFijo = '". $arreglo['telefonoFijo'] . "',"
                            . "Celular = '" . $arreglo["celular"] . "'"
                            ." WHERE idRegistroEncuesta = " . $arreglo["idRegistroEncuesta"];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Call", $query, "actualizarRegistroCall");
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
   
}