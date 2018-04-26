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
class DatosJobOrder extends BDControlador {

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

        $query = "SELECT  j.*
                FROM    resumen_job j
                WHERE j.id = $idResumenJob";

        $db->query($query);
        return $db->fetch();
    }
    
    public function selectFormatosMedicion($idResumenJob) {
        global $db;

        $query = "SELECT  f.*
                  FROM formato_medicion f
                 WHERE f.idResumenJob='" . $idResumenJob . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
 public function traerCentroPoblado($areasMet) {
        global $db;
        
        $query = "SELECT  g.id, g.ciudad
                  FROM     geo.ciudad g
                  WHERE g.idAreaMetropolitana IN(" . $areasMet . ")";
        
        $db->query($query);
        return $db->getArray();
    }
    
    function selectFormatoMedicion($idResumenJob) {
        global $db;
        $query = "SELECT * FROM formato_medicion WHERE idResumenJob = $idResumenJob";        
        $db->query($query);
        return $db->fetch();
    }
    
        function formatoMedicion($idResumenJob) {
        global $db;
        $query = "SELECT * FROM formato_medicion WHERE idResumenJob = $idResumenJob";        
        $db->query($query);
        return $db->getArray();
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
    
    function datosAsesor($idUsuario) {
        global $db;
        $query = "SELECT nombre FROM usuarios WHERE id = $idUsuario";        
        $db->query($query);
        return $db->fetch();
    }
    
    function datosUsuario($idUsuario) {
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
    
    public function traerCanal($idFormatoMedicion) {
        global $db;

        $query = "SELECT  c.id,c.canal
                  FROM formato_medicion_canales fc,item.canal c
                 WHERE fc.idCanal = c.id
                 AND fc.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
        public function nombreCanal($idFormatoMedicion) {
        global $db;

        $query = "SELECT c.canal
                  FROM formato_medicion_canales fc,item.canal c
                 WHERE fc.idCanal = c.id
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

        $query = "SELECT  g.id,g.areaMetropolitana
                  FROM formato_medicion_areamet o,geo.areametropolitana g
                 WHERE o.idAreaMetropolitana = g.id
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

        $query = "SELECT  i.id,i.nombreCategoria
                FROM    item.categoria i
                 WHERE i.id='" . $idCategoria . "'";
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function ContarFormatoMedicion($id) {
        global $db;

        $query = "SELECT count(id) AS cantodadFormanto
                FROM    formato_medicion i
                 WHERE i.idResumenJob='" . $id . "'";
        echo'<pre>';print_r($query);echo'</pre>';
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
    
    function crearVistaRjobUsuario($idPadre,$tipoUs){
        global $db;
        
        if ($tipoUs == 'Supervisor JOB' || $tipoUs == 'Comercial'){
        $query = "CREATE OR REPLACE VIEW vistaResumenJob_". $idPadre . " AS
                     SELECT rjo.id idResumenJob,
			    rjo.estado,
		            usu.id idUsuario,
			    usu.nombre nombreUsuario,
			    cli.id idCliente,
			    cli.nombre nombreCliente,
			    rjo.fechaCreacion,
                            usu.idPadre
                       FROM meiko.resumen_job rjo,
		            meiko.usuarios usu,
			    meiko.clientes cli
                      WHERE  rjo.idCliente = cli.id
                            AND usu.id IN (SELECT id
				             FROM meiko.usuarios
                                            WHERE idPadre IN (SELECT id 
                                                                FROM meiko.usuarios
                                                               WHERE idPadre IN (SELECT id
								                 FROM meiko.usuarios
                                                                                WHERE idPadre =" .$idPadre . ")) 
                                               UNION
                                               SELECT id
                                                 FROM meiko.usuarios
                                                 WHERE idPadre IN (SELECT id
                                                                   FROM meiko.usuarios
							            WHERE idPadre =" .$idPadre . ") 
                                               UNION 
                                               SELECT id
                                                 FROM meiko.usuarios
		                                WHERE idPadre =" .$idPadre . "
                                               UNION 
                                               SELECT id
                                                 FROM meiko.usuarios
		                                WHERE id =" .$idPadre . "
                                                )
                                            AND usu.id IN (rjo.idUsuario)";
        
        }else{
            $query = "CREATE OR REPLACE VIEW vistaResumenJob_". $idPadre . " AS
                     SELECT rjo.id idResumenJob,
			    rjo.estado,
		            usu.id idUsuario,
			    usu.nombre nombreUsuario,
			    cli.id idCliente,
			    cli.nombre nombreCliente,
			    rjo.fechaCreacion,
                            usu.idPadre
                       FROM meiko.resumen_job rjo,
		            meiko.usuarios usu,
			    meiko.clientes cli
                      WHERE rjo.idCliente = cli.id
                        AND usu.id IN (rjo.idUsuario)";
        }
            
        
        $db->query($query);
        
    }
    
    function insertarResumenJobOrder($arreglo) {
        global $db;
        $query = "INSERT INTO resumen_job"
                . "("
                . "  fecha,"
                . "  fechaCreacion,"
//                . "  anio,"
                . "  idUsuario,"
                . "  idCliente,"
                . "  observaciones,"
                . "  estado"
                . ")"
                . "VALUES("
                . "'" . date("Y-m-d") . "',"
                . "now(),"
//                . "'" . $arreglo["anio"] . "',"
                . "'" . $arreglo["idAsesor"] . "',"
                . "'" . $arreglo["idCliente"] . "',"
                . "'" . addslashes($arreglo["obsGenerales"]) . "',"
                . "'" . $arreglo["estado"] . "'"
                . ")";

        $db->query($query);
        
        $idResumenOrden = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "insertarResumenJobOrder");
        return $idResumenOrden;
    }
    
    function actualizarResumenJobOrder($arreglo) {
        global $db;

        $query = "UPDATE resumen_job SET "
                . "observaciones='" . addslashes($arreglo["obsGenerales"]) . "',"
                . "idUsuarioModificador='". $arreglo["idAsesor"] . "',"
                . "fechaModificacion=now()"
                . " WHERE id = " . $arreglo['id'];

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "actualizarCliente");
    }
    
    function insertarOrdenCompra($idResumenJob, $arreglo) {
        global $db;
        $query = "INSERT INTO ordencompra"
                . "("
                . "  idResumenJob,"
                . "  idUsuario,"
                . "  fechaCreacion,"
                . "  cantFormatos,"
                . "  estado"
                . ")"
                . "VALUES("
                . "'" .$idResumenJob . "',"
                . "'" . $arreglo["idAsesor"] . "',"
                . "now(),"
                . "'" . $arreglo["cantFormatos"] . "',"
                . "'" .$arreglo["estado"] . "'"
                . ")";

        $db->query($query);
        
        $idResumenOrden = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "insertarResumenJobOrder");
        return $idResumenOrden;
    }
    
    function actualizarCantidadFormatoMedicion($cantFormatos,$idResumenJob) {
        global $db;

        $query = "UPDATE ordencompra SET "
                . "cantFormatos = $cantFormatos"
                . " WHERE idResumenJob = $idResumenJob";

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "actualizarCliente");
    }
    
    function insertarFormatoMedicion($idResumenJob,$arreglo) {
        global $db;
        $query = "INSERT INTO formato_medicion"
                . "("
                . "  idResumenJob,"
                . "  idCategoria,"
                . "  anio,"
                . "  ciclo,"
                . "  tipoEstudio,"
               // . "  frecuencia,"
                . "  cantidadFrecuencia,"
                . "  avance,"
                . "  estado"
                . ")"
                . "VALUES("
                . "'" . $idResumenJob . "',"
                . "'" .$arreglo->categoria . "',"
                . "'" .$arreglo->anio . "',"
                . "'" .$arreglo->ciclo . "',"
                . "'" .$arreglo->tipoEstudio . "',"
                //. "'" .$arreglo->frecuencia . "',"
                . "'" .$arreglo->cantFrecuencia . "',"
                . "'10',"
                . "'Creado'"
                . ")";

        $db->query($query);
        
        $idFormatoMedicion = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "insertarFormatoMedicion");
        return $idFormatoMedicion;
    }
    
    function actualizarFormatoMedicion($arreglo) {
        global $db;

        $query = "UPDATE formato_medicion SET "
                . "idCategoria = '" . $arreglo->categoria . "',"
                . "anio = '" . $arreglo->anio . "',"
                . "ciclo = '" . $arreglo->ciclo . "',"
                . "tipoEstudio = '" . $arreglo->tipoEstudio . "',"
                . "frecuencia = '" . $arreglo->frecuencia . "',"
                . "cantidadFrecuencia = '" . $arreglo->cantFrecuencia . "'"
                . " WHERE id = " .$arreglo->id;

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "actualizarFormatoMedicion");
    }
    
    function limpiarTablasFormatoMedicion($idResumenJob,$excluidos) {
        global $db;
        $inicial = "SELECT id FROM formato_medicion "
                . "WHERE idResumenJob = " .$idResumenJob . " "
                . "AND id NOT IN(" . $excluidos . ")";        
        
        $db->query($inicial);
        $cont = $db->countRows();       
        
        if($cont > 0){
            $query1 = "DELETE FROM formato_medicion_canales "
                    . "WHERE idFormatoMedicion IN(" . $inicial . ")";
            
            $db->query($query1);

            $query2 = "DELETE FROM formato_medicion_areamet "
                    . "WHERE idFormatoMedicion IN(" . $inicial . ")";
            
            $db->query($query2);

            $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query1, "borrarFormatoMedicion");
        }
    }
    
    function borrarFormatoMedicion($idResumenJob,$excluidos) {
        global $db;
        $query = "DELETE FROM formato_medicion "
                . "WHERE idResumenJob = " .$idResumenJob . " "
                . "AND id NOT IN(" . $excluidos . ")";

        $db->query($query);
        $this->log($_SESSION['datos_logueo']['login'], "JobOrder", $query, "borrarFormatoMedicion");
    }
    
    function insertarFormatoMedCanal($idFormatosMedicion, $canal) {
        global $db;
        $query = "INSERT INTO formato_medicion_canales"
                . "("
                . "  idFormatoMedicion,"
                . "  idCanal"
                . ")"
                . "VALUES("
                . "'" . $idFormatosMedicion . "',"
                . "'" . $canal . "'"
                . ")";
        
        $db->query($query);
        $idFormatoMedCanal = $db->getInsertID();
        return $idFormatoMedCanal;
    }
    
    function consultarFormatoMedCanal($idFormatosMedicion,$canal) {
        global $db;

        $query = "SELECT fm.* FROM formato_medicion_canales fm "
                . "WHERE fm.idFormatoMedicion = " . $idFormatosMedicion." "
                . "AND fm.idCanal = " . $canal;        
        $db->query($query);
        return $db->fetch();
    }
    
    function borrarFormatoMedCanal($idFormatoMedicion,$excluidos) {
        global $db;
        $query = "DELETE FROM formato_medicion_canales "
                . "WHERE idFormatoMedicion = " . $idFormatoMedicion . " "
                . "AND id NOT IN(" . $excluidos . ")";
        
        $db->query($query);        
    }
    
    function insertarFormatoMedAreaMet($idFormatosMedicion, $areaMet) {
        global $db;
        $query = "INSERT INTO formato_medicion_areamet"
                . "("
                . "  idFormatoMedicion,"
                . "  idAreaMetropolitana"
                . ")"
                . "VALUES("
                . "'" . $idFormatosMedicion . "',"
                . "'" . $areaMet . "'"
                . ")";

        $db->query($query);
        $idFormatoMedAreaMet = $db->getInsertID();
        return $idFormatoMedAreaMet;
    }
    
    function consultarFormatoMedAreaMet($idFormatosMedicion,$areaMet) {
        global $db;

        $query = "SELECT * FROM formato_medicion_areamet fm "
                . "WHERE idFormatoMedicion = " . $idFormatosMedicion." "
                . "AND idAreaMetropolitana = " . $areaMet;

        $db->query($query);
        return $db->fetch();
    }
    
    function borrarFormatoMedAreaMet($idFormatoMedicion,$excluidos) {
        global $db;
        $query = "DELETE FROM formato_medicion_areamet "
                . "WHERE idFormatoMedicion = " . $idFormatoMedicion . " "
                . "AND id NOT IN(" . $excluidos . ")";

        $db->query($query);        
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
    
    function armarListaHerencia($idCliente,$idCategoria){
        global $db;
        
        $query = "SELECT f.id as id, f.ciclo as ciclo, f.anio as anio
                    FROM    meiko.formato_medicion f,
                            meiko.resumen_job r
                    WHERE f.idResumenJob = r.id 
                            AND avance > 10
                            AND r.idCliente = " . $idCliente . "
                            AND f.idCategoria = " . $idCategoria . "
                    ORDER BY f.anio,f.ciclo DESC";        
        
        $db->query($query);
        return $db->getArray();
        
    }
    
    function copiarFormatoMedicion($idFormatoMedicion, $idHerencia){
        global $db;
        
        //formato_medicion_columnas
        $query = "INSERT INTO formato_medicion_columnas(idFormatoMedicion,tabla,orden,valor) "
                . "SELECT '" . $idFormatoMedicion . "',tabla,orden,valor "
                . "FROM formato_medicion_columnas "
                . "WHERE idFormatoMedicion=" . $idHerencia;
        
        $db->query($query);
        
        //formato_medicion_registro
        $query = "INSERT INTO formato_medicion_registro(idFormatoMedicion,tabla,valor,herencia,fila,columna,orden,codigo,codigoCorto) "
                . "SELECT '" . $idFormatoMedicion . "',tabla,valor,herencia,fila,columna,orden,codigo,codigoCorto "
                . "FROM meiko.formato_medicion_registro "                
                . "WHERE idFormatoMedicion=" . $idHerencia;
        
        $db->query($query);
        
        //formato_medicion_var_medicion
        $query = "INSERT INTO formato_medicion_var_medicion(idFormatoMedicion,variableMedicion) "
                . "SELECT '" . $idFormatoMedicion . "',variableMedicion "
                . "FROM meiko.formato_medicion_var_medicion "                
                . "WHERE idFormatoMedicion=" . $idHerencia;
        
        $db->query($query);
        
        //formato_medicion_var_especiales
        $query = "INSERT INTO formato_medicion_var_especiales(idFormatoMedicion,variableEspecial,valor) "
                . "SELECT '" . $idFormatoMedicion . "',variableEspecial,valor "
                . "FROM meiko.formato_medicion_var_especiales "                
                . "WHERE idFormatoMedicion=" . $idHerencia;
        
        $db->query($query);
        
    }
    
    
    function borrarCopiaFormatoMedicion($idFormatoMedicion){
        global $db;
        
        //formato_medicion_columnas
        $query = "DELETE FROM meiko.formato_medicion_columnas "
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion;
        
        $db->query($query);
        
        
        //formato_medicion_registro_variable
        $query = "DELETE FROM meiko. formato_medicion_registro_variable "
                . "WHERE idRegistro IN ( SELECT a.id FROM( "
                . "                         SELECT id FROM meiko.formato_medicion_registro "
                . "                         WHERE idFormatoMedicion =" . $idFormatoMedicion . ") a "
                . "                     )";
        
        $db->query($query);
        
        
        
        //formato_medicion_registro
        $query = "DELETE FROM meiko.formato_medicion_registro "
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion;
        
        $db->query($query);
        
        //formato_medicion_var_medicion
        $query = "DELETE FROM meiko.formato_medicion_var_medicion "
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion;
        
        $db->query($query);
        
        //formato_medicion_var_especiales
        $query = "DELETE FROM formato_medicion_var_especiales "               
                . "WHERE idFormatoMedicion=" . $idFormatoMedicion;
        
        $db->query($query);
        
    }
    
    
    
    
    public function traerFormatoMedicionRegistroCopia($idFormatoMedicion) {
        global $db;

        $query = "SELECT *
                  FROM formato_medicion_registro f
                 WHERE f.idFormatoMedicion='" . $idFormatoMedicion . "'";
        
        $db->query($query);
        return $db->getArray();
    }
    
    public function traerInfoRegistroOrigen($idHerencia,$orden) {
        global $db;

        $query = "SELECT *
                  FROM formato_medicion_registro f
                 WHERE f.idFormatoMedicion='" . $idHerencia . "'"
                . "AND f.orden=" . $orden;
        
        $db->query($query);
        return $db->fetch();
    }
    
    public function traerVarMedicion($idFormatoMedicion,$herencia) {
        global $db;

        $query = "SELECT ori.id as oriId, cop.id as copId
                FROM meiko.formato_medicion_var_medicion ori,
                    meiko.formato_medicion_var_medicion cop
                WHERE ori.variableMedicion = cop.variableMedicion
                      AND ori.idFormatoMedicion = " . $herencia . " 
                      AND cop.idFormatoMedicion = ". $idFormatoMedicion;
        
        $db->query($query);
        return $db->getArray();
    }    
    
    public function copiarRegistroVariable($idRegistroOrigen,$idRegistroCopia,$varMedOri,$varMedCop) {
        global $db;

        $query = "INSERT INTO meiko.formato_medicion_registro_variable(idRegistro,idVariableMedicion,valor) "
                . "SELECT '" . $idRegistroCopia . "','" . $varMedCop . "',valor "
                . "FROM meiko.formato_medicion_registro_variable "                
                . "WHERE idRegistro=" . $idRegistroOrigen . " "
                . "AND idVariableMedicion = " . $varMedOri;
        
        $db->query($query);
        
    }
    
    
    

}

?>