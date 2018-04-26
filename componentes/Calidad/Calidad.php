<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once LIB_PATH.'twig/Autoloader.php';

require_once COMPONENTS_PATH . 'Calidad/vista/vistaCalidad.php';
include_once COMPONENTS_PATH . 'Calidad/modelo/datosCalidad.php';


class Calidad{
    /**
     * Variable que almacena un objeto de tipo vistaCalidad.
     *
     * @var vista
     */
    private $vista;

    /**
     * Variable que almacena un objeto de tipo datosCalidad.
     *
     * @var datos
     */
    private $datos;

    public function __construct() {
        $this->datos = new datosCalidad();
        $this->vista = new vistaCalidad($this->datos);
    }
    
    public function mostrarCalidad($arreglo){
    	/** 
    	 * Muestra calidad del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarCalidad($permisos);    	
    }
    
    function verCalidad($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$listaCalidad=$this->datos->mostrarCalidad($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
	$this->vista->verCalidad($listaCalidad);
    }
    
    function agregarCalidad($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        
        $lista_estado = $this->datos->build_list('listavalor','valor','nombre', "WHERE tipo='EstadoCalidad' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
                
        $arreglo['titulo_tabla'] = "NUEVO CALIDAD";        
	$this->vista->agregarCalidad($arreglo);
    }
    
    function editarCalidad($arreglo){        
	
        $arreglo['datosCalidad']=$this->datos->datosCalidad($arreglo);
        
        $lista_estado = $this->datos->build_list('listavalor','valor','nombre', "WHERE tipo='EstadoCalidad' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',isset($arreglo['datosCalidad']->estado)?$arreglo['datosCalidad']->estado:"");        
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR CALIDAD " . strtoupper($arreglo['datosCalidad']->geo);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->editarCalidad($arreglo);
    }        
   
    function guardarCalidad($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarCalidad($arreglo);
	}
	else{            
            $this->datos->insertarCalidad($arreglo);            
	}
        
	$this->mostrarCalidad($arreglo);
    }    
    
    function eliminarCalidad($arreglo){       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->inactivarCalidad($arreglo["id"]);
        $this->eliminarCalidad($arreglo);
    }        
    
    function ajaxListaCalidad($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(ca.idCalidad) as totalrows FROM calidad ca ",                                 // CONFIGURE
                "selectSQL" => "SELECT  ca.idCalidad,ca.geo,ca.callCenter,ca.pendiente,ca.limpieza,ca.estado FROM calidad ca",// CONFIGURE
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
    
        // data conversions (if necessary)
        //$data['page_data'][0]['idUsuario'] = str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
        foreach($data['page_data'] as $key => $row) {
    
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            $data['page_data'][$key]['geo'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Calidad&method=verCalidad&id={$row['id']}\" >{$row['geo']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            if($permisos->editar=="SI"){
                $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Calidad&method=editarCalidad&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Calidad\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }        
            
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


