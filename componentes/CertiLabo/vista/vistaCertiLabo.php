<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author Jorge Rincon
 * @package componentes
 * @subpackage CertiLabo/vista
 */

/**
 * Clase "VistaUsuario"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class VistaCertiLabo {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."CertiLabo/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarCertiLabo($permisos){        
            
        if($permisos->crear=="SI"){
            
           echo $this->plantilla->render('certiLaboral.html', array('generar' => $permisos->certificadoLab,'idMenu' => $permisos->idMenu));
        }
    }    
    
    function generarCetiLabPdf($arreglo){
        
        echo $this->plantilla->render('generarCetiLabPdf.html',array('datosEmpleado' => $arreglo ));
    }
     function generarCetiLabSuelPdf($arreglo){
        
        echo $this->plantilla->render('generarCetiLabSuelPdf.html',array('datosEmpleado' => $arreglo ));
    }
    
    function generarDesprenPdf($arreglo){
        
        echo $this->plantilla->render('generarDesprenPdf.html',array('datosEmpleado' => $arreglo["datosEmpleado"],'datosEnca'=>$arreglo["datosEnca"],'datosCertIngre'=>$arreglo["datosCertIngre"],'datosCertEgre'=>$arreglo["datosCertEgre"],'totales'=>$arreglo["totales"] ));
    }

    function verCertiLabo($datosCertiLabo){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verCertiLabo.html', array('titulo'=> 'DETALLE CertiLabo', 'cal_resultado_registro' =>$datosCertiLabo[0]));
        
    }    
    
    function agregarCertiLabo($arreglo){
        
        echo $this->plantilla->render('editarCertiLabo.html', $arreglo);
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