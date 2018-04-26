<?php
/**
 * Description of Home
 *
 * @author jarz
 */
require_once COMPONENTS_PATH . 'Home/vista/VistaHome.php';
require_once COMPONENTS_PATH . 'Home/modelo/DatosHome.php';

class Home{
    
    private $vistaHome;
    private $datos;

    public function __construct(){
        $this->datos = new DatosHome();
        $this->vistaHome = new VistaHome($this->datos);
    }
    
    public function mostrarLogueo(){
        //echo "ENTRA APLICACION";
        $this->vistaHome->mostrarVistaLogin();
    }
    
    public function mostrarAplicacion(){
 
        $arreglo["idMenu"] = 1;
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        
        $datosUsuario = $this->datos->retornarDatosUsuario($_SESSION['datos_logueo']['idUsuario']);
        $arreglo["nombreUsuario"] = $datosUsuario->nombreUsuario;
        $arreglo["menu"] = $this->traerMenuPadre($_SESSION['datos_logueo']['idUsuario']);
        
        foreach ($arreglo["menu"] as $key => $valueMenu) {
             //foreach ($valueMenu as $key => $value) {
                 $arreglo["menuHijo"] = $this->menuHijo($valueMenu["idPadre"],$_SESSION['datos_logueo']['idUsuario']);
             //}
        
        }
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        /*$header = $this->armarHeader();
        
        //$contenido = "";
        $footer = $this->armarFooter();*/
        
        //echo "ENTRA APLICACION";
        //echo "<pre>";
        //print_r($header);
        //print_r($footer);
        //echo "</pre>";

        $this->vistaHome->mostrarVistaAplicacion($arreglo);
    }    
    
    public function armarHeader(){
        $datosUsuario = $this->datos->retornarDatosUsuario($_SESSION['datos_logueo']['idUsuario']);
        return $this->vistaHome->crearHeaderAplicacion($datosUsuario);
    }
    
    /*public function mostrarContenidoInicial(){      
        
        $menu = $this->mostrarPlantillaMenus($_SESSION['datos_logueo']['idUsuario']);
                
        return $this->vistaHome->mostrarContenidoAplicacion($menu);
    }*/
    
    public function armarFooter(){
        return $this->vistaHome->crearFooterAplicacion();
    }
    
    public function traerMenuPadre($idUsuario){
        
        $menuPrincipal = $this->datos->selectMenu($idUsuario);
       
        
        $listaMenu="";
        
        foreach($menuPrincipal as $key => $value){
            
            //onclick="javascript:inicio('Secundario')"
            $listaMenu = $listaMenu . '<li><a ' . (isset($menuPrincipal[$key]['url'])?'onclick="javascript:'.$menuPrincipal[$key]['url'].'"'  : '') . ' data-toggle="collapse" data-target="#dashboard" class="collapsed active"> <i class="fa fa-th-large"></i> <span class="nav-label">'. $menuPrincipal[$key]['nombre'] .'</span> <span class="fa fa-chevron-left pull-right"></span></a></li>';            
            
            
            $arreglo["listaMenu"]["idPadre"] = $menuPrincipal[$key]['id'];
            $arreglo["listaMenu"]["menuPadre"] = $listaMenu;
        }
        
        
       return $arreglo;
        
    }

function menuHijo($idPadre,$idUsuario) {
        
        $menuHijo="";
        $arregloHijo = null;
        $arregloHijo = $this->datos->selectMenuHijo($idPadre,$idUsuario);
        
    if (isset($arregloHijo[0])){      

            
              foreach($arregloHijo as $key => $value){

                if($value["url"] != null) { 
                 $menuHijo= $menuHijo . '<li class="active">';   
                 $menuHijo = $menuHijo . '<a href="#" ' . (isset($arregloHijo[$key]['url'])?'onclick="javascript:'.$arregloHijo[$key]['url'].'"'  : '') . '>' . $arregloHijo[$key]['nombre'] . '</a>';           
                  
                
              }else{
                   
                       $menuHijo = $menuHijo . $this->menuHijoSub($arregloHijo[$key]['id'],$idUsuario,$value["nombreId"],$value["nombre"]);              

              }  
                
            }
     $menuHijo= $menuHijo .'</li>';
    }        
        
      return $menuHijo;
       
    }
    
   function menuHijoSub($idPadre,$idUsuario,$nombreId,$nombre){

        $subMenuHijo = '';
        $subMenuHi = '';
        $arregloSubHijo = $this->datos->selectSubMenuHijo($idPadre,$idUsuario);

    $subMenuHijo = $subMenuHijo . '<li><a data-toggle="collapse" data-target="#'.$nombreId.'" class="active" aria-expanded="true"> <i class="fa fa-th-large"></i> <span class="nav-label">'. $nombre .'</span> <span class="fa fa-chevron-left pull-right"></span></a><ul  class="sub-menu collapse" id="'.$nombreId.'" >'; 

        foreach ($arregloSubHijo as $key => $valueSubHijo){


          $subMenuHi = $subMenuHi . '<li class="active"> <a href="#" ' . (isset($arregloSubHijo[$key]['url'])?'onclick="javascript:'.$arregloSubHijo[$key]['url'].'"'  : '') . '>' . $arregloSubHijo[$key]['nombre'] . '</a></li>';   

        }

            $subMenuHijo .= $subMenuHi . '</ul></li>';
    
        return $subMenuHijo;
   }
}
?>
