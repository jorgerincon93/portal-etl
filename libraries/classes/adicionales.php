<?php

function myErrorHandler($errno, $errstr, $errfile, $errline) {
	$excepcion = new ManejoExcepciones();
	switch ($errno) {
		case 8:
			$excepcion->manejarErrorScript($errfile,$errline,$errstr);
			break;
		case 2048:
		case 2:
			break;
		default:
			echo $errno."<br />".$errstr."<br />".$errfile."<br />".$errline;
			//$excepcion->manejarErrorScript($errfile,$errline, $errstr."--------- CODIGO $errno --------- ");
			break;
	}
	return true;
}

function formatearMes($mesActual){
	$mes = "Indefinodo mes";
	switch($mesActual){
		case '1': case '01' : $mes = "Enero"; break;
		case '2': case '02' : $mes = "Febrero"; break;
		case '3': case '03' : $mes = "Marzo"; break;
		case '4': case '04' : $mes = "Abril"; break;
		case '5': case '05' : $mes = "Mayo"; break;
		case '6': case '06' : $mes = "Junio"; break;
		case '7': case '07' : $mes = "Julio"; break;
		case '8': case '08' : $mes = "Agosto"; break;
		case '9': case '09' : $mes = "Septiembre"; break;
		case '10' : $mes = "Octubre"; break;
		case '11' : $mes = "Noviembre"; break;
		case '12' : $mes = "Diciembre"; break;
	}
	return $mes;
}

function formatearMesCorto($mesActual){
	$mes = "Indefinodo mes";
	switch($mesActual){
		case '1': case '01' : $mes = "Ene"; break;
		case '2': case '02' : $mes = "Feb"; break;
		case '3': case '03' : $mes = "Mar"; break;
		case '4': case '04' : $mes = "Abr"; break;
		case '5': case '05' : $mes = "May"; break;
		case '6': case '06' : $mes = "Jun"; break;
		case '7': case '07' : $mes = "Jul"; break;
		case '8': case '08' : $mes = "Ago"; break;
		case '9': case '09' : $mes = "Sep"; break;
		case '10' : $mes = "Oct"; break;
		case '11' : $mes = "Nov"; break;
		case '12' : $mes = "Dic"; break;
	}
	return $mes;
}

function build_list($table,$code,$name_camp)
	 {
	 	global $db;
        $sql = "SELECT $code,$name_camp
				FROM $table";	
         
    	$db->query($sql);
		$list = $db->GetArray(); 
		$array = array();
		
		foreach ($list as $key=>$index) 
	    {
		 foreach($index as $keyAux=>$value)
		  {
		   $je = $keyAux;
		   $$je = $value;
		  }
		   $array[$$code] = $$name_camp;
	    }
		return $array;
     }	

	function armSelect($array,  $title = '-',$seleccion='NA' ,$maxCaracteres = 50)
     {
       $returnValue = "<OPTION VALUE=\"\" SELECTED>$title</OPTION> \n";
       foreach($array as $key => $value)
        {
          $selected  = ($seleccion == $key)? ' SELECTED' : '';
	      $returnValue.= "<OPTION VALUE=\""
		  . $key
		  . "\"$selected>"
		  . htmlentities( ucwords( substr($value, 0, $maxCaracteres)), ENT_QUOTES). "</OPTION>\n";
        }
       return $returnValue;
     }
     
/**
 * Recupera del POST los datos para poblar el objeto
 *
 * @param ID $proyecto_id proyecto actual que se esta trabajando 
 * @param OBJECT $objeto_domesa objeto que se va a poblar
*/	
function recuperar_Post(&$objeto_domesa, $campos = array(), $datosPoblar = array()){
	
    $variables_objeto = get_class_vars(get_class($objeto_domesa));
        
    if (count($campos) > 0){
            $variables_objeto = $campos;
    }
    
    foreach($variables_objeto as $variable => $valor){
    	if(count($datosPoblar) > 0){
    		if(isset($datosPoblar[$variable])){
                $objeto_domesa->$variable = utf8_decode($datosPoblar[$variable]);
            }else{
                    if(!empty($datosPoblar[$variable])){
                        $objeto_domesa->$variable = '';
                    }else{
                        $objeto_domesa->$variable = $objeto_domesa->$variable;
                    }
            }
    	}
    	else{
    		if(isset($_REQUEST[$variable])){
                $objeto_domesa->$variable = utf8_decode($_REQUEST[$variable]);
            }else{
                    if(!empty($_REQUEST[$variable])){
                        $objeto_domesa->$variable = '';
                    }else{
                        $objeto_domesa->$variable = $objeto_domesa->$variable;
                    }
            }
    	}  
    }
}

function module_language_return($lenguage, $module){
	$return_value = array();
	if(file_exists("modules/$module/lenguage/$lenguage.php")){
		include("modules/$module/lenguage/$lenguage.php");
		$return_value = $module_strings;
	}
	return $return_value;
}

function __P($datos, $var_dump = null){
	print "<pre>";
	if($var_dump != null){
		var_dump($datos);
	}else{
		print_r($datos);
	}
	print "</pre>";
}

function set_flash($tipo = 'notice', $mensaje = ''){
    clean_flash();
    $_SESSION['flash']['tipo'] = $tipo;
    $_SESSION['flash']['mensaje'] = $mensaje;
}

function get_flash($tipo = 'notice', $mensaje = ''){
    return (isset($_SESSION['flash']) && count($_SESSION['flash']) > 0)?$_SESSION['flash']:false;
}

function clean_flash(){
    unset($_SESSION['flash']);
}

function registrarUltMovimiento(){
    
    if(isset($_SESSION['horaUltimoMovimiento'])){      
             
              $uno = $_SESSION['horaUltimoMovimiento'];
              $dos = date_create(date('d-m-Y H:i:s'));
              
             


              $resta = date_timestamp_get($dos) - date_timestamp_get($uno);
              $tiempo = tiempoMovimiento();
              $movimiento = $tiempo->valor;
             if($resta >= $movimiento){
                session_destroy();
                echo '<script>window.location="index.php";</script>';
                die();
            }else{
                    $_SESSION['horaUltimoMovimiento'] = date_create(date('d-m-Y H:i:s'));
                }
    }else{ 
           $_SESSION['horaUltimoMovimiento'] = date_create(date('d-m-Y H:i:s'));
        }
}

function tiempoMovimiento(){        
        global $db;
            $sql = "SELECT *
                        FROM etlsoluciones_portal.listavalor u
                       WHERE u.tipo = 'MovimientoSesion'";
        $db->query($sql);
        return $db->fetch();
       
}


?>