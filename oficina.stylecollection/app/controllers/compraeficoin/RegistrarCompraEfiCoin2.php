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
if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Analista"){
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
	// $pagosObligatorios = $despacho['opcionInicialObligatorio'];
	// $opInicial = $despacho['opcion_inicial'];
	$pagosObligatorios = $despacho['opcionInicialObligatorio'];
	// $inObligatoria = $despacho['opcionOpcionalInicial'];
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
  // foreach ($pagos_despacho as $key) {
  //   print_r($key['tipo_pago_despacho']);
  //   echo "<br><br>";  
  // }

  $rutaRecarga = $menu3."route=".$_GET['route'];
  $rutaRecargaR = $menu3."route=".$_GET['route']."&action=".$_GET['action'];
  if(!empty($_GET['admin']) && !empty($_GET['select'])){
    $rutaRecargaR .= "&admin=".$_GET['admin']."&select=".$_GET['select'];
  }
  if(!empty($_GET['lider'])){
    $rutaRecargaR .= "&lider=".$_GET['lider'];
  }

    if(!empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) && !empty($_POST['serial']) && !empty($_POST['equivalente']) && empty($_POST['validarData'])){
		// print_r($_POST);
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
		$fecha_operacion = date('Y-m-d H:i:s');
        $fechaRegistro=date('Y-m-d');
        $fecha = $_POST['fechaPago'];
        $tipoPago = ucwords(mb_strtolower($_POST['tipoPago']));
        $serial = mb_strtoupper($_POST['serial']);
        $equivalente = (float) $_POST['equivalente'];
        $firma = ucwords(mb_strtolower($_POST['firma']));
        $leyenda = ucwords(mb_strtolower($_POST['leyenda']));
        $estado="Abonado";
        // echo "CAMPANA: ".$id_campana."<br>";
        // echo "PEDIDO: ".$id_pedido."<br>";
        // echo "CLIENTE: ".$id_cliente."<br>";
        // echo "FECHA: ".$fecha."<br>";
        // echo "FECHA Registro: ".$fechaRegistro."<br>";
        // echo "TIPO PAGO: ".$tipoPago."<br>";
        // echo "SERIAL: ".$serial."<br>";
        // echo "EQV: ".$equivalente."<br>";
        // echo "ESTADO: ".$estado."<br>";
		
		$tasabcv="";
		$tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '{$fecha}'");
        if(Count($tasas)>1){
			$tasa = $tasas[0]; 
			$tasabcv = $tasa['monto_tasa'];
		}
		$tasaeficoin="";
		$tasas = $lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 and fecha_tasa = '{$fecha}'");
        if(Count($tasas)>1){
			$tasa = $tasas[0]; 
			$tasaeficoin = $tasa['monto_tasa'];
		}
		$monto="";
		$forma_pago="Divisas Dolares";
		$pagoID = "C".$id_campana."Y".$anio_campana."LDR".$id_cliente."PED".$id_pedido."P";
		$numss = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago LIKE '%{$pagoID}%'");
		// print_r($numss);
		$numMax = 0;
		if(count($numss)>1){
			$len = strlen($pagoID);
			foreach ($numss as $key) {
				if(!empty($key['id_pago'])){
					$n = substr($key['id_pago'], $len);
					if($n > $numMax){
						$numMax = $n;
					}
				}
			}
		}

		$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
		$numero_pago = $numMax+1;
		$numero_pago2 = $numMax+2;
		$pagoID2 = $pagoID.$numero_pago2;
		$pagoID .= $numero_pago;

		if(count($buscar)>1){
			// echo "Encontro Resultado, pero estan Repetidos";
			$continuar = false;
		}else if(count($buscar)<2){
			// echo "No encontro Resultados";
			$continuar = true;
		}
		if($continuar==true){
			$buscar = $lider->consultarQuery("SELECT * FROM eficoin_divisas WHERE fecha_pago = '{$fecha}' and equivalente_pago LIKE '%{$equivalente}%'");
			$repetido=false;
			$query = "INSERT INTO eficoin_divisas (id_eficoin_div, id_campana, id_pedido, id_cliente, fecha_pago, fecha_registro, tipo_pago, referencia_pago, equivalente_pago, estado_pago, id_pago, estatus) VALUES (DEFAULT, {$id_campana}, {$id_pedido}, {$id_cliente}, '{$fecha}', '{$fecha_operacion}', '{$tipoPago}', '{$serial}', {$equivalente}, '{$estado}', '{$pagoID}', 1)";
			// echo $query."<br><br>";
			// $exec['ejecucion']=true;
			$exec = $lider->registrar($query, "eficoin_divisas", "id_eficoin_div");
			if($exec['ejecucion']==true){
				// echo "<br>SE ejecutó el eficoin<br>";
				$response = "1";
				$queryPagos = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, firma, leyenda, estado, estatus) VALUES ('{$pagoID}', $id_pedido, '{$fecha}', '{$fechaRegistro}', '{$forma_pago}', '$tipoPago', '{$serial}', '{$monto}', '', '$equivalente', '{$firma}', '{$leyenda}', 'Abonado', 1)";
				// echo "<br>".$queryPagos."<br>";
				// $exec2['ejecucion']=true;
				$exec2 = $lider->registrar($queryPagos, "pagos", "id_pago");
				if($exec2['ejecucion']==true){
					$response2 = "1";
					$montobcv = (float) ($equivalente*$tasabcv);
					$montoeficoin = (float) ($equivalente*$tasaeficoin);
					$serial2=$serial."_EfiCoin";
					$monto2 = (float) ($montoeficoin-$montobcv);
					$equivalente2 = (float) number_format(($monto2/$tasabcv),2,'.','');
					$forma_pago2="Descuento por EfiCoin";
					
					$queryPagos2 = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, firma, leyenda, estado, estatus) VALUES ('{$pagoID2}', $id_pedido, '{$fecha}', '{$fechaRegistro}', '{$forma_pago2}', '{$tipoPago}', '{$serial2}', '{$monto2}', '{$tasabcv}', '{$equivalente2}', '{$firma}', '{$leyenda}', 'Abonado', 1)";
					// echo "<br>".$queryPagos2."<br>";
					// $exec3['ejecucion']=true;
					$exec3 = $lider->registrar($queryPagos2, "pagos", "id_pago");
					if($exec2['ejecucion']==true){
						$response3="1";
					}else{
						$response3="2";
					}
				}else{
					if($repetido==true){
						$response2 = "9";
					}else{
						$response2 = "2";
					}
				}
	
			}else{
				$response = "2";
			}
		}else{
			$response = "9";
		}
		if($response=="1" && $response2=="1" && $response3=="1"){
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Eficoin Divisas', 'Registrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response="2";
		}
		
        // die();
        $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
        $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
        // print_r($promociones);
		$rutaPdfEficoin = $menu3."route=".$_GET['route']."&action=GenerarRecepcionPago&id=".$pagoID;
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
        $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
        // print_r($promociones);
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