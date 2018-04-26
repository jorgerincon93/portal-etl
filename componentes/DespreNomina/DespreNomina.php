<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'DespreNomina/vista/vistaDespreNomina.php';
include_once COMPONENTS_PATH . 'DespreNomina/modelo/datosDespreNomina.php';



class DespreNomina{
    /**
     * Variable que almacena un objeto de tipo VistaDespreNomina.
     *
     * @var vista
     */
    private $vista;

    /**
     * Variable que almacena un objeto de tipo DatosDespreNomina.
     *
     * @var datos
     */
    private $datos;

    public function __construct() {
        $this->datos = new DatosDespreNomina();
        $this->vista = new VistaDespreNomina($this->datos);
    }

    public function mostrarAdmLab($arreglo){
    	/** 
    	 * Muestra los DespreNominas del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        $permisos->nombreUsr = $_SESSION["datos_logueo"]["nombreUsuario"];
       
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarAdmLab($permisos);    	
    }
    
function verDespreNomina($arreglo){
        
     $arreglo['mostrarDespreNomina'] = $this->datos->mostrarDespreNomina($arreglo);
        
	   $this->vista->verDespreNomina($arreglo['mostrarDespreNomina']);

}
    
    function agregarDespreNomina($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	      $lista_empleado = $this->datos->build_list('etlsoluciones_portal.empleados','id','nombre', " ORDER BY nombre ");
        $arreglo['select_empleado'] = $this->datos->armSelect($lista_empleado ,'Seleccione el Empleado...');

        $lista_estado = $this->datos->build_list('etlsoluciones_portal.itemnomina','id','descripcion', " ORDER BY descripcion ");
        $arreglo['select_item'] = $this->datos->armSelect($lista_estado ,'Seleccione el Item...');

        $lista_estado = $this->datos->build_list('etlsoluciones_portal.listavalor','id','valor', "WHERE tipo='EstadoItemDespNomi' ORDER BY valor ");
        $arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');


        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO ITEM";
        

	    $this->vista->agregarDespreNomina($arreglo);
    }
    
function editarDespreNomina($arreglo){
	
        $arreglo['datosDespreNomina'] = $this->datos->SelectDespreNomina($arreglo);

        $lista_empleado = $this->datos->build_list('etlsoluciones_portal.empleados','id','nombre', " ORDER BY nombre ");
        $arreglo['select_empleado'] = $this->datos->armSelect($lista_empleado ,'Seleccione el Empleado...',isset($arreglo['datosDespreNomina']->idEmple)?$arreglo['datosDespreNomina']->idEmple:"");

        $lista_estado = $this->datos->build_list('etlsoluciones_portal.itemnomina','id','descripcion', " ORDER BY descripcion ");
        $arreglo['select_item'] = $this->datos->armSelect($lista_estado ,'Seleccione el Item...',isset($arreglo['datosDespreNomina']->idItem)?$arreglo['datosDespreNomina']->idItem:"");

        $lista_estado = $this->datos->build_list('etlsoluciones_portal.listavalor','id','valor', "WHERE tipo='EstadoItemDespNomi' ORDER BY valor ");
        $arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',isset($arreglo['datosDespreNomina']->idEstado)?$arreglo['datosDespreNomina']->idEstado:"");

        $arreglo["idItemEmple"] = $arreglo['datosDespreNomina']->idItemEmple;
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR " . strtoupper($arreglo['datosDespreNomina']->nombre);
        
        
	   $this->vista->editarDespreNomina($arreglo);
}
        
    
function guardarDespreNomina($arreglo){
       
      // echo'<pre>';print_r($arreglo);echo'</pre>';
      
	if($arreglo['opcion']=="editar"){
            
      $this->datos->actualizarDespreNomina($arreglo);
        
	}else{
            
      $this->datos->insertarDespreNomina($arreglo);            
	}
        
	   $this->mostrarDespreNomina($arreglo);
}    
    
    function encriptar($cadena){
         $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        
        return $encrypted; //Devuelve el string encriptado
    }

    function desencriptar($cadena){
        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
       return $decrypted;  //Devuelve el string desencriptado
    }

    function eliminarDespreNomina($arreglo){       

        $this->datos->inactivarDespreNomina($arreglo["id"]);
        $this->mostrarDespreNomina($arreglo);
    }
    
    function datosGrilla($arreglo){
     
        $query= '';
        $data = array();
        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;
        

        // CONFIGURO NUMERO TOTAL DE DATOS
          if(isset($arreglo["rowCount"])) {
              $records_per_page = $arreglo["rowCount"];
          }else{

              $records_per_page = 10;
          }
          
         // CONFIGURO NUMERO DE PAGINA 
          if(isset($arreglo["current"])) {
                $current_page_number = $arreglo["current"];
          }else{
                $current_page_number = 1;
          }

          // CONFIGURO NUMERO DE PAGINA Y DATOS
          $start_from = ($current_page_number - 1) * $records_per_page;


          //$data = $this->datos->selectDespreNominas();

          if(!empty($arreglo["searchPhrase"])){

            $query .= 'AND emit.id LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR emit.nombre LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR emit.descripcion LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR emit.valor LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR emit.mesAnio LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR emit.estado LIKE "%'.$arreglo["searchPhrase"].'%" ';

              
          }


          $orderBy ='';

          if(isset($arreglo["sort"]) && is_array($arreglo["sort"])) {
              
               foreach ($arreglo["sort"] as $key => $value) {
                  $orderBy .= ' emit.' . $key . ' ' . $value .',';
               }
          }else{
              $query .= 'ORDER BY emit.id DESC ';
          }

          if ($orderBy !='') {
              $query .=' ORDER BY ' . substr($orderBy, 0,-1);
          }

          if($records_per_page != -1){
            $query .= " LIMIT " . $start_from . ", " . $records_per_page;  

          }

          
          $data = $this->datos->buscar($query);
          $datos = $this->datos->datosDespreNomina(); 
          $totalrows = count($datos);

          $resultado = array(
            'current' => intval($arreglo["current"]), 
            'rowCount' => 10,
            'total' => intval($totalrows),
            'rows' => $data
          );
      //echo'<pre>';print_r($data);echo'</pre>';
       echo json_encode($resultado);
    }    
        
}



?>


