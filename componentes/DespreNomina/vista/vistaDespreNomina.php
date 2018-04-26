<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author jorge rincon
 * @package componentes
 * @subpackage DespreNomina/vista
 */

/**
 * Clase "VistaNominaEtl"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class vistaDespreNomina {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."DespreNomina/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarAdmLab($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';
        $crear = "";
        if($permisos->crear=="SI"){

            $crear =  '<div class="btnAgre">'
                     
                        . '<a class="btn btn-outline-primary btn-editar" data-toggle="modal" data-target="#miModalAdd" href="index_blank.php?component=DespreNomina&method=agregarDespreNomina&idMenu=' . $permisos->idMenu .  '" onclick="agregarDespreNomina(0)">
                            <i class="material-icons">settings</i>'
                        . '</a>'                      
                    .'</div>';


        }
      
        echo $this->plantilla->render('listadoDespreNomina.html', array('idMenu' => $permisos->idMenu,'crear'=>$crear,'nombreUsr'=>$permisos->nombreUsr));
        
    }    
    
    function verDespreNomina($mostrarDespreNomina){
        
        echo $this->plantilla->render('verDespreNomina.html', array('titulo'=> 'DespreNomina', 'user' =>$mostrarDespreNomina));
        
    }    
    
    function agregarDespreNomina($arreglo){
        
        echo $this->plantilla->render('agregarDespreNomina.html', $arreglo);
    }

    function editarDespreNomina($arreglo){
        
        echo $this->plantilla->render('editarDespreNomina.html', $arreglo);
    }
    
}
?>