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
require_once(CLASSES_PATH . 'BDControlador.php');

/**
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosReglasCalidad extends BDControlador {

    /**
     * Constructor de la clase "DatosBonificacion"
     * 
     * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
     * de ser necesario.
     */
    public function __construct() {
        //parent :: Manejador_BD();
    }

    public function selectReglaCalidad($idRegla) {
        global $db;

        $query = "SELECT  r.*
                FROM    regla r
                WHERE r.id = $idRegla";

        $db->query($query);
        return $db->fetch();
    }
    
    public function selectDescripcionReglas($idRegla) {
        global $db;

        $query = "SELECT  dr.*
                  FROM descripcionreglas dr
                 WHERE dr.idRegla='" . $idRegla . "'";
        //echo $query;
        $db->query($query);
        return $db->getArray();
    }
    
    
    public function selectAccionReglas($idRegla) {
        global $db;
        
        $query = "SELECT  ac.*
                  FROM acciones ac
                 WHERE ac.idRegla='" . $idRegla . "'";
        //echo $query;
        $db->query($query);
        return $db->getArray();
    }
    
    function traerMapeoDatos($campo) {
        global $db;

        $query = "SELECT  ma.*
                  FROM mapeo_datos ma
                 WHERE ma.id ='" . $campo . "'";
        //echo $query;
        $db->query($query);
        return $db->fetch();
    }
    
        function borrarDescripRegla($idReglaCalidad) {
        global $db;
        //echo'<pre>';print_r($idReglaCalidad);echo'</pre>';
        $query = "DELETE FROM descripcionreglas "
                . "WHERE idRegla = $idReglaCalidad";
        
        //echo'<pre>';print_r($query);echo'</pre>';
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "borrarDescripRegla");
    }
    
    public function traerCentroPoblado($areasMet) {
        global $db;

        $query = "SELECT  g.idCentroPoblado, g.centroPoblado
                  FROM     geo.centropoblado g
                  WHERE g.idCabeceraMunicipal IN(" . $areasMet . ")";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function selectFormatoMedicion($idFormatoMedicion) {
        global $db;
        $query = "SELECT * FROM formato_medicion WHERE idResumenJob = $idFormatoMedicion";        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosOrden($idOrden) {
        global $db;
        $query = "SELECT * FROM ordencompra WHERE id = $idOrden";        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosCliente($idOrden) {
        global $db;
        $query = "SELECT * FROM clientes WHERE id = $idOrden";        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosUsuario($idUsuario) {
        global $db;
        $query = "SELECT us.id,us.nombre FROM usuarios us WHERE us.id = $idUsuario";        
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreUsuarioJob($idUsuarioCreador) {
        global $db;
        $query = "SELECT u.nombre FROM usuarios u WHERE id = $idUsuarioCreador";        
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreUsuarioModificador($idUsuarioModificador) {
        global $db;
        $query = "SELECT u.nombre FROM usuarios u WHERE id = $idUsuarioModificador";        
        $db->query($query);
        return $db->fetch();
    }
    

    function retornarNombreCategoriaJob($idCategoria) {
        global $db;
        $query = "SELECT ca.nombreCategoria FROM categoria ca WHERE ca.idCategoria = $idCategoria";        
        $db->query($query);
        return $db->fetch();
    }
    
    public function mostrarCliente($arreglo) {
        global $db;

        $query = "SELECT  c.*
                FROM    clientes c
                WHERE c.id='" . $arreglo["id"] . "'";

        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCanal($idFormatoMedicion) {
        global $db;

        $query = "SELECT  c.idCanal,c.canal
                  FROM formato_medicion_canales fc,item.canal c
                 WHERE fc.idCanal = c.idCanal
                 AND fc.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
//    public function traerCiclo($idFormatoMedicion) {
//        global $db;
//
//        $query = "SELECT  fc.id,fc.ciclo
//                  FROM formato_medicion_ciclos fc
//                 WHERE  fc.idFormatoMedicion='" . $idFormatoMedicion . "'";
//        
//        $db->query($query);
//        return $db->getArray();
//    }
    
    public function traerAreaMet($idFormatoMedicion) {
        global $db;

        $query = "SELECT  g.idCabeceraMunicipal,g.CabeceraMunicipal
                  FROM formato_medicion_areamet o,geo.cabeceramunicipal g
                 WHERE o.idAreaMetropolitana = g.idCabeceraMunicipal
                 AND o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    
    
//    public function traerMunicipio($idFormatoMedicion) {
//        global $db;
//
//        $query = "SELECT  o.idMunicipio, g.centroPoblado
//                FROM    formato_medicion_municipios o, geo.centropoblado g
//                 WHERE o.idMunicipio = g.idCentroPoblado
//                 AND o.idFormatoMedicion='" . $idFormatoMedicion . "'";
//        
//        $db->query($query);
//        return $db->getArray();
//    }
    
    public function traerCategoria($idCategoria) {
        global $db;

        $query = "SELECT  i.idCategoria,i.nombreCategoriaItem
                FROM    item.categoria i
                 WHERE i.idCategoria='" . $idCategoria . "'";
        
        $db->query($query);
        return $db->fetch();
    }
       
    function insertarReglasCalidad($arreglo) {
        global $db;
        $query = "INSERT INTO regla"
                . "("
                . "  nombre,"
                . "  fechaCreacion,"
                . "  idUsuario,"
                //. "  fechaModificacion,"
                . "  estado,"
                . "  idUsuarioModificador,"
                . "  descripcionRegla,"
                . "  tipoRegla,"
                . "  ordenEjecucionRegla"
                . ")"
                . "VALUES("
                . "'" . $arreglo["nombreRegla"] . "',"
                . "now(),"
                . "'" . $arreglo["idCreador"] . "',"
                . "'" . $arreglo["estado"] . "',"
                . "'" . $arreglo["idCreador"] . "',"
                . "'" . $arreglo["descriRegla"] . "',"
                . "'" . $arreglo["tipoRegla"] . "',"
                . "'" . $arreglo["OrdenEjecucionRegla"] . "'"
                . ")";

        $db->query($query);
        $idRegla = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCaldiad", $query, "insertarReglaCalidad");
        return $idRegla;
    }
    
  
    function insertarDescripRegla($idRegla,$arreglo) {
        global $db;
        $query = "INSERT INTO descripcionreglas"
                . "("
                . "  idRegla," 
                //. "  tablaOrigen,"
                . "  campoOrigen,"
                . "  operacion,"
                . "  valor,"
                //. "  tablaVerificacion,"
                //. "  campoVerificacion,"
                . "  conector,"
                . "  orden,"
                . "  estado"
                . ")"
                . "VALUES("
                . "'" . $idRegla . "',"
                //. "'" .$arreglo-> . "',"
                . "'" .$arreglo->campo . "',"
                . "'" .$db->escapeString($arreglo->operacion) . "',"
                . "'" .$db->escapeString($arreglo->valor) . "',"
                . "'" .$db->escapeString($arreglo->conector) . "',"
                . "'" .$arreglo->orden . "',"
                . "'" .$arreglo->estado . "'"
                . ")";
        
        $db->query($query);
        
        //$idRegla = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "insertarDescripcionRegla");
        return $idRegla;
    }
    
    function eliminarDescRegla($idRegla) {
        global $db;
        $query = "DELETE FROM descripcionreglas WHERE idRegla = " . $idRegla . "";
        //echo $query;	              
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "actualizarDescripcionRegla");
    }
    
    function eliminarAccionRegla($idRegla) {
        global $db;
        $query = "DELETE FROM acciones WHERE idRegla = " . $idRegla . "";
        //echo $query;	              
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "eliminarAccionRegla");
    }
    
    function insertarAccionReglas($idRegla,$arreglo) {
        global $db;
        $query = "INSERT INTO acciones"
                . "("
                . "  idRegla,"
                . "  accion,"
                //. "  anio,"
                . "  campo,"
                . "  valor"
                . ")"
                . "VALUES("
                . "'" . $idRegla . "',"
                . "'" .$arreglo->accion_accion . "',"
                . "'" .$arreglo->campo_accion . "',"
                . "'" .addslashes($arreglo->valor_campo_accion) . "'"
                . ")";
        
        $db->query($query);
        
        //$idRegla = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "insertarAccionReglas");
        return $idRegla;
    }
    
    function actualizarReglaCalidad($arreglo) {
        global $db;
        
        $query = "UPDATE regla SET "
                . "nombre = '" . $arreglo["nombreRegla"] . "',"
                . "fechaModificacion = now(),"
                . "estado = '" . $arreglo["estado"] . "',"
                . "idUsuarioModificador = '" . $arreglo["idCreador"] . "',"
                . "descripcionRegla = '" . $arreglo["descriRegla"] . "',"
                . "tipoRegla = '" . $arreglo["tipoRegla"] . "',"
                . "ordenEjecucionRegla = '" . $arreglo["OrdenEjecucionRegla"] . "'"
                . " WHERE id = " . $arreglo["id"];
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "actualizarReglaCalidad");
    }
    
        function actualizarDescripRegla($arreglo) {
        global $db;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $query = "UPDATE descripcionreglas SET "
                . "campoOrigen = '" . $arreglo->campo . "',"
                . "operacion = '" . $arreglo->operacion . "',"
                . "valor = '" . addslashes($arreglo->valor) . "',"
                . "conector = '" . $arreglo->conector . "',"
                . "orden = '" . $arreglo->orden . "',"
                . "estado = '" . $arreglo->estado . "'"
                . "WHERE id = " . $arreglo->id;
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "actualizarDescripRegla");
    }
    
    function actualizarAccionRegla($arreglo) {
        global $db;
        $query = "UPDATE acciones SET "
                . "accion = '" . $arreglo["accion_accion"] . "',"
               . "campo = '" . $arreglo["campo_accion"] . "',"
                . "valor = '" . addslashes($arreglo["valor_accion"]) . "'"
                . "WHERE id = " . $arreglo["id"];
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "ReglasCalidad", $query, "actualizarAccionRegla");
    }
    
    
//    function insertarFormatoMedCanal($idFormatosMedicion, $canal) {
//        global $db;
//        $query = "INSERT INTO formato_medicion_canales"
//                . "("
//                . "  idFormatoMedicion,"
//                . "  idCanal"
//                . ")"
//                . "VALUES("
//                . "'" . $idFormatosMedicion . "',"
//                . "'" . $canal . "'"
//                . ")";
//
//        $db->query($query);
//    }
    
//    function insertarFormatoMedCiclo($idFormatosMedicion, $ciclo) {
//        global $db;
//        $query = "INSERT INTO formato_medicion_ciclos"
//                . "("
//                . "  idFormatoMedicion,"
//                . "  ciclo"
//                . ")"
//                . "VALUES("
//                . "'" . $idFormatosMedicion . "',"
//                . "'" . $ciclo . "'"
//                . ")";
//
//        $db->query($query);
//    }
//    function insertarFormatoMedAreaMet($idFormatosMedicion, $areaMet) {
//        global $db;
//        $query = "INSERT INTO formato_medicion_areamet"
//                . "("
//                . "  idFormatoMedicion,"
//                . "  idAreaMetropolitana"
//                . ")"
//                . "VALUES("
//                . "'" . $idFormatosMedicion . "',"
//                . "'" . $areaMet . "'"
//                . ")";
//
//        $db->query($query);
//    }
//    
//    function insertarFormatoMedMunicipio($idFormatosMedicion, $municipio) {
//        global $db;
//        $query = "INSERT INTO formato_medicion_municipios"
//                . "("
//                . "  idFormatoMedicion,"
//                . "  idMunicipio"
//                . ")"
//                . "VALUES("
//                . "'" . $idFormatosMedicion . "',"
//                . "'" . $municipio . "'"
//                . ")";
//
//        $db->query($query);
//    }
    
    

//    function actualizarCliente($arreglo) {
//        global $db;
//
//        $query = "UPDATE clientes SET "
//                . "nombre = '" . $arreglo['nombre'] . "',"
//                . "codigo = '" . $arreglo['codigo'] . "',"
//                . "direccion = '" . $arreglo['direccion'] . "',"
//                . "telefono = '" . $arreglo['telefono'] . "',"
//                . "contacto = '" . $arreglo['contacto'] . "',"
//                . "estado = '" . $arreglo['estado'] . "'"
//                . " WHERE id = " . $arreglo['id'];
//
//        $db->query($query);
//        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "actualizarCliente");
//    }

    function eliminarCliente($id) {
        global $db;
        $query = "DELETE FROM clientes WHERE id = " . $id . "";
        //echo $query;	              
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "borrarCliente");
    }

    function inactivarCliente($id) {
        global $db;
        $query = "UPDATE clientes SET estado='Inactivo' WHERE id = " . $id;

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "inactivarCliente");
    }

    function listaTipos() {
        global $db;

        $query = "SELECT DISTINCT(tipo) as tipo FROM listavalor";
        $db->query($query);
        return $db->getArray();
    }
    
    function armarListaSegmento($idCategoria){
        global $db;
        $query = "SELECT distinct s.idSegmento,s.nombreSegmento 
                    FROM item i, segmento s
                    WHERE i.idSegmento=s.idSegmento
                    AND i.idCategoria=" . $idCategoria;
        $db->query($query);
        return $db->getArray();
    }
    
    function armarListaColumnas($idCategoria,$exclusion=""){
        global $db;
        
        if($exclusion !=""){
            $sqlExclusion =" AND a.idAtributo NOT IN(" . $exclusion . ")";
        }else{
            $sqlExclusion ="";
        }
        
        $query = "SELECT distinct a.idAtributo,a.nombreAtributo    
                  FROM atributo a,
                       item_atributo ia,
                       item i
                  WHERE a.idAtributo = ia.idAtributo
                    AND ia.idItem = i.idItem
                    AND i.idCategoria = ". $idCategoria."
                    " . $sqlExclusion . "
                  ORDER BY nombreAtributo";
        $db->query($query);
        return $db->getArray();
    }

}

?>