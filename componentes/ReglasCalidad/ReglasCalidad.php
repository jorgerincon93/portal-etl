<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




require_once COMPONENTS_PATH . 'ReglasCalidad/vista/vistaReglasCalidad.php';
include_once COMPONENTS_PATH . 'ReglasCalidad/modelo/datosReglasCalidad.php';

class ReglasCalidad {

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
        $this->datos = new DatosReglasCalidad();
        $this->vista = new VistaReglasCalidad($this->datos);
    }

    public function mostrarReglasCalidad($arreglo) {
        /**
         * Muestra los usuarios del aplicativo
         */
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];
        
        //$permisos->idOrdenCompra = 10;
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';

        $this->vista->mostrarReglasCalidad($permisos);
    }

    function verCliente($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $listaCliente = $this->datos->mostrarCliente($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
        $this->vista->verCliente($listaCliente);
    }

    function agregarReglaCalidad($arreglo) {

        $arreglo["opcion"] = "agregar";
        
        $lista_estado = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='EstadoRegla' ORDER BY valor ");
        $arreglo['select_estado_regla'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...');
        $arreglo['select_estado'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...');
        
        $arreglo['formatoRegla'][0] = array();
        
        $lista_campo = $this->datos->build_list('mapeo_datos', 'id', "CONCAT(campo,' - ',esquema)", " ORDER BY campo ");
        $arreglo['select_campo'] = $this->datos->armSelect($lista_campo, 'Seleccione Campo...');
        $arreglo['formatosRegla'][0]['select_campo'] = $this->datos->armSelect($lista_campo, 'Seleccione Campo...');
        
        $lista_operacion = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaOperacion' ORDER BY valor ");
        $arreglo['select_operacion'] = $this->datos->armSelect($lista_operacion, 'Seleccione Operacion...');
        $arreglo['formatosRegla'][0]['select_operacion'] = $this->datos->armSelect($lista_operacion, 'Seleccione Operacion...');
        
        $lista_conector = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaConector' ORDER BY valor ");
        $arreglo['select_conector'] = $this->datos->armSelect($lista_conector, 'Seleccione Conector...');
        $arreglo['formatosRegla'][0]['select_conector'] = $this->datos->armSelect($lista_conector, 'Seleccione Conector...');
        
        $arreglo['formatosRegla'][0]['select_estado'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...');
        $arreglo['formatosRegla'][0]['orden'] = "1";        
        
        $lista_campo_accion = $this->datos->build_list('mapeo_datos', 'id', "CONCAT(campo,' - ',esquema)", " ORDER BY campo ");
        $arreglo['select_campo_acciones'] = $this->datos->armSelect($lista_campo_accion, 'Seleccione Campo...');
        $arreglo['formatosReglaAccion'][0]['select_campo_acciones'] = $this->datos->armSelect($lista_campo_accion, 'Seleccione Campo...');
        
        $lista_acciones = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaAccion' ORDER BY valor ");
        $arreglo['select_accion_acciones'] = $this->datos->armSelect($lista_acciones, 'Seleccione Accion...');
        $arreglo['formatosReglaAccion'][0]['select_accion_acciones'] = $this->datos->armSelect($lista_acciones, 'Seleccione Accion...');
        
        
        $arreglo['titulo'] = "CREAR REGLA DE CALIDAD";
        $arreglo['datosRegla']['creador'] = $_SESSION['datos_logueo']['nombre'];
        $arreglo['datosRegla']['idCreador'] = $_SESSION['datos_logueo']['idUsuario'];
        $fechaSis = $this->retornarFechaSistemaResumenJob();
        $arreglo['datosRegla']['fechaCreacion'] = $fechaSis;
        
        $this->vista->agregarReglaCalidad($arreglo);
    }

    function editarReglaCalidad($arreglo) {
          
        $arreglo['datosRegla'] = $this->datos->selectReglaCalidad($arreglo["id"]);
        
        $arreglo['datosRegla']->nombreRegla = $arreglo['datosRegla']->nombre;
        
        $arreglo['datosRegla']->descriRegla = $arreglo['datosRegla']->descripcionRegla;
        
        $datosUsuario = $this->datos->datosUsuario($arreglo['datosRegla']->idUsuario);
        $arreglo['datosRegla']->creador = $datosUsuario->nombre;

        if(isset($arreglo['datosRegla']->idUsuarioModificador)){
            $datosUsuarioModificador = $this->datos->datosUsuario($arreglo['datosRegla']->idUsuario);
            $arreglo['datosRegla']->modificador = $datosUsuarioModificador->nombre;        
        }else{
            $arreglo['datosRegla']->modificador = "";
        }
        
        $lista_estado = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='EstadoRegla' ORDER BY valor ");
        $lista_campo = $this->datos->build_list('mapeo_datos', 'id', "CONCAT(campo,' - ',esquema)", " ORDER BY campo ");
        $lista_operacion = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaOperacion' ORDER BY valor ");
        $lista_conector = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaConector' ORDER BY valor ");
        $lista_acciones = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaAccion' ORDER BY valor ");        
        
        $arreglo['select_estado'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...');
        $arreglo['select_estado_regla'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...',$arreglo['datosRegla']->estado);
        $arreglo['select_campo'] = $this->datos->armSelect($lista_campo, 'Seleccione Campo...');
        $arreglo['select_operacion'] = $this->datos->armSelect($lista_operacion, 'Seleccione Operacion...');
        $arreglo['select_conector'] = $this->datos->armSelect($lista_conector, 'Seleccione Conector...');
        
        $formatosRegla = $this->datos->selectDescripcionReglas($arreglo['id']);
        $arreglo['formatosRegla']=$formatosRegla;
        
        foreach($arreglo['formatosRegla'] as $keyFormato => $rowFormato){
            
            $arreglo['formatosRegla'][$keyFormato]["select_campo"] = $this->datos->armSelect($lista_campo,'Seleccione Campo...',$rowFormato["campoOrigen"]);
            $arreglo['formatosRegla'][$keyFormato]["select_operacion"] = $this->datos->armSelect($lista_operacion,'Seleccione Operacion...',$rowFormato["operacion"]);
            $arreglo['formatosRegla'][$keyFormato]["valor"] = $rowFormato["valor"];
            $arreglo['formatosRegla'][$keyFormato]['select_conector'] = $this->datos->armSelect($lista_conector, 'Seleccione Conector...',$rowFormato["conector"]);
            $arreglo['formatosRegla'][$keyFormato]['select_estado'] = $this->datos->armSelect($lista_estado, 'Seleccione Estado...',$rowFormato["estado"]);
            $arreglo['formatosRegla'][$keyFormato]["orden"] = $rowFormato["orden"];           
            
        }
        
        $lista_campo_accion_ver = $this->datos->build_list('mapeo_datos', 'id', "CONCAT(campo,' - ',esquema)", " ORDER BY campo ");
        $lista_acciones_ver = $this->datos->build_list('listavalor', 'valor', 'nombre', "WHERE tipo='ReglaAccion' ORDER BY valor ");
        
        $arreglo['select_campo_acciones'] = $this->datos->armSelect($lista_campo_accion_ver, 'Seleccione Campo...');
        $arreglo['select_accion_acciones'] = $this->datos->armSelect($lista_acciones_ver, 'Seleccione Accion...');
        
        $formatosReglaAccion = $this->datos->selectAccionReglas($arreglo['id']);
        $arreglo['formatosReglaAccion']=$formatosReglaAccion;
        
        foreach($arreglo['formatosReglaAccion'] as $keyFormatoAccion => $rowFormatoAccion){
           
            $arreglo['formatosReglaAccion'][$keyFormatoAccion]["select_campo_acciones"] = $this->datos->armSelect($lista_campo_accion_ver, 'Seleccione Campo...',$rowFormatoAccion["campo"]);
            $arreglo['formatosReglaAccion'][$keyFormatoAccion]["select_accion_acciones"] = $this->datos->armSelect($lista_acciones_ver, 'Seleccione Accion...',$rowFormatoAccion["accion"]);
            $arreglo['formatosReglaAccion'][$keyFormatoAccion]["valorAcciones"] = $rowFormatoAccion["valor"];
        
        } 
        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "EDITAR REGLA DE CALIDAD";
        $arreglo['datosRegla']->idCreador = $_SESSION['datos_logueo']['idUsuario'];

        $this->vista->agregarReglaCalidad($arreglo);
    }

    function guardarReglasCalidad($arreglo) {

        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $ReglasCalidad = json_decode($arreglo["formatosRegla"]);
        $ReglasCalidadAccion = json_decode($arreglo["formatosReglaAccion"]);
        
        if ($arreglo['opcion'] == "editar") {            
            //$listaIdsDescrip = "";
            $idRegla = $arreglo["id"];
            
          //ACTUALIZA REGLA
//            if(isset($ReglasCalidad->idCreador)){
//                    $idModificador = $arreglo["idUsuario"];
//                    echo'<pre>';print_r($idModificador);echo'</pre>';
//                    //$ReglasCalidad->idModificador = $idModificador->id;        
//            }else{
//                    $ReglasCalidad->idCreador = "";
//            }
            $this->datos->actualizarReglaCalidad($arreglo);
          //ACTUALIZA DESCRIPCION REGLA
          //
          //
          //MODIFICAR DESPUES AJUSTE TEMPORAL
          //
          //
            $this->datos->eliminarDescRegla($idRegla);
            foreach ( $ReglasCalidad as $keyRegla => $rowRegla) {
      
                 $ReglasCalidad = $this->datos->insertarDescripRegla($idRegla,$rowRegla);
           }


            // echo'<pre>';print_r($arreglo);echo'</pre>';
//            foreach ($ReglasCalidad as $keyRegla => $rowRegla) {
//                  
//                      if($rowRegla->id != NULL && $rowRegla->id != ""){
//                          $idReglaCalidad = $rowRegla->id;
//                          $this->datos->actualizarDescripRegla($rowRegla);
//                          //$this->datos->borrarDescripRegla($arreglo["id"]);
//                        }else{
//                              //$this->datos->borrarDescripRegla($arreglo["id"]);
//                              $idReglaCalidad = $this->datos->insertarDescripRegla($arreglo["id"], $rowRegla);
//                              //  echo'<pre>';print_r('else');echo'</pre>';
//                        }
//                        
//            } 
       
       //ACTUALIZA ACCION REGLAS  
           $this->datos->eliminarAccionRegla($idRegla);
         foreach ($ReglasCalidadAccion as $keyReglaAccion => $rowReglaAccion){
           //'<pre>';print_r($rowReglaAccion);echo'</pre>';
           //$this->datos->actualizarAccionRegla($rowReglaAccion);
             $ReglasCalidadAccion = $this->datos->insertarAccionReglas($idRegla, $rowReglaAccion);
         }
          
        } else {
//            $arreglo["estado"] = "Creado";
//            $arreglo["cantFormatos"] = count($formatosMedicion);
//            $idResumenJob = $this->datos->insertarResumenJobOrder($arreglo);
//            $this->datos->insertarOrdenCompra($idResumenJob,$arreglo);
           // INSERTA REGLA
            $idRegla = $this->datos->insertarReglasCalidad($arreglo);
              
              $arreglo["idCalidad"] = $idRegla;
              
     // INSERTA DESCRIPCION REGLA   
            foreach ( $ReglasCalidad as $keyRegla => $rowRegla) {
      //              
                 $ReglasCalidad = $this->datos->insertarDescripRegla($idRegla,$rowRegla);
           }
           
         //INSERTA ACCION REGLAS  
         foreach ($ReglasCalidadAccion as $keyReglaAccion => $rowReglaAccion){
           //'<pre>';print_r($rowReglaAccion);echo'</pre>';
             //$ReglasCalidadAccion =
                     $this->datos->insertarAccionReglas($idRegla, $rowReglaAccion);
         }
         // echo'<pre>';print_r($arreglo);echo'</pre>';
           
//                foreach ($rowForm->anio as $keyAnio => $rowAnio) {
//                    //echo'<pre>';print_r($rowAnio);echo'</pre>';
//                  $idFormatosMedicion = $this->datos->insertarFormatoMedicion($idResumenJob, $rowAnio);
//                }
//                foreach ($rowForm->ciclo as $keyCiclo => $rowCiclo) {
////                    echo'<pre>';print_r($rowCiclo);echo'</pre>';
//                 $idFormatosMedicion = $this->datos->insertarFormatoMedicion($idResumenJob, $rowCiclo);
//                }
//                foreach ($rowForm->areaMet as $keyAreaMet => $rowAreaMet) {
////                    echo'<pre>';print_r($rowAreaMet);echo'</pre>';
//                    $this->datos->insertarFormatoMedAreaMet($idFormatosMedicion, $rowAreaMet);
//                }
//                foreach ($rowForm->municipio as $keyMunicipio => $rowMunicipio) {
////                    echo'<pre>';print_r($rowAreaMet);echo'</pre>';
//                    $this->datos->insertarFormatoMedMunicipio($idFormatosMedicion, $rowMunicipio);
//                }
//            }
        }
       $this->vista->verReglasCalidad($idRegla);
    }
    
//        function crearSqlRegla($id){
//        
//        $arreglo['regla'] = $this->datos->selectReglaCalidad($id);
//        
//        $accionRegla = $this->datos->selectAccionReglas($arreglo['regla']->id);
//        $accion = $accionRegla->accion;
//        $campo = $accionRegla->campo;
//        $valor = $accionRegla->valor;
//        $mapeo = $this->datos->traerMapeoDatos($campo);
//        $mapeoDato = $mapeo->campo;
//        $tablaMap = $mapeo->tabla;
//        
//       // ARMA SQL //
//        
//        if($accion == 'UPDATE'){
//            $sql = $accion . ' ' . $tablaMap . ' ' . 'SET ' . ' ' . 
//                     $mapeoDato . '= ' . $valor . ' ' . 'WHERE id = ' . ''. $campo;        
//        }else if($accion == 'SELECT'){
//            $sql = $accion . ' ' . '* FROM ' .$tablaMap . ' ' .  
//                    'WHERE ' .  $mapeoDato . ' = ' . $valor;    
//        }else{
//            $sql = $accion . ' ' . $tablaMap . ' ' . 'SET ' . ' ' . 
//                     $mapeoDato . '= ' . $valor . ' ' . 'WHERE ';        
//        }
//        return $sql;
//      //echo'<pre>';print_r($sql);echo'</pre>';
//        
//    }
    
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
    
    function ajaxListaReglasCalidad($arreglo) {
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];

        $ds = new dacapo($db_settings, null);

        $page_settings = array(
            "selectCountSQL" => "SELECT count(o.id) as totalrows FROM regla o ",
            "selectSQL" => "SELECT id, nombre,fechaCreacion, idUsuario, fechaModificacion, estado, idUsuarioModificador, descripcionRegla, tipoRegla,ordenEjecucionRegla FROM regla", // CONFIGURE
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
//
//
            $usuarioNombre = $this->datos->retornarNombreUsuarioJob($row['idUsuario']);
            $usuarioModificador = $this->datos->retornarNombreUsuarioModificador($row['idUsuarioModificador']);            
////            //$data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
////            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=JobOrder&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
////            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);
//
            $editar = "";
            $eliminar = "";
            if ($permisos->editar == "SI") {
                $editar = "<a href=\"javascript:void(0)\" onclick=\"editarReglaCalidad({$row['id']})\"  ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Regla Calidad\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }
//
            $data['page_data'][$key]['idUsuario'] = $usuarioNombre->nombre;
            $data['page_data'][$key]['idModificador'] = $usuarioModificador->nombre;
//            
//
//            //$data['page_data'][$key]['idOrdenCompra'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['idOrdenCompra']}&idMenu={$permisos->idMenu}\" >{$row['idOrdenCompra']}</a>";
//            //$data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['idJobOrder'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['idJobOrder'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['acciones'] = $editar . " " . $eliminar;
        }

        echo json_encode($data);
    }
    
    function traerCanal($idFormatoMedicion) {
        $arreglo = array();

        $canal = $this->datos->traerCanal($idFormatoMedicion);

        foreach ($canal as $key => $row) {
            array_push($arreglo, $row["idCanal"]);
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
            array_push($arreglo, $row["idCabeceraMunicipal"]);
        }
        return $arreglo;
    }
    
 function traerCentroPoblado($areasMet) {
        $arreglo = array();
        //echo'<pre>';print_r($areasMet);echo'</pre>';
        $textoAreaMet = implode(",",$areasMet);
        $centro = $this->datos->traerCentroPoblado($textoAreaMet);

        foreach ($centro as $key => $row) {
            array_push($arreglo, $row["centroPoblado"]);            
        }
        
        return implode('-',$arreglo);
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

}
?>