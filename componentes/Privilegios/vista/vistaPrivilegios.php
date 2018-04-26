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

class VistaPrivilegios {
//extends Exception{
    
	/**
	 * Variable que almacenará un objeto de tipo twig, encargado de seleccionar editar y mostrar las plantillas
	 *
	 * @var plantilla
	 */
    private $plantilla;   
    private $datos;

    
    public function __construct($datos){        
        
        $this->datos = $datos;        
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Privilegios/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarPrivilegios($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a class="various fancybox.ajax" href="index_blank.php?component=Privilegios&method=agregarPrivilegios&idMenu=' . $permisos->idMenu .  '" onclick="agregarPrivilegios(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Privilegio" />'
                                    . '</a></div></td></tr></table>';
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoPrivilegios.html', array('titulo'=> 'ADMINISTRACI&Oacute;N DE PRIVILEGIOS','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function verPrivilegios($datosUsuario){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verPrivilegios.html', array('titulo'=> 'PRIVILEGIOS', 'user' =>$datosUsuario[0]));
        
    }    
    
    function agregarPrivilegios($arreglo){
        
        echo $this->plantilla->render('editarPrivilegios.html', $arreglo);
    }
    
    function editarPrivilegios($arreglo){
        
        echo $this->plantilla->render('editarPrivilegiosEd.html', $arreglo);
    }
    
    function agregarRol($arreglo){
        
        echo $this->plantilla->render('agregarRol.html', $arreglo);
    }
    
}
?>