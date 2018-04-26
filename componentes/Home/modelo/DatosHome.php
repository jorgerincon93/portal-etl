<?php
/**
 * Description of DaosHome
 *
 * @author jarz
 */
require_once(CLASSES_PATH.'BDControlador.php');

class DatosHome extends BDControlador{
    
    public function __construct(){
    }
    
    public function retornarDatosUsuario($idUsuario){
        global $db;
        $query = "SELECT u.*
                    FROM etlsoluciones_portal.usuario u
                   WHERE u.id = $idUsuario";
        
        $db->query($query);
        return $db->fetch();
    }
//    
    
    
    public function selectMenu($idUsuario){
    	global $db;
   	//$perfilLogueado=$_SESSION['datos_logueo']['perfil_usuario'];
 
        $query = "SELECT m.*
                  FROM  etlsoluciones_portal.usuario u,
                        etlsoluciones_portal.roles_menu ru,
                        etlsoluciones_portal.menu m
		  WHERE u.id = " . $idUsuario . "
                    AND u.idRol=ru.idRol
                    AND ru.idMenu = m.id
                    AND m.idpadre is null
		  ORDER BY m.orden";

        $db->query($query);       
        return $db->getArray();
    }
    
    
    public function selectMenuHijo($idPadre,$idUsuario){
    	global $db;
   	//$perfilLogueado=$_SESSION['datos_logueo']['perfil_usuario'];
 
        $query = 'SELECT m.*
                  FROM  etlsoluciones_portal.usuario u,
                        etlsoluciones_portal.roles_menu ru,
                        etlsoluciones_portal.menu m
		  WHERE u.id = ' . $idUsuario . '
                    AND u.idRol=ru.idRol
                    AND ru.idMenu = m.id
                    AND m.idpadre =' . $idPadre .' 
		  ORDER BY m.orden';
        //echo $query;
        $db->query($query);
        return $db->getArray();
    }
    
    public function selectSubMenuHijo($idPadre,$idUsuario){
        global $db;
        
        $query = "SELECT m.*
                    FROM etlsoluciones_portal.usuario u,
                         etlsoluciones_portal.roles_menu ru,
                         etlsoluciones_portal.menu m
                   WHERE u.id = $idUsuario
                     AND u.idRol=ru.idRol
                     AND ru.idMenu = m.id
                     AND m.idpadre = $idPadre
                    ORDER BY m.orden";
        //echo $query;
        $db->query($query);
        return $db->getArray();
    }
    public function selecMenuPrincipal($idPadre){
    	global $db;
   	$perfilLogueado=$_SESSION['datos_logueo']['perfil_usuario'];
 
        $query = "SELECT m.*,
						(SELECT count(segmen_id)
						   FROM seg_menus,
							    seg_permisos_menu,
							    seg_perfiles
						  WHERE segmen_id_padre=m.segmen_id
						    AND segpermen_id_menu = segmen_id
						    AND segpermen_id_perfil = segper_id
						    AND segper_id = $perfilLogueado
						  ) AS hijos
				    FROM seg_menus m,
						 seg_permisos_menu pm,
						 seg_perfiles p
				   WHERE m.segmen_id_padre = $idPadre
					 AND pm.segpermen_id_menu = m.segmen_id
					 AND pm.segpermen_id_perfil = p.segper_id
					 AND p.segper_id = $perfilLogueado
				 
					 ORDER BY m.segmen_orden";

        $db->query($query);
        return $db->getArray();
    }


}  

?>