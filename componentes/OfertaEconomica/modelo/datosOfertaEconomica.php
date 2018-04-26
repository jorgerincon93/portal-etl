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
class DatosOfertaEconomica extends BDControlador{ 
	
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
    
    function traerIdEstadoDisProd(){
		global $db;
                
		$query="SELECT id idEstadoDisProd "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Disponible' "
                     . "AND tipo = 'EstadoProducto'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerIdEstadoOferOK(){
		global $db;
                
		$query="SELECT id idEstadoOfOk "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'Completada' "
                     . "AND tipo = 'EstadoOfertaEconomica'";
		
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
    
    function datosDetOfertaEconomica($idOferta){
        
		global $db;
		$query="SELECT * FROM mundolimpieza.detalleofertaeconomica WHERE idOfertaEconomica = $idOferta";
		
		$db->query($query);
		return $db->getArray();
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
    
    function traerIvaProd($id) {
        global $db;
        $query = "SELECT iva FROM mundolimpieza.producto WHERE id = $id";
        $db->query($query);
        return $db->fetch();
    }
    
    function traerIva() {
        global $db;
        $query = "SELECT valor as iva FROM mundolimpieza.listavalor WHERE tipo = 'Iva'";
        $db->query($query);
        return $db->fetch();
    }
    
    function traerAiu() {
        global $db;
        $query = "SELECT valor as aiu FROM mundolimpieza.listavalor WHERE tipo = 'AIU'";
        $db->query($query);
        return $db->fetch();
    }
    
    public function selectOfertaEconomica($idOferta,$idCategoria) {
        global $db;
        
        $query = "SELECT det.id IdDetOfe,det.precioUnidad,
                         det.idOfertaEconomica,det.idProducto,
                         det.precioUniTotal,det.idCiudad,
                         det.cantidad,of.fechaModificacion,
                         ls.valor estado,of.estado estadoOfe,det.estado estadoItem
                    FROM mundolimpieza.detalleofertaeconomica det,
                         mundolimpieza.producto pr,
                         mundolimpieza.listavalor ls,
                         mundolimpieza.ofertaeconomica of
                   WHERE det.idOfertaEconomica = $idOferta
                     AND pr.categoria = $idCategoria
                     AND det.idProducto = pr.id
                     AND det.estado = ls.id
                     AND of.id =  det.idOfertaEconomica";
        
        $db->query($query);
        return $db->getArray();
    }
    
    
    function traerEstadoOfeItem($idOferta,$idProducto){
        global $db;
        
        $query = "SELECT det.estado estadoItem
                    FROM mundolimpieza.detalleofertaeconomica det
                   WHERE det.idOfertaEconomica = $idOferta
                     AND det.idProducto = $idProducto";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function datosDetOfertaAIU($idOferta){
        global $db;
        
        $query = "SELECT pr.*
                    FROM mundolimpieza.detalleofertaeconomica pr, 
                         mundolimpieza.producto pro
                   WHERE pr.idOfertaEconomica=$idOferta
                     AND pro.categoria = 188
                     AND pr.idProducto = pro.id;";
        
        $db->query($query);
        return $db->getArray();
        
    }
    function datosDetOfertaPER($idOferta){
        global $db;
        
        $query = "SELECT pr.*
                    FROM mundolimpieza.detalleofertaeconomica pr, 
                         mundolimpieza.producto pro
                   WHERE pr.idOfertaEconomica=$idOferta
                     AND pro.categoria = 189
                     AND pr.idProducto = pro.id;";
        
        $db->query($query);
        return $db->getArray();
        
    }
    function datosDetOfertaASEO($idOferta){
        global $db;
        
        $query = "SELECT pr.*
                    FROM mundolimpieza.detalleofertaeconomica pr, 
                         mundolimpieza.producto pro
                   WHERE pr.idOfertaEconomica=$idOferta
                     AND pro.categoria = 190
                     AND pr.idProducto = pro.id;";
        
        $db->query($query);
        return $db->getArray();
        
    }
    
    function traerNombreCiu($arreglo){
        global $db;
        
        $query = "SELECT CONCAT(nombre,codigo) AS nombre FROM mundolimpieza.ciudad WHERE id='" . $arreglo["idCiudad"] ."'";
        
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
    
    function traerNombreProd($idProducto){
        
         global $db;
        
        $query = "SELECT  CONCAT(nombre,'(',det.serial,')') nombre 
                    FROM mundolimpieza.producto pr,
                         mundolimpieza.detalleproducto det
                    WHERE pr.id = $idProducto
                      AND pr.id = det.idProducto";
        
        $db->query($query);
        return $db->fetch();
        
    }
    
    function traerNombreEstadoOferta($idEstado){
        
         global $db;
        
        $query = "SELECT valor nomEstOferta FROM mundolimpieza.listavalor WHERE id=$idEstado";
        
        $db->query($query);
        return $db->fetch();
        
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
    
    
    function calcularCantidad($idProductoAIU,$estadoDisPro){
        global $db;
        
        $query = "SELECT COUNT(8) cantDispo
                    FROM mundolimpieza.detalleproducto detp
                   WHERE detp.idProducto = $idProductoAIU
                     AND detp.estado = $estadoDisPro";
        
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
                         mundolimpieza.listaValor ls
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
    
    function traerIdDetProd($idProducto,$estadoDisPro,$cantidad){
        
        global $db;
        
        $query ="SELECT detp.id idDetProd
                   FROM mundolimpieza.detalleproducto detp
                  WHERE detp.idProducto = $idProducto
                    AND detp.estado = $estadoDisPro
                    limit $cantidad";
        
        $db->query($query);
        
        return $db->getArray();
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
    
    function traerEstadoItem(){
        
        global $db;
        
        $query = "SELECT ls.id idEstadoItem
                    FROM mundolimpieza.listavalor ls
                   WHERE ls.tipo = 'EstadoDetalleOferta'
                     AND ls.valor = 'Cantidad de producto no disponible'";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function traerNomEstadoItem($idEstado){
        
        global $db;
        
        $query = "SELECT ls.valor nomEstado
                    FROM mundolimpieza.listavalor ls
                   WHERE ls.id = $idEstado";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function traerIdEstadoItemOK(){
        
        global $db;
        
        $query = "SELECT ls.id nomEstado
                    FROM mundolimpieza.listavalor ls
                   WHERE ls.tipo = 'EstadoDetalleOferta'
                     AND ls.valor = 'OK'";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function traerIdEstadoUso(){
        
        global $db;
        
        $query = "SELECT ls.id idEnUso
                    FROM mundolimpieza.listavalor ls
                   WHERE ls.tipo = 'EstadoProducto'
                     AND ls.valor = 'En Uso'";
        
        $db->query($query);
        
        return $db->fetch();
    }
    
    function traerProductosNoDispo($idEstado,$idOferta){
        
        global $db;
        
        $query = "select * 
                   from mundolimpieza.detalleofertaeconomica
                  where estado = $idEstado
                    and idOfertaEconomica = $idOferta";
        
        $db->query($query);
        
        return $db->getArray();
    }
    
    function traerIdDetProUso($idOferta,$idEstado){
        
        global $db;
        
        $query = "SELECT det.id idDetalle
                    FROM mundolimpieza.detalleproducto det,
                         mundolimpieza.producto pr,
                         mundolimpieza.detalleofertaeconomica deto
                   WHERE det.estado = $idEstado
                     AND deto.idOfertaEconomica = $idOferta
                     AND det.idProducto = pr.id
                     AND pr.id = deto.idProducto";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function traerIdDetProOfer($idOferta,$idEstado){
        
        global $db;
        
        $query = "SELECT det.id idDetalle
                    FROM mundolimpieza.detalleproducto det,
                         mundolimpieza.producto pr,
                         mundolimpieza.detalleofertaeconomica deto
                   WHERE det.estado = $idEstado
                     AND deto.idOfertaEconomica = $idOferta
                     AND det.idProducto = pr.id
                     AND pr.id = deto.idProducto";
        
        $db->query($query);
        return $db->getArray();
    }
    
    
    
    function insertarOferta($arreglo){
            
		global $db;
		$query="INSERT INTO mundolimpieza.ofertaeconomica"
                        ."("
                        ."  avance,"
                        ."  estado,"
                        ."  fechaCreacion,"
                        ."  idCliente,"
                        ."  numeroContrato,"
                        ."  numeroContratoInterno,"
                        ."  fechaInicio,"
                        ."  fechaFin,"
                        ."  valorContrato,"
                        ."  actaliquidacion,"
                        ."  certificacion,"
                        ."  idUsuario,"
                        ."  observacion,"
                        ."  idTipoServicio"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['avance'] . "',"
                        ."'". $arreglo['estadoOferta'] . "',"
                        . "now(),"
                        ."'". $arreglo['idCliente'] . "',"
                        ."'". $arreglo['numContra'] . "',"
                        ."'". $arreglo['numContraInte'] . "',"
                        ."'". $arreglo['feIni'] . "',"
                        ."'". $arreglo['feFin'] . "',"
                        ."'". $arreglo['valorContra'] . "',"
                        ."'". $arreglo['actLiqui'] . "',"
                        ."'". $arreglo['certi'] . "',"
                        ."'". $arreglo['idAsesor'] . "',"
                        ."'". $arreglo['obsGenerales'] . "',"
                        ."'". $arreglo['tipoServ'] . "'"
                        .")";	
		 
          
		$db->query($query);
        $idOfertaEcono = $db->getInsertID();
        return $idOfertaEcono;
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "OfertaEconomica",$funcion = "Nueva Oferta Contrato " . $arreglo['numContra']);
        
    }
    
    function insertarOfertaDes($arreglo,$idOfertaEconomica,$idProducto,$estadoItem){

		global $db;
		$query="INSERT INTO mundolimpieza.detalleofertaeconomica"
                        ."("
                        ."precioUnidad,"
                        ."idOfertaEconomica,"
                        ."idProducto,"
                        ."precioUniTotal,"
                        ."idCiudad,"
                        . "cantidad,"
                        . "estado"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['precioUnidad'] . "',"
                        ."". $idOfertaEconomica . ","
                        ."". $idProducto . ","
                        ."'". $arreglo['totalUnidad'] . "',"
                        ."'". $arreglo['region'] . "',"
                        ."'". $arreglo['cant'] . "',"
                        ."". $estadoItem . ""
                        .")";	
		 
                $db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Detalle Productos", $query, "insertarOfertaDes");
                
    }
    
    function actualizarProductosOfer($arreglo){            
		global $db;
                
		$query="UPDATE mundolimpieza.ofertaeconomica SET "
                            ."avance = '". $arreglo['avance'] . "',"
                            ."estado = '". $arreglo['estadoOfertaDesa'] . "',"
                            ."fechaModificacion = ". "now()," 
                            ."idCliente = '". $arreglo['idCliente'] . "',"
                            ."numeroContrato = '". $arreglo['numContra'] . "',"
                            ."numeroContratoInterno = '". $arreglo['numContraInte'] . "',"
                            ."fechaInicio = '". $arreglo['feIni'] . "',"
                            ."fechaFin = '". $arreglo['feFin'] . "',"
                            ."valorContrato = '". $arreglo['valorContra'] . "',"
                            ."actaLiquidacion = '". $arreglo['actLiqui'] . "',"
                            ."certificacion = '". $arreglo['certi'] . "',"
                            ."idUsuario = '". $arreglo['idAsesor'] . "',"
                            ."observacion = '". $arreglo['obsGenerales'] . "',"
                            ."idTipoServicio = '". $arreglo['tipoServ'] . "'"
                         ." WHERE id = " . $arreglo['idOfe'];	
		        
		$db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "OfertaEconomica", $funcion = "Actualizacion Oferta Contrato " . $arreglo['numContra']);
    }
    
    function actualizarProductosDesAIU($arreglo,$id){
		global $db;
                
		$query="UPDATE mundolimpieza.detalleofertaeconomica SET "
                            ."precioUnidad = '". $arreglo['precioUnidad'] . "',"
                            //."idOfertaEconomica = '". $arreglo['idOferta'] . "',"
                            ."idProducto = '". $arreglo['bienServ'] . "',"
                            ."precioUniTotal = '". $arreglo['totalUnidad'] . "',"
                            ."idCiudad = '". $arreglo['region'] . "',"
                            ."cantidad = '". $arreglo['cant'] . "'"
                         ." WHERE id = " . $id;	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
    }
    
    function actualizarProductosPER($arreglo,$id){            
		global $db;
                
		$query="UPDATE mundolimpieza.detalleofertaeconomica SET "
                            ."precioUnidad = '". $arreglo['precioUnidad'] . "',"
                            //."idOfertaEconomica = '". $arreglo['idOferta'] . "',"
                            ."idProducto = '". $arreglo['bienServ_per'] . "',"
                            ."precioUniTotal = '". $arreglo['totalUnidad'] . "',"
                            ."idCiudad = '". $arreglo['region'] . "',"
                            ."cantidad = '". $arreglo['cant'] . "'"
                         ." WHERE id = " . $id;	
		        
		//echo'<pre>';print_r($query);echo'</pre>';
                $db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
    }
    
    function actualizarProductosASEO($arreglo,$id){            
		global $db;
                
		$query="UPDATE mundolimpieza.detalleofertaeconomica SET "
                            ."precioUnidad = '". $arreglo['precioUnidad'] . "',"
                            //."idOfertaEconomica = '". $arreglo['idOferta'] . "',"
                            ."idProducto = '". $arreglo['bienServ_aseo'] . "',"
                            ."precioUniTotal = '". $arreglo['totalUnidad'] . "',"
                            ."idCiudad = '". $arreglo['region'] . "',"
                            ."cantidad = '". $arreglo['cant'] . "'"
                         ." WHERE id = " . $id;	
		        
		//echo'<pre>';print_r($query);echo'</pre>';
                $db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Producto", $query, "actualizarProductos");
    }
    
    function actualizarEvento($arreglo){            
		global $db;
                
		$query="UPDATE mundolimpieza.evento SET "
                            ."fechaInicio = '". $arreglo['fecha_ini'] . "',"
                            ."fechaFin = '". $arreglo['fecha_fin'] . "',"
                            ."asunto = '". $arreglo['asunto'] . "',"
                            ."implicados = '". $arreglo['implicados'] . "',"
                            ."idEstado = '". $arreglo['estado'] . "',"
                            ."idOfertaEconomica = '". $arreglo['idOferta'] . "'"
                         ." WHERE id = " . $arreglo['id'];	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Evento", $query, "actualizarEvento");
    }
    
    function actualizaCantidadDetProd($id,$idEstadoNuevoProd){
        global $db;
      
        $query = "UPDATE mundolimpieza.detalleproducto pr SET "
                       . "pr.estado=" . $idEstadoNuevoProd . ""
                       . " WHERE id=" . $id . "";
        
        //echo'<pre>';print_r($query);echo'</pre>'; 
        $db->query($query);
        
    }
    
    function actualizaEstadoItem($idOferta,$idProd,$idEstadoNuevoProd){
        global $db;
         
        $query = "UPDATE mundolimpieza.detalleofertaeconomica pr SET "
                       . "pr.estado=" . $idEstadoNuevoProd . ""
                       . " WHERE pr.idOfertaEconomica=" . $idOferta . ""
                       . "   AND pr.idProducto = ". $idProd."";
        
        
        $db->query($query);
        
    }
    
    function actualizaEstadoItemOK($idOferta,$idEstado){
        global $db;
        
        $query = "UPDATE mundolimpieza.detalleofertaeconomica pr SET "
                       . "pr.estado=" . $idEstado . ""
                       . " WHERE pr.idOfertaEconomica=" . $idOferta . "";
        
        //echo'<pre>';print_r($query);echo'</pre>'; 
        $db->query($query);
        
    }
    
    function actualizaEstadoOfertaCom($idOferta,$idEstado){
        global $db;
        
        $query = "UPDATE mundolimpieza.ofertaeconomica pr SET "
                       . "pr.estado=" . $idEstado . ""
                       . " WHERE pr.id=" . $idOferta . "";
        
        //echo'<pre>';print_r($query);echo'</pre>'; 
        $db->query($query);
        
    }
    
    function actualizaCantidadProd($id,$canIni){
        global $db;
        
        $query = "UPDATE mundolimpieza.producto pr SET "
                       . "pr.cantidadDisponible=" . $canIni . ""
                       . " WHERE id=" . $id . "";
        
        $db->query($query);
        
    }
    
    
    function insertarOrdenCompra($arreglo,$idOferta){
            
		global $db;
		$query="INSERT INTO mundolimpieza.ordencompra"
                        ."("
                        ."estado,"
                        ."fechaCreacion,"
                        ."idCliente,"
                        ."numeroContrato,"
                        ."numeroContratoInterno,"
                        ."fechaInicio,"
                        ."fechaFin,"
                        ."valorContrato,"
                        ."actaliquidacion,"
                        ."certificacion,"
                        ."idUsuario,"
                        . "idOfertaEconomica"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo->estado . "',"
                        . "now(),"
                        ."'". $arreglo->idCliente . "',"
                        ."'". $arreglo->numeroContrato . "',"
                        ."'". $arreglo->numeroContratoInterno . "',"
                        ."'". $arreglo->fechaInicio . "',"
                        ."'". $arreglo->fechaFin . "',"
                        ."'". $arreglo->valorContrato . "',"
                        ."'". $arreglo->actaLiquidacion . "',"
                        ."'". $arreglo->certificacion . "',"
                        ."'". $arreglo->idUsuario . "',"
                        ."". $idOferta . ""
                        .")";	
		
                
                $db->query($query);
                $idOfertaEcono = $db->getInsertID();
               // $this->log($_SESSION['datos_logueo']['login'], "Productos", $query, "insertarProductos");
         $this->logMovimiento($_SESSION['datos_logueo']['login'], "OfertaEconomica", $funcion = "Nueva Orden Compra " . $arreglo->numeroContrato);
         return $idOfertaEcono;
                
    }
    
    function insertarOrdenDes($idDetalle,$idOrdenCompra){

		global $db;
		$query="INSERT INTO mundolimpieza.detalleordencompra"
                        ."("
                        ."idDetalleProducto,"
                        ."idOrdenCompra"
                        .")" 
                        ."VALUES("
                        ."'". $idDetalle . "',"
                        ."'". $idOrdenCompra . "'"
                        .")";	
		 
                $db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Detalle Productos", $query, "insertarOfertaDes");
                
    }
    
    function insertarEvento($arreglo,$idOferta){

		global $db;
		$query="INSERT INTO mundolimpieza.evento"
                        ."("
                        ."fechaInicio,"
                        ."fechaFin,"
                        ."asunto,"
                        ."implicados,"
                        ."idEstado,"
                        ."idOfertaEconomica"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['fechaInicio'] . "',"
                        ."'". $arreglo['fechaFin'] . "',"
                        ."'". $arreglo['asunto'] . "',"
                        ."'". $arreglo['implicados'] . "',"
                        ."'". $arreglo['estado'] . "',"
                        ."'". $idOferta . "'"
                        .")";	
		
                $db->query($query);
                //$this->log($_SESSION['datos_logueo']['login'], "Evento", $query, "insertarEvento");
        $contra = $this->datosOfertaEconomica($idOferta);
        $this->logMovimiento($_SESSION['datos_logueo']['login'], "Evento", $funcion = "Nuevo Evento " . $contra->numeroContrato);
    }
    
    function insertarEventoInicio($arreglo){

		global $db;
		$query="INSERT INTO mundolimpieza.evento"
                        ."("
                        ."fechaInicio,"
                        ."fechaFin,"
                        ."asunto,"
                        ."implicados,"
                        ."idEstado"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['fecha_ini'] . "',"
                        ."'". $arreglo['fecha_fin'] . "',"
                        ."'". $arreglo['asunto'] . "',"
                        ."'". $arreglo['implicados'] . "',"
                        ."'". $arreglo['estado'] . "'"
                        .")";	
		echo'<pre>';print_r($query);echo'</pre>';
                //$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "Evento", $query, "insertarEvento");
                
    }
    
    function restaurarCantidad($idDisponible,$idOfertado){
        global $db;
        
        $query = "UPDATE mundolimpieza.detalleproducto pr SET "
                       . "pr.estado='" . $idDisponible . "'"
                       . " WHERE estado='" . $idOfertado . "'";
        
        $db->query($query);
        
    }
    
    function restaurarCantidadProd($canDis,$id){
        global $db;
        
        $query = "UPDATE mundolimpieza.producto pr SET "
                       . "pr.cantidadDisponible='" . $canDis . "'"
                       . " WHERE pr.id='" . $id . "'";
        
        $db->query($query);
        
    }
    
    function eliminarOfertaEconomica($id){
        global $db;
        $query="DELETE FROM mundolimpieza.ofertaeconomica WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);        
        $this->log($_SESSION['datos_logueo']['login'], "OfertaEconomica", $query,"eliminarOfertaEconomica");
        
    }
    
    function eliminarRegDetEconomica($idOferta,$idProducto){
        global $db;
        $query="DELETE FROM mundolimpieza.detalleofertaeconomica WHERE idOfertaEconomica = " . $idOferta . " AND idProducto = ". $idProducto ." ";
	echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "OfertaEconomica", $query, "eliminarRegDetEconomica");
    }
    
    function eliminarDesOferta($idOferta) {
        global $db;
        $query = "DELETE FROM detalleofertaeconomica WHERE idOfertaEconomica = " . $idOferta . " ";
        
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
   
   function crearVistaUsuario($idUser,$idTipoAcceso,$nomAcceso){
        global $db;
        
        if ($nomAcceso == 'Cliente'){
        
          $query = "CREATE OR REPLACE VIEW vistaofertaeconomica_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.ofertaeconomica of,
                               mundolimpieza.usuario us
                         WHERE us.idTipoAcceso = $idTipoAcceso
                           AND of.idUsuario = us.id";
        
           $db->query($query);
        }else{
            
            $query = "CREATE OR REPLACE VIEW vistaofertaeconomica_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.ofertaeconomica of";
         
           $db->query($query);
            
        }
        
    }
   
}
?>