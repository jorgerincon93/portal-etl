<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Privilegios/vista/vistaPrivilegios.php';
include_once COMPONENTS_PATH . 'Privilegios/modelo/datosPrivilegios.php';


class Privilegios{
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
        $this->datos = new DatosPrivilegios();
        $this->vista = new VistaPrivilegios($this->datos);
    }

    public function mostrarPrivilegios($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarPrivilegios($permisos);    	
    }
    
    function vePrivilegios($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$datosPrivilegios=$this->datos->mostrarPrivilegios($arreglo);
        //echo'<pre>';print_r($datosUsuario);echo'</pre>';
	$this->vista->verUsuario($datosPrivilegios);
    }
    
    function agregarPrivilegios($arreglo){
        
        $lista_rol = $this->datos->build_list('mundolimpieza.rol','id','rol', 'WHERE 1=1 ORDER BY rol ');
    	$arreglo['select_rol'] = $this->datos->armSelect($lista_rol ,'Seleccione Rol...');
        
	$lista_menu_padre = $this->datos->build_list('mundolimpieza.menu','id','nombre', 'WHERE 1=1 AND idpadre IS NULL ORDER BY nombre ');
    	$arreglo['select_menu_padre'] = $this->datos->armSelect($lista_menu_padre ,'Seleccione Menu Padre...');
        
        $lista_menu_hijo = $this->datos->build_list('mundolimpieza.menu','id','nombre', 'WHERE 1=1 AND idpadre IS NULL ORDER BY nombre ');
        $arreglo['select_menu_hijo'] = $this->datos->armSelect($lista_menu_hijo ,'Seleccione Menu Hijo...');
        
        $lista_menu_hijo2 = $this->datos->build_list('mundolimpieza.menu','id','nombre', 'WHERE 1=1 AND idpadre IS NULL ORDER BY nombre ');
        $arreglo['select_menu_hijo2'] = $this->datos->armSelect($lista_menu_hijo2 ,'Seleccione Menu Hijo...');
                
        $lista_editar = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviEditar' ORDER BY valor DESC");
    	$arreglo['select_editar'] = $this->datos->armSelect($lista_editar ,'Seleccione Privilegio Editar...');
        
        $lista_eliminar = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviEliminar' ORDER BY valor DESC");
    	$arreglo['select_eliminar'] = $this->datos->armSelect($lista_eliminar ,'Seleccione Privilegio Eliminar...');
        
        $lista_crear = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviCrear' ORDER BY valor DESC");
    	$arreglo['select_crear'] = $this->datos->armSelect($lista_crear ,'Seleccione Privilegio Crear...');
     
        $arreglo['disabled'] ="disabled";
        $arreglo['required'] = "required";
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVOS PRIVILEGIOS";
        
	$this->vista->agregarPrivilegios($arreglo);
    }
    
    function editarPrivilegios($arreglo){        
	
        $arreglo['datoPrivilegios']=$this->datos->datoPrivilegios($arreglo);
         $nomRol = $this->datos->traerNombreRol($arreglo['datoPrivilegios']->idRol);
         $nomMenu = $this->datos->traerNombreMenu($arreglo['datoPrivilegios']->idMenu);
        //$arreglo['datosPrivilegios']->jerarquia = $arreglo['datosPrivilegios']->idPadre;
         $arreglo['datoPrivilegios']->rol = $nomRol->rol;
         $arreglo['datoPrivilegios']->menu = $nomMenu->nombre;
        
         
        $lista_menu_padre = $this->datos->build_list('mundolimpieza.menu','id','nombre', 'WHERE 1=1 ORDER BY nombre ');
    	$arreglo['select_menu_padre'] = $this->datos->armSelect($lista_menu_padre ,'Seleccione Menu Padre...',isset($arreglo['datoPrivilegios']->idMenu)?$arreglo['datoPrivilegios']->idMenu:"");
        
        $lista_editar = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviEditar' ORDER BY valor DESC");
    	$arreglo['select_editar'] = $this->datos->armSelect($lista_editar ,'Seleccione Privilegio Editar...',isset($arreglo['datoPrivilegios']->editar)?$arreglo['datoPrivilegios']->editar:"");
        
        $lista_eliminar = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviEliminar' ORDER BY valor DESC");
    	$arreglo['select_eliminar'] = $this->datos->armSelect($lista_eliminar ,'Seleccione Privilegio Eliminar...',isset($arreglo['datoPrivilegios']->eliminar)?$arreglo['datoPrivilegios']->eliminar:"");
        
        $lista_crear = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='PriviCrear' ORDER BY valor DESC");
    	$arreglo['select_crear'] = $this->datos->armSelect($lista_crear ,'Seleccione Privilegio Crear...',isset($arreglo['datoPrivilegios']->crear)?$arreglo['datoPrivilegios']->crear:"");

        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR PERMISOS, " . strtoupper($arreglo['datoPrivilegios']->menu);
        $arreglo['disabledAgregar'] ="disabled";
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$this->vista->editarPrivilegios($arreglo);
    }
    
    function agregarRol($arreglo){
        
        
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "AGREGAR ROL";
            
         $this->vista->agregarRol($arreglo);
        
    }
   
    function guardarPrivilegios($arreglo){
        
        
	if($arreglo['opcion']=="editar"){            
                 
            $this->datos->actualizarPrivilegios($arreglo);
            
	}else{
            
            
              $cantidadPadre = $this->datos->validarRepetidoPadre($arreglo);
              $cantidadHijo= $this->datos->validarRepetidoHijo($arreglo);
              
            if(isset($arreglo["menuHijo2"]) == NULL){
                  
                if($cantidadPadre->cantRepe1 == 0){
                    
                    $this->datos->insertarPrivilegioPadre($arreglo); 
                    $this->datos->insertarPrivilegioHijo($arreglo);
                    
                }else{
                    
                    $this->datos->insertarPrivilegioHijo($arreglo);
                    
                }
                   
            
            }else{
                
              $cantidadHijo1= $this->datos->validarRepetidoHijo1($arreglo);
              
           
              if($cantidadPadre->cantRepe1 == 0 && $cantidadHijo->cantRepe2 == 0 && $cantidadHijo1->cantRepe3 == 0){                  
                      
                      //INSERTO ROLES_MENU COMPLETO//
                   $this->datos->insertarPrivilegioPadre($arreglo); 
                   $this->datos->insertarPrivilegioHijo($arreglo);
                   $this->datos->insertarPrivilegioHijo2($arreglo);        
                   
                  
                  
              }elseif($cantidadHijo->cantRepe2 == 0){
                  
                  $cantidadHijo= $this->datos->validarRepetidoHijo($arreglo);
                  
              }elseif($cantidadHijo1->cantRepe3 == 0){
                      $this->datos->insertarPrivilegioHijo2($arreglo);                       
                       
                  }else{
                      
                      echo "<script type='text/javascript'>alert('REGISTRO YA EXISTE');</script>";
                  }
              }
              
        }  
                 
	
        
	$this->mostrarPrivilegios($arreglo);
    }    
    
    function guardarRol($arreglo){
            
        $repetido = $this->datos->validarRepetido($arreglo['nomRol']);
          
            if($repetido->cantRol > 0){
                $mensaje = "EL Rol "  . $arreglo["nomRol"] . " YA EXISTE";
                echo "<script type='text/javascript'>alert('$mensaje');</script>";
                     
                 }else{
                     $this->datos->insertarRol($arreglo);
                 }
                      
        $this->agregarPrivilegios($arreglo);
    }
    
    function eliminarPrivilegios($arreglo){       
        
        $this->datos->inactivarPrivilegios($arreglo["id"]);
        $this->mostrarPrivilegios($arreglo);
		
		$this->agregarPrivilegios($arreglo);
    }   
    
    function agregarMenuHijo($arreglo){
       
         $lista_menu_hijo = $this->datos->build_list('mundolimpieza.menu','id','nombre', "WHERE id not in (select m.id from roles_menu rm, menu m where rm.idMenu = m.id and rm.idRol =" . $arreglo["idRol"] . " ORDER BY nombre ");
    	 $select_menu_hijo = $this->datos->armSelect($lista_menu_hijo ,'Seleccione Menu Hijo...');
         
        
        echo $select_menu_hijo;  
    
    }
    
    function agregarMenuHijo2($arreglo){
       
         $lista_menu_hijo2 = $this->datos->build_list('mundolimpieza.menu','id','nombre', "WHERE id not in (select m.id from roles_menu rm, menu m where rm.idMenu = m.id and rm.idRol =" . $arreglo["idRol"] . ") ORDER BY nombre ");
    	 $select_menu_hijo2 = $this->datos->armSelect($lista_menu_hijo2 ,'Seleccione Menu Hijo...');
         
        
        echo $select_menu_hijo2;  
    
    }
   
    function ajaxListaPrivilegios($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(u.idRolMenu) as totalrows FROM mundolimpieza.vistarolesmenu u ",                                 // CONFIGURE
                "selectSQL" => "SELECT u.idRolMenu,u.idRol,u.nombreRol,u.idMenu,u.nomMenu,u.editar,u.eliminar,u.crear FROM mundolimpieza.vistarolesmenu u", // CONFIGURE
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
             
            
            // $data['page_data'][$key]['idUsuario']= str_replace('>','&gt;',str_replace('<','&lt;',print_r($data,true)));

            //$data['page_data'][$key]['login'] = "<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Usuario&method=verUsuarios&id={$row['idUsuario']}\" >{$row['login']}</a>";
            
            //$data['page_data'][$key]['idRol'] = $this->datos->retornarRol($data['page_data'][$key]['idRol']);

            $editar = "";
            $eliminar = "";
            if($permisos->editar=="SI"){
                    $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=Privilegios&method=editarPrivilegios&id={$row['idRolMenu']}&idMenu={$permisos->idMenu}\" ><img src=\"imagenes/iconos/mis/editar.png\" title=\"Editar Usuario\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
            }        
            if($permisos->eliminar=="SI"){
                $eliminar ="<a href=\"javascript:eliminarPrivilegios('{$row['idRolMenu']}','{$row['nomMenu']}','{$row['nombreRol']}')\"  class=\"separador\"><img src=\"imagenes/iconos/mis/eliminar.png\" title=\"Eliminar Usuario\" width=\"20\" height=\"20\" border=\"0\"/></a>";
            }
    
            $data['page_data'][$key]['acciones'] = $editar ." ". $eliminar;
        }
    
        echo json_encode($data);        
    }
    
    function ajaxListaRoles($arreglo){
        
        $roles = $this->datos->listaRoles();
        
        $v_cont=0;
        $listaRoles ="[";
        foreach ($roles as $key => $value) {
            if($v_cont==0){
                $listaRoles = $listaRoles . '{"lk_option":"' . $roles[$key]["rol"] . '","lk_value":"' . $roles[$key]["id"] . '"}';
                $v_cont++;
            }else{            
                $listaRoles = $listaRoles . ',{"lk_option":"' . $roles[$key]["rol"] . '","lk_value":"' . $roles[$key]["id"] . '"}';
            }            
        }
        $listaRoles = $listaRoles . "]";
        
        echo $listaRoles;
    }    
        
}



?>


