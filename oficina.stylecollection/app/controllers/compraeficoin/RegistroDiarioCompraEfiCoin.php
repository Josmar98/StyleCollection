<?php 
	
    // $id_campana = $_GET['campaing'];
    // $numero_campana = $_GET['n'];
    // $anio_campana = $_GET['y'];
    // $id_despacho = $_GET['dpid'];
    // $num_despacho = $_GET['dp'];
    // $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
    // $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
    // $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1 ORDER BY pagos_despachos.id_pago_despacho ASC;");
    // $despacho = $despachos[0];
	$menu3="";
    $estados="";
	
	if(!empty($_GET['fecha_seleccionada'])){
        $fecha_desde = $_GET['fecha_seleccionada']." 00:00:00";
        $fecha_hasta = $_GET['fecha_seleccionada']." 23:59:59";
        // $fechaActualHoy = date('Y-m-d');
        // $numDiaHoy= date('w');
        // $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        // $numDiasHabiles = 0;
        // $numDiasMenos = 0;
        // // $diaHoy = $dias[date('w')];
        $estados="Abonado";
        
        $queryEfi="SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.estado_pago='{$estados}' and eficoin_divisas.fecha_registro BETWEEN '{$fecha_desde}' and '{$fecha_hasta}' ORDER BY eficoin_divisas.fecha_registro DESC;";
        $eficoins=$lider->consultarQuery($queryEfi);
        $id_efis="";
        $index=1;
        $cantidades=count($eficoins)-1;
        foreach ($eficoins as $efis) {
            if(!empty($efis['id_eficoin_div'])){
                $id_efis.=$efis['id_eficoin_div'];
                if($index<$cantidades){
                    $id_efis.=", ";
                }
                $index++;
            }
        }
        $detalleEficoin=$lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE eficoin_detalle.estatus = 1 and eficoin_detalle.id_eficoin_div IN ($id_efis)");
        $rutaRecarga = $menu3."route=".$_GET['route'];
    }
    // echo "<br><br>";

	if(empty($_POST)){
		
        if(!empty($action)){
            if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
                require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
            }else{
                require_once 'public/views/error404.php';
            }
        }else{
            if (is_file('public/views/'.$url.'.php')) {
                require_once 'public/views/'.$url.'.php';
            }else{
                require_once 'public/views/error404.php';
            }
        }
	}

// }else{
//     require_once 'public/views/error404.php';
// }

?>