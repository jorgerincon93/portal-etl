<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Call/vista/vistaCall.php';
include_once COMPONENTS_PATH . 'Call/modelo/datosCall.php';


class Call{
    /**
     * Variable que almacena un objeto de tipo VistaUsuario.
     *
     * @var vista
     */
    private $vista;

    /**
     * Variable que almacena un objeto de tipo DatosUsuario.
     *
     * @var datos
     */
    private $datos;

    public function __construct() {
        $this->datos = new DatosCall();
        $this->vista = new VistaCall($this->datos);
    }
    
    public function mostrarCall($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
//        echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista-> mostrarCall($permisos);    	
    }
    
    function verCall($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        /* @var $listaCall type */
        $listaCall=$this->datos->mostrarCall($arreglo);
       
	$this->vista->verCall($listaCall);
    }
    
    function agregarCall($arreglo){        

        $arreglo["opcion"] = "agregar";
     
        $arreglo['titulo_tabla'] = "AGREGAR CALL";        
	$this->vista->agregarCall($arreglo);
    }
    
    function editarCall($arreglo){        
	
        $arreglo['datosCall'] = $this->datos->datosCall($arreglo);
        
        $arreglo['registroCall'] = $this->datos->traerRegistroCall($arreglo['datosCall']->idRegistroEncuesta);
        
        foreach($arreglo['registroCall'] as $keyResCall => $rowResCall){
            
          $TelefonoFijo = $rowResCall["TelefonoFijo"];
          $arreglo['datosCall']->telefonoFijo = $TelefonoFijo;
          
          $Celular = $rowResCall["Celular"];
          $arreglo['datosCall']->celular = $Celular;
          
        }
        
        $arreglo['datosCall']->idModificador = $_SESSION['datos_logueo']['idUsuario'];
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR CALL";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarCall($arreglo);
        
    }        
    
    function guardarCall($arreglo){
        
//        echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarCall($arreglo);
            $this->datos->actualizarRegistroCall($arreglo);
        }
	$this->mostrarCall($arreglo);
    }
   
    function ajaxListaCall($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(id) as totalrows FROM calidad.cal_resultado_registro cal where res_call is not null",              
                "selectSQL" => "SELECT   cal.id,cal.idRegistroEncuesta,cal.res_call,cal.idUsuarioModificador,cal.fechaModificacion FROM calidad.cal_resultado_registro cal where cal.res_call is not null",
                "page_num" => $arreglo['page_num'],
                "rows_per_page" => $arreglo['rows_per_page'],
                "columns" => $arreglo['columns'],
                "sorting" =>  isset($arreglo['sorting']) ? $arreglo['sorting'] : array(),
                "filter_rules" => isset($arreglo['filter_rules']) ? $arreglo['filter_rules'] : array()
        );

        $jfr = new jui_filter_rules($ds);
        $arreglo['debug_mode'] = isset($arreglo['debug_mode'])? $arreglo|['debug_mode'] : "yes";

        $jdg = new bs_grid($ds, $jfr, $page_settings, true);

        $data = $jdg->get_page_data();
        //echo'<pre>';;echo'</pre>';
              
        foreach($data['page_data'] as $key => $row) {
   
          if(isset($row['idUsuarioModificador'])){
              $usuarioNombre = $this->datos->retornarNombreUsuarioCall($row['idUsuarioModificador']);
              $data['page_data'][$key]['idUsuarioModificador'] = $usuarioNombre->nombre;
            }else{
             $row['idUsuarioModificador'] = ""; 
          }
            
            $editar = "";
            $eliminar = "";
            
            if($permisos->editar =='SI'){
                
               $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Call&method=editarCall&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Call\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
              }
              
            $data['page_data'][$key]['acciones'] = $editar ." ". $eliminar;
        }
    
        echo json_encode($data);        
    }
    
    function ajaxListaTipos($arreglo){
        
        $tipos = $this->datos->listaTipos();
        
        $v_cont=0;
        $listaTipos ="[";
        foreach ($tipos as $key => $value) {
            if($v_cont==0){
                $listaTipos = $listaTipos . '{"lk_option":"' . $tipos[$key]["tipo"] . '","lk_value":"' . $tipos[$key]["tipo"] . '"}';
                $v_cont++;
            }else{            
                $listaTipos = $listaTipos . ',{"lk_option":"' . $tipos[$key]["tipo"] . '","lk_value":"' . $tipos[$key]["tipo"] . '"}';
            }            
        }
        $listaTipos = $listaTipos . "]";
        
        echo $listaTipos;
    }    
        
}

?>


