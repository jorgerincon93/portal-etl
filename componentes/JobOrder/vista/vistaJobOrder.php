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

class VistaJobOrder {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH . "JobOrder/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true, 'cache' => 'false', 'auto_reload' => 'true'));
    }

    public function mostrarJobOrder($permisos) {

        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        //echo'<pre>';print_r($permisos);echo'</pre>';

        $filtro = '';
        if (isset($permisos->idOrdenCompra)) {            
            $filtro = ',filter_rules: [
                {
                    "condition": {
                        "filterType": "number",
                        "field": "idOrdenCompra",
                        "operator": "equal",
                        "filterValue": [
                            "' . $permisos->idOrdenCompra . '"
                        ]
                    }
                }                
            ]';
        }
        
        $crear = "";
        if($permisos->crear=="SI"){            
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a href="javascript:void(0)" onclick="agregarJobOrder(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Crear Resumen" />'
                                    . '</a></div></td></tr></table>';
        }

        echo $this->plantilla->render('listadoJobOrder.html', array('titulo' => 'RESUMEN JOB ORDER', 'idMenu' => $permisos->idMenu,'filtro' => $filtro,'crear'=>$crear));
    }

    function verFormatoMedicion($idResumenJob){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verFormatoMedicion.html',array('idResumenJob'=> $idResumenJob));
        
    }

    function agregarJobOrder($arreglo) {

        //echo '<pre>';echo print_r($_SESSION);echo '<pre>';
        echo $this->plantilla->render('editarJobOrder.html', $arreglo);
    }
    
    function verJobOrder($datosResumenJob){
        //echo'<pre>';print_r($datosResumenJob);echo'</pre>';
        echo $this->plantilla->render('verResumenJob.html', $datosResumenJob);
    }
    
}

?>