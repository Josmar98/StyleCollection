<?php 
if(strtolower($url)=="pagos"){
	$id_ciclo = $_GET['c'];
	$num_ciclo = $_GET['n'];
	$ano_ciclo = $_GET['y'];
	$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
	if(!empty($action)){
		$accesoPagosR = false;
		$accesoPagosC = false;
		$accesoPagosM = false;
		$accesoPagosE = false;
		$accesoPagosAutorizadosR = false;
		$accesoPagosAutorizadosC = false;
		$accesoPagosAutorizadosM = false;
		$accesoPagosAutorizadosE = false;
		$accesoPagosAdminR = false;
		$accesoPagosAdminC = false;
		$accesoPagosAdminM = false;
		$accesoPagosAdminE = false;
		$accesoPagosDetallesR = false;
		$accesoPagosDetallesC = false;
		$accesoPagosDetallesM = false;
		$accesoPagosDetallesE = false;
		$accesoPagosConciliarR = false;
		$accesoPagosConciliarC = false;
		$accesoPagosConciliarM = false;
		$accesoPagosConciliarE = false;
		foreach ($_SESSION['home']['accesos'] as $acc) {
			if(!empty($acc['id_rol'])){
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos Autorizados")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosAutorizadosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosAutorizadosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosAutorizadosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosAutorizadosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos Admin")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosAdminR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosAdminC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosAdminM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosAdminE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos Detalles")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosDetallesR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosDetallesC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosDetallesM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosDetallesE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos Conciliar")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosConciliarR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosConciliarC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosConciliarM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosConciliarE=true; }
				}
			}
		}
		// MANEJO DE PEDIDOS
			if(!empty($_GET['admin']) && !empty($_GET['lider'])){
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['home']['id_cliente'];
			}
			$addUrlAdmin = "";
			if(!empty($_GET['op']) && $_GET['op']=="Editar"){
				$addUrlAdmin .= "&op=".$_GET['op'];
			}
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
		$formasPago = [
			0=>['id'=>0, 'name'=>'Transferencia Banco a Banco', 'type'=>'banco'],
			1=>['id'=>1, 'name'=>'Transferencia de Otros Bancos', 'type'=>'banco'],
			2=>['id'=>2, 'name'=>'Pago Movil Banco a Banco', 'type'=>'banco'],
			3=>['id'=>3, 'name'=>'Pago Movil de Otros Bancos', 'type'=>'banco'],
			4=>['id'=>4, 'name'=>'Deposito En Dolares', 'type'=>'banco'],

			5=>['id'=>5, 'name'=>'Divisas Dolares', 'type'=>'fisico'],
			6=>['id'=>6, 'name'=>'Efectivo Bolivares', 'type'=>'fisico'],
			// 5=>['id'=>5, 'name'=>'Deposito En Bolivares', 'type'=>'banco'],
			// 6=>['id'=>6, 'name'=>'Divisas Dolares', 'type'=>'fisico'],
			// 7=>['id'=>7, 'name'=>'Divisas Euros', 'type'=>'fisico'],
			// 8=>['id'=>8, 'name'=>'Efectivo Bolivares', 'type'=>'fisico'],
		];
		
		$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo = $id_ciclo");
		$ciclo = $ciclos[0];
		// CONSULTA DE PAGOS
			$pagosT=['reportado'=>0, 'abonado'=>0, 'diferido'=>0];
			$pagosTReportado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
			$pagosT['reportado']+=$pagosTReportado[0][0];
			$pagosTAbonado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Abonado'");
			$pagosT['abonado']+=$pagosTAbonado[0][0];
			$pagosTDiferido = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Diferido'");
			$pagosT['diferido']+=$pagosTDiferido[0][0];
		// CONSULTA DE PAGOS
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
		
		if($action=="Filtrar"){
			if($accesoPagosC){
				if(!empty($_POST)){
					if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
						$id = $_POST['id_pago'];
						$pedido = $lider->consultarQuery("SELECT * FROm pagos, pedidos, clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago='{$id}'");
						$data = ['exec_pedido'=>true];
						$data += ['pedido'=>$pedido[0]];
						if($pedido[0]['id_banco']!=""){
							$id_banco = $pedido[0]['id_banco'];
							$data += ['exec_banco'=>true];
							$banco = $lid3r->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco} and estatus = 1");
							$data += ['banco' => $banco[0]];
						}else{
							$data += ['exec_banco'=>false];
						}

						echo json_encode($data);	
					}
					if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  isset($_POST['leyenda'])){
						$id_pago = $_POST['id_pago_modal'];
						$estado = $_POST['estado'];
						$firma = $_POST['firma'];
						if(!empty($_POST['newFirma'])){
							$firma = ucwords(mb_strtolower($_POST['newFirma']));
						}
						$leyenda = $_POST['leyenda'];
						$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', leyenda='{$leyenda}', estado='{$estado}' WHERE id_pago='{$id_pago}'");
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						echo $response;
					}
					if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['observacion'])){
						$id_pago = $_POST['id_pago_modal'];
						$estado = $_POST['estado'];
						$firma = $_POST['firma'];
						if(!empty($_POST['newFirma'])){
							$firma = ucwords(mb_strtolower($_POST['newFirma']));
						}
						$observacion = $_POST['observacion'];
						$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', observacion='{$observacion}', estado='{$estado}' WHERE id_pago='{$id_pago}'");
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						echo $response;
					}
				}
				if(empty($_POST)){
					$pagosCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
					$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

					$sqlPagos = "SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo}";

					$sqlMovimientos = "SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1";
					// $sqlPromociones = "SELECT * FROM pagos WHERE pagos.estatus = 1 and ";
					// $fechasPromociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE estatus = 1 and id_ciclo = {$id_ciclo}");
					// if(count($fechasPromociones)>1){
					// 	$fechasPromociones = $fechasPromociones[0];
					// }
					// $sqlPromociones = "SELECT * FROM promocion WHERE promocion.id_ciclo = {$id_ciclo} and promocion.estatus = 1";
					if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
						$id_cliente = $_GET['lider'];
						$sqlPagos .= " and pedidos.id_cliente = {$id_cliente}";
						// $sqlPromociones = "SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promocion.id_ciclo = {$id_campana} and promociones.id_ciclo = {$id_ciclo}";
						// $sqlPromociones .= " and promociones.id_cliente = {$id_cliente}";
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 and clientes.id_cliente = {$id_cliente}");
						$cliente = $clientes[0];
					}else{
						$id_cliente = $_SESSION['home']['id_cliente'];
					}
					if(!empty($_GET['Banco'])){
						$id_banco = $_GET['Banco'];
						$sqlPagos .= " and pagos.id_banco = {$id_banco}";
						$sqlMovimientos .= " and movimientos.id_banco = {$id_banco}";
					}
					if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
						$rangoI = $_GET['rangoI'];
						$rangoF = $_GET['rangoF'];
						$sqlPagos .= " and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF'";
						$sqlMovimientos .= " and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF'";
					}
					if(!empty($_GET['Abonado'])){
						$sqlPagos .= " and pagos.estado='Abonado'";
					}
					if(!empty($_GET['Diferido'])){
						$sqlPagos .= " and pagos.estado='Diferido'";
					}
					$sqlPagos .= " ORDER BY pagos.fecha_pago ASC;";
					$pagos = $lider->consultarQuery($sqlPagos);
					$movimientos = $lider->consultarQuery($sqlMovimientos);
					// $promociones = $lider->consultarQuery($sqlPromociones);

					$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1");

					$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and ciclos.id_ciclo = {$id_ciclo}");

					$resulttDescuentoNivelLider=0;
					$deudaTotal=0;
					$bonoContado1Puntual = 0;
					$bonoPagosPuntuales = 0;
					$bonoAcumuladoCierreEstructura = 0;
					$liquidacion_gemas = 0;
					$totalTraspasoRecibido=0;
					$totalTraspasoEmitidos=0;

					$resultDeudaPorPromociones = 0;
					if(Count($pedidos)>1){
						$pedido = $pedidos[0];
						$id_pedido = $pedido['id_pedido'];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
					}
					$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
					if($pagos['ejecucion']==1){
						$reportado = 0;
						$diferido = 0;
						$abonado = 0;
						$pagosAux = [];
						$nnIndexAux = 0;
						if(count($pagos)){
							foreach ($pagos as $data){ if(!empty($data['id_pago'])){
								$permitido = 0;
								if(!empty($accesosEstructuras)){
									foreach ($accesosEstructuras as $struct) {
										if(!empty($struct['id_cliente'])){
											if($struct['id_cliente']==$data['id_cliente']){
												$permitido = 1;
											}
										}
									}
								}
								if($personalInterno){
									$permitido = 1;
								}
								if($personalExterno){
									if($data['id_cliente']==$id_cliente){
										$permitido = 1;
									}
								}

								if($permitido==1){
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
										$abonado += $data['equivalente_pago'];
										$reportado += $data['equivalente_pago'];
									}else{
										$reportado += $data['equivalente_pago'];
									}
								}
							} }
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
		if($action=="Consultar"){
			if($accesoPagosC){
				if(!empty($_POST)){
					if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
						$num = number_format($_POST['val'],2,',','.');
						echo $num;
					}
					if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
						$id = $_POST['id_pago'];
						$pedido = $lider->consultarQuery("SELECT * FROM pagos, pedidos, clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago='{$id}'");
						$data = ['exec_pedido'=>true];
						$data += ['pedido'=>$pedido[0]];
						if($pedido[0]['id_banco']!=""){
							$id_banco = $pedido[0]['id_banco'];
							$data += ['exec_banco'=>true];
							$banco = $lid3r->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco} and estatus = 1");
							$data += ['banco' => $banco[0]];
						}else{
							$data += ['exec_banco'=>false];
						}
						echo json_encode($data);	
					}
					if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  isset($_POST['leyenda'])){
						$id_pago = $_POST['id_pago_modal'];
						$estado = $_POST['estado'];
						$firma = $_POST['firma'];
						if(!empty($_POST['newFirma'])){
							$firma = ucwords(mb_strtolower($_POST['newFirma']));
						}
						$leyenda = $_POST['leyenda'];
						$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', leyenda='{$leyenda}', estado='{$estado}' WHERE id_pago='{$id_pago}'");
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						echo $response;
					}
					if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['observacion'])){
						$id_pago = $_POST['id_pago_modal'];
						$estado = $_POST['estado'];
						$firma = $_POST['firma'];
						if(!empty($_POST['newFirma'])){
							$firma = ucwords(mb_strtolower($_POST['newFirma']));
						}
						$observacion = $_POST['observacion'];
						$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', observacion='{$observacion}', estado='{$estado}' WHERE id_pago='{$id_pago}'");
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						echo $response;
					}
					if(!empty($_POST['id_pago_modal']) && !empty($_POST['fecha_pago']) && !empty($_POST['rol']) && $_POST['rol']=="Analistas" && isset($_POST['tasa'])){
							$id_pedido_temp = $_POST['id_pedido_temp'];
							$id_pago = $_POST['id_pago_modal'];
							$tasa = $_POST['tasa'];
							$fecha = $_POST['fecha_pago'];
							$tasass = $lid3r->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '{$fecha}'");

							$pago = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago='$id_pago'");
							$pago=$pago[0];
							$equivalente_pago = "";
							if($tasa!=""){
								if($pago['forma_pago']=="Divisas Dolares" || $pago['forma_pago']=="Divisas Euros" || $pago['forma_pago']=="Deposito En Dolares"){
									if($pago['estado']=="Abonado"){
										$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago='' WHERE id_pago='$id_pago'");
									}else{
										if($fecha == $pago['fecha_pago']){
											$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago=null WHERE id_pago='$id_pago'");
										}else{
											$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago=null, estado = '' WHERE id_pago='$id_pago'");
										}
									}
								}else{
									if(count($tasass)>1){
										$tassa = $tasass[0]['monto_tasa'];
										if($tasa != $tassa){
											$tasa = $tassa;
										}
									}
									$equivalente_pago = $pago['monto_pago']/$tasa;
									$equivalente_pago = number_format($equivalente_pago,2);

									if($pago['estado']=="Abonado"){
										$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago='{$tasa}', equivalente_pago='{$equivalente_pago}' WHERE id_pago='$id_pago'");
									}else{
										if($fecha == $pago['fecha_pago']){
											$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago='{$tasa}', equivalente_pago='{$equivalente_pago}' WHERE id_pago='$id_pago'");
										}else{
											$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', tasa_pago='{$tasa}', equivalente_pago='{$equivalente_pago}', estado = '' WHERE id_pago='$id_pago'");
										}
									}
								}
							}else{
								if($pago['estado']=="Abonado"){
									$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}' WHERE id_pago='$id_pago'");
								}else{
									if($fecha == $pago['fecha_pago']){
										$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}' WHERE id_pago='$id_pago'");
									}else{
										$exec = $lider->modificar("UPDATE pagos SET id_pedido={$id_pedido_temp}, fecha_pago = '{$fecha}', estado = '' WHERE id_pago='$id_pago'");
									}
								}
							}

							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
							}
							// $paggo = $lid3r->consultarQuery("SELECT * FROM bancos, pagos WHERE pagos.id_pago='{$id_pago}'");
							// $despp = $lider->consultarQuery("SELECT * FROM despachos WHERE despachos.id_despacho = {$id_despacho}");
							$return['exec'] = $response;
							// if(count($despp)>1){
							// 	$return['despacho'] = $despp[0];
							// }
							// if(count($paggo)>1){
								// $return['pago'] = $paggo[0];
								// $return['pago']['fecha_pago_format'] = $lider->formatFecha($paggo[0]['fecha_pago']);
								// $return['pago']['tasa_pago_format'] = number_format($paggo[0]['tasa_pago'],4,',','.');
								// $return['pago']['monto_pago_format'] = number_format($paggo[0]['monto_pago'],2,',','.');
								// $return['pago']['equivalente_pago_format'] = number_format($paggo[0]['equivalente_pago'],2,',','.');
							// }
							echo json_encode($return);
						}
				}
				if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					if($accesoPagosE == 1){
						$pagos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, pagos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");
						if(count($pagos)>1){
							$pago = $pagos[0];
							$borrarDef = false;
							if($pago['id_banco']!=""){
								$borrarDef = true;
							}
							if($borrarDef){
								$querys = "UPDATE movimientos SET estado_movimiento='', id_pago='' WHERE movimientos.id_pago = '{$pago['id_pago']}'";
								$execDel = $lid3r->modificar($querys);
								if($execDel['ejecucion']==true){
									$responses = "1";
								}else{
									$responses = "2";
								}
							}else{
								$responses = "1";
							}
							if($responses=="1"){
								$query = "UPDATE pagos SET estatus = 0 WHERE id_pago = '{$id}'";
								$res1 = $lider->eliminar($query);
								if($res1['ejecucion']==true){
									$response = "1";
									$aux = "";
									if(!empty($_GET['filtrar'])){
										$aux .= "&filtrar=".$_GET['filtrar'];
									}
									if(!empty($_GET['admin'])){
										$aux .= "&admin=1";
									}
									if(!empty($_GET['lider'])){
										$aux .= "&lider=".$_GET['lider'];
									}
									if(!empty($_GET['rangoI'])){
										$aux .= "&rangoI=".$_GET['rangoI'];
									}
									if(!empty($_GET['rangoF'])){
										$aux .= "&rangoF=".$_GET['rangoF'];
									}
									if(!empty($_GET['Banco'])){
										$aux .= "&Banco=".$_GET['Banco'];
									}
									// if(!empty($modulo) && !empty($accion)){
									// 	$fecha = date('Y-m-d');
									// 	$hora = date('H:i:a');
									// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Borrar', '{$fecha}', '{$hora}')";
									// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
									// }
								}else{
									$response = "2"; // echo 'Error en la conexion con la bd';
								}
							}
							// die();
						}else{
							$response = "2";
						}
					}else{
						$response = "2";
					}
				}
				if(empty($_POST)){
					$pagosCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
					$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE ciclos.id_ciclo = pedidos.id_ciclo and clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

					$sqlPagos = "SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo}";

					$sqlMovimientos = "SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1";
					// $sqlPromociones = "SELECT * FROM pagos WHERE pagos.estatus = 1 and ";
					// $fechasPromociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE estatus = 1 and id_ciclo = {$id_ciclo}");
					// if(count($fechasPromociones)>1){
					// 	$fechasPromociones = $fechasPromociones[0];
					// }
					// $sqlPromociones = "SELECT * FROM promocion WHERE promocion.id_ciclo = {$id_ciclo} and promocion.estatus = 1";
					if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
						$id_cliente = $_GET['lider'];
						$sqlPagos .= " and pedidos.id_cliente = {$id_cliente}";
						// $sqlPromociones = "SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promocion.id_ciclo = {$id_campana} and promociones.id_ciclo = {$id_ciclo}";
						// $sqlPromociones .= " and promociones.id_cliente = {$id_cliente}";
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 and clientes.id_cliente = {$id_cliente}");
						$cliente = $clientes[0];
					}else{
						$id_cliente = $_SESSION['home']['id_cliente'];
					}
					if(!empty($_GET['filtrar'])){
						if($_GET['filtrar']=="Bancarios"){
							$sqlPagos .= " and pagos.id_banco IS NOT NULL";
						}
						if($_GET['filtrar']=="Bolivares"){
							$sqlPagos .= " and pagos.forma_pago = 'Efectivo Bolivares'";
						}
						if($_GET['filtrar']=="Divisas"){
							$sqlPagos .= " and (pagos.forma_pago = 'Divisas Dolares' or pagos.forma_pago = 'Divisas Euros')";
						}
					}
					if(!empty($_GET['Banco'])){
						$id_banco = $_GET['Banco'];
						$sqlPagos .= " and pagos.id_banco = {$id_banco}";
						$sqlMovimientos .= " and movimientos.id_banco = {$id_banco}";
					}
					if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
						$rangoI = $_GET['rangoI'];
						$rangoF = $_GET['rangoF'];
						$sqlPagos .= " and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF'";
						$sqlMovimientos .= " and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF'";
					}
					if(!empty($_GET['Abonado'])){
						$sqlPagos .= " and pagos.estado='Abonado'";
					}
					if(!empty($_GET['Diferido'])){
						$sqlPagos .= " and pagos.estado='Diferido'";
					}
					$sqlPagos .= " ORDER BY pagos.fecha_pago ASC;";
					$pagos = $lider->consultarQuery($sqlPagos);
					$movimientos = $lider->consultarQuery($sqlMovimientos);
					// $promociones = $lider->consultarQuery($sqlPromociones);

					$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1");

					$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and ciclos.id_ciclo = {$id_ciclo}");

					$resulttDescuentoNivelLider=0;
					$deudaTotal=0;
					$bonoContado1Puntual = 0;
					$bonoPagosPuntuales = 0;
					$bonoAcumuladoCierreEstructura = 0;
					$liquidacion_gemas = 0;
					$totalTraspasoRecibido=0;
					$totalTraspasoEmitidos=0;

					$resultDeudaPorPromociones = 0;
					if(Count($pedidos)>1){
						$pedido = $pedidos[0];
						$id_pedido = $pedido['id_pedido'];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
					}
					$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
					if($pagos['ejecucion']==1){
						$reportado = 0;
						$diferido = 0;
						$abonado = 0;
						$pagosAux = [];
						$nnIndexAux = 0;
						if(count($pagos)){
							foreach ($pagos as $data){ if(!empty($data['id_pago'])){
								$permitido = 0;
								if(!empty($accesosEstructuras)){
									foreach ($accesosEstructuras as $struct) {
										if(!empty($struct['id_cliente'])){
											if($struct['id_cliente']==$data['id_cliente']){
												$permitido = 1;
											}
										}
									}
								}
								if($personalInterno){
									$permitido = 1;
								}
								if($personalExterno){
									if($data['id_cliente']==$id_cliente){
										$permitido = 1;
									}
								}

								if($permitido==1){
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
										$abonado += $data['equivalente_pago'];
										$reportado += $data['equivalente_pago'];
									}else{
										$reportado += $data['equivalente_pago'];
									}
								}
							} }
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
		if($action=="Borrados"){
			if($accesoPagosC){
				// if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
				// 	if($accesoPagosE == 1){
				// 		$pagos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, pagos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");
				// 		if(count($pagos)>1){
				// 			$pago = $pagos[0];
				// 			$borrarDef = false;
				// 			if($pago['id_banco']!=""){
				// 				$borrarDef = true;
				// 			}
				// 			if($borrarDef){
				// 				$querys = "UPDATE movimientos SET estado_movimiento='', id_pago='' WHERE movimientos.id_pago = '{$pago['id_pago']}'";
				// 				$execDel = $lid3r->modificar($querys);
				// 				if($execDel['ejecucion']==true){
				// 					$responses = "1";
				// 				}else{
				// 					$responses = "2";
				// 				}
				// 			}else{
				// 				$responses = "1";
				// 			}
				// 			if($responses=="1"){
				// 				$query = "UPDATE pagos SET estatus = 0 WHERE id_pago = '{$id}'";
				// 				$res1 = $lider->eliminar($query);
				// 				if($res1['ejecucion']==true){
				// 					$response = "1";
				// 					$aux = "";
				// 					if(!empty($_GET['filtrar'])){
				// 						$aux .= "&filtrar=".$_GET['filtrar'];
				// 					}
				// 					if(!empty($_GET['admin'])){
				// 						$aux .= "&admin=1";
				// 					}
				// 					if(!empty($_GET['lider'])){
				// 						$aux .= "&lider=".$_GET['lider'];
				// 					}
				// 					if(!empty($_GET['rangoI'])){
				// 						$aux .= "&rangoI=".$_GET['rangoI'];
				// 					}
				// 					if(!empty($_GET['rangoF'])){
				// 						$aux .= "&rangoF=".$_GET['rangoF'];
				// 					}
				// 					if(!empty($_GET['Banco'])){
				// 						$aux .= "&Banco=".$_GET['Banco'];
				// 					}
				// 					// if(!empty($modulo) && !empty($accion)){
				// 					// 	$fecha = date('Y-m-d');
				// 					// 	$hora = date('H:i:a');
				// 					// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Borrar', '{$fecha}', '{$hora}')";
				// 					// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				// 					// }
				// 				}else{
				// 					$response = "2"; // echo 'Error en la conexion con la bd';
				// 				}
				// 			}
				// 			// die();
				// 		}else{
				// 			$response = "2";
				// 		}
				// 	}else{
				// 		$response = "2";
				// 	}
				// }
				if(empty($_POST)){
					$pagosCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
					$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE ciclos.id_ciclo = pedidos.id_ciclo and clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

					$sqlPagos = "SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 0 and ciclos.id_ciclo = {$id_ciclo}";

					$sqlMovimientos = "SELECT * FROM movimientos WHERE movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1";
					// $sqlPromociones = "SELECT * FROM pagos WHERE pagos.estatus = 1 and ";
					// $fechasPromociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE estatus = 1 and id_ciclo = {$id_ciclo}");
					// if(count($fechasPromociones)>1){
					// 	$fechasPromociones = $fechasPromociones[0];
					// }
					// $sqlPromociones = "SELECT * FROM promocion WHERE promocion.id_ciclo = {$id_ciclo} and promocion.estatus = 1";
					if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
						$id_cliente = $_GET['lider'];
						$sqlPagos .= " and pedidos.id_cliente = {$id_cliente}";
						// $sqlPromociones = "SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promocion.id_ciclo = {$id_campana} and promociones.id_ciclo = {$id_ciclo}";
						// $sqlPromociones .= " and promociones.id_cliente = {$id_cliente}";
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 and clientes.id_cliente = {$id_cliente}");
						$cliente = $clientes[0];
					}else{
						$id_cliente = $_SESSION['home']['id_cliente'];
					}
					if(!empty($_GET['filtrar'])){
						if($_GET['filtrar']=="Bancarios"){
							$sqlPagos .= " and pagos.id_banco IS NOT NULL";
						}
						if($_GET['filtrar']=="Bolivares"){
							$sqlPagos .= " and pagos.forma_pago = 'Efectivo Bolivares'";
						}
						if($_GET['filtrar']=="Divisas"){
							$sqlPagos .= " and (pagos.forma_pago = 'Divisas Dolares' or pagos.forma_pago = 'Divisas Euros')";
						}
					}
					if(!empty($_GET['Banco'])){
						$id_banco = $_GET['Banco'];
						$sqlPagos .= " and pagos.id_banco = {$id_banco}";
						$sqlMovimientos .= " and movimientos.id_banco = {$id_banco}";
					}
					if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
						$rangoI = $_GET['rangoI'];
						$rangoF = $_GET['rangoF'];
						$sqlPagos .= " and pagos.fecha_pago BETWEEN '$rangoI' and '$rangoF'";
						$sqlMovimientos .= " and movimientos.fecha_movimiento BETWEEN '$rangoI' and '$rangoF'";
					}
					if(!empty($_GET['Abonado'])){
						$sqlPagos .= " and pagos.estado='Abonado'";
					}
					if(!empty($_GET['Diferido'])){
						$sqlPagos .= " and pagos.estado='Diferido'";
					}
					$sqlPagos .= " ORDER BY pagos.fecha_pago ASC;";
					$pagos = $lider->consultarQuery($sqlPagos);
					$movimientos = $lider->consultarQuery($sqlMovimientos);
					// $promociones = $lider->consultarQuery($sqlPromociones);

					$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1");

					$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and ciclos.id_ciclo = {$id_ciclo}");

					$resulttDescuentoNivelLider=0;
					$deudaTotal=0;
					$bonoContado1Puntual = 0;
					$bonoPagosPuntuales = 0;
					$bonoAcumuladoCierreEstructura = 0;
					$liquidacion_gemas = 0;
					$totalTraspasoRecibido=0;
					$totalTraspasoEmitidos=0;

					$resultDeudaPorPromociones = 0;
					if(Count($pedidos)>1){
						$pedido = $pedidos[0];
						$id_pedido = $pedido['id_pedido'];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
					}
					$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
					if($pagos['ejecucion']==1){
						$reportado = 0;
						$diferido = 0;
						$abonado = 0;
						$pagosAux = [];
						$nnIndexAux = 0;
						if(count($pagos)){
							foreach ($pagos as $data){ if(!empty($data['id_pago'])){
								$permitido = 0;
								if(!empty($accesosEstructuras)){
									foreach ($accesosEstructuras as $struct) {
										if(!empty($struct['id_cliente'])){
											if($struct['id_cliente']==$data['id_cliente']){
												$permitido = 1;
											}
										}
									}
								}
								if($personalInterno){
									$permitido = 1;
								}
								if($personalExterno){
									if($data['id_cliente']==$id_cliente){
										$permitido = 1;
									}
								}

								if($permitido==1){
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
										$abonado += $data['equivalente_pago'];
										$reportado += $data['equivalente_pago'];
									}else{
										$reportado += $data['equivalente_pago'];
									}
								}
							} }
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
		if($action=="Registrar"){
			$estado_ciclo = $ciclo['estado_ciclo'];
			if(
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo2") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor2") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
			){
				$estado_ciclo = 1;
			}
			if($accesoPagosR && $estado_ciclo==1){
				$marcaPago = $_SESSION['home']['cuenta']['cedula']." ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
				if(!empty($_POST)){
					if(!empty($_POST['encontrarTasa'])){
						$fecha = $_POST['fecha'];
						$tasa = $lid3r->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fecha}' and estatus = 1");
						if(Count($tasa)>1){
							$tasa['elementos']="1";
						}else{
							$tasa['elementos']="0";
						}
						echo json_encode($tasa);
					}

					if(!empty($_POST['guardarDatosTemporalmente'])){
						$_SESSION['home']['dataRegistroTemp'] = [];
						print_r($_POST);
						foreach ($_POST as $key => $value) {
							$_SESSION['home']['dataRegistroTemp'][$key] = $value;
						}
						echo "1";
					}

					if(!empty($_POST['borrarDatosTemporalmente'])){
						$_SESSION['home']['dataRegistroTemp'] = [];
						echo "1";
					}
					
					if(!empty($_POST['valForma']) && !empty($_POST['fechaPago']) && !empty($_POST['equivalente']) ){
						// print_r($_POST);

						$id_banco = "";
						$id_pedido = "";
						$forma_pago = "";
						$fechaPago = "";
						$tasa = "";
						// $tipoPago = "";
						$referencia = "";
						$serial = "";
						$monto = "";
						$eqv = "";
						$eqv2 = "";
						if(!empty($_POST['valForma'])){ $forma_pago = $_POST['valForma']; }
						if(!empty($_POST['valBanco'])){ $id_banco = $_POST['valBanco']; }
						if(!empty($_POST['fechaPago'])){ $fechaPago = $_POST['fechaPago']; }
						if(!empty($_POST['tasa'])){ $tasa = $_POST['tasa']; }
						// if(!empty($_POST['tipoPago'])){ $tipoPago = ucwords(mb_strtolower($_POST['tipoPago'])); }
						if(!empty($_POST['referencia'])){ $referencia = mb_strtoupper($_POST['referencia']); }
						if(!empty($_POST['cedula'])){ 
							$cedula = $_POST['cedula']; 
							$tipo_cedula = $_POST['tipo_cedula'];
							$referencia = $tipo_cedula."-".$cedula; 
						}
						if(!empty($_POST['telefono'])){ $referencia = $_POST['telefono']; }
						if(!empty($_POST['serial'])){ $serial = mb_strtoupper($_POST['serial']); }
						if(!empty($_POST['monto'])){ $monto = (float) $_POST['monto']; }
						if(!empty($_POST['equivalente'])){ $eqv = (float) $_POST['equivalente']; }
						if(!empty($_POST['equivalente2'])){ $eqv2 = (float) $_POST['equivalente2']; }
						if($tasa=="" && $serial==""){
							$eqv = "";
						}
						if($tasa!="" && $monto!=""){
							$eqv = (float) $monto/$tasa;
						}
						if(!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){				
							$id_cliente = $_GET['lider'];
						}else{
							$id_cliente = $_SESSION['home']['id_cliente'];
						}
						// $fechaPago="2022-08-30";
						// $referencia="272009";
						// $monto = (float) 23.46;

						$pedido=$lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.id_ciclo = pedidos.id_ciclo and ciclos.estatus = 1 and pedidos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(Count($pedido)>1){
							$pedido = $pedido[0];
							$id_pedido = $pedido['id_pedido'];		
							$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
							if(count($pedidosInv)>1){
								$pedidosInvent=$pedidosInv[0];
								$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
								$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
							}
						}


						if($id_banco != ""){
							$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
							$banco = $bancos[0];
							// if($banco['nombre_banco']=="Provincial"){ // Es uno o OTro // Venezuela o Provincial
							// if($banco['nombre_banco']=="Venezuela"){
								// $buscar = ['ejecucion'=>true];
								// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$referencia}' and monto_pago = '{$monto}'");
								// if(count($buscar)>1){
									// $buscar['movimiento'] = false;
								// }
							// }else{
								if($referencia!=""){
									// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$referencia}' and monto_pago = '{$monto}' and estatus = 1");
									// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$referencia}' and monto_pago = '{$monto}'");
									if($banco['codigo_banco']=="0108" && !empty($_POST['cedula'])){
										$buscar = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$cedula}%' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");
									}else{
										$buscar = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$referencia}' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");
									}
									$execution['movimiento'] = true;
								}else if($serial != ""){
									// echo "ID Banco: ".$id_banco."<br>";
									// echo "fecha Pago: ".$fechaPago."<br>";
									// echo "Movimiento: ".$serial."<br>";
									// echo "Monto: ".$eqv."<br>";
									// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
									// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}'");
									if(!isset($monto)){
										$buscar = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$serial}%' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");
									}else{
										$buscar = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$serial}%' and monto_movimiento = '{$eqv}' and estado_movimiento != 'Firmado' and estatus = 1");
									}

									$execution['movimiento'] = true;
								}
							// }
						}else{
							if($forma_pago=="Divisas Dolares"){
								// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
								// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and  id_campana = {$id_campana}");
								$buscar = $lid3r->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
							}
							if($forma_pago=="Divisas Euros"){
								// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
								// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and  id_campana = {$id_campana}");
								$buscar = $lid3r->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
							}
							if($forma_pago=="Efectivo Bolivares"){
								$buscar = ['ejecucion'=>true];
							}
						}
						$pagoID = "HOME_C".$id_ciclo."Y".$ano_ciclo."LDR".$id_cliente."PED".$id_pedido."P";
						$numss = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago LIKE '%{$pagoID}%'");
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
						$numero_pago = $numMax+1;
						$pagoID .= $numero_pago;
						// // echo $numero_pago;
						// // echo $pagoID;

						$continuar = false;
						if(count($buscar)>1 && (!empty($execution['movimiento']))){
							// echo "Encontro Resultado pero en Movimientos";
							$continuar = true;
						}else if(count($buscar)<2 && (!empty($execution['movimiento']))){
							// echo "No Encontro Resultado, No encontrado en movimientos";
							$continuar = false;
						}else if(count($buscar)>1){
							// echo "Encontro Resultado, pero estan Repetidos";
							$continuar = false;
						}else if(count($buscar)<2){
							// echo "No encontro Resultados";
							$continuar = true;
						}
						if($continuar==true){
							// echo "Todo OK<br><br>";
							if($id_banco==""){
								// echo "Si depende de un banco sera Automatico";
								$query = "INSERT INTO pagos (id_pago, id_ciclo, id_pedido, fecha_pago, fecha_registro, forma_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, marca, estatus) VALUES ('{$pagoID}', {$id_ciclo}, {$id_pedido}, '{$fechaPago}', '{$fechaActual}', '{$forma_pago}', '{$serial}', '{$monto}', '{$tasa}', '{$eqv}', '{$marcaPago}', 1)";
							}else{
								if($referencia!=""){
									// echo "Hay Referencia no Serial";

									// if($banco['nombre_banco']=="Venezuela"){
									// 	$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES ('{$pagoID}', $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$referencia', '$monto', '$tasa', '$eqv', 1)";
									// }else{
										$query = "INSERT INTO pagos (id_pago, id_ciclo, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, marca, estatus) VALUES ('{$pagoID}', {$id_ciclo}, {$id_pedido}, {$id_banco}, '{$fechaPago}', '{$fechaActual}', '{$forma_pago}', '{$referencia}', '{$monto}', '{$tasa}', '{$eqv}', 'Abonado', '{$marcaPago}', 1)";
										// if(!empty($execution['movimiento']) && $execution['movimiento']==true){
										// 	$id_movimiento = $buscar[0]['id_movimiento'];
										// 	// echo "Movimiento ID: ".$id_movimiento;
										// 	$lider->modificar("UPDATE movimientos SET estado_movimiento='Firmado', id_pago = '{$pagoID}' WHERE id_movimiento = '{$id_movimiento}'");
										// }
									// }
								}else if($serial!=""){
									// echo "Hay Serial no Referencia";

									// if($banco['nombre_banco']=="Venezuela"){
									// 	$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES ('{$pagoID}', $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 1)";
									// }else{
										$query = "INSERT INTO pagos (id_pago, id_ciclo, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, marca, estatus) VALUES ('{$pagoID}', {$id_ciclo}, {$id_pedido}, {$id_banco}, '{$fechaPago}', '{$fechaActual}', '{$forma_pago}', '{$serial}', '{$monto}', '{$tasa}', '{$eqv}', 'Abonado', '{$marcaPago}', 1)";
										// if(!empty($execution['movimiento']) && $execution['movimiento']==true){
										// 	$id_movimiento = $buscar[0]['id_movimiento'];
										// 	// echo "Movimiento ID: ".$id_movimiento;
										// 	$lider->modificar("UPDATE movimientos SET estado_movimiento='Firmado', id_pago = '{$pagoID}' WHERE id_movimiento = '{$id_movimiento}'");
										// }
									// }
								}
							}
							$exec = $lider->registrar($query, "pagos", "id_pago");
							if($exec['ejecucion']==true){
								$response = "1";
								if(!empty($execution['movimiento']) && $execution['movimiento']==true){
									$id_movimiento = $buscar[0]['id_movimiento'];
									// echo "Movimiento ID: ".$id_movimiento;
									$lid3r->modificar("UPDATE movimientos SET estado_movimiento='Firmado', id_pago = '{$pagoID}' WHERE id_movimiento = '{$id_movimiento}'");
								}
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pago', 'Registrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
							}
						}else{
							if(!empty($execution['movimiento'])){
								$movimentos = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}'");
								if(count($movimentos)>1){
									if($id_banco != ""){
										$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
										$banco = $bancos[0];
										if($referencia!=""){
											if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
												$buscar1 = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$cedula}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");

											}else{
												$buscar1 = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$referencia}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
											}
										}else if($serial != ""){
											if(!isset($monto)){
												$buscar1 = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
											}else{
												$buscar1 = $lid3r->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$eqv}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
											}
										}
										if(count($buscar1)>1){
											$id_pago_buscar = $buscar1[0]['id_pago'];
											$positionSearch = strrpos($id_pago_buscar, "OME_");
											if($positionSearch==false){
												if($referencia!=""){
													if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
														$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$cedula}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
													}else{
														$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$referencia}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
													}
												}else if($serial != ""){
													if(!isset($monto)){
														$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
													}else{
														$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$eqv}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
													}
												}
											}else{
												if($referencia!=""){
													if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
														$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$cedula}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
													}else{
														$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$referencia}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
													}
												}else if($serial != ""){
													if(!isset($monto)){
														$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
													}else{
														$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
														// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$eqv}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
													}
												}
											}
											if(count($buscar2)>1){
												$dataEncontrado = $buscar2[0];
												if($positionSearch==false){
													$dataEncontrado['sistema'] = "stylecollection";
													$response = "952";
												}else{
													$dataEncontrado['sistema'] = "stylehome";
													$response = "951";
												}
											}else{
												$response = "910";
											}
										}else{
											$response = "911";
										}
									}else{
										$response = "912";
									}
								}else{
									$response = "92";
								}
							}else{
								$response = "9";
							}
						}
						// echo "<br>Response: ".$response."<br>";
						// echo "<br>";
						// print_r($dataEncontrado);
						// echo "<br>";

						if(!empty($action)){
							if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
								require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
							}else{
							    require_once 'public/views/error404.php';
							}
						}else{
							require_once 'public/views/error404.php';
						}	
					}

					if(!empty($_POST['buscarFechaMovimientos']) && !empty($_POST['idBanco'])){
						$id_banco = $_POST['idBanco'];
						$mov = $lid3r->consultarQuery("SELECT DISTINCT max(fecha_movimiento) FROM movimientos WHERE id_banco = {$id_banco} ORDER BY fecha_movimiento DESC");
						if(!empty($mov[0][0])){
							$mov['elementos'] = "1";
						}else{
							$mov['elementos'] = "0";
						}
						echo json_encode($mov);
					}
				}
				if(empty($_POST)){
					// $promociones = [];
					if(!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==0){
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
					}else{
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
						if(!empty($_GET['admin']) && !empty($_POST['id_cliente'])){				
							$id_cliente = $_POST['id_cliente'];
						} else if(!empty($_GET['admin']) && !empty($_GET['lider'])){				
							$id_cliente = $_GET['lider'];
						}else{
							$id_cliente = $_SESSION['home']['id_cliente'];
						}
					
						$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidos)>1){
							$id_pedido = $pedidos[0]['id_pedido'];
							$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and pedidos.id_pedido = $id_pedido");
						}else{
							$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");					
						}
						// $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
					}
					$index = 0;
					foreach ($lideres as $key) {
						if(!empty($key['id_pedido'])){
							$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
							if(count($pedidosInv)>1){
								$pedidosInvent=$pedidosInv[0];
								$lideres[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
								$lideres[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							}
							$index++;
						}
					}
					$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
					if(!empty($pedidos) && Count($pedidos)>1){
						$pedido = $pedidos[0];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
					}
					if($num_ciclo == 1){
						$yL = date('Y')-1;
						$limiteFechaMinimo = date($yL.'-01-01');
					}else{
						$limiteFechaMinimo = date('Y-01-01');				
					}

					// if(!empty($_GET['fechaPagar'])){
					// 	$fechaPagar = $_GET['fechaPagar'];
					// 	$tasaHoy = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaPagar}' and estatus = 1");
					// 	$tasaMontar = "";
					// 	if(count($tasaHoy)>1){
					// 		$tasaMontar = $tasaHoy[0]['monto_tasa'];
					// 	}
					// 	$fechaHoyReal = date('Y-m-d');
					// 	$tasaHoyReal = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaHoyReal}' and estatus = 1");
					// 	$tasaMontarReal = "";
					// 	if(count($tasaHoyReal)>1){
					// 		$tasaMontarReal = $tasaHoyReal[0]['monto_tasa'];
					// 	}
						
					// }

					if(!empty($action)){
						if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
							require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
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
		if($action=="Modificar"){
			$estado_ciclo = $ciclo['estado_ciclo'];
			if(
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrativo2") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista Supervisor2") || 
				mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Analista2")
			){
				$estado_ciclo = 1;
			}
			if($accesoPagosM && $estado_ciclo==1){
				$marcaPago = $_SESSION['home']['cuenta']['cedula']." ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
				if(!empty($_POST)){
					if(!empty($_POST['fechaPago']) && !empty($_POST['serial']) && !empty($_POST['equivalente']) ){
						$id_banco = "";
						$id_pedido = "";
						$forma_pago = "";
						$fechaPago = "";
						$tasa = "";
						// $tipoPago = "";
						$referencia = "";
						$serial = "";
						$monto = "";
						$eqv = "";
						$eqv2 = "";
						if(!empty($_POST['valForma'])){ $forma_pago = $_POST['valForma']; }
						if(!empty($_POST['valBanco'])){ $id_banco = $_POST['valBanco']; }
						if(!empty($_POST['fechaPago'])){ $fechaPago = $_POST['fechaPago']; }
						if(!empty($_POST['tasa'])){ $tasa = $_POST['tasa']; }
						// if(!empty($_POST['tipoPago'])){ $tipoPago = ucwords(mb_strtolower($_POST['tipoPago'])); }
						if(!empty($_POST['referencia'])){ $referencia = mb_strtoupper($_POST['referencia']); }
						if(!empty($_POST['cedula'])){ 
							$cedula = $_POST['cedula']; 
							$tipo_cedula = $_POST['tipo_cedula'];
							$referencia = $tipo_cedula."-".$cedula; 
						}
						if(!empty($_POST['telefono'])){ $referencia = $_POST['telefono']; }
						if(!empty($_POST['serial'])){ $serial = mb_strtoupper($_POST['serial']); }
						if(!empty($_POST['monto'])){ $monto = (float) $_POST['monto']; }
						if(!empty($_POST['equivalente'])){ $eqv = (float) $_POST['equivalente']; }
						if(!empty($_POST['equivalente2'])){ $eqv2 = (float) $_POST['equivalente2']; }
						if($tasa=="" && $serial==""){
							$eqv = "";
						}
						if(!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){				
							$id_cliente = $_GET['lider'];
						}else{
							$id_cliente = $_SESSION['home']['id_cliente'];
						}
						$query = "UPDATE pagos SET referencia_pago='{$serial}', equivalente_pago='{$eqv}' WHERE id_pago='{$id}'";
						$exec = $lider->modificar($query);
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						
						$sqlPagos = "SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and pagos.id_pago='{$id}'";

						$pagos = $lider->consultarQuery($sqlPagos);
						$pago=$pagos[0];
						$aux = "";
						if(!empty($_GET['filtrar'])){
							$aux .= "&filtrar=".$_GET['filtrar'];
						}
						if(!empty($_GET['admin'])){
							$aux .= "&admin=1";
						}
						if(!empty($_GET['lider'])){
							$aux .= "&lider=".$_GET['lider'];
						}
						if(!empty($_GET['rangoI'])){
							$aux .= "&rangoI=".$_GET['rangoI'];
						}
						if(!empty($_GET['rangoF'])){
							$aux .= "&rangoF=".$_GET['rangoF'];
						}
						if(!empty($_GET['Banco'])){
							$aux .= "&Banco=".$_GET['Banco'];
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
					}
				}
				if(empty($_POST)){
					$pagosCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
					$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE ciclos.id_ciclo = pedidos.id_ciclo and clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

					$sqlPagos = "SELECT * FROM ciclos, pedidos, pagos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and pagos.id_pago='{$id}'";

					$pagos = $lider->consultarQuery($sqlPagos);
					$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and ciclos.id_ciclo = {$id_ciclo}");
					if(Count($pedidos)>1){
						$pedido = $pedidos[0];
						$id_pedido = $pedido['id_pedido'];
						$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidosInv)>1){
							$pedidosInvent=$pedidosInv[0];
							$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
							$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
						}
					}
					if(count($pagos)>1){
						$pago=$pagos[0];
						// $reportado = 0;
						// $diferido = 0;
						// $abonado = 0;
						// $pagosAux = [];
						// $nnIndexAux = 0;
						// if(count($pagos)){
						// 	foreach ($pagos as $data){ if(!empty($data['id_pago'])){
						// 		$permitido = 0;
						// 		if(!empty($accesosEstructuras)){
						// 			foreach ($accesosEstructuras as $struct) {
						// 				if(!empty($struct['id_cliente'])){
						// 					if($struct['id_cliente']==$data['id_cliente']){
						// 						$permitido = 1;
						// 					}
						// 				}
						// 			}
						// 		}
						// 		if($personalInterno){
						// 			$permitido = 1;
						// 		}
						// 		if($personalExterno){
						// 			if($data['id_cliente']==$id_cliente){
						// 				$permitido = 1;
						// 			}
						// 		}

						// 		if($permitido==1){
						// 			if(!empty($_GET['Diferido'])){
						// 				if($data['estado']=="Diferido"){
						// 					$pagosAux[$nnIndexAux] = $data;
						// 					$nnIndexAux++;
						// 				}
						// 			}
						// 			if(!empty($_GET['Abonado'])){
						// 				if($data['estado']=="Abonado"){
						// 					$pagosAux[$nnIndexAux] = $data;
						// 					$nnIndexAux++;
						// 				}
						// 			}
						// 			if($data['estado']=="Diferido"){
						// 				$diferido += $data['equivalente_pago'];
						// 				$reportado += $data['equivalente_pago'];
						// 			}else if($data['estado']=="Abonado"){
						// 				$abonado += $data['equivalente_pago'];
						// 				$reportado += $data['equivalente_pago'];
						// 			}else{
						// 				$reportado += $data['equivalente_pago'];
						// 			}
						// 		}
						// 	} }
						// }
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
		if($action=="RegistrarAutorizados"){
			if($accesoPagosAutorizadosR){
				if(!empty($_POST)){
					$marcaPago = $_SESSION['home']['cuenta']['cedula']." ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
					if(!empty($_POST['lider']) && !empty($_POST['fechaPago']) && !empty($_POST['equivalente']) ){
						$id_cliente = "";
						$id_pedido = "";
						$forma_pago = "Autorizado Por ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
						$fechaPago = "";
						$serial = "";
						$monto = "";
						$tasa = "";
						$eqv = "";
						$eqv2 = "";
						if(!empty($_POST['lider'])){ $id_cliente = $_POST['lider']; }
						if(!empty($_POST['fechaPago'])){ $fechaPago = $_POST['fechaPago']; }
						if(!empty($_POST['serial'])){ $serial = ucwords(mb_strtolower($_POST['serial'])); }
						if(!empty($_POST['equivalente'])){ $eqv = $_POST['equivalente']; }
						if(!empty($_POST['equivalente2'])){ $eqv2 = $_POST['equivalente2']; }

						$pedido=$lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.id_ciclo = pedidos.id_ciclo and ciclos.estatus = 1 and pedidos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
						if(Count($pedido)>1){
							$pedido = $pedido[0];
							$id_pedido = $pedido['id_pedido'];		
							$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
							if(count($pedidosInv)>1){
								$pedidosInvent=$pedidosInv[0];
								$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
								$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
							}
						}
						
						$buscar = ['ejecucion'=>true];
						$pagoID = "HOME_C".$id_ciclo."Y".$ano_ciclo."LDR".$id_cliente."PED".$id_pedido."P";
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
						$numero_pago = $numMax+1;
						$pagoID .= $numero_pago;
						// echo "<br>".$pagoID."<br>";

						$query = "INSERT INTO pagos (id_pago, id_ciclo, id_pedido, fecha_pago, fecha_registro, forma_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, marca, estatus) VALUES ('{$pagoID}', {$id_ciclo}, {$id_pedido},'{$fechaPago}', '{$fechaActual}', '{$forma_pago}', '{$serial}', '{$monto}', '{$tasa}', '{$eqv}', 'Abonado', '{$marcaPago}', 1)";
						// echo $query."<br><br>";
						$exec = $lider->registrar($query, "pagos", "id_pago");
						// print_r($exec);
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
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
					}
				}
				if(empty($_POST)){
					if(!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==0){
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
					}else{
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
						if(!empty($_GET['admin']) && !empty($_POST['id_cliente'])){				
							$id_cliente = $_POST['id_cliente'];
						} else if(!empty($_GET['admin']) && !empty($_GET['lider'])){				
							$id_cliente = $_GET['lider'];
						}else{
							$id_cliente = $_SESSION['home']['id_cliente'];
						}
					
						$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.id_cliente = {$id_cliente}");
						if(count($pedidos)>1){
							$id_pedido = $pedidos[0]['id_pedido'];
							$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and pedidos.id_pedido = $id_pedido");
						}else{
							$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");					
						}
						// $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
					}
					$index = 0;
					foreach ($lideres as $key) {
						if(!empty($key['id_pedido'])){
							$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
							if(count($pedidosInv)>1){
								$pedidosInvent=$pedidosInv[0];
								$lideres[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
								$lideres[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
							}
							$index++;
						}
					}

					$bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
					if(!empty($pedido)&&Count($pedido)>1){
						$pedido = $pedido[0];
					}
					if($num_ciclo == 1){
						$yL = date('Y')-1;
						$limiteFechaMinimo = date($yL.'-01-01');
					}else{
						$limiteFechaMinimo = date('Y-01-01');				
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
				}
			}else{
				require_once 'public/views/error404.php';
			}
		}
		if($action=="ModificarAutorizados"){
			if($accesoPagosAutorizadosM){
				if(!empty($_POST)){
					$marcaPago = $_SESSION['home']['cuenta']['cedula']." ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
					if(!empty($_POST['lider']) && !empty($_POST['fechaPago']) && !empty($_POST['equivalente']) ){
						$id_cliente = "";
						$id_pedido = "";
						$forma_pago = "Autorizado Por ".$_SESSION['home']['cuenta']['primer_nombre']." ".$_SESSION['home']['cuenta']['primer_apellido'];
						$fechaPago = "";
						$serial = "";
						$monto = "";
						$tasa = "";
						$eqv = "";
						$eqv2 = "";
						if(!empty($_POST['lider'])){ $id_cliente = $_POST['lider']; }
						if(!empty($_POST['fechaPago'])){ $fechaPago = $_POST['fechaPago']; }
						if(!empty($_POST['serial'])){ $serial = ucwords(mb_strtolower($_POST['serial'])); }
						if(!empty($_POST['equivalente'])){ $eqv = $_POST['equivalente']; }
						if(!empty($_POST['equivalente2'])){ $eqv2 = $_POST['equivalente2']; }

						
						$query = "UPDATE pagos SET fecha_pago='{$fechaPago}', referencia_pago='{$serial}', equivalente_pago='{$eqv}' WHERE id_pago='{$id}'";
						// echo $query;
						$exec = $lider->modificar($query);
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
						}
						$pagos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, pagos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");
						$aux = "";
						if(!empty($_GET['filtrar'])){
							$aux .= "&filtrar=".$_GET['filtrar'];
						}
						if(!empty($_GET['admin'])){
							$aux .= "&admin=1";
						}
						if(!empty($_GET['lider'])){
							$aux .= "&lider=".$_GET['lider'];
						}
						if(!empty($_GET['rangoI'])){
							$aux .= "&rangoI=".$_GET['rangoI'];
						}
						if(!empty($_GET['rangoF'])){
							$aux .= "&rangoF=".$_GET['rangoF'];
						}
						if(!empty($_GET['Banco'])){
							$aux .= "&Banco=".$_GET['Banco'];
						}
						if(count($pagos)>1){
							$pago = $pagos[0];
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
				}
				if(empty($_POST)){
					$pagos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, pagos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");
					// if(!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==0){
					// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
					// }else{
					// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
					// 	if(!empty($_GET['admin']) && !empty($_POST['id_cliente'])){				
					// 		$id_cliente = $_POST['id_cliente'];
					// 	} else if(!empty($_GET['admin']) && !empty($_GET['lider'])){				
					// 		$id_cliente = $_GET['lider'];
					// 	}else{
					// 		$id_cliente = $_SESSION['home']['id_cliente'];
					// 	}
					
					// 	$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.estatus = 1 and ciclos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.id_cliente = {$id_cliente}");
					// 	if(count($pedidos)>1){
					// 		$id_pedido = $pedidos[0]['id_pedido'];
					// 		// $pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and pedidos.id_pedido = $id_pedido");
					// 	}else{
					// 		// $pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");					
					// 	}
					// 	// $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
					// }
					// $index = 0;
					// foreach ($lideres as $key) {
					// 	if(!empty($key['id_pedido'])){
					// 		$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
					// 		if(count($pedidosInv)>1){
					// 			$pedidosInvent=$pedidosInv[0];
					// 			$lideres[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
					// 			$lideres[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
					// 		}
					// 		$index++;
					// 	}
					// }

					// $bancos = $lid3r->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
					// if(!empty($pedido)&&Count($pedido)>1){
					// 	$pedido = $pedido[0];
					// }
					// if($num_ciclo == 1){
					// 	$yL = date('Y')-1;
					// 	$limiteFechaMinimo = date($yL.'-01-01');
					// }else{
					// 	$limiteFechaMinimo = date('Y-01-01');				
					// }
					if(count($pagos)>1){
						$pago = $pagos[0];
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


?>