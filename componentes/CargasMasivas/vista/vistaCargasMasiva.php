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

class VistaCargasMasiva {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH . "CargasMasivas/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true, 'cache' => 'false', 'auto_reload' => 'true'));
    }

    public function mostrarCargasMasivas($permisos) {

        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        //echo'<pre>';print_r($arreglo);echo'</pre>';

        $filtro = '';        
        
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a href="javascript:void(0)" onclick="agregarCargasMasivas(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Carga Masiva" />'
                                    . '</a></div></td></tr></table>';
        }

        echo $this->plantilla->render('listadoCargasMasiva.html', array('titulo' => 'RESUMEN CARGA MASIVA', 'idMenu' => $permisos->idMenu,'filtro' => $filtro,'crear'=>$crear));
               
    }

    function agregarCargasMasivas($arreglo) {

        //echo '<pre>';echo print_r($_SESSION);echo '<pre>';
        echo $this->plantilla->render('editarCargasMasiva.html', $arreglo);
    }
    
    function mostrarCarga($arreglo){
      echo $this->plantilla->render('listadoCargasMasiva.html',$arreglo);
    }
}

?>