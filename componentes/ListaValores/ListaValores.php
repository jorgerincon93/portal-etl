<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'ListaValores/vista/vistaListaValores.php';
include_once COMPONENTS_PATH . 'ListaValores/modelo/datosListaValores.php';


class ListaValores{
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
        $this->datos = new DatosListaValores();
        $this->vista = new VistaListaValores($this->datos);
    }
    
    public function mostrarLista($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$ListaValores = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarListaValores($permisos);    	
    }
    
    function verListaValor($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$ListaValores=$this->datos->mostrarListaValor($arreglo);
        //echo'<pre>';print_r($ListaValores);echo'</pre>';
	$this->vista->verListaValor($ListaValores);
    }
    
    function agregarListaValor($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO VALOR";        
	$this->vista->agregarListaValor($arreglo);
    }
    
    function editarListaValor($arreglo){        
	
        $arreglo['datosListaValor']=$this->datos->datosListaValor($arreglo);
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR LISTA VALOR " . strtoupper($arreglo['datosListaValor']->valor);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarListaValor($arreglo);
    }        
   
    function guardarListaValor($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarListaValor($arreglo);
	}
	else{            
            $this->datos->insertarListaValor($arreglo);            
	}
        
	$this->mostrarLista($arreglo);
    }    
    
    function eliminarListaValor($arreglo){       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->eliminarListaValor($arreglo["id"]);
        $this->mostrarLista($arreglo);
    }        
    
    function ajaxLista($arreglo){
       global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(l.id) as totalrows FROM listavalor l",                                 // CONFIGURE
                "selectSQL" => "SELECT l.id,l.idPadreLista,l.tipo,l.valor,l.nombre,l.texto FROM listavalor l", // CONFIGURE
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

            $data['page_data'][$key]['valor'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=ListaValores&method=verListaValor&id={$row['id']}\" >{$row['valor']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            $eliminar = "";
            if($permisos->editar=="SI"){
                $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=ListaValores&method=editarListaValor&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/mis/editar.png\" title=\"Editar Lista Valor\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
            }        
            if($permisos->eliminar=="SI"){
                $eliminar ="<a href=\"javascript:eliminarListaValor('{$row['id']}','{$row['valor']}')\"  class=\"separador\"><img src=\"imagenes/iconos/mis/eliminar.png\" title=\"Eliminar Lista Valor\" width=\"20\" height=\"20\" border=\"0\"/></a>";
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


