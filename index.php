<?php
ini_set('display_errors', 'On');
date_default_timezone_set('America/Bogota');
session_name("ETL");
session_start();


define('entrada_valida', true);
require_once('config.php');
require_once LIB_PATH.'Twig/Autoloader.php';
require_once(CLASSES_PATH.'DatabaseMySQL.php');
require_once(CLASSES_PATH.'BDControlador.php');
require_once(CLASSES_PATH.'anexgrid.php');
/** Include PHPExcel */
require_once(CLASSES_PATH.'PHPExcel.php');
//require_once dirname(__FILE__) . '/libraries/classes/PHPExcel.php';

Twig_Autoloader::register();


//CONEXIÓN BASE DE DATOS
$db = Database::getInstance(array('localhost','etlsol','ETL.S0L201B','etlsoluciones_portal'));

require_once(CLASSES_PATH.'adicionales.php');
//registrarUltMovimiento();
if(!isset( $_SESSION['datos_logueo']['usuario'] )){
    $method = 'mostrarLogueo';
}else{
    $method = 'mostrarAplicacion';
}


include COMPONENTS_PATH . 'Home/Home.php';
$clase = new Home();
$clase->$method();


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

