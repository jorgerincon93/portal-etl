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
class DatosInsumos extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectProductos(){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.producto c";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function selectProductosLs($id){
		global $db;
		$query="SELECT * FROM mundolimpieza.producto WHERE id =$id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function selectDetProductosLs($id){
		global $db;
		$query="SELECT * FROM mundolimpieza.detalleproducto WHERE idProducto =$id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerUltimoSerial($id){
		global $db;
		$query="SELECT MAX(det.serial) maxser,det.* 
                          FROM mundolimpieza.detalleproducto det 
                          where det.idProducto = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarProductos($arreglo){
        global $db;
        
        $query="SELECT  COUNT(det.idProducto) countDetProducto,c.*,det.*
                FROM    mundolimpieza.producto c,
                        mundolimpieza.detalleproducto det
                WHERE c.id='".$arreglo["id"]."' 
                  AND c.id = det.idProducto";
            
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCantidad($id){
        global $db;
        
        $query="SELECT  COUNT(det.idProducto) countDetProducto
                FROM    mundolimpieza.producto c,
                        mundolimpieza.detalleproducto det
                WHERE c.id='".$id."' 
                  AND c.id = det.idProducto";
            
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerProdLV($idCate){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.listavalor c
                WHERE c.id = $idCate";
            
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreCategoria($id){
        
        global $db;
        
            $query = "SELECT nombre FROM mundolimpieza.listavalor WHERE id = $id";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarNombreTipo($id){
        
        global $db;
        
            $query = "SELECT nombre FROM mundolimpieza.listavalor WHERE id = $id";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarEstadoProd($id){
        
        global $db;
        
            $query = "SELECT nombre FROM mundolimpieza.listavalor WHERE id = $id";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarEstado(){
        
        global $db;
        
            $query = "SELECT id FROM mundolimpieza.listavalor WHERE tipo = 'EstadoProducto' AND valor = 'Inactivo'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarMarca($id){
        global $db;
        
        $query="SELECT nombre FROM mundolimpieza.marca WHERE id = $id";
	$db->query($query);
        
        return $db->fetch();
    }
    
    function retornarNomEstado($id){
        global $db;
        
        $query="SELECT valor FROM mundolimpieza.listavalor WHERE id = $id";
	$db->query($query);
        
        return $db->fetch();
    }
    
    function listacate(){
        global $db;
        
        $query="SELECT id,nombre FROM mundolimpieza.listavalor WHERE tipo = 'CategoriaProducto'";		              
	$db->query($query);
        return $db->getArray();
    }
    
    function listaTipo(){
        global $db;
        
        $query="SELECT id,nombre FROM mundolimpieza.listavalor WHERE tipo = 'TipoProducto'";		              
	$db->query($query);
        return $db->getArray();
    }
    
    function traerIdMarca($nomMarca){
        global $db;
        
        $query="SELECT id id FROM mundolimpieza.marca WHERE nombre = '" . $nomMarca ."'";
	$db->query($query);
        
        return $db->fetch();
    }
    
    function validaMarca($arreglo){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.marca "
                        . "WHERE nombre ='". $arreglo['nuevMarca'] . "'";

                $db->query($query);
		return $db->getArray();
    }
    
    function insertarProductos($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.producto"
                        ."("
                        ."  nombre,"
                       // ."  serial,"
                        ."  referencia,"
                        ."  categoria,"
                        ."  tipo,"
                        ."  idMarca,"
                        ."  tamano,"
                        ."  empaque,"
                        ."  olor,"
                        ."  presentacion,"
                        ."  descripcion,"
                        ."  iva"
                        //."  idZona,"
                        //."  idPersona"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nombre'] . "',"
                        //."'". $arreglo['serial'] . "',"
                        ."'". $arreglo['ref'] . "',"
                        ."'". $arreglo['categoria'] . "',"
                        ."'". $arreglo['tipo'] . "',"
                        ."'". $arreglo['marca'] . "',"
                        ."'". $arreglo['tamano'] . "',"
                        ."'". $arreglo['empaque'] . "',"
                        ."'". $arreglo['olor'] . "',"
                        ."'". $arreglo['presentacion'] . "',"
                        ."'". $arreglo['descripcion'] . "',"
                        ."'". $arreglo['iva'] . "'"
                        //."'". $arreglo['idZona'] . "',"
                        //."'". $arreglo['idPersona'] . "'"
                        .")";	
		         
		$db->query($query);                
                $idProducto = $db->getInsertID();
                //$this->log($_SESSION['datos_logueo']['login'], "Productos", $query, "insertarProductos");
                $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Nuevo Insumo " . $arreglo['nombre']);
                return $idProducto;
    }
    
    function insertarDetProductos($arreglo,$valor){
            
		global $db;
		$query="INSERT INTO mundolimpieza.detalleproducto"
                        ."("
                         ."serial,"
                         ."estado,"
                         ."idProducto"
                        .")" 
                        ."VALUES("
                        ."'". $valor . "',"
                        ."'". $arreglo['estadoPro'] . "',"
                        ."'". $arreglo['idProducto'] . "'"
                        .")";	
		
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Productos", $query, "insertarDetProductos");
                //$producto  = $this->selectProductosLs($arreglo['idProducto']);
               // $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Nuevo Detalle Insumo " . $producto->nombre);
    }
    
    function insertarMarca($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.marca"
                        ."("
                        ."nombre"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['nuevMarca'] . "'"
                        .")";	
         
		$db->query($query);
               // $this->log($_SESSION['datos_logueo']['login'], "Insumos", $query, "insertarMarca");
           $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Nueva Marca " . $arreglo['nuevMarca']);
    }
    
    function actualizarProductos($arreglo){
		global $db;
                
		$query="UPDATE mundolimpieza.producto SET "
                            ."nombre = '". $arreglo['nombre'] . "',"
                            //."serial = '". $arreglo['serial'] . "',"
                            ."referencia = '". $arreglo['ref'] . "',"
                            ."categoria = '". $arreglo['categoria'] . "',"
                            ."tipo = '". $arreglo['tipo'] . "',"
                            ."idMarca = '". $arreglo['marca'] . "',"
                            ."tamano = '". $arreglo['tamano'] . "',"
                            ."empaque = '". $arreglo['empaque'] . "',"
                            ."olor = '". $arreglo['olor'] . "',"
                            ."presentacion = '". $arreglo['presentacion'] . "',"
                            ."descripcion = '". $arreglo['descripcion'] . "',"
							."iva = '". $arreglo['iva'] . "'"
                         ." WHERE id = " . $arreglo['id'];	
		  
		$db->query($query);
               $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
            // $this->logMovimiento($_SESSION['datos_logueo']['login'], "Producto", $funcion = "Actualiza Insumo " . $arreglo['nombre']);
    }
    
    function actualizarDetProductos($arreglo){
		global $db;
               
		$query="UPDATE mundolimpieza.detalleproducto SET "
                            ."serial = '". $arreglo['serial'] . "',"
                            ."estado = '". $arreglo['estadoPro'] . "'"                            
                         ." WHERE idProducto = " . $arreglo['idProducto'];	
		
		$db->query($query);
		
                $producto  = $this->selectProductosLs($arreglo['idProducto']);
                $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Actualiza Detalle Insumo " . $producto->nombre);
                //$this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
    }
    
    function eliminarProductos($id){
        global $db;
        $query="DELETE FROM mundolimpieza.producto WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "borrarCliente");
    }
    
    function inactivarProductos($id,$idEstado){
        global $db;
        $query="UPDATE mundolimpieza.detalleproducto SET estado='$idEstado' WHERE idProducto = " . $id ;
		              
	$db->query($query);
        $producto  = $this->selectProductosLs($id);
        //$this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "inactivarCliente");
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Inactiva Insumo " . $producto->nombre);
    }
    
     function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM mundolimpieza.listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
    public function findData($search)
	{
        global $db;
		$query ="SELECT nombreUsuario, id FROM mundolimpieza.usuario WHERE nombreUsuario LIKE :search";
        $query->execute(array(':search' => '%'.$search.'%'));
        $db = null;
        if($query->rowCount() > 0)
        {
        	echo json_encode(array('res' => 'full', 'data' => $query->fetchAll()));
        }
        else
        {
        	echo json_encode(array('res' => 'empty'));
        }
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