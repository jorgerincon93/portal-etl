<?php 
/**
 * 
 * 
 * @author jarinz
 * @package componentes
 */

/**
 * Inclusion Clase BDControlador
 * Permite heredar de la clase BDControlador, esta se encarga de realizar el proceso de CRUD dinamico.
 */
//PENDIENTE
require_once(CLASSES_PATH.'BDControlador.php');
//require_once(CLASSES_PATH. 'anexgrid.php');

/**
 * Clase "DatosNomina"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class datosNomina extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosNomina"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }

    public function selectUsuarios(){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    etlsoluciones_portal.usuario u,
                        rol r
                WHERE u.idRol=r.id";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosNomina(){
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.itemnomina";
		
		$db->query($query);
		return $db->getArray();
    }
    
    
    function conteoRegistros($wh){
        global $db;

        $query = "SELECT COUNT(*) Total
                    FROM etlsoluciones_portal.itemnomina u
                   WHERE $wh";

        $db->query($query);
        return $db->fetch();
    }

    function buscar($where){
        global $db;

        $query =  "SELECT u.id,u.codigo,u.descripcion,r.valor tipo
                    FROM etlsoluciones_portal.itemnomina u,
                         etlsoluciones_portal.listavalor r
                   WHERE u.tipo = r.id"
                . "  $where";
                

        $db->query($query);
        return $db->getArray();
    }

    function SelectNomina($arreglo){
        global $db;

        $query = "SELECT * FROM etlsoluciones_portal.itemnomina us WHERE us.id = '".$arreglo["id"]."'";

        $db->query($query);
        return $db->fetch();
    }

    function nombreUsuario($id){
		global $db;
		$query="SELECT nombreUsuario FROM etlsoluciones_portal.usuario WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarNomina($arreglo){
        global $db;
        
        $query="SELECT  u.*,r.valor tipo
                FROM    etlsoluciones_portal.itemnomina u,
                        etlsoluciones_portal.listavalor r
                WHERE u.tipo=r.id
                    AND u.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function validarRepetido($arreglo){
            
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.Nominas WHERE $arreglo[campo] = '$arreglo[valorCampo]'";
		
		if(isset($arreglo['id']) && !empty($arreglo['id'])){
			$query.=" AND id <> $arreglo[id]";
		}
                
		$db->query($query);
		return $db->getArray();
    }
    
    function insertarNomina($arreglo){
            
		global $db;
		$query="INSERT INTO etlsoluciones_portal.itemnomina"
                        ."("
                        ."  codigo,"
                        ."  tipo,"
                        ."  descripcion"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['codigo'] . "',"
                        ."'". $arreglo['selectTipo'] . "',"
                        ."'". $arreglo['descript'] . "'"
                        .")";	
		            
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Nomina", $query, "insertarNomina");
    }
    
    function actualizarNomina($arreglo){            
		global $db;
                
		$query="UPDATE etlsoluciones_portal.itemnomina SET "
                            ."codigo = '". $arreglo['codigo'] . "',"
                            ."tipo = '". $arreglo['selectTipo'] . "',"
                            ."descripcion = '". $arreglo['descript'] . "'"
                            ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "actualizarUsuario");
       //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Usuario", $funcion = "Actualiza Usuario " . $arreglo['nombre']);
    }
    
    function borrarUsuario($id){
        global $db;
        $query="DELETE etlsoluciones_portal.usuario WHERE id = " . $arreglo['id'] . " ";
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "borrarUsuario");
    }
    
     function inactivarUsuario($id){
        global $db;
        $query="UPDATE etlsoluciones_portal.usuario SET estado='Inactivo' WHERE id = " . $id ;
		              
	     $db->query($query);

         $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "inactivarUsuario");
    
    }
    
    function retornarRol($idRol){
        global $db;
        
        $query="SELECT rol FROM etlsoluciones_portal.rol WHERE id = " . $idRol . " ";		              
	$db->query($query);
        $rol = $db->fetch();
        return $rol->rol;
    }
    
    function listaRoles(){
        global $db;
        
        $query="SELECT id,rol FROM etlsoluciones_portal.rol";		              
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