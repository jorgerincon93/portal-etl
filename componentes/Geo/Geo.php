<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Geo/vista/vistaGeo.php';
include_once COMPONENTS_PATH . 'Geo/modelo/datosGeo.php';


class Geo{
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
        $this->datos = new DatosGeo();
        $this->vista = new VistaGeo($this->datos);
    }
    
    public function mostrarGeo($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
       
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
//       echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarGeo($permisos);    	
    }
    
    function verGeo($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$listaGeo=$this->datos->mostrarGeo($arreglo);
       
	$this->vista->verGeo($listaGeo);
    }
    
    function agregarGeo($arreglo){        

        $arreglo["opcion"] = "agregar";
        
        $arreglo['datosDepto'] = $this->datos->datosDepto($arreglo);
         
        $lista_pais = $this->datos->build_list('geo.pais','id','nombrePais', 'WHERE 1=1 ORDER BY nombrePais ');
        $arreglo['select_pais'] = $this->datos->armSelect($lista_pais ,'Seleccione Pais...');
        
        $lista_depto = array();
        $arreglo['select_depto'] = "";
        //$lista_depto = $this->datos->build_list('geo.departamento','id','NombreDepto', 'WHERE 1=1 ORDER BY NombreDepto ');
        //$this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        $lista_municipio = array();
        $arreglo['select_municipio'] = "";
        //$lista_municipio = $this->datos->build_list('geo.municipio','id','nombreMunicipio', 'WHERE 1=1 ORDER BY nombreMunicipio ');
        //$this->datos->armSelect($lista_municipio ,'Seleccione Municipio...');
        
        //$lista_areaMetropolitana = array();
        //$arreglo['select_areaMetropolitana'] = "";
        $lista_areaMetropolitana = $this->datos->build_list('geo.areametropolitana','id','AreaMetropolitana', 'WHERE 1=1 ORDER BY AreaMetropolitana ');
        $arreglo['select_areaMetropolitana'] = $this->datos->armSelect($lista_areaMetropolitana ,'Seleccione Area Metropolitana...');
        
        $lista_ciudad = array();
        $arreglo['select_ciudad'] = "";
        //$lista_ciudad = $this->datos->build_list('geo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        //$this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        $lista_Localidad = array();
        $arreglo['select_Localidad'] = "";
        //$lista_Localidad = $this->datos->build_list('geo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        //$this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
        
        $lista_subLocalidad = array();
        $arreglo['select_SubLocalidad'] = "";
        //$lista_subLocalidad = $this->datos->build_list('geo.sublocalidad','id','nombreSubLocalidad', 'WHERE 1=1 ORDER BY nombreSubLocalidad ');
        //$this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...');
        
        
        
        
        $lista_codDane = $this->datos->build_list('geo.municipio','id','CodigoDane', 'WHERE 1=1 ORDER BY CodigoDane ');
        $arreglo['select_codDane'] = $this->datos->armSelect($lista_codDane ,'Seleccione Codigo Dane...');
        
        //$arreglo['datosAreaMetropol'] = $this->datos->selectAreaMetropol($arreglo['select_areaMetropolitana']);
        //$arreglo['datosAreaMetropol']->areaMetropol = $arreglo['datosAreaMetropol']->areaMetropolitana;
        
        
        $arreglo['disabled'] ="disabled";
        $arreglo["opcion"] = "agregar";
        $arreglo['titulo_tabla'] = "AGREGAR GEO MASTER";
        
	$this->vista->agregarGeo($arreglo);
    }
    
    function agregarPais($arreglo){
       
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "AGREGAR PAIS";
            
         $this->vista->agregarPais($arreglo); 
         
    }  
    
    function agregarDepto($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        
        $lista_pais = $this->datos->build_list('geo.pais','id','nombrePais', 'WHERE 1=1 ORDER BY nombrePais ');
        $arreglo['select_pais'] = $this->datos->armSelect($lista_pais ,'Seleccione Pais...');
       
        
        $arreglo['titulo_tabla'] = "AGREGAR DEPARTAMENTO";
           
         $this->vista->agregarDepto($arreglo); 
    }
        
    function agregarAreaMetro($arreglo){
        
        $arreglo["opcion"] = "agregar";

        
        $arreglo['titulo_tabla'] = "AGREGAR AREA METROPOLITANA";
           
         $this->vista->agregarAreaMetro($arreglo); 
    }
    
    function agregarCiudad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
       $lista_areaMetropolitana = $this->datos->build_list('geo.areametropolitana','id','AreaMetropolitana', 'WHERE 1=1 ORDER BY AreaMetropolitana ');
        $arreglo['select_areaMetropolitana'] = $this->datos->armSelect($lista_areaMetropolitana ,'Seleccione Area Metropolitana...');
        
        $arreglo['titulo_tabla'] = "AGREGAR CIUDAD";
           
         $this->vista->agregarCiudad($arreglo); 
         
    }  
    
    function agregarMunicipio($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_depto = $this->datos->build_list('geo.departamento','id','NombreDepto', 'WHERE 1=1 ORDER BY NombreDepto ');
        $arreglo['select_depto'] = $this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        $arreglo['titulo_tabla'] = "AGREGAR MUNICIPIO";
           
         $this->vista->agregarMunicipio($arreglo); 
         
    }
    
    function agregarLocalidad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_ciudad = $this->datos->build_list('geo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        $arreglo['select_ciudad'] = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        $arreglo['titulo_tabla'] = "AGREGAR LOCALIDAD";
           
         $this->vista->agregarLocalidad($arreglo); 
         
    }
    
    function agregarSubLocalidad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_Localidad = $this->datos->build_list('geo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        $arreglo['select_Localidad'] = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
        
        
        $arreglo['titulo_tabla'] = "AGREGAR SUBLOCALIDAD";
           
         $this->vista->agregarSubLocalidad($arreglo); 
         
    }
    
    function editarMicrozona($arreglo){        
	
        $arreglo['datosMicrozona'] = $this->datos->mostrarMicrozona($arreglo);
        
        $arreglo['datosMicrozona']->codigoDaneEdit = $arreglo['datosMicrozona']->codigoDane;
        $arreglo['datosMicrozona']->nicEdit = $arreglo['datosMicrozona']->nic;
        $arreglo['datosMicrozona']->nicDaneEdit = $arreglo['datosMicrozona']->nicDane;
        $arreglo['datosMicrozona']->areaKmEdit = $arreglo['datosMicrozona']->areaKm;
        
        $lista_ciudad = $this->datos->build_list('geo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        $arreglo['select_ciudad'] = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...',isset($arreglo['datosMicrozona']->idCiudad)?$arreglo['datosMicrozona']->idCiudad:"");
        
        $lista_municipio = $this->datos->build_list('geo.municipio','id','nombreMunicipio', 'WHERE 1=1 ORDER BY nombreMunicipio ');
        $arreglo['select_municipio'] = $this->datos->armSelect($lista_municipio ,'Seleccione Municipio...',isset($arreglo['datosMicrozona']->idMunicipio)?$arreglo['datosMicrozona']->idMunicipio:"");
        
        $lista_Localidad = $this->datos->build_list('geo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        $arreglo['select_localidad'] = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...',isset($arreglo['datosMicrozona']->idLocalidad)?$arreglo['datosMicrozona']->idLocalidad:"");
        
        $lista_subLocalidad = $this->datos->build_list('geo.sublocalidad','id','nombreSubLocalidad', 'WHERE 1=1 ORDER BY nombreSubLocalidad ');
        $arreglo['select_SubLocalidad'] = $this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...',isset($arreglo['datosMicrozona']->idSubLocalidad)?$arreglo['datosMicrozona']->idSubLocalidad:"");
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR MICROZONA";
       
        
	$this->vista->editarMicrozona($arreglo);
        
    }        
    
    function guardarMircozona($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarMicrozona($arreglo);
	}else{
            $this->datos->insertarMicrozona($arreglo);            
	}
        
        $this->mostrarGeo($arreglo);

    }
    
    function guardarPais($arreglo){
            
        $selPais = $this->datos->validaPais($arreglo);
          
            if(count($selPais)>0){
                $mensaje = "EL PAIS "  . $arreglo["nuevPais"] . " YA EXISTE";
                echo "<script type='text/javascript'>alert('$mensaje');</script>";
                     
                 }else{
                     $this->datos->insertarPais($arreglo);
                 }
                      
        $this->agregarGeo($arreglo);
    }
    
    function guardarDepto($arreglo){
              
        $selDepto = $this->datos->validaDepto($arreglo);
          
            if(count($selDepto)>0){                     
                $mensaje = "LA COMBINACION YA EXISTE";
                echo "<script type='text/javascript'>alert('$mensaje');</script>";     
                
            }else{
                     $this->datos->insertarDepto($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
    
    function guardarCiudad($arreglo){
        
        $selCiudad = $this->datos->validaCiudad($arreglo);  
          
            if(count($selCiudad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                    echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     $this->datos->insertarCiudad($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
 
    function guardaAreaMetropol($arreglo){
        
        $selAreaMetropol = $this->datos->validaAreaMetropol($arreglo);  
          
            if(count($selAreaMetropol)>0){                     
                     $mensaje = "EL AREA METROPOLITANA "  . $arreglo["nuevAreaMetropol"] . " YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarAreaMetropol($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
    
    function guardaMunicipio($arreglo){
        
        $selMunicipio = $this->datos->validaMunicipio($arreglo);  
          
            if(count($selMunicipio)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarMunicipio($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
    
    function guardarLocalidad($arreglo){
        
        $selLocalidad = $this->datos->validaLocalidad($arreglo);  
          
            if(count($selLocalidad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarLocalidad($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
    
    function guardarSubLocalidad($arreglo){
        
        $selSubLocalidad = $this->datos->validaSubLocalidad($arreglo);  
          
            if(count($selSubLocalidad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarSubLocalidad($arreglo);
                 }
                        
        $this->agregarGeo($arreglo);
    }
    
    function inactivarGeo($arreglo){  
      
       //echo'<pre>';print_r($arreglo);echo'</pre>';
       $this->datos->inactivarGeo($arreglo["id"]);
       $this->mostrarGeo($arreglo);
    }        
    
    function ajaxListaGeo($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(id) as totalrows FROM geo.vista_microzona",              
                "selectSQL" => "SELECT mic.id, mic.idCiudad, mic.idMunicipio, mic.ciudad,mic.nombreMunicipio,mic.CodigoDane, mic.nic, mic.nicDane, mic.areaKm, mic.idLocalidad, mic.idSubLocalidad,mic.nombreLocalidad,mic.nombreSubLocalidad  FROM geo.vista_microzona mic",
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
     
         foreach($data['page_data'] as $key => $row) {
            
            // $nombreCiudad = $this->datos->retornarNombreCiudad($row['idCiudad']);
             
         /* if(isset($row['idUsuarioModificador'])){
              $usuarioNombre = $this->datos->retornarNombreUsuarioGeo($row['idUsuarioModificador']);
              $data['page_data'][$key]['idUsuarioModificador'] = $usuarioNombre->nombre;
          }else{
             $row['idUsuarioModificador'] = ""; 
          }*/
             
              //$data['page_data'][$key]['idCiudad'] = $nombreCiudad->ciudad;
             
            $editar = "";
            $eliminar = "";
            
            if($permisos->editar =='SI'){
                
               $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Geo&method=editarMicrozona&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Geo\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
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
    
    function consultarDepto($arreglo){
        
        $lista_depto = $this->datos->build_list('geo.departamento','id','NombreDepto', "WHERE idPais IN (" . $arreglo["idPais"] . ") ORDER BY NombreDepto ");
        $select_depto = $this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        echo $select_depto;    
        
    }
    
    function consultarMuni($arreglo){
        
        $lista_municipio = $this->datos->build_list('geo.municipio','id','nombreMunicipio', "WHERE idDepto IN (" . $arreglo["idDepto"] . ") ORDER BY nombreMunicipio ");
        $select_municipio = $this->datos->armSelect($lista_municipio ,'Seleccione Municipio...');
        
        echo $select_municipio;    
        
    }
    
    function consultarCiudad($arreglo){
        
        $lista_ciudad = $this->datos->build_list('geo.ciudad','id','ciudad', "WHERE idAreaMetropolitana IN (" . $arreglo["areaMetropolitana"] . ") ORDER BY ciudad ");
        $select_ciudad = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        echo $select_ciudad;    
        
    }
    
    function consultarLocalidad($arreglo){
        
       $lista_Localidad = $this->datos->build_list('geo.localidad','id','nombreLocalidad', "WHERE idCiudad IN (" . $arreglo["idCiudad"] . ") ORDER BY nombreLocalidad ");
       $select_Localidad = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
       
       echo $select_Localidad;
    }
    
    function consultarSubLocalidad($arreglo){
        
       $lista_subLocalidad = $this->datos->build_list('geo.sublocalidad','id','nombreSubLocalidad', "WHERE idLocalidad IN (" . $arreglo["localidad"] . ") ORDER BY nombreSubLocalidad ");
       $select_SubLocalidad = $this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...');
       
       echo $select_SubLocalidad;
    }
}

?>


