<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	
	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['observacion'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$estado = $_POST['estado'];
	// 	$firma = $_POST['firma'];
	// 	$observacion = $_POST['observacion'];
	// 	$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', observacion='{$observacion}', estado='{$estado}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}

	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}
		

	// }


	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['leyenda'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$estado = $_POST['estado'];
	// 	$firma = $_POST['firma'];
	// 	$leyenda = $_POST['leyenda'];
	// 	$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', leyenda='{$leyenda}', estado='{$estado}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}

	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}


	// }

	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['tipo_pago']) && !empty($_POST['tasa'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$tasa = $_POST['tasa'];
	// 	$pago = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago = $id_pago");
	// 	$pago=$pago[0];
	// 	$equivalente_pago = "";
	// 	if($tasa!=""){
	// 		$equivalente_pago = $pago['monto_pago']/$tasa;
	// 		$equivalente_pago = number_format($equivalente_pago,2);
	// 	}
	// 	$tipo_pago = $_POST['tipo_pago'];
	// 	$exec = $lider->modificar("UPDATE pagos SET tasa_pago='{$tasa}', tipo_pago='{$tipo_pago}', equivalente_pago='{$equivalente_pago}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}



	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}
	// }

	// if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
	// 	$id = $_POST['id_pago'];
	// 	$pedido = $lider->consultarQuery("SELECT * FROm pagos,pedidos,clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago = $id");
	// 	echo json_encode($pedido);	
	// 	// $pago = $lider->consultarQuery("SELECT * FROM pagos WHERE ")

	// }

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE pagos SET estatus = 1 WHERE id_pago = '{$id}'";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pagos', 'Restaurar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}

		// if(!empty($action)){
		// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
		// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
		// 	}else{
		// 	    require_once 'public/views/error404.php';
		// 	}
		// }else{
		// 	if (is_file('public/views/'.$url.'.php')) {
		// 		require_once 'public/views/'.$url.'.php';
		// 	}else{
		// 	    require_once 'public/views/error404.php';
		// 	}
		// }
	}

	if(empty($_POST)){

		$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
		if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
			$id_cliente = $_GET['lider'];
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
			}else{
				$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
			}
		}else{
			if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
				$rangoI = $_GET['rangoI'];
				$rangoF = $_GET['rangoF'];
				$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF' ORDER BY fecha_pago asc");
			}else{
				$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
			}
			$id_cliente = $_SESSION['id_cliente'];
		}

		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1");
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");
		$resulttDescuentoNivelLider=0;
		$deudaTotal=0;
	 	$bonoContado1Puntual = 0;
	 	$bonoPago1Puntual = 0;
	 	$bonoCierrePuntual = 0;
	 	$bonoAcumuladoCierreEstructura = 0;
		if(Count($pedidos)>1){
			$pedido = $pedidos[0];	
			$id_pedido = $pedido['id_pedido'];
			$bonosContado1 = $lider->consultarQuery("SELECT * FROm bonoscontado WHERE id_pedido = $id_pedido");
	 		if(count($bonosContado1)>1){
	 			foreach ($bonosContado1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoContado1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
			$bonosPago1 = $lider->consultarQuery("SELECT * FROm bonosPagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id_pedido");
	 		if(count($bonosPago1)>1){
	 			foreach ($bonosPago1 as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoPago1Puntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
	 		$bonosCierre = $lider->consultarQuery("SELECT * FROm bonosPagos WHERE tipo_bono = 'Cierre' and id_pedido = $id_pedido");
	 		if(count($bonosCierre)>1){
	 			foreach ($bonosCierre as $bono) {
	 				if(!empty($bono['totales_bono'])){
	 					$bonoCierrePuntual += $bono['totales_bono'];
	 				}
	 			}
	 		}
	 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id_pedido");
	 		if(count($bonosCierreEstructura)>1){
	 			foreach ($bonosCierreEstructura as $bono) {
	 				if(!empty($bono['totales_bono_cierre'])){
	 					$bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre'];
	 				}
	 			}
	 		}
			$total = $pedido['cantidad_total'];
			$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad");
			if(count($liderazgos)>1){
				$lidera = $liderazgos[0];
				foreach ($liderazgosAll as $data) {
					if(!empty($data['id_liderazgo'])){
						if ($lidera['id_liderazgo'] >= $data['id_liderazgo']){
							$resultNLider = $data['descuento_coleccion']*$pedido['cantidad_aprobado'];
							$resulttDescuentoNivelLider += $resultNLider;
						}
					}
				}
			}
			$totalAprobado = $pedido['cantidad_aprobado'];
			$deudaTotal += $totalAprobado * $pedido['precio_coleccion'];
		}
		$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");
		$resulttDescuentoDirecto=0;
		foreach ($colss as $col) {
			if(!empty($col['id_plan_campana'])){
				if(!empty($col['descuento_directo']) && $col['descuento_directo']>0){
					$multi = $col['cantidad_coleccion']*$col['cantidad_coleccion_plan'];
					$resultt = $multi*$col['descuento_directo'];
					$resulttDescuentoDirecto+=$resultt;
				}
			}
		}
		$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPago1Puntual + $bonoCierrePuntual + $bonoAcumuladoCierreEstructura;
		$nuevoTotal = $deudaTotal-$descuentosTotales;
		// echo "Deuda: ".$deudaTotal."<br>";
		// echo "Descuentos: ".$descuentosTotales."<br>";
		// echo "Total: ".$nuevoTotal."<br>";

		//$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and planes.estatus = 1 and pedidos.estatus = 1");
		$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
		$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
		$despacho = $despachos[0];

		if($pagos['ejecucion']==1){
			$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			if(count($pagos)){
              foreach ($pagos as $data) {
                if(!empty($data['id_pago'])){
                  $reportado += $data['equivalente_pago'];
                  if($data['estado']=="Diferido"){
                    $diferido += $data['equivalente_pago'];
                  }
                  if($data['estado']=="Abonado"){
                    $abonado += $data['equivalente_pago'];
                  }
                }
              }
			}
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
		}else{
			require_once 'public/views/error404.php';
		}
	}
}else{
	require_once 'public/views/error404.php';
}


?>