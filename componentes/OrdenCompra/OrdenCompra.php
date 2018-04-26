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
        //echo'<pre>';print_r($tipoAcceso);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarOrdenCompra($permisos);    	
    }
    
    function verOfertaEconomica($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$listaProductos=$this->datos->mostrarOfertaEconomica($arreglo);
        //echo'<pre>';print_r($listaProductos);echo'</pre>';
	$this->vista->verOfertaEconomica($listaProductos);
    }
    
    function agregarOfertaEconomica($arreglo){        
        
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
        
        $arreglo['OfertaEconomicaAIU'][0] = array();
        $arreglo['OfertaEconomicaAIU'][0]["select_bienServ"] = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
        $arreglo['OfertaEconomicaAIU'][0]["select_reg_aiu"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...');
        $arreglo['OfertaEconomicaAIU'][0]["disabled"] = "disabled";
        
        $arreglo['OfertaEconomicaPER'][0] = array();
        $arreglo['OfertaEconomicaPER'][0]["select_bienServPer"] = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
        $arreglo['OfertaEconomicaPER'][0]["select_reg_per"] = $this->datos->armSelect($lista_region_per,'Seleccione La Ciudad...');
        $arreglo['OfertaEconomicaPER'][0]["disabledPer"] = "disabled";
        
        $arreglo['OfertaEconomicaASEO'][0] = array();
        $arreglo['OfertaEconomicaASEO'][0]["select_aseo"] = $this->datos->armSelect($lista_cant,'Seleccione Bien o Servicio...');
        $arreglo['OfertaEconomicaASEO'][0]["select_reg_aseo"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...');
        $arreglo['OfertaEconomicaASEO'][0]["disabledAseo"] = "disabled";  
        
        
        $arreglo['OfertaEconomica']["genOrden"] = "NULL";       
        
        
        $fechaSis = $this->retornarFechaSistema();
        $arreglo['datosOfertaEconomica']['fechaSis'] = $fechaSis;
        $arreglo['datosOfertaEconomica']['asesor'] = $_SESSION['datos_logueo']['nombreUsuario'];
        $arreglo['datosOfertaEconomica']['idAsesor'] = $_SESSION['datos_logueo']['idUsuario'];
        
        $arreglo['titulo_tabla'] = "NUEVA OFERTA COMERCIAL";
        
	$this->vista->agregarOfertaEconomica($arreglo);
    }
    
    function editarOfertaEconomica($arreglo){
	
        
        $arreglo["opcion"] = "editar";
        
        $arreglo['OfertaEconomica']["genOrden"] = "si";
        $arreglo['datosClientes'] = $this->datos->datosClientes();
		$arreglo['datosUsuario'] = $this->datos->datosUsuario();
		$datosOfertaEconomica = $this->datos->datosOfertaEconomica($arreglo["id"]);
		$arreglo['datosDetOfertaEconomica'] = $this->datos->datosDetOfertaEconomica($arreglo["id"]);
		$datosOrdenCompra = $this->datos->datosOrdenCompra($arreglo["id"]);
        
        $idSerEspe = $this->datos->traerIdServEspeciales();
        $idPersonal = $this->datos->traerIdPersonal();
        $idBienesAseo = $this->datos->traerIdBienesAseo();
        
        $datosUsuario = $this->datos->datosAsesor($datosOfertaEconomica->idUsuario);
        
        $arreglo['datosOfertaEconomica']["asesor"] = $datosUsuario->nombreUsuario;
        $arreglo['datosOfertaEconomica']["idAsesor"] = $_SESSION['datos_logueo']['idUsuario'];
        
        $fechaSis = $this->retornarFechaSistema();
        $arreglo['datosOfertaEconomica']["fechaSis"] = $fechaSis;
        $arreglo['datosOfertaEconomica']["valorContrato"] = $datosOfertaEconomica->valorContrato;
        $arreglo['datosOfertaEconomica']["numeroContrato"] = $datosOfertaEconomica->numeroContrato;
        $arreglo['datosOfertaEconomica']["numeroContratoInterno"] = $datosOfertaEconomica->numeroContratoInterno;
        $arreglo['datosOfertaEconomica']["fechaInicio"] = $datosOfertaEconomica->fechaInicio;
        $arreglo['datosOfertaEconomica']["fechaFin"] = $datosOfertaEconomica->fechaFin;
        $arreglo['datosOfertaEconomica']["observacion"] = $datosOfertaEconomica->observacion;
        
        
        //$arreglo['datosOfertaEconomica']->fechaInicio = $arreglo['datosOfertaEconomica']->fechaInicio;
        
        $lista_cli_ofe = $this->datos->build_list('mundolimpieza.cliente', 'id', 'nombre', "WHERE estado='Activo' ORDER BY nombre ");
        $arreglo['select_cli_ofe'] = $this->datos->armSelect($lista_cli_ofe, 'Seleccione El Cliente...',$datosOfertaEconomica->idCliente);
        
        $lista_act_liqui = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'ActaLiquidacion' ORDER BY id ");
    	$arreglo['select_act_liqui'] = $this->datos->armSelect($lista_act_liqui,'Seleccione La Opcion...',$datosOfertaEconomica->actaLiquidacion);
        
        $lista_certi = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'Certificacion' ORDER BY id ");
    	$arreglo['select_certi'] = $this->datos->armSelect($lista_certi,'Seleccione La Opcion...',$datosOfertaEconomica->certificacion);
        
        $lista_region = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_aiu'] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad');
        
        $lista_region_per = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_per'] = $this->datos->armSelect($lista_region_per,'Seleccione La Ciudad');
        
        $lista_region_aseo = $this->datos->build_list('mundolimpieza.ciudad','id',"CONCAT(nombre,'(',codigo,')')", " ORDER BY id ");
    	$arreglo['select_reg_aseo'] = $this->datos->armSelect($lista_region_aseo,'Seleccione La Ciudad');
        
        $lista_bienServ = $this->datos->build_list('mundolimpieza.producto', 'id', "nombre", "WHERE categoria = '".  $idSerEspe->idSerEspe ."' ORDER BY nombre ");
        $arreglo['select_bienServ'] = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...');
        
        $lista_bienServPer = $this->datos->build_list('mundolimpieza.producto', 'id', 'nombre', "WHERE categoria = '".  $idPersonal->idPersonal ."' ORDER BY nombre ");
        $arreglo['select_bienServPer'] = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...');
        
        
        $lista_cant = $this->datos->build_list('mundolimpieza.producto','id',"CONCAT(nombre,'(',referencia,')')",  "WHERE categoria = '".  $idBienesAseo->idBienesAseo ."' ORDER BY id");
        $arreglo['select_aseo'] = $this->datos->armSelect($lista_cant ,'Seleccione Bien o Servicio...');
        
        $lista_marca = $this->datos->build_list('mundolimpieza.listavalor', 'id', 'valor', "WHERE tipo = 'Marca' ORDER BY nombre ");
        $arreglo['select_marca'] = $this->datos->armSelect($lista_marca,'Seleccione Marca...');
        
        $ofertaEconomicaAIU = $this->datos->selectOfertaEconomica($datosOrdenCompra->idOfertaEconomica,$idSerEspe->idSerEspe);
        $arreglo['OfertaEconomicaAIU'] = $ofertaEconomicaAIU;        
        
        
        $ofertaEconomicaPer = $this->datos->selectOfertaEconomica($datosOrdenCompra->idOfertaEconomica,$idPersonal->idPersonal);
        $arreglo['OfertaEconomicaPER'] = $ofertaEconomicaPer;
        
        $ofertaEconomicaASEO = $this->datos->selectOfertaEconomica($datosOrdenCompra->idOfertaEconomica,$idBienesAseo->idBienesAseo);
        $arreglo['OfertaEconomicaASEO'] = $ofertaEconomicaASEO;       
      
        
        // Traigo ID producto segun categoria 
        foreach ($arreglo['OfertaEconomicaAIU']as $keyAIU => $valueAIU){
            
            //$idProductoAIU = $this->datos->traerIdProd($valueAIU['idOfertaEconomica'],$idSerEspe->idSerEspe);
            $arreglo['OfertaEconomicaAIU'][$keyAIU]["idProductoAIU"] = $valueAIU['idProducto'];
            $arreglo['OfertaEconomicaAIU'][$keyAIU]["disabled"] = "disabled";
            
            
            
        }
        
        foreach ($arreglo['OfertaEconomicaPER'] as $keyPER => $valuePER) {
            
            //$idProductoPER = $this->datos->traerIdProd($valuePER['idOfertaEconomica'],$idPersonal->idPersonal);
            $arreglo['OfertaEconomicaPER'][$keyPER]["idProductoPER"] = $valuePER['idProducto'];
            $arreglo['OfertaEconomicaPER'][$keyPER]["disabledPer"] = "disabled";            
            
        }
        
        foreach ($arreglo['OfertaEconomicaASEO'] as $keyASEO => $valueASEO) {
            
            //$idProductoASEO = $this->datos->traerIdProd($valueASEO['idOfertaEconomica'],$idBienesAseo->idBienesAseo);
            $arreglo['OfertaEconomicaASEO'][$keyASEO]["idProductoASEO"] = $valueASEO['idProducto'];
            $arreglo['OfertaEconomicaASEO'][$keyASEO]["disabledAseo"] = "disabled";
            
            
        }
        
        foreach($arreglo['OfertaEconomicaAIU'] as $keyOferta => $rowOfertaAIU){
            
            if($rowOfertaAIU['estadoItem'] != '' || $rowOfertaAIU['estadoItem'] != NULL){
                      $nomEstadoItem = $this->datos->traerNomEstadoItem($rowOfertaAIU['estadoItem']);
                      $nomEstadoItemAIU = $nomEstadoItem->nomEstado;
            
               
            }else{
                
                $nomEstadoItemAIU = '';
            }
            
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["idProductoAIU"] = $rowOfertaAIU['idProducto'];
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["select_reg_aiu"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...',$rowOfertaAIU["idCiudad"]);
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["select_bienServ"] = $this->datos->armSelect($lista_bienServ,'Seleccione Bien o Servicio...',$rowOfertaAIU["idProductoAIU"]);
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["cantidadAIU"] = $rowOfertaAIU["cantidad"];
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["precioUnidad"] = $rowOfertaAIU["precioUnidad"];
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["precioUniTotalAIU"] = $rowOfertaAIU["precioUniTotal"];
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["disabled"] = $rowOfertaAIU["disabled"];
                $arreglo['OfertaEconomicaAIU'][$keyOferta]["estadoCanAIU"] = $nomEstadoItemAIU;
        
        
                
                if($rowOfertaAIU["estadoOfe"] == "707" && $rowOfertaAIU["fechaModificacion"] == null){
                    $arreglo['OfertaEconomicaAIU'][$keyOferta]["disabled"] = "";
                }else{            
                    $arreglo['OfertaEconomicaAIU'][$keyOferta]["disabled"] = "disabled";
                }
             
                if($rowOfertaAIU["estadoOfe"]=="707" && $rowOfertaAIU["fechaModificacion"] != null){
                    $arreglo['OfertaEconomicaAIU'][$keyOferta]["disabled"] = "";
                }else{  
                    $arreglo['OfertaEconomicaAIU'][$keyOferta]["disabled"] = "disabled";
                }
             
        }
        
        foreach($arreglo['OfertaEconomicaPER'] as $keyOferta => $rowOfertaPer){
            
            if($rowOfertaPer['estadoItem'] != '' || $rowOfertaPer['estadoItem'] != NULL){
                      $nomEstadoItem = $this->datos->traerNomEstadoItem($valuePER['estadoItem']);
                      $nomEstadoItemPER = $nomEstadoItem->nomEstado;
            
               
            }else{
                
                $nomEstadoItemPER = '';
            }
            
                $arreglo['OfertaEconomicaPER'][$keyOferta]["select_reg_per"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...',$rowOfertaPer["idCiudad"]);
                $arreglo['OfertaEconomicaPER'][$keyOferta]["select_bienServPer"] = $this->datos->armSelect($lista_bienServPer,'Seleccione Bien o Servicio...',$rowOfertaPer["idProductoPER"]);
                $arreglo['OfertaEconomicaPER'][$keyOferta]["cantidadPER"] = $rowOfertaPer["cantidad"];
                $arreglo['OfertaEconomicaPER'][$keyOferta]["precioUnidadPer"] = $rowOfertaPer["precioUnidad"];
                $arreglo['OfertaEconomicaPER'][$keyOferta]["precioUniTotalPer"] = $rowOfertaPer["precioUniTotal"];
                $arreglo['OfertaEconomicaPER'][$keyOferta]["disabledPer"] = $rowOfertaPer["disabledPer"];
                $arreglo['OfertaEconomicaPER'][$keyOferta]["estadoCanPER"] = $nomEstadoItemPER;
                
              if($rowOfertaPer["estadoOfe"]=="707" && $rowOfertaPer["fechaModificacion"] == null){
                    $arreglo['OfertaEconomicaPER'][$keyOferta]["disabledPer"] = "";
                }else{            
                    $arreglo['OfertaEconomicaPER'][$keyOferta]["disabledPer"] = "disabled";
                }
                
              if($rowOfertaPer["estadoOfe"]=="707" && $rowOfertaPer["fechaModificacion"] != null){
                    $arreglo['OfertaEconomicaPER'][$keyOferta]["disabledPer"] = "";
                }else{  
                    $arreglo['OfertaEconomicaPER'][$keyOferta]["disabledPer"] = "disabled";
                }
             
        }
        
        
        foreach($arreglo['OfertaEconomicaASEO'] as $keyOferta => $rowOfertaAseo){
                
            if($rowOfertaAseo['estadoItem'] != '' || $rowOfertaAseo['estadoItem'] != NULL){
                
                      $nomEstadoItem = $this->datos->traerNomEstadoItem($rowOfertaAseo['estadoItem']);
                      $nomEstadoItemASEO = $nomEstadoItem->nomEstado;            
               
            }else{
                
                $nomEstadoItemASEO = '';
            }
                
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["select_reg_aseo"] = $this->datos->armSelect($lista_region,'Seleccione La Ciudad...',$rowOfertaAseo["idCiudad"]);
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["select_aseo"] = $this->datos->armSelect($lista_cant,'Seleccione Bien o Servicio...',$rowOfertaAseo["idProductoASEO"]);
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["cantidadASEO"] = $rowOfertaAseo["cantidad"];
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["precioUnidadAseo"] = $rowOfertaAseo["precioUnidad"];
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["precioUniTotalAseo"] = $rowOfertaAseo["precioUniTotal"];
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["disabledAseo"] = $rowOfertaAseo["disabledAseo"];
                $arreglo['OfertaEconomicaASEO'][$keyOferta]["estadoCanASEO"] = $nomEstadoItemASEO;
                
                
               
                /*if($rowOfertaAseo["estadoOfe"]=="En Desarrollo" && $rowOfertaAseo["fechaModificacion"] == null){
                    $arreglo['OfertaEconomicaASEO'][$keyOferta]["disabledAseo"] = "";
                }else{            
                    $arreglo['OfertaEconomicaASEO'][$keyOferta]["disabledAseo"] = "disabled";
                }*/
                
                if($rowOfertaAseo["estadoOfe"]=="707" && $rowOfertaAseo["fechaModificacion"] != null){
                    $arreglo['OfertaEconomicaASEO'][$keyOferta]["disabledAseo"] = "";
                }else{  
                    $arreglo['OfertaEconomicaASEO'][$keyOferta]["disabledAseo"] = "disabled";
                }
                
                
        }
        
        $arreglo["disabled"] = "disabled";
        //$arreglo['titulo_tabla'] = "EDITAR OFERTA COMERCIAL "; //. strtoupper($arreglo['datosProductos']->nombre);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
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
            
            

            if(isset($valueSubTotal->ivasi) == 'si'){
                
                $valIva = 1.19;
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;                
                $totalPrecio = $totalPrecio * $valIva;
                
            }else{
                
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;
            }
            
            
            if(isset($valueSubTotal->ivaPersi) == 'si' && isset($valueSubTotal->aiusi) == 'si'){
                
                $valIva = 19;
                $valAiu = 10;
                        
                $valIva = $valIva/100;                
                $valAiu = $valAiu/100;
                
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;
                
                $totalPrecioAiu = $totalPrecio * $valAiu;
                $totalPrecioIva = $totalPrecioAiu * $valIva;
                
                $totalPrecio = $totalPrecio + $totalPrecioAiu + $totalPrecioIva;
                
                
            }elseif(isset($valueSubTotal->ivaPersi) == 'si' && isset($valueSubTotal->aiusi) != 'si'){
                
                
                $valIva = 1.19;
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;                
                $totalPrecio = $totalPrecio * $valIva;                                
                
            }elseif(isset($valueSubTotal->ivaPersi) != 'si' && isset($valueSubTotal->aiusi) == 'si'){
                
                $valAiu = 10;
                $valAiu = $valAiu/100;
                
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;
                
                $totalPrecioAiu = $totalPrecio * $valAiu;     
                
                $totalPrecio = $totalPrecio + $totalPrecioAiu;
                
            }
                
                
                
            if(isset($valueSubTotal->ivaAseosi) == 'si'){
                
                $valIva = 1.19;
                $totalPrecio = $valueSubTotal->precio * $valueSubTotal->cantidad;                
                $totalPrecio = $totalPrecio * $valIva;            
                
                
                
            }
             
            
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
    
    function guardarOfertaEconomica($arreglo){
        
        $OfertaEconomicaAIU = json_decode($arreglo["OfertaEconomicaAIU"],true);
        $OfertaEconomicaPERSONAL = json_decode($arreglo["OfertaEconomicaPERSONAL"],true);
        $OfertaEconomicaASEO = json_decode($arreglo["OfertaEconomicaASEO"],true);
        
	if($arreglo['opcion']=="editar"){
            
            
            //Guadro encabezado de la oferta
            $estadoOfertaDesa = $this->datos->traerIDEstadoOfertaDesa();
            $idSerEspe = $this->datos->traerIdServEspeciales();
            $idPersonal = $this->datos->traerIdPersonal();
            $idBienesAseo = $this->datos->traerIdBienesAseo();
            $arreglo["estadoOfertaDesa"] = $estadoOfertaDesa->id;
            $arreglo["avance"] = 20;
            $arreglo["IdCatAIU"] = $idSerEspe->idSerEspe;
            $arreglo["IdCatPER"] = $idPersonal->idPersonal;
            $arreglo["IdCatASEO"] = $idBienesAseo->idBienesAseo;
            $listaIdsFormatos = "";
            
//            
//            foreach ($datosDetOferta as $key => $valueDet) {
//                
//                
//                
//            }
//            $estadoItemAIU = $this->datos->traerEstadoOfeItem($arreglo["idOfe"],$idSerEspe->idSerEspe);
//            echo'<pre>';print_r($estadoItemAIU);echo'</pre>';
//            $estadoItemPER = $this->datos->traerEstadoOfeItem($arreglo["idOfe"],$idPersonal->idPersonal);
//            $estadoItemASEO = $this->datos->traerEstadoOfeItem($arreglo["idOfe"],$idBienesAseo->idBienesAseo);
            $this->datos->actualizarProductosOfer($arreglo);
            
            
            
            $this->datos->eliminarDesOferta($arreglo["idOfe"]);
            foreach ($OfertaEconomicaAIU as $key => $valueAiu){
                
                //echo'<pre>';print_r($OfertaEconomicaAIU);echo'</pre>';
                
                $idProductoAiu = $valueAiu["bienServ"];
                $this->datos->insertarOfertaDes($valueAiu,$valueAiu["idOferta"],$idProductoAiu,710);
                 
            }
            
            foreach ($OfertaEconomicaPERSONAL as $key => $valuePer) {

                    $idProductoPer = $valuePer["bienServ_per"];
                    $this->datos->insertarOfertaDes($valuePer,$valuePer["idOferta"],$idProductoPer,710);
            
                
            }
            
            foreach ($OfertaEconomicaASEO as $key => $valueAseo){
                
               $idProductoAseo = $valueAseo["bienServ_aseo"];
               $this->datos->insertarOfertaDes($valueAseo,$arreglo["idOfe"],$idProductoAseo,710);
                
                
            }
            
            
	}else{
            
            $estadoOferta = $this->datos->traerIDEstadoOferta();
            $arreglo["avance"] = '10';
            $arreglo["estadoOferta"] = $estadoOferta->id;
            
            $idSerEspe = $this->datos->traerIdServEspeciales();
            $idPersonal = $this->datos->traerIdPersonal();
            $idBienesAseo = $this->datos->traerIdBienesAseo();
             
                $originalDate = $arreglo["feIni"];
                $origDate = $arreglo["feFin"];
                
                $arreglo["feIni"] = date("Y-m-d", strtotime($originalDate));
                $arreglo["feFin"] = date("Y-m-d", strtotime($origDate));
                
             $idOfertaEcono = $this->datos->insertarOferta($arreglo);
             $arreglo["idOfertaEconomica"] = $idOfertaEcono;
            
            foreach ($OfertaEconomicaAIU as $key => $valueAiu) {
                  //$idDetProducto = $this->datos->traerIdDetProd($valueAiu["bienServ"]);
                  $idProducto = $valueAiu["bienServ"];
                  $this->datos->insertarOfertaDes($valueAiu,$arreglo["idOfertaEconomica"],$idProducto,710);
            }
            
            foreach ($OfertaEconomicaPERSONAL as $key => $valuePer) {
                  //$idDetProducto = $this->datos->traerIdDetProd($valuePer["bienServ_per"]);
                  //$arreglo["idDetProductoPer"] = $idDetProducto->id;
                  $idProductoPer = $valuePer["bienServ_per"];
                  $this->datos->insertarOfertaDes($valuePer,$arreglo["idOfertaEconomica"],$idProductoPer,710);
            }
            
            foreach ($OfertaEconomicaASEO as $key => $valueAseo) {
                  //$idDetProducto = $this->datos->traerIdDetProd($valueAseo["bienServ_aseo"]);
                  $idProductoAseo = $valueAseo["bienServ_aseo"];
                  $this->datos->insertarOfertaDes($valueAseo,$arreglo["idOfertaEconomica"],$idProductoAseo,710);
            }
            
	}
        
	$this->mostrarOfertaEconomica($arreglo);
    }    
    
    function traerCiudad($arreglo){
        
      $nomCiu = $this->datos->traerNombreCiu($arreglo);
        
    if(isset($nomCiu->nombre)){
            echo $nomCiu->nombre;
        }else{
            echo "";
        } 
    }
    
    function generarOrdenCompra($arreglo){
        
        $cantAIU = json_decode($arreglo["cantidadAIU"],TRUE);
        $cantPER = json_decode($arreglo["cantidadPER"],TRUE);
        $cantASEO = json_decode($arreglo["cantidadASEO"],TRUE);
        
        //TRAIGO ESTADOS DEL PRODUCTO
        $estadoDisPro = $this->datos->traerIdEstadoDisProd();
        //TRAIGO ID ESTADO ITEM NO DISPONIBLE
        $idCanNoDispo = $this->datos->traerEstadoItem();
        
        //CALCULO CANTIDAD CATEGORIA SERVICIOS ESPECIALES(AIU)        
        foreach ($cantAIU as $keyAIU => $valuecantAIU){
            
            $cantidadAIU = $valuecantAIU['valorCant'];
            $idProductoAIU = $valuecantAIU['idProducto'];
            
             $canDisAIU = $this->datos->calcularCantidad($idProductoAIU,$estadoDisPro->idEstadoDisProd);
             $nomProducto = $this->datos->traerNombreProd($idProductoAIU);
            
               //VALIDO CANTIDAD INGRESADA             
                if($canDisAIU->cantDispo > 0){
                    
                    $canDisProAIU = $canDisAIU->cantDispo;
                       
                       $totalCanAIU = $canDisProAIU - $cantidadAIU;
                       
                         // VALIDO EL RESULTADO DE LA RESTA, DE SER POSITIVO ACTUALIZO ESTADO DEL PRODUCTO
                                if($totalCanAIU >= 0){
                                    
                                    $estadoProd = 'Ofertado';
                                    $idEstadoNuevoProd = $this->datos->traerIDEstadoProd($estadoProd);
                                    $arreglo["idEstOfertado"] = $idEstadoNuevoProd->id;
                                    
                                    $arreglo["cantActualizarAIU"][$keyAIU]["actualizarAiu"]  = $this->datos->traerIdDetProd($valuecantAIU['idProducto'],$estadoDisPro->idEstadoDisProd,$cantidadAIU);
                                                                                 
                                      
                                }else{
                                    
                                    $this->datos->actualizaEstadoItem($valuecantAIU['idOferta'],$idProductoAIU,$idCanNoDispo->idEstadoItem);
                                }
                    
                }
              
        }
        
        //CALCULO CANTIDAD CATEGORIA PERSONAL
        foreach ($cantPER as $keyPER => $valuecantPER){
            
            $cantidadPER = $valuecantPER['valorCant'];
            $idProductoPER = $valuecantPER['idProducto'];
            
             $canDisPER = $this->datos->calcularCantidad($idProductoPER,$estadoDisPro->idEstadoDisProd);
             $nomProductoPer = $this->datos->traerNombreProd($idProductoPER);
            
               //VALIDO CANTIDAD INGRESADA
             
                if($canDisPER->cantDispo > 0){
                    
                    $canDisProPER = $canDisPER->cantDispo;
                       
                       $totalCanPER = $canDisProPER - $cantidadPER;
                       
                         // VALIDO EL RESULTADO DE LA RESTA, DE SER POSITIVO ACTUALIZO ESTADO DEL PRODUCTO
                               
                        if($totalCanPER >= 0){
                                    
                                    $estadoProd = 'Ofertado';
                                    $idEstadoNuevoProd = $this->datos->traerIDEstadoProd($estadoProd);
                                    $arreglo["idEstOfertado"] = $idEstadoNuevoProd->id;
                                    
                                    $arreglo["cantActualizarPER"][$keyPER]["actualizarPer"] = $this->datos->traerIdDetProd($valuecantPER['idProducto'],$estadoDisPro->idEstadoDisProd,$cantidadPER);
                                        
                                                                        
                                }else{
                                    
                                    $this->datos->actualizaEstadoItem($valuecantPER['idOferta'],$idProductoPER,$idCanNoDispo->idEstadoItem);
                                }
                       
                }
              
        }
        
        //CALCULO CANTIDAD CATEGORIA BIENES DE ASEO Y CAFETERIA
        foreach ($cantASEO as $keyASEO => $valuecantASEO){
            
            $cantidadASEO = $valuecantASEO['valorCant'];
            $idProductoASEO = $valuecantASEO['idProducto'];
            
             $canDisASEO = $this->datos->calcularCantidad($idProductoASEO,$estadoDisPro->idEstadoDisProd);
             $nomProductoAseo = $this->datos->traerNombreProd($idProductoASEO);
            
               //VALIDO CANTIDAD INGRESADA
               
                if($canDisASEO->cantDispo > 0){
                    
                    $canDisProASEO = $canDisASEO->cantDispo;
                       
                       $totalCanASEO = $canDisProASEO - $cantidadASEO;
                        
                         // VALIDO EL RESULTADO DE LA RESTA
                                if($totalCanASEO >= 0){
                                    
                                    $estadoProd = 'Ofertado';
                                    $idEstadoNuevoProd = $this->datos->traerIDEstadoProd($estadoProd);
                                    $arreglo["idEstOfertado"] = $idEstadoNuevoProd->id;
                                    
                                    $arreglo["cantActualizarASEO"][$keyASEO]["actualizarASEO"] = $this->datos->traerIdDetProd($valuecantASEO['idProducto'],$estadoDisPro->idEstadoDisProd,$cantidadASEO);
                                    //$this->datos->actualizaEstadoItem($valuecantASEO['idOferta'],$idProductoASEO,710);
                                     
                                }else{
                                    
                                    $this->datos->actualizaEstadoItem($valuecantASEO['idOferta'],$idProductoASEO,$idCanNoDispo->idEstadoItem);
                                }
                    
                }
        }
        
        $arreglo["cantNoDis"]["idEstadoItem"] = $idCanNoDispo->idEstadoItem;
          
        $this->verCantidad($arreglo);
        
        
    }
    
    function verCantidad($arreglo){
        
        $arreglo["titulo"] = 'CANTIDADES FALTANTES';
        $cantidadNoDispo = $arreglo["cantNoDis"]["idEstadoItem"];
        $canNoDisponible = $this->datos->traerProductosNoDispo($cantidadNoDispo,$arreglo["idOfe"]);
        $estadoDisPro = $this->datos->traerIdEstadoDisProd();
        
        $conArreglo = count($canNoDisponible);
       if($conArreglo > 0){
         
        foreach ($canNoDisponible as $key => $valueNoDis) {
            
            $idProducto = $valueNoDis['idProducto'];
            $nomProducto = $this->datos->traerNombreProd($idProducto);
            $canDis = $this->datos->calcularCantidad($idProducto,$estadoDisPro->idEstadoDisProd);
            
            $cantidadFalta = $valueNoDis['cantidad'] - $canDis->cantDispo;
            
            $arreglo["cantNo"][$key]["nombreProducto"] = $nomProducto->nombre;
            $arreglo["cantNo"][$key]["cantidadProducto"] = $cantidadFalta;          
            
            
        }
        
        $this->vista->verCantidad($arreglo);
        
       }else{
           
            foreach ($arreglo["cantActualizarAIU"] as $key => $valueAIU){
                  
                foreach ($valueAIU["actualizarAiu"] as $key => $valueAi) {
                    
                    //ACTUALIZO EL VALOR A DISPONIBLE DEL PRODUCTO EN EL DETALE
                 $this->datos->actualizaCantidadDetProd($valueAi['idDetProd'],$arreglo["idEstOfertado"]);
                 
                }
                 
                                       
            }
            
            foreach ($arreglo["cantActualizarPER"] as $key => $valuePer){
                 
                foreach ($valuePer["actualizarPer"] as $key => $valuePe) {
                    
                    //ACTUALIZO EL VALOR A DISPONIBLE DEL PRODUCTO EN EL DETALE
                   $this->datos->actualizaCantidadDetProd($valuePe['idDetProd'],$arreglo["idEstOfertado"]);
                 
                }
                 
                                           
            }
              
            
            foreach ($arreglo["cantActualizarASEO"] as $key => $valueAseo){
                
                foreach ($valueAseo["actualizarASEO"] as $key => $valueAS) {
                    
                    //ACTUALIZO EL VALOR A DISPONIBLE DEL PRODUCTO EN EL DETALE
                   $this->datos->actualizaCantidadDetProd($valueAS["idDetProd"],$arreglo["idEstOfertado"]);
                
                   
                }
               
                 
                                           
            }
         
          $this->vista->crearOrdenCompra($arreglo);
           
       }
       
       
    }
    
    function generarOrden($arreglo){
        
        
        
        
        //Validar el estado disponible
        $nomEstadoItemOK  = $this->datos->traerIdEstadoItemOK();
        $idEstadoEnUso  = $this->datos->traerIdEstadoUso();
        $idEstadoOfertado = $this->datos->traerIdEstadoOferProd();
        $idEstadoOfertaEco = $this->datos->traerIdEstadoOferOK();
        
        //ACTUALIZO ESTADO ITEM OFERTA OK
        $this->datos->actualizaEstadoItemOK($arreglo["idOfe"],$nomEstadoItemOK->nomEstado);
        
        //ACTUALIZO ESTADO OFERTA
        $this->datos->actualizaEstadoOfertaCom($arreglo["idOfe"],$idEstadoOfertaEco->idEstadoOfOk);
        $ofertaEconomica = $this->datos->datosOfertaEconomica($arreglo["idOfe"]);
        
        $idDetProductoOfertado = $this->datos->traerIdDetProUso($arreglo["idOfe"],$idEstadoOfertado->idEstadoOferProd);
        
       
       /* 
        $idDetProductoEnUso = $this->datos->traerIdDetProUso($arreglo["idOfe"],$idEstadoOfertado->idEstadoOferProd);
        
        
        //ACTUALIZO ESTADO PRODUCTO
        foreach ($idDetProductoEnUso as $key => $valueProdOrden) {
            
            $this->datos->actualizaCantidadDetProd($valueProdOrden["idDetalle"],$idEstadoEnUso->idEnUso);
        }
           
        $idDetProducto = $this->datos->traerIdDetProUso($arreglo["idOfe"],$idEstadoEnUso->idEnUso);*/
        
        //INSERTO ENCABEZADO        
        $idOrdenCompra = $this->datos->insertarOrdenCompra($ofertaEconomica,$arreglo["idOfe"]);
        
        //INSERTO DETALLE
        foreach ($idDetProductoOfertado as $key => $valueDetOfe) {
            
            $this->datos->insertarOrdenDes($valueDetOfe["idDetalle"],$idOrdenCompra);
            
        }
        
        $this->mostrarOfertaEconomica($arreglo);
        
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
    
    function crearEvento($arreglo){
        
         
        $lista_evento = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'EstadoEvento' ORDER BY id ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_evento,'Seleccione Estado...');
        
        $arreglo["evento"][0]["disabled"] = 'disabled';
        $arreglo["evento"][0]["idOferta"] = $arreglo["id"];
        $arreglo["evento"][0]["calendario"] = "";
        
        
        $this->vista->crearEvento($arreglo);
        
        
    }  
    
    
    function guardarEvento($arreglo){
        
        
     
        if($arreglo["calendario"] != 'calendario'){
        
            
             $evento = json_decode($arreglo["evento"],true);
             $idOferta = $evento[0]["oferta"];
               
                foreach ($evento as $key => $value){
                    
                       $value["fechaInicio"] =  date("Y-m-d", strtotime($value["fechaInicio"])); 
                       $value["fechaFin"] =  date("Y-m-d", strtotime($value["fechaFin"])); 
                       
                       $this->datos->insertarEvento($value,$idOferta);
                       
                
            }
            
        }else{
            
               if($arreglo["opcion"] == "editar"){
                   
                   $this->datos->actualizarEvento($arreglo);
                   
               }else{
               
                        $arreglo["fechaInicio"] =  date("Y-m-d", strtotime($arreglo["fechaInicio"])); 
                        $arreglo["fechaFin"] =  date("Y-m-d", strtotime($arreglo["fechaFin"])); 
                        $idOferta = 0;
                        $this->datos->insertarEvento($arreglo,$idOferta);
                    }    
            
            
        }
        
    }   
    
    function guardarEventoInicio($arreglo){
        
        
         $this->datos->insertarEventoInicio($arreglo);
                    
       
        
    }    
    
    /*function eliminarOfertaEconomica($arreglo){       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->eliminarOfertaEconomica($arreglo["id"]);
        $this->datos->eliminarDesOferta($arreglo["id"]);
        $this->mostrarOfertaEconomica($arreglo);
    } */       
    
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
                
            $nombreCli = $this->datos->retornarNombreCliente($row['idCliente']);
            $nombreActa = $this->datos->retornarNombreActa($row['actaLiquidacion']);
            $nombreCert = $this->datos->retornarNombreCert($row['certificacion']);
            $nombreEstado = $this->datos->retornarNombreEstado($row['estado']);
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            //$data['page_data'][$key]['id'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OfertaEconomica&method=verOfertaEconomica&id={$row['id']}\" >{$row['id']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);
            
            $ver = "";
            
            if($permisos->crear=="SI"){
                $ver ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=editarOfertaEconomica&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/detalle5.png\" title=\"Ver Detalle Orden Compra\" width=\"25\" height=\"25\" border=\"0\" /></a>";
               // $ver ="<a href=\"javascript:void(0)\" onclick=\"editarOfertaEconomica('{$row['id']}','{$row['id']}')\"  ><img src=\"imagenes/iconos/mis/editar.png\" title=\"Editar Oferta Comercial\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }
            
             $data['page_data'][$key]['cliente'] = $nombreCli->nombre;
             $data['page_data'][$key]['actaLiquidacion'] = $nombreActa->valor;
             $data['page_data'][$key]['certificacion'] = $nombreCert->valor;
             $data['page_data'][$key]['estado'] = $nombreEstado->nomEstado;
            
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

