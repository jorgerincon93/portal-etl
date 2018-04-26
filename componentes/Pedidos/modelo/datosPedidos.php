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
class DatosPedidos extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function mostrarPedidos($arreglo){
        global $db;
        
        $query="SELECT  c.*
                FROM    mundolimpieza.Pedidosmovimientos c
                WHERE c.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosAsesor($id){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.usuario where id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosUsuario($id){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.usuario where id = $id";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerTipoAcceso($id) {
        global $db;
        $query = "SELECT valor nomAcceso FROM mundolimpieza.listavalor WHERE id = $id";
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNomPuntSer($id) {
        global $db;
        $query = "SELECT valor nomPuntSer FROM mundolimpieza.listavalor WHERE id = $id";
        $db->query($query);
        return $db->fetch();
    }
    
    function traerContrato($idUsuario) {
        global $db;
        $query = "SELECT oc.numeroContrato
                    FROM mundolimpieza.ordencompra oc,
                         mundolimpieza.usuario us
                   WHERE us.id = $idUsuario
                     AND oc.idUsuario = us.id";
        $db->query($query);
        return $db->getArray();
    }
    
    function traerIdEstadoOferProdOK(){
		global $db;
                
		$query="SELECT id idEstadoOferProdOk "
                     . "FROM mundolimpieza.listavalor "
                     . "WHERE valor = 'OK' "
                     . "AND tipo = 'EstadoDetalleOferta'";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function traerIdDetProd($idOrden,$estadoProd){
		global $db;
                
		$query="SELECT det.id idDetalle
                          FROM mundolimpieza.detalleproducto det,
                               mundolimpieza.producto pr,
                               mundolimpieza.detalleofertaeconomica deto
                         WHERE det.estado = $estadoProd
                           AND deto.idOfertaEconomica = $idOrden
                           AND det.idProducto = pr.id
                           AND pr.id = deto.idProducto";
		
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
    
    function datosOrdenCompra($idOrden){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.ordencompra where id = $idOrden";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function datosPedido($idPedido){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.pedido where id = $idPedido";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function datosPed($idPedido){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.pedido where id = $idPedido";
		
		$db->query($query);
		return $db->fetch();
    }
    
    function detProdPedidoIni($idPedido){
		global $db;
                
		$query="SELECT * FROM mundolimpieza.detallepedidoinicial where idPedido = $idPedido";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function detProductos($idProducto,$canSol){
		global $db;
                
		$query="
                    SELECT det.id idDet,pr.id,pr.nombre
                          FROM mundolimpieza.detalleproducto det,
                               mundolimpieza.producto pr
                         where det.idProducto = $idProducto
                           and det.estado = 185
                           and det.idProducto = pr.id
                           limit $canSol";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function nombreProducto($idProducto,$idPedido){
		global $db;
                
		$query="SELECT pr.nombre
                          FROM mundolimpieza.producto pr,
                               mundolimpieza.detalleproducto depr,
                               mundolimpieza.detallepedidoinicial depi
                         WHERE pr.id = $idProducto
                           AND depi.idPedido = $idPedido
                           AND depr.estado <> 185
                           AND pr.id = depr.idProducto
                           AND pr.id = depi.idProducto";
		
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
    
    function productosPedido($idOrdenCompra){
		global $db;
                
		$query="SELECT p.descripcion,
                               p.tamano,
                               p.nombre,
                               p.id idProd,
                               deof.cantidad,
                               substr(detp.serial,1,INSTR(detp.serial,'-')-1) serial,
                               ped.id idPedido,
                               oc.numeroContrato
                          FROM mundolimpieza.ordencompra oc,
                               mundolimpieza.detalleofertaeconomica deof,
                               mundolimpieza.producto p,
                               mundolimpieza.detalleproducto detp,
                               mundolimpieza.pedido ped
                         WHERE oc.id = $idOrdenCompra
                           AND p.id = detp.idProducto
                           AND oc.idOfertaEconomica = deof.idOfertaEconomica
                           AND deof.idProducto = p.id
                           AND oc.id = ped.idOrdenCompra
                        GROUP BY 1 , 2 , 3 , 4";
		
		$db->query($query);
		return $db->getArray();
    }    
    
    function traerProduOrdenCompra($idOrden,$estadoProd) {
        global $db;
        $query = "SELECT p.descripcion,
                         p.tamano,
                         p.nombre,    
                         p.id idProd,
                      deof.cantidad,
                      substr(detp.serial,1,INSTR(detp.serial,'-')-1) serial
                FROM mundolimpieza.ordencompra oc,
                     mundolimpieza.detalleofertaeconomica deof,
                     mundolimpieza.producto p,
                     mundolimpieza.detalleproducto detp
               WHERE oc.id = $idOrden
                 AND deof.estado = $estadoProd
                 AND p.id = detp.idProducto
                 AND oc.idOfertaEconomica = deof.idOfertaEconomica
                 AND deof.idProducto = p.id
                GROUP BY 1 , 2 , 3 , 4";
        
        $db->query($query);
        return $db->getArray();
    }
    
   public function mostrarPermisoAprobacion($idPedido,$idRol) {
        global $db;

        $query = "SELECT fm.* FROM mundolimpieza.pedidoaprobaciones fm "
                . "WHERE  fm.idPedido=" . $idPedido . " "
                        . " AND fm.estado = 'Pendiente Gerencia' "
                        . " AND fm.idPerfil = " . $idRol . " ";
        
        $db->query($query);
        return $db->fetch();
        //return $query;
    }
    
    function traerPerfilesAprobacionAlma() {
        global $db;

        $query = "SELECT  lv.*
                  FROM mundolimpieza.listavalor lv
                 WHERE lv.tipo='AprobardorAlamacen'
                 ORDER BY valor";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function tipoUsr($id){
          global $db;
            
          $query = " SELECT l.nombre
                               FROM mundolimpieza.listavalor l,
                                    mundolimpieza.usuario u
                              WHERE l.tipo = 'Aprobador'
                                AND u.idrol = l.valor
                                and u.id = $id ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function tipoPreAprobador($id){
          global $db;
            
          $query = " SELECT l.nombre
                               FROM mundolimpieza.listavalor l,
                                    mundolimpieza.usuario u
                              WHERE l.tipo = 'PreAprobardor'
                                AND u.idrol = l.valor
                                and u.id = $id ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerPerfilesAprobacion() {
        global $db;

        $query = "SELECT  lv.*
                  FROM listavalor lv
                 WHERE lv.tipo='Aprobador'
                 ORDER BY valor";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function mostrarPermisoPreAprobacion($idPedido,$idRol) {
        global $db;

        $query = "SELECT fm.* FROM pedidoaprobaciones fm "
                . "WHERE  fm.idPedido=" . $idPedido . " "
                        . " AND fm.estado = 'Pendiente Gerencia' ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerUsrAlama($idPedido) {
        global $db;

        $query = "
            SELECT us.nombreUsuario
                    FROM mundolimpieza.pedidoaprobaciones fm,
                         mundolimpieza.usuario us
                   WHERE fm.idPedido = $idPedido
                     AND fm.estado = 'Pendiente Gerencia'
                     AND fm.idUsuario = us.id";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerCorreoPadre($idPadre){
        global $db;
        
        $query ="SELECT lv.email 
                   FROM mundolimpieza.usuario lv
                  WHERE lv.id = $idPadre";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerCorreoCliente($idPedido){
        global $db;
        
        $query ="SELECT cl.email
                   FROM mundolimpieza.pedidoaprobaciones fm,
                        mundolimpieza.pedido po,
                        mundolimpieza.ordencompra ord,
                        mundolimpieza.cliente cl
                  WHERE fm.idPedido = $idPedido
                    AND fm.estado = 'Aprobado'
                    AND fm.idPedido = po.id
                    AND po.idOrdenCompra = ord.id
                    AND ord.idCliente = cl.id";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerCorreoUsrCreador($idPedido){
        global $db;
        
        $query ="SELECT cl.email
                   FROM mundolimpieza.pedido po,
                        mundolimpieza.usuario cl
                  WHERE po.id = $idPedido
                    AND po.idUsuarioElaboro = cl.id";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosDetPedido($idPedido){
        global $db;
        
        $query ="SELECT *
                   FROM mundolimpieza.detallepedido det
                  WHERE det.idPedido = $idPedido";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function pedidoAprob($idPedido){
        global $db;
        
        $query ="SELECT *
                   FROM mundolimpieza.pedidoaprobaciones pea
                  WHERE pea.idPedido = $idPedido";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function crearVistaUsuario($idUser,$idTipoAcceso,$nomAcceso){
        global $db;
        
        if ($nomAcceso == 'Cliente'){
        
          $query = "CREATE OR REPLACE VIEW vistapedido_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.pedido of,
                               mundolimpieza.usuario us
                         WHERE us.idTipoAcceso = $idTipoAcceso
                           AND of.idUsuarioElaboro = us.id 
                            limit 1";
                  
        
           $db->query($query);
        }else{
            
            $query = "CREATE OR REPLACE VIEW vistapedido_". $idUser . " AS
                        SELECT of.*
                          FROM mundolimpieza.pedido of";
        
           $db->query($query);
            
        }
        
    }    
    
    function actualizarEstadoPreAprobacion($idPedido,$idPerfil,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idPedido='" . $idPedido . "'
                     AND fma.estado='Pre Aprobado'
                     AND fma.idPerfil = '" . $idPerfil . "'";
        
        $db->query($query);
    }
    
    function actualizarEstadoPedidoPreAprobado($idPedido,$estado,$avance) {
        global $db;

        $query = "UPDATE mundolimpieza.pedido fm
                  SET  fm.estado = '" . $estado . "',
                       fm.avance = '" . $avance . "'
                 WHERE fm.id='" . $idPedido . "'";
        
        $db->query($query);
    }
    
    function actualizarEstAprobacion($idPedido,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuarioAprobo = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idPedido='" . $idPedido . "'
                     AND fma.estado='Pre Aprobado'";
        
        $db->query($query);
    }
    
    function actualizarEstAprobGerem($idPedido,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idPedido='" . $idPedido . "'
                     AND fma.estado='Pre Aprobado'";
        
        $db->query($query);
    }
    
    function actualizarApro($idPedido,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idPedido='" . $idPedido . "'
                     AND fma.estado='Pendiente Gerencia'";
        
        $db->query($query);
    }
    
    function rechazarEstadoAprobacion($idPedido,$estado,$idUsuario,$obs,$perfil) {
        global $db;

        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.obsAprobacion = '" . $db->escapeString($obs) . "',
                       fma.estado = '" . $estado . "', 
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "'
                 WHERE fma.idPedido='" . $idPedido . "' "
                . "AND fma.idPerfil=" . $perfil ." "
                . "AND fma.obsAprobacion IS NULL ";
               // . "AND fma.estado='Pendiente' ";
        
        $db->query($query);
        
        $query = "UPDATE mundolimpieza.pedidoaprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "'
                 WHERE fma.idPedido='" . $idPedido . "' "
                . "AND fma.estado <> 'Rechazado'";
        
        $db->query($query);
    }
    
    function rechazarEstadoFormato($idPedido,$estado) {
        global $db;

        $query = "UPDATE mundolimpieza.pedido fm
                  SET  fm.estado = '" . $estado . "',
                       fm.avance = '5'
                 WHERE fm.id='" . $idPedido . "'";
        
        $db->query($query);
    }
    
    function actualizaEstadosPedido($idPedido,$idReviso,$fechaReviso,$idUsuario) {
        global $db;

        $query = "UPDATE mundolimpieza.pedido fm
                  SET  fm.fechaAprobo = now(),
                       fm.fechaReviso = '" .$fechaReviso ."',
                       fm.idUsuarioReviso = $idReviso,
                       fm.idUsuarioAprobo = $idUsuario
                 WHERE fm.id='" . $idPedido . "'";
        
        $db->query($query);
    }
    
    function actualizarEstadoDetProdcuto($id,$idEstadoOk) {
        global $db;

        $query = "UPDATE mundolimpieza.detalleproducto fm
                  SET  fm.estado = '" . $idEstadoOk . "'
                 WHERE fm.id='" . $id . "'";
        
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Pedido", $query, "actualizarEstadoDetProdcuto");
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
    
    function traerDetallePedido($idPedido){
		global $db;
                
		$query="SELECT pr.id idProducto,
                               pr.nombre,
                               pr.tamano,
                               detpr.serial
                          FROM mundolimpieza.pedido p,
                               mundolimpieza.detallepedido dep,
                               mundolimpieza.detalleproducto detpr,
                               mundolimpieza.producto pr,
                               mundolimpieza.ordencompra ord
                         WHERE p.id = $idPedido
                           AND p.id = dep.idPedido
                           AND dep.idDetalleProducto = detpr.id
                           AND detpr.idProducto = pr.id
                           AND p.idOrdenCompra = ord.id";
		
		$db->query($query);
		return $db->getArray();
    }
    
    function traerDetallePedidoIni($idPedido,$idProducto){
		global $db;
                
		$query="SELECT depi.*
                          FROM mundolimpieza.pedido p,
                               mundolimpieza.detallepedidoinicial depi
                         WHERE p.id = $idPedido
                           AND depi.idProducto = $idProducto
                           AND p.id = depi.idPedido";
		
		$db->query($query);
		return $db->getArray();
    }
    
    
    function insertarEncaPedido($arreglo){
                global $db;
		$query="INSERT INTO mundolimpieza.pedido"
                        ."("
                        ."idPuntoServicio,"
                        ."idOrdenCompra,"
                        ."idUsuarioElaboro,"
                        ."fechaElaboro,"
                        ."estado"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['idPuntoServicio'] . "',"
                        ."'". $arreglo['contrato'] . "',"
                        ."'". $arreglo['idUsuario'] . "',"
                        . "now(),"
                        ."'Pendiente Aprobar'"
                        .")";	
		 
                
	$db->query($query);
        $idPedido = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "Pedido",$query, "insertarDetPedido");
        return $idPedido;
    }
    
    function insertarDetPedidoIni($detArreglo,$idPedido){
                global $db;
		$query="INSERT INTO mundolimpieza.detallepedidoinicial"
                        ."("
                        ."cantidad,"
                        ."idProducto,"
                        ."idPedido"
                        .")" 
                        ."VALUES("
                        ."'". $detArreglo['cantidadSol'] . "',"
                        ."'". $detArreglo['idProd'] . "',"
                        ."'". $idPedido . "'"
                        .")";	
		 
                
		$db->query($query);
        
        $this->log($_SESSION['datos_logueo']['login'], "Pedido",$query,"insertarDetPedido");
        
    }
    
    function insertarDetPedido($idDetProd,$idPedido){
                global $db;
		$query="INSERT INTO mundolimpieza.detallepedido"
                        ."("
                        ."idDetalleProducto,"
                        ."idPedido"
                        .")" 
                        ."VALUES("
                        ."'". $idDetProd . "',"
                        ."'". $idPedido . "'"
                        .")";	
		 
            
		$db->query($query);
        
        //$this->logMovimiento($_SESSION['datos_logueo']['login'], "Pedido",$funcion = "Nuevo Pedido ");
                $this->log($_SESSION['datos_logueo']['login'], "Pedido", $query, "insertarDetPedido");
        
    }
    
    function insertarAprobacion($idPedido,$idPerfil,$estado,$porcentaje){
                global $db;
                
           $query="INSERT INTO mundolimpieza.pedidoaprobaciones"
                . "("
                . "idPedido,"
                . "idPerfil,"
                . "estado,"
                . "fechaCreacion,"
                . "porcentaje"
                . ")VALUES("
                . "" . $idPedido . ","
                . "" . $idPerfil . ","
                . "'" . $estado . "',"
                . "now(),"
                . "" . $porcentaje . ""
                . ")";        

        $db->query($query);       
       
        
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
        $ok = 'ok';
        return $ok;
   }
   
    function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM mundolimpieza.listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
   
}
?>