<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author jorge rincon
 * @package componentes
 * @subpackage Nomina/vista
 */

/**
 * Clase "VistaNominaEtl"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class vistaNomina {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Nomina/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarNomina($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';
        $crear = "";
        if($permisos->crear=="SI"){

            $crear =  '<div class="btnAgre">'
                     
                        . '<a class="btn btn-outline-primary btn-editar" data-toggle="modal" data-target="#miModalAdd" href="index_blank.php?component=Nomina&method=agregarNomina&idMenu=' . $permisos->idMenu .  '" onclick="agregarNomina(0)">
                            <i class="material-icons">settings</i>'
                        . '</a>'                      
                    .'</div>';


        }
      
        echo $this->plantilla->render('listadoNomina.html', array('idMenu' => $permisos->idMenu,'crear'=>$crear,'nombreUsr'=>$permisos->nombreUsr));
        
    }    
    
    function verNomina($mostrarNomina){
        
        echo $this->plantilla->render('verNomina.html', array('titulo'=> 'Nomina', 'user' =>$mostrarNomina));
        
    }    
    
    function agregarNomina($arreglo){
        
        echo $this->plantilla->render('agregarNomina.html', $arreglo);
    }

    function editarNomina($arreglo){
        
        echo $this->plantilla->render('editarNomina.html', $arreglo);
    }
    
}
?>