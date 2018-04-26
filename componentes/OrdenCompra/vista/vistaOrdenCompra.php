<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author jarz
 * @package componentes
 */

/**
 * Clase "VistaUsuario"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class VistaOrdenCompra{
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."OrdenCompra/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
public function mostrarOrdenCompra($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';            
        
        
        /*$crear = "";
        if($permisos->crear=="SI"){            
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a href="javascript:void(0)" onclick="agregarOfertaEconomica(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Crear Oferta" />'
                                    . '</a></div></td></tr></table>';
        }*/
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoOrdenCompra.html', array('titulo'=> 'ORDEN COMPRA','idMenu' => $permisos->idMenu));
    }    
    
    function verOrdenCompra($listaOrdenCompra){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verOrdenCompra.html',$listaOrdenCompra);
        
    }    
    
    function agregarOrdenCompra($arreglo){
        
        echo $this->plantilla->render('editarOrdenCompra.html', $arreglo);
    }
    
}
?>