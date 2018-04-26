<?php 
/**
 * 
 * 
 * @author jarz
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
class DatosClientes extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectClientes(){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.cliente c";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosCliente($arreglo){
		global $db;
		$query="SELECT * FROM mundolimpieza.cliente WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function nombreCliente($id){
		global $db;
		$query="SELECT nombre FROM mundolimpieza.cliente WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarCliente($arreglo){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.cliente c
                WHERE c.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    
    function insertarCliente($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.cliente"
                        ."("
                        ."  nombre,"
                        ."  tipoDocumento,"
                        ."  documento,"
                        ."  numeroContrato,"
                        ."  numeroCodigo,"
                        ."  vigencia,"
                        ."  sedes,"
                        ."  insumos,"
                        ."  cantidadOperarios,"
                        ."  telefono,"
                        ."  email,"
                        ."  direccion,"
                        ."  personaContacto,"
                        . " estado"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nombre'] . "',"
                        ."'". $arreglo['tipoDocumento'] . "',"
                        ."'". $arreglo['documento'] . "',"
                        ."'". $arreglo['numeroContrato'] . "',"
                        ."'". $arreglo['numeroCodigo'] . "',"
                        ."'". $arreglo['vigencia'] . "',"
                        ."'". $arreglo['sedes'] . "',"
                        ."'". $arreglo['insumos'] . "',"
                        ."'". $arreglo['cantidadOperarios'] . "',"
                        ."'". $arreglo['telefono'] . "',"
                        ."'". $arreglo['email'] . "',"
                        ."'". $arreglo['direccion'] . "',"
                        ."'". $arreglo['personaContacto'] . "',"
                        ."'". $arreglo['estado'] . "'"
                        
                        .")";	
		            
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "insertarCliente");
                $this->logMovimiento($_SESSION['datos_logueo']['login'], "Clientes", $funcion = "Nuevo Cliente " . $arreglo['nombre']);
    }
    
    function actualizarCliente($arreglo){            
		global $db;
                
		$query="UPDATE mundolimpieza.cliente SET "
                            ."nombre = '". $arreglo['nombre'] . "',"
                            ."tipoDocumento = '". $arreglo['tipoDocumento'] . "',"
                            ."documento = '". $arreglo['documento'] . "',"
                            ."numeroContrato = '". $arreglo['numeroContrato'] . "',"
                            ."numeroCodigo = '". $arreglo['numeroCodigo'] . "',"
                            ."vigencia = '". $arreglo['vigencia'] . "',"
                            ."sedes = '". $arreglo['sedes'] . "',"
                            ."insumos = '". $arreglo['insumos'] . "',"
                            ."cantidadOperarios = '". $arreglo['cantidadOperarios'] . "',"
                            ."telefono = '". $arreglo['telefono'] . "',"
                            ."email = '". $arreglo['email'] . "',"
                            ."direccion = '". $arreglo['direccion'] . "',"
                            ."personaContacto = '". $arreglo['personaContacto'] . "',"
                            ."estado = '". $arreglo['estado'] . "'"
                         ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "actualizarCliente");
                $this->logMovimiento($_SESSION['datos_logueo']['login'], "Clientes", $funcion = "Actualiza Cliente " . $arreglo['nombre']);
    }
    
    function eliminarCliente($id){
        global $db;
        $query="DELETE FROM mundolimpieza.cliente WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "borrarCliente");
    }
    
    function inactivarCliente($id){
        global $db;
        $query="UPDATE mundolimpieza.cliente SET estado='Inactivo' WHERE id = " . $id ;
		              
	$db->query($query);
        //$this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "inactivarCliente");
        
        $nombreCliente  = $this->nombreCliente($id);
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Clientes", $funcion = "Inactiva Cliente " . $nombreCliente->nombre);
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM mundolimpieza.listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
    function logMovimiento($user,$modulo,$funcion){
        
        global $db;
        
        $query = "INSERT INTO mundolimpieza.logmovimientos"
                        ."("
                        ."  usuario,"
                        ."  modulo,"
                        ."  funcion,"
                        ."  fecha"
                        .")" 
                        ."VALUES("
                        ."'". $user . "',"
                        ."'". $modulo . "',"
                        ."'". $funcion . "',"
                        . "now()"
                        .")";	
		            
	$db->query($query);  
        
        
    }
   
}
?>