<?php 


// $amTasas = 0;
// $amTasasR = 0;
// $amTasasC = 0;
// $amTasasE = 0;
// $amTasasB = 0;
// foreach ($accesos as $access) {
//   if(!empty($access['id_acceso'])){
//     if($access['nombre_modulo'] == "Tasas"){
//       $amTasas = 1;
//       if($access['nombre_permiso'] == "Registrar"){
//         $amTasasR = 1;
//       }
//       if($access['nombre_permiso'] == "Ver"){
//         $amTasasC = 1;
//       }
//       if($access['nombre_permiso'] == "Editar"){
//         $amTasasE = 1;
//       }
//       if($access['nombre_permiso'] == "Borrar"){
//         $amTasasB = 1;
//       }
//     }
//   }
// }
// if($amTasasR == 1){
// if($_SESSION)
$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
$id_despacho = $_GET['dpid'];
$num_despacho = $_GET['dp'];
$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1 ORDER BY pagos_despachos.id_pago_despacho ASC;");
	$despacho = $despachos[0];
	################################################
	// $pagosObligatorios = "Y";
	$opInicial = $despacho['opcion_inicial'];
	$pagosObligatorios = $despacho['opcionInicialObligatorio'];
	$inObligatoria = $despacho['opcionOpcionalInicial'];
	################################################
	// echo "<br>";
	// echo $opInicial;
	// echo "<br>";
	// echo $pagosObligatorios;
	// echo "<br>";
	// echo $inObligatoria;
	// echo "<br>";
	$cantidadPagosDespachosFild = [];
	if($pagosObligatorios == "Y"){
		if($opInicial=="Y"){
			// if($inObligatoria=="N"){
				$sumAdd = 1;
				$cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
			// }else{
				// $sumAdd = 0;
			// }

		}else{
			$sumAdd = 0;
		}
		for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
			$key = $cantidadPagosDespachos[$i];
			if($key['cantidad'] <= $despacho['cantidad_pagos']){
				$cantidadPagosDespachosFild[$i+$sumAdd] = $key;
			}
		}
	}
	if($pagosObligatorios == "N"){
    $sumAdd = 0;
		for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
			$key = $cantidadPagosDespachos[$i];
			if($key['cantidad'] <= $despacho['cantidad_pagos']){
				$cantidadPagosDespachosFild[$i+$sumAdd] = $key;
			}
		}
	}

    
    $rutaRecarga = $menu3."route=".$_GET['route'];
    $rutaRecargaR = $menu3."route=".$_GET['route']."&action=".$_GET['action'];
    if(!empty($_GET['admin']) && !empty($_GET['select'])){
        $rutaRecargaR .= "&admin=".$_GET['admin']."&select=".$_GET['select'];
    }
    if(!empty($_GET['lider'])){
        $rutaRecargaR .= "&lider=".$_GET['lider'];
    }

    // $eficoins=$lider->consultarQuery("SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.id_cliente={$_GET['lider']} ORDER BY eficoin_divisas.fecha_pago DESC;");
    if($_SESSION['nombre_rol']=="Vendedor"){
		$eficoins=$lider->consultarQuery("SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.id_cliente={$_SESSION['id_cliente']} and eficoin_divisas.id_eficoin_div={$id} ORDER BY eficoin_divisas.fecha_registro DESC;");
	}else{
		$eficoins=$lider->consultarQuery("SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.id_eficoin_div={$id} ORDER BY eficoin_divisas.fecha_registro DESC;");
	}
    
    $bancosDepositos = $lider->consultarQuery("SELECT * FROM bancos WHERE tipo_cuenta='Divisas'");
    if(count($eficoins)>1){
        $eficoin=$eficoins[0];
        $detalleEficoin=$lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE eficoin_detalle.estatus = 1 and eficoin_detalle.id_campana={$id_campana} and eficoin_detalle.id_eficoin_div={$eficoin['id_eficoin_div']}");
        $detalleEficoin=$detalleEficoin[0];
        if(!empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) && !empty($_POST['serial']) && !empty($_POST['equivalente']) && empty($_POST['validarData'])){
            if(!empty($_GET['lider'])){
                $id_cliente = $_GET['lider'];
            }else{
                $id_cliente = $_SESSION['id_cliente'];
            }
            $pedidos=$lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente={$id_cliente} and id_despacho={$id_despacho}");
            if(count($pedidos)>1){
                $pedido=$pedidos[0];
                $id_pedido=$pedido['id_pedido'];
            }else{
                $id_pedido=null;
            }
            $fechaRegistro=date('Y-m-d');
            $fecha = $_POST['fechaPago'];
            $tipoPago = ucwords(mb_strtolower($_POST['tipoPago']));
            $serial = mb_strtoupper($_POST['serial']);
            $equivalente = (float) $_POST['equivalente'];
            $estado="Reportado";
            // echo "CAMPANA: ".$id_campana."<br>";
            // echo "PEDIDO: ".$id_pedido."<br>";
            // echo "CLIENTE: ".$id_cliente."<br>";
            // echo "FECHA: ".$fecha."<br>";
            // echo "FECHA Registro: ".$fechaRegistro."<br>";
            // echo "TIPO PAGO: ".$tipoPago."<br>";
            // echo "SERIAL: ".$serial."<br>";
            // echo "EQV: ".$equivalente."<br>";
            // echo "ESTADO: ".$estado."<br>";
            $id_detalle_eficoin=$_POST['id_detalle_eficoin'];
            $buscar = $lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE id_eficoin_div={$id} and id_detalle_eficoin={$id_detalle_eficoin}");
            $repetido=false;
            if(count($buscar)>1){
                $query="UPDATE eficoin_detalle SET tipo_pago='{$tipoPago}', referencia_pago='{$serial}' WHERE id_eficoin_div={$id} and id_detalle_eficoin={$id_detalle_eficoin}";
                // echo $query."<br><br>";
                $exec['ejecucion']=false;
                $exec = $lider->modificar($query);
            }else{
                $repetido=true;
                $exec['ejecucion']=false;
            }

            if($exec['ejecucion']==true){
                $response = "1";
                if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Eficoin Divisas', 'Modificar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                }
            }else{
                if($repetido==true){
                $response = "9";
                }else{
                $response = "2";
                }
            }


            $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
            $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 and clientes.id_cliente={$id_cliente} ORDER BY clientes.id_cliente ASC");
            // print_r($promociones);
            $lideres=$lideres[0];
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
            // print_r($exec);
        }
        if(empty($_POST)){
            if(!empty($_GET['lider'])){
                $id_cliente = $_GET['lider'];
            }else{
                $id_cliente = $_SESSION['id_cliente'];
            }
            $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
            $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 and clientes.id_cliente={$id_cliente} ORDER BY clientes.id_cliente ASC");
            // print_r($promociones);
            $lideres=$lideres[0];
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

    }else{
        require_once 'public/views/error404.php';
    }

?>