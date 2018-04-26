<?php
require_once 'anexgrid.php';

try
{
    $anexGrid = new AnexGrid();
    
    /* Si es que hay filtro, tenemos que crear un WHERE dinámico */
    $wh = "id > 0";
    
    foreach($anexGrid->filtros as $f)
    {
        if($f['columna'] == 'login') $wh .= " AND login LIKE '%" . addslashes ($f['valor']) . "%'";
        if($f['columna'] == 'nombreUsuario') $wh .= " AND nombreUsuarui LIKE '%" . addslashes ($f['valor']) . "%'";
        if($f['columna'] == 'tipoDocumento' && $f['valor'] != '') $wh .= " AND tipoDocumento = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'numeroDocumento' && $f['valor'] != '') $wh .= " AND numeroDocumento = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'area' && $f['valor'] != '') $wh .= " AND area = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'email' && $f['valor'] != '') $wh .= " AND email = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'idRol' && $f['valor'] != '') $wh .= " AND idRol = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'ultimoIngreso' && $f['valor'] != '') $wh .= " AND ultimoIngreso = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'estado' && $f['valor'] != '') $wh .= " AND estado = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'intento' && $f['valor'] != '') $wh .= " AND intento = '" . addslashes ($f['valor']) . "'";
        if($f['columna'] == 'idPadre' && $f['valor'] != '') $wh .= " AND numeroDocumento = '" . addslashes ($f['valor']) . "'";

    }
    
    /* Nos conectamos a la base de datos */
    $db = new PDO("mysql:dbname=test;host=localhost;charset=utf8", "root", "" );
    //$db = new PDO("mysql:dbname=anexsoft_anexgrid;host=localhost;charset=utf8", "anexsoft_admin", "aspodiaowpdas234" );
    
    /* Nuestra consulta dinámica */
    $registros = $db->query("
        SELECT * FROM empleado
        WHERE $wh ORDER BY $anexGrid->columna $anexGrid->columna_orden
        LIMIT $anexGrid->pagina,$anexGrid->limite")->fetchAll(PDO::FETCH_ASSOC
     );
    
    $total = $db->query("
        SELECT COUNT(*) Total
        FROM empleado
        WHERE $wh
    ")->fetchObject()->Total;
    
    foreach($registros as $k => $r)
    {
        $profesion = $db->query("SELECT * FROM profesion p WHERE p.id = " . $r['Profesion_id'])
                        ->fetch(PDO::FETCH_ASSOC);
        
        $registros[$k]['Profesion'] = $profesion;
    }

    header('Content-type: application/json');
    print_r($anexGrid->responde($registros, $total));
}
catch(PDOException $e)
{
    echo $e->getMessage();
}