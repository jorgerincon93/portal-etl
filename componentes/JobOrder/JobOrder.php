<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




require_once COMPONENTS_PATH . 'JobOrder/vista/vistaJobOrder.php';
include_once COMPONENTS_PATH . 'JobOrder/modelo/datosJobOrder.php';

class JobOrder {

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
        $this->datos = new DatosJobOrder();
        $this->vista = new VistaJobOrder($this->datos);
    }

    public function mostrarJobOrder($arreglo) {
        /**
         * Muestra los usuarios del aplicativo
         */
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];
        if (isset($arreglo["idResumenJob"])) {
            $permisos->idResumenJob = $arreglo["idResumenJob"];
        }
        
        $idPadre = $this->datos->datosUsuario($_SESSION["datos_logueo"]["idUsuario"]);
        $tipoUs =  $this->datos->tipoUsr($idPadre->id);
          if(isset($idPadre->id,$tipoUs->nombre)){
               $this->datos->crearVistaRjobUsuario($idPadre->id,$tipoUs->nombre);
               
          }       
        //$permisos->idOrdenCompra = 10;
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';

        $this->vista->mostrarJobOrder($permisos);
    }

    function verCliente($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $listaCliente = $this->datos->mostrarCliente($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
        $this->vista->verCliente($listaCliente);
    }

    function verJobOrder($id){        
       //echo'<pre>';print_r($id);echo'</pre>';
        $this->vista->verJobOrder($id["id"]);
    }
    
    function agregarJobOrder($arreglo) {

        $arreglo["opcion"] = "agregar";
        
        $lista_clientes = $this->datos->build_list('clientes', 'id', 'nombre', "WHERE estado='Activo' ORDER BY nombre ");
        $arreglo['select_cliente'] = $this->datos->armSelect($lista_clientes, 'Seleccione el Cliente...');

        $lista_areaMet = $this->datos->build_list('geo.areametropolitana', 'id', 'AreaMetropolitana', " ORDER BY AreaMetropolitana ");
        $arreglo['select_areaMet'] = $this->datos->armSelectMultiple($lista_areaMet);

        $lista_frecuencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Frecuencia' ORDER BY valor ");
        $arreglo['select_frecuencia'] = $this->datos->armSelect($lista_frecuencia, 'Seleccione Frecuencia...');
        
        $lista_cantFrecuencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='CantidadFrecuencia' ORDER BY id ");
        $arreglo['select_cantFrecuencia'] = $this->datos->armSelect($lista_cantFrecuencia, 'Seleccione Cantidad Frecuencia...');
        
        $lista_ciclo = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Ciclo' ORDER BY valor ");
        $arreglo['select_ciclo'] = $this->datos->armSelect($lista_ciclo, 'Seleccione Ciclo...');

        $lista_anios = $this->retornarAnios(10);
        $arreglo['select_anio'] = $this->datos->armSelect($lista_anios, 'Seleccione Año...');

        $lista_estudio = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='TipoEstudio' ORDER BY valor ");
        $arreglo['select_estudio'] = $this->datos->armSelect($lista_estudio, 'Seleccione Estudio...');

        $lista_categorias = $this->datos->build_list('item.categoria', 'id', 'nombreCategoria', " ORDER BY nombreCategoria ");
        $arreglo['select_categoria'] = $this->datos->armSelect($lista_categorias,'Seleccione Categoria...');
        
        $lista_canal = $this->datos->build_list('item.canal', 'id', 'canal', " ORDER BY canal ");
        $arreglo['select_canal'] = $this->datos->armSelectMultiple($lista_canal);
        
        $arreglo['select_herencia'] = $this->datos->armSelect(array(),'Heredar de...');
        
        
        $arreglo['formatosMedicion'][0] = array();
        $arreglo['formatosMedicion'][0]["select_categoria"] = $this->datos->armSelect($lista_categorias,'Seleccione Categoria...');
        $arreglo['formatosMedicion'][0]["select_canal"] = $this->datos->armSelectMultiple($lista_canal);
        $arreglo['formatosMedicion'][0]["select_anio"] = $this->datos->armSelect($lista_anios, 'Seleccione Año...');
        $arreglo['formatosMedicion'][0]["select_ciclo"] = $this->datos->armSelect($lista_ciclo, 'Seleccione Ciclo...');
        $arreglo['formatosMedicion'][0]["select_estudio"] = $this->datos->armSelect($lista_estudio,'Seleccione Estudio...');
        $arreglo['formatosMedicion'][0]["select_areaMet"] = $this->datos->armSelectMultiple($lista_areaMet);
        //$arreglo['formatosMedicion'][0]["select_municipios"] = $this->datos->armSelectMultiple($lista_municipios);
        $arreglo['formatosMedicion'][0]["select_frecuencia"] = $this->datos->armSelect($lista_frecuencia,'Seleccione Frecuencia...');
        $arreglo['formatosMedicion'][0]['select_cantFrecuencia'] = $this->datos->armSelect($lista_cantFrecuencia, 'Seleccione Cantidad Frecuencia...');
        $arreglo['formatosMedicion'][0]["select_herencia"] = $this->datos->armSelect(array(),'Heredar de...');
        $arreglo['formatosMedicion'][0]["tipo_estudio"] = "";
        //echo'<pre>';print_r($arreglo['formatosMedicion']);echo'</pre>';
        
        $arreglo['titulo'] = "CREAR RESUMEN JOB ORDER";
        $arreglo['datosResumenJob']['asesor'] = $_SESSION['datos_logueo']['nombre'];
        $arreglo['datosResumenJob']['idAsesor'] = $_SESSION['datos_logueo']['idUsuario'];
        $fechaSis = $this->retornarFechaSistemaResumenJob();
        $arreglo['datosResumenJob']['fechaSis'] = $fechaSis;
        
        $this->vista->agregarJobOrder($arreglo);
    }

    function editarJobOrder($arreglo) {
          
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo["id"]);
        $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        
        //$arreglo['areaMetro'] = $this->datos->traerAreaMet($arreglo['datosFormatoMedicion']->id);
        //$nombreCiudad = $this->traerCentroPoblado($arreglo["id"]);
        //$arreglo['datosFormatoMedicion']->ciudad = implode(' - ', $nombreCiudad);        
        
        $datosUsuario = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosResumenJob']->asesor = $datosUsuario->nombre;
        $arreglo['datosResumenJob']->idAsesor = $_SESSION['datos_logueo']['idUsuario'];        
        
        $fechaSis = $this->retornarFechaSistemaResumenJob();
        
        $datoCliente = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
         
        $lista_clientes = $this->datos->build_list('clientes', 'id', 'nombre', "WHERE estado='Activo' ORDER BY nombre ");
        $arreglo['select_cliente'] = $this->datos->armSelect($lista_clientes, 'Seleccione el Cliente...',$arreglo['datosResumenJob']->idCliente);
        
        $lista_frecuencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Frecuencia' ORDER BY valor ");
        $arreglo['select_frecuencia'] = $this->datos->armSelect($lista_frecuencia, 'Seleccione Frecuencia...');
        
        $lista_canal = $this->datos->build_list('item.canal', 'id', 'canal', " ORDER BY canal ");
        $arreglo['select_canal'] = $this->datos->armSelectMultiple($lista_canal);
        
        $lista_anios = $this->retornarAnios(10);
        $arreglo['select_anio'] = $this->datos->armSelect($lista_anios, 'Seleccione Año...');
        
        $lista_ciclo = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Ciclo' ORDER BY valor ");
        $arreglo['select_ciclo'] = $this->datos->armSelect($lista_ciclo, 'Seleccione Ciclo...');
        
        $lista_estudio = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='TipoEstudio' ORDER BY valor ");
        $arreglo['select_estudio'] = $this->datos->armSelect($lista_estudio, 'Seleccione Estudio...');
        
        $lista_cantFrecuencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='CantidadFrecuencia' ORDER BY id ");
        $arreglo['select_cantFrecuencia'] = $this->datos->armSelect($lista_cantFrecuencia, 'Seleccione Cantidad Frecuencia...');
        
        $lista_areaMet = $this->datos->build_list('geo.areametropolitana', 'id', 'areaMetropolitana', " ORDER BY areaMetropolitana ");
        $arreglo['select_areaMet'] = $this->datos->armSelectMultiple($lista_areaMet);
        
        //$lista_municipios = $this->datos->build_list('geo.centropoblado', 'idCentroPoblado', 'centroPoblado', " WHERE idCabeceraMunicipal IN (" . $arreglo["areaMet"] . ") ORDER BY centroPoblado ");
        //$lista_municipios = $this->datos->build_list('geo.centropoblado', 'idCentroPoblado', 'centroPoblado', "  ORDER BY centroPoblado ");
         
        $arreglo['datosResumenJob']->fechaSis = $fechaSis;
        $arreglo['datosResumenJob']->nomCliente = $datoCliente->nombre;
        $arreglo['datosResumenJob']->nomcontCliente = $datoCliente->contacto;
        $arreglo['datosResumenJob']->telCliente = $datoCliente->telefono;
        $arreglo['datosResumenJob']->emailCliente = $datoCliente->email;
        $arreglo['datosResumenJob']->cliDisabled = "disabled";
        
        $formatosMedicion = $this->datos->selectFormatosMedicion($arreglo['id']);
        $arreglo['formatosMedicion']=$formatosMedicion;
        
        $lista_categorias = $this->datos->build_list('item.categoria', 'id', 'nombreCategoria', " ORDER BY nombreCategoria ");
        $arreglo['select_categoria'] = $this->datos->armSelect($lista_categorias,'Seleccione Categoria...');
        
        foreach($arreglo['formatosMedicion'] as $keyFormato => $rowFormato){
          
            $canal = $this->traerCanal($rowFormato["id"]);
//            $ciclo = $this->traerCiclo($rowFormato["id"]);
            $areaMet = $this->traerAreaMet($rowFormato["id"]);
            //echo'<pre>';print_r($areaMet);echo'</pre>';
            $ciudad = $this->traerCentroPoblado($areaMet);
            // echo'<pre>';print_r($rowFormato);echo'</pre>';
                       
            $arreglo['formatosMedicion'][$keyFormato]["select_categoria"] = $this->datos->armSelect($lista_categorias,'Seleccione Categoria...',$rowFormato["idCategoria"]);
            $arreglo['formatosMedicion'][$keyFormato]["select_canal"] = $this->datos->armSelectMultiple($lista_canal,$canal);
            $arreglo['formatosMedicion'][$keyFormato]["select_anio"] = $this->datos->armSelect($lista_anios,'Seleccione Año...',$rowFormato["anio"]);
            $arreglo['formatosMedicion'][$keyFormato]["select_ciclo"] = $this->datos->armSelect($lista_ciclo,'Seleccione Ciclo...',$rowFormato["ciclo"]);
            $arreglo['formatosMedicion'][$keyFormato]["select_estudio"] = $this->datos->armSelect($lista_estudio,'Seleccione Estudio...',$rowFormato["tipoEstudio"]);
            $arreglo['formatosMedicion'][$keyFormato]["select_areaMet"] = $this->datos->armSelectMultiple($lista_areaMet,$areaMet);
            $arreglo['formatosMedicion'][$keyFormato]["ciudad"] = $ciudad;
            $arreglo['formatosMedicion'][$keyFormato]["select_frecuencia"] = $this->datos->armSelect($lista_frecuencia,'Seleccione Frecuencia...',$rowFormato["frecuencia"]);
            $arreglo['formatosMedicion'][$keyFormato]["select_cantFrecuencia"] = $this->datos->armSelect($lista_cantFrecuencia,'Seleccione Cantidad Frecuencia...',$rowFormato["cantidadFrecuencia"]);
            $arreglo['formatosMedicion'][$keyFormato]["tipo_estudio"] = $rowFormato["tipoEstudio"];
            $arreglo['formatosMedicion'][$keyFormato]["select_herencia"] = $this->armarListaHerenciaEditar($arreglo['datosResumenJob']->idCliente,$rowFormato["idCategoria"]);            
            
            
            
            $arreglo['formatosMedicion'][$keyFormato]["tipo_estudio"] = $rowFormato["tipoEstudio"];
            
            
            if($rowFormato["estado"]=="Creado" && $rowFormato["fecha_ult_modificacion"] == null){
                $arreglo['formatosMedicion'][$keyFormato]["disabled"] = "";
            }else{            
                $arreglo['formatosMedicion'][$keyFormato]["disabled"] = "disabled";
            }            
        }
        
        // echo'<pre>';print_r($arreglo['formatosMedicion']);echo'</pre>';
        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "EDITAR RESUMEN JOB ORDER " . $arreglo['datosResumenJob']->id;
        
        $this->vista->agregarJobOrder($arreglo);
    }
    
    function verResumenJob($arreglo){
        
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo["id"]);
	$arreglo['formatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $formatoMedicionVer = $arreglo['formatoMedicion'];
        
        $datoCliente = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
        
        $datosOrden = $this->datos->datosOrden($arreglo['datosResumenJob']->id);
        
        $datosUsuario = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosResumenJob']->asesor = $datosUsuario->nombre;
		
	$fechaCreacion = $arreglo['datosResumenJob']->fechaCreacion;
        $fechaCreacion = date("d-m-Y",strtotime($fechaCreacion)); 
        $arreglo['datosResumenJob']->fechaCreacion = $fechaCreacion;
                
	$datoCliente = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
	$arreglo['datosResumenJob']->nomCliente = $datoCliente->nombre;
	
	$arreglo['datosResumenJob']->nomcontCliente = $datoCliente->contacto;
	$arreglo['datosResumenJob']->telCliente = $datoCliente->telefono;
	$arreglo['datosResumenJob']->emailCliente = $datoCliente->email;
        
    // Formato Medicion Seleccion Multiple// 
           $formatoMedicion = $this->datos->formatoMedicion($arreglo["id"]);
           $arreglo['verFormatosMedicion']=$formatoMedicion;
           //$verFormatosMedicion = $arreglo["verFormatosMedicion"];
        
        
    foreach($arreglo['verFormatosMedicion'] as $keyFormato => $rowFormato){
        
        $nombreCategoria = $this->datos->retornarNombreCategoriaJob($rowFormato["idCategoria"]);
        $areaMetro = $this->verAreaMet($rowFormato["id"]);
        $areaMet = $this->traerAreaMet($rowFormato["id"]);
        $ciudad = $this->traerCentroPoblado($areaMet);
        
            $arreglo['verFormatosMedicion'][$keyFormato]["nombreCategoria"]= $nombreCategoria->nombreCategoria;
            $arreglo['verFormatosMedicion'][$keyFormato]["ver_canal"] = $this->verCanal($rowFormato["id"]);
            $arreglo['verFormatosMedicion'][$keyFormato]["areaMetro"] = $areaMetro;
            $arreglo['verFormatosMedicion'][$keyFormato]["ciudad"] = $ciudad;            
            
            
            if($rowFormato["estado"]=="Creado" && $rowFormato["fecha_ult_modificacion"] == null){
                $arreglo['verFormatosMedicion'][$keyFormato]["disabled"] = "";
            }else{            
                $arreglo['verFormatosMedicion'][$keyFormato]["disabled"] = "disabled";
            }            
    }        

        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "DETALLE RESUMEN JOB " . $arreglo['datosResumenJob']->id;

        $this->vista->verJobOrder($arreglo);
    }

    function guardarOrden($arreglo) {

        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $formatosMedicion = json_decode($arreglo["formatosMedicion"]);
        //echo'<pre>';print_r($formatosMedicion);echo'</pre>';
        //$categorias = explode(',', $arreglo["categoria_array"]);
//        $cabecera = explode(',', $arreglo["area_met_array"]);
//        $centroPoblado = explode(',', $arreglo["municipio_array"]);
       
        if ($arreglo['opcion'] == "editar") {
            //$this->datos->actualizarCliente($arreglo);
            $listaIdsFormatos = "";            
            $idResumenJob = $arreglo["id"];
            $this->datos->actualizarResumenJobOrder($arreglo);
            
            foreach ($formatosMedicion as $keyForm => $rowForm) {
                
                if(isset($rowForm->ciclo)){
                    $rowForm->frecuencia = "";
                    $rowForm->cantFrecuencia = "";
                }else{                    
                    $rowForm->ciclo = "";
                }
                
                if($rowForm->id != NULL && $rowForm->id != ""){
                    $idFormatosMedicion = $rowForm->id;
                    $this->datos->actualizarFormatoMedicion($rowForm);
                }else{
                    $idFormatosMedicion = $this->datos->insertarFormatoMedicion($arreglo["id"], $rowForm);
                }
                
                
                
                if($rowForm->herencia > 0){
                    
                    $this->datos->borrarCopiaFormatoMedicion($idFormatosMedicion);
                    $this->datos->copiarFormatoMedicion($idFormatosMedicion, $rowForm->herencia);
                    
                    $registroFormatoCopia = $this->datos->traerFormatoMedicionRegistroCopia($idFormatosMedicion);
                    
                    foreach ($registroFormatoCopia as $keyCopia => $valueCopia) {
                        $idRegistroOrigen = $this->datos->traerInfoRegistroOrigen($rowForm->herencia,$valueCopia["orden"]);
                        $varMedicion = $this->datos->traerVarMedicion($idFormatosMedicion,$rowForm->herencia);
                        foreach ($varMedicion as $keyVarMed => $valueVarMed) {
                            $this->datos->copiarRegistroVariable($idRegistroOrigen->id,$valueCopia["id"],$valueVarMed["oriId"],$valueVarMed["copId"]);
                        }
                        
                    }
                }
                
//                if($rowForm->id != NULL && $rowForm->id != ""){
//                    $idFormatosMedicion = $rowForm->id;
//                    $this->datos->actualizarFormatoMedicion($rowForm);  
//                
//                }elseif(isset($rowForm->anio) && isset($rowForm->ciclo)){
//                          $rowForm->frecuencia = "";
//                }else{
//                     $rowForm->anio = "";
//                     $rowForm->ciclo = "";
//                }
                
                //$idFormatosMedicion = $this->datos->insertarFormatoMedicion($arreglo["id"], $rowForm);
                
                $listaIdsFormatos = $listaIdsFormatos . "," . $idFormatosMedicion;
                $listaIdsCanal = "";
                $listaIdsAreaMet = "";
                
                //CANALES
                foreach ($rowForm->canal as $keyCan => $rowCan) {
                    
                    $formatoMedCanal = $this->datos->consultarFormatoMedCanal($idFormatosMedicion, $rowCan);
                    
                    if(isset($formatoMedCanal->id)){
                        $idFormatoMedCanal = $formatoMedCanal->id;
                    }else{
                        $idFormatoMedCanal = $this->datos->insertarFormatoMedCanal($idFormatosMedicion, $rowCan);
                    }                    
                    $listaIdsCanal = $listaIdsCanal . "," . $idFormatoMedCanal;
                }                
                
                //AREA METROPOLITANA
                foreach ($rowForm->areaMet as $keyAreaMet => $rowAreaMet) {
                    
                    $formatoMedAreaMet = $this->datos->consultarFormatoMedAreaMet($idFormatosMedicion, $rowAreaMet);
                    
                    if(isset($formatoMedAreaMet->id)){
                        $idFormatoMedAreaMet = $formatoMedAreaMet->id;
                    }else{
                        $idFormatoMedAreaMet = $this->datos->insertarFormatoMedAreaMet($idFormatosMedicion, $rowAreaMet);
                    }                    
                    $listaIdsAreaMet = $listaIdsAreaMet . "," . $idFormatoMedAreaMet;
                }
                
                $listaIdsCanal = trim($listaIdsCanal,',');
                $this->datos->borrarFormatoMedCanal($idFormatosMedicion,$listaIdsCanal);
                $listaIdsAreaMet = trim($listaIdsAreaMet,',');
                $this->datos->borrarFormatoMedAreaMet($idFormatosMedicion,$listaIdsAreaMet);                
            }
            
            //BORRAR LOS FORMATOS ELIMINADOS
            $listaIdsFormatos = trim($listaIdsFormatos,',');
            $this->datos->limpiarTablasFormatoMedicion($arreglo["id"],$listaIdsFormatos);
            $this->datos->borrarFormatoMedicion($arreglo["id"],$listaIdsFormatos);                    
            
            $cantFormato = $this->datos->ContarFormatoMedicion($idResumenJob);
            $cantFormatos = $cantFormato->cantodadFormanto;
            $this->datos->actualizarCantidadFormatoMedicion($cantFormatos,$idResumenJob);
            
            
        } else {
            $arreglo["estado"] = "Creado";
            $arreglo["cantFormatos"] = count($formatosMedicion);
            $idResumenJob = $this->datos->insertarResumenJobOrder($arreglo);
            $this->datos->insertarOrdenCompra($idResumenJob,$arreglo);
            
            $arreglo["idResumenJob"] = $idResumenJob;
            
            foreach ($formatosMedicion as $keyForm => $rowForm) {
//                echo'<pre>';print_r($rowForm);echo'</pre>';
                if(isset($rowForm->anio) && isset($rowForm->ciclo)){
                   $rowForm->frecuencia = "";
                   $rowForm->cantFrecuencia = "";
                }else{                     
                     $rowForm->ciclo = "";
                }
                $idFormatosMedicion = $this->datos->insertarFormatoMedicion($idResumenJob, $rowForm);
                
                if($rowForm->herencia > 0){
                    $this->datos->copiarFormatoMedicion($idFormatosMedicion, $rowForm->herencia);
                    
                    $registroFormatoCopia = $this->datos->traerFormatoMedicionRegistroCopia($idFormatosMedicion);
                    
                    foreach ($registroFormatoCopia as $keyCopia => $valueCopia) {
                        $idRegistroOrigen = $this->datos->traerInfoRegistroOrigen($rowForm->herencia,$valueCopia["orden"]);
                        $varMedicion = $this->datos->traerVarMedicion($idFormatosMedicion,$rowForm->herencia);
                        foreach ($varMedicion as $keyVarMed => $valueVarMed) {
                            $this->datos->copiarRegistroVariable($idRegistroOrigen->id,$valueCopia["id"],$valueVarMed["oriId"],$valueVarMed["copId"]);
                        }
                        
                    }
                }
                
                
                foreach ($rowForm->canal as $keyCan => $rowCan) {
                    $idFormatoMedCanal = $this->datos->insertarFormatoMedCanal($idFormatosMedicion, $rowCan);
                }
                foreach ($rowForm->areaMet as $keyAreaMet => $rowAreaMet) {
                    $idFormatoMedAreaMet = $this->datos->insertarFormatoMedAreaMet($idFormatosMedicion, $rowAreaMet);
                }
            }
        }
        $this->vista->verFormatoMedicion($idResumenJob);
    }
    
    function eliminarCliente($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->inactivarCliente($arreglo["id"]);
        $this->mostrarJobOrder($arreglo);
    }

    function consultarCliente($arreglo) {
        $datoCliente = $this->datos->datosCliente($arreglo["idCliente"]);
        echo json_encode($datoCliente);
    }

    function retornarFechaSistemaResumenJob() {
        
        $fechaActual = date("d-m-Y");
        return $fechaActual;
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
    
    function consultarCategoria($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        $nombreCategoria = $this->datos->retornarNombreCategoriaJob($arreglo['cat']);
        echo $nombreCategoria->nombreCategoria;
    }
    
    function consultarSegmento($arreglo){
        
        $lista_segmentoDinamico = $this->armarListaSegmento($arreglo['cat']);        
        $select_segmento_dinamico = $this->datos->armSelect($lista_segmentoDinamico,'Seleccione Segmento...');
        
        echo $select_segmento_dinamico;
    }
    
    function ajaxListaJobOrder($arreglo) {
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];
        $idUsuario = $_SESSION["datos_logueo"]["idUsuario"];

        $ds = new dacapo($db_settings, null);

        $page_settings = array(
            "selectCountSQL" => "SELECT count(o.idResumenJob) as totalrows FROM vistaResumenJob_" . $idUsuario . " o ",
            "selectSQL" => "SELECT idResumenJob, estado, idUsuario,nombreUsuario,nombreCliente,idCliente,fechaCreacion FROM vistaResumenJob_" . $idUsuario ."", // CONFIGURE
            "page_num" => $arreglo['page_num'],
            "rows_per_page" => $arreglo['rows_per_page'],
            "columns" => $arreglo['columns'],
            "sorting" => isset($arreglo['sorting']) ? $arreglo['sorting'] : array(),
            "filter_rules" => isset($arreglo['filter_rules']) ? $arreglo['filter_rules'] : array()
        );

        $jfr = new jui_filter_rules($ds);
        $arreglo['debug_mode'] = isset($arreglo['debug_mode']) ? $arreglo | ['debug_mode'] : "yes";

        $jdg = new bs_grid($ds, $jfr, $page_settings, true);

        $data = $jdg->get_page_data();

        // data conversions (if necessary)
        //$data['page_data'][0]['idUsuario'] = str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
        foreach ($data['page_data'] as $key => $row) {


            //$usuarioNombreJob = $this->datos->retornarNombreUsuarioJob($row['idUsuario']);
            //$usuarioClienteJob = $this->datos->retornarNombreClienteJob($row['idCliente']);            
//            //$data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
//            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
//            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            $eliminar = "";
            if ($permisos->editar == "SI") {
                $editar = "<a href=\"javascript:void(0)\" onclick=\"editarJobOrder({$row['idResumenJob']})\"  ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Resumen Job\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }

            //$data['page_data'][$key]['idUsuario'] = $usuarioNombreJob->nombre;
            //$data['page_data'][$key]['idCliente'] = $usuarioClienteJob->nombre;
            

            //$data['page_data'][$key]['idOrdenCompra'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['idOrdenCompra']}&idMenu={$permisos->idMenu}\" >{$row['idOrdenCompra']}</a>";
            //$data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['idJobOrder'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['idJobOrder'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['idResumenJob'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verResumenJob&id={$row['idResumenJob']}&idMenu={$permisos->idMenu}\" >{$row['idResumenJob']}</a>";
            $data['page_data'][$key]['acciones'] = $editar . " " . $eliminar;
        }

        echo json_encode($data);
    }
    
    function traerCanal($idFormatoMedicion) {
        $arreglo = array();

        $canal = $this->datos->traerCanal($idFormatoMedicion);

        foreach ($canal as $key => $row) {
            array_push($arreglo, $row["id"]);
        }
        return $arreglo;
    }
    
    function traerCiclo($idFormatoMedicion) {
        $arreglo = array();

        $ciclo = $this->datos->traerCiclo($idFormatoMedicion);

        foreach ($ciclo as $key => $row) {
            array_push($arreglo, $row["ciclo"]);
        }
        return $arreglo;
    }

    function traerAreaMet($idFormatoMedicion) {
        $arreglo = array();

        $cabecera = $this->datos->traerAreaMet($idFormatoMedicion);

        foreach ($cabecera as $key => $row) {
            array_push($arreglo, $row["id"]);
        }
        return $arreglo;
    }
    
  function verCanal($canales) {
        $arreglo = array();
        
        if(is_array($canales)){
            $textoCanal = implode(",",$canales);
        }else{
            $textoCanal = $canales;
        }        
        $canal = $this->datos->traerCanal($textoCanal);

        foreach ($canal as $key => $row) {
            array_push($arreglo, $row["canal"]);            
        }
        
        return implode(' - ',$arreglo);
    }
    
    function traerCentroPoblado($areasMet) {
        $arreglo = array();
        //echo'<pre>';print_r($areasMet);echo'</pre>';
        if(is_array($areasMet)){
            $textoAreaMet = implode(",",$areasMet);
        }else{
            $textoAreaMet = $areasMet;
        }        
        $centro = $this->datos->traerCentroPoblado($textoAreaMet);

        foreach ($centro as $key => $row) {
            array_push($arreglo, $row["ciudad"]);            
        }
        
        return implode(' - ',$arreglo);
    }
    
    function verAreaMet($areasMetro) {
        $arreglo = array();
        
        if(is_array($areasMetro)){
            $textoAreaMetr = implode(",",$areasMetro);
        }else{
            $textoAreaMetr = $areasMetro;
        }        
        $areaMetro = $this->datos->traerAreaMet($textoAreaMetr);

        foreach ($areaMetro as $key => $row) {
            array_push($arreglo, $row["areaMetropolitana"]);            
        }
        
        return implode(' - ',$arreglo);
    }
    
    function consultarMunicipios($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $lista_municipios = $this->traerCentroPoblado($arreglo["areaMet"]);
        //$datoCliente = $this->datos->datosCliente($arreglo["idCliente"]);         
        echo $lista_municipios;
    }
//    function traerMunicipio($idFormatoMedicion) {
//        $arreglo = array();
//
//        $centro = $this->datos->traerMunicipio($idFormatoMedicion);
//
//        foreach ($centro as $key => $row) {
//            array_push($arreglo, $row["idMunicipio"]);
//        }
//        return $arreglo;
//    }
    function armarListaSegmento($idCategoria) {
         
        $arreglo = array();

        $segmento = $this->datos->armarListaSegmento($idCategoria);

        foreach ($segmento as $key => $row) {
        $arreglo[$row["idSegmento"]]=$row["nombreSegmento"];
        }
        return $arreglo;
        
    }
    
    function armarListaColumnas($arreglo) {
         
        $array_res = array();

        $columna = $this->datos->armarListaColumnas($arreglo["categoria"],$arreglo["seleccion"]);

        foreach ($columna as $key => $row) {
            $array_res[$row["idAtributo"]]=$row["nombreAtributo"];
        }
        //return $columna;
        $select_columna = $this->datos->armSelect($array_res,'Columna...');
        echo $select_columna;
    }

    function ajaxListaTipos($arreglo) {

        $tipos = $this->datos->listaTipos();

        $v_cont = 0;
        $listaTipos = "[";
        foreach ($tipos as $key => $value) {
            if ($v_cont == 0) {
                $listaTipos = $listaTipos . '{"lk_option":"' . $tipos[$key]["tipo"] . '","lk_value":"' . $tipos[$key]["tipo"] . '"}';
                $v_cont++;
            } else {
                $listaTipos = $listaTipos . ',{"lk_option":"' . $tipos[$key]["tipo"] . '","lk_value":"' . $tipos[$key]["tipo"] . '"}';
            }
        }
        $listaTipos = $listaTipos . "]";

        echo $listaTipos;
    }
    
    function armarListaHerencia($arreglo) {
         
        $array_res = array();

        $columna = $this->datos->armarListaHerencia($arreglo["idCliente"],$arreglo["idCategoria"]);

        foreach ($columna as $key => $row) {
            $array_res[$row["id"]]=$row["anio"] . "-" . $row["ciclo"] . "-" . $row["id"];
        }
        //return $columna;
        $select_columna = $this->datos->armSelect($array_res,'Heredar de...');
        echo $select_columna;
    }
    
    
    function armarListaHerenciaEditar($idCliente,$idCategoria) {
         
        $array_res = array();

        $columna = $this->datos->armarListaHerencia($idCliente,$idCategoria);

        foreach ($columna as $key => $row) {
            $array_res[$row["id"]]=$row["anio"] . "-" . $row["ciclo"] . "-" . $row["id"];
        }
        //return $columna;
        $select_columna = $this->datos->armSelect($array_res,'Heredar de...');
        return $select_columna;
    }
    
    

}
?>