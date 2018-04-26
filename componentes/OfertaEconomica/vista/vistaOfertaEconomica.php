<?php
/**
 * Clase Vista del módulo "Oferta Economica" en el patrón MVC
 * 
 * @author jarz
 * @package componentes
 * 
 **/


class VistaOfertaEconomica {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."OfertaEconomica/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarOfertaEconomica($permisos){        
            
        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        
        
        $crear = "";
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
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoOfertaEconomica.html', array('titulo'=> 'OFERTA COMERCIAL','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function verOfertaEconomica($listaOfertaEconomica){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verOfertaEconomica.html', array('titulo'=> 'DETALLE OFERTA ECONOMICA', 'OfertaEconomica' =>$listaOfertaEconomica[0]));
        
    }    
    
    function agregarOfertaEconomica($arreglo){
        
        echo $this->plantilla->render('editarOfertaEconomica.html', $arreglo);
    }
    
    function verCantidad($cantidad){       
          
        echo $this->plantilla->render('verCantidad.html',$cantidad);
        
    }
    
    function crearOrdenCompra($arreglo){       
          
        echo $this->plantilla->render('crearOrdenCompra.html',$arreglo);
        
    }
    
    function crearEvento($arreglo){
        
        echo $this->plantilla->render('crearEvento.html',$arreglo);
    }
    
}
?>