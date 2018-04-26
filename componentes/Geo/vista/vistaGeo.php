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

class VistaGeo {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Geo/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarGeo($permisos){        
            
        //echo'<pre>';print_r($arreglo);echo'</pre>';                
        $crear = "";
        if($permisos->crear=="SI"){
            $crear =   '<table align="center" '
                                    . "border='0' "
                                    . 'width="100%" cellpadding="0" cellspacing="0"> '
                                    . '<tr height="40px"> '
                                    . '<td align="right"> '
                                    . '<div class="popups"> '
                                    . '<a class="various fancybox.ajax" href="index_blank.php?component=Geo&method=agregarGeo&idMenu=' . $permisos->idMenu .  '" onclick="agregarGeo(0)">'
                                    . '<input type="button" class="botonGeneralGrande" value="Agregar Geo" />'
                                    . '</a></div></td></tr></table>';
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        echo $this->plantilla->render('listadoGeo.html', array('titulo'=> 'GEO MASTER','idMenu' => $permisos->idMenu, 'crear'=>$crear));
    }    
    
    function editarMicrozona($arreglo){
        
        echo $this->plantilla->render('editarMicrozona.html', $arreglo);
    }
    
    function verGeo($datosGeo){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verGeo.html', array('titulo'=> 'DETALLE GEO', 'cal_resultado_registro' =>$datosGeo[0]));
        
    }    
    
    function agregarGeo($arreglo){
        
        echo $this->plantilla->render('editarGeo.html', $arreglo);
    }
    
    public function agregarAreaMetro($arreglo){       
           
        echo $this->plantilla->render('agregarAreaMetropol.html',$arreglo);
    }
    
    public function agregarCiudad($arreglo){       
           
        echo $this->plantilla->render('agregarCiudad.html',$arreglo);
    }
    
    public function agregarMunicipio($arreglo){       
           
        echo $this->plantilla->render('agregarMunicipio.html',$arreglo);
    }
    
    public function agregarPais($arreglo){       
           
        echo $this->plantilla->render('agregarPais.html',$arreglo);
    }
    
    public function agregarDepto($arreglo){        
        
      echo $this->plantilla->render('agregarDepto.html',$arreglo);
      
    }
    
    public function agregarLocalidad($arreglo){
        
      echo $this->plantilla->render('agregarLocalidad.html',$arreglo);
      
    }
    
    public function agregarSubLocalidad($arreglo){
        
      echo $this->plantilla->render('agregarSubLocalidad.html',$arreglo);
      
    }
    
    
}
?>