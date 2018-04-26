<?php
/**
 * Description of Home
 *
 * @author jorge rincon
 */


if(!defined('entrada_valida')) die('Acceso directo no permitido');
require_once COMPONENTS_PATH . 'AccederSistema/vista/VistaAccederSistema.php';
require_once COMPONENTS_PATH . 'AccederSistema/modelo/DatosAccederSistema.php';

class AccederSistema{
    
    private $vista;
    private $datos;
    var $usuario;
    var $clave;
    

    public function __construct(){
        recuperar_Post($this);
        $this->vista = new VistaAccederSistema();
        $this->datos = new DatosAccederSistema();
    }
    
    public function validarLogueoUsuario(){
        
        if(empty($this->usuario)||empty($this->clave)){
            print('faltante');
        }
        else{
            $mensaje = $this->datos->validarUsuario($this->usuario, $this->clave);
            
            print($mensaje);
        }
    }
    
    public function cerrarSesion(){
        session_destroy();
    }
}
?>