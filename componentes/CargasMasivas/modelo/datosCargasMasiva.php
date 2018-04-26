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
require_once(CLASSES_PATH . 'BDControlador.php');

/**
 * Clase "DatosUsuario"
 * 
 * Clase encargada de manejar las peticiones a la base de datos (CRUD: create, read, update, delete) y retornar
 * los resultados a la vista o al controlador dependiendo el caso.
 *
 */
class DatosCargasMasiva extends BDControlador {

    /**
     * Constructor de la clase "DatosBonificacion"
     * 
     * parent :: Manejador_BD(): permite referirnos a un m�todo de la clase Manejador_BD en cualquier momento
     * de ser necesario.
     */
    public function __construct() {
        //parent :: Manejador_BD();
    }

    public function selectCargasMasiva($id) {
        global $db;

        $query = "SELECT  r.*
                FROM    mundolimpieza.logcargamasiva r
                WHERE r.id = $id";

        $db->query($query);
        return $db->fetch();
}
    
    function datosUsuario($idUsuario) {
        global $db;
        $query = "SELECT us.id,us.nombreUsuario FROM usuario us WHERE us.id = $idUsuario";        
        $db->query($query);
        return $db->fetch();
    }
    
    function retornarNombreCargasMasivas($idUsuarioCarga) {
        global $db;
        $query = "SELECT u.nombreUsuario FROM usuario u WHERE id = $idUsuarioCarga";        
        $db->query($query);
        return $db->fetch();
    }
       
    function insertarLogCargaMasiva($arreglo) {
        global $db;
        $query = "INSERT INTO mundolimpieza.logcargamasiva"
                . "("
                . "  tipoCarga,"
                . "  nombreArchivo,"
                . "  tamanoArchivo,"
                . "  fechaCarga,"
                . "  idUsuarioCarga,"
                . "  estado,"
                . "  fechaProceso"
                . ")"
                . "VALUES("
                . "'" . $arreglo["tipoCargue"] . "',"
                . "'" . $arreglo["nombreArchivo"] . "',"
                . "'" . $arreglo["tamanoArchivo"] . "',"
                . "now(),"
                . "'" . $arreglo["idUsuario"] . "'," 
                . "'Pendiente',"
                . "now()"
                . ")";

        $db->query($query);
        $idRegla = $db->getInsertID();
        $this->log($_SESSION['datos_logueo']['login'], "CargasMasvias", $query, "insertarLogCargaMasiva");
        return $idRegla;
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
    

}

?>