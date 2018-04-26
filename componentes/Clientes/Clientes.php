<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Clientes/vista/vistaClientes.php';
include_once COMPONENTS_PATH . 'Clientes/modelo/datosClientes.php';


class Clientes{
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
        $this->datos = new DatosClientes();
        $this->vista = new VistaClientes($this->datos);
    }
    
    public function mostrarClientes($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarClientes($permisos);    	
    }
    
    function verCliente($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$listaCliente=$this->datos->mostrarCliente($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
	$this->vista->verCliente($listaCliente);
    }
    
    function agregarCliente($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='EstadoCliente' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
   
        $lista_tipoDoc = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...');
        
        
        $arreglo['titulo_tabla'] = "NUEVO CLIENTE";        
	$this->vista->agregarCliente($arreglo);
    }
    
    function editarCliente($arreglo){        
	
        $arreglo['datosCliente']=$this->datos->datosCliente($arreglo);
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='EstadoCliente' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',isset($arreglo['datosCliente']->estado)?$arreglo['datosCliente']->estado:"");        
        
        $lista_tipoDoc = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...',isset($arreglo['datosCliente']->tipoDocumento)?$arreglo['datosCliente']->tipoDocumento:"");
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR CLIENTE " . strtoupper($arreglo['datosCliente']->nombre);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarCliente($arreglo);
    }        
   
    function guardarCliente($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarCliente($arreglo);
	}
	else{            
            $this->datos->insertarCliente($arreglo);            
	}
        
	$this->mostrarClientes($arreglo);
    }    
    
    function eliminarCliente($arreglo){       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->inactivarCliente($arreglo["id"]);
        $this->mostrarClientes($arreglo);
    }        
    
    function ajaxListaClientes($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(c.id) as totalrows FROM mundolimpieza.cliente c ",                                 // CONFIGURE
                "selectSQL" => "SELECT c.id,c.nombre,c.tipoDocumento,c.documento,c.numeroContrato,c.numeroCodigo,c.vigencia,c.sedes,c.insumos,c.cantidadOperarios,c.telefono,c.email,c.direccion,c.personaContacto,c.estado FROM mundolimpieza.cliente c ",// CONFIGURE
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

            $data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Clientes&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            $eliminar = "";
            if($permisos->editar=="SI"){
                $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Clientes&method=editarCliente&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/mis/editar.png\" title=\"Editar Cliente\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
            }        
            if($permisos->eliminar=="SI"){
                $eliminar ="<a href=\"javascript:eliminarCliente('{$row['id']}','{$row['nombre']}')\"  class=\"separador\"><img src=\"imagenes/iconos/mis/eliminar.png\" title=\"Eliminar Cliente\" width=\"20\" height=\"20\" border=\"0\"/></a>";
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


