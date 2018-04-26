<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'ItemMaster/vista/vistaItemMaster.php';
include_once COMPONENTS_PATH . 'ItemMaster/modelo/datosItemMaster.php';


class ItemMaster{
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
        $this->datos = new DatosItemMaster();
        $this->vista = new VistaItemMaster($this->datos);
    }
    
    public function mostrarItemMaster($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        //$Clientees = $this->datos->selectUsuarios();
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        
        
        $permisos->camposAtributos = "";
        $atributos = $this->datos->listaAtributos();
        foreach ($atributos as $keyAtt => $valueAtt) {
            $permisos->camposAtributos = $permisos->camposAtributos . '{field: "' . $valueAtt["nombre"]  . '", header: "'.$valueAtt["nombre"].'"},';            
        }
        //echo $permisos->camposAtributos;
        
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarItemMaster($permisos);    	
    }
    
    function agregarItem($arreglo){

        
        $arreglo["opcion"] = "agregar";
        
        $idHistorialCat = "";
        $idHistorialFab = "";
        $idHistorialMar = "";
        
        if(isset($arreglo["idHistorialCat"])){
            $idHistorialCat = $arreglo['idHistorialCat'];
        }
        
        if(isset($arreglo["idHistorialFab"])){
            $idHistorialFab = $arreglo['idHistorialFab'];
        }
        
        if(isset($arreglo["idHistorialMar"])){
            $idHistorialMar = $arreglo['idHistorialMar'];
        }
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $lista_categoria = $this->datos->build_list('item.categoria','id','nombreCategoria', " ORDER BY nombreCategoria ");
    	$arreglo['select_categoria'] = $this->datos->armSelect($lista_categoria ,'Seleccione Categoria...',$idHistorialCat);
        
        $lista_fabricante = $this->datos->build_list('item.fabricante','id','nombreFabricante', " ORDER BY nombreFabricante ");
    	$arreglo['select_fabricante'] = $this->datos->armSelect($lista_fabricante ,'Seleccione Fabricante...',$idHistorialFab);
        
        $lista_marca = $this->datos->build_list('item.marca','id','nombreMarca', " ORDER BY nombreMarca ");
    	$arreglo['select_marca'] = $this->datos->armSelect($lista_marca ,'Seleccione Marca...',$idHistorialMar);
        
        $arreglo["disabled"] = "";
        
        $arreglo["atributos"] = $this->datos->listaAtributos();
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        /*foreach ($listaAtributos as $keyAtt => $valueAtt) {
            $arreglo["atributos"][$keyAtt]["nombre"]=$valueAtt["nombreAtributo"];
            $arreglo["atributos"][$keyAtt]["id"]=$valueAtt["id"];
        }*/
        
                
        $arreglo['titulo_tabla'] = "NUEVO ITEM";        
	$this->vista->agregarItem($arreglo);
    }
    
    function editarItem($arreglo){        
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        $infoItem = $this->datos->consultarVistaItems($arreglo["idItemAtributo"]);
        $arreglo["datosItem"] = $infoItem;
        //echo'<pre>';print_r($infoItem);echo'</pre>';
        
        $lista_categoria = $this->datos->build_list('item.categoria','id','nombreCategoria', " ORDER BY nombreCategoria ");
    	$arreglo['select_categoria'] = $this->datos->armSelect($lista_categoria ,'Seleccione Categoria...',$infoItem->idCategoria);
        
        $lista_fabricante = $this->datos->build_list('item.fabricante','id','nombreFabricante', " ORDER BY nombreFabricante ");
    	$arreglo['select_fabricante'] = $this->datos->armSelect($lista_fabricante ,'Seleccione Fabricante...',$infoItem->idFabricante);
        
        $lista_marca = $this->datos->build_list('item.marca','id','nombreMarca', " ORDER BY nombreMarca ");
    	$arreglo['select_marca'] = $this->datos->armSelect($lista_marca ,'Seleccione Marca...',$infoItem->idMarca);        
        
        $arreglo["atributos"][0]["nombre"] = $infoItem->nombreAtributo;
        $arreglo["atributos"][0]["valor"] = $infoItem->valor;
        $arreglo["atributos"][0]["idAtributo"] = $infoItem->idAtributo;
        
        $arreglo["disabled"] = "disabled";
        
        
        /*foreach ($listaAtributos as $keyAtt => $valueAtt) {
            $arreglo["atributos"][$keyAtt]["nombre"]=$valueAtt["nombreAtributo"];
            $arreglo["atributos"][$keyAtt]["id"]=$valueAtt["id"];
        }*/
                
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR ITEM " . strtoupper($infoItem->idItemAtributo);
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarItem($arreglo);
    }        
   
    function guardarItem($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        $atributos = $this->datos->listaAtributos();
        
        if($arreglo['opcion']=="editar"){
            //echo "editar";
        //    $this->datos->actualizarCliente($arreglo);
            
            $datosItem = $this->datos->consultarVistaItems($arreglo["id"]);
            $idBaseItem = $this->datos->consultarBaseItems($datosItem->idCategoria,$datosItem->idFabricante,$datosItem->idMarca);
            $idBaseItemAct = $idBaseItem->id;
            
            foreach ($atributos as $keyAtt => $valueAtt) {
                
                if(isset($arreglo[$valueAtt["nombre"]])){
                    $this->datos->actualizarValorItemAtributo($arreglo["id"],$arreglo[$valueAtt["nombre"]]);
                }
            }
	}
	else{
            //echo "insertar";
            $idBaseItem = $this->datos->consultarBaseItems($arreglo["categoria"],$arreglo["fabricante"],$arreglo["marca"]);
            if(isset($idBaseItem->id)){            
                //echo'<pre>';print_r($idBaseItem);echo'</pre>';
                $idBaseItemAct = $idBaseItem->id;
            }else{
                //echo "Insertar base Item";
                $idBaseItemAct = $this->datos->insertarBaseItem($arreglo);
            }
            
            
            //BUSCAR ATRIBUTOS PARA NO INSERTARLOS DOBLE VEZ
        
            

            foreach ($atributos as $keyAtt => $valueAtt) {

                if( ($arreglo[$valueAtt["nombre"]] == "") || ($arreglo[$valueAtt["nombre"]] == null)){
                    $arreglo[$valueAtt["nombre"]] = "NO TIENE";
                }            
                //echo'<pre>';print_r($arreglo[$valueAtt["nombre"]]);echo'</pre>';

                $idItemAtributoValor = $this->datos->consultarItemAtributoValor($idBaseItemAct,$valueAtt["id"],$arreglo[$valueAtt["nombre"]]);

                if(!isset($idItemAtributoValor->id)){

                    //echo'<pre>';echo "NUEVO ATRIBUTO: " . $valueAtt["nombre"] . " - ". $arreglo[$valueAtt["nombre"]];echo'</pre>';


    //                if($arreglo['opcion']=="editar"){
    //                    
    //                    $idItemAtributo = $this->datos->consultarItemAtributo($idBaseItemAct,$valueAtt["id"]);
    //                    
    //                    if(isset($idItemAtributo->id)){
    //                        echo'<pre>';echo "ACTUALIZAR ATRIBUTO: " . $valueAtt["nombre"] . " - ". $arreglo[$valueAtt["nombre"]];echo'</pre>';
    //                    }else{
    //                        echo'<pre>';echo "INSERTAR ATRIBUTO: " . $valueAtt["nombre"] . " - ". $arreglo[$valueAtt["nombre"]];echo'</pre>';
    //                    }
    //                    
    //                }else{ //INSERTAR                   
                        //echo'<pre>';echo "INSERTAR ATRIBUTO: " . $valueAtt["nombre"] . " - ". $arreglo[$valueAtt["nombre"]];echo'</pre>';
                        $this->datos->insertarAtributoItem($valueAtt["id"],$idBaseItemAct,$arreglo[$valueAtt["nombre"]]);                
                    //}

                }
                
                // INSERTAR NO TIENE Y OTROS SI NO LO TIENE
                $noTiene = $this->datos->consultarItemAtributoNotiene($idBaseItemAct,$valueAtt["id"]);            
                if($noTiene->contador == 0){
                    $this->datos->insertarItemAtributoNotiene($idBaseItemAct,$valueAtt["id"]);
                }

                $otros = $this->datos->consultarItemAtributoOtros($idBaseItemAct,$valueAtt["id"]);            
                if($otros->contador == 0){
                    $this->datos->insertarItemAtributoOtros($idBaseItemAct,$valueAtt["id"]);
                }
            }
            $this->generarCodigosItem($arreglo['categoria'],$arreglo['fabricante'],$arreglo['marca'],$arreglo);
            
            $nombreAtributo = $this->datos->consultarTablaCodigos();
            $itemLista = $arreglo;
            foreach ($nombreAtributo as $keyItem => $nombreAtrib) {
                $arreglo['valorItem'][$nombreAtrib["nombre"]] = $itemLista[$nombreAtrib["nombre"]]; 
                if($itemLista[$nombreAtrib["nombre"]] == 'NO TIENE'){   
                       $arreglo['valorItem'][$nombreAtrib["nombre"]] = NULL; 
                }
                
            }
            
            $this->insertarItems($arreglo);
        }
      $this->mostrarItemMaster($arreglo);
    }    
    
    function agregarCategoria($arreglo){        

        $arreglo["opcion"] = "agregar";
         
        $arreglo['titulo_tabla'] = "NUEVA CATEGORIA";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarCategoria($arreglo);
    }
    
    function guardarCategoria($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        $existeCategoria = $this->datos->consultarValorCategoria($arreglo["categoria"]);
        
        if($existeCategoria->id == NULL || $existeCategoria->id == ''){
         $idCategoria  = $this->datos->insertarCategoria($arreglo["categoria"]);
        }else{
             $idCategoria = $existeCategoria->id;
        }
        
        $arreglo['idHistorialCat'] = $idCategoria;
        
        $this->agregarItem($arreglo);
    } 
    
    function agregarFabricante($arreglo){        
	
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO FABRICANTE";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarFabricante($arreglo);
    }
    
    function guardarFabricante($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        $existeFabricante = $this->datos->consultarValorFabricante($arreglo["fabricante"]);
        if($existeFabricante->id == NULL || $existeFabricante->id == ''){
          $idFabricante = $this->datos->insertarFabricante($arreglo["fabricante"]);
        }else{
             $idFabricante = $existeFabricante->id;
        }
        
        $arreglo['idHistorialFab'] = $idFabricante;
         
        $this->agregarItem($arreglo);    
    }
    
    function agregarMarca($arreglo){        
	
        $arreglo["opcion"] = "agregar";        
                
        $arreglo['titulo_tabla'] = "NUEVO MARCA";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->agregarMarca($arreglo);
    }
    
    function guardarMarca($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        
        $existeMarca = $this->datos->consultarValorMarca($arreglo["marca"]);
        if($existeMarca->id == NULL && $existeMarca->id == ''){
          $idMarca = $this->datos->insertarMarca($arreglo["marca"]);
        }else{
             $idMarca = $existeMarca->id;
        }
        
        $arreglo['idHistorialMar'] = $idMarca;
        
        $this->agregarItem($arreglo);    
    }
    
    function generarCodigosItem($categoria,$fabricante,$marca,$arreglo) {

        $listaItems = $this->datos->consultarTabla();

            foreach ($listaItems as $keyItem => $itemLista) {
                
              //  $datosMapeo =  $this->datos->consultarMapeoDatos($itemLista["ITEM"]);

                //if (isset($datosMapeo->campo)) {
                    //echo "Existe " . $datosMapeo->campo . "<br> \n";

                    $codigoItemCompleto = $this->insertarCodigosCompleto($categoria,$fabricante,$marca,$arreglo);
                    //echo "COMPLETO : " . $codigoItemCompleto . "<br> \n";
                    $codigoItemShopper = $this->insertarCodigosShopper($categoria,$fabricante,$marca,$arreglo);
                    //echo "SHOPPER : " . $codigoItemShopper . "<br> \n";

                   if ($codigoItemShopper == 0) {
                        //echo "<pre>"; echo print_r($itemLista); echo "</pre>";
                        echo " CATEGORIA - FABRICANTE - MARCA NO EXISTE EN ITEM MASTER <br> \n ";
                        $this->datos->actualizarItemFaltantes($itemLista["ID"], "CATEGORIA - FABRICANTE - MARCA NO EXISTE EN ITEM MASTER");
                    }else {
                        $this->datos->actualizarMapeoDatos($itemLista["ITEM"], $codigoItemCompleto, $codigoItemShopper);
                        $this->datos->actualizarItemFaltantes($itemLista["ID"], "ACTUALIZADO EN MAPEO DATOS", $codigoItemCompleto, $codigoItemShopper);
                    }
                //}else {
                    //    echo "NO Existe " . $datosMapeo->campo . "<br> \n";
                      //  $this->datos->actualizarItemFaltantes($itemLista["ID"], "NO Existe " . $datosMapeo->campo . "");
                //}
            }
    }
    
    function insertarItems($arreglo) {
    
        //borrarTablas();
        
        $nomCategoria = $this->datos->consultarCategoria($arreglo['categoria']);
        $nomFabricante = $this->datos->consultarFabricante($arreglo['fabricante']);
        $nomMarca = $this->datos->consultarMarca($arreglo['marca']);
       // $listaItems = $arreglo;//$this->datos->consultarTablaItems();
        $arreglo['valorItem']['nomCategoria'] = $nomCategoria->nombreCategoria;
        $arreglo['valorItem']['nomFabricante'] = $nomFabricante->nombreFabricante;
        $arreglo['valorItem']['nomMarca'] = $nomMarca->nombreMarca;
        $itemLista = $arreglo['valorItem'];
       //if($itemLista[$nombreAtrib["nombre"]] != 'NO TIENE'){   
            $unidades = $itemLista["UNIDADES"]>1?$itemLista["UNIDADES"]:"";
        
                $nombreItem = str_replace("  ", " ",str_replace("  ", " ", trim($itemLista["nomCategoria"] . " " . $itemLista["nomFabricante"] . " " . $itemLista["nomMarca"] . " " . $itemLista["SUBMARCA"] . " " . $itemLista["VARIEDAD"] . " " . $itemLista["EMPAQUE"] . " " . $itemLista["COLOR"] . " " . $itemLista["SABOR_AROMA"] . " " . $itemLista["CONTENIDO"] . " " . $unidades . " " . $itemLista["ACTIVIDAD_PROMOCIONAL"] . " " . $itemLista["USO"] . " " . $itemLista["PRESENTACION"] . " " . $itemLista["CALORIAS"])));
                //echo $nombreItem . "<br> \n";
                $codigoItemCompleto = $this->insertarCodigosCompleto($arreglo["categoria"],$arreglo["fabricante"],$arreglo["marca"],$arreglo);
                //echo "COMPLETO : " . $codigoItemCompleto . "<br> \n";        
        
            $registroHistorial = $this->datos->consultarRegistroHistorial($codigoItemCompleto);
            
            if($registroHistorial->conteo<1){
                
                $this->datos->insertarItemCompleto($arreglo['valorItem'], $codigoItemCompleto, $nombreItem);
            }
        
            $nombreItemShopper = str_replace("  ", " ",str_replace("  ", " ",trim($itemLista["nomCategoria"] . " " . $itemLista["nomMarca"] . " " . $itemLista["USO"] . " " . $itemLista["PRESENTACION"] . " " . $itemLista["CALORIAS"] . " " . $itemLista["CONTENIDO"] . " " . $unidades . " " . $itemLista["VARIEDAD"] . " " . $itemLista["EMPAQUE"] . " " . $itemLista["SABOR_AROMA"] . " " . $itemLista["SUBMARCA"] . " " . $itemLista["COLOR"] . " " . $itemLista["ACTIVIDAD_PROMOCIONAL"])));
                //echo $nombreItemShopper . "<br> \n";        
            $codigoItemShopper = $this->insertarCodigosShopper($arreglo["categoria"],$arreglo["fabricante"],$arreglo["marca"],$arreglo);
        
            $registroHistorialShopper = $this->datos->consultarRegistroHistorialShopper($codigoItemShopper);
            
            if($registroHistorialShopper->conteo<1){
                  $this->datos->insertarItemShopper($arreglo['valorItem'], $codigoItemShopper, $nombreItemShopper);
            }    
                //echo "SHOPPER : " . $codigoItemShopper . "<br> \n";        
          //  }
        //}
    }

    function insertarCodigosCompleto($idCategoriaItem,$idFabricanteItem,$idMarcaItem,$arreglo) {

    //echo'<pre>';print_r($itemLista);echo'</pre>';
    $cont = 0;
    
    
    $codigo = 0;
    $categoria = $this->datos->consultarCategoria($idCategoriaItem);
    $fabricante = $this->datos->consultarFabricante($idFabricanteItem);
    $marca = $this->datos->consultarMarca($idMarcaItem);


    $idCategoria = $this->datos->consultarIdTablaRegistro($categoria->nombreCategoria, "categoria");
    $idFabricante = $this->datos->consultarIdTablaRegistro($fabricante->nombreFabricante, "fabricante");
    $idMarca = $this->datos->consultarIdTablaRegistro($marca->nombreMarca, "marca");

    
        if (isset($idCategoria->id) && isset($idFabricante->id) && isset($idMarca->id)) {

            $codigo = $parte = str_pad($idCategoria->id, 10, "0", STR_PAD_LEFT);
            $codigo = $codigo . $parte = str_pad($idFabricante->id, 10, "0", STR_PAD_LEFT);
            $codigo = $codigo . $parte = str_pad($idMarca->id, 10, "0", STR_PAD_LEFT);

            $listaEstructura = $this->datos->consultarTablaCodigos();
            
            foreach ($listaEstructura as $keyEstructura => $valueEstructura) {
                    $idItemAtributo = 0;
                    
                        $idItemAtributo = $this->datos->retornarInfoAtributo(trim($arreglo[$valueEstructura["nombre"]]), $valueEstructura["valor"], $idCategoria->id, $idFabricante->id, $idMarca->id);
                        $codigo = $codigo . $parte = str_pad($idItemAtributo->id, 10, "0", STR_PAD_LEFT);
                    
            }
           return $codigo;
        }else{
         return 0;
        }
    }
    
    function insertarCodigosShopper($categoriaItemSh,$fabricanteItemSh,$marcaItemSh,$arreglo) {
    //echo "<pre>"; echo print_r($itemLista); echo "</pre>";
        
    $categoria = $this->datos->consultarCategoria($categoriaItemSh);
    $fabricante = $this->datos->consultarFabricante($fabricanteItemSh);
    $marca = $this->datos->consultarMarca($marcaItemSh);    
    $cont = 0;

    $codigo = 0;
    //$idCategoria = "";
    //$idFabricante = "";
    //$idMarca = "";
    $idItemUso = "";
    $idItemPresentacion = "";
    $idItemCalorias = "";
    $idItemContenido = "";
    $idItemUnidades = "";
    $idItemVariedad = "";
    $idItemEmpaque = "";
    $idItemAroma = "";
    $idItemSubmarca = "";
    $idItemColor = "";
    $idItemActProm = "";

    $idCategoria = $this->datos->consultarIdTablaRegistro($categoria->nombreCategoria, "categoria");
    $idFabricante = $this->datos->consultarIdTablaRegistro($fabricante->nombreFabricante, "fabricante");
    $idMarca = $this->datos->consultarIdTablaRegistro($marca->nombreMarca, "marca");

        if (isset($idCategoria->id) && isset($idFabricante->id) && isset($idMarca->id)) {

            $codigo = $parte = str_pad($idCategoria->id, 10, "0", STR_PAD_LEFT);
            $codigo = $codigo . $parte = str_pad($idFabricante->id, 10, "0", STR_PAD_LEFT);
            $codigo = $codigo . $parte = str_pad($idMarca->id, 10, "0", STR_PAD_LEFT);

            $listaEstructura = $this->datos->consultarTablaCodigosShopper();

            foreach ($listaEstructura as $keyEstructura => $valueEstructura) {
                      $idItemAtributo = 0;
                      $idItemAtributo = $this->datos->retornarInfoAtributo(trim($arreglo[$valueEstructura["nombre"]]), $valueEstructura["valor"], $idCategoria->id, $idFabricante->id, $idMarca->id);
                      $codigo = $codigo . $parte = str_pad($idItemAtributo->id, 10, "0", STR_PAD_LEFT);
            }
              return $codigo;
         }else {
                return 0;
        }
    }

    function ajaxListaItems($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);
        
        $atributos = $this->datos->listaAtributos();
        
        $selectAtributos = "";
        foreach ($atributos as $keyAtt => $valueAtt) {
            $selectAtributos = $selectAtributos . ",'" . $valueAtt["nombre"] . "' AS " . $valueAtt["nombre"] . " ";
        }

        $page_settings = array(
                "selectCountSQL" => "SELECT count(c.id) as totalrows FROM item.vista_item_master c ",                                 // CONFIGURE
                "selectSQL" => "SELECT c.id,c.idCategoria,c.idFabricante,c.idMarca,c.nombreCategoria,c.nombreFabricante,c.nombreMarca,c.idItemAtributo,c.idAtributo,c.idItem,c.valor,c.nombreAtributo  FROM item.vista_item_master c",// CONFIGURE
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
            
//            $categoriaValor = $this->datos->consultarCategoria($data['page_data'][$key]['idCategoria']);            
//            $data['page_data'][$key]['idCategoria'] = $categoriaValor->nombreCategoria;
//            
//            $fabricanteValor = $this->datos->consultarFabricante($data['page_data'][$key]['idFabricante']);            
//            $data['page_data'][$key]['idFabricante'] = $fabricanteValor->nombreFabricante;
//            
//            $marcaValor = $this->datos->consultarMarca($data['page_data'][$key]['idMarca']);            
//            $data['page_data'][$key]['idMarca'] = $marcaValor->nombreMarca;
            
           
    
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            //$data['page_data'][$key]['nombre'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=ItemMaster&method=verItem&id={$row['id']}\" >{$row['nombre']}</a>";
            
            //$data['page_data'][$key]['rol'] = $this->datos->retornarRol($data['page_data'][$key]['rol']);

            $editar = "";
            $eliminar = "";
            if($permisos->editar=="SI"){
                $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=ItemMaster&method=editarItem&idItem={$row['id']}&idItemAtributo={$row['idItemAtributo']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar Item\" width=\"20\" height=\"20\" border=\"0\" /></a>";
            }        
            //if($permisos->eliminar=="SI"){
            //    $eliminar ="<a href=\"javascript:eliminarItem('{$row['id']}')\"  class=\"separador\"><img src=\"images/iconos/mis/eliminar.png\" title=\"Eliminar Cliente\" width=\"20\" height=\"20\" border=\"0\"/></a>";
            //}
    
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
        
}

?>


