<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Aplicaciones/vista/vistaAplicaciones.php';
include_once COMPONENTS_PATH . 'Aplicaciones/modelo/datosAplicaciones.php';


class Aplicaciones{
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
        $this->datos = new DatosAplicaciones();
        $this->vista = new VistaAplicaciones($this->datos);
    }
    
    public function mostrarAplicaciones($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
//        echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarAplicaciones($permisos);    	
    }
    
    function verAplicaciones($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$listaAplicaciones=$this->datos->mostrarAplicaciones($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
	$this->vista->verAplicaciones($listaAplicaciones);
    }
    
    function agregarAplicaciones($arreglo){        
	
        $lista_estado = $this->datos->build_list('listavalor','valor','nombre', "WHERE tipo='EstadoAplicaciones' ORDER BY valor ");
        $arreglo['select_estado_Apli'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...');
             
        $lista_anios = $this->retornarAnios(10);
        $arreglo['select_anio'] = $this->datos->armSelect($lista_anios, 'Seleccione Año...');
        
        $lista_ciclo = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Ciclo' ORDER BY valor ");
        $arreglo['select_ciclo'] = $this->datos->armSelect($lista_ciclo, 'Seleccione Ciclo...');
        
        $arreglo["opcion"] = "agregar";
        
        //$lista_estado = $this->datos->build_list('descripcion','codigoAplicacion','estado','anio','ciclo', "WHERE tipo='estado' ORDER BY valor ");
    	//$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
                
        $arreglo['titulo_tabla'] = "AGREGAR APLICACION";        
	$this->vista->agregarAplicaciones($arreglo);
    }
    
    function editarAplicaciones($arreglo){        
	
      $arreglo['datosAplicaciones'] = $this->datos->datosAplicaciones($arreglo);
        
        $lista_estado = $this->datos->build_list('listavalor','valor','nombre', "WHERE tipo='EstadoAplicaciones' ORDER BY valor ");
        $arreglo['select_estado_Apli'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...',isset($arreglo['datosAplicaciones']->estado)?$arreglo['datosAplicaciones']->estado:"");
       
        $lista_anios = $this->retornarAnios(10);
        $arreglo['select_anio'] = $this->datos->armSelect($lista_anios, 'Seleccione Año...',isset($arreglo['datosAplicaciones']->anio)?$arreglo['datosAplicaciones']->anio:"");
        
        $lista_ciclo = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Ciclo' ORDER BY valor ");
        $arreglo['select_ciclo'] = $this->datos->armSelect($lista_ciclo, 'Seleccione Ciclo...',isset($arreglo['datosAplicaciones']->ciclo)?$arreglo['datosAplicaciones']->ciclo:"");
                  
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR APLICACION";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarAplicaciones($arreglo);
        
    }        
    
    function guardarAplicaciones($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarAplicaciones($arreglo);
	}
	else{            
            $this->datos->insertarAplicaciones($arreglo);            
	}
        
	$this->mostrarAplicaciones($arreglo);
    }

function retornarAnios($cantidad = 10) {
        $anioActual = date('Y');
        $listaAnios = array();
        $valorAnio = $anioActual - (round($cantidad / 2));
        for ($i = 0; $i <= $cantidad; $i++) {

            $listaAnios[$valorAnio] = $valorAnio;
            $valorAnio ++;
        }
        return $listaAnios;
    }    
    
    function inactivarAplicaciones($arreglo){  
      
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->inactivarAplicaciones($arreglo["id"]);
        $this->mostrarAplicaciones($arreglo);
    }        
    
    function ajaxListaAplicaciones($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(a.id) as totalrows FROM ext_aplicaciones a ",              
                "selectSQL" => "SELECT  id,descripcion,codigoAplicacion,estado,anio,ciclo FROM ext_aplicaciones a ",
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
    
            $editar = "";
            $eliminar = "";
            
            if($permisos->editar =='SI'){
                
               $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Aplicaciones&method=editarAplicaciones&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Aplicacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
              }        
            if($permisos->eliminar=='SI'){
                $eliminar ="<a href=\"javascript:inactivarAplicaciones('{$row['id']}','{$row['descripcion']}')\"  class=\"separador\"><img src=\"images/iconos/mis/eliminar.png\" title=\"Eliminar Aplicacion\" width=\"20\" height=\"20\" border=\"0\"/></a>";
            }
//            $data['page_data'][$key]['ciclo'] = print_r($data);
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


