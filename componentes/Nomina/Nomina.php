<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Nomina/vista/vistaNomina.php';
include_once COMPONENTS_PATH . 'Nomina/modelo/datosNomina.php';



class Nomina{
    /**
     * Variable que almacena un objeto de tipo VistaNomina.
     *
     * @var vista
     */
    private $vista;

    /**
     * Variable que almacena un objeto de tipo DatosNomina.
     *
     * @var datos
     */
    private $datos;

    public function __construct() {
        $this->datos = new DatosNomina();
        $this->vista = new VistaNomina($this->datos);
    }

    public function mostrarNomina($arreglo){
    	/** 
    	 * Muestra los Nominas del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        $permisos->nombreUsr = $_SESSION["datos_logueo"]["nombreUsuario"];
       
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarNomina($permisos);    	
    }
    
function verNomina($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $arreglo['mostrarNomina']=$this->datos->mostrarNomina($arreglo);
        
	   $this->vista->verNomina($arreglo['mostrarNomina']);

}
    
    function agregarNomina($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	     
        $lista_tipo = $this->datos->build_list('etlsoluciones_portal.listavalor','id','valor', "WHERE tipo='TipoAporte' ORDER BY valor ");
        $arreglo['select_tipo'] = $this->datos->armSelect($lista_tipo ,'Seleccione el Tipo de Ingreso...');
        
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO ITEM";
        

	    $this->vista->agregarNomina($arreglo);
    }
    
function editarNomina($arreglo){
	
        $arreglo['datosNomina']=$this->datos->SelectNomina($arreglo);

        $lista_tipo = $this->datos->build_list('etlsoluciones_portal.listavalor','id','valor', "WHERE tipo='TipoAporte' ORDER BY valor ");
        $arreglo['select_tipo'] = $this->datos->armSelect($lista_tipo ,'Seleccione el Tipo de Ingreso...',isset($arreglo['datosNomina']->tipo)?$arreglo['datosNomina']->tipo:"");

        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR Nomina " . strtoupper($arreglo['datosNomina']->descripcion);
        
	   $this->vista->editarNomina($arreglo);
}
        
    function validarRepetido($arreglo){
                
		$arreglo['campo']='login';
		$arreglo['valorCampo']=$arreglo['login'];
		$datos=$this->datos->validarRepetido($arreglo);
                //echo $datos;
		if(count($datos)>0){
			print 'invalido';
		}
		else {
			print 'valido';
		}
    }
        
function validarDocumento($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$arreglo['campo']='numeroDocumento';
	$arreglo['valorCampo']=$arreglo['numeroDocumento'];
	$datos=$this->datos->validarRepetido($arreglo);
            if(count($datos)>0){
		print 'invalido';
            }
            else {
		print 'valido';
	}
}
    
function guardarNomina($arreglo){
       
      
	if($arreglo['opcion']=="editar"){
            
      $this->datos->actualizarNomina($arreglo);
        
	}else{
            
      $this->datos->insertarNomina($arreglo);            
	}
        
	   $this->mostrarNomina($arreglo);
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

    function eliminarNomina($arreglo){       

        $this->datos->inactivarNomina($arreglo["id"]);
        $this->mostrarNomina($arreglo);
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


          //$data = $this->datos->selectNominas();

          if(!empty($arreglo["searchPhrase"])){

            $query .= 'AND u.id LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.codigo LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.tipo LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.descripcion LIKE "%'.$arreglo["searchPhrase"].'%" ';          

              
          }


          $orderBy ='';

          if(isset($arreglo["sort"]) && is_array($arreglo["sort"])) {
              
               foreach ($arreglo["sort"] as $key => $value) {
                  $orderBy .= ' u.' . $key . ' ' . $value .',';
               }
          }else{
              $query .= 'ORDER BY u.id DESC ';
          }

          if ($orderBy !='') {
              $query .=' ORDER BY ' . substr($orderBy, 0,-1);
          }

          if($records_per_page != -1){
            $query .= " LIMIT " . $start_from . ", " . $records_per_page;  

          }

          
          $data = $this->datos->buscar($query);
          $datos = $this->datos->datosNomina(); 
          $totalrows = count($datos);

          $resultado = array(
            'current' => intval($arreglo["current"]), 
            'rowCount' => 10,
            'total' => intval($totalrows),
            'rows' => $data
          );
      //echo'<pre>';print_r($datos);echo'</pre>';
       echo json_encode($resultado);
    }    
        
}



?>


