<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once COMPONENTS_PATH . 'CertiLabo/vista/vistaCertiLabo.php';
include_once COMPONENTS_PATH . 'CertiLabo/modelo/datosCertiLabo.php';
//include_once CLASSES_PATH . ' MPDF/mpdf.php';



class CertiLabo{
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
        $this->datos = new DatosCertiLabo();
        $this->vista = new VistaCertiLabo($this->datos);
    }
    
    public function mostrarCertifi($arreglo){
    	/** 
    	 * Muestra los usuarios del aplicativo
    	 */
       //echo'<pre>';print_r($arreglo);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];

        $permisos->certificadoLab = 
        '<div class="card-deck">
          <div class="card cardEtl card-outline-info">
           <img class="card-img-top imageCertiLab" src="imagenes/desCertiLaboral.png" alt="Card image cap">
             <div class="card-block">
               <h4 class="card-title">Certificado Laboral Sin Sueldo</h4>
             </div>
             <div class="card-block">
               <a href="#" id="cerLab" onclick="generarCetiLabPdf()" class="card-link btn btn-outline-primary">Generar</a>
             </div>
          </div>
          <div class="card cardEtl card-outline-info">
           <img class="card-img-top imageCertiLab" src="imagenes/desCertiLaboralCon.png" alt="Card image cap">
             <div class="card-block">
               <h4 class="card-title">Certificado Laboral Con Sueldo</h4>
             </div>
             <div class="card-block">
               <a href="#" id="cerLab" onclick="generarCetiLaSulbPdf()" class="card-link btn btn-outline-primary">Generar</a>
             </div>
          </div>
          <div class="card cardEtl card-outline-info">
           <img class="card-img-top imageCertiLab" src="imagenes/despreNomi.png" alt="Card image cap">
             <div class="card-block">
               <h4 class="card-title">Desprendible De Nomina</h4>
             </div>
             <div class="card-block">
               <a href="#" id="cerLab" onclick="generarDesprNomina()" class="card-link btn btn-outline-primary">Generar</a>
             </div>
          </div>          
        </div>';



        //echo'<pre>';print_r($_SESSION);echo'</pre>';
        //echo'<pre>';print_r($arreglo);echo'</pre>';
       //echo'<pre>';print_r($permisos);echo'</pre>';
        
        $this->vista->mostrarCertiLabo($permisos);    	
    }

    function generarCetiLaSulbPdf($arreglo){
       
       
        $idEmp = $this->datos->traerIdEmpleado($_SESSION["datos_logueo"]["idUsuario"]);
        $arreglo["datosEmpleado"] = $this->datos->selectCertiLabConSuel($idEmp->idEmpleado);
        $totalSalario = 0;

        foreach ($arreglo["datosEmpleado"] as $key => $value) {
           
           $totalSalario = $totalSalario +  $value["valor"];

           if($value["descripcion"] === "Salario Ordinario") {

              $arreglo["datosEmpleado"]["SalarioBasico"] = $value["valor"];
           }elseif($value["descripcion"] === "Subsidio de Transporte") {
               $arreglo["datosEmpleado"]["transporte"] = $value["valor"];
           }elseif($value["descripcion"] === "Bono de Solidaridad") {
               $arreglo["datosEmpleado"]["bonoAdicional"] = $value["valor"];
           }elseif($value["descripcion"] === "Auxilio de Equipo") {
               $arreglo["datosEmpleado"]["AuxEquipo"] = $value["valor"];
           }

        }
        
        $arreglo["datosEmpleado"]["diaIngre"] = date("d",strtotime($arreglo["datosEmpleado"][0]["fechaIngreEmple"]));
        $arreglo["datosEmpleado"]["mesIngre"] = $this->obtenerFechaEnLetra($arreglo["datosEmpleado"][0]["fechaIngreEmple"]);
        $arreglo["datosEmpleado"]["anoIngre"] = date("Y",strtotime($arreglo["datosEmpleado"][0]["fechaIngreEmple"]));
        $arreglo['datosEmpleado']["totalSal"] = $totalSalario;
        

        $fechActual = date("m/d/y");
        $arreglo['datosEmpleado']["totalLetra"] =  $this->numtoletras($totalSalario);
        $arreglo["datosEmpleado"]["diaSoli"] = date("d");
        $arreglo["datosEmpleado"]["mesSoli"] = $this->obtenerFechaEnLetra($fechActual);
        $arreglo["datosEmpleado"]["anoSoli"] = date("Y");
        $arreglo["datosEmpleado"]["nombre"] = $arreglo["datosEmpleado"][0]["nombre"];
        $arreglo["datosEmpleado"]["tipoDocumento"] = $arreglo["datosEmpleado"][0]["tipoDocumento"];
        $arreglo["datosEmpleado"]["numeroDocumento"] = $arreglo["datosEmpleado"][0]["numeroDocumento"];
        $arreglo["datosEmpleado"]["cargo"] = $arreglo["datosEmpleado"][0]["cargo"];
        $arreglo["datosEmpleado"]["tipoContrato"] = $arreglo["datosEmpleado"][0]["tipoContrato"];
        

        $this->mostrarCertifi($arreglo);
        $this->vista->generarCetiLabSuelPdf($arreglo["datosEmpleado"] );
    }


function generarCetiLabPdf($arreglo){

    

        $idEmp = $this->datos->traerIdEmpleado($_SESSION["datos_logueo"]["idUsuario"]);
        $arreglo["datosEmpleado"] = $this->datos->selectCertiLabSinSuel($idEmp->idEmpleado);
        
        $arreglo["datosEmpleado"]->diaIngre = date("d",strtotime($arreglo["datosEmpleado"]->fechaIngreEmple));
        $arreglo["datosEmpleado"]->mesIngre = $this->obtenerFechaEnLetra($arreglo["datosEmpleado"]->fechaIngreEmple);
        $arreglo["datosEmpleado"]->anoIngre = date("Y",strtotime($arreglo["datosEmpleado"]->fechaIngreEmple));
       
        $fechActual = date("m/d/y");
        $arreglo["datosEmpleado"]->diaSoli = date("d");
        $arreglo["datosEmpleado"]->mesSoli = $this->obtenerFechaEnLetra($fechActual);
        $arreglo["datosEmpleado"]->anoSoli = date("Y");

        
        $this->mostrarCertifi($arreglo);
        $this->vista->generarCetiLabPdf($arreglo["datosEmpleado"] );
       
}

function generarDesprNomina($arreglo){

    

        $idEmp = $this->datos->traerIdEmpleado($_SESSION["datos_logueo"]["idUsuario"]);
        $arreglo["datosEmpleado"] = $this->datos->selectDespreNomiIngresos($idEmp->idEmpleado);
        $arreglo["datosEmpEgreso"] = $this->datos->selectDespreNomiEgresos($idEmp->idEmpleado);
        $total = 0;
        $totalNeto = 0;

        /********************** DATOS ENCABEZADO **************************/
        $arreglo["datosEnca"]["numeroDocumento"] = $arreglo["datosEmpleado"][0]["numeroDocumento"];
        $arreglo["datosEnca"]["nombre"] = $arreglo["datosEmpleado"][0]["nombre"];
        $arreglo["datosEnca"]["cargo"] = $arreglo["datosEmpleado"][0]["cargo"];
        $arreglo["datosEnca"]["periodo"] = $arreglo["datosEmpleado"][0]["mesAnio"];
        
        

        
        //echo'<pre>';print_r($arreglo["datosEmpleado"]);echo'</pre>';
        
        
        /*********************** INGRESOS ***************************/
        foreach ($arreglo["datosEmpleado"] as $key => $value) {

            $total = $total + $value["valor"];
            $arreglo["datosCertIngre"][$key]["codigo"] = $value["codigo"];
            $arreglo["datosCertIngre"][$key]["descripcion"] = $value["descripcion"];
            $arreglo["datosCertIngre"][$key]["cantidad"] = 1;
            $arreglo["datosCertIngre"][$key]["valor"] = $value["valor"];
            

        }

        
        /*********************** EGRESOS ****************************/
        foreach ($arreglo["datosEmpEgreso"] as $key => $valuEgre) {

            $totalNeto = $totalNeto + $valuEgre["valor"];
            $arreglo["datosCertEgre"][$key]["codigo"] = $valuEgre["codigo"];
            $arreglo["datosCertEgre"][$key]["descripcion"] = $valuEgre["descripcion"];
            $arreglo["datosCertEgre"][$key]["cantidad"] = 1;
            $arreglo["datosCertEgre"][$key]["valor"] = $valuEgre["valor"];

        }

        $arreglo["totales"]["total"] = $total;
        $arreglo["totales"]["totalNeto"] = $total - $totalNeto;
        $arreglo["totales"]["totalDeducciones"] = $totalNeto;

        $this->mostrarCertifi($arreglo);
        $this->vista->generarDesprenPdf($arreglo);
       
}

//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = $this->subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS ";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS"; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

function obtenerFechaEnLetra($fecha){

    $dia= $this->conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $mes;
}
 
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}

function desencriptar($cadena){
        $key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
       return $decrypted;  //Devuelve el string desencriptado
    }

    function verCertiLabo($arreglo){
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	    $listaCertiLabo=$this->datos->mostrarCertiLabo($arreglo);
       
	    $this->vista->verCertiLabo($listaCertiLabo);
    }
    
    function agregarCertiLabo($arreglo){        

        $arreglo["opcion"] = "agregar";
        
        $arreglo['datosDepto'] = $this->datos->datosDepto($arreglo);
         
        $lista_pais = $this->datos->build_list('CertiLabo.pais','id','nombrePais', 'WHERE 1=1 ORDER BY nombrePais ');
        $arreglo['select_pais'] = $this->datos->armSelect($lista_pais ,'Seleccione Pais...');
        
        $lista_depto = array();
        $arreglo['select_depto'] = "";
        //$lista_depto = $this->datos->build_list('CertiLabo.departamento','id','NombreDepto', 'WHERE 1=1 ORDER BY NombreDepto ');
        //$this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        $lista_municipio = array();
        $arreglo['select_municipio'] = "";
        //$lista_municipio = $this->datos->build_list('CertiLabo.municipio','id','nombreMunicipio', 'WHERE 1=1 ORDER BY nombreMunicipio ');
        //$this->datos->armSelect($lista_municipio ,'Seleccione Municipio...');
        
        //$lista_areaMetropolitana = array();
        //$arreglo['select_areaMetropolitana'] = "";
        $lista_areaMetropolitana = $this->datos->build_list('CertiLabo.areametropolitana','id','AreaMetropolitana', 'WHERE 1=1 ORDER BY AreaMetropolitana ');
        $arreglo['select_areaMetropolitana'] = $this->datos->armSelect($lista_areaMetropolitana ,'Seleccione Area Metropolitana...');
        
        $lista_ciudad = array();
        $arreglo['select_ciudad'] = "";
        //$lista_ciudad = $this->datos->build_list('CertiLabo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        //$this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        $lista_Localidad = array();
        $arreglo['select_Localidad'] = "";
        //$lista_Localidad = $this->datos->build_list('CertiLabo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        //$this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
        
        $lista_subLocalidad = array();
        $arreglo['select_SubLocalidad'] = "";
        //$lista_subLocalidad = $this->datos->build_list('CertiLabo.sublocalidad','id','nombreSubLocalidad', 'WHERE 1=1 ORDER BY nombreSubLocalidad ');
        //$this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...');
        
        
        
        
        $lista_codDane = $this->datos->build_list('CertiLabo.municipio','id','CodigoDane', 'WHERE 1=1 ORDER BY CodigoDane ');
        $arreglo['select_codDane'] = $this->datos->armSelect($lista_codDane ,'Seleccione Codigo Dane...');
        
        //$arreglo['datosAreaMetropol'] = $this->datos->selectAreaMetropol($arreglo['select_areaMetropolitana']);
        //$arreglo['datosAreaMetropol']->areaMetropol = $arreglo['datosAreaMetropol']->areaMetropolitana;
        
        
        $arreglo['disabled'] ="disabled";
        $arreglo["opcion"] = "agregar";
        $arreglo['titulo_tabla'] = "AGREGAR CertiLabo MASTER";
        
	$this->vista->agregarCertiLabo($arreglo);
    }
    
    function agregarPais($arreglo){
       
        $arreglo["opcion"] = "agregar";
        
        $arreglo['titulo_tabla'] = "AGREGAR PAIS";
            
         $this->vista->agregarPais($arreglo); 
         
    }  
    
    function agregarDepto($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        
        $lista_pais = $this->datos->build_list('CertiLabo.pais','id','nombrePais', 'WHERE 1=1 ORDER BY nombrePais ');
        $arreglo['select_pais'] = $this->datos->armSelect($lista_pais ,'Seleccione Pais...');
       
        
        $arreglo['titulo_tabla'] = "AGREGAR DEPARTAMENTO";
           
         $this->vista->agregarDepto($arreglo); 
    }
        
    function agregarAreaMetro($arreglo){
        
        $arreglo["opcion"] = "agregar";

        
        $arreglo['titulo_tabla'] = "AGREGAR AREA METROPOLITANA";
           
         $this->vista->agregarAreaMetro($arreglo); 
    }
    
    function agregarCiudad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
       $lista_areaMetropolitana = $this->datos->build_list('CertiLabo.areametropolitana','id','AreaMetropolitana', 'WHERE 1=1 ORDER BY AreaMetropolitana ');
        $arreglo['select_areaMetropolitana'] = $this->datos->armSelect($lista_areaMetropolitana ,'Seleccione Area Metropolitana...');
        
        $arreglo['titulo_tabla'] = "AGREGAR CIUDAD";
           
         $this->vista->agregarCiudad($arreglo); 
         
    }  
    
    function agregarMunicipio($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_depto = $this->datos->build_list('CertiLabo.departamento','id','NombreDepto', 'WHERE 1=1 ORDER BY NombreDepto ');
        $arreglo['select_depto'] = $this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        $arreglo['titulo_tabla'] = "AGREGAR MUNICIPIO";
           
         $this->vista->agregarMunicipio($arreglo); 
         
    }
    
    function agregarLocalidad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_ciudad = $this->datos->build_list('CertiLabo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        $arreglo['select_ciudad'] = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        $arreglo['titulo_tabla'] = "AGREGAR LOCALIDAD";
           
         $this->vista->agregarLocalidad($arreglo); 
         
    }
    
    function agregarSubLocalidad($arreglo){
        
        $arreglo["opcion"] = "agregar";
        
        $lista_Localidad = $this->datos->build_list('CertiLabo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        $arreglo['select_Localidad'] = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
        
        
        $arreglo['titulo_tabla'] = "AGREGAR SUBLOCALIDAD";
           
         $this->vista->agregarSubLocalidad($arreglo); 
         
    }
    
    function editarMicrozona($arreglo){        
	
        $arreglo['datosMicrozona'] = $this->datos->mostrarMicrozona($arreglo);
        
        $arreglo['datosMicrozona']->codigoDaneEdit = $arreglo['datosMicrozona']->codigoDane;
        $arreglo['datosMicrozona']->nicEdit = $arreglo['datosMicrozona']->nic;
        $arreglo['datosMicrozona']->nicDaneEdit = $arreglo['datosMicrozona']->nicDane;
        $arreglo['datosMicrozona']->areaKmEdit = $arreglo['datosMicrozona']->areaKm;
        
        $lista_ciudad = $this->datos->build_list('CertiLabo.ciudad','id','ciudad', 'WHERE 1=1 ORDER BY ciudad ');
        $arreglo['select_ciudad'] = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...',isset($arreglo['datosMicrozona']->idCiudad)?$arreglo['datosMicrozona']->idCiudad:"");
        
        $lista_municipio = $this->datos->build_list('CertiLabo.municipio','id','nombreMunicipio', 'WHERE 1=1 ORDER BY nombreMunicipio ');
        $arreglo['select_municipio'] = $this->datos->armSelect($lista_municipio ,'Seleccione Municipio...',isset($arreglo['datosMicrozona']->idMunicipio)?$arreglo['datosMicrozona']->idMunicipio:"");
        
        $lista_Localidad = $this->datos->build_list('CertiLabo.localidad','id','nombreLocalidad', 'WHERE 1=1 ORDER BY nombreLocalidad ');
        $arreglo['select_localidad'] = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...',isset($arreglo['datosMicrozona']->idLocalidad)?$arreglo['datosMicrozona']->idLocalidad:"");
        
        $lista_subLocalidad = $this->datos->build_list('CertiLabo.sublocalidad','id','nombreSubLocalidad', 'WHERE 1=1 ORDER BY nombreSubLocalidad ');
        $arreglo['select_SubLocalidad'] = $this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...',isset($arreglo['datosMicrozona']->idSubLocalidad)?$arreglo['datosMicrozona']->idSubLocalidad:"");
        
        $arreglo["opcion"] = "editar";     
        $arreglo['titulo_tabla'] = "EDITAR MICROZONA";
       
        
	$this->vista->editarMicrozona($arreglo);
        
    }        
    
    function guardarMircozona($arreglo){
        
        //echo'<pre>';print_r($arreglo);echo'</pre>';
	if($arreglo['opcion']=="editar"){
            $this->datos->actualizarMicrozona($arreglo);
	}else{
            $this->datos->insertarMicrozona($arreglo);            
	}
        
        $this->mostrarCertiLabo($arreglo);

    }
    
    function guardarPais($arreglo){
            
        $selPais = $this->datos->validaPais($arreglo);
          
            if(count($selPais)>0){
                $mensaje = "EL PAIS "  . $arreglo["nuevPais"] . " YA EXISTE";
                echo "<script type='text/javascript'>alert('$mensaje');</script>";
                     
                 }else{
                     $this->datos->insertarPais($arreglo);
                 }
                      
        $this->agregarCertiLabo($arreglo);
    }
    
    function guardarDepto($arreglo){
              
        $selDepto = $this->datos->validaDepto($arreglo);
          
            if(count($selDepto)>0){                     
                $mensaje = "LA COMBINACION YA EXISTE";
                echo "<script type='text/javascript'>alert('$mensaje');</script>";     
                
            }else{
                     $this->datos->insertarDepto($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
    
    function guardarCiudad($arreglo){
        
        $selCiudad = $this->datos->validaCiudad($arreglo);  
          
            if(count($selCiudad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                    echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     $this->datos->insertarCiudad($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
 
    function guardaAreaMetropol($arreglo){
        
        $selAreaMetropol = $this->datos->validaAreaMetropol($arreglo);  
          
            if(count($selAreaMetropol)>0){                     
                     $mensaje = "EL AREA METROPOLITANA "  . $arreglo["nuevAreaMetropol"] . " YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarAreaMetropol($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
    
    function guardaMunicipio($arreglo){
        
        $selMunicipio = $this->datos->validaMunicipio($arreglo);  
          
            if(count($selMunicipio)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarMunicipio($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
    
    function guardarLocalidad($arreglo){
        
        $selLocalidad = $this->datos->validaLocalidad($arreglo);  
          
            if(count($selLocalidad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarLocalidad($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
    
    function guardarSubLocalidad($arreglo){
        
        $selSubLocalidad = $this->datos->validaSubLocalidad($arreglo);  
          
            if(count($selSubLocalidad)>0){                     
                     $mensaje = "LA COMBINACION YA EXISTE";
                     echo "<script type='text/javascript'>alert('$mensaje');</script>";
                 }else{
                     
                     $this->datos->insertarSubLocalidad($arreglo);
                 }
                        
        $this->agregarCertiLabo($arreglo);
    }
    
    function inactivarCertiLabo($arreglo){  
      
       //echo'<pre>';print_r($arreglo);echo'</pre>';
       $this->datos->inactivarCertiLabo($arreglo["id"]);
       $this->mostrarCertiLabo($arreglo);
    }        
    
    function ajaxListaCertiLabo($arreglo){
        global $db_settings;
        //echo'<pre>';print_r($arreglo);echo'</pre>';
        //echo'<pre>';print_r($_POST);echo'</pre>';
        $permisos = $this->datos->retornarPermisos($_SESSION["datos_logueo"]["idUsuario"],$arreglo["idMenu"]);
        $permisos->idMenu=$arreglo["idMenu"];        
        
        $ds = new dacapo($db_settings, null);

        $page_settings = array(
                "selectCountSQL" => "SELECT count(id) as totalrows FROM CertiLabo.vista_microzona",              
                "selectSQL" => "SELECT mic.id, mic.idCiudad, mic.idMunicipio, mic.ciudad,mic.nombreMunicipio,mic.CodigoDane, mic.nic, mic.nicDane, mic.areaKm, mic.idLocalidad, mic.idSubLocalidad,mic.nombreLocalidad,mic.nombreSubLocalidad  FROM CertiLabo.vista_microzona mic",
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
     
         foreach($data['page_data'] as $key => $row) {
            
            // $nombreCiudad = $this->datos->retornarNombreCiudad($row['idCiudad']);
             
         /* if(isset($row['idUsuarioModificador'])){
              $usuarioNombre = $this->datos->retornarNombreUsuarioCertiLabo($row['idUsuarioModificador']);
              $data['page_data'][$key]['idUsuarioModificador'] = $usuarioNombre->nombre;
          }else{
             $row['idUsuarioModificador'] = ""; 
          }*/
             
              //$data['page_data'][$key]['idCiudad'] = $nombreCiudad->ciudad;
             
            $editar = "";
            $eliminar = "";
            
            if($permisos->editar =='SI'){
                
               $editar ="<a class=\"various fancybox.ajax\" href=\"index_blank.php?component=CertiLabo&method=editarMicrozona&id={$row['id']}&idMenu={$permisos->idMenu}\" ><img src=\"images/iconos/mis/editar.png\" title=\"Editar CertiLabo\" width=\"20\" height=\"20\" border=\"0\" /></a>";                       
              }        
            
              
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
    
    function consultarDepto($arreglo){
        
        $lista_depto = $this->datos->build_list('CertiLabo.departamento','id','NombreDepto', "WHERE idPais IN (" . $arreglo["idPais"] . ") ORDER BY NombreDepto ");
        $select_depto = $this->datos->armSelect($lista_depto ,'Seleccione Departamento...');
        
        echo $select_depto;    
        
    }
    
    function consultarMuni($arreglo){
        
        $lista_municipio = $this->datos->build_list('CertiLabo.municipio','id','nombreMunicipio', "WHERE idDepto IN (" . $arreglo["idDepto"] . ") ORDER BY nombreMunicipio ");
        $select_municipio = $this->datos->armSelect($lista_municipio ,'Seleccione Municipio...');
        
        echo $select_municipio;    
        
    }
    
    function consultarCiudad($arreglo){
        
        $lista_ciudad = $this->datos->build_list('CertiLabo.ciudad','id','ciudad', "WHERE idAreaMetropolitana IN (" . $arreglo["areaMetropolitana"] . ") ORDER BY ciudad ");
        $select_ciudad = $this->datos->armSelect($lista_ciudad ,'Seleccione Ciudad...');
        
        echo $select_ciudad;    
        
    }
    
    function consultarLocalidad($arreglo){
        
       $lista_Localidad = $this->datos->build_list('CertiLabo.localidad','id','nombreLocalidad', "WHERE idCiudad IN (" . $arreglo["idCiudad"] . ") ORDER BY nombreLocalidad ");
       $select_Localidad = $this->datos->armSelect($lista_Localidad ,'Seleccione Localidad...');
       
       echo $select_Localidad;
    }
    
    function consultarSubLocalidad($arreglo){
        
       $lista_subLocalidad = $this->datos->build_list('CertiLabo.sublocalidad','id','nombreSubLocalidad', "WHERE idLocalidad IN (" . $arreglo["localidad"] . ") ORDER BY nombreSubLocalidad ");
       $select_SubLocalidad = $this->datos->armSelect($lista_subLocalidad ,'Seleccione SubLocalidad...');
       
       echo $select_SubLocalidad;
    }
}

?>


