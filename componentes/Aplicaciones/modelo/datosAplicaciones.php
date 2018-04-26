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
class DatosAplicaciones extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectAplicaciones(){
        global $db;
        
        $query="SELECT  a.*
                FROM    ext_aplicaciones a";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function datosAplicaciones($arreglo){
		global $db;
		$query="SELECT * FROM ext_aplicaciones WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarAplicaciones($arreglo){
        global $db;
        
        $query="SELECT ext.*
                FROM    ext_aplicaciones ext
                WHERE c.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    
    function insertarAplicaciones($arreglo){
            
		global $db;
		$query="INSERT INTO ext_aplicaciones"
                        ."("
                        ."  descripcion,"
                        ."  codigoAplicacion,"
                        ."  estado,"
                        ."  anio,"
                        ."  ciclo"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['descripcion'] . "',"
                        ."'". $arreglo['codigoAplicacion'] . "',"
                        ."'". $arreglo['estado'] . "',"
                        ."'". $arreglo['anio'] . "',"
                        ."'". $arreglo['ciclo'] . "'"
                        .")";	
		            
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Aplicaciones", $query, "insertarAplicaciones");
    }
    
    function actualizarAplicaciones($arreglo){            
		global $db;
                
		$query="UPDATE ext_aplicaciones SET "
                            ."descripcion = '". $arreglo['descripcion'] . "',"
                            ."codigoAplicacion = '". $arreglo['codigoAplicacion'] . "',"
                            ."estado = '". $arreglo['estado'] . "',"
                            ."anio = '". $arreglo['anio'] . "',"
                            ."ciclo = '". $arreglo['ciclo'] . "'"
                            ." WHERE id = " . $arreglo["id"];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Aplicaciones", $query, "actualizarAplicaciones");
    }
    
    function eliminarAplicaciones($id){
        global $db;
        $query="DELETE FROM ext_aplicaciones WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Aplicaciones", $query, "borrarAplicaciones");
    }
    
    function inactivarAplicaciones($id){
        global $db;
        $query="UPDATE ext_aplicaciones SET estado='Inactivo' WHERE id = " . $id ;
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Aplicaciones", $query, "inactivarAplicaciones");
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
   
}
