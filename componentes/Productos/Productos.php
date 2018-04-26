<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Productos/vista/vistaProductos.php';
include_once COMPONENTS_PATH . 'Productos/modelo/datosProductos.php';


class Productos{
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
        $this->datos = new DatosProductos();
        $this->vista = new VistaProductos($this->datos);
    }
    
    public function mostrarProductos($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarProductos($permisos);    	
    }
    
    function verProductos($arreglo){
        
        $arreglo["producto"] = $this->datos->mostrarProductos($arreglo);        
        
        $nombreCate = $this->datos->retornarNombreCategoria($arreglo['producto'][0]["categoria"]);
        $nombreTipo = $this->datos->retornarNombreTipo($arreglo['producto'][0]["tipo"]);
        $nombreMarca = $this->datos->retornarMarca($arreglo['producto'][0]["idMarca"]);
        $nombreEstado = $this->datos->retornarNomEstado($arreglo['producto'][0]["estado"]);
        
        $arreglo["producto"][0]["nombreCate"] = $nombreCate->nombre;
        $arreglo["producto"][0]["nombreTipo"] = $nombreTipo->nombre;
        $arreglo["producto"][0]["marca"] = $nombreMarca->nombre;
        $arreglo["producto"][0]["estado"] = $nombreEstado->valor;
        
        
        
	$this->vista->verProductos($arreglo["producto"]);
    }
    
    function agregarProductos($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        
        $lista_cate_pro = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE tipo='CategoriaProducto' ORDER BY valor ");
    	$arreglo['select_cate_pro'] = $this->datos->armSelect($lista_cate_pro ,'Seleccione Categoria...');
        
        $lista_tipo_pro = array();
        $arreglo['select_tipo_pro'] = "";
        /*$lista_tipo_pro = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoProducto' ORDER BY valor ");
    	$arreglo['select_tipo_pro'] = $this->datos->armSelect($lista_tipo_pro ,'Seleccione Tipo...');*/
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='EstadoProducto' ORDER BY valor ");
    	$arreglo['select_estado_pro'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
   
        /*$lista_tipoDoc = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...');*/
        
        $lista_marca = $this->datos->build_list('mundolimpieza.marca','id','nombre', " ORDER BY nombre ");
    	$arreglo['select_marca'] = $this->datos->armSelect($lista_marca ,'Seleccione Marca...');
        
        $arreglo['disabled'] ="disabled";
        $arreglo['titulo_tabla'] = "NUEVO PRODUCTO MAQUINARIA";
	$this->vista->agregarProductos($arreglo);
    }
    
    function editarProductos($arreglo){       
	
        $arreglo['datosProducto'] = $this->datos->selectProductosLs($arreglo["id"]);
		
        $datosProductosLV = $this->datos->traerProdLV($arreglo['datosProducto']->categoria);
        $datosProductosTipo = $this->datos->traerProdLV($arreglo['datosProducto']->tipo);
        
        $lista_cate_pro = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE tipo='CategoriaProducto' ORDER BY valor ");
    	$arreglo['select_cate_pro'] = $this->datos->armSelect($lista_cate_pro ,'Seleccione Categoria...',$datosProductosLV->id);
        
        $lista_tipo_pro = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE tipo='TipoProducto' ORDER BY nombre ");
        $arreglo['select_tipo_pro'] = $this->datos->armSelect($lista_tipo_pro ,'Seleccione Tipo...',$datosProductosTipo->id);
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE tipo='EstadoProducto' ORDER BY valor ");
    	$arreglo['select_estado_pro'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',$arreglo['datosProducto']->estado);
                
        $lista_marca = $this->datos->build_list('mundolimpieza.marca','id','nombre', " ORDER BY nombre ");
    	$arreglo['select_marca'] = $this->datos->armSelect($lista_marca ,'Seleccione Marca...',$arreglo['datosProducto']->idMarca);
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR PRODUCTO " . strtoupper($arreglo['datosProducto']->nombre);
        
	$this->vista->agregarProductos($arreglo);
    }        
   
    function guardarProductos($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
		
           $this->datos->actualizarProductos($arreglo);
            $this->datos->actualizarDetProductos($arreglo);
	}
	else{           
            
            $idProducto = $this->datos->insertarProductos($arreglo);
            $arreglo['idProducto'] = $idProducto;
              
              $this->datos->insertarDetProductos($arreglo);
	}
        
	  //$this->mostrarProductos($arreglo);
    }    
    
    function eliminarProductos($arreglo){       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
          $idEstadoInactivoProd = $this->datos->retornarEstado();
          $this->datos->inactivarProductos($arreglo["id"],$idEstadoInactivoProd->id);
          $this->mostrarProductos($arreglo);
    }        
    
//    function consultarCatpro($arreglo){
//       
//        $lista_cate_pro = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE idPadreLista IN (" . $arreglo["categoria"] . ") ORDER BY nombre ");
//        $select_cate_pro = $this->datos->armSelect($lista_cate_pro ,'Seleccione Categoria...');
//        
//        echo $select_cate_pro;    
//        
//    }
    
    function consultarTipopro($arreglo){
       
        $lista_tipo_pro = $this->datos->build_list('mundolimpieza.listavalor','id','nombre', "WHERE idPadreLista IN (" . $arreglo["categoria"] . ") ORDER BY nombre ");
        $select_tipo_pro = $this->datos->armSelect($lista_tipo_pro ,'Seleccione Tipo...');
        
        echo $select_tipo_pro;    
        
    }
    
    function ajaxListaProductos($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(c.id) as totalrows FROM mundolimpieza.maquinaria c ",                                 // CONFIGURE c.nombreMarca,
                "selectSQL" => "SELECT c.id,c.referencia,nombre,c.categoria,c.tipo,c.tamano,c.empaque,c.presentacion,c.descripcion,c.estado,c.countDetProducto FROM mundolimpieza.maquinaria c ",// CONFIGURE
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
             
            $nombreCate = $this->datos->retornarNombreCategoria($row['categoria']);
            $nombreTipo = $this->datos->retornarNombreTipo($row['tipo']);
            $nombreEstado = $this->datos->retornarEstadoProd($row['estado']);
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            $data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Productos&method=verProductos&id={$row['id']}\" >{$row['nombre']}</a>";
            
            $data['page_data'][$key]['categoria'] = $this->datos->retornarNombreCategoria($data['page_data'][$key]['categoria']);
            $data['page_data'][$key]['tipo'] = $this->datos->retornarNombreTipo($data['page_data'][$key]['tipo']);
            $data['page_data'][$key]['estado'] = $this->datos->retornarEstadoProd($data['page_data'][$key]['estado']);

            $editar = "";
            $eliminar = "";
            if($permisos->editar=="SI"){
                $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Productos&method=editarProductos&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/mis/editar.png\" title=\"Editar Producto\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
            }        
            if($permisos->eliminar=="SI"){
                $eliminar ="<a href=\"javascript:eliminarProductos('{$row['id']}','{$row['nombre']}')\"  class=\"separador\"><img src=\"imagenes/iconos/mis/eliminar.png\" title=\"Eliminar Producto\" width=\"20\" height=\"20\" border=\"0\"/></a>";
            }
            
            $data['page_data'][$key]['categoria'] = $nombreCate->nombre;
            $data['page_data'][$key]['tipo'] = $nombreTipo->nombre;
            $data['page_data'][$key]['estado'] = $nombreEstado->nombre;
            
            $data['page_data'][$key]['acciones'] = $editar ." ". $eliminar;
        }
    
        echo json_encode($data);        
    }
    
    function ajaxListaProdCate($arreglo){
        
        $tipos = $this->datos->listacate();
        
        $v_cont=0;
        $listaTipos ="[";
        foreach ($tipos as $key => $value) {
            if($v_cont==0){
                $listaTipos = $listaTipos . '{"lk_option":"' . $tipos[$key]["nombre"] . '","lk_value":"' . $tipos[$key]["id"] . '"}';
                $v_cont++;
            }else{            
                $listaTipos = $listaTipos . ',{"lk_option":"' . $tipos[$key]["nombre"] . '","lk_value":"' . $tipos[$key]["id"] . '"}';
            }            
        }
        $listaTipos = $listaTipos . "]";
        
        echo $listaTipos;
    }
    
    function ajaxListaProdInsumos($arreglo){
        
        $tipos = $this->datos->listaTipo();
        
        $v_cont=0;
        $listaTipos ="[";
        foreach ($tipos as $key => $value) {
            if($v_cont==0){
                $listaTipos = $listaTipos . '{"lk_option":"' . $tipos[$key]["nombre"] . '","lk_value":"' . $tipos[$key]["id"] . '"}';
                $v_cont++;
            }else{            
                $listaTipos = $listaTipos . ',{"lk_option":"' . $tipos[$key]["nombre"] . '","lk_value":"' . $tipos[$key]["id"] . '"}';
            }            
        }
        $listaTipos = $listaTipos . "]";
        
        echo $listaTipos;
    }
        
}

?>


