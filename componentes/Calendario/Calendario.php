<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'Calendario/vista/vistaCalendario.php';
include_once COMPONENTS_PATH . 'Calendario/modelo/datosCalendario.php';


class Calendario{
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
        $this->datos = new DatosCalendario();
        $this->vista = new VistaCalendario($this->datos);
    }

    public function mostrarCalendario($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
        
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];
        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarCalendario($permisos);    	
    }
    
    function verCalendario($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	$datosCalendario=$this->datos->mostrarCalendario($arreglo);
        //echo'<pre>';print_r($datosUsuario);echo'</pre>';
	$this->vista->verCalendario($datosCalendario);
    }
    
    function agregarCalendario($arreglo){
        
	$lista_perfil = $this->datos->build_list('rol','id','rol', 'WHERE 1=1 ORDER BY rol ');
    	$arreglo['select_perfil'] = $this->datos->armSelect($lista_perfil ,'Seleccione Perfil...');
        
        $lista_tipoDoc = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoDocumento' ORDER BY valor ");
    	$arreglo['select_tipoDoc'] = $this->datos->armSelect($lista_tipoDoc ,'Seleccione Tipo de Documento...');
        
        $lista_area = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='Area' ORDER BY valor ");
    	$arreglo['select_area'] = $this->datos->armSelect($lista_area ,'Seleccione el Area...');
        
        $lista_acceso = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='TipoAcceso' ORDER BY valor ");
    	$arreglo['select_acceso'] = $this->datos->armSelect($lista_acceso ,'Seleccione el Tipo de Acceso...');
        
        $lista_estado = $this->datos->build_list('mundolimpieza.listavalor','valor','nombre', "WHERE tipo='EstadoUsuario' ORDER BY valor ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_estado ,'Seleccione el Estado...');
        
        $arreglo['required'] = "required";
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "NUEVO Calendario";
        
	$this->vista->agregarCalendario($arreglo);
    }
    
    function EditarEvento($arreglo){
	
        $arreglo["datosEvento"] = $this->datos->datosCalendario($arreglo["id"]);
        
        $lista_evento = $this->datos->build_list('mundolimpieza.listavalor','id','valor', "WHERE tipo = 'EstadoEvento' ORDER BY id ");
    	$arreglo['select_estado'] = $this->datos->armSelect($lista_evento,'Seleccione Estado...',isset($arreglo['datosEvento']->idEstado)?$arreglo['datosEvento']->idEstado:"");
        
        $arreglo["evento"]["fechaIni"] = $arreglo["datosEvento"]->fechaInicio;
        $arreglo["evento"]["fechaFin"] = $arreglo["datosEvento"]->fechaFin;
        $arreglo["evento"]["asunto"] = $arreglo["datosEvento"]->asunto;
        $arreglo["evento"]["implicados"] = $arreglo["datosEvento"]->implicados;
        
        $arreglo["evento"]["calendario"] = "calendario";
        $arreglo["evento"]["idOferta"] = $arreglo["datosEvento"]->idOfertaEconomica;
        $arreglo["evento"]["id"] = $arreglo["datosEvento"]->id;
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR EVENTO "; // . strtoupper($arreglo['datosUsuario']->login);
        $arreglo['readonly'] = "readonly";
        
       
        
	$this->vista->editarCalendario($arreglo);
    }
        
    
    function guardarCalendario($arreglo){
        
       // echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            
           
            $this->datos->actualizarCalendario($arreglo);
            
	}
	else{
            
            $this->datos->insertarCalendario($arreglo);            
	}
        
	$this->mostrarCalendario($arreglo);
    }    
    
    function eliminarCalendario($arreglo){       
        $this->datos->inactivarUsuario($arreglo["id"]);
        $this->mostrarUsuarios($arreglo);
    }   
    
   function fecha($valor){
	$timer = explode(" ",$valor);
	$fecha = explode("-",$timer[0]);
	$fechex = $fecha[2]."/".$fecha[1]."/".$fecha[0];
	return $fechex;
}

function buscar_en_array($fecha,$array){
	$total_eventos=count($array);
	for($e=0;$e<$total_eventos;$e++){
		if ($array[$e]["fecha"]==$fecha) return true;
	}
}


function evento($evento){
    
        switch($evento["accion"]){
                 
            case "listar_evento":
                
                 $listaEvento = $this->datos->listarEvento($evento["fecha"]);
                
                 foreach ($listaEvento as $key => $value){
                     
                     $nomEstadoEvento = $this->datos->traerEstadoEvento($value["idEstado"]);
                       
                     $verEvento = "<button onclick='acordion();' class='accordion'>" . $value["asunto"] . "</button>"
                                . "<div class='panel'>" 
                                . "<table align='center' width='100%' cellpadding='0' cellspacing='0' class='tablaOferta'>"
                                . "<thead>"
                                . "<tr>"
                                . "<td width='100' id='columna_fechaInicio' class='tituloAlineado'>Fecha Inicio</td>"
                                . "<td width='100' id='columna_fechaFin' class='tituloAlineado'>Fecha Fin</td>"
                                . "<td width='100' id='columna_asunto' class='tituloAlineado'>Asunto</td>"
                                . "<td width='100' id='columna_implicado' class='tituloAlineado'>Implicados</td>"
                                . "<td width='100' id='columna_estado' class='tituloAlineado'>Estado</td>"
                                . "<td width='100' id='columna_ofert' class='tituloAlineado'>Oferta Economica</td>"
                                . "<td width='100' id='columna_ofert' class='tituloAlineado'>Editar Evento</td>"
                                . "</tr>"
                                . "</thead>"
                                . "<tbody>"
                                . "<td>" . $value["fechaInicio"] . "</td>"
                                . "<td>" . $value["fechaFin"] . "</td>"
                                . "<td>" . $value["asunto"] . "</td>"
                                . "<td>" . $value["implicados"] . "</td>"
                                . "<td>" . $nomEstadoEvento->nombre . "</td>"
                                . "<td>" . $value["idOfertaEconomica"] . "</td>"
                                . "<td>"
                                . "<a href='#' class='editar_evento' rel='".$value["id"]."' title='Editar este Evento del ". $this->fecha($value["fechaInicio"])."'><img src='css/imagenes/eventos/editarEvento.png' width='40' height='40' border='0'></a>"
                                . "<a href='#' class='eliminar_evento' rel='".$value["id"]."' title='Eliminar este Evento del ". $this->fecha($value["fechaInicio"])."'><img src='css/imagenes/eventos/delete.png' width='20' height='20' border='0'></a>"
                                . "</td>"
                                . "</tbody>"
                                . "</table>"
                                . "</div>";


                                
                                  
                     echo $verEvento;
                     //echo "<p>".$valueList["asunto"]."<a href='#' class='eliminar_evento' rel='".$valueList["id"]."' title='Eliminar este Evento del ". $this->fecha($valueList["fechaInicio"])."'><img src='css/imagenes/eventos/delete.png'></a></p>";
                     
		 }
            
            
            break;
            
            case "borrar_evento":
                
                
                $this->datos->eliminarEvento($evento["id"]);
                
		 echo "<p class='ok'>Evento Cerrado correctamente.</p>";
                
                 $this->eventoApoyo($evento);
                
            break;
	
            case "generar_calendario":
                
                if($evento["mes"] == date("m")){
        
                       $evento["mes"] = date("m");
                       $evento["anio"] = date("Y");
        
                }elseif($evento["metodo"] == "siguiente"){
                    
                        $evento["mes"] = $evento["mes"];
                        $evento["anio"] = $evento["anio"];
                        
                    
                       }else{
                        
                        $difMes =  date("m") - $evento["mes"];
                        $evento["mes"] = $evento["mes"] + $difMes;
                        $evento["anio"] = date("Y");
                     
                            if($evento["mes"] <= 1){
                         
                                    $evento["mes"] = 1;
                                    $evento["anio"] = $evento["anio"] + 1;
            
                            }
                        
                    }
                     
                    
                    
                
	
		$fecha_calendario=array();
		if($evento["mes"]=="" || $evento["anio"]==""){
			$fecha_calendario[1]=intval(date("m"));
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			$fecha_calendario[0]=date("Y");
		} 
		else{
			$fecha_calendario[1]=intval($evento["mes"]);
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			else $fecha_calendario[1]=$fecha_calendario[1];
			$fecha_calendario[0]=$evento["anio"];
		}
		$fecha_calendario[2]="01";
		
			
		// obtenemos el dia de la semana del 1 del mes actual 
		$primeromes=date("N",mktime(0,0,0,$fecha_calendario[1],1,$fecha_calendario[0]));
                        
		 //comprobamos si el año es bisiesto y creamos array de días 
		if (($fecha_calendario[0] % 4 == 0) && (($fecha_calendario[0] % 100 != 0) || ($fecha_calendario[0] % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
		else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
		
                
		$eventos=array();
		$genCalen = $this->datos->generarCalendario($fecha_calendario[1],$fecha_calendario[0]);
                
                foreach ($genCalen as $key => $valueCalen){
                    
                        $eventos[$valueCalen["fechaInicio"]]=$valueCalen["total"];                    
                    
                }
		
		$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		// calculamos los días de la semana anterior al día 1 del mes en curso
		$diasantes=$primeromes-1;
			
		// los días totales de la tabla siempre serán máximo 42 (7 días x 6 filas máximo) 
		$diasdespues=42;
			
		//calculamos las filas de la tabla 
		$tope=$dias[intval($fecha_calendario[1])]+$diasantes;
		if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
		else $totalfilas=intval(($tope/7));
			
		// empezamos a pintar la tabla//
		echo "<h2>Calendario de Eventos para: ".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." <abbr title='S&oacute;lo se pueden agregar eventos en d&iacute;as h&aacute;biles y en fechas futuras (o la fecha actual).'>(?)</abbr></h2>";
		if (isset($mostrar)) echo $mostrar;
			
		echo "<table class='calendario' cellspacing='0' cellpadding='0'>";
			echo "<tr><th>Lunes</th><th>Martes</th><th>Mi&eacute;rcoles</th><th>Jueves</th><th>Viernes</th><th>S&aacute;bado</th><th>Domingo</th></tr><tr>";
			
		         //inicializamos filas de la tabla
			$tr=0;
			$dia=1;
		
			function es_finde($fecha){
                            
				$cortamos=explode("-",$fecha);
                                $dia=$cortamos[2];
				$mes=$cortamos[1];
				$ano=$cortamos[0];
				$fue=date("w",mktime(0,0,0,$mes,$dia,$ano));
				if (intval($fue)==0 || intval($fue)==6) return true;
				else return false;
			}
			
			for ($i=1;$i<=$diasdespues;$i++){
                            
				if ($tr<$totalfilas){
					if($i>=$primeromes && $i<=$tope){
						echo "<td class='";
						/* creamos fecha completa */
						if($dia<10){
                                                    $dia_actual="0".$dia;                                                     
                                                }else{
                                                    $dia_actual=$dia;
                                                }
                                               
						$fecha_completa=$fecha_calendario[0]."-".$fecha_calendario[1]."-".$dia_actual;
                                                
                                                if(isset($eventos[$fecha_completa])){
                                                
                                                    echo "evento";
						    $hayevento=$eventos[$fecha_completa];
						}else{
                                                    $hayevento=0;
                                                }
						
						/* si es hoy coloreamos la celda */
						if(date("Y-m-d")==$fecha_completa){
							echo " hoy";
						}	
						echo "'>";
                                                
						/* recorremos el array de eventos para mostrar los eventos del día de hoy */
                                                if($hayevento>0){
                                                        
                                                        echo "<a href=\"javascript:verEvento('".$fecha_completa."')\" data-evento='#evento".$dia_actual."'  rel='".$fecha_completa."' title='Hay ".$hayevento." eventos'>".$dia."</a>";
						       }else{
							   echo "$dia";
						        }
						
						/* agregamos enlace a nuevo evento si la fecha no ha pasado */
						$fecha = $this->fecha($fecha_completa);
                                                if(date("Y-m-d")<=$fecha_completa && es_finde($fecha_completa)==false){
                                                    echo "<a href=\"javascript:verEvento('".$fecha_completa."')\" data-evento='#nuevo_evento' title='Agregar un Evento el ".$fecha."' class='add agregar_evento' rel='".$fecha_completa."'>&nbsp;</a>";
                                                }
                                                
						echo "</td>";
						$dia+=1;
					 }else{
                                            echo "<td class='desactivada'>&nbsp;</td>";
                                        }
                                        
					if($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42){
                                            echo "<tr>";$tr+=1;
                                           
                                        }
				}
			}
			echo "</table>";
			
			$mesanterior=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]-1,01,$fecha_calendario[0]));
                        $messiguiente=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]+1,01,$fecha_calendario[0]));
                        echo "<p class='toggle'>&laquo; <a href='#' rel='$mesanterior' class='anterior' id='anterior'>Mes Anterior</a> - <a href='#' class='siguiente' rel='$messiguiente' id='siguiente'>Mes Siguiente</a> &raquo;</p>";
		break;
	
	
        }
    
    
}

function eventoApoyo($evento){
    
    $evento["accion"] = "listar_evento";
    
    $fechaInicio = $this->datos->traerFechaEvento($evento["id"]);
    
    $evento["fecha"] = $fechaInicio->fechaInicio;
    
    $this->evento($evento);
    
}   
    

	

}

?>


