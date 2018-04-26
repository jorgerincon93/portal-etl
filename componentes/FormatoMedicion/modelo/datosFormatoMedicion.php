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
class DatosFormatoMedicion extends BDControlador {

    /**
     * Constructor de la clase "DatosBonificacion"
     * 
     * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
     * de ser necesario.
     */
    public function __construct() {
        //parent :: Manejador_BD();
    }

    public function selectResumenJob($idResumenJob) {
        global $db;

        $query = "SELECT  o.*
                FROM    resumen_job o
                WHERE o.id = $idResumenJob";

        $db->query($query);
        return $db->fetch();
    }

    function selectFormatoMedicion($idFormatoMedicion) {
        global $db;
        $query = "SELECT * FROM formato_medicion WHERE id = $idFormatoMedicion";        
        $db->query($query);
        return $db->fetch();
    }
    
    function traerFormatoMedicion($idResumenJob) {
        global $db;
        $query = "SELECT * FROM formato_medicion WHERE idResumenJob = $idResumenJob";        
        $db->query($query);
        return $db->getArray();
    }
    
    function selectVariablesMedicion($idFormatoMedicion,$variable) {
        global $db;
        $query = "SELECT * FROM formato_medicion_var_medicion "
                . "WHERE idFormatoMedicion =".$idFormatoMedicion." "
                . "AND variableMedicion ='" .$variable."'";
        $db->query($query);
        return $db->fetch();
    }
    
    function datosCliente($idCliente) {
        global $db;
        $query = "SELECT * FROM clientes WHERE id = $idCliente";        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosAsesor($idUsuario) {
        global $db;
        $query = "SELECT * FROM usuarios WHERE id = $idUsuario";        
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreUsuarioJob($idUsuarioCreador) {
        global $db;
        $query = "SELECT u.nombre FROM usuarios u WHERE id = $idUsuarioCreador";        
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreClienteJob($idCliente) {
        global $db;
        $query = "SELECT u.nombre FROM clientes u WHERE id = $idCliente";        
        $db->query($query);
        return $db->fetch();
    }
    

    function retornarNombreCategoriaJob($idCategoria) {
        global $db;
        $query = "SELECT ca.nombreCategoria FROM item.categoria ca WHERE ca.id = $idCategoria";        
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
    
    public function traerCabecera($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.idAreaMetropolitana,g.AreaMetropolitana
                  FROM formato_medicion_areamet o,geo.areametropolitana g
                 WHERE o.idAreaMetropolitana = g.id
                 AND o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCentroPoblado($idFormatoMedicion) {
        global $db;

        $query = "SELECT  g.id, g.ciudad
                FROM   formato_medicion_areamet a, geo.ciudad g
                 WHERE a.idAreaMetropolitana = g.idAreaMetropolitana
                 AND a.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCiclo($idFormatoMedicion) {
        global $db;

        $query = "SELECT   o.ciclo
                FROM    formato_medicion_ciclos o
                 WHERE  o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCanal($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.idCanal, g.canal
                FROM    formato_medicion_canales o, item.canal g
                 WHERE o.idCanal = g.id
                 AND o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerCategoria($idCategoria) {
        global $db;

        $query = "SELECT  i.idCategoria,i.nombreCategoriaItem
                FROM    item.categoria i
                 WHERE i.idCategoria='" . $idCategoria . "'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function tipoPreAprobarJob($id){
          global $db;
            
          $query = " SELECT l.nombre
                               FROM meiko.listavalor l,
                                    meiko.usuarios u
                              WHERE l.tipo = 'PreAprobarJob'
                                AND u.idrol = l.valor
                                and u.id = $id ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function tipoUsr($id){
          global $db;
            
          $query = " SELECT l.nombre
                               FROM meiko.listavalor l,
                                    meiko.usuarios u
                              WHERE l.tipo = 'aprobarjob'
                                AND u.idrol = l.valor
                                and u.id = $id ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    function crearVistaFmUsuario($idPadre,$tipoUs){
        global $db;
        
        if ($tipoUs == 'Supervisor JOB' || $tipoUs == 'Comercial'){
        
        $query = "CREATE OR REPLACE VIEW vistaformatomedicion_". $idPadre . " AS
               SELECT 
                     fm.avance AS avance,
                     fm.estado AS estado,
                     fm.id AS id,
                     us.nombre AS nombreUsuario,
                     us.id AS idUsuario,
                     fm.anio AS anio,
                     fm.ciclo AS ciclo,
                     cli.nombre AS nombreCliente,
                     cat.nombreCategoria AS nombreCategoria,
                     rj.fechaCreacion AS fechaCreacion,
                     fm.idResumenJob AS idResumenJob,
                     us.idPadre AS idPadre
                FROM
                     meiko.formato_medicion fm,
                     meiko.resumen_job rj,
                     meiko.usuarios us,
                     item.categoria cat,
                     meiko.clientes cli
               WHERE
                    fm.idResumenJob = rj.id
                AND rj.idUsuario = us.id
                AND rj.idCliente = cli.id
                AND fm.idCategoria = cat.id
                AND us.id IN (SELECT 
                                    id
                                FROM meiko.usuarios
                               WHERE idPadre IN (SELECT 
                                                        id
                                                   FROM meiko.usuarios
                                                  WHERE idPadre IN (SELECT 
                                                                          id
                                                                      FROM meiko.usuarios
                                                                     WHERE idPadre = " .$idPadre . ")) 
                UNION 
                  SELECT id
                    FROM meiko.usuarios
                   WHERE idPadre IN (SELECT id
                                       FROM meiko.usuarios
                                      WHERE idPadre = " .$idPadre . ") 
                UNION 
                   SELECT id
                     FROM meiko.usuarios
                    WHERE idPadre = " .$idPadre . " 
                UNION 
                  SELECT id
                    FROM meiko.usuarios
                   WHERE id = " .$idPadre . " 
                UNION SELECT us.id
                        FROM meiko.usuarios us,
                             meiko.listavalor lis
                        WHERE lis.tipo = 'AprobarJob'
                          AND lis.nombre <> 'Comercial'
                          AND lis.valor = us.idRol
                          AND us.idPadre IS NOT NULL
                          AND us.id = " .$idPadre . "
                          AND us.id IN (rj.idUsuario))";  
        
        }
        
        else{
             $query = "CREATE OR REPLACE VIEW vistaformatomedicion_". $idPadre . " AS
                    SELECT fm.avance AS avance,
                           fm.estado AS estado,
                           fm.id AS id,
                           us.nombre AS nombreUsuario,
                           us.id AS idUsuario,
                           fm.anio AS anio,
                           fm.ciclo AS ciclo,
                           cli.nombre AS nombreCliente,
                           cat.nombreCategoria AS nombreCategoria,
                           rj.fechaCreacion AS fechaCreacion,
                           fm.idResumenJob AS idResumenJob,
                           us.idPadre AS idPadre
                      FROM meiko.formato_medicion fm,
                           meiko.resumen_job rj,
                           meiko.usuarios us,
                           item.categoria cat,
                           meiko.clientes cli
                     WHERE fm.idResumenJob = rj.id
                       AND rj.idUsuario = us.id
                       AND rj.idCliente = cli.id
                       AND fm.idCategoria = cat.id
                       AND us.id IN (SELECT 
                                            j.idusuario id
                                       FROM meiko.formato_medicion m,
                                            meiko.resumen_job j
                                      WHERE m.idresumenjob = j.id)
                                        AND us.id IN (rj.idUsuario)";
            
        }
        $db->query($query);
        
    }
    
    function selectHistorialAprobacion($idFormatoMedicion) {
        global $db;
        $query = "SELECT * FROM formato_medicion_aprobaciones fma WHERE fma.idFormatoMedicion = $idFormatoMedicion order by fma.fechaCreacion desc, fma.fechaAprobacion asc";        
        $db->query($query);
        return $db->getArray();
    }
    
    function nombreRol($idPerfil){
        global $db;
        $query = "SELECT ro.rol FROM meiko.rol ro WHERE ro.id = $idPerfil";
        $db->query($query);
        return $db->fetch();
    }   

    function traerCantLineas($id){
        global $db;
        $query = "SELECT COUNT(DISTINCT(fr.fila))cantLineas FROM meiko.formato_medicion_registro fr where fr.idFormatoMedicion = $id order by fr.fila";
        $db->query($query);
        return $db->fetch();
    }
    
    function actualizarOrdenCantLineas($arreglo) {
        global $db;
        $query = "UPDATE ordencompra SET "
                . "cantLineas = " . $arreglo->cantLineas
                . " WHERE idResumenJob = " . $arreglo->idResumenJob;
        
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "actualizarOrdenCantLineas");
    }
    
    function insertarOrdenCategoria($idJobOrder, $idCategoria) {
        global $db;
        $query = "INSERT INTO ordencompra_categorias"
                . "("
                . "  idJobOrder,"
                . "  idCategoria"
                . ")"
                . "VALUES("
                . "'" . $idJobOrder . "',"
                . "'" . $idCategoria . "'"
                . ")";

        $db->query($query);
    }

    function insertarOrdenCabecera($idJobOrder, $idCabecera) {
        global $db;
        $query = "INSERT INTO ordencompra_cabecera"
                . "("
                . "  idJobOrder,"
                . "  idCabeceraMunicipal"
                . ")"
                . "VALUES("
                . "'" . $idJobOrder . "',"
                . "'" . $idCabecera . "'"
                . ")";

        $db->query($query);
    }

    function insertarOrdenCentroPoblado($idJobOrder, $idCentroPoblado) {
        global $db;
        $query = "INSERT INTO ordencompra_centropoblado"
                . "("
                . "  idJobOrder,"
                . "  idCentroPoblado"
                . ")"
                . "VALUES("
                . "'" . $idJobOrder . "',"
                . "'" . $idCentroPoblado . "'"
                . ")";

        $db->query($query);
    }
    
    function insertarJobOrder($idJobOrder,$idCategoria, $arreglo) {
        global $db;
        $query = "INSERT INTO joborder"
                . "("
                . "  idUsuarioCreador,"
                . "  idCliente,"
                . "  idCategoria,"
                . "  fechaCreacion,"
                . "  idJobOrder,"
                . "  avance"
                . ")"
                . "VALUES("
                . "'" . $arreglo["idAsesor"] . "',"
                . "'" . $arreglo["idCliente"] . "',"
                . "'" . $idCategoria . "',"
                . "now(),"
                . "'" . $idJobOrder . "',"                
                . "'10'"
                . ")";

        $db->query($query);
    }

    function actualizarFormatoMedicion($arreglo) {
        global $db;
        $query = "UPDATE formato_medicion SET "
                . "tendencia = '" . $arreglo['tendencia'] . "',"
                . "observacionesTendencia = '" . $db->escapeString($arreglo['observacionesTendencia']) . "',"
                . "observacionesGeomatica = '" . $db->escapeString($arreglo['obsGeomatica']) . "',"
                . "anexaTipificacion = '" . $arreglo['tipificacion'] . "',"
                . "urlTipificacion = '" . $db->escapeString($arreglo['urlTipificacion']) . "',"
                . "observacionesGenerales = '" . $db->escapeString($arreglo['obsGenerales']) . "',"
                . "fecha_ult_modificacion = now(),"
                . "avance = '" . $arreglo['avance'] . "',"
                . "estado = '" . $arreglo['estado'] . "'"
                . " WHERE id = " . $arreglo['id'];

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "actualizarFormatoMedicion");
    }
    
    function borrarGeoSegmentacion($idFormatoMedicion){
        global $db;
        
        $query = "DELETE FROM formato_medicion_geosegmento WHERE idFormatoMedicion=".$idFormatoMedicion;
        
        $db->query($query);        
    }
    
    function actualizarGeoSegmentacion($idFormatoMedicion,$geosegmentacion){        
        global $db;
        $query = "INSERT INTO formato_medicion_geosegmento ( "
                . "idFormatoMedicion,"
                . "geosegmentacion"                
                . ") VALUES ("
                . "" . $idFormatoMedicion . ","
                . "'" . $geosegmentacion ."'"
                . ")";
        //echo $query;
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "actualizarVariablesMedicion");
    }
    
    function borrarVariablesMedicion($idFormatoMedicion){
        global $db;
        
        $query = "DELETE FROM formato_medicion_var_medicion WHERE idFormatoMedicion=".$idFormatoMedicion;
        
        $db->query($query);        
    }
    
    function traerVariablesMedicion($idFormatoMedicion){
        global $db;
        
        $query = "SELECT * FROM formato_medicion_var_medicion WHERE idFormatoMedicion=".$idFormatoMedicion;
        
        $db->query($query);
        return $db->getArray();
    } 
    
    function actualizarVariablesMedicion($idFormatoMedicion,$variableMedicion){        
        global $db;
        $query = "INSERT INTO formato_medicion_var_medicion ( "
                . "idFormatoMedicion,"
                . "variableMedicion"                
                . ") VALUES ("
                . "" . $idFormatoMedicion . ","
                . "'" . $variableMedicion ."'"
                . ")";
        //echo $query;
        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "actualizarVariablesMedicion");
    }
    
    function borrarVariablesEspeciales($idFormatoMedicion){
        global $db;
        
        $query = "DELETE FROM formato_medicion_var_especiales WHERE idFormatoMedicion=".$idFormatoMedicion;
        $db->query($query);        
    }   
    
    function actualizarVariablesEspeciales($idFormatoMedicion,$variableMedicion,$valor){
        global $db;
            
        $query = "INSERT INTO formato_medicion_var_especiales ( "
                . "idFormatoMedicion,"
                . "variableEspecial,"
                . "valor"                
                . ")VALUES("
                . "" . $idFormatoMedicion . ","
                . "'" . $variableMedicion ."',"
                . "'" . $db->escapeString($valor) . "'"
                . ")";

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "actualizarVariablesEspeciales");
    }
    
    function borrarColumnas($idFormatoMedicion){
        global $db;
        
        $query = "DELETE FROM formato_medicion_columnas WHERE idFormatoMedicion=".$idFormatoMedicion;
        $db->query($query);        
    } 
    
    function guardarColumna($idFormatoMedicion,$tabla,$valor,$orden){
        global $db;
        
        $query = "INSERT INTO formato_medicion_columnas ( "
                . "idFormatoMedicion,"
                . "tabla,"
                . "orden,"
                . "valor"                
                . ")VALUES("
                . "" . $idFormatoMedicion . ","
                . "'" . $tabla ."',"
                . "'" . $orden ."',"
                . "'" . $valor . "'"
                . ")";

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "guardarColumnas");
    }
    
    function borrarRegistros($idFormatoMedicion){
        global $db;
        
        $query = "DELETE FROM formato_medicion_registro_variable WHERE idRegistro IN (SELECT id FROM formato_medicion_registro WHERE idFormatoMedicion=".$idFormatoMedicion.")";
        $query = "DELETE FROM formato_medicion_registro WHERE idFormatoMedicion=".$idFormatoMedicion;
        $db->query($query);        
    }
    
    function guardarRegistro($idFormatoMedicion,$tabla,$valor,$herencia,$fila,$columna,$orden,$codigoItem,$codigoItemCorto){
        global $db;
        
        $query = "INSERT INTO formato_medicion_registro ( "
                . "idFormatoMedicion,"
                . "tabla,"
                . "valor,"
                . "herencia,"
                . "fila,"
                . "columna,"
                . "orden,"
                . "codigo,"
                . "codigoCorto"
                . ")VALUES("
                . "" . $idFormatoMedicion . ","
                . "'" . $tabla ."',"
                . "'" . $valor ."',"
                . "'" . $herencia ."',"
                . "'" . $fila ."',"
                . "'" . $columna ."',"
                . "'" . $orden . "',"
                . "'" . $codigoItem . "',"
                . "'" . $codigoItemCorto . "'"
                . ")";
        
        $db->query($query);
        $idRegistro = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "guardarRegistro");
        return $idRegistro;
    }
    
    function guardarRegistroVariable($idRegistro,$idVariableMedicion,$valor){
        global $db;
        $query = "INSERT INTO formato_medicion_registro_variable ( "
                . "idRegistro,"
                . "idVariableMedicion,"
                . "valor"                
                . ")VALUES("
                . "" . $idRegistro . ","
                . "'" . $idVariableMedicion ."',"
                . "'" . $db->escapeString($valor) ."'"
                . ")";

        $db->query($query);        
        $this->log($_SESSION['datos_logueo']['login'], "FormatoMedicion", $query, "guardarRegistro");        
    }

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
    
    function armarListaFabricante($idCategoria){
        global $db;
        $query = "SELECT distinct f.id,f.nombreFabricante 
                    FROM item.base_items i, item.fabricante f
                    WHERE i.idFabricante=f.id
                    AND i.idCategoria=" . $idCategoria;
        $db->query($query);
        return $db->getArray();
    }
    
    function armarListaColumnas($idCategoria,$exclusion=""){
        global $db;
        
        if($exclusion !=""){
            $sqlExclusion =" AND a.id NOT IN(" . $exclusion . ")";
        }else{
            $sqlExclusion ="";
        }
        
        $query = "SELECT distinct a.id,a.nombreAtributo
                  FROM item.atributos a,
                       item.item_atributo ia,
                       item.base_items i
                  WHERE a.id = ia.idAtributo
                    AND ia.idItem = i.id
                    AND i.idCategoria = ". $idCategoria."
                    " . $sqlExclusion . "
                  ORDER BY nombreAtributo";
        $db->query($query);
        //echo $query;
        return $db->getArray();
    }
    
    function armarListaRegistroDinamico($arregloCol,$herencia,$columna){
        global $db;
        
        if($columna <=3){
            $select = "SELECT distinct col.id,col.nombre".ucfirst($arregloCol[$columna -1])." ";
            $from = "FROM  item.base_items i, item." . $arregloCol[$columna -1] ." col ";
            $where = "WHERE i.id".ucfirst($arregloCol[$columna -1])." = col.id ";
            $order = "ORDER BY col.nombre".ucfirst($arregloCol[$columna -1])." ";
            
            for($i=0;$i<$columna-1;$i++){
                $valorReg = $this->consultarValorTablaRegistro($herencia[$i],$arregloCol[$i]);
                
                if($valorReg->valor != 'OTROS'){
                    $where = $where . "AND i.id".ucfirst($arregloCol[$i])."=". $herencia[$i]." " ;
                }                
            }
            
        }else{
            $select = "SELECT DISTINCT ia.id, ia.valor ";
            $from = "FROM  item.base_items i, item.item_atributo ia ";
            $where = "WHERE ia.idItem = i.id AND ia.idAtributo=".ucfirst($arregloCol[$columna -1])." ";
            $order = "ORDER BY ia.valor ";
           
            $whereBasico = "";
           
            for($i=0;$i<$columna-1;$i++){
                if ($i<=2){
                    $valorReg = $this->consultarValorTablaRegistro($herencia[$i],$arregloCol[$i]);
                    
                    if($valorReg->valor != 'OTROS'){
                        $whereBasico = $whereBasico . "AND i.id".ucfirst($arregloCol[$i])."=". $herencia[$i]." " ;
                    }
                }else{
                    $where = $where . "AND EXISTS ( SELECT iaa.idItem FROM item.item_atributo iaa WHERE iaa.idItem = i.id "
                            . "AND iaa.valor = '". $herencia[$i]."' AND iaa.idAtributo = " . ucfirst($arregloCol[$i]) . " " .$whereBasico . ")" ;
                }
            }
            $where = $where . $whereBasico;
           
        }
        $query = $select . $from . $where . $order;
        
//        $query = "SELECT distinct col.id".ucfirst($colAct).",col.nombre".ucfirst($colAct)."    
//                  FROM  item i,"
//                  . $colAct ." col                       
//                  WHERE i.idCategoria = ". $idCategoria."
//                    AND i.id".ucfirst($colAnt)." = ".$valor."
//                    AND i.id".ucfirst($colAct)." = col.id".ucfirst($colAct)."
//                  ORDER BY col.nombre".ucfirst($colAct)."";
        //echo $query;
        $db->query($query);
        
        return $db->getArray();
    }
    
    function traerNombreAtributo($idAtributo){
        global $db;
        
        $query = "SELECT a.nombreAtributo FROM item.atributos a WHERE a.id=".$idAtributo;
        $db->query($query);        
        return $db->fetch();
        
    }
    
    public function traerGeoSeg($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.id,o.geosegmentacion
                  FROM formato_medicion_geosegmento o
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerVarMedicion($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.*,l.*
                  FROM formato_medicion_var_medicion o, listavalor l
                 WHERE o.variableMedicion = l.valor
                        AND tipo='VariablesMedicion'
                        AND o.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerVarMedicionCompleto($idFormatoMedicion) {
        global $db;

        $query = "SELECT  l.valor,l.nombre
                  FROM formato_medicion_var_medicion o, listavalor l
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . "AND l.valor=o.variableMedicion "
                . "AND l.tipo='VariablesMedicion' ";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerVarEspeciales($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.id,o.variableEspecial,o.valor as valorRegistro ,l.*
                  FROM formato_medicion_var_especiales o, listavalor l
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "'"
                        . "AND l.valor=o.variableEspecial "
                        . "AND l.tipo='VariablesEspecialesAnalisis' ";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerVarEspecial($idFormatoMedicion,$variableEspecial) {
        global $db;

        $query = "SELECT  o.id,o.variableEspecial,o.valor
                  FROM formato_medicion_var_especiales o
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "'"
                . "AND o.variableEspecial='" . $variableEspecial ."'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerRegistroVarMedicion($idRegistro,$idVarMed) {
        global $db;

        $query = "SELECT  o.id,o.idRegistro,o.idVariableMedicion,o.valor
                  FROM formato_medicion_registro_variable o
                 WHERE o.idRegistro='" . $idRegistro . "' "
                . "AND o.idVariableMedicion='" . $idVarMed . "'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerColumnasFormato($idFormatoMedicion) {
        global $db;

        $query = "SELECT  o.id,o.tabla,o.orden,o.valor
                  FROM formato_medicion_columnas o
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "' ORDER BY o.orden";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerValorColumnas($valor) {
        global $db;

        $query = "SELECT  ia.*
                  FROM item.atributos ia
                 WHERE ia.id=" . $valor . "";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function cantidadFilasRegistro($idFormatoMedicion) {
        global $db;

        $query = "SELECT  MAX(r.fila) as maxFila
                  FROM formato_medicion_registro r
                 WHERE r.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerRegistrosFormato($idFormatoMedicion) {
        global $db;

        $query = "SELECT  r.*
                  FROM formato_medicion_registro r
                 WHERE r.idFormatoMedicion='" . $idFormatoMedicion . "' ORDER BY fila,columna";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerValorFormatoPosicion($idFormatoMedicion,$fila,$columna) {
        global $db;

        $query = "SELECT  r.*
                  FROM meiko.formato_medicion_registro r
                 WHERE r.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . "AND fila = " . $fila . " "
                . "AND columna = " . $columna;
        
        $db->query($query);
        return $db->fetch();
    }
    
    
    public function traerValorFormatoTabla($valor,$tabla) {
        global $db;

        $query = "SELECT  t.nombre" .  ucfirst($tabla) ." as nombre
                  FROM item." . $tabla . " t
                 WHERE t.id=" . $valor;
        
        $db->query($query);
        return $db->fetch();
    }
    
    
    
    public function insertarAprobacion($idFormatoMedicion,$idPerfil,$estado,$porcentaje){
        global $db;
        
        $query="INSERT INTO formato_medicion_aprobaciones"
                . "("
                . "idFormatoMedicion,"
                . "idPerfil,"
                . "estado,"
                . "fechaCreacion,"
                . "porcentaje"
                . ")VALUES("
                . "" . $idFormatoMedicion . ","
                . "" . $idPerfil . ","
                . "'" . $estado . "',"
                . "now(),"
                . "" . $porcentaje . ""
                . ")";        
        $db->query($query);
    }
    
    public function traerPerfilesAprobacion() {
        global $db;

        $query = "SELECT  lv.*
                  FROM listavalor lv
                 WHERE lv.tipo='AprobarJob'
                 ORDER BY valor";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function actualizarEstadoAprobacion($idFormatoMedicion,$idPerfil,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE formato_medicion_aprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idFormatoMedicion='" . $idFormatoMedicion . "'
                     AND fma.estado='Pendiente'
                     AND fma.idPerfil = '" . $idPerfil . "'";
        
        $db->query($query);
    }
    
    public function actualizarEstadoPreAprobacion($idFormatoMedicion,$idPerfil,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE formato_medicion_aprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idFormatoMedicion='" . $idFormatoMedicion . "'
                     AND fma.estado='Pre Aprobado'
                     AND fma.idPerfil = '" . $idPerfil . "'";
        
        $db->query($query);
    }
    
    public function actualizarEstAprobacion($idFormatoMedicion,$estado, $idUsuario,$obs="") {
        global $db;

        $query = "UPDATE formato_medicion_aprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "',
                       fma.obsAprobacion = '" . $db->escapeString($obs) . "'
                 WHERE fma.idFormatoMedicion='" . $idFormatoMedicion . "'
                     AND fma.estado='Pre Aprobado'";
        
        $db->query($query);
    }
    
    public function actualizarEstadoFormato($idFormatoMedicion,$estado,$avance) {
        global $db;

        $query = "UPDATE formato_medicion fm
                  SET  fm.estado = '" . $estado . "',
                       fm.avance = fm.avance + " . $avance . "
                 WHERE fm.id='" . $idFormatoMedicion . "'";
        
        $db->query($query);
    }
    
    public function actualizarEstadoFormatoPreAprobado($idFormatoMedicion,$estado,$avance) {
        global $db;

        $query = "UPDATE formato_medicion fm
                  SET  fm.estado = '" . $estado . "',
                       fm.avance = '" . $avance . "'
                 WHERE fm.id='" . $idFormatoMedicion . "'";
        
        $db->query($query);
    }
    
    function traerCorreoPadre($idPadre){
        global $db;
        
        $query ="SELECT lv.email 
                   FROM usuarios lv
                  WHERE lv.id = $idPadre";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function rechazarEstadoFormato($idFormatoMedicion,$estado) {
        global $db;

        $query = "UPDATE formato_medicion fm
                  SET  fm.estado = '" . $estado . "',
                       fm.avance = '15'
                 WHERE fm.id='" . $idFormatoMedicion . "'";
        
        $db->query($query);
    }
    
    public function rechazarEstadoAprobacion($idFormatoMedicion,$estado,$idUsuario,$obs,$perfil) {
        global $db;

        $query = "UPDATE formato_medicion_aprobaciones fma 
                  SET  fma.obsAprobacion = '" . $db->escapeString($obs) . "',
                       fma.estado = '" . $estado . "', 
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "'
                 WHERE fma.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . "AND fma.idPerfil=" . $perfil ." "
                . "AND fma.obsAprobacion IS NULL ";
               // . "AND fma.estado='Pendiente' ";
        
        $db->query($query);
        
        $query = "UPDATE formato_medicion_aprobaciones fma 
                  SET  fma.estado = '" . $estado . "',
                       fma.fechaAprobacion = now(),
                       fma.idUsuario = '" . $idUsuario . "'
                 WHERE fma.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . "AND fma.estado <> 'Rechazado'";
        
        $db->query($query);
    }
    
    public function mostrarPermisoAprobacion($idFormatoMedicion,$idRol) {
        global $db;

        $query = "SELECT fm.* FROM formato_medicion_aprobaciones fm "
                . "WHERE  fm.idFormatoMedicion=" . $idFormatoMedicion . " "
                        . " AND fm.estado = 'Pendiente' "
                        . " AND fm.idPerfil = " . $idRol . " ";
        
        $db->query($query);
        return $db->fetch();
        //return $query;
    }
    
    public function mostrarPermisoPreAprobacion($idFormatoMedicion,$idRol) {
        global $db;

        $query = "SELECT fm.* FROM formato_medicion_aprobaciones fm "
                . "WHERE  fm.idFormatoMedicion=" . $idFormatoMedicion . " "
                        . " AND fm.estado = 'Pre Aprobado' "
                        . " AND fm.idPerfil = " . $idRol . " ";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function consultarPermisoObsItem($idPerfil) {
        global $db;

        $query = "SELECT  lv.*
                  FROM listavalor lv
                 WHERE lv.tipo='ObservacionesItem'
                 AND lv.valor = " . $idPerfil . "
                 ORDER BY valor";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function consultarValorTablaRegistro($valor,$tabla){
        global $db;

        $query = "SELECT  nombre" . ucfirst($tabla) . " as valor "
                . "FROM item." . strtolower($tabla) . " i "
                . "WHERE id=" . $valor . "";
        
        $db->query($query);
        return $db->fetch();        
    }
    
    public function consultarIdTablaRegistro($valor,$tabla){
        global $db;

        $query = "SELECT  id,nombre" . ucfirst($tabla) . " as valor "
                . "FROM item." . strtolower($tabla) . " i "
                . "WHERE nombre" . ucfirst($tabla) . "='" . $db->escapeString($valor) . "'";
        
        $db->query($query);
        return $db->fetch();        
    }
    
    public function insertarAprobObsItem($idFormatoMedicion,$idUsuario,$idPerfil,$fila,$observaciones){
        global $db;        
        $query="INSERT INTO formato_medicion_aprob_item"
                . "("
                . "idFormatoMedicion,"
                . "idUsuario,"
                . "idPerfil,"
                . "fila,"
                . "observaciones,"
                . "fecha_creacion,"
                . "estado"
                . ")VALUES("
                . "" . $idFormatoMedicion . ","
                . "" . $idUsuario . ","
                . "'" . $idPerfil . "',"
                . "'" . $fila . "',"
                . "'" . $db->escapeString($observaciones) . "',"
                . "now(),"
                . "'Creado'"
                . ")";      
        
        $db->query($query);
    }
    
    public function consultarAprobObsItem($idFormatoMedicion,$fila){
        global $db;        
        $query="SELECT * FROM formato_medicion_aprob_item "
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion . " "
                . "AND fila=" . $fila . " "
                . "AND estado='Creado' "
                . "ORDER BY fecha_creacion DESC";
        $db->query($query);
        return $db->fetch();
    }
    
    public function jerarquiaJob($idJerarquia){
        global $db;
         $query = "select * from meiko.usuarios "
                  . "where idPadre =" . $idJerarquia . " "
                  . "or id =" . $idJerarquia . " ";
         
        $db->query($query);
        return $db->getArray();
    }
    
    public function actualizarAprobObsItem($idFormatoMedicion){
        global $db;        
        $query="UPDATE formato_medicion_aprob_item "
                . "SET estado='Ajustado'"
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion . " ";
        $db->query($query);
    }
    
    public function traerEstructuraCodigo(){
        global $db;        
        $query="SELECT * FROM item.estructura_codigos order by orden ";
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerEstructuraCodigoCorto(){
        global $db;        
        $query="SELECT * FROM item.estructura_codigos_cortos order by orden ";
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerValorColumnasFormato($idFormatoMedicion,$columna,$valor) {
        global $db;
        
        $arrayBasicas = array('CATEGORIA','FABRICANTE','MARCA');

        IF(in_array($columna, $arrayBasicas)){
            $query = "SELECT  o.id,o.tabla,o.orden,o.valor
                  FROM formato_medicion_columnas o
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . " AND UPPER(tabla)='" . $columna . "'";
        }else{
            $query = "SELECT  o.id,o.tabla,o.orden,o.valor
                  FROM formato_medicion_columnas o
                 WHERE o.idFormatoMedicion='" . $idFormatoMedicion . "' "
                . " AND valor=" . $valor . " ";
        }
        
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerNombreColumnasFormato($idFormatoMedicion) {
        global $db;
        $query="SELECT CASE
                            WHEN c.tabla = 'atributo' THEN UPPER(a.nombreAtributo)
                            ELSE UPPER(c.tabla)
                        END AS nombreColumna            
                FROM meiko.formato_medicion_columnas c LEFT JOIN item.atributos a ON c.valor = a.id
                WHERE idFormatoMedicion = " . $idFormatoMedicion;
        $db->query($query);
        return $db->getArray();
    }
    
    public function retornarInfoAtributo($valor,$idAtributo,$idCategoria,$idFabricante,$idMarca){
        global $db;
        
        $valorFabricante = $this->consultarValorTablaRegistro($idFabricante,"Fabricante");
        $valorMarca = $this->consultarValorTablaRegistro($idMarca,"Marca");
        //$valorReg = $this->consultarValorTablaRegistro($herencia[$i],$arregloCol[$i]);
        
        $where = "";
        
        if($valorFabricante->valor == "OTROS"){
            $where = "";
        }else{
            $where = " AND idFabricante=" . $idFabricante . "";
        }
        
        if($valorMarca->valor == "OTROS"){
            $where = "";            
        }else{
            $where = " AND idMarca=" . $idMarca . "";
        }
        
        $query="SELECT MAX(ia.id) as id
                FROM item.item_atributo ia,
                     item.base_items ba
                WHERE ba.id = ia.idItem 
                      AND valor = '" . $db->escapeString($valor) . "'
                      AND idAtributo=" . $idAtributo . "
                      AND idCategoria=" . $idCategoria . " " . $where;
        
        $db->query($query);
        return $db->fetch();
    }
    
    
    public function listarItemsShopper(){
        global $db;
            $sql = "SELECT ia.*
                        FROM item.temporal_cargue_item_shooper ia";
        $db->query($sql);
        return $db->getArray();
    }
    
    public function insertarRegistroShopper($nombre,$codigo){
        global $db;        
        $query="INSERT INTO item.items_shopper"
                . "("
                . "nombre,"
                . "codigo"                
                . ")VALUES("
                . "'" . $db->escapeString($nombre) . "',"
                . "'" . $codigo . "'"
                . ")";      
        
        $db->query($query);
    }

}

?>