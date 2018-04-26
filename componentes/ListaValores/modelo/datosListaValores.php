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
class DatosListaValores extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectListaValor(){
        global $db;
        
        $query="SELECT  l.*
                FROM    etlsoluciones_portal.listavalor l";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosListaValor($arreglo){
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.listavalor WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function nombreListaValor($id){
		global $db;
		$query="SELECT nombre FROM etlsoluciones_portal.listavalor WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarListaValor($arreglo){
        global $db;
        
        $query="SELECT  l.*
                FROM    etlsoluciones_portal.listavalor l
                WHERE l.id ='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    
    function insertarListaValor($arreglo){
            
		global $db;
		$query="INSERT INTO etlsoluciones_portal.listavalor"
                        ."("
                        ."  tipo,"
                        ."  valor,"
                        ."  nombre,"
                        ."  texto,"
                        ."  idPadreLista"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['tipo'] . "',"
                        ."'". $arreglo['valor'] . "',"
                        ."'". $arreglo['nombre'] . "',"
                        ."'". $arreglo['texto'] . "',"
                        ."'". $arreglo['idPadreLista'] . "'"                        
                        .")";	
		            
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "ListaValor", $query, "insertarListaValor");
         $this->logMovimiento($_SESSION['datos_logueo']['login'], "ListaValor", $funcion = "Nueva Lista Valor " . $arreglo['nombre']);
    }
    
    function actualizarListaValor($arreglo){            
		global $db;
                
		$query="UPDATE etlsoluciones_portal.listavalor SET "
                            ."tipo = '". $arreglo['tipo'] . "',"
                            ."valor = '". $arreglo['valor'] . "',"
                            ."nombre = '". $arreglo['nombre'] . "',"
                            ."texto = '". $arreglo['texto'] . "',"
                            ."idPadreLista = '". $arreglo['idPadreLista'] . "'"
                      ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "ListaValor", $query, "actualizarListaValor");
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "ListaValor", $funcion = "Actualiza Lista Valor " . $arreglo['nombre']);
    }
    
    function eliminarListaValor($id){
        global $db;
        $query="DELETE FROM etlsoluciones_portal.listavalor WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        //$this->log($_SESSION['datos_logueo']['login'], "ListaValor", $query, "borrarListaValor");
       $nomListaValor = $this->nombreListaValor($id);
       $this->logMovimiento($_SESSION['datos_logueo']['login'], "ListaValor", $funcion = "Elimina Lista Valor " . $nomListaValor->nombre);
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM etlsoluciones_portal.listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
    function logMovimiento($user,$modulo,$funcion){
        
        global $db;
        
        $query = "INSERT INTO etlsoluciones_portal.logmovimientos"
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