<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	$id_cliente = $_SESSION['id_cliente'];
	// $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE estatus = 1 and id_campana = $id_campana");
	// $colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad as cantidad, producto, descripcion, productos.cantidad as cantidad_producto, precio, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana");
	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_cliente and pedidos.id_despacho = $id_despacho");
	$existenciasPromocion = $lider->consultarQuery("SELECT * FROM existencias_promocion WHERE id_campana = {$id_campana}");
	$promociones = $lider->consultarQuery("SELECT * FROM clientes, pedidos, promocion, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promociones.id_despacho = {$id_despacho}");
	
	$promocionesFull = $lider->consultarQuery("SELECT * FROM clientes, pedidos, promocion, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1");
	$fechasPromociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
	// $pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
	$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
	$despacho = $despachos[0];

if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	// $query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
	// $res1 = $lider->eliminar($query);

	// if($res1['ejecucion']==true){
	// 	$response = "1";
	// }else{
	// 	$response = "2"; // echo 'Error en la conexion con la bd';
	// }

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
if(!empty($_POST['pedidos_historicos']) && !empty($_POST['id_pedido'])){
	$id_pedido = $_POST['id_pedido'];
	$pedidos_historicos = $lider->consultarQuery("SELECT id_pedidos_historicos, id_despacho, id_pedido, cantidad_aprobado, fecha_aprobado, hora_aprobado, pedidos_historicos.estatus, usuarios.id_usuario, usuarios.nombre_usuario, clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido FROM pedidos_historicos, usuarios, clientes WHERE pedidos_historicos.id_usuario=usuarios.id_usuario and usuarios.id_cliente = clientes.id_cliente and pedidos_historicos.id_despacho = {$id_despacho} and pedidos_historicos.id_pedido = {$id_pedido}");
	if(count($pedidos_historicos)>1){
		$result['msj']="Good";
		$result['data'] = [];
		$ind = 0;
		foreach ($pedidos_historicos as $key) {
			if(!empty($key['id_pedido'])){
				if($key['id_pedido']==$id_pedido){
					$result['data'][$ind] = $key;
					$ind++;
				}
			}
		}
		echo json_encode($result);
	}
}


if(empty($_POST)){
	// print_r($promociones);
	if($promociones['ejecucion']==1){
		if(count($fechasPromociones)>1){
			$fechasPromo = $fechasPromociones[0];
			$limite = date('Y-m-d');
			$opcionFacturasCerradas=0;
			if($limite <= $despacho['limite_pedido']){
				$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
				foreach ($configuraciones as $config) {
					if($config['clausula']=='Limitar Pedidos A Facturas Cerradas'){
						$opcionFacturasCerradas = $config['valor'];
					}
				}
				if($opcionFacturasCerradas==1){
					$verCampanas = $lider->consultarQuery("SELECT * FROM campanas WHERE estatus=1 and visibilidad=1 and id_campana < {$despacho['id_campana']} ORDER BY id_campana DESC;");
					$infoCamp = [];
					$infoCamp['restoGeneral']=0;
					$countG = 0;
					if(count($verCampanas)>1){
						foreach($verCampanas as $verCamp){ if(!empty($verCamp['id_campana'])){
							$restoFactura=0;
							// print_r($key);
							// echo "<br><br>";
							// $verIdCamp = $verCampanas[0]['id_campana'];
							// $infoCamp .= "Campaña ".$verCampanas[0]['numero_campana']."/".$verCampanas[0]['anio_campana'];
							$verIdCamp = $verCamp['id_campana'];
							
							$verDespachos = $lider->consultarQuery("SELECT * FROM despachos WHERE estatus=1 and id_campana={$verIdCamp}");
							if(count($verDespachos)>1){
								foreach ($verDespachos as $verDesp) {
									if(!empty($verDesp['id_despacho'])){
										$verIdDesp = $verDesp['id_despacho'];
										$verTotalFactura=0;
										$verCantidadAprobado=0;
										$verPrecioColeccion = $verDesp['precio_coleccion'];

										$verPedidos = $lider->consultarQuery("SELECT * FROM pedidos as p, despachos as d WHERE p.id_despacho=d.id_despacho and d.id_despacho={$verIdDesp} and p.id_cliente = {$_SESSION['id_cliente']} and p.estatus =1");
										if(count($verPedidos)>1){
											$verPedido = $verPedidos[0];
											$veridPed = $verPedido['id_pedido'];
											$verCantidadAprobado = $verPedido['cantidad_aprobado'];
											//Total Factura;
											$verTotalFactura = $verPrecioColeccion*$verCantidadAprobado;

											//Recuperar todos los descuentos;
											// ======================================= // ======================================== // =================================== //
												$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$verIdCamp} and despachos.id_despacho = {$verIdDesp} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
												
												$pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$verDesp['contado_precio_coleccion']];

												$iterRecor = 1;
												foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
													$pagosRecorridos[$iterRecor-1]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
													// echo $pagosD['tipo_pago_despacho'].": ".$pagosD['fecha_pago_despacho_senior']."<br>";
													if($pagosD['tipo_pago_despacho']=="Inicial"){
														$pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
														$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
														$iterRecor++;
													}
												} }
												
												$cantidadPagosDespachosFild = [];

												for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
													$key = $cantidadPagosDespachos[$i];
													if($key['cantidad'] <= $despacho['cantidad_pagos']){
														$cantidadPagosDespachosFild[$i] = $key;
														foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
															if($pagosD['tipo_pago_despacho']==$key['name']){
																if($i < $despacho['cantidad_pagos']-1){
																	$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
																	$iterRecor++;
																}
																if($i == $despacho['cantidad_pagos']-1){
																	$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
																	$iterRecor++;
																}
															}
														}}
													}
												}
												$resulttDescuentoNivelLider=0;
												$deudaTotal=0;
											 	$bonoContado1Puntual = 0;
											 	$bonoPagosPuntuales = 0;
											 	$bonoAcumuladoCierreEstructura = 0;
											 	$liquidacion_gemas = 0;
											 	$totalTraspasoRecibido=0;
											 	$totalTraspasoEmitidos=0;
												$abonado_lider_gemas = 0;
												$fechaPagoLimiteFinal = $pagosRecorridos[count($pagosRecorridos)-1]['fecha_pago'];
												$fecha_pago_cierre_lider = "";
												// foreach ($pagosRecorridos as $pagosR) {
												// 	$fechaPagoConceptoAct = $pagosR['fecha_pago'];
												// 	$conceptoPagoConceptoAct = $pagosR['name'];
												// 	$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$veridPed} and estado = 'Abonado' and tipo_pago = '{$conceptoPagoConceptoAct}' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
												// 	if(count($pagosGemas)>1){
												// 		$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
												// 		foreach ($pagosGemas as $key) {
												// 			if(!empty($key['fecha_pago'])){
												// 				$abonado_lider_gemas += $key['equivalente_pago']; 
												// 			}
												// 		}
												// 	}
												// }
												foreach ($pagosRecorridos as $pagosR) {
													$fechaPagoConceptoAct = $pagosR['fecha_pago'];
												}
												$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$veridPed} and estado = 'Abonado' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
												if(count($pagosGemas)>1){
													$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
													foreach ($pagosGemas as $key) {
														if(!empty($key['fecha_pago'])){
															$abonado_lider_gemas += $key['equivalente_pago']; 
														}
													}
												}

												$totalAprobado = $verPedido['cantidad_aprobado'];
												$deudaTotal += $totalAprobado * $verPedido['precio_coleccion'];
												
												$Opttraspasarexcedente = 0;
												$configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
												foreach ($configuraciones as $config) {
													if(!empty($config['id_configuracion'])){
														if($config['clausula']=="Opttraspasarexcedente"){
															$Opttraspasarexcedente = $config['valor'];
														}
													}
												}
												if($Opttraspasarexcedente=="1"){
													$traspasosRecibidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_emisor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_receptor = $veridPed");
													foreach ($traspasosRecibidos as $traspas){ if(!empty($traspas['id_traspaso'])){ $totalTraspasoRecibido += $traspas['cantidad_traspaso']; } }

													$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $veridPed");
													foreach ($traspasosEmitidos as $traspas){ if(!empty($traspas['id_traspaso'])){ $totalTraspasoEmitidos += $traspas['cantidad_traspaso']; } }
												}
												$bonosContado1 = $lider->consultarQuery("SELECT * FROm bonoscontado WHERE id_pedido = $veridPed");
										 		if(count($bonosContado1)>1){
										 			foreach ($bonosContado1 as $bono){ if(!empty($bono['totales_bono'])){ $bonoContado1Puntual += $bono['totales_bono']; } }
										 		}

												$bonosPagos = $lider->consultarQuery("SELECT * FROM bonospagos WHERE id_pedido = $veridPed");
												if(count($bonosPagos)>1){
										 			foreach ($bonosPagos as $bono){ if(!empty($bono['totales_bono'])){ $bonoPagosPuntuales += $bono['totales_bono']; } }
										 		}
										 		$bonosCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $veridPed");
										 		if(count($bonosCierreEstructura)>1){
										 			foreach ($bonosCierreEstructura as $bono){ if(!empty($bono['totales_bono_cierre'])){ $bonoAcumuladoCierreEstructura += $bono['totales_bono_cierre']; } }
										 		}
										 		$gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$_SESSION['id_cliente']}");
										 		if(count($gemas_liquidadas)>1){
										 			foreach ($gemas_liquidadas as $liquidadas){ if(!empty($liquidadas['total_descuento_gemas'])){ $liquidacion_gemas += $liquidadas['total_descuento_gemas']; } }
										 		}

										 		$sumatoria_cantidad_total_real = 0;
												$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$verIdCamp} and id_cliente = {$_SESSION['id_cliente']}");
												foreach ($pedidosAcumulados as $keyss) {
													if(!empty($keyss['cantidad_total_alcanzada'])){
														$sumatoria_cantidad_total_real += $keyss['cantidad_total_alcanzada'];
													}
												}
												if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
													$total = $verPedido['cantidad_total'];
													// $total = $sumatoria_cantidad_total;
													$total = $sumatoria_cantidad_total_real;
												}
												if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
													$total = $verPedido['cantidad_aprobado'];
													$total = $sumatoria_cantidad_aprobado;
												}
												$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = {$verIdCamp} and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$verIdDesp}");
												$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $verIdCamp and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$verIdDesp}");
												if(count($liderazgos)>1){
													$lidera = $liderazgos[0];
													foreach ($liderazgosAll as $data){ if(!empty($data['id_liderazgo'])){
														if ($lidera['id_liderazgo'] >= $data['id_liderazgo']){
															$resultNLider = $data['descuento_coleccion']*$verPedido['cantidad_aprobado'];
															$resulttDescuentoNivelLider += $resultNLider;
														}
													} }
												}
												$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$verIdDesp} and pedidos.id_cliente = {$_SESSION['id_cliente']} and planes_campana.id_despacho = {$verIdDesp}");
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
												$descuentosTotales = $resulttDescuentoNivelLider + $resulttDescuentoDirecto + $bonoContado1Puntual + $bonoPagosPuntuales + $totalTraspasoRecibido + $bonoAcumuladoCierreEstructura + $liquidacion_gemas;
												$nuevoTotal = $deudaTotal-$descuentosTotales + $totalTraspasoEmitidos;

												$porcentajeAbonadoPuntual = ($abonado_lider_gemas*100)/$nuevoTotal;
												// echo "<br>".$porcentajeAbonadoPuntual."<br>";
												if($porcentajeAbonadoPuntual>=100){
													$porcentajeAbonadoPuntual = 100.01;
												}

												$coleccionesPuntuales = ($verCantidadAprobado/100)*$porcentajeAbonadoPuntual;
												$porcentajeAbonadoPuntualRed = number_format($porcentajeAbonadoPuntual,2,',','.');
												$coleccionesPuntualesRed = intval($coleccionesPuntuales);
												$coleccionesPuntualesRed = number_format($coleccionesPuntuales,0,',','.');
												// ============================== // ================================== // ============================== //
												$pagosAbonados = $lider->consultarQuery("SELECT *, SUM(equivalente_pago) as abonado_total FROM pagos WHERE pagos.id_pedido={$veridPed} and pagos.estado='Abonado' and estatus=1");
												$abonadoTotal=0;
												foreach ($pagosAbonados as $key) {
													if(!empty($key['id_pago'])){
														$abonadoTotal+=$key['abonado_total'];
													}
												}
											// ======================================= // ======================================== // =================================== //
											$restoFactura += $nuevoTotal-$abonadoTotal;
											$countG++;
											// echo "Factura: ".$nuevoTotal."<br>";
											// echo "Abonado: ".$abonadoTotal."<br>";
											// echo "RESTA: ".$restoFactura."<br>";
										
										}

									}
								}
							}
							if($restoFactura<=0){
								$restoFactura = 0;
							}
							$infoCamp['restoGeneral']+=$restoFactura;
							$infoCamp[$countG]['info'] = "Campaña ".$verCamp['numero_campana']."/".$verCamp['anio_campana'];
							$infoCamp[$countG]['restoFactura']=$restoFactura;

						} }
					}
				}
			}
			// foreach ($infoCamp as $info) {
			// 	print_r($info);
			// 	echo "<br>";
			// }
			// echo "El monto pendiente en la ".$infoCamp." es $".number_format($restoFactura,2,',','.');

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
	}else{
		require_once 'public/views/error404.php';
	}
}


?>