<?php 

// if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	
	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
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
		// if($inObligatoria=="N"){
		// 	$sumAdd = 1;
		// 	$cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
		// }else{
			$sumAdd = 0;
		// }
		for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
			$key = $cantidadPagosDespachos[$i];
			if($key['cantidad'] <= $despacho['cantidad_pagos']){
				$cantidadPagosDespachosFild[$i+$sumAdd] = $key;
			}
		}
	}


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
	// print_r($cantidadPagosDespachosFild);


	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){
		$marcaPago = $_SESSION['cuenta']['cedula']." ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
		if(!empty($_POST['validarData'])){
			$id_liderazgo = $_POST['id_liderazgo'];
			$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "9"; //echo "Registro ya guardado.";
				}else{
					$response = "1";
				}
			}else{
				$response = "5"; // echo 'Error en la conexion con la bd';
			}
			echo $response;
		}

		if(!empty($_POST['encontrarTasa'])){
			$fecha = $_POST['fecha'];
			$tasa = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fecha}' and estatus = 1");
			if(Count($tasa)>1){
				$tasa['elementos']="1";
			}else{
				$tasa['elementos']="0";
			}
			echo json_encode($tasa);
		}

		if(!empty($_POST['guardarDatosTemporalmente'])){
			$_SESSION['dataRegistroTemp'] = [];
			foreach ($_POST as $key => $value) {
				$_SESSION['dataRegistroTemp'][$key] = $value;
			}
			echo "1";
		}

		if(!empty($_POST['borrarDatosTemporalmente'])){
			$_SESSION['dataRegistroTemp'] = [];
			echo "1";
		}
		
		if(!empty($_POST['valForma']) && !empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) ){
			// print_r($_POST);

			$id_banco = "";
			$id_pedido = "";
			$forma_pago = "";
			$fechaPago = "";
			$tasa = "";
			$tipoPago = "";
			$referencia = "";
			$serial = "";
			$monto = "";
			$eqv = "";
			$eqv2 = "";
			if(!empty($_POST['valForma'])){ $forma_pago = $_POST['valForma']; }
			if(!empty($_POST['valBanco'])){ $id_banco = $_POST['valBanco']; }
			if(!empty($_POST['fechaPago'])){ $fechaPago = $_POST['fechaPago']; }
			if(!empty($_POST['tasa'])){ $tasa = $_POST['tasa']; }
			if(!empty($_POST['tipoPago'])){ $tipoPago = ucwords(mb_strtolower($_POST['tipoPago'])); }
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
				$eqv = (float) number_format(($monto/$tasa),2,'.','');
			}
			if(!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){				
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['id_cliente'];
			}
			
			$pedido=$lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and pedidos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho} and pedidos.id_cliente = {$id_cliente}");

			if(Count($pedido)>1){
				$pedido = $pedido[0];
				$id_pedido = $pedido['id_pedido'];		
			}
			

			// echo "<br>";
			// echo "<br>id_pedido: ".$id_pedido;
			// echo "<br>id_banco: ".$id_banco;
			// echo "<br>fechaPago: ".$fechaPago;
			// echo "<br>forma_pago: ".$forma_pago;
			// echo "<br>tipoPago: ".$tipoPago;
			// echo "<br>referencia: ".$referencia;
			// echo "<br>serial: ".$serial;
			// echo "<br>monto: ".$monto;
			// echo "<br>tasa: ".$tasa;
			// echo "<br>eqv: ".$eqv;
			// echo "<br>eqv2: ".$eqv2;
			// echo "<br>";
			// echo "<br>";

			// if($id_banco != ""){
			// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
			// 	$banco = $bancos[0];
			// 	// if($banco['nombre_banco']=="Provincial"){
			// 		// $buscar = ['ejecucion'=>true];
			// 	// }else{
			// 		if($referencia!=""){
			// 			// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$referencia}'");
			// 			$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$referencia}%' and monto_movimiento = '{$monto}'");
			// 			if(count($buscar)>1){
			// 				$buscar['movimiento'] = true;
			// 			}
			// 		}else if($serial != ""){
			// 			// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE  referencia_pago = '{$serial}'");
			// 			$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$serial}%' and monto_movimiento = '{$monto}'");
			// 			if(count($buscar)>1){
			// 				$buscar['movimiento'] = true;
			// 			}
			// 		}
			// 	// }
			// }else{
			// 	if($forma_pago=="Divisas Dolares"){
			// 		// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and estatus = 1");
			// 		// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and id_campana = {$id_campana}");
			// 		$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}'");
			// 		if(count($buscar)>1){
			// 			$buscar['movimiento'] = false;
			// 		}
			// 	}
			// 	if($forma_pago=="Divisas Euros"){
			// 		// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and estatus = 1");
			// 		// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and id_campana = {$id_campana}");
			// 		$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}'");
			// 		if(count($buscar)>1){
			// 			$buscar['movimiento'] = false;
			// 		}
			// 	}
			// 	if($forma_pago=="Efectivo Bolivares"){
			// 		$buscar = ['ejecucion'=>true];
			// 	}

			// }



			// if(Count($buscar)<2){
				// echo "NO devolvio de resultado";





				if($id_banco != ""){
					// $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco} and estatus = 1");
					$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
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
								$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$cedula}%' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");
							}else{

								$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$referencia}' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");

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
								$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$serial}%' and monto_movimiento = '{$monto}' and estado_movimiento != 'Firmado' and estatus = 1");
							}else{
								$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}' and num_movimiento LIKE '%{$serial}%' and monto_movimiento = '{$eqv}' and estado_movimiento != 'Firmado' and estatus = 1");
							}

							$execution['movimiento'] = true;
						}
					// }

				}else{
					if($forma_pago=="Divisas Dolares"){
						// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
						// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and  id_campana = {$id_campana}");
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
					}
					if($forma_pago=="Divisas Euros"){
						// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
						// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and  id_campana = {$id_campana}");
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
					}
					if($forma_pago=="Efectivo Bolivares"){
						$buscar = ['ejecucion'=>true];
					}
				}
				// print_r($buscar);

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

				$numero_pago = $numMax+1;
				$pagoID .= $numero_pago;

				// echo $numero_pago;
				// echo $pagoID;






				// print_r($buscar);
			
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
				echo $continuar;
				if($continuar==true){


					// echo "Todo OK<br><br>";
					if($id_banco==""){
						// echo "Si depende de un banco sera Automatico";
						$query = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, marca, estatus) VALUES ('{$pagoID}', $id_pedido, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', '{$marcaPago}', 1)";

					}else{
						if($referencia!=""){
							// echo "Hay Referencia no Serial";

							// if($banco['nombre_banco']=="Venezuela"){
							// 	$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES ('{$pagoID}', $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$referencia', '$monto', '$tasa', '$eqv', 1)";
							// }else{
								$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, marca, estatus) VALUES ('{$pagoID}', $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$referencia', '$monto', '$tasa', '$eqv', 'Abonado', '{$marcaPago}', 1)";
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
								$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, marca, estatus) VALUES ('{$pagoID}', $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 'Abonado', '{$marcaPago}', 1)";
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
									$lider->modificar("UPDATE movimientos SET estado_movimiento='Firmado', id_pago = '{$pagoID}' WHERE id_movimiento = '{$id_movimiento}'");
								}
						if(!empty($modulo) && !empty($accion)){
							$fecha = date('Y-m-d');
							$hora = date('H:i:a');
							$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pago', 'Registrar', '{$fecha}', '{$hora}')";
							$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			            }
					}else{
						$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
					}
				}else{
					if(!empty($execution['movimiento'])){
						$movimentos = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_banco = {$id_banco} and fecha_movimiento = '{$fechaPago}'");
						if(count($movimentos)>1){
							if($id_banco != ""){
								$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
								$banco = $bancos[0];
								if($referencia!=""){
									if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
										// $buscar = $lider->consultarQuery("SELECT * FROM movimientos, pagos, pedidos, despachos, campanas, clientes WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$cedula}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1 and movimientos.id_pago = pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana");
										$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$cedula}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
									}else{
										// $buscar = $lider->consultarQuery("SELECT * FROM movimientos, pagos, pedidos, despachos, campanas, clientes WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$referencia}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1 and movimientos.id_pago = pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana");
										$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$referencia}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
									}
								}else if($serial != ""){
									if(!isset($monto)){
										// $buscar = $lider->consultarQuery("SELECT * FROM movimientos, pagos, pedidos, despachos, campanas, clientes WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1 and movimientos.id_pago = pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana");
										$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$monto}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
									}else{
										// $buscar = $lider->consultarQuery("SELECT * FROM movimientos, pagos, pedidos, despachos, campanas, clientes WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$eqv}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1 and movimientos.id_pago=pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana");
										$buscar = $lider->consultarQuery("SELECT * FROM movimientos WHERE movimientos.id_banco = {$id_banco} and movimientos.fecha_movimiento = '{$fechaPago}' and movimientos.num_movimiento LIKE '%{$serial}%' and movimientos.monto_movimiento = '{$eqv}' and movimientos.estado_movimiento = 'Firmado' and movimientos.estatus = 1");
									}
								}
								if(count($buscar)>1){
									$id_pago_buscar = $buscar[0]['id_pago'];
									$positionSearch = strpos($id_pago_buscar, "OME_");
									if($positionSearch==false){
										if($referencia!=""){
											if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
												$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$cedula}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
											}else{
												$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$referencia}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
											}
										}else if($serial != ""){
											if(!isset($monto)){
												$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
											}else{
												$buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lider->consultarQuery("SELECT * FROM pagos, pedidos, despachos, campanas, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$eqv}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pagos.id_pago='{$id_pago_buscar}'");
											}
										}
									}else{
										if($referencia!=""){
											if($banco['nombre_banco']=="Provincial" && !empty($_POST['cedula'])){
												$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$cedula}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
											}else{
												$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$referencia}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
											}
										}else if($serial != ""){
											if(!isset($monto)){
												$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$monto}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
											}else{
												$buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
												// $buscar2 = $lid3r->consultarQuery("SELECT * FROM pagos, pedidos, ciclos, clientes WHERE pagos.id_banco = {$id_banco} and pagos.fecha_pago = '{$fechaPago}' and pagos.referencia_pago LIKE '%{$serial}%' and pagos.monto_pago = '{$eqv}' and pagos.estatus = 1 and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and pagos.id_pago='{$id_pago_buscar}'");
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
									// $dataEncontrado = $buscar[0];
									// print_r($dataEncontrado);
									// $response = "95";
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
				// $response = "95";
				// echo "<br>Response: ".$response."<br>";
				// echo "<br>";
				// print_r($dataEncontrado);
				// echo "<br>";

				$fechasPromociones = [];
				$fechasPromo = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
				if(count($fechasPromo)>1){
					$fechasPromociones = $fechasPromo[0];
				}
				$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");

				if(!empty($_GET['fechaPagar'])){
					$fechaPagar = $_GET['fechaPagar'];
					$tasaHoy = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaPagar}' and estatus = 1");
					$tasaMontar = "";
					if(count($tasaHoy)>1){
						$tasaMontar = $tasaHoy[0]['monto_tasa'];
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

		}

		if(!empty($_POST['buscarFechaMovimientos']) && !empty($_POST['idBanco'])){
			$id_banco = $_POST['idBanco'];
			$mov = $lider->consultarQuery("SELECT DISTINCT max(fecha_movimiento) FROM movimientos WHERE id_banco = {$id_banco} ORDER BY fecha_movimiento DESC");
			if(!empty($mov[0][0])){
				$mov['elementos'] = "1";
			}else{
				$mov['elementos'] = "0";
			}
			echo json_encode($mov);
		}
		//print_r($_SESSION['dataRegistroTemp']);
		if(empty($_POST)){
			$promociones = [];
			if(!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==0){
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			}else{
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
				if(!empty($_GET['admin']) && !empty($_POST['id_cliente'])){				
					$id_cliente = $_POST['id_cliente'];
				} else if(!empty($_GET['admin']) && !empty($_GET['lider'])){				
					$id_cliente = $_GET['lider'];
				}else{
					$id_cliente = $_SESSION['id_cliente'];
				}
			
				$pedido = $lider->consultarQuery("SELECT * FROM campanas, despachos,pedidos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho} and despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = {$id_cliente}");
				if(count($pedido)>1){
					$id_ped = $pedido[0]['id_pedido'];
					$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and pedidos.id_pedido = $id_ped");
				}else{
					$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente}");					
				}
				$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
			}
			$fechasPromociones = [];
			$fechasPromo = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
			if(count($fechasPromo)>1){
				$fechasPromociones = $fechasPromo[0];
			}

			$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
			$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.estatus = 1 and campanas.estatus = 1 and despachos.estatus = 1 and planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = despachos.id_campana and planes_campana.id_despacho = {$id_despacho}");


			if(Count($despachos)>1){
				$despacho = $despachos[0];
				if(!empty($pedido)&&Count($pedido)>1){
					$pedido = $pedido[0];
				}
				if($numero_campana == 1){
					$yL = date('Y')-1;
					$limiteFechaMinimo = date($yL.'-01-01');
				}else{
					$limiteFechaMinimo = date('Y-01-01');				
				}

				if(!empty($_GET['fechaPagar'])){
					$fechaPagar = $_GET['fechaPagar'];
					$tasaHoy = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaPagar}' and estatus = 1");
					$tasaMontar = "";
					if(count($tasaHoy)>1){
						$tasaMontar = $tasaHoy[0]['monto_tasa'];
					}
					$fechaHoyReal = date('Y-m-d');
					$tasaHoyReal = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaHoyReal}' and estatus = 1");
					$tasaMontarReal = "";
					if(count($tasaHoyReal)>1){
						$tasaMontarReal = $tasaHoyReal[0]['monto_tasa'];
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