<?php

/**
 *
 * @author jorge rincon
 */
class DatosAccederSistema {

    public function __construct() {
        
    }

    public function validarUsuario($usuario, $clave) {

        global $db;

        $mensaje = 'error';
        
        $query = "SELECT us.*
          FROM etlsoluciones_portal.usuario us
          WHERE us.login='$usuario'";

        $db->query($query);
        $total = $db->countRows();
        $rows = $db->fetch();
        
        //if ($total > 0 && $rows->eliminado == 0) {
        if ($total > 0){
                if(password_verify($clave, $rows->clave)){
                      if($rows->estado == "Activo"){
                          $mensaje = 'logueado';
                          $_SESSION['datos_logueo']['idUsuario'] = $rows->id;
                          $_SESSION['datos_logueo']['login'] = $rows->login;
                          $_SESSION['datos_logueo']['usuario'] = $rows->login;
                          $_SESSION['datos_logueo']['nombreUsuario'] = $rows->nombreUsuario;
                          $_SESSION['datos_logueo']['idRol'] = $rows->idRol;
                          $this->registrarUltimoIngreso();
                          $this->setIntento();                          
                }else{
                    
                 $mensaje = 'inactivo';
                }                
               
            }else{
                    if($rows->idRol != 1){
                    $idUsuario = $rows->id;
                    $intento = $rows->intento;
                    $intento = $intento + 1;
                    $this->actualizarIntento($intento,$idUsuario);
                    $valida = $this->validarIntento();
                    $valor = $valida->valor;
                   //echo'<pre>';print_r($mensaje1);echo'</pre>';
                    if ($intento < $valor){
                            $resta = $valor - $intento;
                            $mensaje  = 'Contraseña errada intento ' . $intento . ' Le resta ' . $resta . ' de ' . $valor . ' itentos posibles';
                        }
                           //$mensaje = 'error_clave';
                        
                        if($intento == $valor){
                             $mensaje = 'Ha exedido el numero de intentos permitidos.Por favor comuniquese con el administrador del sistema';
                             $this->inactivarIngreso($idUsuario);
                        }
                   if($intento > $valor){
                       $mensaje = 'inactivo';
                   }
                  }
            }
            
        }else{
            $mensaje = 'error';
        }
        
            return $mensaje;
    }
    
    //echo'<pre>';print_r($usr);echo'</pre>';
    function mensajeIntento($intento,$valor){
        if ($intento < $valor){
            $resta = $valor - $intento;
            $mensaje = 'Ha intentado acceder de manera incorrecta ' . $intento . ' Le restan ' . $resta . ' intentos de ' . $valor . ' posibles';
        }
        return $mensaje;
    }

    function registrarUltimoIngreso() {
        global $db;
        $fecha = date('d-m-Y H:i:s');
        $usuario = $_SESSION['datos_logueo']['idUsuario'];
        $sql = "UPDATE  etlsoluciones_portal.usuario
		         SET ultimoIngreso=now()
		       WHERE id = '$usuario'";
        //echo $sql;
        $db->query($sql);
    }
    
    function validarIntento(){
        
        global $db;
            $query = "SELECT *
                        FROM etlsoluciones_portal.listavalor u
                       WHERE u.tipo = 'IntentoClave'";
        
        $db->query($query);
        return $db->fetch();
       
    }
     
    function setIntento(){
        
        global $db;
        $id = $_SESSION['datos_logueo']['idUsuario'];
        $sql="UPDATE etlsoluciones_portal.usuario SET intento ='' WHERE id = '$id'";
        //echo $sql;
        $db->query($sql);
    }
    
    function actualizarIntento($intento, $idUsuario){
        
        global $db;
        
        $sql="UPDATE etlsoluciones_portal.usuario SET intento ='$intento' WHERE id = '$idUsuario'";
        //echo $sql;
        $db->query($sql);
    }
 
    
    function inactivarIngreso($idUsuario){
        
        global $db;
        $sql = "UPDATE etlsoluciones_portal.usuario  SET estado = 'Inactivo' WHERE id = '$idUsuario'";
        //echo $sql;
        $db->query($sql);
    }

 }

?>
