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
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosUsuario extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
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
    
    function datosUsuario(){
		global $db;
        $query="SELECT us.* FROM etlsoluciones_portal.usuario us";
		/*$query="SELECT us.id,
                       us.login,
                       us.nombreUsuario,
                       us.ultimoIngreso,
                       us.estado,
                       us.intento,
                       ro.rol,
                       em.nombre
                  FROM etlsoluciones_portal.usuario us,
                       etlsoluciones_portal.rol ro,
                       etlsoluciones_portal.empleados em
                 Where us.idRol = ro.id
                   and us.idEmpleado = em.id";*/
		
		$db->query($query);
		return $db->getArray();
    }
    
    
    function conteoRegistros($wh){
        global $db;

        $query = "SELECT COUNT(*) Total
                    FROM etlsoluciones_portal.usuario u
                   WHERE $wh";

        $db->query($query);
        return $db->fetch();
    }

    function buscar($where){
        global $db;

        $query =  "SELECT u.id,u.login,u.nombreUsuario,r.rol,u.estado,u.intento,u.ultimoIngreso
                    FROM etlsoluciones_portal.usuario u,
                         etlsoluciones_portal.rol r
                   WHERE u.idRol = r.id"
                . "  $where";
                

        $db->query($query);
        return $db->getArray();
    }

    function SelectUsr($arreglo){
        global $db;

        $query = "SELECT * FROM etlsoluciones_portal.usuario us WHERE us.id = '".$arreglo["id"]."'";

        $db->query($query);
        return $db->fetch();
    }

    function traerIdRolUsr($id){
		global $db;
		$query="SELECT idRol FROM etlsoluciones_portal.empleados WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function nombreUsuario($id){
        global $db;
        $query="SELECT nombreUsuario FROM etlsoluciones_portal.usuario WHERE id = $id";
        
        $db->query($query);
        return $db->fetch();
    }

    public function mostrarUsuario($arreglo){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    etlsoluciones_portal.usuario u,
                        etlsoluciones_portal.rol r
                WHERE u.idRol=r.id
                    AND u.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function validarRepetido($arreglo){
            
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.usuario WHERE $arreglo[campo] = '$arreglo[valorCampo]'";
		
		if(isset($arreglo['id']) && !empty($arreglo['id'])){
			$query.=" AND id <> $arreglo[id]";
		}
                
		$db->query($query);
		return $db->getArray();
    }
    
    function insertarUsuario($arreglo){
            
		global $db;
		$query="INSERT INTO etlsoluciones_portal.usuario"
                        ."("
                        ."  login,"
                        ."  clave,"
                        ."  estado,"
                        ."  idEmpleado,"
                        ."  nombreUsuario,"
                        ."  idRol"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['usuario'] . "',"
                        ."'". $arreglo['clave'] . "',"
                        ."'". $arreglo['selectEstado'] . "',"
                        ."'". $arreglo['selectEmpleado'] . "',"
                        ."'". $arreglo['usuarioNombre'] . "',"
                        ."'". $arreglo["idRol"] . "'"
                        .")";   	
		            
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "insertarUsuario");
        //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Usuario", $funcion = "Nuevo Usuario " . $arreglo['nombre']);
    }
    
    function actualizarUsuario($arreglo){            
		global $db;
                
                echo'<pre>';print_r($arreglo);echo'</pre>';
                
                $textoClave = "";
                
                if(!empty($arreglo['clave']) != null){
                    $textoClave = ",clave = '". $arreglo['clave'] . "'";
                }
                
		$query="UPDATE etlsoluciones_portal.usuario SET "
                            ."login = '". $arreglo['usuario'] . "',"
                            ."intento = '". $arreglo['intento'] . "',"
                            ."estado = '". $arreglo['selectEstado'] . "', "
                            ."idEmpleado = '". $arreglo['selectEmpleado'] . "'"
                            . $textoClave .
                        " WHERE id = " . $arreglo['id'];	
		        
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