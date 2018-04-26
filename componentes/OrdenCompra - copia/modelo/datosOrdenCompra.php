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

require_once(CLASSES_PATH . 'BDControlador.php');

/**
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosOrdenCompra extends BDControlador {

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
    
    function datosProductos($arreglo){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.producto WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosUsuario(){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.usuario";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosClientes(){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.cliente";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosOrdenCompra($idOrden){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.ordencompra where id = $idOrden";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosDetOrdenCompra($idOrden){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.detalleordencompra where idOrdenCompra = $idOrden";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function traerIdServEspeciales(){
		global $db;
                
		$query="SELECT id idSerEspe "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Servicios Especiales' "
                     . "AND tipo = 'CategoriaProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerIdPersonal(){
		global $db;
                
		$query="SELECT id idPersonal "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Personal' "
                     . "AND tipo = 'CategoriaProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerIdBienesAseo(){
		global $db;
                
		$query="SELECT id idBienesAseo "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Bienes de Aseo y Cafeteria'  "
                     . "AND tipo = 'CategoriaProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerNombreDetProd($idOrdenCompra,$idCategoria){
		global $db;
                
		$query="SELECT CONCAT(pr.nombre,'(',detpr.serial,')') nombre
                          FROM mundolimpieza.detalleordencompra detor,
                               mundolimpieza.detalleproducto detpr,
                               mundolimpieza.producto pr
                         WHERE detor.idOrdenCompra = $idOrdenCompra
                           AND pr.categoria = $idCategoria
                           AND detor.idDetalleProducto = detpr.id     
                           AND detpr.idProducto = pr.id";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function traerDetalleOferta($idOrdenCompra,$idCategoria){
		global $db;
                
		$query="SELECT *
                          FROM mundolimpieza.ordencompra ord,
                               mundolimpieza.detalleofertaeconomica detof,
                               mundolimpieza.detalleproducto detpr,
                               mundolimpieza.producto pr
                         WHERE ord.id = $idOrdenCompra
                           AND pr.categoria = $idCategoria
                           AND detpr.estado = 700
                           AND ord.idOfertaEconomica = detof.idOfertaEconomica
                           AND detof.idProducto = detpr.idProducto
                           AND detof.idProducto = pr.id";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function traerIdEstadoDisProd(){
		global $db;
                
		$query="SELECT id idEstadoDisProd "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Disponible' "
                     . "AND tipo = 'EstadoProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function retornarNombreEstado($idEstado){
		global $db;
                
		$query="SELECT valor nomEstado "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE id = $idEstado";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerIdEstadoOferProd(){
		global $db;
                
		$query="SELECT id idEstadoOferProd "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Ofertado' "
                     . "AND tipo = 'EstadoProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerPrecio($idCiudad,$idProducto){
		global $db;
                
		$query="SELECT precio "
                     . "FROM mundolimpieza.precioproductociudad "
                     . "WHERE idCiudad = '$idCiudad' "
                     . "AND idProducto = '$idProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    
    function datosOfertaEconomica($idOferta){
		global $db;
		$query="SELECT * FROM mundolimpieza.ofertaeconomica WHERE id = $idOferta";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosAsesor($idUsuario) {
        global $db;
        $query = "SELECT * FROM mundolimpieza.usuario WHERE id = $idUsuario";        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerTipoAcceso($id) {
        global $db;
        $query = "SELECT valor nomAcceso FROM mundolimpieza.listavalor WHERE id = $id";
        $db->query($query);
        return $db->fetch();
    }
    
    public function selectOfertaEconomica($idOferta,$idCategoria) {
        global $db;
        
        $query = "SELECT deOf.id IdDetOfe,deOf.precioUnidad,
                         deOf.idOfertaEconomica,deOf.idProducto,
                         deOf.precioUniTotal,deOf.idCiudad,
                         deOf.cantidad,of.fechaModificacion,ls.valor estadoOfe
                    FROM mundolimpieza.detalleofertaeconomica deof,
                         mundolimpieza.producto pro,
                         mundolimpieza.ofertaeconomica of,
                         mundolimpieza.listavalor ls
                   WHERE deOf.idOfertaEconomica = $idOferta
                     AND pro.categoria = $idCategoria
                     AND deof.idProducto = pro.id
                     AND of.estado = ls.id;";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function traerNombreCiu($idCiudad){
        global $db;
        
        $query = "SELECT nombre nombre FROM mundolimpieza.ciudad WHERE id='" . $idCiudad ."'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarNombreCliente($idCliente){
        
         global $db;
        
        $query = "SELECT nombre FROM mundolimpieza.cliente WHERE id='$idCliente'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarNombreActa($idActa){
        
         global $db;
        
        $query = "SELECT valor FROM mundolimpieza.listavalor WHERE id='$idActa'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function retornarNombreCert($idActa){
        
         global $db;
        
        $query = "SELECT valor FROM mundolimpieza.listavalor WHERE id='$idActa'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function traerNombreProd(){
        
         global $db;
        
        $query = "SELECT nombre FROM mundolimpieza.producto";
        
        $db->query($query);
        return $db->getArray();
        
    }
    
    function traercantidadProd($idDis){
        
         global $db;
        
        $query = "SELECT count(pr.referencia) cantref,pr.id,pr.cantidad canIni
                    FROM mundolimpieza.producto pr,
                         mundolimpieza.detalleproducto detpr
                   WHERE pr.id = detpr.idProducto
                     AND detpr.estado <> '$idDis'";
        
        $db->query($query);
        return $db->getArray();
        
    }
    
    
    function calcularCantidad($arreglo){
        global $db;
        
        $query = "SELECT pr.cantidadDisponible cantDispo
                    FROM mundolimpieza.producto pr
                   WHERE pr.id = '" .$arreglo->idProducto . "'";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function calcularCantidadChan($arreglo){
        global $db;
        
        $query = "SELECT pr.cantidadDisponible cantDis
                    FROM mundolimpieza.producto pr
                   WHERE pr.id ='" . $arreglo["referencia"] ."'";
        
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function traerIDEstadoProd($estadoProd){
        global $db;
        
        $query = "SELECT ls.id id FROM mundolimpieza.listavalor ls WHERE ls.valor ='" . $estadoProd . "'";
        
         $db->query($query);
        return $db->fetch();
    }
    
    function traerIDEstadoOferta(){
        global $db;
        
        $query = "SELECT ls.id id FROM mundolimpieza.listavalor ls WHERE ls.tipo = 'EstadoOfertaEconomica' AND ls.valor ='En Desarrollo'";
        
         $db->query($query);
        return $db->fetch();
    }
    
    function traerIDEstadoOfertaDesa(){
        global $db;
        
        $query = "SELECT ls.id id FROM mundolimpieza.listavalor ls WHERE ls.tipo = 'EstadoOfertaEconomica' AND ls.valor ='En Desarrollo'";
        
         $db->query($query);
        return $db->fetch();
    }
    
    function nombreCiudad($idCiudad){
        global $db;
        
        $query = "SELECT ls.nombre FROM mundolimpieza.ciudad ls WHERE ls.id ='$idCiudad'";
        
         $db->query($query);
        return $db->fetch();
    }
    
    
    function traerIdActualizar($arreglo,$valorCant){
        global $db;
        
        $query = "SELECT pr.id
                    FROM mundolimpieza.detalleproducto pr,
                         mundolimpieza.listavalor ls
                   WHERE ls.valor = 'Disponible'
                     AND pr.idProducto = '" .$arreglo->idProducto . "'
                     AND pr.estado = ls.id
                     LIMIT ". $valorCant . "";
        
        $db->query($query);
        return $db->getArray();
            
    }
    
    public function mostrarProductos($arreglo){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.producto c
                WHERE c.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function traerIdDetProd($idProducto){
        
        global $db;
        
        $query ="SELECT depr.id FROM mundolimpieza.detalleproducto depr WHERE depr.idProducto = '$idProducto'";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function traerIdProd($idOferta,$idCategoria){
        
        global $db;
        
        $query ="SELECT pr.id idProducto "
              . "FROM mundolimpieza.detalleofertaeconomica detOfer,
                      mundolimpieza.detalleproducto detpr,
                      mundolimpieza.producto pr "
              . "WHERE detOfer.idOfertaEconomica = $idOferta
                   AND pr.categoria = $idCategoria
                   AND detOfer.idDetalleProducto = detpr.id
                   AND detpr.idProducto = pr.id";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function eliminarProductos($id){
        global $db;
        $query="DELETE FROM mundolimpieza.producto WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "borrarCliente");
    }
    
    function eliminarDesOferta($idOferta) {
        global $db;
        $query = "DELETE FROM detalleofertaeconomica WHERE idOfertaEconomica = " . $idOferta . "";
        //echo $query;	              
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "OfertaEconomica", $query, "eliminarDesOferta");
    }
    
    function inactivarProductos($id){
        global $db;
        $query="UPDATE mundolimpieza.producto SET estado='Inactivo' WHERE id = " . $id ;
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "inactivarCliente");
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
    
   function crearVistaUsuario($idUser,$idTipoAcceso,$nomAcceso){
        global $db;
        
        if ($nomAcceso == 'Cliente'){
        
          $query = "CREATE OR REPLACE VIEW vistaordencompra_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.ordencompra of,
                               mundolimpieza.usuario us
                         WHERE us.idTipoAcceso = $idTipoAcceso
                           AND of.idUsuario = us.id";
        
           $db->query($query);
        }else{
            
            $query = "CREATE OR REPLACE VIEW vistaordencompra_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.ordencompra of";
        
           $db->query($query);
            
        }
        
    }
}
?>