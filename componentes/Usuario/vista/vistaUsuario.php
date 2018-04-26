<?php
/**
 * Clase Vista del módulo "Bonificacion" en el patrón MVC
 * 
 * @author jorge rincon
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

class VistaUsuario {
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
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Usuario/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }
    
    public function mostrarUsuarios($permisos){        
            
        //echo'<pre>';print_r($permisos);echo'</pre>';
        $crear = "";
        if($permisos->crear=="SI"){

            $crear =  '<div class="btnAgre">'
                     
                        . '<a class="btn btn-outline-primary btn-editar" data-toggle="modal" data-target="#miModalAdd" href="index_blank.php?component=Usuario&method=agregarUsuario&idMenu=' . $permisos->idMenu .  '" onclick="agregarUsuario(0)">
                            <i class="material-icons">person_add</i>'
                        . '</a>'                      
                    .'</div>';


        }
      
        echo $this->plantilla->render('listadoUsuarios.html', array('idMenu' => $permisos->idMenu,'crear'=>$crear,'nombreUsr'=>$permisos->nombreUsr));
        
    }    
    
    function verUsuario($datosUsuario){
        //echo'<pre>';print_r($datosUsuario[0]);echo'</pre>';
        echo $this->plantilla->render('verUsuario.html', array('titulo'=> 'USUARIOS', 'user' =>$datosUsuario));
        
    }    
    
    function agregarUsuario($arreglo){
        
        echo $this->plantilla->render('agregarUsuario.html', $arreglo);
    }

    function editarUsuario($arreglo){
        
        echo $this->plantilla->render('editarUsuario.html', $arreglo);
    }
    
}
?>