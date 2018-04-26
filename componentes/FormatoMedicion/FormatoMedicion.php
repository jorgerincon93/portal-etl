<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




require_once COMPONENTS_PATH . 'FormatoMedicion/vista/vistaFormatoMedicion.php';
include_once COMPONENTS_PATH . 'FormatoMedicion/modelo/datosFormatoMedicion.php';

class FormatoMedicion {

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
        $this->datos = new DatosFormatoMedicion();
        $this->vista = new VistaFormatoMedicion($this->datos);
    }

    public function mostrarFormatoMedicion($arreglo) {
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
        
        $idPadre = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $tipoUs =  $this->datos->tipoUsr($idPadre->id);
          if(isset($idPadre->id,$tipoUs->nombre)){
              $this->datos->crearVistaFmUsuario($idPadre->id,$tipoUs->nombre);
               
          }
        //$prueba =  $this->datos->jerarquiaJob($_SESSION["datos_logueo"]["idUsuario"]);
        //$permisos->idOrdenCompra = 10;
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';

        $this->vista->mostrarJobOrder($permisos);
    }

    function verCliente($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $listaCliente = $this->datos->mostrarCliente($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
        $this->vista->verCliente($listaCliente);
    }
    
    function editarFormatoMedicion($arreglo) {
         
        if($arreglo["id"]==10){
            $this->insertarCodigosShopper();
        }

        $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo['datosFormatoMedicion']->idResumenJob);        
        $arreglo['datosUsuario'] = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosCliente'] = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
        
        //INFORMACION DE APROBACIONES Y RECHAZOS
        if(($arreglo['datosFormatoMedicion']->avance > 20) || ($arreglo['datosFormatoMedicion']->estado == 'Rechazado')){
            $arreglo['tieneHistorial'] = 'SI';
            $arreglo['historialAprobacion'] = $this->datos->selectHistorialAprobacion($arreglo["id"]);          
        
            foreach($arreglo['historialAprobacion'] as $keyHistorial => $rowHistorial){

                //echo'<pre>';print_r($arreglo['historialAprobacion']);echo'</pre>';
                $nombreRol = $this->datos->nombreRol($rowHistorial["idPerfil"]);

                if(isset($rowHistorial["idUsuario"])){
                   $nombreUsuario= $this->datos->retornarNombreUsuarioJob($rowHistorial["idUsuario"]);
                   $arreglo['historialAprobacion'][$keyHistorial]["nombreUsuario"] = $nombreUsuario->nombre;
                }else{
                    $arreglo['historialAprobacion'][$keyHistorial]["nombreUsuario"] = '';
                }                
                $arreglo['historialAprobacion'][$keyHistorial]["nombrePerfil"] = $nombreRol->rol;
            }
        }

        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //$fechaSis = $arreglo['datosResumenJob']->fechaCreacion
        $arreglo['datosResumenJob']->fechaSis = date('Y-m-d',strtotime($arreglo['datosResumenJob']->fechaCreacion));
        $cabecera = $this->traerCabecera($arreglo["id"]);
        $centroPoblado = $this->traerCentroPoblado($arreglo["id"]);
//        $ciclo = $this->traerCiclo($arreglo["id"]);
        $canal = $this->traerCanal($arreglo["id"]);
        
        $arreglo['datosFormatoMedicion']->areaMet = implode(' - ', $cabecera);
        $arreglo['datosFormatoMedicion']->municipio = implode(' - ', $centroPoblado);
//        $arreglo['datosFormatoMedicion']->ciclo = implode(' - ', $ciclo);
        $arreglo['datosFormatoMedicion']->canal = implode(' - ', $canal);
        
        $arreglo['datosFormatoMedicion']->frecuencia;
        
        $nomCat = $this->datos->retornarNombreCategoriaJob($arreglo['datosFormatoMedicion']->idCategoria);
        $arreglo['datosFormatoMedicion']->nombreCategoria = $nomCat->nombreCategoria;
        
        $nombreFormato = $arreglo['datosCliente']->nombre;
        $nombreCategoria = $arreglo['datosFormatoMedicion']->nombreCategoria;
        $ciclo = $arreglo['datosFormatoMedicion']->ciclo;
        $anio = $arreglo['datosFormatoMedicion']->anio;
        $tituloFormatoMedicion = $nombreFormato . ' ' . $nombreCategoria . ' ' . $ciclo . ' ' . $anio;
        $arreglo['datosFormatoMedicion']->titulo = $tituloFormatoMedicion;
        //echo'<pre>';print_r($arreglo['datosFormatoMedicion']);echo'</pre>';
        
        $lista_tendencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Tendencia' ORDER BY valor ");
        $arreglo['select_tendencia'] = $this->datos->armSelect($lista_tendencia, 'Tendencia...',$arreglo['datosFormatoMedicion']->tendencia);
        
        $geoSeg = $this->traerGeoSeg($arreglo["id"]);
        $lista_geoSegmento = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='GeoSegmento' ORDER BY valor ");
        $arreglo['select_geoSegmento'] = $this->datos->armSelectMultiple($lista_geoSegmento,$geoSeg);
        
        $lista_tipificacion = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='Tipificacion' ORDER BY valor ");
        $arreglo['select_tipificacion'] = $this->datos->armSelect($lista_tipificacion, 'Anexa Tipificacion...',$arreglo['datosFormatoMedicion']->anexaTipificacion);
        
        $variable_medicion = $this->traerVarMedicion($arreglo["id"]);
        if(count($variable_medicion)==0){
            $variable_medicion = array("PRESENCIA");
        }
        
        $arreglo["varMedicion"] = $this->datos->traerVarMedicionCompleto($arreglo["id"]);

        $lista_varMedicion = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='VariablesMedicion' ORDER BY valor ");
        $arreglo['select_varMedicion'] = $this->datos->armSelectMultiple($lista_varMedicion,$variable_medicion);
        
        $variables_especiales = $this->traerVarEspeciales($arreglo["id"]);
        $lista_varEspeciales = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='VariablesEspecialesAnalisis' ORDER BY valor ");
        $arreglo['select_varEspeciales'] = $this->datos->armSelectMultiple($lista_varEspeciales,$variables_especiales);
        
        //echo'<pre>';print_r($lista_varMedicion);echo'</pre>';
        
        $lista_fabricanteDinamico = $this->armarListaFabricante($arreglo['datosFormatoMedicion']->idCategoria);
        $arreglo['select_fabricante_inicial'] = $this->datos->armSelect($lista_fabricanteDinamico,'Seleccione Fabricante...');
        
        //ARMADO DE MATRIZ DE REGISTROS
        $arreglo["colsRechazo"] = 0;
        $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);
        $matriz = array();
        if(isset($filas->maxFila)){
            $arreglo["cantFilas"] = $filas->maxFila;

            $columnasFormato = $this->traerColumnasFormato($arreglo["id"],$arreglo['datosFormatoMedicion']->idCategoria);
            $arreglo["columnasFormato"] = $columnasFormato;
            $arreglo["contColumnas"] = count($columnasFormato);
            $arreglo["colExcluidas"] = $columnasFormato[count($columnasFormato)-1]["exclusion"];
            
            if(strlen($arreglo["colExcluidas"]) > 0){
                $arreglo["columnasArray"] = '"categoria","fabricante","marca","' . str_replace(',', '","', $arreglo["colExcluidas"]) . '"';
            }else{
                $arreglo["columnasArray"] = '"categoria","fabricante","marca"';
            }
            
            $arreglo["arregloVarMedicion"]= '"' . implode('","', $variable_medicion) . '"';
            $columnasArray = "categoria,fabricante,marca," . $arreglo["colExcluidas"];
            $matriz = $this->armarMatrizRegistro($arreglo["id"],$columnasArray);
            if(isset($matriz["rechazoItem"])){
                $arreglo["colsRechazo"] = 3;
            }
        }else{
            $arreglo["cantFilas"] = 2;
            $arreglo["contColumnas"] = 3;
            $matriz[1][1]["valor"] = $arreglo['datosFormatoMedicion']->idCategoria;
            $matriz[1][1]["herencia"] = "";
            $matriz[1]["PRESENCIA"] = "Si";
            $matriz[2][2]["valor"] = "";
            $matriz[2][2]["select"] = $this->datos->armSelect($lista_fabricanteDinamico,'Seleccione Fabricante...');
            $arreglo["columnasArray"] = '"categoria","fabricante","marca"';
            $arreglo["arregloVarMedicion"] = '"PRESENCIA"';
            $matriz[2][2]["herencia"] = $arreglo['datosFormatoMedicion']->idCategoria;
            $matriz[2]["PRESENCIA"] = "Si";
            $arreglo["colsRechazo"] = 0;
        }
        
        $arreglo["matriz"]= $matriz;
   
//        $lista_tipoTendencia = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='TipoTendencia' ORDER BY valor ");
//        $arreglo['select_tipoTendencia'] = $this->datos->armSelect($lista_tipoTendencia, 'Seleccione Tendencia...');
        //echo'<pre>';print_r($arreglo);echo'</pre>';        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "EDITAR FORMATO MEDICION"; 
        $this->vista->agregarJobOrder($arreglo);
    }
    
    function generarExcel($arreglo){
        
        $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo['datosFormatoMedicion']->idResumenJob);        
        $arreglo['datosUsuario'] = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosCliente'] = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);        
        
        $cabecera = $this->traerCabecera($arreglo["id"]);
        $centroPoblado = $this->traerCentroPoblado($arreglo["id"]);
        $canal = $this->traerCanal($arreglo["id"]);
        
        $arreglo['datosFormatoMedicion']->areaMet = implode(' - ', $cabecera);
        $arreglo['datosFormatoMedicion']->municipio = implode(' - ', $centroPoblado);
        $arreglo['datosFormatoMedicion']->canal = implode(' - ', $canal);        
        $arreglo['datosFormatoMedicion']->frecuencia;
        
        $nomCat = $this->datos->retornarNombreCategoriaJob($arreglo['datosFormatoMedicion']->idCategoria);
        $arreglo['datosFormatoMedicion']->nombreCategoria = $nomCat->nombreCategoria;
        
        $nombreFormato = $arreglo['datosCliente']->nombre;
        $nombreCategoria = $arreglo['datosFormatoMedicion']->nombreCategoria;
        $ciclo = $arreglo['datosFormatoMedicion']->ciclo;
        $anio = $arreglo['datosFormatoMedicion']->anio;
        $tituloFormatoMedicion = strtoupper($nombreFormato . ' ' . $nombreCategoria . ' ' . $ciclo . ' ' . $anio);
        $arreglo['datosFormatoMedicion']->titulo = $tituloFormatoMedicion;
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Fabrica Meiko")
                                                                 ->setLastModifiedBy("Fabrica Meiko")
                                                                 ->setTitle("Formato de Medicion " . $arreglo["id"])
                                                                 ->setSubject("Formato de Medicion " . $arreglo["id"])
                                                                 ->setDescription("Formato de Medicion " . $arreglo["id"])
                                                                 ->setKeywords("Formato Medicion " . $arreglo["id"])
                                                                 ->setCategory("Formato Medicion " . $arreglo["id"]);

        // Add some data
        $hoja = $objPHPExcel->getSheet(0);
        $hoja->setTitle(substr($tituloFormatoMedicion,0,30));
        $hoja->setCellValue('A1', $tituloFormatoMedicion);
        
        //ARMADO DE MATRIZ DE REGISTROS
        $arreglo["colsRechazo"] = 0;
        $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);
        $matriz = array();
            
        $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);
        $contFilas = $filas->maxFila;
        $contColumnas = 1;
            
        $matriz[0][0] = "#";
        $nomColumnas = $this->datos->traerNombreColumnasFormato($arreglo["id"]);
            
        foreach ($nomColumnas as $keyCol => $valueCol) {
            $matriz[0][$contColumnas] = $valueCol["nombreColumna"];
            $contColumnas ++;
        }
        $contColumnas ++;

        //VARIABLES MEDICION
        $varMedicion = $this->datos->traerVarMedicionCompleto($arreglo["id"]);
        $contVarMed = count($varMedicion);
        foreach ($varMedicion as $keyVarMed => $valueVarMed) {
            $matriz[0][$contColumnas] = $valueVarMed["nombre"];
            $contColumnas ++;
        }

        //$contColumnas ++;

        $matriz[0][$contColumnas+1] = "CODIGO";
        $matriz[0][$contColumnas+2] = "CODIGO CORTO";

        //
        //
        //ARMADO DE REGISTROS//
        //
        //
        //
        
        
        $variableMedicion = $this->datos->traerVariablesMedicion($arreglo["id"]);
        

        for ($i=1;$i<=$contFilas;$i++){
            $codigo = 0;
            $codigoCorto = 0;
            $matriz[$i][0] = $i;
            $arrayVarMedicion = array();
            for($j=1;$j<($contColumnas-$contVarMed);$j++){

                $datosPosicion = $this->datos->traerValorFormatoPosicion($arreglo["id"],$i,$j);
                
                

                if(isset($datosPosicion->valor)){
                    $contColVarMed = $contColumnas-$contVarMed-1;
                    //VARIABLES DE MEDICION
                    foreach ($variableMedicion as $keyVarMed => $rowVarMed) {                    
                        $registroVarMed = $this->datos->traerRegistroVarMedicion($datosPosicion->id,$rowVarMed["id"]);
                        if(isset($registroVarMed->valor)){
                            $arrayVarMedicion[$contColVarMed] = $registroVarMed->valor;
                        }else{
                            $arrayVarMedicion[$contColVarMed] = 'No';
                        }
                        $contColVarMed++;
                    }
                    //echo'<pre>';print_r($arrayVarMedicion);echo'</pre>';
                    
                    $codigo = $datosPosicion->codigo;
                    $codigoCorto = $datosPosicion->codigoCorto;
                    if($datosPosicion->tabla != 'item_atributo'){
                        $datosTabla = $this->datos->traerValorFormatoTabla($datosPosicion->valor,$datosPosicion->tabla);
                        $valorPosicion = $datosTabla->nombre;
                    }else{
                        $valorPosicion = $datosPosicion->valor;
                    }
                }else{
                    $valorPosicion= "";
                }
                $matriz[$i][$j] = $valorPosicion;
            }

            $contColVarMedFila = $contColumnas-$contVarMed-1;
            foreach ($variableMedicion as $keyVarMed => $rowVarMed) {
                $matriz[$i][$contColVarMedFila] = $arrayVarMedicion[$contColVarMedFila];
                $contColVarMedFila++;
            }

            $matriz[$i][$contColumnas] = $codigo;
            $matriz[$i][$contColumnas+1] = $codigoCorto;
        }
            
            
       
        $colFin = ord("A")+$contColumnas;
        $hoja->mergeCells('A1:' . chr($colFin) . '1');
        
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        
        $hoja->getStyle('A1:' . chr($colFin) . '1')->applyFromArray($style);

            
        $hoja->fromArray($matriz,NULL,"A2");


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="FormatoMedicion_' . $arreglo["id"] . '_' . str_replace(" ", "_", $tituloFormatoMedicion)  . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    
    function aprobarFormatoMedicion($arreglo) {

        $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo['datosFormatoMedicion']->idResumenJob);        
        $arreglo['datosUsuario'] = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosCliente'] = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
        
        $fechaSis = $this->retornarFechaSisFormatoMedicion();
        $arreglo['datosResumenJob']->fechaSis = date('Y-m-d',strtotime($arreglo['datosResumenJob']->fechaCreacion));
        $cabecera = $this->traerCabecera($arreglo["id"]);
        $centroPoblado = $this->traerCentroPoblado($arreglo["id"]);
        $canal = $this->traerCanal($arreglo["id"]);
        
        $arreglo['datosFormatoMedicion']->areaMet = implode(' - ', $cabecera);
        $arreglo['datosFormatoMedicion']->municipio = implode(' - ', $centroPoblado);
        $arreglo['datosFormatoMedicion']->canal = implode(' - ', $canal);
        
        $nomCat = $this->datos->retornarNombreCategoriaJob($arreglo['datosFormatoMedicion']->idCategoria);
        $arreglo['datosFormatoMedicion']->nombreCategoria = $nomCat->nombreCategoria;
        
        $nombreFormato = $arreglo['datosCliente']->nombre;
        $nombreCategoria = $arreglo['datosFormatoMedicion']->nombreCategoria;
        $ciclo = $arreglo['datosFormatoMedicion']->ciclo;
        $anio = $arreglo['datosFormatoMedicion']->anio;
        $tituloFormatoMedicion = $nombreFormato . ' ' . $nombreCategoria . ' ' . $ciclo . ' ' . $anio;
        $arreglo['datosFormatoMedicion']->titulo = $tituloFormatoMedicion;
        //echo'<pre>';print_r($arreglo['datosFormatoMedicion']);echo'</pre>';        
        
        $geoSeg = $this->traerGeoSeg($arreglo["id"]);
        $arreglo['datosFormatoMedicion']->geosegmentacion = implode(' - ', $geoSeg);
        
        $variable_medicion = $this->traerVarMedicion($arreglo["id"],"nombre");
        $arreglo['datosFormatoMedicion']->varMedicion = implode(' - ', $variable_medicion);
        
        $arreglo["varMedicion"] = $this->datos->traerVarMedicionCompleto($arreglo["id"]);
        
        $variables_especiales = $this->traerVarEspeciales($arreglo["id"],"nombre");
        $arreglo['datosFormatoMedicion']->varMedicionEspecial = implode(' - ', $variables_especiales);
        
        $registroVarEsp = $this->datos->traerVarEspeciales($arreglo["id"]);
        $arreglo['datosFormatoMedicion']->variablesEspeciales = $registroVarEsp;
        
        //echo'<pre>';print_r($registroVarEsp);echo'</pre>';
        
        //ARMADO DE MATRIZ DE REGISTROS
        
        $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);
        $matriz = array();
        if(isset($filas->maxFila)){
            $arreglo["cantFilas"] = $filas->maxFila;

            $columnasFormato = $this->traerColumnasFormato($arreglo["id"],$arreglo['datosFormatoMedicion']->idCategoria,false);
            $arreglo["columnasFormato"] = $columnasFormato;
            $arreglo["contColumnas"] = count($columnasFormato);            
            $columnasArray = array();
            $matriz = $this->armarMatrizRegistro($arreglo["id"],$columnasArray,false);
        }
        
        $arreglo["matriz"]= $matriz;
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';        

        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "APROBAR FORMATO MEDICION";
        
        $this->vista->aprobarFormatoMedicion($arreglo);
    }
    
    
    function aprobarFormatoMedicionItem($arreglo) {

        $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo['datosFormatoMedicion']->idResumenJob);        
        $arreglo['datosUsuario'] = $this->datos->datosAsesor($arreglo['datosResumenJob']->idUsuario);
        $arreglo['datosCliente'] = $this->datos->datosCliente($arreglo['datosResumenJob']->idCliente);
        
        $fechaSis = $this->retornarFechaSisFormatoMedicion();
        $arreglo['datosResumenJob']->fechaSis = date('Y-m-d',strtotime($arreglo['datosResumenJob']->fechaCreacion));
        $cabecera = $this->traerCabecera($arreglo["id"]);
        $centroPoblado = $this->traerCentroPoblado($arreglo["id"]);
        $canal = $this->traerCanal($arreglo["id"]);
        
        $arreglo['datosFormatoMedicion']->areaMet = implode(' - ', $cabecera);
        $arreglo['datosFormatoMedicion']->municipio = implode(' - ', $centroPoblado);
        $arreglo['datosFormatoMedicion']->canal = implode(' - ', $canal);
        
        $nomCat = $this->datos->retornarNombreCategoriaJob($arreglo['datosFormatoMedicion']->idCategoria);
        $arreglo['datosFormatoMedicion']->nombreCategoria = $nomCat->nombreCategoria;
        
        $nombreFormato = $arreglo['datosCliente']->nombre;
        $nombreCategoria = $arreglo['datosFormatoMedicion']->nombreCategoria;
        $ciclo = $arreglo['datosFormatoMedicion']->ciclo;
        $anio = $arreglo['datosFormatoMedicion']->anio;
        $tituloFormatoMedicion = $nombreFormato . ' ' . $nombreCategoria . ' ' . $ciclo . ' ' . $anio;
        $arreglo['datosFormatoMedicion']->titulo = $tituloFormatoMedicion;
        //echo'<pre>';print_r($arreglo['datosFormatoMedicion']);echo'</pre>';        
        
        $geoSeg = $this->traerGeoSeg($arreglo["id"]);
        $arreglo['datosFormatoMedicion']->geosegmentacion = implode(' - ', $geoSeg);
        
        $variable_medicion = $this->traerVarMedicion($arreglo["id"],"nombre");
        $arreglo['datosFormatoMedicion']->varMedicion = implode(' - ', $variable_medicion);
        
        $arreglo["varMedicion"] = $this->datos->traerVarMedicionCompleto($arreglo["id"]);
        
        $variables_especiales = $this->traerVarEspeciales($arreglo["id"],"nombre");
        $arreglo['datosFormatoMedicion']->varMedicionEspecial = implode(' - ', $variables_especiales);
        
        $registroVarEsp = $this->datos->traerVarEspeciales($arreglo["id"]);
        $arreglo['datosFormatoMedicion']->variablesEspeciales = $registroVarEsp;
        
        //echo'<pre>';print_r($registroVarEsp);echo'</pre>';
        
        //ARMADO DE MATRIZ DE REGISTROS
        
        $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);
        $matriz = array();
        if(isset($filas->maxFila)){
            $arreglo["cantFilas"] = $filas->maxFila;

            $columnasFormato = $this->traerColumnasFormato($arreglo["id"],$arreglo['datosFormatoMedicion']->idCategoria,false);
            $arreglo["columnasFormato"] = $columnasFormato;
            $arreglo["contColumnas"] = count($columnasFormato);            
            $columnasArray = array();
            $matriz = $this->armarMatrizRegistro($arreglo["id"],$columnasArray,false);
        }
        
        $arreglo["matriz"]= $matriz;
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';        

        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "APROBAR FORMATO MEDICION POR ITEM";
        
        $this->vista->aprobarFormatoMedicionItem($arreglo);
    }
    
    function guardarFormato($arreglo) {
        
        $datosUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
          
         if($datosUsuario->idRol == 1){
             
             $arreglo["estado"]= "En Dasarrollo Comercial Junior";
             $arreglo['avance']= 15;
         }else{
        
                $arreglo["estado"]= "En Desarrollo";
                $arreglo['avance']= 20;
         }     
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        //ACTUALIZAR INFO BASICA
//       $arreglo['datosFormatoMedicion'] ->observacionesTendencia ;
        
        $pruebaFormato = json_decode($arreglo["pruebaFormato"]);
        
        foreach ($pruebaFormato as $keyForm => $rowForm){
            $arreglo[$rowForm->name] = $rowForm->value;		
	}
        
        if(isset($arreglo["id"])){
            
            $arreglo['datosFormatoMedicion'] = $this->datos->selectFormatoMedicion($arreglo["id"]);
            /*$obsTendencia = $arreglo['datosFormatoMedicion']->observacionesTendencia;
            $urlTi = $arreglo['datosFormatoMedicion']->urlTipificacion;
            $Vare = ""; */
            
            

            if(!isset($arreglo["observacionesTendencia"])){
               $arreglo["observacionesTendencia"]="";
              }

            if(!isset($arreglo["urlTipificacion"])){
               $arreglo["urlTipificacion"]="";
             }   

            if(!isset($Vare['varEsp_'])){
               $arreglo['varEsp_']='';         
             } 

           // $arreglo['datosRegla']['fechaCreacion'] = $fechaSis;

           $this->datos->actualizarFormatoMedicion($arreglo);

           //ACTUALIZAR GEOSEGMENTACION
           $arregloGeoSegmentacion = explode(',',$arreglo["arregloGeoSegmentacion"]);        
           $this->datos->borrarGeoSegmentacion($arreglo["id"]);

           foreach ($arregloGeoSegmentacion as $keyGeo => $rowGeo) {
               $this->datos->actualizarGeoSegmentacion($arreglo["id"],$rowGeo);            
           }

           // ACTUALIZAR VARIABLES DE MEDICION

           $arregloVariablesMedicion = explode(',',$arreglo["arregloVariablesMedicion"]);        
           $this->datos->borrarVariablesMedicion($arreglo["id"]);

           foreach ($arregloVariablesMedicion as $keyVarMed => $rowVarMed) {
               $this->datos->actualizarVariablesMedicion($arreglo["id"],$rowVarMed);            
           }

           $arregloVariablesEspeciales = explode(',',$arreglo["arregloVariablesEspeciales"]);
           $this->datos->borrarVariablesEspeciales($arreglo["id"]);

           foreach ($arregloVariablesEspeciales as $keyVarEsp => $rowVarEsp){

               $nom_campo= preg_replace("/[%#(,) ]/i","_", $rowVarEsp);
               $nom_campo= preg_replace("/__/i","_", $nom_campo);
               //echo $nom_campo ."\n";
               //idCol = idCol.replace(/__/g,'_');
               $valorVar = $arreglo['varEsp_'.$nom_campo];  
               $this->datos->actualizarVariablesEspeciales($arreglo["id"],$rowVarEsp,$valorVar);
           }

           $matriz_resultante = array();
           $arregloColumnas = explode(',',$arreglo["columnasArray"]);
           $this->datos->borrarColumnas($arreglo["id"]);
           $this->datos->borrarRegistros($arreglo["id"]);
           $orden = 0;
           //echo'<pre>';print_r($arregloColumnas);echo'</pre>';

           foreach ($arregloColumnas as $keyCol => $rowCol) {
                   $var_fila ="|";
                   $var_herencia="|";                

                   $this->guardarColumna($arreglo["id"],$rowCol,($keyCol+1));

               for ($i=1;$i<=$arreglo["numeroLineas"];$i++){

                   if(isset($arreglo["input_".$i."_".($keyCol+1)])){

                       $orden = $orden+1;

                       //if((strpos($var_fila,$arreglo["input_".$i."_".($keyCol+1)])==false) && (strpos($var_fila,$arreglo["input_".$i."_".($keyCol+1)])==false)  ){

                       $matriz_resultante[$i][$keyCol+1]["valor"] = $arreglo["input_".$i."_".($keyCol+1)];
                       $matriz_resultante[$i][$keyCol+1]["herencia"] = $arreglo["herencia_".$i."_".($keyCol+1)];
                       $matriz_resultante[$i][$keyCol+1]["orden"] = $orden;

                       if($matriz_resultante[$i][$keyCol+1]["herencia"] != '' && $matriz_resultante[$i][$keyCol+1]["herencia"] != NULL){
                           $codigoHerencia = $matriz_resultante[$i][$keyCol+1]["herencia"] .",". $matriz_resultante[$i][$keyCol+1]["valor"];
                       }else{
                           $codigoHerencia = $matriz_resultante[$i][$keyCol+1]["valor"];
                       }                    


                       $codigoItem = $this->crearCodigo($arreglo["id"],$codigoHerencia);
                       $codigoItemCorto = $this->crearCodigoCorto($arreglo["id"],$codigoHerencia);

                       $idRegistro = $this->guardarRegistro($arreglo["id"],$arreglo["input_".$i."_".($keyCol+1)],$arreglo["herencia_".$i."_".($keyCol+1)],$i,($keyCol+1),$orden,$codigoItem,$codigoItemCorto);

                       $variablesMedicion = $this->datos->traerVariablesMedicion($arreglo["id"]);

                       foreach($variablesMedicion as $keyVarMedicion => $rowVarMedicion){

                           $nom_medicion = preg_replace("/[%#(,) ]/i","_", $rowVarMedicion["variableMedicion"]);
                           $nom_medicion = preg_replace("/__/i","_", $nom_medicion);

                           if(isset($arreglo["input_".$i."_".$nom_medicion])){                            
                               $this->datos->guardarRegistroVariable($idRegistro,$rowVarMedicion["id"],$arreglo["input_".$i."_".$nom_medicion]);
                           }
                       }

                           //$var_fila = $var_fila . "|" . $arreglo["input_".$i."_".($keyCol+1)];
                           //$var_herencia= $var_herencia . "|" . $arreglo["herencia_".$i."_".($keyCol+1)];


                       //echo "posicion_".$i."_".($keyCol+1).": ".  $arreglo["input_".$i."_".($keyCol+1)] . "\n";
                       //echo "herencia_".$i."_".($keyCol+1).": ".  $arreglo["herencia_".$i."_".($keyCol+1)] . "\n";
                   }                

               }
           }
           
           $formMedicion = $this->datos->traerFormatoMedicion($arreglo['datosFormatoMedicion']->idResumenJob);
           $numeroLineas = 0;
            foreach ($formMedicion as $key => $valueFrom) {
    
                $cantLineas = $this->datos->traerCantLineas($valueFrom["id"]);
                $numeroLineas = $numeroLineas + $cantLineas->cantLineas;
                $arreglo['datosFormatoMedicion']->cantLineas = $numeroLineas;
                $this->datos->actualizarOrdenCantLineas($arreglo['datosFormatoMedicion']);
                
            }           
           //echo'<pre>';print_r($arreglo['datosFormatoMedicion']);echo'</pre>';
           if($arreglo["resumenJob"] != 0){
               $arreglo["idResumenJob"] = $arreglo["resumenJob"];
           }

           $this->datos->actualizarAprobObsItem($arreglo["id"]);
           //echo'<pre>';print_r($matriz_resultante);echo'</pre>';

           //$categorias = explode(',', $arreglo["categoria_array"]);
           //$cabecera = explode(',', $arreglo["area_met_array"]);
           //$centroPoblado = explode(',', $arreglo["municipio_array"]);

           
           //echo'<pre>';print_r($arreglo['fecha']);echo'</pre>';
           //$fecha =  date_create_from_format('d/m/Y',$arreglo['fecha']);
           //echo'<pre>';print_r($fecha);echo'</pre>';
   //        if ($arreglo['opcion'] == "editar") {
   //            $this->datos->actualizarCliente($arreglo);
   //        } else {
   //            $arreglo["estado"] = "Creado";
   //            $idJobOrder = $this->datos->insertarJobOrder($arreglo);
   //
   //            foreach ($categorias as $keyCat => $rowCat) {
   //                $this->datos->insertarOrdenCategoria($idJobOrder, $rowCat);
   //                $this->datos->insertarJobOrder($idJobOrder, $rowCat, $arreglo);
   //            }
   //
   //            foreach ($cabecera as $keyCab => $rowCab) {
   //                $this->datos->insertarOrdenCabecera($idJobOrder, $rowCab);
   //            }
   //
   //            foreach ($centroPoblado as $keyCentro => $rowCentro) {
   //                $this->datos->insertarOrdenCentroPoblado($idJobOrder, $rowCentro);
   //            }
   //
   //            //$categorias_array = 
   //        }
        }else{
            echo "ERROR DE DATOS -  FORMATO DE MEDICION SIN ID";
        }
            
        $this->mostrarFormatoMedicion($arreglo);
    }
    
    function aprobarFormato($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $perfilesAprobacion = $this->datos->traerPerfilesAprobacion();//array("1","2","3","4","6","7","8");
        $cantPerfiles = count($perfilesAprobacion);
        $porPerfiles = 70/$cantPerfiles; //PENDIENTE VERIFICACION
        $infoUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $tipoPreAprobarJob = $this->datos->tipoPreAprobarJob($_SESSION["datos_logueo"]["idUsuario"]);
        $aprobarJob = $this->datos->tipoUsr($_SESSION["datos_logueo"]["idUsuario"]);
        $correoPadre = $this->datos->TraercorreoPadre($infoUsuario->idPadre);
        $correoUsuario = ',';
        $estado="Pendiente";
        
        if(isset($tipoPreAprobarJob->nombre)){
          if($tipoPreAprobarJob->nombre == "Comercial"){
                    foreach ($perfilesAprobacion as $keyPerfil => $rowPerfil){ 
                        
                             if($rowPerfil['nombre'] == 'Supervisor JOB'){
                                 $this->datos->insertarAprobacion($arreglo["id"],$rowPerfil["valor"],"Pre Aprobado",$porPerfiles);
                                 $correoUsuario = $correoPadre->email;
                               }else{
                                  $this->datos->insertarAprobacion($arreglo["id"],$rowPerfil["valor"],"Pre Aprobado",$porPerfiles);
                                  $correoUsuario = $correoPadre->email;
                                }
                    }
        
                $correo = $correoUsuario;
                
                $infoUsuario->idRol =1;
                $this->datos->actualizarEstadoPreAprobacion($arreglo["id"],$infoUsuario->idRol,"Pre Aprobado", $infoUsuario->id,$arreglo["obsAprobacion"]);
                $this->datos->actualizarEstadoFormatoPreAprobado($arreglo["id"],"Pre Aprobado",$porPerfiles);
                // Modificado meiko 21-07-2016
                // $this->enviarCorreo($arreglo["id"],$correo);
                   $this->enviarCorreo($arreglo["id"],"fabrica@grupomeiko.co, ". $correo);
            
                
            }
            
        }
        if(isset($aprobarJob->nombre)){
              if($aprobarJob->nombre != "Comercial"){
                foreach ($perfilesAprobacion as $keyPerfil => $rowPerfil){  
                     
                              $this->datos->insertarAprobacion($arreglo["id"],$rowPerfil["valor"],$estado,$porPerfiles);
                              $correoUsuario = $correoUsuario . $rowPerfil["texto"] . ',';
                }
                    
                $correo = trim($correoUsuario,',');
                
                $infoUsuario->idRol =21;
                $this->datos->actualizarEstadoAprobacion($arreglo["id"],$infoUsuario->idRol,"Aprobado", $infoUsuario->id,$arreglo["obsAprobacion"]);
                $this->datos->actualizarEstadoFormato($arreglo["id"],"Pendiente Aprobacion",$porPerfiles);
                $this->enviarCorreo($arreglo["id"],"fabrica@grupomeiko.co, ". $correo);
            
             }
        }
         //if($rowPerfil["valor"]== $infoUsuario["idRol"])
        $this->mostrarFormatoMedicion($arreglo);
    }
    
    function aprobarFormatoProceso($arreglo) {
        
        $infoUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $datosPreAprobacion = $this->datos->mostrarPermisoPreAprobacion($arreglo["id"],$infoUsuario->idRol);  
        $perfilesAprobacion = $this->datos->traerPerfilesAprobacion();
        $nomRol = $this->datos->nombreRol($infoUsuario->idRol);
        $datosFormatoMedicion = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $datosResumenJob = $this->datos->selectResumenJob($datosFormatoMedicion->idResumenJob);
        $datosUsuarioCreador = $this->datos->datosAsesor($datosResumenJob->idUsuario);
        $estado="";
        $correoUsuario = ',';
        
        //echo'<pre>';print_r($datosFormatoMedicion);echo'</pre>';
        //echo'<pre>';print_r($datosAprobacion);echo'</pre>';        
        //echo'<pre>';print_r($infoUsuario);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';        
        
       
       if(isset($datosPreAprobacion->estado)){ 
           if($datosPreAprobacion->estado == "Pre Aprobado" && $nomRol->rol == 'Supervisor JOB'){
            
                $estado = "Pendiente";
                $this->datos->actualizarEstAprobacion($datosFormatoMedicion->id,$estado, $infoUsuario->id);
                
                foreach ($perfilesAprobacion as $keyPerfil => $rowPerfil){  
                        
                    $correoUsuario = $correoUsuario . $rowPerfil["texto"] . ',';
                }
                    
                $correo = trim($correoUsuario,',');
                $this->enviarCorreo($arreglo["id"],"fabrica@grupomeiko.co, ". $correo);
            }
       }    
       
       $datosAprobacion = $this->datos->mostrarPermisoAprobacion($arreglo["id"],$infoUsuario->idRol);
        
        if($arreglo["resAprobar"] =="Aprobar"){
              $avance = $datosFormatoMedicion->avance + $datosAprobacion->porcentaje;
                if ($avance >80){
                     $estado="Aprobado";
                }else{
                        $estado="Pendiente Aprobacion";
                    }
            $this->datos->actualizarEstadoAprobacion($arreglo["id"],$infoUsuario->idRol,"Aprobado", $infoUsuario->id,$arreglo["obsAprobacion"]);
            $this->datos->actualizarEstadoFormato($arreglo["id"],$estado,$datosAprobacion->porcentaje);
            $this->enviarCorreoAprobacion($arreglo["id"],$infoUsuario->nombre,"fabrica@grupomeiko.co, " . $datosUsuarioCreador->email);
        }else{
                    $estado="Rechazado";
                    $this->datos->rechazarEstadoAprobacion($arreglo["id"],$estado, $infoUsuario->id,$arreglo["obsAprobacion"],$infoUsuario->idRol);
                    $this->datos->rechazarEstadoFormato($arreglo["id"],$estado);
                    $this->enviarCorreoRechazado($arreglo["id"],$infoUsuario->nombre,"fabrica@grupomeiko.co,operaciones@grupomeiko.co,gerencia@grupomeiko.co,finanzas@grupomeiko.co,database@grupomeiko.co,campo@grupomeiko.co,administracion@grupomeiko.co, " . $datosUsuarioCreador->email);
        }
        
        $this->mostrarFormatoMedicion($arreglo);
        
    }
    
    
    function aprobarFormatoProcesoItem($arreglo) {
        
        $infoUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $datosAprobacion = $this->datos->mostrarPermisoAprobacion($arreglo["id"],$infoUsuario->idRol);
        $datosFormatoMedicion = $this->datos->selectFormatoMedicion($arreglo["id"]);
        $datosResumenJob = $this->datos->selectResumenJob($datosFormatoMedicion->idResumenJob);
        $datosUsuarioCreador = $this->datos->datosAsesor($datosResumenJob->idUsuario);
        $estado="";
        
        //echo'<pre>';print_r($datosFormatoMedicion);echo'</pre>';
        //echo'<pre>';print_r($datosAprobacion);echo'</pre>';
        //echo'<pre>';print_r($infoUsuario);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        
        if($arreglo["resAprobar"] =="Aprobar"){            
            $avance = $datosFormatoMedicion->avance + $datosAprobacion->porcentaje;
            if ($avance >80){
                $estado="Aprobado";
            }else{
                $estado="Pendiente Aprobacion";
            }
            $this->datos->actualizarEstadoAprobacion($arreglo["id"],$infoUsuario->idRol,"Aprobado", $infoUsuario->id,$arreglo["obsAprobacion"]);
            $this->datos->actualizarEstadoFormato($arreglo["id"],$estado,$datosAprobacion->porcentaje);
            $this->enviarCorreoAprobacion($arreglo["id"],$infoUsuario->nombre,"fabrica@grupomeiko.co, " . $datosUsuarioCreador->email);
        }else{
            $filas = $this->datos->cantidadFilasRegistro($arreglo["id"]);

            for($i=1;$i<=$filas->maxFila;$i++){
                if(isset($arreglo["input_". $i ."_rechazar"])){
                    if($arreglo["input_". $i ."_rechazar"]=="SI"){
                        $this->datos->insertarAprobObsItem($arreglo["id"],$infoUsuario->id,$infoUsuario->idRol,$i,$arreglo["obs_". $i ."_rechazo"]);
                    }
                }
            }
            
            $estado="Rechazado";
            $this->datos->rechazarEstadoAprobacion($arreglo["id"],$estado, $infoUsuario->id,$arreglo["obsAprobacion"],$infoUsuario->idRol);
            $this->datos->rechazarEstadoFormato($arreglo["id"],$estado);
            $this->enviarCorreoRechazado($arreglo["id"],$infoUsuario->nombre,"fabrica@grupomeiko.co,operaciones@grupomeiko.co,gerencia@grupomeiko.co,finanzas@grupomeiko.co,database@grupomeiko.co,campo@grupomeiko.co,administracion@grupomeiko.co," . $datosUsuarioCreador->email);
        }
        
        $this->mostrarFormatoMedicion($arreglo);        
    }
    
    //function buscarRepetidoMatriz
    
    
    function guardarColumna($idFormatoMedicion,$valorColumna,$orden){
        $columnasBasicas = array("categoria","fabricante","marca");
        $tabla = "";
        $valor = "";
        
        if(in_array($valorColumna, $columnasBasicas)){
            $tabla = $valorColumna;
            $valor = "";
        }else{
            $tabla = "atributo";
            $valor = $valorColumna;
        }
        
        $this->datos->guardarColumna($idFormatoMedicion,$tabla,$valor,$orden);
    }
    
    
    //guardarRegistro($arreglo["id"],$arreglo["input_".$i."_".($keyCol+1)],$arreglo["herencia_".$i."_".($keyCol+1)],$i,($keyCol+1),$orden);
    
    function guardarRegistro($idFormatoMedicion,$valor,$herencia,$fila,$columna,$orden,$codigoItem,$codigoItemCorto){
        $columnasBasicas = array("categoria","fabricante","marca");
        $tabla = "";        
        
        if($columna <= count($columnasBasicas)){
            $tabla = $columnasBasicas[($columna-1)];
        }else{
            $tabla = "item_atributo";
        }
        //guardarRegistro($idFormatoMedicion,$tabla,$valor,$herencia,$fila,$columna,$orden){
        $idRegistro = $this->datos->guardarRegistro($idFormatoMedicion,$tabla,$valor,$herencia,$fila,$columna,$orden,$codigoItem,$codigoItemCorto);
        return $idRegistro;
    }
            
    

    function consultarCliente($arreglo) {
        $datoCliente = $this->datos->datosCliente($arreglo["idCliente"]);
        echo json_encode($datoCliente);
    }

    
    function retornarFechaSisFormatoMedicion() {
        
        $fechaActual = date("d-m-Y");
        return $fechaActual;
    }
    
    function consultarMunicipios($arreglo) {

        $lista_municipios = $this->datos->build_list('geo.centropoblado', 'idCentroPoblado', 'centroPoblado', " WHERE idCabeceraMunicipal IN (" . $arreglo["areaMet"] . ") ORDER BY centroPoblado ");
        $select_municipio = $this->datos->armSelectMultiple($lista_municipios);
        //$datoCliente = $this->datos->datosCliente($arreglo["idCliente"]);         
        echo $select_municipio;
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
    
    function mostrarHistorialAprobacion($arreglo){
        
        $arreglo['historialAprobacion'] = $this->datos->selectHistorialAprobacion($arreglo["id"]);
          
        
        foreach($arreglo['historialAprobacion'] as $keyHistorial => $rowHistorial){
            
            //echo'<pre>';print_r($arreglo['historialAprobacion']);echo'</pre>';
            $nombreRol = $this->datos->nombreRol($rowHistorial["idPerfil"]);
            
            if(isset($rowHistorial["idUsuario"])){
               $nombreUsuario= $this->datos->retornarNombreUsuarioJob($rowHistorial["idUsuario"]);
               $arreglo['historialAprobacion'][$keyHistorial]["nombreUsuario"] = $nombreUsuario->nombre;
            }else{
                $arreglo['historialAprobacion'][$keyHistorial]["nombreUsuario"] = '';
            }     
             $arreglo['historialAprobacion'][$keyHistorial]["nombrePerfil"] = $nombreRol->rol;
            
        }
        
        
    $arreglo['titulo'] = "RESUMEN HISTORIAL APROBACION";
    
    $this->vista->verHistorialAprobacion($arreglo);
       
    }


    function ajaxListaJobOrder($arreglo) {
        global $db_settings;        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];
        $id_usuario = $_SESSION["datos_logueo"]["idUsuario"];
        
        $ds = new dacapo($db_settings, null);
        
        $page_settings = array(
                "selectCountSQL" => "SELECT count(vfm.id) as totalrows FROM vistaformatomedicion_" . $id_usuario . " vfm",
                "selectSQL" => "SELECT vfm.avance,vfm.estado,vfm.id,vfm.nombreUsuario,vfm.anio,vfm.ciclo,vfm.nombreCliente,vfm.nombreCategoria,vfm.fechaCreacion,vfm.idResumenJob FROM meiko.vistaformatomedicion_" . $id_usuario ."  vfm",
                "page_num" => $arreglo['page_num'],
                "rows_per_page" => $arreglo['rows_per_page'],
                "columns" => $arreglo['columns'],
                "sorting" =>  isset($arreglo['sorting']) ? $arreglo['sorting'] : array(),
                "filter_rules" => isset($arreglo['filter_rules']) ? $arreglo['filter_rules'] : array()
        );
        
        //$selectCount = "SELECT count(o.id) as totalrows ";
         //$select = "SELECT o.avance,o.id, o.idResumenJob,o.idCategoria,o.tipoEstudio,o.estado,o.anio,o.ciclo ";
        //$from = " FROM formato_medicion o ,resumen_job j";
        //$reglaInicial = array();
        //$reglaInicial[0]["condition"]["field"] = "o.idResumenJob";
        //$reglaInicial[0]["condition"]["condition"] = "10";
        //$reglaInicial[0]["condition"]["filterValue"][0] = "j.id";
        //$reglaInicial[0]["condition"]["operator"] = "equal";
        //$reglaInicial[0]["condition"]["filterType"] = "number";        
        //$reglaInicial[0]["logical_operator"] = "AND";
        
        //$reglaInicial[1]["condition"]["field"] = "o.avance";
        //$reglaInicial[1]["condition"]["condition"] = "10";
        //$reglaInicial[1]["condition"]["filterValue"][0] = "10";
        //$reglaInicial[1]["condition"]["operator"] = "equal";
        //$reglaInicial[1]["condition"]["filterType"] = "text";
        
       /* $reglas = array();
        $msgError= "";
        //$reglas =  $reglaInicial;
        if(isset($arreglo['filter_rules'])){
            try{
                $reglas =array_merge($reglaInicial, $arreglo['filter_rules']);
            }catch (Exception $e) {
                $msgError = "Excepción capturada: " .  $e->getMessage();
            }            
        }else{
            $reglas =  $reglaInicial;
        }
        
       $page_settings = array(
            "selectCountSQL" => $selectCount . $from . $where,
            "selectSQL" => $select . $from . $where, // CONFIGURE
            "page_num" => $arreglo['page_num'],
            "rows_per_page" => $arreglo['rows_per_page'],
            "columns" => $arreglo['columns'],
            "sorting" => isset($arreglo['sorting']) ? $arreglo['sorting'] : array(),
            "filter_rules" => $reglas
        );*/
        
        //$filterrules = implode('|',$arreglo['filter_rules']);

        $jfr = new jui_filter_rules($ds);
        $arreglo['debug_mode'] = isset($arreglo['debug_mode']) ? $arreglo | ['debug_mode'] : "yes";

        $jdg = new bs_grid($ds, $jfr, $page_settings, true);

        $data = $jdg->get_page_data();

        // data conversions (if necessary)
        //$data['page_data'][0]['idUsuario'] = str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
        foreach ($data['page_data'] as $key => $row) {
            //if($key!=0){
            //$datosResumenJob = $this->datos->selectResumenJob($row['idResumenJob']);
            //$usuarioNombreJob = $this->datos->datosAsesor($datosResumenJob->idUsuario);
            //$usuarioClienteJob = $this->datos->datosCliente($datosResumenJob->idCliente);
            
            //$arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo["idResumenJob"]);
            //$usuarioNombreJob = $this->datos->retornarNombreUsuarioJob($row['idUsuarioCreador']);
            //$usuarioClienteJob = $this->datos->retornarNombreClienteJob($row['idCliente']);
            //$nombreCategoria = $this->datos->retornarNombreCategoriaJob($row['idCategoria']);
            
            $nomCanal = $this->traerCanal($row['id']);
            $nomAreaMet = $this->traerCabecera($row['id']);
            
            $data['page_data'][$key]['idResumenJob'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verResumenJob&id={$row['idResumenJob']}&idMenu={$permisos->idMenu}\" >{$row['idResumenJob']}</a>";
            $data['page_data'][$key]['canal'] = implode(' - ', $nomCanal);
            $data['page_data'][$key]['areaMetropolitana'] = implode(' - ', $nomAreaMet);
//            //$data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
//            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
//            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            $eliminar = "";
            $aprobar ="";
            $historial = "";
            $excel ="";
            
            if ($permisos->editar == "SI") {
                $editar = "<a href=\"javascript:void(0)\" onclick=\"editarFormatoMedicion({$row['id']},{$arreglo["idResumenJob"]})\"  ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                $excel = "<a href=\"javascript:void(0)\" onclick=\"generarExcel({$row['id']})\"  ><img src=\"images/iconos/excel.jpg\" title=\"Generar Excel\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }
            // se agrega funcionalidad de visualizacion de excel cuando no tiene permisos de edicion 29-09-2016 - Jeyson Vargas
             if ($permisos->editar == "NO") {
                $excel = "<a href=\"javascript:void(0)\" onclick=\"generarExcel({$row['id']})\"  ><img src=\"images/iconos/excel.jpg\" title=\"Generar Excel\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }
            
            $permisosPreAprobacion = $this->datos->mostrarPermisoPreAprobacion($row['id'],$_SESSION["datos_logueo"]["idRol"]);
            
            if(isset($permisosPreAprobacion->id)){
                if($permisosPreAprobacion->idPerfil == 21){
                   $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarFormatoMedicion({$row['id']})\"  ><img src=\"images/iconos/valido.png\" title=\"Aprobar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
            }
            
            $permisosAprobacion = $this->datos->mostrarPermisoAprobacion($row['id'],$_SESSION["datos_logueo"]["idRol"]);
            
            if(isset($permisosAprobacion->id)){
                $permisosObsItem= $this->datos->consultarPermisoObsItem($_SESSION["datos_logueo"]["idRol"]);
                if(isset($permisosObsItem->id)){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarFormatoMedicionItem({$row['id']})\"  ><img src=\"images/iconos/valido.png\" title=\"Aprobar Formato Medicion Item\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }else{
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarFormatoMedicion({$row['id']})\"  ><img src=\"images/iconos/valido.png\" title=\"Aprobar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }                
            }
            
            if(($_SESSION["datos_logueo"]["idRol"]=="1")){
                if($data['page_data'][$key]['estado']=="En Dasarrollo Comercial Junior"){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarFormatoMedicionInicial({$row['id']})\"  ><img src=\"images/iconos/valido.png\" title=\"Aprobar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
                if(($data['page_data'][$key]['avance']>30) || ($data['page_data'][$key]['estado']=="Rechazado")){
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
            }  
                
            if(($_SESSION["datos_logueo"]["idRol"]=="21")){
                if($data['page_data'][$key]['estado']=="En Desarrollo"){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarFormatoMedicionInicial({$row['id']})\"  ><img src=\"images/iconos/valido.png\" title=\"Aprobar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
                if(($data['page_data'][$key]['avance']>30) || ($data['page_data'][$key]['estado']=="Rechazado")){
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
                
            }
            
            //$data['page_data'][$key]['idUsuarioCreador'] = $usuarioNombreJob->nombre;
            //$data['page_data'][$key]['idCliente'] = $usuarioClienteJob->nombre;
            //$data['page_data'][$key]['idCategoria'] = $nombreCategoria->nombreCategoria;
            //$data['page_data'][$key]['fechaCreacion'] = $datosResumenJob->fechaCreacion;

           //$data['page_data'][$key]['idOrdenCompra'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['idOrdenCompra']}&idMenu={$permisos->idMenu}\" >{$row['idOrdenCompra']}</a>";
            $data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['id'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['id'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['acciones'] = $historial . " " . $aprobar . " " . $editar . " " . $eliminar . " " . $excel;
            //}else{
            //    unset($data['page_data'][$key]);
            //}
        }

        echo json_encode($data);
    }
    
//    
//        function pruebaajaxListaJobOrder($arreglo) {
//        global $db_settings;
//        $arreglo['page_num'] = 1;
//        $arreglo['rows_per_page'] = 10;
//        $arreglo['columns'] =  array();
//        
//        //echo'<pre>';print_r($_POST);echo'</pre>';
//        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
//        $permisos->idMenu = $arreglo["idMenu"];
//
//        $ds = new dacapo($db_settings, null);
//        
//        $selectCount = "SELECT count(o.id) as totalrows ";
//        $select = "SELECT o.avance,o.id, o.idResumenJob,o.idCategoria,o.tipoEstudio,o.estado,o.anio,o.ciclo ";
//        $from = " FROM formato_medicion o ,resumen_job j";
//        $where = " ";
//        $reglaInicial = array();
//        $reglaInicial[0]["condition"]["field"] = "o.idResumenJob";
//        $reglaInicial[0]["condition"]["condition"] = "10";
//        $reglaInicial[0]["condition"]["filterValue"][0] = "j.id";
//        $reglaInicial[0]["condition"]["operator"] = "equal";
//        $reglaInicial[0]["condition"]["filterType"] = "number";
//        $reglaInicial[0]["logical_operator"] = "AND";
//        
//        $reglaInicial[1]["condition"]["field"] = "o.avance";
//        $reglaInicial[1]["condition"]["condition"] = "10";
//        $reglaInicial[1]["condition"]["filterValue"][0] = "10";
//        $reglaInicial[1]["condition"]["operator"] = "equal";
//        $reglaInicial[1]["condition"]["filterType"] = "text";
//        
//        $arreglo['filter_rules'] = array_merge($arreglo['filter_rules'],$reglaInicial);
//        
//        $page_settings = array(
//            "selectCountSQL" => $selectCount . $from . $where,
//            "selectSQL" => $select . $from . $where, // CONFIGURE
//            "page_num" => $arreglo['page_num'],
//            "rows_per_page" => $arreglo['rows_per_page'],
//            "columns" => $arreglo['columns'],
//            "sorting" => isset($arreglo['sorting']) ? $arreglo['sorting'] : array(),
//            "filter_rules" => isset($arreglo['filter_rules']) ? $arreglo['filter_rules'] : $reglaInicial
//        );
//        
//        //$filterrules = implode('|',$arreglo['filter_rules']);
//
//        $jfr = new jui_filter_rules($ds);
//        $arreglo['debug_mode'] = isset($arreglo['debug_mode']) ? $arreglo | ['debug_mode'] : "yes";
//
//        $jdg = new bs_grid($ds, $jfr, $page_settings, true);
//
//        $data = $jdg->get_page_data();
//
//        // data conversions (if necessary)
//        //$data['page_data'][0]['idUsuario'] = str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
//        foreach ($data['page_data'] as $key => $row) {
//            
//            $datosResumenJob = $this->datos->selectResumenJob($row['idResumenJob']);
//            $usuarioNombreJob = $this->datos->datosAsesor($datosResumenJob->idUsuario);
//            $usuarioClienteJob = $this->datos->datosCliente($datosResumenJob->idCliente);
//            
//            //$arreglo['datosResumenJob'] = $this->datos->selectResumenJob($arreglo["idResumenJob"]);
//            //$usuarioNombreJob = $this->datos->retornarNombreUsuarioJob($row['idUsuarioCreador']);
//            //$usuarioClienteJob = $this->datos->retornarNombreClienteJob($row['idCliente']);
//            $nombreCategoria = $this->datos->retornarNombreCategoriaJob($row['idCategoria']);
////            //$data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
////            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
////            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);
//
//            $editar = "";
//            $eliminar = "";
//            if ($permisos->editar == "SI") {
//                $editar = "<a href=\"javascript:void(0)\" onclick=\"editarFormatoMedicion({$row['id']})\"  ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Formato Medicion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
//            }
//
//            $data['page_data'][$key]['idUsuarioCreador'] = $usuarioNombreJob->nombre;
//            $data['page_data'][$key]['idCliente'] = $usuarioClienteJob->nombre;
//            $data['page_data'][$key]['idCategoria'] = $nombreCategoria->nombreCategoria;
//            $data['page_data'][$key]['fechaCreacion'] = $datosResumenJob->fechaCreacion;
//            
//
//           //$data['page_data'][$key]['idOrdenCompra'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['idOrdenCompra']}&idMenu={$permisos->idMenu}\" >{$row['idOrdenCompra']}</a>";
//            $data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['id'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['id'] . "').barIndicator(opt); </script>";
//            $data['page_data'][$key]['acciones'] = $editar . " " . $eliminar;
//            $data['page_data'][$key]['acciones'] = $jdg->get_debug_message();
//        }
//
//         echo'<pre>';print_r($data);echo'</pre>';
//    }
    
    
    
    function traerCabecera($idFormatoMedicion) {
        $arreglo = array();

        $cabecera = $this->datos->traerCabecera($idFormatoMedicion);

        foreach ($cabecera as $key => $row) {
            array_push($arreglo, $row["AreaMetropolitana"]);
        }
        return $arreglo;
    }

    function traerCentroPoblado($idFormatoMedicion) {
        $arreglo = array();

        $centro = $this->datos->traerCentroPoblado($idFormatoMedicion);

        foreach ($centro as $key => $row) {
            array_push($arreglo, $row["ciudad"]);
        }
        return $arreglo;
    }
    
//    function traerCiclo($idFormatoMedicion) {
//        $arreglo = array();
//
//        $ciclo = $this->datos->traerCiclo($idFormatoMedicion);
//
//        foreach ($ciclo as $key => $row) {
//            array_push($arreglo, $row["ciclo"]);
//        }
//        return $arreglo;
//    }
    
    function traerCanal($idFormatoMedicion) {
        $arreglo = array();

        $canal = $this->datos->traerCanal($idFormatoMedicion);

        foreach ($canal as $key => $row) {
            array_push($arreglo, $row["canal"]);
        }
        return $arreglo;
    }
    
    function armarListaSegmento($idCategoria) {
         
        $arreglo = array();

        $segmento = $this->datos->armarListaSegmento($idCategoria);

        foreach ($segmento as $key => $row) {
        $arreglo[$row["idSegmento"]]=$row["nombreSegmento"];
        }
        return $arreglo;
        
    }
    
    function armarListaFabricante($idCategoria) {
         
        $arreglo = array();

        $fabricante = $this->datos->armarListaFabricante($idCategoria);

        foreach ($fabricante as $key => $row) {
        $arreglo[$row["id"]]=$row["nombreFabricante"];
        }
        return $arreglo;        
    }
    
    function armarListaColumnas($arreglo) {
         
        $array_res = array();

        $columna = $this->datos->armarListaColumnas($arreglo["categoria"],$arreglo["seleccion"]);

        foreach ($columna as $key => $row) {
            $array_res[$row["id"]]=$row["nombreAtributo"];
        }
        //return $columna;
        $select_columna = $this->datos->armSelect($array_res,'Columna...',$arreglo["colSeleccion"]);
        echo $select_columna;
    }
    
    function armarListaRegistro($arreglo,$valInterno=true,$selected='NA') {
        
        $listaBasicos = array("categoria","fabricante","marca");
        $array_res = array();
        $resultado = array();
        
        //echo'<pre>';print_r($selected);echo'</pre>';
        
        $arregloCol = explode(',',$arreglo["arregloCol"]);
        $herencia = explode(',',$arreglo["herencia"]);
        //echo'<pre>';print_r($arregloCol);echo'</pre>';
        //echo'<pre>';print_r($herencia);echo'</pre>';
        
        $resultado = $this->datos->armarListaRegistroDinamico($arregloCol,$herencia,$arreglo["columna"]);
        //echo'<pre>';print_r($resultado);echo'</pre>';
        
        //if(in_array($arreglo["columnaAct"], $listaBasicos)){
        //    $resultado = $this->datos->armarListaRegistroDinamico($arreglo["valAnt"],$arreglo["columnaAnt"],$arreglo["columnaAct"],$arreglo["categoria"]);
        //}
       //
//        $columna = $this->datos->armarListaColumnas($arreglo["categoria"],$arreglo["seleccion"]);
//
        foreach ($resultado as $key => $row) {            
            if( $arreglo["columna"]<=3 ){
                $array_res[$row["id"]] = $row["nombre".ucfirst($arregloCol[$arreglo["columna"]-1])];
            }else{
                $array_res[$row["valor"]] = $row["valor"];
            }    
        }
        //return $columna;
        
        if ($arreglo["columna"]<=3){
            $nomAtributo = ucfirst($arregloCol[$arreglo["columna"]-1]);
        }else{
            $nomAtributo = $this->datos->traerNombreAtributo($arregloCol[$arreglo["columna"]-1]);
            $nomAtributo = $nomAtributo->nombreAtributo;
        }
        
        
        $select_registro = $this->datos->armSelect($array_res,'Seleccione ' . $nomAtributo .'...',$selected);
        if($valInterno){
            echo $select_registro;
        }else{
            return $select_registro;
        }
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
    
    function traerGeoSeg($idFormatoMedicion) {
        $arreglo = array();

        $geoSeg = $this->datos->traerGeoSeg($idFormatoMedicion);

        foreach ($geoSeg as $key => $row) {
            array_push($arreglo, $row["geosegmentacion"]);
        }
        return $arreglo;
    }
    
    function traerVarMedicion($idFormatoMedicion,$campo="variableMedicion") {
        $arreglo = array();

        $varMed = $this->datos->traerVarMedicion($idFormatoMedicion);        

        foreach ($varMed as $key => $row) {
            array_push($arreglo, $row[$campo]);
        }
        
        return $arreglo;
    }
    function traerVarMedicionCompleto($idFormatoMedicion) {
        $arreglo = array();

        $varMed = $this->datos->traerVarMedicionCompleto($idFormatoMedicion);

        foreach ($varMed as $key => $row) {
            array_push($arreglo, $row["variableMedicion"]);
        }
        return $arreglo;
    }
    
    function traerVarEspeciales($idFormatoMedicion,$campo="variableEspecial") {
        $arreglo = array();

        $varEsp = $this->datos->traerVarEspeciales($idFormatoMedicion);

        foreach ($varEsp as $key => $row) {
            array_push($arreglo, $row[$campo]);
        }
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        return $arreglo;
    }
    
    function traerColumnasFormato($idFormatoMedicion,$categoria,$editar=true) {
        $arreglo = array();
        
        $exclusion = "";

        $colsFormato = $this->datos->traerColumnasFormato($idFormatoMedicion);
        foreach ($colsFormato as $key => $row) {
            
            if($editar){

                    //echo $exclusion;
                    $columna = $this->datos->armarListaColumnas($categoria,$exclusion);
                    $array_res = array();
                    foreach ($columna as $keyCol => $rowCol) {
                        $array_res[$rowCol["id"]]=$rowCol["nombreAtributo"];
                    }

                    $select_columna = $this->datos->armSelect($array_res,'Columna...',$row["valor"]);
                    $colsFormato[$key]["selectCol"] = $select_columna;
                    $exclusion = $exclusion . ',' . $row["valor"];
                    $exclusion = trim($exclusion,',');
                    $colsFormato[$key]["exclusion"] = $exclusion;

            }else{
                if($row["valor"]!= null && $row["valor"]!= ""){
                    $nomColumna = $this->datos->traerValorColumnas($row["valor"]);
                    $colsFormato[$key]["valor"] = $nomColumna->nombreAtributo;
                }else{
                    $colsFormato[$key]["valor"] = "";
                }
                
                $colsFormato[$key]["tabla"] = $row["tabla"];
            }
        }            

        return $colsFormato;
    }
    
    function  armarMatrizRegistro($idFormatoMedicion,$arregloColumnas=array(),$editar=true){
        $matriz = array();
        
        $registro = $this->datos->traerRegistrosFormato($idFormatoMedicion);
        $variableMedicion = $this->datos->traerVariablesMedicion($idFormatoMedicion);
        
        
        foreach ($registro as $key => $row) {
                $arreglo =  array();
                $matriz[$row["fila"]][$row["columna"]]["valor"]=$row["valor"];
                $matriz[$row["fila"]][$row["columna"]]["herencia"]=$row["herencia"];
                
                $rechazoItem = $this->datos->consultarAprobObsItem($idFormatoMedicion,$row["fila"]);
                
                if(isset($rechazoItem->id)){
                    $nombreUsuario= $this->datos->retornarNombreUsuarioJob($rechazoItem->idUsuario);
                    
                    $matriz["rechazoItem"]="SI";
                    $matriz[$row["fila"]]["rechazo"]["valor"]="SI";
                    $matriz[$row["fila"]]["rechazo"]["obs"]=$rechazoItem->observaciones;
                    $matriz[$row["fila"]]["rechazo"]["nomUsuario"]=$nombreUsuario->nombre;                    
                }                
                
                foreach ($variableMedicion as $keyVarMed => $rowVarMed) {
                    $registroVarMed = $this->datos->traerRegistroVarMedicion($row["id"],$rowVarMed["id"]);
                    if(isset($registroVarMed->valor)){
                        $matriz[$row["fila"]][$rowVarMed["variableMedicion"]] = $registroVarMed->valor;
                    }else{
                        $matriz[$row["fila"]][$rowVarMed["variableMedicion"]] = 'No';
                    }
                }
                
                $arreglo["arregloCol"]=$arregloColumnas;
                $arreglo["herencia"]=$row["herencia"];
                $arreglo["columna"]=$row["columna"];
                if($editar){
                    $matriz[$row["fila"]][$row["columna"]]["select"]=$this->armarListaRegistro($arreglo,false,$row["valor"]);
                }else{
                    if($row["tabla"]!='item_atributo'){
                        $valorRegistro = $this->datos->consultarValorTablaRegistro($row["valor"],$row["tabla"]);
                        $matriz[$row["fila"]][$row["columna"]]["valor"]=$valorRegistro->valor;
                    }
                    
                }
                
            }
        //echo'<pre>';print_r($matriz);echo'</pre>';
        return $matriz;
    }
    
    function traerValorEspecial($arreglo) {        
        
        $valor = $this->datos->traerVarEspecial($arreglo["idFormatoMedicion"],$arreglo["variable"]);
        
        if(isset($valor->valor)){
            echo $valor->valor;
        }else{
            echo "";
        }        
    }
    
    function enviarCorreo($idPedido,$destinatario){
        $to = $destinatario;
        $subject = "Creacion de Pedido para Aprobacion" ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue creado para su aprobacion, por favor ingresar al SGC para"
                . " aprobarlo. Gracias</div>";

        $headers = 'From: fabrica@grupomeiko.co' . "\r\n" ;
        $headers .='Reply-To: '. $to . "\r\n" ;
        $headers .='X-Mailer: PHP/' . phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $resCorreo = mail($to, $subject, $body,$headers);
        //if(mail($to, $subject, $body,$headers)) {
        //    echo('<br>'."Email Sent ;D ".'</br>');
        //} 
        //else 
        //{
        //    echo("<p>Email Message delivery failed...</p>");
        //}
    }
    
    function enviarCorreoAprobacion($idFormatoMedicion,$nomUsuario,$destinatario){
        $to = $destinatario; //"andres.monroy@etlsoluciones.com";
        $subject = "Aprobacion de Formato de Medicion " . $idFormatoMedicion . " " ;
        $body = "<div> Este correo es para informarle que el Formato de Medicion con id <b>" . $idFormatoMedicion . "</b>"
                . " fue aprobado por el usuario <b>" . $nomUsuario . "</b>, por favor ingresar al aplicativo de Fabrica Meiko para"
                . " verificar. Gracias</div>";

        $headers = 'From: fabrica@grupomeiko.co' . "\r\n" ;
        $headers .='Reply-To: '. $to . "\r\n" ;
        $headers .='X-Mailer: PHP/' . phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $resCorreo = mail($to, $subject, $body,$headers);
        //if(mail($to, $subject, $body,$headers)) {
        //    echo('<br>'."Email Sent ;D ".'</br>');
        //} 
        //else 
        //{
        //    echo("<p>Email Message delivery failed...</p>");
        //}
    }
    
    
    function enviarCorreoRechazado($idFormatoMedicion,$nomUsuario,$destinatario){
        $to = $destinatario; // "andres.monroy@etlsoluciones.com";
        $subject = "Rechazo de Formato de Medicion " . $idFormatoMedicion . " " ;
        $body = "<div> Este correo es para informarle que el Formato de Medicion con id <b>" . $idFormatoMedicion . "</b>"
                . " fue rechazado por el usuario <b>" . $nomUsuario . "</b>, por favor ingresar al aplicativo de Fabrica Meiko para"
                . " verificar el motivo del rechazo. Gracias</div>";

        $headers = 'From: fabrica@grupomeiko.co' . "\r\n" ;
        $headers .='Reply-To: '. $to . "\r\n" ;
        $headers .='X-Mailer: PHP/' . phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $resCorreo = mail($to, $subject, $body,$headers);
        //if(mail($to, $subject, $body,$headers)) {
        //    echo('<br>'."Email Sent ;D ".'</br>');
        //} 
        //else 
        //{
        //    echo("<p>Email Message delivery failed...</p>");
        //}
    }
    
    public function crearCodigo($idFormatoMedicion,$herencia){
        
        //echo'<pre>';print_r($idFormatoMedicion);echo'</pre>';
        //echo'<pre>';print_r($herencia);echo'</pre>';
        
        $codigo = "";
        $arrayBasicas = array('CATEGORIA','FABRICANTE','MARCA');
        $arrayHerencia = explode(',', $herencia);
        
        $idCategoria = isset($arrayHerencia[0])?$arrayHerencia[0]:0;
        $idFabricante = isset($arrayHerencia[1])?$arrayHerencia[1]:0;
        $idMarca = isset($arrayHerencia[2])?$arrayHerencia[2]:0;
        
        $estructuraCodigo = $this->datos->traerEstructuraCodigo();
        
        foreach ($estructuraCodigo as $keyEstructura => $rowEstructura){
            
            $valor=0;
            $cantidad=$rowEstructura["posFinal"]-$rowEstructura["posInicial"] + 1;
            $posicionCol = $this->datos->traerValorColumnasFormato($idFormatoMedicion, $rowEstructura["nombre"], $rowEstructura["valor"]);
            
            if(isset($posicionCol->orden)){
                //echo $posicionCol->orden;
                //echo "\n";
                
                if(in_array($rowEstructura["nombre"], $arrayBasicas)){
                    $valor = isset($arrayHerencia[$posicionCol->orden-1])?$arrayHerencia[$posicionCol->orden-1]:0;
                }else{
                    if(isset($arrayHerencia[$posicionCol->orden-1])){
                        if($arrayHerencia[$posicionCol->orden-1] != "NO TIENE"){
                            $idItemAtt =  $this->datos->retornarInfoAtributo($arrayHerencia[$posicionCol->orden-1], $posicionCol->valor , $idCategoria, $idFabricante, $idMarca);
                            $valor = $idItemAtt->id;
                        }else{
                            $valor = 0;
                        }
                    }else{
                        $valor = 0;
                    }
                }
                
                $parte= str_pad($valor, $cantidad , "0", STR_PAD_LEFT); 
            }else{
                
                $parte= str_pad("", $cantidad , "0", STR_PAD_LEFT); 
            }
            
            $codigo = $codigo . $parte;
        }
        return $codigo;
    }
    
    public function crearCodigoCorto($idFormatoMedicion,$herencia){
        
        //echo'<pre>';print_r($idFormatoMedicion);echo'</pre>';
        //echo'<pre>';print_r($herencia);echo'</pre>';
        
        $codigo = "";
        $arrayBasicas = array('CATEGORIA','FABRICANTE','MARCA');
        $arrayHerencia = explode(',', $herencia);
        
        $idCategoria = isset($arrayHerencia[0])?$arrayHerencia[0]:0;
        $idFabricante = isset($arrayHerencia[1])?$arrayHerencia[1]:0;
        $idMarca = isset($arrayHerencia[2])?$arrayHerencia[2]:0;
        
        $estructuraCodigo = $this->datos->traerEstructuraCodigoCorto();
        
        foreach ($estructuraCodigo as $keyEstructura => $rowEstructura){
            
            $valor=0;
            $cantidad=$rowEstructura["posFinal"]-$rowEstructura["posInicial"] + 1;
            $posicionCol = $this->datos->traerValorColumnasFormato($idFormatoMedicion, $rowEstructura["nombre"], $rowEstructura["valor"]);
            
            if(isset($posicionCol->orden)){
                //echo $posicionCol->orden;
                //echo "\n";
                
                if(in_array($rowEstructura["nombre"], $arrayBasicas)){
                    $valor = isset($arrayHerencia[$posicionCol->orden-1])?$arrayHerencia[$posicionCol->orden-1]:0;
                }else{
                    if(isset($arrayHerencia[$posicionCol->orden-1])){
                        if($arrayHerencia[$posicionCol->orden-1] != "NO TIENE"){
                            $idItemAtt =  $this->datos->retornarInfoAtributo($arrayHerencia[$posicionCol->orden-1], $posicionCol->valor , $idCategoria, $idFabricante, $idMarca);
                            $valor = $idItemAtt->id;
                        }else{
                            $valor = 0;
                        }
                    }else{
                        $valor = 0;
                    }
                }
                
                $parte= str_pad($valor, $cantidad , "0", STR_PAD_LEFT); 
            }else{
                
                $parte= str_pad("", $cantidad , "0", STR_PAD_LEFT); 
            }
            
            $codigo = $codigo . $parte;
        }
        return $codigo;
    }
    
    
    function insertarCodigosShopper(){
        ini_set('max_execution_time', 3000);
        $listaItems = $this->datos->listarItemsShopper();        
        echo "inicio";
        $cont = 0;
        
        foreach ($listaItems as $keyItem => $valueItem) {
            $codigo = 0;
            $idCategoria = "";
            $idFabricante = "";
            $idMarca = "";
            $idItemUso = "";
            $idItemPresentacion="";
            $idItemCalorias="";
            $idItemContenido="";
            $idItemUnidades="";
            $idItemVariedad="";
            $idItemEmpaque="";
            $idItemAroma="";
            $idItemSubmarca="";
            $idItemColor="";
            $idItemActProm="";

            $idCategoria = $this->datos->consultarIdTablaRegistro($valueItem["CATEGORIA"],"categoria");
            $idFabricante = $this->datos->consultarIdTablaRegistro($valueItem["FABRICANTE"],"fabricante");
            $idMarca = $this->datos->consultarIdTablaRegistro($valueItem["MARCA"],"marca");
            
            $codigo = $parte= str_pad($idCategoria->id, 10 , "0", STR_PAD_LEFT); 
            $codigo = $codigo . $parte= str_pad($idFabricante->id, 10 , "0", STR_PAD_LEFT);
            $codigo = $codigo . $parte= str_pad($idMarca->id, 10 , "0", STR_PAD_LEFT);            
            
            $idItemUso =  $this->datos->retornarInfoAtributo(trim($valueItem["USO"]), 4 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemUso->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemPresentacion =  $this->datos->retornarInfoAtributo(trim($valueItem["PRESENTACION"]), 5 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemPresentacion->id, 10 , "0", STR_PAD_LEFT);            
            
            $idItemCalorias =  $this->datos->retornarInfoAtributo(trim($valueItem["CALORIAS"]), 8 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemCalorias->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemContenido =  $this->datos->retornarInfoAtributo(trim($valueItem["CONTENIDO"]), 9 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemContenido->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemUnidades =  $this->datos->retornarInfoAtributo(trim($valueItem["UNIDADES"]), 10 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemUnidades->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemVariedad =  $this->datos->retornarInfoAtributo(trim($valueItem["VARIEDAD"]), 11 , $idCategoria->id, $idFabricante->id, $idMarca->id);            
            $codigo = $codigo . $parte= str_pad($idItemVariedad->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemEmpaque =  $this->datos->retornarInfoAtributo(trim($valueItem["EMPAQUE"]), 12 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemEmpaque->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemAroma =  $this->datos->retornarInfoAtributo(trim($valueItem["SABOR_AROMA"]), 13 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemAroma->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemSubmarca =  $this->datos->retornarInfoAtributo(trim($valueItem["SUBMARCA"]), 14 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemSubmarca->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemColor =  $this->datos->retornarInfoAtributo(trim($valueItem["COLOR"]), 15 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemColor->id, 10 , "0", STR_PAD_LEFT);
            
            $idItemActProm =  $this->datos->retornarInfoAtributo(trim($valueItem["ACTIVIDAD_PROMOCIONAL"]), 16 , $idCategoria->id, $idFabricante->id, $idMarca->id);
            $codigo = $codigo . $parte= str_pad($idItemActProm->id, 10 , "0", STR_PAD_LEFT);
            
            $this->datos->insertarRegistroShopper(trim($valueItem["NOMBRESHOPPER"]),$codigo);
                //$contAttr = consultarItemAtributo($valueItem["id"],$valueAtributos["id"]);

    //            if($contAttr->cantidad<2){
    //                insertarNoTieneOtros($valueItem["id"],$valueAtributos["id"]);
    //            }
            }
               
        echo "fin";
    }

}
?>