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

/**
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosPrivilegios extends BDControlador{ 
	
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
                FROM    mundolimpieza.usuario u,
                        rol r
                WHERE u.idRol=r.id";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datoPrivilegios($arreglo){
		global $db;
		$query="SELECT * FROM mundolimpieza.roles_menu WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function nombrePrivilegios($id){
		global $db;
		$query="SELECT * FROM mundolimpieza.roles_menu WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarUsuario($arreglo){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    mundolimpieza.usuario u,
                        mundolimpieza.rol r
                WHERE u.idRol=r.id
                    AND u.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerNombreRol($rol){
        global $db;
        
        $query="SELECT r.rol 
                  FROM mundolimpieza.rol r 
                 WHERE r.id = '$rol'";
            
    	$db->query($query);
	return $db->fetch();
    }
    
     public function traerNombreMenu($id){
        global $db;
        
        $query="SELECT r.nombre 
                  FROM mundolimpieza.menu r 
                 WHERE r.id = '$id'";
            
    	$db->query($query);
	return $db->fetch();
    }
    
    function validarRepetido($nomRol){
        
		global $db;
		$query="SELECT COUNT(8) cantRol FROM mundolimpieza.rol where rol = '$nomRol'";
		
                
		$db->query($query);
		return $db->fetch();
    }
    
    function validarRepetidoPadre($arreglo){
        
	global $db;
          $query = "SELECT COUNT(8) cantRepe1 FROM mundolimpieza.roles_menu "
                  . " WHERE idRol = '".$arreglo["rol"]."'"
                  . " AND idMenu = '".$arreglo["menuPadre"]."'"
                  . " AND editar = '".$arreglo["editar"]."'"
                  . " AND eliminar = '".$arreglo["eliminar"]."'"
                  . " AND crear = '".$arreglo["crear"]."'";
    
        $db->query($query);
	return $db->fetch();
    }

    function validarRepetidoHijo($arreglo){
        
	global $db;
           $query = "SELECT COUNT(8) cantRepe2 FROM mundolimpieza.roles_menu "
                  . " WHERE idRol = '".$arreglo["rol"]."'"
                  . " AND idMenu = '".$arreglo["menuHijo"]."'"
                  . " AND editar = '".$arreglo["editar"]."'"
                  . " AND eliminar = '".$arreglo["eliminar"]."'"
                  . " AND crear = '".$arreglo["crear"]."'";
    
        $db->query($query);
	return $db->fetch();
        
    }
    
    function validarRepetidoHijo1($arreglo){
        
        global $db;
        
        if(isset($arreglo["menuHijo2"]) == NULL){
            
            $arreglo["menuHijo2"] = 0;
            
        }
        
           $query = "SELECT COUNT(8) cantRepe3 FROM mundolimpieza.roles_menu "
                  . " WHERE idRol = '".$arreglo["rol"]."'"
                  . " AND idMenu = '".$arreglo["menuHijo2"]."'"
                  . " AND editar = '".$arreglo["editar"]."'"
                  . " AND eliminar = '".$arreglo["eliminar"]."'"
                  . " AND crear = '".$arreglo["crear"]."'";
        echo'<pre>';print_r($query);echo'</pre>';
        $db->query($query);
	return $db->fetch();
       
          
    }
    
    function insertarRol($arreglo){
   
        global $db;
        $query = "INSERT INTO mundolimpieza.rol"
                . "("
                . "rol"
                . ")"
                . "VALUES("
                ."'". $arreglo['nomRol'] . "'"
                . ")";
     
        $db->query($query);
        //$this->log($_SESSION['datos_logueo']['login'], "Privilegio", $query, "insertarRol");
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegio", $funcion = "Nuevo Rol " . $arreglo['nomRol']);
    
    }
    
    function insertarPrivilegioPadre($arreglo){
        
		global $db;
		$query="INSERT INTO mundolimpieza.roles_menu"
                        ."("
                        ."  idRol,"
                        ."  idMenu,"
                        ."  editar,"
                        ."  eliminar,"
                        ."  crear"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['rol'] . "',"
                        ."'". $arreglo['menuPadre'] . "',"
                        ."'". $arreglo['editar'] . "',"
                        ."'". $arreglo['eliminar'] . "',"
                        ."'". $arreglo['crear'] . "'"
                        .")";	
                
                $db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Privilegio", $query, "insertarPrivilegio");
           $nomMenu = $this->traerNombreMenu($arreglo['menuPadre']);
           $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegio", $funcion = "Nuevo Permiso " . $nomMenu->nombre);
                
    }            
                
    function insertarPrivilegioHijo($arreglo){
        
        
		global $db;    
                
        $query="INSERT INTO mundolimpieza.roles_menu"
                        ."("
                        ."  idRol,"
                        ."  idMenu,"
                        ."  editar,"
                        ."  eliminar,"
                        ."  crear"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['rol'] . "',"
                        ."'". $arreglo['menuHijo'] . "',"
                        ."'". $arreglo['editar'] . "',"
                        ."'". $arreglo['eliminar'] . "',"
                        ."'". $arreglo['crear'] . "'"
                        .")";
                
		$db->query($query);
               
           //     $this->log($_SESSION['datos_logueo']['login'], "Privilegio", $query, "insertarPrivilegio");
           $nomMenu = $this->traerNombreMenu($arreglo['menuPadre']);
           $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegio", $funcion = "Nuevo Permiso Hijo " . $nomMenu->nombre);     
       
    }
    
    function insertarPrivilegioHijo2($arreglo){
        
        
		global $db;    
                
                if(!isset($arreglo["menuHijo2"])){
            
                     $arreglo["menuHijo2"] = 0;
            
                }
                
        $query="INSERT INTO mundolimpieza.roles_menu"
                        ."("
                        ."  idRol,"
                        ."  idMenu,"
                        ."  editar,"
                        ."  eliminar,"
                        ."  crear"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['rol'] . "',"
                        ."'". $arreglo['menuHijo2'] . "',"
                        ."'". $arreglo['editar'] . "',"
                        ."'". $arreglo['eliminar'] . "',"
                        ."'". $arreglo['crear'] . "'"
                        .")";
                
		$db->query($query);
               
                //$this->log($_SESSION['datos_logueo']['login'], "Privilegio", $query, "insertarPrivilegio");
        $nomMenu = $this->traerNombreMenu($arreglo['menuPadre']);
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegio", $funcion = "Nuevo Permiso Hijo " . $nomMenu->nombre);        
       
    }
    
    function actualizarPrivilegios($arreglo){            
		global $db;
                
		$query="UPDATE mundolimpieza.roles_menu SET "
                            //."idRol = '". $arreglo['login'] . "',"
                            ."idMenu = '". $arreglo['menu'] . "',"
                            ."editar = '". $arreglo['editar'] . "',"
                            ."eliminar = '". $arreglo['eliminar'] . "',"
                            ."crear = '". $arreglo['crear'] . "'".
                        " WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Privilegios", $query, "actualizarPrivilegios");
        $nomMenu = $this->traerNombreMenu($arreglo['menu']);
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegios", $funcion = "Actualiza Privilegio " . $nomMenu->nombre);
    }
    
    function inactivarPrivilegios($id){
        global $db;
        
        $query="DELETE FROM mundolimpieza.roles_menu WHERE id = '$id'";
		              
	$db->query($query);
        //$this->log($_SESSION['datos_logueo']['login'], "Privilegios", $query, "borrarPrivilegio");
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Privilegios", $funcion = "Elimina Privilegio ");
    }
    
     function inactivarUsuario($id){
        global $db;
        $query="UPDATE mundolimpieza.usuario SET estado='Inactivo' WHERE id = " . $id ;
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "inactivarUsuario");
    }
    
    function retornarRol($idRol){
        global $db;
        
        $query="SELECT rol FROM mundolimpieza.rol WHERE id = " . $idRol . " ";		              
	$db->query($query);
        $rol = $db->fetch();
        return $rol->rol;
    }
    
    function listaRoles(){
        global $db;
        
        $query="SELECT id,rol FROM mundolimpieza.rol";		              
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