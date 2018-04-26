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
class DatosCalendario extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectCalendario(){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    mundolimpieza.usuario u,
                        rol r
                WHERE u.idRol=r.id";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosCalendario($id){
		global $db;
		$query="SELECT * FROM mundolimpieza.evento WHERE id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarCalendario($arreglo){
        global $db;
        
        $query="SELECT  u.*,r.rol
                FROM    mundolimpieza.usuario u,
                        mundolimpieza.rol r
                WHERE u.idRol=r.id
                    AND u.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function listarEvento($feInicio){
        
        global $db;
        
        $query="SELECT  *
                FROM  mundolimpieza.evento e
                WHERE e.fechaInicio = '" . $feInicio ."'
                order by e.id asc";
         
        $db->query($query);
        return $db->getArray();
        
    }
    
    function traerFechaEvento($id){
        
        global $db;
        
        $query="SELECT e.fechaInicio
                FROM  mundolimpieza.evento e
                WHERE e.id = '" . $id ."'";
         
        $db->query($query);
        return $db->fetch();
        
    }
    
    function generarCalendario($mes,$anio){
        
        global $db;
        
        $query="select fechaInicio,count(id) as total 
                from mundolimpieza.evento 
                where month(fechaInicio)= '" . $mes . "'
                  and year(fechaInicio)= '" . $anio . "'
                group by fechaInicio;";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function traerEstadoEvento($idEstado){
        
        global $db;
        
        $query="select nombre
                from mundolimpieza.listavalor lv
                where lv.id = $idEstado
                  and lv.tipo = 'EstadoEvento'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function insertarCalendario($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.usuario"
                        ."("
                        ."  login,"
                        ."  nombreUsuario,"
                        ."  tipoDocumento,"
                        ."  numeroDocumento,"
                        //."  area,"
                        ."  email,"
                        ."  idRol,"
                        //."  tipoAcceso,"
                        ."  clave,"
                        ."  estado"
                        //."  idPadre"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['login'] . "',"
                        ."'". $arreglo['nombre'] . "',"
                        ."'". $arreglo['tipoDocumento'] . "',"
                        ."'". $arreglo['numeroDocumento'] . "',"
                        //."'". $arreglo['area'] . "',"
                        ."'". $arreglo['email'] . "',"
                        ."'". $arreglo['idRol'] . "',"
                        //."'". $arreglo['tipoAcceso'] . "',"
                        ."'". $arreglo['clave'] . "',"
                        ."'". $arreglo['estado'] . "'"
                        //."'". $arreglo['jerarquia'] . "'"
                        .")";	
		            
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "insertarUsuario");
    }
    
    function actualizarCalendario($arreglo){            
		global $db;
                
               
                
		$query="UPDATE mundolimpieza.usuario SET "
                            ."login = '". $arreglo['login'] . "',"
                            ."nombreUsuario = '". $arreglo['nombre'] . "',"
                            ."tipoDocumento = '". $arreglo['tipoDocumento'] . "',"
                            ."numeroDocumento = '". $arreglo['numeroDocumento'] . "',"
                            //."area = '". $arreglo['area'] . "',"
                            ."email = '". $arreglo['email'] . "',"
                            ."idRol = '". $arreglo['idRol'] . "',"
                            ."intento = '". $arreglo['intento'] . "',"
                            //."tipoAcceso = '". $arreglo['tipoAcceso'] . "',"
                            //."idPadre = '". $arreglo['jerarquia'] . "',"
                            ."estado = '". $arreglo['estado'] . "' "
                        .
                        " WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "actualizarUsuario");
    }
    
    function eliminarEvento($id){
        global $db;
        
        $query="UPDATE mundolimpieza.evento ev
                   SET ev.idEstado = 715
                 WHERE ev.id = " . $id . "";	
        
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Evento", $query, "eliminarEvento");
    }
    
     function inactivarCalendario($id){
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
    
    
}
?>