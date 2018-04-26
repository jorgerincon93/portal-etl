<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Pedidos/vista/vistaPedidos.php';
include_once COMPONENTS_PATH . 'Pedidos/modelo/datosPedidos.php';
require_once 'libraries/classes/dompdf/dompdf_config.inc.php';




class Pedidos{
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
        $this->datos = new DatosPedidos();
        $this->vista = new VistaPedidos($this->datos);
    }
    
    public function mostrarPedidos($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        
        $idTipoAcceso = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $tipoAcceso =  $this->datos->traerTipoAcceso($idTipoAcceso->idTipoAcceso);
        
          if(isset($tipoAcceso->nomAcceso)){
              $this->datos->crearVistaUsuario($idTipoAcceso->id,$idTipoAcceso->idTipoAcceso,$tipoAcceso->nomAcceso);
               
          }
          
        //echo'<pre>';print_r($idTipoAcceso);echo'</pre>';
        //echo'<pre>';print_r($tipoAcceso);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarPedidos($permisos);    	
    }
    
    function verPedido($arreglo){
        
        
        $arreglo["datosPedidos"] = $this->datos->datosPed($arreglo["id"]);
        
        $puntoServicio = $this->datos->retornarNomPuntSer($arreglo["datosPedidos"]->idPuntoServicio);
        $nombreAsesor = $this->datos->datosAsesor($arreglo["datosPedidos"]->idUsuarioElaboro);
        $contrato = $this->datos->traerContrato($arreglo["datosPedidos"]->idUsuarioElaboro);
        
        $arreglo["datosPedidos"]->nombreAsesor = $nombreAsesor->nombreUsuario;
        $arreglo["datosPedidos"]->puntoServicio = $puntoServicio->nomPuntSer;
        $arreglo["datosPedidos"]->contrato = $contrato[0]["numeroContrato"];
        $arreglo["datosPedidos"]->reviso = $contrato[0]["numeroContrato"];
        $arreglo["datosPedidos"]->aprobo = $contrato[0]["numeroContrato"];
        
        
        $arreglo["detallePedido"] = $this->datos->traerDetallePedido($arreglo["id"]);
        
        
        
        foreach ($arreglo["detallePedido"] as $key => $valueDet) {
               
               $arreglo["detallePedidoIni"] = $this->datos->traerDetallePedidoIni($arreglo["id"],$valueDet["idProducto"]);
               
               foreach ($arreglo["detallePedidoIni"] as $keyDet => $value) {
                   
                   $arreglo["detPed"][$key]["nombre"] = $valueDet["nombre"] . ' ' . $valueDet["serial"];
                   $arreglo["detPed"][$key]["referencia"] = $valueDet["tamano"];
                   $arreglo["detPed"][$key]["cantidad"] = $value["cantidad"];
               }
              
                  
                
        }
       
        
        $arreglo["titulo"] = 'DETALLE PEDIDO';
	$this->vista->verPedidos($arreglo);
    }
    
    function imprimirPedido($arreglo){
        
        
        $arreglo["datosPedidos"] = $this->datos->datosPed($arreglo["id"]);
        
        $puntoServicio = $this->datos->retornarNomPuntSer($arreglo["datosPedidos"]->idPuntoServicio);
        $nombreAsesor = $this->datos->datosAsesor($arreglo["datosPedidos"]->idUsuarioElaboro);
        $contrato = $this->datos->traerContrato($arreglo["datosPedidos"]->idUsuarioElaboro);
        
        $arreglo["datosPedidos"]->nombreAsesor = $nombreAsesor->nombreUsuario;
        $arreglo["datosPedidos"]->puntoServicio = $puntoServicio->nomPuntSer;
        $arreglo["datosPedidos"]->contrato = $contrato[0]["numeroContrato"];
        $arreglo["datosPedidos"]->reviso = $contrato[0]["numeroContrato"];
        $arreglo["datosPedidos"]->aprobo = $contrato[0]["numeroContrato"];
        
        
        $arreglo["detallePedido"] = $this->datos->traerDetallePedido($arreglo["id"]);
        
        
        
        foreach ($arreglo["detallePedido"] as $key => $valueDet) {
               
               $arreglo["detallePedidoIni"] = $this->datos->traerDetallePedidoIni($arreglo["id"],$valueDet["idProducto"]);
               
               foreach ($arreglo["detallePedidoIni"] as $keyDet => $value) {
                   
                   $arreglo["detPed"][$key]["nombre"] = $valueDet["nombre"] . ' ' . $valueDet["serial"];
                   $arreglo["detPed"][$key]["referencia"] = $valueDet["tamano"];
                   $arreglo["detPed"][$key]["cantidad"] = $value["cantidad"];
               }
              
                  
                
        }
        
        
        $this->vista->generarPdf($arreglo);
    }
    
    function agregarPedidos($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        $idUsuario = $_SESSION['datos_logueo']['idUsuario'];
        $arreglo["contrato"] = $this->datos->traerContrato($_SESSION['datos_logueo']['idUsuario']);
        
        $lista_punto_serv = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo='PuntoServicio' ORDER BY valor ");
    	$arreglo['select_punto_serv'] = $this->datos->armSelect($lista_punto_serv ,'Seleccione el Punto de Servicio...');
        
        $lista_contrato = $this->datos->build_list('mundolimpieza.ordencompra','id','numeroContrato', "WHERE idUsuario= $idUsuario ORDER BY numeroContrato ");
        $arreglo['select_contrato'] = $this->datos->armSelect($lista_contrato,'Seleccione el Contrato...');
        
        
        $fechaSis = $this->retornarFechaSistema();
        $arreglo['datosPedidos']['fechaSis'] = $fechaSis;
        $arreglo['datosPedidos']['dia'] =  date("d");
        $arreglo['datosPedidos']['mes'] =  date("m");
        $arreglo['datosPedidos']['asesor'] = $_SESSION['datos_logueo']['nombreUsuario'];
        $arreglo['datosPedidos']['idAsesor'] = $idUsuario;
        
        
        $arreglo['disabled'] ="disabled";
        $arreglo['titulo_tabla'] = "DESPACHO DE PEDIDO";        
	$this->vista->agregarPedidos($arreglo);
    }
    
    function traerProductosContra($arreglo){
        
        $idEstadoOferProdOk = $this->datos->traerIdEstadoOferProdOK();
        $arreglo["productosOrden"] = $this->datos->traerProduOrdenCompra($arreglo["idOrdenCompra"],$idEstadoOferProdOk->idEstadoOferProdOk);        
        $arreglo["productosOrden"]["canLineas"] = count($arreglo["productosOrden"]);
        $arreglo["productosOrden"]["nomTd1"] = "desc";
        $arreglo["productosOrden"]["nomTd2"] = "unMed";
        $arreglo["productosOrden"]["nomTd3"] = "canDis";
        
        
        echo json_encode($arreglo["productosOrden"]);
        
    }
            
    function editarPedidos($arreglo){        
	
        $arreglo['datosCliente']=$this->datos->datosCliente($arreglo);
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='EstadoCliente' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...',isset($arreglo['datosCliente']->estado)?$arreglo['datosCliente']->estado:"");        
        
        $lista_tipoDoc = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...',isset($arreglo['datosCliente']->tipoDocumento)?$arreglo['datosCliente']->tipoDocumento:"");
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR CLIENTE " . strtoupper($arreglo['datosCliente']->nombre);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarPedidos($arreglo);
    }        
   
    function guardarPedidos($arreglo){
        
       
       $arreglo["pedidos"] = json_decode($arreglo["pedido"],true);
      
	   
            //INSERTO PEDIDO ENCABEZADO PEDIDO
                 $idPedido = $this->datos->insertarEncaPedido($arreglo);
                
               foreach ($arreglo["pedidos"] as $key => $valuePed) {
                    
                   $this->datos->insertarDetPedidoIni($valuePed,$idPedido);
    
                }

        
	$this->mostrarPedidos($arreglo);
    }    
    
    function aprobarPedido($arreglo) {

        $arreglo['datosPedidos'] = $this->datos->datosPedido($arreglo["id"]);
        $arreglo["productosPedido"] = $this->datos->productosPedido($arreglo['datosPedidos'][0]["idOrdenCompra"]);
        $arreglo["detProdPedidoIni"] = $this->datos->detProdPedidoIni($arreglo['datosPedidos'][0]["id"]);
        $arreglo["idPedido"] = $arreglo["id"];
        $nomPuntSer = $this->datos->retornarNomPuntSer($arreglo['datosPedidos'][0]["idPuntoServicio"]);
        
		
        foreach ($arreglo["detProdPedidoIni"] as $key => $valuePed) {
             
            $arreglo["productosPedido"][$key]["cantidadSol"] = $valuePed["cantidad"];
        }
        
        $arreglo['datosPedidos']['nomPuntSer'] = $nomPuntSer->nomPuntSer;
        $arreglo['datosPedidos']['numeroContrato'] = $arreglo["productosPedido"][0]["numeroContrato"];
        
        if($_SESSION['datos_logueo']['idRol']=='2' || $_SESSION['datos_logueo']['idRol']=='5' || $_SESSION['datos_logueo']['idRol']=='6'){
            
              $arreglo["metodoEnvio"] = "Inicial";
            
        }else{
            
            $arreglo["metodoEnvio"] = "";
        }
        
        $fechaSis = $this->retornarFechaSistema();
        $arreglo['datosPedidos']['fechaSis'] = $fechaSis;
        $arreglo['datosPedidos']['dia'] =  date("d");
        $arreglo['datosPedidos']['mes'] =  date("m");
        $arreglo['datosPedidos']['asesor'] = $_SESSION['datos_logueo']['nombreUsuario'];
        
        //echo'<pre>';print_r($arreglo['productosPedido']);echo'</pre>';
        
        $arreglo["opcion"] = "editar";
        $arreglo['titulo'] = "APROBAR PEDIDO";
        
       $this->vista->aprobarPedido($arreglo);
    }
    
    function aprobarPedidoInicial($arreglo){
        

        $perfilesAprobacionAlam = $this->datos->traerPerfilesAprobacionAlma();//array("1","2","3","4","6","7","8");
        $perfilesAprobacion = $this->datos->traerPerfilesAprobacion();
	$cantPerfiles = count($perfilesAprobacionAlam);
        $porPerfiles = (8/$cantPerfiles);
        $infoUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);        
	$tipoPreAprobador = $this->datos->tipoPreAprobador($_SESSION["datos_logueo"]["idUsuario"]);
        $correoPadre = $this->datos->TraercorreoPadre($infoUsuario->idPadre);
        $datosUsuarioCreador = $this->datos->traerCorreoUsrCreador($arreglo["idPedido"]);
        $pedidoAprob = $this->datos->pedidoAprob($arreglo["idPedido"]);
        $fechaSis = $this->retornarFechaSistema();
        $correoUsuario = '';
        $correo = '';
        $correoMasivo = ',';
        $estado="Pendiente";
			
	
    if($arreglo["resAprobar"] != "Rechazar"){
        if(isset($tipoPreAprobador->nombre)){
          if($tipoPreAprobador->nombre == "Comercial" || $tipoPreAprobador->nombre == "Cliente"){
                    foreach ($perfilesAprobacionAlam as $keyPerfil => $rowPerfilAlma){ 
                        
                        
                             if($rowPerfilAlma["nombre"] == "Almacen"){
                                 $this->datos->insertarAprobacion($arreglo["idPedido"],$rowPerfilAlma["valor"],"Pre Aprobado",$porPerfiles);
                                 $correoUsuario = $correoPadre->email;
                                 
                                 
                               }
                    }
                 
                $correo = $correoUsuario;
                $infoUsuario->idRol =1;
                $this->datos->actualizarEstadoPreAprobacion($arreglo["idPedido"],$infoUsuario->idRol,"Pre Aprobado", $infoUsuario->id,$arreglo["obsGenerales"]);
                $this->datos->actualizarEstadoPedidoPreAprobado($arreglo["idPedido"],"Pre Aprobado",$porPerfiles);
                
                $this->enviarCorreo($arreglo["idPedido"],$correo ,$infoUsuario->email);
            
                
            }
            
        }else{
                
                
               foreach ($perfilesAprobacionAlam as $key => $valueAlm){
                    
                    if(isset($valueAlm["nombre"])){

                          if($valueAlm["nombre"] == "Almacen"){
                              
                              
                              foreach ($perfilesAprobacion as $keyPerfil => $rowPerfil){ 
                                  
                                   $estado = "Pendiente Gerencia";
                                   $this->datos->actualizarEstAprobacion($arreglo["idPedido"],$estado, $infoUsuario->id);
                                   $correoMasivo = $correoMasivo . $rowPerfil["texto"] . ',';
                                   
                              }
                        
                                $correo = trim($correoMasivo,',');
                                $this->datos->actualizarEstadoPedidoPreAprobado($arreglo["idPedido"],"Pendiente Gerencia",$porPerfiles);
                                $this->datos->actualizaEstadosPedido($arreglo["idPedido"],$_SESSION["datos_logueo"]["idUsuario"],$fechaSis,$pedidoAprob->idUsuarioAprobo);
                                
                                $datoPedAprob = $this->datos->traerUsrAlama($arreglo["idPedido"]);
                                $this->enviarCorreoAprobacionAlma($arreglo["idPedido"],$correo,$infoUsuario->email,$datoPedAprob->nombreUsuario);
                              
                          }    
                    
                    }
            
                }
                    
                    
            }
       }else{
           
           $estado="Rechazado";
           $this->datos->rechazarEstadoAprobacion($arreglo["idPedido"],$estado, $infoUsuario->id,$arreglo["obsGenerales"],$infoUsuario->idRol);
           $this->datos->rechazarEstadoFormato($arreglo["idPedido"],$estado);
           $this->enviarCorreoRechazado($arreglo["idPedido"],$infoUsuario->nombreUsuario,$datosUsuarioCreador->email,$infoUsuario->email);
           
           
       }
        $this->mostrarPedidos($arreglo);
    }
    
    
    function aprobarPedidoProceso($arreglo) {
        
        
        $infoUsuario = $this->datos->datosAsesor($_SESSION["datos_logueo"]["idUsuario"]);
        $datosPedido = $this->datos->datosPed($arreglo["idPedido"]);        
        $emailUser = $this->datos->traerCorreoUsrCreador($arreglo["idPedido"]);
        //$datosAprobacion = $this->datos->mostrarPermisoAprobacion($arreglo["idPedido"],$infoUsuario->idRol);
        $datosUsuarioCreador = $this->datos->traerCorreoUsrCreador($arreglo["idPedido"]);
        $pedidoAprob = $this->datos->pedidoAprob($arreglo["idPedido"]);
        $tipoUsr = $this->datos->tipoUsr($_SESSION["datos_logueo"]["idUsuario"]);
        $fechaSis = $this->retornarFechaSistema();
        $nombreProd = ',';
        
        if($arreglo["resAprobar"] =="Aprobar" && $tipoUsr->nombre == "Administrador" || $tipoUsr->nombre == "Gerencia"){
              $avance = $datosPedido->avance + 70;
                if ($avance <80){
                     $estado="Aprobado";
                }/*else{
                        $estado="Pendiente Aprobacion";
                    }-*/
            
            $resPedido = $this->aprobarProductos($arreglo);
            $cantIndi = count($resPedido);
            $numOK = 0;
            $numNoOK = 0;
           
            foreach ($resPedido as $key => $value) {
                
                 if($value["ok"] == 'OK'){
                     
                      $numOK = $numOK + 1;
                     
                 }else{
                     
                     $numNoOK = $numNoOK + 1;
                     $nombreProd = $nombreProd . $value["ok"] . ',';
                 }
                
                
            }
            
            $nombreProd = trim($nombreProd,',');
             
            if($numOK === $cantIndi){
              
                
               $emailCliente = $this->datos->traerCorreoCliente($arreglo["idPedido"]);
               $this->datos->actualizarApro($arreglo["idPedido"],"Aprobado", $infoUsuario->id,$arreglo["obsGenerales"]);
               $this->datos->actualizarEstadoPedidoPreAprobado($arreglo["idPedido"],$estado,$avance);
               $this->datos->actualizaEstadosPedido($arreglo["idPedido"],$id_usuario = $_SESSION["datos_logueo"]["idUsuario"],$fechaSis,$pedidoAprob->idUsuarioAprobo);
               $this->enviarCorreoAprobacion($arreglo["idPedido"],$infoUsuario->nombreUsuario,$infoUsuario->email,$emailCliente->email,$emailUser->email);
               
            }else{
                
                    $estado = "Rechazado, Por Favor Validar El Correo";
                    $this->datos->rechazarEstadoAprobacion($arreglo["idPedido"],$estado, $infoUsuario->id,$arreglo["obsGenerales"],$infoUsuario->idRol);
                    $this->datos->rechazarEstadoFormato($arreglo["idPedido"],$estado);
                    $this->enviarCorreoRechazadoProceso($arreglo["idPedido"],$infoUsuario->nombreUsuario,$datosUsuarioCreador->email,$infoUsuario->email,$nombreProd);
            }
           
            
            
        }else{
                    $estado="Rechazado";
                    $this->datos->rechazarEstadoAprobacion($arreglo["idPedido"],$estado, $infoUsuario->id,$arreglo["obsGenerales"],$infoUsuario->idRol);
                    $this->datos->rechazarEstadoFormato($arreglo["idPedido"],$estado);
                    $this->enviarCorreoRechazado($arreglo["idPedido"],$infoUsuario->nombreUsuario,$datosUsuarioCreador->email,$infoUsuario->email);
        }
        
       $this->mostrarPedidos($arreglo);
        
    }
    
    function enviarCorreo($idPedido,$destinatario,$de){
        
        $to = $destinatario;
        $subject = "Creacion de Pedido para Aprobacion" ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue creado para su aprobacion, por favor ingresar al SGC para"
                . " aprobarlo. Gracias</div>";

        $headers = 'From: ' . $de . "\r\n" ;
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
    
    function enviarCorreoAprobacionAlma($idPedido,$destinatario,$de,$nomUsuario){
        
        $to = $destinatario;
        $subject = "Aprobacion de Pedido " . $idPedido . " " ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue aprobado por el usuario <b>" . $nomUsuario . "</b>, por favor ingresar al aplicativo SGC para"
                . " verificar. Gracias</div>";

        $headers = 'From: ' . $de . "\r\n" ;
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
    
    function enviarCorreoAprobacion($idPedido,$nomUsuario,$de,$emailCliente,$destinatario){
        
        $to = $emailCliente . "," . $destinatario;
        
        $subject = "Aprobacion de Pedido " . $idPedido . " " ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue aprobado por el usuario <b>" . $nomUsuario . "</b>, por favor ingresar al aplicativo SGC para"
                . " verificar. Gracias</div>";
        
        $headers = 'From: ' . $de . "\r\n" ;
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
    
    function enviarCorreoRechazado($idPedido,$nomUsuario,$destinatario,$de){
        
        $to = $destinatario;
        $subject = "Rechazo de Pedido " . $idPedido . " " ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue rechazado por el usuario <b>" . $nomUsuario . "</b>, por favor ingresar al aplicativo SGC para"
                . " verificar el motivo del rechazo. Gracias</div>";

        $headers = 'From: ' . $de . "\r\n" ;
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
    
    function enviarCorreoRechazadoProceso($idPedido,$nomUsuario,$destinatario,$de,$nombreProducto){
        
        $to = $destinatario;
        $subject = "Rechazo de Pedido " . $idPedido . " " ;
        $body = "<div> Este correo es para informarle que el Pedido con id <b>" . $idPedido . "</b>"
                . " fue rechazado por el usuario <b>" . $nomUsuario . "</b>, ya que los productos: " . $nombreProducto . " no se encuentran disponibles por favor solicitar al almacen dichos productos"
                . "</div>";

        $headers = 'From: ' . $de . "\r\n" ;
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
    
    function aprobarProductos($arreglo){
        
          
         $arreglo["detProdPedidoIni"] =  $this->datos->detProdPedidoIni($arreglo["idPedido"]);
         $idEstadoEnUso  = $this->datos->traerIdEstadoUso();
         $pedidoAprob = $this->datos->pedidoAprob($arreglo["idPedido"]);
         $respuestaPedido = "";
         $arreglo["idDetProd"] = array();
            //Actualiza estado producto a En Uso
             
            foreach ($arreglo["detProdPedidoIni"] as $key => $valueDetPed) {
                
                     $arreglo["idDetProd"][$key]["detProd"] = $this->datos->detProductos($valueDetPed["idProducto"],$valueDetPed["cantidad"]);
                     
                     
                     if($arreglo["idDetProd"][$key]["detProd"] == null){  
                         
                            $nombreProducto = $this->datos->nombreProducto($valueDetPed["idProducto"],$arreglo["idPedido"]);
                            $arreglo["resPedido"][$key]["ok"] = " " . $nombreProducto->nombre;
                        
                         
                     }else{
                         
                            foreach ($arreglo["idDetProd"][$key]["detProd"] as $keyProd => $value) {
                      
                                $this->datos->insertarDetPedido($value["idDet"],$arreglo["idPedido"]);
                                $this->datos->actualizarEstadoDetProdcuto($value["idDet"],$idEstadoEnUso->idEnUso);
                                
                             
                           }
                         
                           $arreglo["resPedido"][$key]["ok"] = "OK";
                     }
                     
                       
            }
            
           
            return  $arreglo["resPedido"];
    } 
   
    
    
    function eliminarPedidos($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $this->datos->inactivarCliente($arreglo["id"]);
        $this->mostrarPedidos($arreglo);
    }        
    
    function retornarFechaSistema() {
        
        $fechaActual = date("d-m-Y");
        return $fechaActual;
    }
    
    function ajaxPedidos($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        $id_usuario = $_SESSION["datos_logueo"]["idUsuario"];
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(c.id) as totalrows FROM mundolimpieza.vistapedido_" . $id_usuario ." c ",// CONFIGURE
                "selectSQL" => "SELECT l.id,l.idPuntoServicio,l.idOrdenCompra,l.idUsuarioElaboro,l.idUsuarioReviso,l.idUsuarioAprobo,l.fechaElaboro,l.fechaReviso,l.fechaAprobo,l.estado,l.avance FROM mundolimpieza.vistapedido_" . $id_usuario ." l ",// CONFIGURE
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
    
        // data conversions (if necessary)
        //$data['page_data'][0]['idUsuario'] = str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));
        foreach($data['page_data'] as $key => $row) {
             
            $nomPuntSer = $this->datos->retornarNomPuntSer($row['idPuntoServicio']);
            $idUserElab = $this->datos->datosUsuario($row['idUsuarioElaboro']);
            /*$idUserRevi = $this->datos->datosUsuario($row['idUsuarioReviso']);
            $idUserAprobo = $this->datos->datosUsuario($row['idUsuarioAprobo']);*/
            
            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Clientes&method=verCliente&id={$row['id']}\" >{$row['nombre']}</a>";
            


            $ver = "";
            $aprobar = "";
            $imprimir ="";
            if($permisos->crear=="SI"){
                $ver ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Pedidos&method=verPedido&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/detalle5.png\" title=\"Ver Detalle Pedido\" width=\"25\" height=\"25\" border=\"0\" /></a>";
            }
            if($permisos->editar=="SI"){
                $imprimir ="<a href=\"javascript:void(0)\" onclick=\"imprimirPedido({$row['id']})\" ><img src=\"imagenes/iconos/print.png\" title=\"Imprimir Pedido\" width=\"25\" height=\"25\" border=\"0\" /></a>";
            }
            
            $data['page_data'][$key]['idPuntoServicio'] = $nomPuntSer->nomPuntSer;
            $data['page_data'][$key]['idUsuarioElaboro'] = $idUserElab->nombreUsuario;
            /*$data['page_data'][$key]['idUsuarioReviso'] = $idUserRevi->nombreUsuario;
            $data['page_data'][$key]['idUsuarioAprobo'] = $idUserAprobo->nombreUsuario;*/
            
            
            if(($_SESSION["datos_logueo"]["idRol"]=="1" || $_SESSION["datos_logueo"]["idRol"]=="2")){
                   if($data['page_data'][$key]['estado']=="Pendiente Aprobar"){
                     $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarPedido({$row['id']})\"  ><img src=\"imagenes/iconos/valido.png\" title=\"Aprobar Pedido\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                   }
                if($data['page_data'][$key]['estado']=="Rechazado"){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarPedido({$row['id']})\"  ><img src=\"imagenes/iconos/valido.png\" title=\"Aprobar Pedido\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
            }  
                
            if(($_SESSION["datos_logueo"]["idRol"]=="6")){
                if($data['page_data'][$key]['estado']=="Pre Aprobado"){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarPedido({$row['id']})\"  ><img src=\"imagenes/iconos/valido.png\" title=\"Aprobar Pedido\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
               /* if(($data['page_data'][$key]['avance']>30) || ($data['page_data'][$key]['estado']=="Rechazado")){
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }*/
                
            }
            
            if(($_SESSION["datos_logueo"]["idRol"]=="3" ||$_SESSION["datos_logueo"]["idRol"]=="1")){
                if($data['page_data'][$key]['estado']=="Pendiente Gerencia"){
                    $aprobar = "<a href=\"javascript:void(0)\" onclick=\"aprobarPedido({$row['id']})\"  ><img src=\"imagenes/iconos/valido.png\" title=\"Aprobar Pedido\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }
               /* if(($data['page_data'][$key]['avance']>30) || ($data['page_data'][$key]['estado']=="Rechazado")){
                    $historial = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=FormatoMedicion&method=mostrarHistorialAprobacion&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/ver.png\" title=\"Mostrar Historial Aprobacion\" width=\"20\" height=\"20\" border=\"0\" /></a>";
                }*/
                
            }
            
            
            
            $data['page_data'][$key]['avance'] = "<span id=\"bar_" . $data['page_data'][$key]['id'] . "\">" . $data['page_data'][$key]['avance'] . "</span> <script> $('#bar_" . $data['page_data'][$key]['id'] . "').barIndicator(opt); </script>";
            $data['page_data'][$key]['acciones'] = $ver . " " . $aprobar . $imprimir;
        }
    
        echo json_encode($data);        
    }
    
    function ajaxPedido($arreglo){
        
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
        
}

?>


