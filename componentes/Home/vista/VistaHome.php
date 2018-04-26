<?php
/**
 * Description of VistaHome
 *
 * @author jorge rincon
 */

class VistaHome{
    
    private $plantilla;
    private $datosHome;

    public function __construct($datos){        
        $this->datosHome = $datos;
        $loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Home/vista/tpl/");
        $this->plantilla = new Twig_Environment($loader, array('debug' => true,'cache' => 'false','auto_reload' => 'true'));
    }

    public function mostrarVistaLogin(){
        echo $this->plantilla->render('plantillaLogueo.html');
        //$this->plantilla->loadTemplateFile( COMPONENTS_PATH ."Home/vista/tmpl/plantillaLogueo.php");
        //$this->plantilla->setVariable("COMODIN", "");
        //$this->plantilla->show();
    }
    
    public function crearHeaderAplicacion($infoUsuario){
        //$tmpl = new HTML_Template_IT();
        //$tmpl->loadTemplateFile( COMPONENTS_PATH ."Home/vista/tmpl/plantillaHeader.php");
        //loader = new Twig_Loader_Filesystem(COMPONENTS_PATH ."Home/vista/tpl/");
        //$tmpl->setVariable("COMODIN", "");
        $nombreUsuario = isset($infoUsuario->nombreUsuario)?$infoUsuario->nombreUsuario:"";
        //$tmpl->setVariable("nombre_usuario", strtolower($nombreUsuario));
        return $this->plantilla->render('plantillaHeader.html',array('nombre_usuario' => strtolower($nombreUsuario)));
    }
//    
   
    
    public function mostrarContenidoAplicacion($menu){
        
       
//      $tmplC = new HTML_Template_IT();
//        $tmplC->loadTemplateFile( COMPONENTS_PATH ."Home/vista/tmpl/plantillaContenido.php");
//        $tmplC->setVariable("COMODIN", "");
//        $tmplC->setVariable("menu_general", $menu);
//        $tmplC->setVariable("contenido_home", $this->armarContenidoHome());
        
        
        
        $arreglo_pantalla["COMODIN"]="";
        $arreglo_pantalla["menu_general"]=$menu;
         
        
        
        $arreglo_pantalla["contenido_home"]="";
        
          return $this->plantilla->render('plantillaContenido.html',$arreglo_pantalla);
         
    }
    
    
    public function crearFooterAplicacion(){        
        return $this->plantilla->render('plantillaFooter.html');
        //return $this->plantilla->get();
    }
    
    public function mostrarAlerta(){        
        return $this->plantilla->render('alerta.html');
        //return $this->plantilla->get();
    }
//    
    public function mostrarVistaAplicacion($arreglo){
        //$this->plantilla->loadTemplateFile( COMPONENTS_PATH ."Home/vista/tmpl/plantillaAplicacion.php");
        //$this->plantilla->setVariable("COMODIN", "");
        //$this->plantilla->setVariable("plantilla_header", $header);
        //$this->plantilla->setVariable("plantilla_contenido", $contenido);
        //$this->plantilla->setVariable("plantilla_footer", $footer);
        //$this->plantilla->show();
        
       echo $this->plantilla->render('plantillaAplicacion.html',array('datos' => $arreglo));
        
    }
//    
    public function mostrarPlantillaMenus($menuPrincipal){
        //$tmpl_menu = new HTML_Template_IT();
        //$tmpl_menu->loadTemplateFile( COMPONENTS_PATH ."Home/vista/tmpl/plantillaMenu.php");
        //$tmpl_menu->setVariable("COMODIN", "");
        //$tmpl_menu->setVariable("menu_principal", $this->mostrarMenuPrincipal($menuPrincipal));
        //echo $menuPrincipal;
        return $this->plantilla->render('plantillaMenu.html',array('lista_menu' => $menuPrincipal));
    }
    
}
?>
