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
class DatosCalidad extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectCalidad(){
        global $db;
        
        $query="SELECT  ca.*
                FROM    calidad ca";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosCalidad($arreglo){
		global $db;
		$query="SELECT * FROM calidad WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarCalidad($arreglo){
        global $db;
        
        $query="SELECT  ca.*
                FROM    calidad ca
                WHERE ca.idCalidad='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    
    function insertarCalidad($arreglo){
            
		global $db;
                    $query="INSERT INTO calidad" 
                            ."("
                            ."  geo,"
                            ."  callCenter,"
                            ."  pendiente,"
                            ."  limpieza"
                            .")" 
                            ."VALUES("
                            ."'". $arreglo['geo'] . "',"
                            ."'". $arreglo['call'] . "',"
                            ."'". $arreglo['pendiente'] . "',"
                            ."'". $arreglo['limpieza'] . "'"
                            .")";	
		            
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Calidad", $query, "insertarCalidad");
    }
    
    function actualizarCalidad($arreglo){            
		global $db;
                
		$query="UPDATE calidad SET "
                            ."geo = '". $arreglo['geo'] . "',"
                            ."callCenter = '". $arreglo['call'] . "',"
                            ."pendiente = '". $arreglo['pendiente'] . "',"
                            ."limpieza = '". $arreglo['limpieza'] . "'"
                         ." WHERE idCalidad = " . $arreglo['id'];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Calidad", $query, "actualizarCalidad");
    }
    
    //function eliminarCliente($id){
    //    global $db;
    //    $query="DELETE FROM calidad WHERE id = " . $id . "";
	//echo $query;	              
//	$db->query($query);
  //      $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "borrarCliente"); //calidad
    //}
    
    function inactivarCalidad($id){
        global $db;
        $query="UPDATE calidad SET estado='Inactivo' WHERE idCalidad = " . $id ;
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Calidad", $query, "inactivarCalidad");
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
   
}
?>