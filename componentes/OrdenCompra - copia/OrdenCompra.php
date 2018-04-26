<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'OrdenCompra/vista/vistaOrdenCompra.php';
include_once COMPONENTS_PATH . 'OrdenCompra/modelo/datosOrdenCompra.php';

class OrdenCompra{

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
        $this->datos = new DatosOrdenCompra();
        $this->vista = new VistaOrdenCompra($this->datos);
    }

    public function mostrarOrdenCompra($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        
        $idTipoAcceso = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $tipoAcceso =  $this->datos->traerTipoAcceso($idTipoAcceso->idTipoAcceso);
        
          if(isset($tipoAcceso->nomAcceso)){
              $this->datos->crearVistaUsuario($idTipoAcceso->id,$idTipoAcceso->idTipoAcceso,$tipoAcceso->nomAcceso);
               
          }
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarOrdenCompra($permisos);    	
    }
    
    function verOrdenCompra($arreglo){
        
        
        $idCatServ = $this->datos->traerIdServEspeciales();
        $idCatPer = $this->datos->traerIdPersonal();
        $idCatAseo = $this->datos->traerIdBienesAseo();
        
        $arreglo["datosOrdenCompra"] = $this->datos->datosOrdenCompra($arreglo["id"]);
        $arreglo["datosDetOrdenCompra"] = $this->datos->datosDetOrdenCompra($arreglo["id"]);
        
        
        $nombreClie = $this->datos->retornarNombreCliente($arreglo["datosOrdenCompra"]->idCliente);
        $nombreActa = $this->datos->retornarNombreActa($arreglo["datosOrdenCompra"]->actaLiquidacion);
        $nombreCert = $this->datos->retornarNombreCert($arreglo["datosOrdenCompra"]->certificacion);
        
        $arreglo["datosOrdenCompra"]->nombreClie = $nombreClie->nombre;
        $arreglo["datosOrdenCompra"]->actLiqui = $nombreActa->valor;
        $arreglo["datosOrdenCompra"]->certi = $nombreCert->valor;
        $arreglo['datosOrdenCompra']->asesor = $_SESSION['datos_logueo']['nombreUsuario'];
        
        
        $arreglo["nomProdCatServ"] = $this->datos->traerDetalleOferta($arreglo["id"],$idCatServ->idSerEspe);
        $arreglo["nomProdCatPer"] = $this->datos->traerDetalleOferta($arreglo["id"],$idCatPer->idPersonal);
        $arreglo["nomProdCatAseo"] = $this->datos->traerDetalleOferta($arreglo["id"],$idCatAseo->idBienesAseo);
        
        
        foreach ($arreglo["nomProdCatServ"] as $key => $valueDet) {
                
               $nombreCiudad = $this->datos->traerNombreCiu($valueDet["idCiudad"]);
                  
                  $arreglo["nomProdCatServ"][$key]["valorUni"] = $valueDet["precioUnidad"];
                  $arreglo["nomProdCatServ"][$key]["valorUniTotal"] = $valueDet["precioUniTotal"];
                  $arreglo["nomProdCatServ"][$key]["ciudad"] = $nombreCiudad->nombre;                                    
                  
                
        }
        
        foreach ($arreglo["nomProdCatPer"] as $key => $valueDet) {
                
               $nombreCiudad = $this->datos->traerNombreCiu($valueDet["idCiudad"]);
                  
                  $arreglo["nomProdCatPer"][$key]["valorUni"] = $valueDet["precioUnidad"];
                  $arreglo["nomProdCatPer"][$key]["valorUniTotal"] = $valueDet["precioUniTotal"];
                  $arreglo["nomProdCatPer"][$key]["ciudad"] = $nombreCiudad->nombre;                                    
                  
                
        }
        
        foreach ($arreglo["nomProdCatAseo"] as $key => $valueDet) {
                
                  $nombreCiudad = $this->datos->traerNombreCiu($valueDet["idCiudad"]);
                  
                  $arreglo["nomProdCatAseo"][$key]["valorUni"] = $valueDet["precioUnidad"];
                  $arreglo["nomProdCatAseo"][$key]["valorUniTotal"] = $valueDet["precioUniTotal"];
                  $arreglo["nomProdCatAseo"][$key]["ciudad"] = $nombreCiudad->nombre;
                                    
                  
                     
        }
              
        
        $arreglo["titulo"] = 'ORDEN COMPRA';
	$this->vista->verOrdenCompra($arreglo);
    }
    
    function agregarOrdenCompra($arreglo){        
        
        $arreglo["opcion"] = "agregar";
        
        $arreglo['datosClientes'] = $this->datos->datosClientes();
        $arreglo['datosUsuario'] = $this->datos->datosUsuario();
        $idSerEspe = $this->datos->traerIdServEspeciales();
        $idPersonal = $this->datos->traerIdPersonal();
        $idBienesAseo = $this->datos->traerIdBienesAseo();
        
        $lista_act_liqui = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'ActaLiquidacion' ORDER BY id ");
    	$arreglo['select_act_liqui'] = $this->datos->armSelect($lista_act_liqui,'Seleccione La Opcion...');
        
        $lista_certi = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'Certificacion' ORDER BY id ");
    	$arreglo['select_certi'] = $this->datos->armSelect($lista_certi,'Seleccione La Opcion...');
        
        $lista_region = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_aiu'] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad');
        
        $lista_region_per = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_per'] = $this->datos->armSelect($lista_region_per,'Seleccione La Ciudad');
        
        $lista_region_aseo = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_aseo'] = $this->datos->armSelect($lista_region_aseo,'Seleccione La Ciudad');
   
        $lista_cli_ofe = $this->datos->build_list('mundolimpieza.cliente', 'id', 'nombre', "WHERE estado='Activo' ORDER BY nombre ");
        $arreglo['select_cli_ofe'] = $this->datos->armSelect($lista_cli_ofe, 'Seleccione El Cliente...');
        
        
        $lista_bienServ = $this->datos->build_list('mundolimpieza.producto', 'id', "nombre", "WHERE categoria = '".  $idSerEspe->idSerEspe ."' ORDER BY nombre ");
        $arreglo['select_bienServ'] = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
        
        $lista_bienServPer = $this->datos->build_list('mundolimpieza.producto', 'id', 'nombre', "WHERE categoria = '".  $idPersonal->idPersonal ."' ORDER BY nombre ");
        $arreglo['select_bienServPer'] = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
        
        
        $lista_cant = $this->datos->build_list('mundolimpieza.producto','id',"CONCAT(nombre,'(',referencia,')')",  "WHERE categoria = '".  $idBienesAseo->idBienesAseo ."' ORDER BY id");
        $arreglo['select_aseo'] = $this->datos->armSelect($lista_cant ,'Seleccione Bien o Servicio...');
        
        /*$lista_marca = $this->datos->build_list('mundolimpieza.listavalor', 'id', 'valor', "WHERE tipo = 'Marca' ORDER BY nombre ");
        $arreglo['select_marca'] = $this->datos->armSelect($lista_marca,'Seleccione Marca...');*/
        
        $arreglo['OrdenCompraAIU'][0] = array();
        $arreglo['OrdenCompraAIU'][0]["select_bienServ"] = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
        $arreglo['OrdenCompraAIU'][0]["select_reg_aiu"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...');
        $arreglo['OrdenCompraAIU'][0]["disabled"] = "disabled";
        
        $arreglo['OrdenCompraPER'][0] = array();
        $arreglo['OrdenCompraPER'][0]["select_bienServPer"] = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
        $arreglo['OrdenCompraPER'][0]["select_reg_per"] = $this->datos->armSelect($lista_region_per,'Seleccione La Ciudad...');
        $arreglo['OrdenCompraPER'][0]["disabledPer"] = "disabled";
        
        $arreglo['OrdenCompraASEO'][0] = array();
        $arreglo['OrdenCompraASEO'][0]["select_aseo"] = $this->datos->armSelect($lista_cant,'Seleccione Bien o Servicio...');
        $arreglo['OrdenCompraASEO'][0]["select_reg_aseo"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...');
        $arreglo['OrdenCompraASEO'][0]["disabledAseo"] = "disabled";        
        
        
        $fechaSis = $this->retornarFechaSistema();
        $arreglo['datosOrdenCompra']['fechaSis'] = $fechaSis;
        $arreglo['datosOrdenCompra']['asesor'] = $_SESSION['datos_logueo']['nombreUsuario'];
        $arreglo['datosOrdenCompra']['idAsesor'] = $_SESSION['datos_logueo']['idUsuario'];
        
        $arreglo['titulo_tabla'] = "NUEVA OFERTA ECONOMICA";
        
	$this->vista->agregarOrdenCompra($arreglo);
    }
    
    function consultarCantidadAIU($referencia){
       
       $canDis = $this->datos->calcularCantidadChan($referencia);
       //$idEstadoDisProd = $this->datos->traerIdEstadoDisProd();
       $idSerEspe = $this->datos->traerIdServEspeciales();
       
        $valorCant = $canDis->cantDis;
        
        if($valorCant == 0){
            
            $lista_bienServ = $this->datos->build_list('mundolimpieza.producto', 'id', "nombre", "WHERE categoria = '".  $idSerEspe->idSerEspe ."' AND cantidadDisponible <> '0' ORDER BY nombre ");
            $select_aiu_cant = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
            
            
            echo $select_aiu_cant;
            
        }else{
            
           $lista_bienServ = $this->datos->build_list('mundolimpieza.producto', 'id', "nombre", "WHERE categoria = '".  $idSerEspe->idSerEspe ."' AND cantidadDisponible <> '0' ORDER BY nombre ");
           $select_aiu_cant = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
            
           echo $select_aiu_cant;
        }
        
    }
    
    function consultarCantidadPER($referencia){
       
       $canDis = $this->datos->calcularCantidadChan($referencia);
       //$idEstadoDisProd = $this->datos->traerIdEstadoDisProd();
       $idPersonal = $this->datos->traerIdPersonal();
       
        $valorCant = $canDis->cantDis;
        
        if($valorCant == 0){
            
             $lista_bienServPer = $this->datos->build_list('mundolimpieza.producto', 'id', 'nombre', "WHERE categoria = '".  $idPersonal->idPersonal ."' AND cantidadDisponible <> '0' ORDER BY nombre ");
             $select_per_cant = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
            
             echo $select_per_cant;
            
        }else{
            
           $lista_bienServPer = $this->datos->build_list('mundolimpieza.producto', 'id', 'nombre', "WHERE categoria = '".  $idPersonal->idPersonal ."' AND cantidadDisponible <> '0' ORDER BY nombre ");
           $select_per_cant = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
            
            
            
            echo $select_per_cant;
        }
        
    }
    
    function consultarCantidadAEO($referencia){
       
       $canDis = $this->datos->calcularCantidadChan($referencia);
       //$idEstadoDisProd = $this->datos->traerIdEstadoDisProd();
       $idBienesAseo = $this->datos->traerIdBienesAseo();
       
        $valorCant = $canDis->cantDis;
        
        if($valorCant == 0){
                
            $aseoCant = $this->datos->build_list('mundolimpieza.producto','id',"CONCAT(nombre,'(',referencia,')')",  "WHERE categoria = '".  $idBienesAseo->idBienesAseo ."' ORDER BY id");
            $select_aseo_cant = $this->datos->armSelect($aseoCant,'Seleccione Bien o Servicio...');
            
            echo $select_aseo_cant;
            
        }else{
            
            $aseoCant = $this->datos->build_list('mundolimpieza.producto','id',"CONCAT(nombre,'(',referencia,')')",  "WHERE categoria = '".  $idBienesAseo->idBienesAseo ."' ORDER BY id");
            $select_aseo_cant = $this->datos->armSelect($aseoCant,'Seleccione Bien o Servicio...');
            
            echo $select_aseo_cant;
        }
        
    }
    
    
    function traerPrecioAIU($arreglo){
        
         $precioCiudad = json_decode($arreglo["precioCiudad"]);
         
         foreach ($precioCiudad as $key => $valuePrecio) {
             
             $precio = $this->datos->traerPrecio($valuePrecio->idCiudad,$valuePrecio->idProducto);
             
            
         }
         
        echo $precio->precio;
    }
    
    function traerPrecio($arreglo){
        
         $precioCiudad = json_decode($arreglo["precioCiudad"]);
         
         foreach ($precioCiudad as $key => $valuePrecio) {
             
             $precio = $this->datos->traerPrecio($valuePrecio->idCiudad,$valuePrecio->idProducto);
             
            
         }
         
        echo $precio->precio;
    }
    
    function multiplicarCantValorUni($arreglo){
        
        $preciototal = json_decode($arreglo["preciototal"]);
        
        foreach ($preciototal as $key => $valueSubTotal) {
            
             $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;
            
        }
        
        echo $totalPrecio;
        
    }
    
    function reiniciarValorContrato($arreglo){
        
        $totalCon = NULL;
                
        if($arreglo["opcion"] == 'editar'){
        
            if(isset($arreglo["valorContra"])){
                
                $totalCon = 0;
                
            }
            
        }
        
        echo $totalCon;
        
    }
    
    function sumarSubTotales($arreglo){
        
        $subtotal = json_decode($arreglo["subtotal"],true);
         
        $totalGeneral = 0;
        $subtotalAIU = 0;
        $subtotalPER = 0;
        $subtotalASEO = 0;
        //$subtGeneral = 0;
         
        foreach ($subtotal as $keyTotal => $valueTotal) {
               
              if(isset($valueTotal["subtotalAIU"])){
                   
                  $arreglo["totalOfe"][$keyTotal] = $valueTotal["subtotalAIU"];
                  
                   
               }else{
                   
                   $subtotalAIU = 0;
               }
               
               
               if(isset($valueTotal["subtotalPER"])){
                   
                   $arreglo["totalOfe"][$keyTotal] = $valueTotal["subtotalPER"];

                   
                   
               }else{
                   
                   $subtotalPER = 0;
               }
               
               if(isset($valueTotal["subtotalASEO"])){
                   
                   $arreglo["totalOfe"][$keyTotal] = $valueTotal["subtotalASEO"];
                   
                   
                   
               }else{
                   
                   $subtotalASEO = 0;
               }
               
               $totalGeneral = array_sum($arreglo["totalOfe"]);
               
        }
        
        echo $totalGeneral;
        
    }
    
    function calcularCantidad($arreglo){
        
        $calCant = json_decode($arreglo["cantidad"]);
        
        
        
        foreach ($calCant as $key => $value) {
            
          
            $cantidad = $value->valorCant;
            $ref = $value->idProducto;
         
        if($ref != '' || $ref != NULL){
            
                if($cantidad != '' || $cantidad != NULL){
               
           
                    $canDis = $this->datos->calcularCantidad($value);
           
                        // VALIDO CANDTIDAD INGRESADA //
            
                          if($value->valorCant > 0){
                                $valorCant = $value->valorCant;
                                $canDis = $canDis->cantDispo;
                                $totalCant = $canDis - $valorCant;
                   
                                // VALIDO EL RESULTADO DE LA RESTA, DE SER POSITIVO ACTUALIZO ESTADO DEL PRODUCTO
                                if($totalCant >= 0){
                       
                       
                                    $estadoProd = 'Ofertado';
                                    $idEstadoNuevoProd = $this->datos->traerIDEstadoProd($estadoProd);
                          
                                    $idActuali = $this->datos->traerIdActualizar($value,$valorCant);
                         
                                        foreach ($idActuali as $key => $valueId) {
                                
                                           //ACTUALIZO EL VALOR DISPONIBLE DEL PRODUCTO
                                            $this->datos->actualizaCantidadDetProd($valueId["id"],$idEstadoNuevoProd->id);//,$totalCant);
                                            
                                        }    
                                        
                                    if($totalCant >= 0){
                                         $this->datos->actualizaCantidadProd($ref,$totalCant);
                                          echo '<script language="javascript">alert("CANTIDAD DISPONIBLE: ' . $totalCant . '");</script>';
                                          
                                          
                                        if($totalCant == 0){
                                            $this->datos->actualizaCantidadProd($ref,$totalCant);
                                            echo '<script language="javascript">alert("SE HABILITA OTRA REFENCIA PARA EL PRODUCTO SELECCIONADO");</script>';
                                            
                                        }
                              
                              
                                    }
                            
                            
                  
                       
                       
                                }else{
                                    
                                    echo '<script language="javascript">alert("LA CANTIDAD INGRESADA ' .
                                        ' NO SE ENCUENTRA DISPONIBLE EN EL MOMENTO, CANTIDAD ACTUAL: ' . $canDis . '");</script>';
                                }
                   
                            }else{
                   
                                     echo '<script language="javascript">alert("LA CANTIDAD ' . $value->valorCant .
                                     ' NO ES VALIDA, CANTIDAD ACTUAL: ' . $canDis . '");</script>';
                   
                            }
            
                }else{
                
                        echo '<script language="javascript">alert("POR FAVOR INGRESAR CANTIDAD");</script>';
                        
                      }  
        
            }else{
            
                    echo '<script language="javascript">alert("POR FAVOR SELECIONE UNA REFERENCIA");</script>';
                } 
        }
    
    }
    
    function restaurarCantidad($arreglo){
        
           
        //foreach ($arreglo as $key => $value) {
            
             if($arreglo['opcion'] == "agregar"){
                 
                 $idEstadoDisProd = $this->datos->traerIdEstadoDisProd();
                 $idEstadoOferProd = $this->datos->traerIdEstadoOferProd();
                 $cantInicial = $this->datos->traercantidadProd($idEstadoDisProd->idEstadoDisProd);
                 
                 $this->datos->restaurarCantidad($idEstadoDisProd->idEstadoDisProd,$idEstadoOferProd->idEstadoOferProd);
                 
                 foreach ($cantInicial as $key => $valueIni) {
                     
                     $this->datos->restaurarCantidadProd($valueIni["canIni"],$valueIni["id"]);
                 }
                 
             }
            
            
        //}
        
        
        
    }        
    
    function retornarFechaSistema() {
        
        $fechaActual = date("d-m-Y");
        return $fechaActual;
    }
    
    function ajaxListaOrdenCompra($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        $id_usuario = $_SESSION["datos_logueo"]["idUsuario"];
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(c.id) as totalrows FROM vistaordencompra_" . $id_usuario ." c  ", // CONFIGURE
                "selectSQL" => "SELECT c.id,c.estado,c.fechaCreacion,c.fechaModificacion,c.idCliente,c.numeroContrato,c.numeroContratoInterno,c.fechaInicio,"
                                    . "c.fechaFin,c.prorroga,c.valorContrato,c.idServicio,c.cantidadOperarios,c.actaLiquidacion,c.certificacion,c.idOfertaEconomica"
                                    . " FROM mundolimpieza.vistaordencompra_" . $id_usuario ." c ",// CONFIGURE
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
                
            /*$nombreCli = $this->datos->retornarNombreCliente($row['idCliente']);
            $nombreActa = $this->datos->retornarNombreActa($row['actaLiquidacion']);
            $nombreCert = $this->datos->retornarNombreCert($row['certificacion']);
            $nombreEstado = $this->datos->retornarNombreEstado($row['estado']);*/
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            //$data['page_data'][$key]['id'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OfertaEconomica&method=verOfertaEconomica&id={$row['id']}\" >{$row['id']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);
            
            $ver = "";
            
            if($permisos->crear=="SI"){
                $ver ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/detalle5.png\" title=\"Ver Detalle Orden Compra\" width=\"25\" height=\"25\" border=\"0\" /></a>";
            }
            
             /*$data['page_data'][$key]['cliente'] = $nombreCli->nombre;
             $data['page_data'][$key]['actaLiquidacion'] = $nombreActa->valor;
             $data['page_data'][$key]['certificacion'] = $nombreCert->valor;
             $data['page_data'][$key]['estado'] = $nombreEstado->nomEstado;*/
            
            //$data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['id'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['id'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['acciones'] = $ver;
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


