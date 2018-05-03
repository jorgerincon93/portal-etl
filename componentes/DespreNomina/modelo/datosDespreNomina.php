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
 * Clase "DatosDespreNomina"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class datosDespreNomina extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosDespreNomina"
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
    
    function datosDespreNomina(){
		global $db;
		$query="SELECT emp.id,emp.nombre,nomit.descripcion,
                       emit.valor,emit.fechaInicio,emit.fechaFin,ls.valor estado,
                       emit.id idEmpItem
                  FROM etlsoluciones_portal.empleadoitemnomina emit,
                       etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.itemnomina nomit,
                       etlsoluciones_portal.listavalor ls
                 WHERE emit.idEmpleado = emp.id
                   AND emit.idItem = nomit.id
                   ANd emit.estado = ls.id";
		
		$db->query($query);
		return $db->getArray();
    }
    
    
    function conteoRegistros($wh){
        global $db;

        $query = "SELECT COUNT(*) Total
                    FROM etlsoluciones_portal.empleadoitemnomina u
                   WHERE $wh";

        $db->query($query);
        return $db->fetch();
    }

    function buscar($where){
        global $db;

        $query =  "SELECT emp.id,emp.nombre,nomit.descripcion,
                       emit.valor,emit.fechaInicio,emit.fechaFin,ls.valor estado,
                       emit.id idEmpItem
                  FROM etlsoluciones_portal.empleadoitemnomina emit,
                       etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.itemnomina nomit,
                       etlsoluciones_portal.listavalor ls
                 WHERE emit.idEmpleado = emp.id
                   AND emit.idItem = nomit.id
                   ANd emit.estado = ls.id"
                . "  $where";
                

        $db->query($query);
        return $db->getArray();
    }

    function SelectDespreNomina($arreglo){
        global $db;

        $query = "SELECT emp.id idEmple,emp.nombre,nomit.id idItem,nomit.descripcion,
                       emit.valor,emit.fechaInicio,emit.fechaFin,ls.id idEstado,ls.valor estado,emit.id idItemEmple
                  FROM etlsoluciones_portal.empleadoitemnomina emit,
                       etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.itemnomina nomit,
                       etlsoluciones_portal.listavalor ls
                 WHERE emit.idEmpleado = emp.id
                   AND emit.idItem = nomit.id
                   AND emit.estado = ls.id
                   AND emit.id = '".$arreglo["id"]."'";

        $db->query($query);
        return $db->fetch();
    }

    function traerEmpleados(){
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.empleados";
		
		$db->query($query);
		return $db->getArray();
    }
    
    public function mostrarDespreNomina($arreglo){
        global $db;
        
        $query="SELECT emp.id,emp.nombre,nomit.descripcion,
                       emit.valor,emit.fechaInicio,emit.fechaFin,ls.valor estado
                  FROM etlsoluciones_portal.empleadoitemnomina emit,
                       etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.itemnomina nomit,
                       etlsoluciones_portal.listavalor ls
                 WHERE emit.idEmpleado = emp.id
                   AND emit.idItem = nomit.id
                   ANd emit.estado = ls.id
                    AND emit.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function validarRepetido($arreglo){
            
		global $db;
		$query="SELECT * FROM etlsoluciones_portal.DespreNominas WHERE $arreglo[campo] = '$arreglo[valorCampo]'";
		
		if(isset($arreglo['id']) && !empty($arreglo['id'])){
			$query.=" AND id <> $arreglo[id]";
		}
                
		$db->query($query);
		return $db->getArray();
    }
    
    function insertarDespreNomina($arreglo){
            
		global $db;
		$query="INSERT INTO etlsoluciones_portal.empleadoitemnomina"
                        ."("
                        ."  idEmpleado,"
                        ."  idItem,"
                        ."  valor,"
                        ."  fechaInicio,"
                        ."  estado,"
                        ."  fechaFin"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['empleado'] . "',"
                        ."'". $arreglo['item'] . "',"
                        ."'". $arreglo['valor'] . "',"
                        ."'". $arreglo['feIni'] . "',"
                        ."'". $arreglo['estado'] . "',"
                        ."'". $arreglo['feFin'] . "'"
                        .")";	
		            
		    $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "DespreNomina", $query, "insertarDespreNomina");
    }
    
    function actualizarDespreNomina($arreglo){            
		global $db;
                
		$query="UPDATE etlsoluciones_portal.empleadoitemnomina SET "
                            ."idEmpleado = '". $arreglo['empleado'] . "',"
                            ."idItem = '". $arreglo['item'] . "',"
                            ."valor = '". $arreglo['valor'] . "',"
                            ."fechaInicio = '". $arreglo['feIni'] . "',"
                            ."fechaFin = '". $arreglo['feFin'] . "',"
                            ."estado = '". $arreglo['estado'] . "'"
                            ." WHERE id = " . $arreglo['idItemEmple'];	
		        
		    $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Usuario", $query, "actualizarUsuario");
    
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
    
    

}
?>