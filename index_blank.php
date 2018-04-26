<?php
//ini_set('display_errors', 'On');
date_default_timezone_set('America/Bogota');
session_name("ETL");
session_start();
define('entrada_valida', true);
require_once('config.php');
require_once LIB_PATH.'Twig/Autoloader.php';
require_once(CLASSES_PATH.'DatabaseMySQL.php');
require_once(CLASSES_PATH.'BDControlador.php');

require_once(CLASSES_PATH.'bs_grid.php');
require_once(CLASSES_PATH.'jui_filter_rules.php');
require_once(CLASSES_PATH.'dacapo.class.php');
require_once(CLASSES_PATH.'PHPExcel.php');
require_once(CLASSES_PATH.'anexgrid.php');

//require_once(CLASSES_PATH.'ManejoExcepciones/ManejoExcepciones.php');
//set_error_handler('myErrorHandler');
//error_reporting(1);

Twig_Autoloader::register();

global $db;
global $db_settings;
//$excepcion = new ManejoExcepciones();
$db = Database::getInstance(array('localhost','etlsol','ETL.S0L201B','etlsoluciones_portal'));

$db_settings = array(
            'rdbms' => 'MYSQLi',
            'db_server' => 'localhost',
            'db_user' => 'etlsol',
            'db_passwd' => 'ETL.S0L201B',
            'db_name' => 'etlsoluciones_portal',
            'db_port' => '3306'            
);

require_once(CLASSES_PATH.'adicionales.php');

 registrarUltMovimiento();   
if(!isset( $_SESSION['datos_logueo']['usuario'] ) && $_REQUEST['component']!='AccederSistema'){
    echo '<script>window.location="index.php";</script>';
	die();
}
else{
    $component = isset( $_REQUEST['component'] ) ? $_REQUEST['component'] : 'Home';
    $method = isset( $_REQUEST['method'] ) ? $_REQUEST['method'] : 'mostrarAplicacion';
}

$component_path = COMPONENTS_PATH . $component . '/' . $component . '.php';
include $component_path;
$clase = new $component();
$clase->$method($_REQUEST);

?>