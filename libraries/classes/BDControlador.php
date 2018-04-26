<?php
class BDControlador
{
	/**
	 * La tabla de la base de datos donde los registros de esta clase son almacenados
	 *
	 * @var String
	 */
	var $table_name = '';

	/**
	 * Este es el nombre singular del objeto.  (i.e. Usuario).
	 *
	 * @var String
	 */
	var $object_name = '';

	/**
	 * El nombre de directorio del mdulo para este tipo de objeto.
	 *
	 * @var String
	 */
	var $module_directory = '';

	function Manejador_BD(){
	}

	function log($id_usuario, $modulo, $sqlquery, $funcion='save'){
		global $db;
                
                $sqlquery = addslashes($sqlquery);
		$sql="INSERT INTO etlsoluciones_portal.log
	              (
                    usuario,
	                modulo,
	                funcion,
	                query,
                    fecha
                   )VALUES(
                        '$id_usuario',
						'$modulo',
						'$funcion',
						'" . $sqlquery ."',
                         now())";
                
		$db->query($sql);
	}



	function build_list($table,$code,$name_camp,$where=''){
		global $db;
                
		$sql = "SELECT $code,$name_camp
				FROM $table
				$where";
				 
				$db->query($sql);
				$result = $db->GetArray();
				$array = array();                                 
				foreach ($result as $key=>$index)
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
	 
	/**
	 * function guardar()
	 * Guarda el objeto. Si se ingresa un id se actualiza dicho registro de lo contrario se inserta un nuevo registro.
	 *
	 *
	 * @param ID $registro_id ID del registro que se va a guardar
	 * @return BOOLEAN true si guarda correctamente false de lo contrario
	 *
	 */
	function save($registro_id=0, $campo='id', $log='save'){
		global $db;
		$variables_objeto = get_class_vars(get_class($this));
		$total_campos = count($variables_objeto);
		$numero_campo = 1;
		$sql_campos='';
		$sql_variables='';
		$sql_par_ini='(';
		$sql_par_fin=')';
		if($registro_id>0){
			$sql_guardar = "UPDATE ".$this->table_name." SET";
			 
			foreach($variables_objeto as $variable => $valor){
				if($variable != 'table_name' && $variable != 'module_directory' && $variable != 'object_name'
				&& $variable != 'campos' && $variable!='camposSincronizar' && $variable != 'fecha_creacion' && ($variable != 'id') && $variable != "_etapa"){
					if($numero_campo!=$total_campos && $numero_campo>1) $sql_guardar .=", ";
					if ($this->$variable === null){
						$sql_guardar .= " $variable = NULL";
					}else{
						if($this->$variable === "on"){
							$this->$variable = 1;
						}
						$sql_guardar .= " $variable = '".addslashes($this->$variable)."'";
					}
					$numero_campo++;
				}else{
					$total_campos--;
				}
			}


		}else{
			$sql_guardar = "INSERT INTO ".$this->table_name." ";

			foreach($variables_objeto as $variable => $valor){
				 
				 
				if($variable != 'table_name' && $variable != 'module_directory' && $variable != 'object_name'
				&& $variable != 'campos' && $variable!='camposSincronizar' && $variable != 'fecha_creacion' && ($variable != 'id') && $variable != "_etapa"){
					//if ($numero_campo==1)$sql_guardar .="( ";
					if($numero_campo!=$total_campos && $numero_campo>1) {$sql_campos .=", "; $sql_variables.=", "; }
					if ($this->$variable === null){

						$sql_campos .= " $variable  ";
						$sql_variables.="''";
					}else{
						if($this->$variable === "on"){
							$this->$variable = 1;
						}
						$sql_campos .= " $variable  ";
						$sql_variables.="'".addslashes($this->$variable)."'";
					}
					$numero_campo++;
				}else{
					$total_campos--;
				}
			}
			$sql_campos=$sql_par_ini.$sql_campos.$sql_par_fin;
			$sql_variables=$sql_par_ini.$sql_variables.$sql_par_fin;
			$sql_guardar.=" ".$sql_campos." VALUES ".$sql_variables;
		}

		if($registro_id>0){
			$sql_guardar .= " WHERE $campo = $registro_id";
			//__P($sql_guardar);
			//exit;
			$db->query($sql_guardar);
			$this->log($_SESSION['datos_logueo']['idUsuario'], 'N/A', $this->module_directory, base64_encode($sql_guardar),$log);
			return $registro_id;
		}else{
			//__P($sql_guardar);
			//exit;
                    echo $sql_guardar;
			$query_result=$db->query($sql_guardar);
			$query            = 'select SCOPE_IDENTITY() AS last_insert_id';
			$query_result     = mssql_query($query)
			or die('Query failed: '.$query);

			$query_result    = mssql_fetch_object($query_result);

			$this->log($_SESSION['datos_logueo']['idUsuario'], 'N/A', $this->module_directory, base64_encode($sql_guardar),$log);
			return $query_result->last_insert_id;

		}
	}

	/**
	 * Funcin trae una sola fila de datos basado en un valor de clave primaria.
	 *
	 * Los datos recuperados son colocados en el objeto instanciado. La funcin tambien procesa los datos formateandolos en
	 * el formato correcto de hora/fecha y valores nmericos.
	 *
	 * @param string $id usado para la bsqueda
	 * @param boolean $codificar Optional, predeterminado true, codifica los valores recuperados de la base de datos.
	 *
	 */
	function recover($id, $field = null, $poblarObjeto = true){
		global $db;
		if ($field === null){
			$field = 'id';
		}else{
			$field = $field;
		}
		$query = "SELECT $this->table_name.* FROM $this->table_name"
		." WHERE $this->table_name.{$field} = '$id' ";
		//$GLOBALS['log']->debug("Recuperar $this->object_name : ".$query);
		//__P($query);
		//exit;
		$db->query($query);
		$result = $db->getArray();

		if(empty($result)){
			return null;
		}

		if(!count($result)>0){
			return null;
		}

		if($poblarObjeto === true){
			$this->poblar_desde_fila($result[0]);
			return $this;
		}else{
			return $registry;
		}
	}


	/**
	 * Coloca el valor de la fila recuperada en el objeto actual.
	 *
	 * @param ARRAY $registro fila recuperada
	 *
	 */
	function poblar_desde_fila($registro){
		foreach($this->campos as $campo){
			if(isset($registro[$campo]) && $registro[$campo] != ""){
				$this->$campo = $registro[$campo];
			}else{
				if (!isset($registro[$campo]) && $this->$campo === null){
					$this->$campo = null;
				}else{
					$this->$campo = '';
				}
			}
		}
	}
	/**
	 * Funcin trae un listado con todos los registro del objeto
	 *
	 * Los datos recuperados son devueltos en un array.
	 *
	 * @param STRING $where usado para limitar los registros
	 * @param ARRAY $campos array que se utiliza para seleccionar los campos que se necesitan del listado
	 * @return ARRAY $registros arreglo con los registros de la lista
	 *
	 */
	function get_listed($where = "", $campos=array(), $associative = false, $return_result = false){
		global $db;
		$campos = (count($campos)>0)?$campos:$this->campos;
		$sql_list = "SELECT ";
		$sql_list .= $this->select_fields_build($campos);
		$sql_list .= " FROM ".$this->table_name;
		if(!empty($where)) $sql_list .= "\n WHERE $where";

		//__P($sql_list);
		//exit;

		$db->query($sql_list);
		return $db->GetArray();
	}

	/**
	 * function select_fields_build()
	 * Construye una cadena de los campos que se colocarn en el select separado por comas
	 *
	 * @param ARRAY $campos array que se utiliza para seleccionar los campos que se necesitan del listado
	 * @return STRING $cadena_campos campos separados por comas
	 */
	function select_fields_build($campos=array()){
		return implode(",", $campos);
	}

	/**
	 * function armSelect()
	 * Construye un select html con la informaci�n del arreglo asociativo que llega como par�metro
	 *
	 * @param ARRAY $array: array que contiene el nombre y valor que tendr� el select
	 * @param STRING $title: nombre de la primera fila del select que no tendr� valor. Ej: Selecione un Valor...
	 * @param STRING $seleccion: Contiene el valor del campo que se selecciona en la primera carga del select
	 * @param INT $maxCaracteres: Cantidad m�xima de caracteres a mostrar en el estacio del Select.
	 */
	function armSelect($array,  $title = '-',$seleccion='NA' ,$maxCaracteres = 50){
		$returnValue = "<OPTION VALUE=\"\" SELECTED>$title</OPTION> \n";
		foreach($array as $key => $value)
		{
			$selected  = ($seleccion == $key)? ' SELECTED' : '';
			$returnValue.= "<OPTION VALUE=\""
			. $key
			. "\"$selected>"
			. htmlentities(ucwords( substr($value, 0, $maxCaracteres)), ENT_QUOTES, "iso-8859-1"). "</OPTION>\n";
		}
		return $returnValue;
	}
        
        function armSelectMultiple($array,$seleccion=array() ,$maxCaracteres = 50){
		//$returnValue = "<OPTION VALUE=\"\" SELECTED>$title</OPTION> \n";
                $returnValue ="";
		foreach($array as $key => $value)
		{
			$selected  = in_array($key,$seleccion)? ' SELECTED' : '';
			$returnValue.= "<OPTION VALUE=\""
			. $key
			. "\"$selected>"
			. htmlentities(ucwords( substr($value, 0, $maxCaracteres)), ENT_QUOTES, "iso-8859-1"). "</OPTION>\n";
		}
		return $returnValue;
	}
	 
	function deleted($id = null, $campo='id', $campoEliminado='eliminado'){
		if(is_numeric($id) === true){
			if($this->recover($id, $campo) === null){
				return false;
			}else{
				$this->$campoEliminado = 1;
				$this->save($id, $campo ,'delete');
				return true;
			}
		}else{
			return null;
		}
	}
	
	function delete_rows($entidad = null, $where=''){
		if(is_null($entidad)){
			$entidad = $this->table_name;
		}
		global $db;
   		$db->query("DELETE FROM ".$entidad." ".$where);
	}
	
	public function iniciar(){
   		global $db;
   		$db->query("BEGIN TRAN");
   	}
   	
   	public function regresar(){
   		global $db;
   		$db->query("ROLLBACK");
   	}
   	
   	public function commit(){
   		global $db;
   		$db->query("COMMIT");
   	}
        function retornarPermisos($idUsuario,$idMenu){    
            global $db;
            
            $query="SELECT  m.editar,m.eliminar,m.crear
                    FROM    etlsoluciones_portal.roles_menu m,
                            etlsoluciones_portal.usuario u
                    WHERE   m.idRol=u.idRol
                        AND m.idMenu=" . $idMenu . "
                        AND u.id=" . $idUsuario . "";
            $db->query($query);
            return $db->fetch();
        }             
    function logEjecucionCall($idRegistroEncuesta,$tipo,$movimiento,$idUsuario){
		global $db;
                
                
		$sql="INSERT INTO calidad.cal_log_ejecucion
	              (
                        idRegistroEncuesta,
                        fecha,
                        tipo,
                        movimiento,
                        idUsuario
                        )VALUES(
                        '$idRegistroEncuesta',
                         now(),
                        '$tipo',
			'$movimiento',
                        '$idUsuario')";
                
		$db->query($sql);
	} 
}
?>
