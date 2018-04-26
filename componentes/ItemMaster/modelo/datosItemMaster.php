<?php 
/**
 * 
 * 
 * @author ammonroyc
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
class DatosItemMaster extends BDControlador{ 
	
	/**
	 * Constructor de la clase "DatosBonificacion"
	 * 
	 * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
	 * de ser necesario.
	 */
    public function __construct(){
    	//parent :: Manejador_BD();
    }
    
    public function selectClientes(){
        global $db;
        
        $query="SELECT  c.*
                FROM    clientes c";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function datosCliente($arreglo){
		global $db;
		$query="SELECT * FROM clientes WHERE id = $arreglo[id]";
		
		$db->query($query);
		return $db->fetch();
    }
    
    public function mostrarCliente($arreglo){
        global $db;
        
        $query="SELECT  c.*
                FROM    clientes c
                WHERE c.id='".$arreglo["id"]."'";
            
        $db->query($query);
        return $db->getArray();
    }
    
    function consultarTabla() {
        global $db;

        $query = "SELECT * FROM item.temporalFaltantesItems ";
        $db->query($query);
        return $db->getArray();
    }
    
    function consultarMapeoDatos($label) {
       global $db;

        $query = "SELECT * FROM meiko.mapeo_datos where label='" . $label . "'";
        $db->query($query);
        return $db->fetch();
    }
    
    function consultarIdTablaRegistro($valor, $tabla) {
         global $db;
    
            $query = "SELECT  id,nombre" . ucfirst($tabla) . " as valor "
                   . "FROM item." . strtolower($tabla) . " i "
                   . "WHERE nombre" . ucfirst($tabla) . "='" . $db->escapeString($valor) . "'";

            $db->query($query);
            return $db->fetch();
    }
    
    function consultarTablaCodigos() {
        global $db;

        $query = "SELECT * FROM item.estructura_codigos WHERE valor IS NOT NULL ORDER BY orden ";
        $db->query($query);
        return $db->getArray();
    }
    
    function consultarTablaCodigosShopper() {
        global $db;

        $query = "SELECT * FROM item.estructura_codigos_cortos WHERE valor IS NOT NULL ORDER BY orden";
        $db->query($query);
        return $db->getArray();
    }
    
    function consultarValorTablaRegistro($valor, $tabla) {
        global $db;

        $query = "SELECT  nombre" . ucfirst($tabla) . " as valor "
            . "FROM item." . strtolower($tabla) . " i "
            . "WHERE id=" . $valor . "";

        $db->query($query);
        return $db->fetch();
    }

    function retornarInfoAtributo($valor, $idAtributo, $idCategoria, $idFabricante, $idMarca) {
    global $db;
    
    $valorFabricante = $this->consultarValorTablaRegistro($idFabricante, "Fabricante");
    $valorMarca = $this->consultarValorTablaRegistro($idMarca, "Marca");
    //$valorReg = $this->consultarValorTablaRegistro($herencia[$i],$arregloCol[$i]);

            $where = "";

          if ($valorFabricante->valor == "OTROS") {
                $where = "";
            } else {
                    $where = " AND idFabricante=" . $idFabricante . "";
          }

        if ($valorMarca->valor == "OTROS") {
             $where = "";
        } else {
                $where = " AND idMarca=" . $idMarca . "";
        }

        $query = "SELECT MAX(ia.id) as id
                FROM item.item_atributo ia,
                     item.base_items ba
                WHERE ba.id = ia.idItem 
                      AND valor = '" . $db->escapeString($valor) . "'
                      AND valor != 'NO TIENE'    
                      AND idAtributo=" . $idAtributo . "
                      AND idCategoria=" . $idCategoria . " " . $where;

        $db->query($query);
        return $db->fetch();
    }
    
    function actualizarItemFaltantes($id, $mensaje, $codigo = 0, $codigoCorto = 0) {
            global $db;

            $query = "UPDATE  item.temporalFaltantesItems "
                   . "SET estado='" . $mensaje . "', "
                   . "nombre_item_completo = '" . $codigo . "', "
                   . "nombre_item_shopper = '" . $codigoCorto . "' "
                   . "WHERE id=" . $id . "";

            $db->query($query);
    }
    
    function actualizarMapeoDatos($label, $codigo, $codigoCorto) {
            global $db;

            $query = "UPDATE  meiko.mapeo_datos "
                   . "SET item='" . $codigo . "', "
                   . " itemCorto='" . $codigoCorto . "' "
                   . "WHERE label='" . $label . "'";
    
            $db->query($query);
    }
    
    function consultarTablaItems() {
        global $db;

        $query = "SELECT DISTINCT * FROM item.temporal_carga ";
        $db->query($query);
        return $db->getArray();
    }
    
    function consultarRegistroHistorial($codigo){
        global  $db;
      
            $query = "SELECT COUNT(0) conteo FROM item.items_completo WHERE codigo ='" . $codigo . "'";
            $db->query($query);
      
        return $db->fetch();
    }
    
    function consultarRegistroHistorialShopper($codigo){
        global  $db;
      
        $query = "SELECT COUNT(0) conteo FROM item.items_shopper WHERE codigo ='" . $codigo . "'";
        $db->query($query);
      
        return $db->fetch();
    
    }
    function insertarItemCompleto($valores, $codigo, $nombre) {
        
        global $db;
 
        $query = "INSERT INTO item.items_completo ("
                //. "id,"
                . "CATEGORIA,"
                . "FABRICANTE,"
                . "MARCA,"
                //. "ITEM,"
                . "TIPO,"
                . "TECNOLOGIA,"
                . "SABOR,"
                . "USO,"
                . "PRESENTACION,"
                . "MAXI_MINI,"
                . "RETORNABILIDAD,"
                . "CALORIAS,"
                . "CONTENIDO,"
                . "UNIDADES,"
                . "VARIEDAD,"
                . "EMPAQUE,"
                . "SABOR_AROMA,"
                . "SUBMARCA,"
                . "COLOR,"
                . "ACTIVIDAD_PROMOCIONAL,"
                . "fechaCreacion,"
                . "nombre,"
                . " codigo)"
                . "VALUES("
                //. "" . $valores["id"] . ","
                . "'" . $db->escapeString($valores["nomCategoria"]) . "',"
                . "'" . $db->escapeString($valores["nomFabricante"]) . "',"
                . "'" . $db->escapeString($valores["nomMarca"]) . "',"
                //. "'" . $db->escapeString($valores["ITEM"]) . "',"
                . "'" . $db->escapeString($valores["TIPO"]) . "',"
                . "'" . $db->escapeString($valores["TECNOLOGIA"]) . "',"
                . "'" . $db->escapeString($valores["SABOR"]) . "',"
                . "'" . $db->escapeString($valores["USO"]) . "',"
                . "'" . $db->escapeString($valores["PRESENTACION"]) . "',"
                . "'" . $db->escapeString($valores["MAXI_MINI"]) . "',"
                . "'" . $db->escapeString($valores["RETORNABILIDAD"]) . "',"
                . "'" . $db->escapeString($valores["CALORIAS"]) . "',"
                . "'" . $db->escapeString($valores["CONTENIDO"]) . "',"
                . "'" . $db->escapeString($valores["UNIDADES"]) . "',"
                . "'" . $db->escapeString($valores["VARIEDAD"]) . "',"
                . "'" . $db->escapeString($valores["EMPAQUE"]) . "',"
                . "'" . $db->escapeString($valores["SABOR_AROMA"]) . "',"
                . "'" . $db->escapeString($valores["SUBMARCA"]) . "',"
                . "'" . $db->escapeString($valores["COLOR"]) . "',"
                . "'" . $db->escapeString($valores["ACTIVIDAD_PROMOCIONAL"]) . "',"
                . "now(),"
                . "'" . $db->escapeString($nombre) . "',"
                . "'" . $codigo . "')";
      
        $db->query($query);
    }
    
    function insertarItemShopper($valores, $codigo, $nombre) {
        global $db;

        $query = "INSERT INTO item.items_shopper ("
               //. "id,"
               . "CATEGORIA,"
               . "FABRICANTE,"
               . "MARCA,"
               //. "ITEM,"
               . "TIPO,"
               . "TECNOLOGIA,"
               . "SABOR,"
               . "USO,"
               . "PRESENTACION,"
               . "MAXI_MINI,"
               . "RETORNABILIDAD,"
               . "CALORIAS,"
               . "CONTENIDO,"
               . "UNIDADES,"
               . "VARIEDAD,"
               . "EMPAQUE,"
               . "SABOR_AROMA,"
               . "SUBMARCA,"
               . "COLOR,"
               . "ACTIVIDAD_PROMOCIONAL,"
               . "fechaCreacion,"
               . "nombre,"
               . " codigo)"
               . "VALUES("
               //. "" . $valores["id"] . ","
               . "'" . $db->escapeString($valores["nomCategoria"]) . "',"
               . "'" . $db->escapeString($valores["nomFabricante"]) . "',"
               . "'" . $db->escapeString($valores["nomMarca"]) . "',"
               //. "'" . $db->escapeString($valores["ITEM"]) . "',"
               . "'" . $db->escapeString($valores["TIPO"]) . "',"
               . "'" . $db->escapeString($valores["TECNOLOGIA"]) . "',"
               . "'" . $db->escapeString($valores["SABOR"]) . "',"
               . "'" . $db->escapeString($valores["USO"]) . "',"
               . "'" . $db->escapeString($valores["PRESENTACION"]) . "',"
               . "'" . $db->escapeString($valores["MAXI_MINI"]) . "',"
               . "'" . $db->escapeString($valores["RETORNABILIDAD"]) . "',"
               . "'" . $db->escapeString($valores["CALORIAS"]) . "',"
               . "'" . $db->escapeString($valores["CONTENIDO"]) . "',"
               . "'" . $db->escapeString($valores["UNIDADES"]) . "',"
               . "'" . $db->escapeString($valores["VARIEDAD"]) . "',"
               . "'" . $db->escapeString($valores["EMPAQUE"]) . "',"
               . "'" . $db->escapeString($valores["SABOR_AROMA"]) . "',"
               . "'" . $db->escapeString($valores["SUBMARCA"]) . "',"
               . "'" . $db->escapeString($valores["COLOR"]) . "',"
               . "'" . $db->escapeString($valores["ACTIVIDAD_PROMOCIONAL"]) . "',"
                . "now(),"
               . "'" . $db->escapeString($nombre) . "',"
               . "'" . $codigo . "')";
      
        $db->query($query);
    }

    function insertarBaseItem($arreglo){
            
		global $db;
		$query="INSERT INTO item.base_items "
                        ."("
                        ."  idCategoria,"
                        ."  idFabricante,"
                        ."  idMarca"
                        .")" 
                        ."VALUES("
                        ."'". $arreglo['categoria'] . "',"
                        ."'". $arreglo['fabricante'] . "',"
                        ."'". $arreglo['marca'] . "'"
                        .")";	
		            
		$db->query($query);
                $idRegistro = $db->getInsertID();
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarBaseItem");
                return $idRegistro;
    }
    
    function insertarAtributoItem($idAtributo,$idItem,$valor){
            
		global $db;
		$query="INSERT INTO item.item_atributo "
                        ."("
                        ."  idAtributo,"
                        ."  idItem,"
                        ."  valor"
                        .")" 
                        ."VALUES("
                        ."'". $idAtributo . "',"
                        ."'". $idItem . "',"
                        ."'". $valor . "'"
                        .")";	
		            
		$db->query($query);               
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarAtributoItem");                
    }
    
    function insertarItemAtributoNotiene($idItem,$idAtributo){
            
		global $db;
		$query="INSERT INTO item.item_atributo "
                        ."("
                        ."  idAtributo,"
                        ."  idItem,"
                        ."  valor"
                        .")" 
                        ."VALUES("
                        ."'". $idAtributo . "',"
                        ."'". $idItem . "',"
                        ."'NO TIENE'"
                        .")";	
		            
		$db->query($query);               
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarAtributoItemNotiene");                
    }
    
    function insertarItemAtributoOtros($idItem,$idAtributo){
            
		global $db;
		$query="INSERT INTO item.item_atributo "
                        ."("
                        ."  idAtributo,"
                        ."  idItem,"
                        ."  valor"
                        .")" 
                        ."VALUES("
                        ."'". $idAtributo . "',"
                        ."'". $idItem . "',"
                        ."'OTROS'"
                        .")";	
		            
		$db->query($query);               
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarAtributoItemNotiene");                
    }
    
    function insertarCategoria($categoria){
            
		global $db;
		$query="INSERT INTO item.categoria "
                        ."("
                        ."  nombreCategoria"
                        .")" 
                        ."VALUES("
                        ."'". $db->escapeString($categoria) . "'"
                        .")";	
		            
		$db->query($query);
                $idCategoria = $db->getInsertID();
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarCategoria");
                return $idCategoria;
    }
    
    function insertarFabricante($fabricante){
            
		global $db;
		$query="INSERT INTO item.fabricante "
                        ."("
                        ."  nombreFabricante"
                        .")" 
                        ."VALUES("
                        ."'". $db->escapeString($fabricante) . "'"
                        .")";	
		            
		$db->query($query);
                $idFabricante = $db->getInsertID();
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarFabricante");
                return $idFabricante;
    }
    
    
    function insertarMarca($marca){
            
		global $db;
		$query="INSERT INTO item.marca "
                        ."("
                        ."  nombreMarca"
                        .")" 
                        ."VALUES("
                        ."'". $db->escapeString($marca) . "'"
                        .")";	
		            
		$db->query($query);
                $idMarca = $db->getInsertID();
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "insertarMarca");
                return $idMarca;
    }
    
    function actualizarValorItemAtributo($idItemAtributo,$valor){            
		global $db;
                
		$query="UPDATE item.item_atributo SET "
                            ."valor = '". $db->escapeString($valor) . "'"                            
                         ." WHERE id = " . $idItemAtributo;	
		        
		$db->query($query);
                $this->log($_SESSION['datos_logueo']['login'], "ItemMaster", $query, "actualizarValorItemAtributo");
    }
    
    function eliminarCliente($id){
        global $db;
        $query="DELETE FROM clientes WHERE id = " . $id . "";
	//echo $query;	              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "borrarCliente");
    }
    
    function inactivarCliente($id){
        global $db;
        $query="UPDATE clientes SET estado='Inactivo' WHERE id = " . $id ;
		              
	$db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "Clientes", $query, "inactivarCliente");
    }
    
    function listaTipos(){
        global $db;
        
        $query="SELECT DISTINCT(tipo) as tipo FROM listavalor";
	$db->query($query);
        return $db->getArray();
    }
    
    function listaAtributos(){
        global $db;
        
        $query="SELECT id,nombreAtributo as nombre FROM item.atributos";
	$db->query($query);
        return $db->getArray();
    }
    
    function consultarBaseItems($idCategoria,$idFabricante,$idMarca){
        global $db;
        
        $query="SELECT id FROM item.base_items "
                . " WHERE idCategoria = " . $idCategoria . " "
                . " AND  idFabricante = " . $idFabricante . " "
                . " AND idMarca = " . $idMarca . " " ;
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarItemAtributoValor($idItem,$idAtributo,$valor){
        global $db;
        
        $query="SELECT id FROM item.item_atributo "
                . " WHERE idAtributo = " . $idAtributo . " "
                . " AND  idItem = " . $idItem . " "
                . " AND valor = '" . $db->escapeString($valor) . "' " ;
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarItemAtributo($idItem,$idAtributo){
        global $db;
        
        $query="SELECT id FROM item.item_atributo "
                . " WHERE idAtributo = " . $idAtributo . " "
                . " AND  idItem = " . $idItem . " "
                . " AND valor NOT IN ('NO TIENE','OTROS') " ;
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarItemAtributoNotiene($idItem,$idAtributo){
        global $db;
        
        $query="SELECT count(0) as contador FROM item.item_atributo "
                . " WHERE idAtributo = " . $idAtributo . " "
                . " AND  idItem = " . $idItem . " "
                . " AND valor IN ('NO TIENE') " ;
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarItemAtributoOtros($idItem,$idAtributo){
        global $db;
        
        $query="SELECT count(0) as contador FROM item.item_atributo "
                . " WHERE idAtributo = " . $idAtributo . " "
                . " AND  idItem = " . $idItem . " "
                . " AND valor IN ('OTROS') " ;
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarCategoria($idCategoria){
        global $db;        
        $query="SELECT * FROM item.categoria "
                . " WHERE id = " . $idCategoria . " ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarFabricante($idFabricante){
        global $db;        
        $query="SELECT * FROM item.fabricante "
                . " WHERE id = " . $idFabricante . " ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarMarca($idMarca){
        global $db;        
        $query="SELECT * FROM item.marca "
                . " WHERE id = " . $idMarca . " ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarVistaItems($idItemAtributo){
        global $db;        
        $query="SELECT * FROM item.vista_item_master "
                . " WHERE idItemAtributo = " . $idItemAtributo . " ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarValorCategoria($categoria){
        global $db;        
        $query="SELECT MAX(id) as id FROM item.categoria "
                . " WHERE nombreCategoria = '" . $db->escapeString($categoria) . "' ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarValorFabricante($fabricante){
        global $db;        
        $query="SELECT MAX(id) as id FROM item.fabricante "
                . " WHERE nombreFabricante = '" . $db->escapeString($fabricante) . "' ";
	$db->query($query);
        return $db->fetch();
    }
    
    function consultarValorMarca($marca){
        global $db;        
        $query="SELECT MAX(id) as id FROM item.marca "
                . " WHERE nombreMarca = '" . $db->escapeString($marca) . "' ";
	$db->query($query);
        return $db->fetch();
    }
   
}
?>