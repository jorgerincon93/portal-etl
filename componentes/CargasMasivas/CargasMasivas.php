<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




require_once COMPONENTS_PATH . 'CargasMasivas/vista/vistaCargasMasiva.php';
include_once COMPONENTS_PATH . 'CargasMasivas/modelo/datosCargasMasiva.php';

class CargasMasivas {

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
        $this->datos = new DatosCargasMasiva();
        $this->vista = new VistaCargasMasiva($this->datos);
    }

    public function mostrarCargasMasivas($arreglo) {
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

        $this->vista->mostrarCargasMasivas($permisos);
    }

    function verCliente($arreglo) {
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $listaCliente = $this->datos->mostrarCliente($arreglo);
        //echo'<pre>';print_r($Clientees);echo'</pre>';
        $this->vista->verCliente($listaCliente);
    }

    function agregarCargasMasivas($arreglo) {
        
        $arreglo["opcion"] = "crear";
       
        $lista_tipoCargue = $this->datos->build_list('listavalor','valor','nombre', "WHERE tipo='CargasMasiva' ORDER BY valor ");
    	$arreglo['select_tipoCargue'] = $this->datos->armSelect($lista_tipoCargue ,'Seleccione Tipo de Cargue Masivo...');
        
        
        $arreglo['titulo'] = "CARGAR ARCHIVO";
        //echo'<pre>'; echo print_r($_SESSION);echo'</pre>';
        $arreglo["datosCargueArchivo"]["creador"] = $_SESSION['datos_logueo']['nombreUsuario'];
        $arreglo["datosCargueArchivo"]["idUsuario"] = $_SESSION['datos_logueo']['idUsuario'];
        
        $this->vista->agregarCargasMasivas($arreglo);
    }

    function guardarCargaMasiva($arreglo){
        
        //echo '<pre>'; echo print_r($arreglo);echo '</pre>';
       
      IF($arreglo['opcion']=="crear"){  
        if(!isset($_FILES['archivo']) ){
               echo '';
         }else{ 
                $arreglo["datosCargueArchivo"]["nombreArchivo"] = $_FILES['archivo']['name'];
                $arreglo["datosCargueArchivo"]["tmp"] = $_FILES['archivo']['tmp_name'];
                $arreglo["datosCargueArchivo"]["tipoArchivo"]= $_FILES['archivo']['type'];
                $arreglo["datosCargueArchivo"]["tamanoArchivo"] = round($_FILES['archivo']['size']/1024) . ' Kb';
                $arreglo["datosCargueArchivo"]["tipoCargue"] = $arreglo['tipoCargue'];
                $arreglo["datosCargueArchivo"]["idUsuario"] = $_SESSION['datos_logueo']['idUsuario'];
                //$arreglo["datosCargueArchivo"]["estado"] = 'Pendiente';
                
                $CargueArchivo = $arreglo['datosCargueArchivo']["nombreArchivo"];
                $tipoArchivo = $arreglo["datosCargueArchivo"]["tipoArchivo"]= $_FILES['archivo']['type'];
                
                $nombreArchivo = $CargueArchivo;
                $extPermitidas = array('xlsx','xls');
                $partesNombre = explode('.', $nombreArchivo);
                $extension = end($partesNombre);
                $extCorrecta = in_array($extension, $extPermitidas);
                $tipoCorrecto = preg_match('/application\/(vnd.ms-excel)$/', $tipoArchivo);
                if($extension != $extCorrecta){
                   echo '<script language="javascript">alert("TIPO DE ARCHIVO NO ES PERMITIDO, SOLO SE PERMITE ARCHIVOS .XLSX y .XLS");</script>';
                }else{
                        if(file_exists(MASIVOS_PATH. $nombreArchivo)){
                             echo '<script language="javascript">alert("ARCHIVO YA FUE CARGADO: ' . $nombreArchivo . ' ");</script>';
                        }else{
                                move_uploaded_file($_FILES['archivo']['tmp_name'],MASIVOS_PATH . $nombreArchivo);
                                $this->datos->insertarLogCargaMasiva($arreglo["datosCargueArchivo"]);
                                echo '<script language="javascript">alert("ARCHIVO GUARDADO PENDIENTE POR PROCESAR");</script>';
                                
                        }
                }
                    
         }
      } 
        $this->mostrarCargasMasivas($arreglo);
    }
    
    
    function editarCargasMasivas($arreglo) {
          
        $arreglo['datosLogCargaMasiva'] = $this->datos->selectCargasMasiva($arreglo["id"]);
        
        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "AGREGAR CARGA MASIVA";
        $arreglo['datosRegla']->idCreador = $_SESSION['datos_logueo']['idUsuario'];

        $this->vista->agregarCargasMasivas($arreglo);
    }   
    
    
    function ajaxListaCargasMasvias($arreglo) {
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"], $arreglo["idMenu"]);
        $permisos->idMenu = $arreglo["idMenu"];

        $ds = new dacapo($db_settings, null);

        $page_settings = array(
            "selectCountSQL" => "SELECT count(o.id) as totalrows FROM mundolimpieza.logcargamasiva o ",
            "selectSQL" => "SELECT id, tipoCarga,nombreArchivo, tamanoArchivo,filas,columnas, fechaCarga, idUsuarioCarga,estado,fechaProceso FROM mundolimpieza.logcargamasiva", // CONFIGURE
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
            $usuarioNombre = $this->datos->retornarNombreCargasMasivas($row['idUsuarioCarga']);
            
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
            $data['page_data'][$key]['idUsuarioCarga'] = $usuarioNombre->nombreUsuario;
            
//            
//
//            //$data['page_data'][$key]['idOrdenCompra'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=OrdenCompra&method=verOrdenCompra&id={$row['idOrdenCompra']}&idMenu={$permisos->idMenu}\" >{$row['idOrdenCompra']}</a>";
//            //$data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['idJobOrder'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['idJobOrder'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['acciones'] = $editar . " " . $eliminar;
        }

        echo json_encode($data);
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