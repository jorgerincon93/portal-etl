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

class VistaProductos {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Productos/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarProductos($permisos){        
            
        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        
        
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a class="various fancybox.ajax" href="index_blank.php?component=Productos&method=agregarProductos&idMenu=' . $permisos->idMenu .  '" onclick="agregarProductos(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Producto" />'
                                    . '</a></div></td></tr></table>';
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoProductos.html', array('titulo'=> 'PRODUCTO MAQUINARIA','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function verProductos($arreglo){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verProductos.html', array('titulo'=> 'DETALLE PRODUCTO', 'producto' =>$arreglo[0]));
        
    }    
    
    function agregarProductos($arreglo){
        
        echo $this->plantilla->render('editarProductos.html', $arreglo);
    }
    
}
?>