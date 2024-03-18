<?php
		if(!empty($_GET['liderTraspaso'])){
			$liderEmisor = $lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and clientes.id_cliente = pedidos.id_cliente and despachos.id_campana = $id_campana and pedidos.id_pedido = {$_GET['liderTraspaso']}");
			$liderEmisor = $liderEmisor[0];
			$traspasoEmitido = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id and pedidos.id_pedido = {$_GET['liderTraspaso']}");
		}
		$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes, despachos WHERE pedidos.id_despacho = despachos.id_despacho and traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id");
		$traspasosRecibidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes, despachos WHERE pedidos.id_despacho = despachos.id_despacho and traspasos.id_pedido_emisor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_receptor = $id");
		$clientesAll = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho");
		$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");

		$bonosPagos = $lider->consultarQuery("SELECT * FROM bonospagos WHERE id_pedido = $id");

		// $bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	// $bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Segundo Pago' and id_pedido = $id");
	 	// print_r($bonosCierre);

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");
		$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
	 	$id_cliente = $id_cliente[0]['id_cliente'];

	 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = $id and id_cliente = {$id_cliente}");
	 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");

		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";

		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");

			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$cierresEstructura = 0;
					$pedido = $pedidos[0];

					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and planes_campana.id_despacho = {$id_despacho} and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");
						$pagos_planes_campana=$lider->consultarQuery("SELECT * FROM planes_campana, pagos_planes_campana WHERE planes_campana.id_plan_campana = pagos_planes_campana.id_plan_campana and planes_campana.id_campana = pagos_planes_campana.id_campana and planes_campana.id_despacho = pagos_planes_campana.id_despacho and pagos_planes_campana.id_campana = {$id_campana} and pagos_planes_campana.id_despacho = {$id_despacho} and planes_campana.estatus = 1 and pagos_planes_campana.estatus = 1");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query); 
						// echo "<br>".$id_cliente."<br>";
						// echo "<br>".$id_campana."<br>";
						// echo "<br>".$id_despacho."<br>";


						// $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

						$sumatoria_cantidad_aprobado = 0;
						$sumatoria_cantidad_total = 0;
						// foreach ($pedidosAcumulados as $keyss) {
						// 	if(!empty($keyss['cantidad_aprobado'])){
						// 		if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
						// 			$total = $pedido['cantidad_total'];
						// 			$sumatoria_cantidad_total += $keyss['cantidad_total'];
						// 		}
						// 		if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
						// 			$total = $pedido['cantidad_aprobado'];
						// 			$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
						// 		}
						// 	}
						// }

						$sumatoria_cantidad_total_real = 0;
						// $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
						// foreach ($pedidosAcumulados as $keyss) {
						// 	if(!empty($keyss['cantidad_total_alcanzada'])){
						// 		$sumatoria_cantidad_total_real += $keyss['cantidad_total_alcanzada'];
						// 	}
						// }
						#============================================================#
						$cantidad = $pedido['cantidad_aprobado'];
						$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
						$cantidadClientesBajos = Count($clientesBajas)-1;
						$cantidad_total = 0;
						$cantidad_total_alcanzada = 0;
						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
						$cantidad_acumulada = 0;
						foreach ($pedidosAcumulados as $keyss) {
							if(!empty($keyss['id_pedido'])){
								$cantidad_acumulada += $keyss['cantidad_aprobado'];
							}
						}
						if($cantidadClientesBajos > 0){
							$tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
							// $cantidad_total = $tot;
							$cantidad_total = $cantidad+$tot;

							$totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
							$cantidad_total_alcanzada = $cantidad_acumulada+$totAlcanzadas;
						}else{
							$cantidad_total = $cantidad;
							$cantidad_total_alcanzada = $cantidad_acumulada;
						}
						$sumatoria_cantidad_total_real = $cantidad_total_alcanzada;
						#============================================================#
						
						if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
							$total = $pedido['cantidad_total'];
							$total = $sumatoria_cantidad_total;
							$total = $sumatoria_cantidad_total_real;
						}
						if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
							$total = $pedido['cantidad_aprobado'];
							$total = $sumatoria_cantidad_aprobado;
						}


						
						// print_r($cantidad_total_alcanzada);

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$maxima = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_despacho = {$id_despacho} ORDER BY liderazgos_campana.minima_cantidad DESC;");
						if(count($maxima)>1){
							$maxmax = $maxima[0];
							if($maxmax['minima_cantidad'] <= $total){
								$id_liderazgoTemp = $maxmax['id_liderazgo'];
								$minima_cantidadTemp = $maxmax['minima_cantidad'];
								$maxima_cantidadTemp = $maxmax['minima_cantidad']*10;
								$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos.id_liderazgo = {$id_liderazgoTemp} and $total > minima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
							}else{

								$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
							}
						}

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");
						// print_r($clientesPedidos);
						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];
							// print_r($lidera);
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
			                // $cantidad_total = $cantidad_total_alcanzada;
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}

					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						
						####
						// $liderEstruct = explode("-", $id_liderEstruct);
						// $id_liderEstruct = $liderEstruct[0];
						####
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
					}

					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;


					$lideres = $lider->consultar("clientes");
					$despachosDisponiblesAcutales = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = {$id_campana}");
					$countDespachos = 0;
					foreach ($despachosDisponiblesAcutales as $key) {
						if(!empty($key['id_despacho'])){
							$countDespachos++;
						}
					}
					$pedidosDisponiblesLider = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");
					$countPedidos = 0;
					foreach ($pedidosDisponiblesLider as $key) {
						if(!empty($key['id_pedido'])){
							$countPedidos++;
						}
					}

					$_SESSION['ids_general_estructura'] = [];
					$_SESSION['id_campana'] = $id_campana;
					$_SESSION['id_despacho'] = $id_despacho;

					// echo "Despachos: ".$countDespachos."<br>";
					// echo "Pedidos: ".$countPedidos."<br>";
					if($countDespachos==$countPedidos){
						// echo "Mismo Despachos. Mismos Pedidos<br><br>";
						consultarEstructura($id_cliente, $lider);
					}
					if($countDespachos!=$countPedidos){
						if($countPedidos==1){
							// echo "Diferentes Despachos. Un Pedido<br><br>";
							consultarEstructuraAc($id_cliente, $lider);
						}
						if($countPedidos>1){
						}
					}
					$estructuraLideres = $_SESSION['ids_general_estructura'];
					$number = 1;

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


					$fechaPagoLimiteFinal = "";
					// foreach ($cantidadPagosDespachosFild as $key) {
					// 	if($key['cantidad']==$despacho['cantidad_pagos']){
					// 		foreach ($pagosRecorridos as $pagosR){ 
					// 			if($pagosR['name']==$key['name']){
					// 				$fechaPagoLimiteFinal = $pagosR['fecha_pago'];
					// 			}
					// 		}
					// 	}
					// }
		
					// // $despacho['fecha_segunda_senior'] = '2022-04-26';
					// $pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id} and estado = 'Abonado' and fecha_pago <= '{$fechaPagoLimiteFinal}' ORDER BY fecha_pago DESC");
					// $num = 0;
					// $abonado_lider_gemas = 0;
					// $fecha_pago_cierre_lider = "";
					// if(count($pagosGemas)>1){
					// 	foreach ($pagosGemas as $key) {
					// 		if(!empty($key['fecha_pago'])){
					// 			$abonado_lider_gemas += $key['equivalente_pago']; 
					// 		}
					// 	}
					// 	$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
					// }
					// echo "Abonado POR EL LIDER: ".$abonado_lider_gemas."<br>";  // 3210
					// echo "FECHA DE ULTIMO PAGO Abonado PUNTUAL POR EL LIDER: ".$fecha_pago_cierre_lider."<br>"; // 2023-03-07
					// echo "<br><br>";
					$fechaPagoLimiteFinal = $pagosRecorridos[count($pagosRecorridos)-1]['fecha_pago'];
					$abonado_lider_gemas = 0;
					$fecha_pago_cierre_lider = "";
					// print_r($pagosRecorridos);
					foreach ($pagosRecorridos as $pagosR) {
						if(!empty($pagosR['fecha_pago'])){
							$fechaPagoConceptoAct = $pagosR['fecha_pago'];
						}
						// $conceptoPagoConceptoAct = $pagosR['name'];
						// $pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id} and estado = 'Abonado' and tipo_pago = '{$conceptoPagoConceptoAct}' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
						// if(count($pagosGemas)>1){
						// 	$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
						// 	foreach ($pagosGemas as $key) {
						// 		if(!empty($key['fecha_pago'])){
						// 			$abonado_lider_gemas += $key['equivalente_pago']; 
						// 		}
						// 	}
						// }
						// echo $pagosR['name']." ".$pagosR['fecha_pago']."<br>";
						// print_r($pagosGemas);
						// echo "<br><br>";
						// echo "<br><br>";
					}
					$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id} and estado = 'Abonado' and fecha_pago <= '{$fechaPagoConceptoAct}' ORDER BY fecha_pago DESC");
					if(count($pagosGemas)>1){
						$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
						foreach ($pagosGemas as $key) {
							if(!empty($key['fecha_pago'])){
								$abonado_lider_gemas += $key['equivalente_pago']; 
							}
						}
					}
					// echo "Abonado POR EL LIDER: ".$abonado_lider_gemas."<br>";  // 3210
					// echo "FECHA DE ULTIMO PAGO Abonado PUNTUAL POR EL LIDER: ".$fecha_pago_cierre_lider."<br>"; // 2023-03-07
					$distribucionDescuentos = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE distribucion_pagos.estatus = 1 and distribucion_pagos.id_pedido = {$id}");
					$totalDistribucionDescuentos = 0;
					foreach ($distribucionDescuentos as $distri) {
						if(!empty($distri['id_distribucion_pagos'])){
							$totalDistribucionDescuentos += $distri['cantidad_distribucion'];
						}
					}
					
					$gemasReclamar = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_campana = {$id_campana} and gemas.id_pedido = {$id} and gemas.id_cliente = {$pedido['id_cliente']} and gemas.estado = 'Bloqueado' and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa'");

					$promocionesFull = $lider->consultarQuery("SELECT * FROM clientes, pedidos, promocion, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1 and promociones.id_cliente = {$id_cliente} and promociones.id_pedido = {$id}");

					//print_r($promocionesFull);
                    $resultDeudaPorPromociones = 0;

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
		}else{
		    require_once 'public/views/error404.php';
		}

?>