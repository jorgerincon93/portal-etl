<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Usuario/vista/vistaUsuario.php';
include_once COMPONENTS_PATH . 'Usuario/modelo/datosUsuario.php';



class Usuario{
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
        $this->datos = new DatosUsuario();
        $this->vista = new VistaUsuario($this->datos);
    }

    public function mostrarUsuarios($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        $permisos->nombreUsr = $_SESSION["datos_logueo"]["nombreUsuario"];
       
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarUsuarios($permisos);    	
    }
    
    function verUsuarios($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $arreglo['mostrarUsuario']=$this->datos->mostrarUsuario($arreglo);
        
	   $this->vista->verUsuario($arreglo['mostrarUsuario']);
    }
    
    function agregarUsuario($arreglo){
        
	    $lista_perfil = $this->datos->build_list('etlsoluciones_portal.rol','id','rol', 'WHERE 1=1 ORDER BY rol ');
    	$arreglo['select_rol'] = $this->datos->armSelect($lista_perfil ,'Seleccione Rol...');
        
      $lista_tipoAcc = $this->datos->build_list('etlsoluciones_portal.listavalor','id','valor', "WHERE tipo='TipoAcceso' ORDER BY valor ");
    	$arreglo['select_tipoAcc'] = $this->datos->armSelect($lista_tipoAcc ,'Seleccione Tipo de Acceso...');
        
      $lista_tipoDoc = $this->datos->build_list('etlsoluciones_portal.listavalor','nombre','valor', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...');
        
      $lista_area = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='Area' ORDER BY valor ");
    	$arreglo['select_area'] = $this->datos->armSelect($lista_area ,'Seleccione el Area...');
        
      $lista_acceso = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='TipoAcceso' ORDER BY valor ");
    	$arreglo['select_acceso'] = $this->datos->armSelect($lista_acceso ,'Seleccione el Tipo de Acceso...');
        
      $lista_estado = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='EstadoUsuario' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
        
      $lista_TipoCon = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='TipoContrato' ORDER BY valor ");
      $arreglo['selectTipoContra'] = $this->datos->armSelect($lista_TipoCon ,'Seleccione el Tipo de Contrato...');

      $lista_cargo = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='Cargo' ORDER BY valor ");
      $arreglo['selectCargo'] = $this->datos->armSelect($lista_cargo ,'Seleccione el Cargo...');

      $lista_emple = $this->datos->build_list('etlsoluciones_portal.empleados','id','nombre', "ORDER BY nombre ");
      $arreglo['selectEmple'] = $this->datos->armSelect($lista_emple ,'Seleccione el Empleado...');
        
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO USUARIO";
        

	    $this->vista->agregarUsuario($arreglo);
    }
    
    function editarUsuario($arreglo){
	       
        //echo'<pre>';print_r($arreglo);echo'</pre>';
         
        $arreglo['datosUsuario']=$this->datos->SelectUsr($arreglo);
        $arreglo['datosUsuario']->jerarquia = $arreglo['datosUsuario']->idPadre;
    
        $lista_estado = $this->datos->build_list('etlsoluciones_portal.listavalor','valor','nombre', "WHERE tipo='EstadoUsuario' ORDER BY valor ");
        $arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',isset($arreglo['datosUsuario']->estado)?$arreglo['datosUsuario']->estado:"");

        $lista_emple = $this->datos->build_list('etlsoluciones_portal.empleados','id','nombre', "ORDER BY nombre ");
        $arreglo['selectEmple'] = $this->datos->armSelect($lista_emple ,'Seleccione el Empleado...',isset($arreglo['datosUsuario']->idEmpleado)?$arreglo['datosUsuario']->idEmpleado:"");

        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR USUARIO " . strtoupper($arreglo['datosUsuario']->login);
        
	     $this->vista->editarUsuario($arreglo);
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
    
    function guardarUsuario($arreglo){
       
     $idRol = $this->datos->traerIdRolUsr($arreglo["selectEmpleado"]);
     $arreglo["idRol"] = $idRol->idRol;
    
	if($arreglo['opcion']=="editar"){
            
            
            if(isset($arreglo["clave"])){
                if(!empty($arreglo["clave"])){
                    $arreglo["clave"]= password_hash($arreglo["clave"], PASSWORD_BCRYPT);                    
                }else{
                    $arreglo["clave"]= null;
                }                
            }else{
                $arreglo["clave"]= null;
            }

         
            $this->datos->actualizarUsuario($arreglo);
            
	}
	else{
            //$id = null;
            //echo'<pre>';print_r($arreglo);echo'</pre>';
            /*$arreglo["salbasi"] = $this->encriptar($arreglo["salbasi"]);
            $arreglo["bonTr"] = $this->encriptar($arreglo["bonTr"]);
            $arreglo["bonAdi"] = $this->encriptar($arreglo["bonAdi"]);*/
            $arreglo["clave"] = password_hash($arreglo["clave"], PASSWORD_BCRYPT);
            $this->datos->insertarUsuario($arreglo);            
	}
        
	   $this->mostrarUsuarios($arreglo);
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

    function eliminarUsuario($arreglo){       

        $this->datos->inactivarUsuario($arreglo["id"]);
        $this->mostrarUsuarios($arreglo);
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


          //$data = $this->datos->selectEmpleados();

          if(!empty($arreglo["searchPhrase"])){

            $query .= 'AND u.id LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.nombre LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.tipoDocumento LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.numeroDocumento LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.area LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.email LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.idRol LIKE "%'.$arreglo["searchPhrase"].'%" ';
            $query .= 'OR u.estado LIKE "%'.$arreglo["searchPhrase"].'%" ';
            

              
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
          $datos = $this->datos->datosUsuario(); 
          $totalrows = count($datos);

          $resultado = array(
            'current' => intval($arreglo["current"]), 
            'rowCount' => 10,
            'total' => intval($totalrows),
            'rows' => $datos
          );
//echo'<pre>';print_r($datos);echo'</pre>';
       echo json_encode($resultado);
    }    
        

        
}



?>


