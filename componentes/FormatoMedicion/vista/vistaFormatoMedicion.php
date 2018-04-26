<?php

/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author ammonroyc
 * @package componentes
 * @subpackage Usuario/vista
 */

/**
 * Clase "VistaUsuario"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class VistaFormatoMedicion {
//extends Exception{

    /**
     * Variable que almacenará un objeto de tipo twig, encargado de seleccionar editar y mostrar las plantillas
     *
     * @var plantilla
     */
    private $plantilla;
    private $datos;

    public function __construct($datos) {

        $this->datos = $datos;
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH . "FormatoMedicion/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true, 'cache' => 'false', 'auto_reload' => 'true'));
    }

    public function mostrarJobOrder($permisos) {

        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        //echo'<pre>';print_r($arreglo);echo'</pre>';

        $filtro = '';
        $idResumenJob = "0";
        if (isset($permisos->idResumenJob)) {            
            $filtro = ',filter_rules: [
                {
                    "condition": {
                        "filterType": "number",
                        "field": "idResumenJob",
                        "operator": "equal",
                        "filterValue": [
                            "' . $permisos->idResumenJob . '"
                        ]
                    }
                }                
            ]';
        }
        
        $crear = "";
//        if($permisos->crear=="SI"){
//            $crear =   '<table align="center" '
//                                    . "border='0' "
//                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
//                                    . '<tr height="40px"> '
//                                    . '<td align="right"> '
//                                    . '<div class="popups"> '
//                                    . '<a href="javascript:void(0)" onclick="agregarJobOrder(0)">'
//                                    . '<input type="button" class="botonGeneralGrande" value="Formato Medicion" />'
//                                    . '</a></div></td></tr></table>';
//        }

        echo $this->plantilla->render('listadoFormatoMedicion.html', array('titulo' => 'FORMATO MEDICION JOB ORDER', 'idMenu' => $permisos->idMenu,'filtro' => $filtro,'crear'=>$crear,'idResumenJob'=>$idResumenJob));
    }

    function verJobOrder($datosJobOrder) {
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verJobOrder.html', array('titulo' => 'DETALLE ORDEN COMPRA', 'cliente' => $datosJobOrder[0]));
    }

    function agregarJobOrder($arreglo) {

        //echo '<pre>';echo print_r($_SESSION);echo '<pre>';
        echo $this->plantilla->render('editarFormatoMedicion.html', $arreglo);
    }
    
    function aprobarFormatoMedicion($arreglo) {

        //echo '<pre>';echo print_r($_SESSION);echo '<pre>';
        echo $this->plantilla->render('aprobarFormatoMedicion.html', $arreglo);
    }
    
    function aprobarFormatoMedicionItem($arreglo) {

        //echo '<pre>';echo print_r($_SESSION);echo '<pre>';
        echo $this->plantilla->render('aprobarFormatoMedicionItem.html', $arreglo);
    }
    
    function verHistorialAprobacion($historialAprobacion){
        //echo'<pre>';print_r($historialAprobacion);echo'</pre>';
        echo $this->plantilla->render('historialAprobacionFormatoMedicion.html', $historialAprobacion);
    }
}

?>