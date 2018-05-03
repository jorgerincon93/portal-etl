<?php

/**
 * 
 * 
 * @author Jorge Rincon
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
class DatosCertiLabo extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectUsr($id){
        global $db;
        
        $query="SELECT  a.*
                FROM    etlsoluciones_portal.empleados a where a.id = $id";
            
        $db->query($query);
        return $db->fetch();
    }

    public function traerIdEmpleado($id){
        global $db;
        
        $query="SELECT idEmpleado FROM etlsoluciones_portal.usuario where id = $id";
            
        $db->query($query);
        return $db->fetch();
    }

    public function traerPeriEmple($id){
        global $db;
        
        $query="SELECT *
                  FROM etlsoluciones_portal.empleadoitemnomina a
                 WHERE a.estado = 21
                   AND a.idEmpleado = $id";
            
        $db->query($query);
        return $db->getArray();
    }

    public function selectCertiLabSinSuel($id){
        global $db;
        
        $query="SELECT emp.nombre,
                       emp.tipoDocumento,
                       emp.numeroDocumento,
                       emp.fechaIngreEmple,
                       emp.cargo,
                       emp.tipoContrato
                  FROM etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.empleadoitemnomina empitm,
                       etlsoluciones_portal.itemnomina itmnom
                 WHERE emp.id = $id
                   AND emp.id = empitm.idEmpleado
                   AND empitm.idItem = itmnom.id
                   limit 1";
          
        $db->query($query);
        return $db->fetch();
    }

    public function selectCertiLabConSuel($id){
        global $db;
        
        $query="SELECT emp.nombre,
                       emp.tipoDocumento,
                       emp.numeroDocumento,
                       emp.fechaIngreEmple,
                       emp.cargo,
                       emp.tipoContrato,
                       itmnom.descripcion,
                       empitm.valor
                  FROM etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.empleadoitemnomina empitm,
                       etlsoluciones_portal.itemnomina itmnom
                 WHERE emp.id = $id
                   AND emp.id = empitm.idEmpleado
                   AND empitm.idItem = itmnom.id
                   AND empitm.estado = 21
                   AND itmnom.tipo = 19";
          
        $db->query($query);
        return $db->getArray();
    }

    public function selectDespreNomiIngresos($id){
        global $db;
        
        $query="SELECT emp.nombre,
                       emp.tipoDocumento,
                       emp.numeroDocumento,
                       emp.fechaIngreEmple,
                       emp.cargo,
                       emp.tipoContrato,
                       empitm.valor,
                       empitm.fechaInicio,
                       empitm.fechaFin,
                       itmnom.codigo,
                       itmnom.descripcion,
                       empitm.fechaFin
                  FROM etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.empleadoitemnomina empitm,
                       etlsoluciones_portal.itemnomina itmnom
                 WHERE emp.id = $id
                   AND itmnom.tipo = 19
                   AND empitm.estado = 21
                   AND emp.id = empitm.idEmpleado
                   AND empitm.idItem = itmnom.id
                   ORDER BY empitm.fechaFin ASC";
          
        $db->query($query);
        return $db->getArray();
    }
    
     public function selectDespreNomiEgresos($id){
        global $db;
        
        $query="SELECT emp.nombre,
                       emp.tipoDocumento,
                       emp.numeroDocumento,
                       emp.fechaIngreEmple,
                       emp.cargo,
                       emp.tipoContrato,
                       empitm.valor,
                       empitm.fechaInicio,
                       empitm.fechaFin,
                       itmnom.codigo,
                       itmnom.descripcion
                  FROM etlsoluciones_portal.empleados emp,
                       etlsoluciones_portal.empleadoitemnomina empitm,
                       etlsoluciones_portal.itemnomina itmnom
                 WHERE emp.id = $id
                   AND itmnom.tipo = 20
                   AND empitm.estado = 21
                   AND emp.id = empitm.idEmpleado
                   AND empitm.idItem = itmnom.id";
          
        $db->query($query);
        return $db->getArray();
    }

    function selectAreaMetropol($arreglo){
		global $db;
		$query="SELECT * 
                        FROM geo.areametropolitana
                        WHERE id='".$arreglo["id"]."'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosDepto(){
		global $db;
		$query="SELECT * FROM geo.departamento";
		
		$db->query($query);
		return $db->getArray();
    }

    function datosPais(){
		global $db;
		$query="SELECT * FROM geo.pais";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function datosCiudad(){
		global $db;
		$query="SELECT * FROM geo.ciudad";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function datosAreametropol(){
		global $db;
		$query="SELECT * FROM geo.areametropolitana";
		
		$db->query($query);
		return $db->getArray();
    }
   
    public function mostrarGeo($arreglo){
        global $db;
        
        $query="SELECT *
                FROM geo.microzona
                WHERE id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    public function mostrarMicrozona($arreglo){
        global $db;
        
        $query="SELECT * 
                  FROM geo.microzona
                  WHERE id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreCiudad($idCiudad){
		global $db;
		$query="SELECT ciu.ciudad FROM geo.ciudad ciu WHERE ciu.id = $idCiudad";
		
		$db->query($query);
		return $db->getArray();
    }
    
    public function traerRegistroGeo($idRegistroEncuesta){
        global $db;
           
        $query = "SELECT cade.Direccion, cade.Ciudad, cade.Localidad
                    FROM calidad.ext_demografico cade
                   WHERE cade.idRegistroEncuesta = $idRegistroEncuesta
                     AND cade.Direccion = 'FALSE'";
        
        $db->query($query);
        return $db->getArray();
    } 
    
    
    function retornarIdAreaMtr($arreglo){
        global $db;
        
        $query = "SELECT id as idAreaMtrop FROM geo.areametropolitana WHERE areametropolitana ='". $arreglo['areaMtr'] . "'";
	
	$db->query($query);
	return $db->fetch();
    }
    
        function validaPais($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.pais "
                        . "WHERE nombrePais ='". $arreglo['nuevPais'] . "'";

                $db->query($query);
		return $db->getArray();
    }
   
    function validaDepto($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.departamento "
                        . "WHERE nombreDepto ='". $arreglo['nomDepto'] . "'"
                        . "  AND idPais = '". $arreglo['idPais'] . "'"
                        . "  AND CodigoDane = '". $arreglo['codDane']. "'";

                $db->query($query);
		return $db->getArray();
    }
    
    function validaCiudad($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.ciudad "
                        . "WHERE id ='". $arreglo['idCiudad'] . "'"
                        . "  AND ciudad = '". $arreglo['ciudad'] . "'"
                        . "  AND idAreaMetropolitana = '". $arreglo['idAreaMetro']. "'";

                $db->query($query);
		return $db->getArray();
    }
    
    function validaAreaMetropol($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.areametropolitana "
                        . "WHERE areametropolitana ='". $arreglo['nuevAreaMetropol'] . "'";

                $db->query($query);
		return $db->getArray();
    }
    
    function validaMunicipio($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.municipio "
                        . "WHERE nombreMunicipio ='". $arreglo['municipio'] . "'"
                        . " AND idDepto ='". $arreglo['depto'] . "'"
                        . " AND CodigoDane ='". $arreglo['codDane'] . "'";
                
                $db->query($query);
		return $db->getArray();
    }
    
    function validaLocalidad($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.localidad "
                        . "WHERE id ='". $arreglo['idLocalidad'] . "'"
                        . " AND nombreLocalidad ='". $arreglo['nomLocalidad'] . "'"
                        . " AND idCiudad ='". $arreglo['idCiu'] . "'";
        
                $db->query($query);
		return $db->getArray();
    }
    
    function validaSubLocalidad($arreglo){
		global $db;
                
		$query="SELECT * FROM geo.sublocalidad "
                        . "WHERE id ='". $arreglo['idSubLocalidad'] . "'"
                        . " AND nombreSubLocalidad ='". $arreglo['nomSubLocalidad'] . "'"
                        . " AND idLocalidad ='". $arreglo['idLocali'] . "'";
        
                $db->query($query);
		return $db->getArray();
    }
    
    function actualizarMicrozona($arreglo){            
		global $db;
                
		$query="UPDATE geo.microzona SET "
                            ."idCiudad= '". $arreglo['idCiudadEdit'] . "',"
                            . "idMunicipio = '" . $arreglo['idMunicipioEdit'] . "',"
                            . "codigoDane = '" . $arreglo['codigoDaneEdit'] . "',"
                            . "nic = '" . $arreglo['nicEdit'] . "',"
                            . "nicDane = '" . $arreglo['nicDaneEdit'] . "',"
                            . "areaKm = '" . $arreglo['areaKmEdit'] . "',"
                            . "idLocalidad = '" . $arreglo['localidadEdit'] . "',"
                            . "idSubLocalidad = '" . $arreglo['subLocalidadEdit'] . "'"
                            ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "actualizarMicrozona");
    }
    
    function actualizarRegistroGeo($arreglo){            
	global $db;
                
		$query="UPDATE calidad.ext_demografico SET "
                            ."Ciudad = '". $arreglo['ciudad'] . "',"
                            . "Localidad = '" . $arreglo["localidad"] . "'"
                            ." WHERE idRegistroEncuesta = " . $arreglo["idRegistroEncuesta"];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Call", $query, "actualizarRegistroCall");
    }
    
    function insertarDepto($arreglo){
            
		global $db;
		$query="INSERT INTO geo.departamento"
                        ."("
                        ."  nombreDepto,"
                        ."  idPais,"
                        ."  CodigoDane"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nomDepto'] . "',"
                        ."'". $arreglo['idPais'] . "',"
                        ."'". $arreglo['codDane'] . "'"
                        .")";	
        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarDepto");
    }
    
    function insertarPais($arreglo){
            
		global $db;
		$query="INSERT INTO geo.pais"
                        ."("
                        ."nombrePais"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nuevPais'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarPais");
    }
    
    function insertarCiudad($arreglo){
            
		global $db;
		$query="INSERT INTO geo.ciudad"
                        ."("
                        ."id,"
                        ."ciudad,"
                        ."idAreaMetropolitana "
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['idCiudad'] . "',"
                        ."'". $arreglo['ciudad'] . "',"
                        ."'". $arreglo['idAreaMetro'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarCiudad");
    }
    
    function insertarAreaMetropol($arreglo){
            
		global $db;
		$query="INSERT INTO geo.areaMetropolitana"
                        ."("
                        ."AreaMetropolitana "
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nuevAreaMetropol'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarAreaMetropol");
    }
    
    function insertarMunicipio($arreglo){
            
		global $db;
		$query="INSERT INTO geo.municipio"
                        ."("
                        ."nombreMunicipio,"
                        ."idDepto,"
                        ."CodigoDane"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['municipio'] . "',"
                        ."'". $arreglo['depto'] . "',"
                        ."'". $arreglo['codDane'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarMunicipio");
    }
    
    function insertarLocalidad($arreglo){
            
		global $db;
		$query="INSERT INTO geo.localidad"
                        ."("
                        ."id,"
                        ."nombreLocalidad,"
                        ."idCiudad"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['idLocalidad'] . "',"
                        ."'". $arreglo['nomLocalidad'] . "',"
                        ."'". $arreglo['idCiu'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarLocalidad");
    }
    
    function insertarSubLocalidad($arreglo){
            
		global $db;
		$query="INSERT INTO geo.subLocalidad"
                        ."("
                        ."id,"
                        ."nombreSubLocalidad,"
                        ."idLocalidad"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['idSubLocalidad'] . "',"
                        ."'". $arreglo['nomSubLocalidad'] . "',"
                        ."'". $arreglo['idLocali'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarSubLocalidad");
    }
    
    function insertarMicrozona($arreglo){
        
        global $db;
		$query="INSERT INTO geo.microzona"
                        ."("
                        ."idCiudad,"
                        ."idMunicipio,"
                        ."codigoDane,"
                        ."nic,"
                        ."nicDane,"
                        ."areaKm,"
                        ."idLocalidad,"
                        ."idSublocalidad"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['idCiudad'] . "',"
                        ."'". $arreglo['idMunicipio'] . "',"
                        ."'". $arreglo['codiDane'] . "',"
                        ."'". $arreglo['nic'] . "',"
                        ."'". $arreglo['nicDane'] . "',"
                        ."'". $arreglo['areaKm'] . "',"
                        ."'". $arreglo['localidad'] . "',"
                        ."'". $arreglo['subLocalidad'] . "'"
                        .")";	
         
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Geo Master", $query, "insertarMicrozona");
        
    }
    
    function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
   
}
