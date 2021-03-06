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

class VistaClientes {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Clientes/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarClientes($permisos){        
            
        //echo'<pre>';print_r($arreglo);echo'</pre>';            
        
        
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a class="various fancybox.ajax" href="index_blank.php?component=Clientes&method=agregarCliente&idMenu=' . $permisos->idMenu .  '" onclick="agregarCliente(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Cliente" />'
                                    . '</a></div></td></tr></table>';
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoClientes.html', array('titulo'=> 'CLIENTES','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function verCliente($datosCliente){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verCliente.html', array('titulo'=> 'DETALLE CLIENTE', 'cliente' =>$datosCliente[0]));
        
    }    
    
    function agregarCliente($arreglo){
        
        echo $this->plantilla->render('editarCliente.html', $arreglo);
    }
    
}
?>