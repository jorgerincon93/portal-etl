<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author ammonroyc
 * @package componentes
 * @subpackage Usuario/vista
 */

/**
 * Clase "VistaCalidad"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class VistaCalidad {
//extends Exception{
    
	/**
	 * Variable que almacenará un objeto de tipo twig, encargado de seleccionar editar y mostrar las plantillas
	 *
	 * @var plantilla
	 */
    private $plantilla;   
    private $datos;

    
    public function __construct($datos){        
        require_once LIB_PATH.'twig/Autoloader.php';
        $this->datos = $datos;        
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Calidad/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarCalidad($permisos){        
            
        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        
        
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a class="various fancybox.ajax" href="index_blank.php?component=Calidad&method=agregarCalidad&idMenu=' . $permisos->idMenu .  '" onclick="agregarCalidad(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Calidad" />'
                                    . '</a></div></td></tr></table>';
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoCalidad.html', array('titulo'=> 'CALIDAD','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function verCalidad($datosCalidad){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verCalidad.html', array('titulo'=> 'DETALLE CALIDAD', 'calidad' =>$datosCalidad[0]));
        
    }    
    
    function agregarCalidad($arreglo){
        
        echo $this->plantilla->render('editarCalidad.html', $arreglo);
    }
    
}
?>