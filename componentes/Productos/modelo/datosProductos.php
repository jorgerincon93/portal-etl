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
class DatosProductos extends BDControlador{ 
	
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
		$query="SELECT pr.id idProd,pr.nombre,pr.referencia,pr.categoria,pr.tipo,pr.idMarca,pr.tamano,pr.empaque,pr.presentacion,pr.descripcion,detpr.id idDet,detpr.serial,detpr.estado,idProducto
                          FROM mundolimpieza.producto pr,
                               mundolimpieza.detalleproducto detpr
                         WHERE pr.id =$id
                           AND pr.id = detpr.idProducto";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarProductos($arreglo){
        global $db;
        
        $query="SELECT *
                  FROM mundolimpieza.producto pr,
                       mundolimpieza.detalleproducto det
                 WHERE pr.id='".$arreglo["id"]."'
                   AND pr.id = det.idProducto";
            
        $db->query($query);
        return $db->getArray();
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
    
    function retornarEstado(){
        
        global $db;
        
            $query = "SELECT id FROM mundolimpieza.listavalor WHERE tipo = 'EstadoProducto' AND valor = 'Inactivo'";
        
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
                        //."  olor,"
                        ."  presentacion,"
                        ."  descripcion"
                        //."  estado"
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
                        //."'". $arreglo['olor'] . "',"
                        ."'". $arreglo['presentacion'] . "',"
                        ."'". $arreglo['descripcion'] . "'"
                        //."'". $arreglo['estadoPro'] . "'"
                        //."'". $arreglo['idZona'] . "',"
                        //."'". $arreglo['idPersona'] . "'"
                        .")";	
		         
		$db->query($query);
                $idProducto = $db->getInsertID();
                //$this->log($_SESSION['datos_logueo']['login'], "Productos", $query, "insertarProductos");
                $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Nueva Maquina " . $arreglo['nombre']);
                return $idProducto;
    }
    
    function insertarDetProductos($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.detalleProducto"
                        ."("
                         ."serial,"
                         ."estado,"
                         ."idProducto"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['serial'] . "',"
                        ."'". $arreglo['estadoPro'] . "',"
                        ."'". $arreglo['idProducto'] . "'"
                        .")";	
		         
		$db->query($query);                
                //$this->log($_SESSION['datos_logueo']['login'], "Productos", $query, "insertarDetProductos");
        $producto  = $this->selectProductosLs($arreglo['idProducto']);
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Nuevo Detalle Maquina " . $producto->nombre);
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
                            //."olor = '". $arreglo['olor'] . "',"
                            ."presentacion = '". $arreglo['presentacion'] . "',"
                            ."descripcion = '". $arreglo['descripcion'] . "'"
                         ." WHERE id = " . $arreglo['idProd'];	
		 
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
        //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Producto", $funcion = "Actualiza Maquina " . $arreglo['nombre']);
    }
    
    function actualizarDetProductos($arreglo){
		global $db;
                
		$query="UPDATE mundolimpieza.detalleproducto SET "
                            ."serial = '". $arreglo['serial'] . "',"
                            ."estado = '". $arreglo['estadoPro'] . "'"
                         ." WHERE idProducto = " . $arreglo['idProd'];	
		  
		$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
        //  $producto  = $this->selectProductosLs($arreglo['idProducto']);
        //  $this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Actualiza Detalle Maquina " . $producto->nombre);
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
        //$producto  = $this->selectProductosLs($id);
        $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "inactivarProducto");
        //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Productos", $funcion = "Inactiva Maquina " . $producto->nombre);
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
    
   
}
?>