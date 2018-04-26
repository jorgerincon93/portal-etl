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
 * Clase "DatosEmpleado"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class datosEmpleado extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosEmpleado"
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
    
    function datosEmpleado(){
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.empleados";
		
		$db->query($query);
		return $db->getArray();
    }
    
    
    function conteoRegistros($wh){
        global $db;

        $query = "SELECT COUNT(*) Total
                    FROM etlsoluciones_portal.empleados u
                   WHERE $wh";

        $db->query($query);
        return $db->fetch();
    }

    function buscar($where){
        global $db;

        $query =  "SELECT u.id,u.nombre,u.tipoDocumento,u.numeroDocumento,
                          u.area,u.email,r.rol,u.estado,u.cargo
                    FROM etlsoluciones_portal.empleados u,
                         etlsoluciones_portal.rol r
                   WHERE u.idRol = r.id"
                . "  $where";
                

        $db->query($query);
        return $db->getArray();
    }

    function SelectEmpleado($arreglo){
        global $db;

        $query = "SELECT * FROM etlsoluciones_portal.empleados us WHERE us.id = '".$arreglo["id"]."'";

        $db->query($query);
        return $db->fetch();
    }

    function nombreUsuario($id){
		global $db;
		$query="SELECT nombreUsuario FROM etlsoluciones_portal.usuario WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarEmpleado($arreglo){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    etlsoluciones_portal.empleados u,
                        etlsoluciones_portal.rol r
                WHERE u.idRol=r.id
                    AND u.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function treaerIdUsr($idEmpl){
        global $db;
        
        $query="SELECT u.id
                  FROM etlsoluciones_portal.usuario u
                 WHERE u.idEmpleado = $idEmpl "  ;
            
        $db->query($query);
        return $db->fetch();
    }

    function validarRepetido($arreglo){
            
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.empleados WHERE $arreglo[campo] = '$arreglo[valorCampo]'";
		
		if(isset($arreglo['id']) && !empty($arreglo['id'])){
			$query.=" AND id <> $arreglo[id]";
		}
                
		$db->query($query);
		return $db->getArray();
    }
    
    function insertarEmpleado($arreglo){
            
		global $db;
		$query="INSERT INTO etlsoluciones_portal.empleados"
                        ."("
                        ."  nombre,"
                        ."  tipoDocumento,"
                        ."  numeroDocumento,"
                        ."  area,"
                        ."  email,"
                        ."  idRol,"
                        ."  estado,"
                        ."  tipoContrato,"
                        ."  fechaIngreEmple,"
                        ."  cargo"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['empleado'] . "',"
                        ."'". $arreglo['selectTipoDoc'] . "',"
                        ."'". $arreglo['docu'] . "',"
                        ."'". $arreglo['selectArea'] . "',"
                        ."'". $arreglo['email'] . "',"
                        ."'". $arreglo['selcetRol'] . "',"
                        ."'". $arreglo['selectEstado'] . "',"
                        ."'". $arreglo['selectTipoContra'] . "',"
                        ."'". $arreglo['fechIngreCom'] . "',"
                        ."'". $arreglo['selectCargo'] . "'"
                        .")";	
		            
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Empleado", $query, "insertarEmpleado");
    }
    
    function actualizarEmpleado($arreglo){            
		global $db;
                
               
		$query="UPDATE etlsoluciones_portal.empleados SET "
                            ."nombre = '". $arreglo['empleado'] . "',"
                            ."tipoDocumento = '". $arreglo['selectTipoDoc'] . "',"
                            ."numeroDocumento = '". $arreglo['docu'] . "',"
                            ."area = '". $arreglo['selectArea'] . "',"
                            ."email = '". $arreglo['email'] . "',"
                            ."idRol = '". $arreglo['selcetRol'] . "',"
                            ."estado = '". $arreglo['selectEstado'] . "', "
                            ."tipoContrato = '". $arreglo['selectTipoContra'] . "', "
                            ."fechaIngreEmple = '". $arreglo['fechIngreCom'] . "', "
                            ."cargo = '". $arreglo['selectCargo'] . "'"
                            ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Empleado", $query, "actualizarEmpleado");
       //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Usuario", $funcion = "Actualiza Usuario " . $arreglo['nombre']);
    }

    function actualizarIdRolUsr($idRol,$id){            
        global $db;
                
               
        $query="UPDATE etlsoluciones_portal.usuario SET "
                            ."idRol = '". $idRol . "'"
                            ." WHERE id = " . $id;   
             
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Empleado", $query, "actualizarEmpleado");
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