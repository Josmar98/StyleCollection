<?php 
if(strtolower($url)=="estados"){
	$id_ciclo = $_GET['c'];
	$num_ciclo = $_GET['n'];
	$ano_ciclo = $_GET['y'];
	$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
	if(!empty($action)){
		$accesoEstadosR = false;
		$accesoEstadosC = false;
		$accesoEstadosM = false;
		$accesoEstadosE = false;
		$accesoExcedentes = false;
		$accesoExcedentesR = false;
		$accesoExcedentesC = false;
		$accesoExcedentesM = false;
		$accesoExcedentesE = false;
		// $accesoAprobarPedidos = false;
		// $accesoAprobarPedidosR = false;
		// $accesoAprobarPedidosC = false;
		// $accesoAprobarPedidosM = false;
		// $accesoAprobarPedidosE = false;
		foreach ($_SESSION['home']['accesos'] as $acc) {
			if(!empty($acc['id_rol'])){
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("estados")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoEstadosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoEstadosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoEstadosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoEstadosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("excedentes")){
					$accesoExcedentes = true;
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoExcedentesR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoExcedentesC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoExcedentesM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoExcedentesE=true; }
				}
				// if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("aprobar pedidos")){
				// 	$accesoAprobarPedidos = true;
				// 	if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoAprobarPedidosR=true; }
				// 	if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoAprobarPedidosC=true; }
				// 	if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoAprobarPedidosM=true; }
				// 	if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoAprobarPedidosE=true; }
				// }
			}
		}
		
		// MANEJO DE PEDIDOS
			if(!empty($_GET['admin']) && !empty($_GET['lider'])){
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['home']['id_cliente'];
			}
			$addUrlAdmin = "";
			if(!empty($_GET['admin'])){
				$addUrlAdmin .= "&admin=1";
			}
			if(!empty($_GET['lider'])){
				$addUrlAdmin .= "&lider=".$_GET['lider'];
			}
			$cantidadCarrito = 0;
			$classHidden="";
			$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and carrito.estatus = 1");
			if($buscar['ejecucion']==true){
				$cantidadCarrito = count($buscar)-1;
			}
			if($cantidadCarrito==0){
				$classHidden="d-none";
			}
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente=usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1");
		// MANEJO DE PEDIDOS

		$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo = {$id_ciclo}");
		$ciclo = $ciclos[0];
		$pagosCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
		$cuotaFinal = [];
		$index = 1;
		foreach ($pagosCiclos as $pc){ if(!empty($pc['id_pago_ciclo'])){ if($index==$ciclo['cantidad_cuotas']){ $cuotaFinal = $pc; } $index++; } }
		//$ciclo['cierre_seleccion']=$fechaActual; // // /// // /// / // / 
		
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
		if($action=="Consultar"){
			if($accesoEstadosC){
				$existencias = $lider->consultarQuery("SELECT * FROM inventarios, existencias WHERE inventarios.cod_inventario=existencias.cod_inventario and inventarios.estatus=1 and existencias.estatus=1");

				if(!empty($_POST)){
					if(!empty($_POST['cerrarExcedenteLider']) && !empty($_POST['cantidad_excedente']) ){
						$id_pedido = $_GET['id'];
						$cantidad = $_POST['cantidad_excedente'];
						$descripcion = ucwords(mb_strtolower($_POST['descripcion_excedente']));
						$query = "INSERT INTO excedentes (id_excedente, id_pedido, cantidad_excedente, descripcion_excedente, estatus) VALUES (DEFAULT, {$id_pedido}, '{$cantidad}', '{$descripcion}', 1)";
						$res1 = $lider->registrar($query,"excedentes", "id_excedente");
						if($res1['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2"; // echo 'Error en la conexion con la bd';
						}
						echo $response;
					}

				}
				if(empty($_POST)){
					$pedidos = $lider->consultarQuery("SELECT * FROM usuarios, clientes, pedidos WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente=pedidos.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 and pedidos.estatus=1 and pedidos.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$id}");
					if(empty($_POST) && (!empty($_GET['reclamar']) && $_GET['reclamar'] == "PorcentPuntos" ) && !empty($_GET['puntos']) && !empty($_GET['porcentaje'])){
						$pedido = $pedidos[0];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$id}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas']=$pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
						$id_punto = $_GET['puntos'];
						$porcentaje = number_format($_GET['porcentaje'],2);
						$puntos = $lider->consultarQuery("SELECT * FROM puntos WHERE id_punto = {$id_punto}");
						$punto = $puntos[0];
						$inactivas = $punto['cantidad_puntos'] - $porcentaje;
						$activas = $porcentaje;

						$precioFacturaTotal = $pedido['cantidad_aprobada'];
						$cantidad_puntos = $punto['cantidad_puntos'];
						$inactivasCalc = $cantidad_puntos - $porcentaje;
						$activasCalc = $porcentaje;
						$cantidad_puntos = (float) number_format($cantidad_puntos,2);
						$inactivasCalc = (float) number_format($inactivasCalc,2);
						$activasCalc = (float) number_format($activasCalc,2);
						// echo " | ".$inactivas." | ".$activas." | ";
						// echo $porcentaje."<br>";
						// echo "<br><br>";
						// echo "Cantidad Total Puntos: ".$punto['cantidad_puntos']." <br>";
						// echo "FACTURA APROBADAS: ".$pedido['cantidad_aprobada']." <br>";
						// echo "Precio Factura: ".$precioFacturaTotal." <br>";
						// echo "Cantidad PUNTOS: ".$cantidad_puntos." <br>";
						// echo "Porcentaje Calculado: ".$porcentaje."<br>";
						// echo "INACTIVAS Calculado: ".$inactivasCalc."<br>";
						// echo "ACTIVAS Calculado: ".$activasCalc."<br>";
						// echo "<br><br>";


						$query = "UPDATE puntos SET cantidad_puntos={$cantidad_puntos}, puntos_disponibles = {$activasCalc}, puntos_bloqueados = {$inactivasCalc}, estado_puntos = 1, fecha_puntos='{$fechaActual}', hora_puntos='{$horaActual}' WHERE id_punto = {$id_punto}";
						// echo $query;
						$res1 = $lider->modificar($query);
						if($res1['ejecucion']==true){
							$responsePts = "1";
						}else{
							$responsePts = "2"; // echo 'Error en la conexion con la bd';
						}
						// die();
					}
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if(($addUrlAdmin!="" && $accesoEstadosE) || $addUrlAdmin==""){
							$query = "UPDATE carrito SET estatus = 0 WHERE id_carrito = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "11";
							}else{
								$response = "22"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					
					if(Count($pedidos)>1){
						$pedido = $pedidos[0];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$id}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas']=$pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}


						$_SESSION['home']['id_ciclo'] = $id_ciclo;
						$_SESSION['home']['ids_general_estructuraID'] = [];
						$totalFactura = obtenerTotalFacturaEstructura($lider, $pedido['id_cliente']);
						// $totalFactura=$totalFactura*5;
						$pedido['cantidad_facturaTotal'] = $pedido['cantidad_aprobada']+$totalFactura;

						$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} ORDER BY liderazgos_ciclos.id_lc ASC");
						$nivelLider = [];
						$nivelLider['color_liderazgo']="#FFFFFF";
						if($pedido['cantidad_facturaTotal']>=$ciclo['precio_minimo']){
							$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and {$pedido['cantidad_facturaTotal']} >= liderazgos_ciclos.precio_minimo ORDER BY liderazgos_ciclos.id_lc DESC");

						}else{
							$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} ORDER BY liderazgos_ciclos.id_lc ASC");
						}

						if(count($liderazgos)>1){
							$nivelLider = $liderazgos[0];
						}
						//  ---- CHEQUEO DE PUNTOS -----  
							$puntosDisponiblesCliente = 0;
							$puntosBloqueadosCliente = 0;
							$puntoscanjeadosCliente=0;
							$puntos = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_cliente = {$pedido['id_cliente']} and puntos.estatus=1");
							foreach ($puntos as $point) { if(!empty($point['id_punto'])){
								if($point['estado_puntos']==1){
									$puntosDisponiblesCliente += $point['puntos_disponibles'];
								}
								if($point['estado_puntos']==0){
									$puntosBloqueadosCliente += $point['puntos_bloqueados'];
								}
							} }



							$puntssPerso = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_cliente = {$pedido['id_cliente']} and puntos.estatus=1 and puntos.concepto='1'");
							$puntosBloqueadoParaDesbloquearID = 0;
							foreach ($puntssPerso as $ptssPerson){ if(!empty($ptssPerson['id_punto'])){
								$tid_ciclo = $ptssPerson['id_ciclo'];
								$tid_pedido = $ptssPerson['id_pedido'];
								if($ptssPerson['estado_puntos']==0){
									$puntosBloqueadosCliente -= $ptssPerson['puntos_bloqueados'];
									$pointsPerso = 0;
									$tciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.id_ciclo={$tid_ciclo} and ciclos.estatus=1");
									$tciclos = $tciclos[0];
									$pointsPerso += $ptssPerson['puntos_bloqueados']/$tciclos['cantidad_cuotas'];
									$nPointsPerso = 0;
									$tpedidos = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_aprobada*inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and inventarios.estatus=1 and pedidos.id_pedido={$tid_pedido} and pedidos.estatus=1");
									$tpedidos = $tpedidos[0];
									$tcantidad_aprobada = $tpedidos['cantidad_aprobada'];
									$cuotaPagarPerso = $tpedidos['cantidad_aprobada']/$tciclos['cantidad_cuotas'];
									$cuotaAlcanzarPerso = 0;
									$tpagosCiclosPerson = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE pagos_ciclo.id_ciclo={$tid_ciclo} and pagos_ciclo.estatus=1");
									foreach ($tpagosCiclosPerson as $pc){ if(!empty($pc['id_pago_ciclo'])){
										if($fechaActual>= $pc['fecha_pago_cuota']){
											$cuotaAlcanzarPerso += $cuotaPagarPerso;
											$pagosCuotasPerso = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus=1 and pagos.id_pedido={$tid_pedido} and fecha_pago <= '{$pc['fecha_pago_cuota']}'");
											$cuotaAbonadaPerso = 0;
											foreach ($pagosCuotasPerso as $abCuota){ if(!empty($abCuota['id_pago'])){
												if($abCuota['estado']=='Abonado'){
													$cuotaAbonadaPerso += $abCuota['equivalente_pago'];
												}
											} }
											if($cuotaAbonadaPerso >= $cuotaAlcanzarPerso){
												$nPointsPerso += $pointsPerso;
											}
										}
									} }
									if($tid_pedido==$_GET['id']){
										$puntosBloqueadoParaDesbloquearID = $nPointsPerso;
									}
									$puntosBloqueadosCliente+=$nPointsPerso;
								}
							} }



							$canjeos = $lider->consultarQuery("SELECT * FROM canjeos, inventarios WHERE canjeos.cod_inventario=inventarios.cod_inventario and canjeos.id_cliente = {$pedido['id_cliente']} and canjeos.estatus=1");
							foreach ($canjeos as $canje) { if(!empty($canje['id_canjeo'])){
								$puntoscanjeadosCliente += $canje['puntos_inventario'];
							} }
							$puntosDisponiblesCliente -= $puntoscanjeadosCliente; 

							$puntosReclamarTotal = 0;
							$puntosReclamarDisp = 0;
							$puntosReclamarBloq = 0;
							$puntosReclamarID = 0;

							$puntosReclamar = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_cliente = {$pedido['id_cliente']} and puntos.id_pedido={$id} and puntos.concepto='1' and puntos.estatus = 1");
							foreach($puntosReclamar as $ptr){ if(!empty($ptr['id_punto'])){
								$puntosReclamarID += $ptr['id_punto'];
								$puntosReclamarTotal += $ptr['cantidad_puntos'];
								if($ptr['estado_puntos']==1){
									$puntosReclamarDisp += $ptr['puntos_disponibles'];
								}
								if($ptr['estado_puntos']==0){
									$puntosReclamarBloq += $ptr['puntos_bloqueados'];
								}
							} }
						//  ---- CHEQUEO DE PUNTOS -----  

						$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
						$pagos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");

						$reportado = 0;
						$diferido = 0;
						$abonado = 0;
						$abonadoPuntual = 0;
						if(count($pagos)){
							foreach ($pagos as $data){ if(!empty($data['id_pago'])){
								if(!empty($_GET['Diferido'])){
									if($data['estado']=="Diferido"){
										$pagosAux[$nnIndexAux] = $data;
										$nnIndexAux++;
									}
								}
								if(!empty($_GET['Abonado'])){
									if($data['estado']=="Abonado"){
										$pagosAux[$nnIndexAux] = $data;
										$nnIndexAux++;
									}
								}
								if($data['estado']=="Diferido"){
									$diferido += $data['equivalente_pago'];
									$reportado += $data['equivalente_pago'];
								}else if($data['estado']=="Abonado"){
									if($data['fecha_pago'] <= $cuotaFinal['fecha_pago_cuota']){
										$abonadoPuntual += $data['equivalente_pago'];
									}
									$abonado += $data['equivalente_pago'];
									$reportado += $data['equivalente_pago'];
								}else{
									$reportado += $data['equivalente_pago'];
								}
							} }
						}
						$excedentesPagados = 0;
						$excedentes = $lider->consultarQuery("SELECT * FROM excedentes WHERE excedentes.estatus = 1 and excedentes.id_pedido={$id}");
						foreach ($excedentes as $exced){ if(!empty($exced['id_excedente'])){
							$excedentesPagados += $exced['cantidad_excedente'];
						} }
						$notaExistente = 0;
						$notaExist = $lider->consultarQuery("SELECT * FROM notas,pedidos WHERE notas.id_pedido = pedidos.id_pedido and notas.id_ciclo={$id_ciclo} and pedidos.id_ciclo={$id_ciclo} and pedidos.id_pedido={$id} and notas.estatus=1 and pedidos.estatus=1");
						if(count($notaExist)>1){
							$notaExistente = 1;
						}else{
							$notaExistente = 0;
						}
						if(!empty($action)){
							if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
								require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
							}else{
								require_once 'public/views/error404.php';
							}
						}else{
							require_once 'public/views/error404.php';
						}
					}else{
						require_once 'public/views/error404.php';
					}
				}
			}else{
				require_once 'public/views/error404.php';
			}
		}
	}
}
function consultarEstructura($id_c, $lider){
	$id_ciclo = $_SESSION['home']['id_ciclo'];
	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c and clientes.estatus = 1");
	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				$pedidos = $lider->consultarQuery("SELECT pedidos.id_pedido, SUM(pedidos_inventarios.cantidad_aprobada*inventarios.precio_inventario) as totalFactura FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_cliente = {$lid['id_cliente']} and pedidos.id_ciclo={$id_ciclo}");
				if(count($pedidos)>1){
					$lid2 = $pedidos[0];
					$lid2['cantidad_acumulada'] = $lid2['totalFactura'];
					$_SESSION['home']['ids_general_estructuraID'][] = $lid2;
				}
				consultarEstructura($lid['id_cliente'], $lider);
			}
		}
	}
}
function obtenerTotalFacturaEstructura($lider, $id){
	consultarEstructura($id, $lider);
	$totalFactura = 0;
	foreach ($_SESSION['home']['ids_general_estructuraID'] as $keys) {
		// print_r($keys);
		// echo "<hr>";
		$totalFactura += $keys['cantidad_acumulada'];
	}
	return $totalFactura;
}

?>