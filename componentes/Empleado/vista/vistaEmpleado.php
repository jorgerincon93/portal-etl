<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author jorge rincon
 * @package componentes
 * @subpackage Empleado/vista
 */

/**
 * Clase "VistaNominaEtl"
 * 
 * Clase encargada de seleccionar las plantillas (contenido html) y poblarlas con la información que corresponda 
 * para luego mostrarlas al usuario de acuerdo a la petición realizada.
 */
//require_once CLASSES_PATH . 'ConstruirXML.php';

class vistaEmpleado {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Empleado/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarEmpleado($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';
        $crear = "";
        if($permisos->crear=="SI"){

            $crear =  '<div class="btnAgre">'
                     
                        . '<a class="btn btn-outline-primary btn-editar" data-toggle="modal" data-target="#miModalAdd" href="index_blank.php?component=Empleado&method=agregarEmpleado&idMenu=' . $permisos->idMenu .  '" onclick="agregarEmpleado(0)">
                            <i class="material-icons">person_add</i>'
                        . '</a>'                      
                    .'</div>';


        }
      
        echo $this->plantilla->render('listadoEmpleado.html', array('idMenu' => $permisos->idMenu,'crear'=>$crear,'nombreUsr'=>$permisos->nombreUsr));
        
    }    
    
    function verEmpleado($mostrarEmpleado){
        
        echo $this->plantilla->render('verEmpleado.html', array('titulo'=> 'Empleado', 'user' =>$mostrarEmpleado));
        
    }    
    
    function agregarEmpleado($arreglo){
        
        echo $this->plantilla->render('agregarEmpleado.html', $arreglo);
    }

    function editarEmpleado($arreglo){
        
        echo $this->plantilla->render('editarEmpleado.html', $arreglo);
    }
    
}
?>