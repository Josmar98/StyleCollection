<?php 

		  $id_campana = $_GET['campaing'];
		  $numero_campana = $_GET['n'];
		  $anio_campana = $_GET['y'];
			$id_despacho = $_GET['dpid'];
			$num_despacho = $_GET['dp'];
			$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
		$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrativo2"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){
		if(!empty($_POST['validarData'])){
			$id_liderazgo = $_POST['id_liderazgo'];
			$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "9"; //echo "Registro ya guardado.";
				  // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
			   //    if($res2['ejecucion']==true){
			   //      if(Count($res2)>1){
			   //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
			   //        if($res3['ejecucion']==true){
			   //          $response = "1";
			   //        }
			   //      }else{
			   //        $response = "9"; //echo "Registro ya guardado.";
			   //      }
			   //    }


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
			$tasa = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fecha}'");
			if(Count($tasa)>1){
				$tasa['elementos']="1";
			}else{
				$tasa['elementos']="0";
			}
			echo json_encode($tasa);
		}

		if(!empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) ){
			$id_banco = "";
			$id_pedido = "";
			$forma_pago = "Autorizado Por ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
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
			if(!empty($_POST['referencia'])){ $referencia = ucwords(mb_strtolower($_POST['referencia'])); }
			if(!empty($_POST['cedula'])){ 
				$cedula = $_POST['cedula']; 
				$tipo_cedula = $_POST['tipo_cedula'];
				$referencia = $tipo_cedula."-".$cedula; 
			}
			if(!empty($_POST['telefono'])){ $referencia = ucwords(mb_strtolower($_POST['telefono'])); }
			if(!empty($_POST['serial'])){ $serial = ucwords(mb_strtolower($_POST['serial'])); }
			if(!empty($_POST['monto'])){ $monto = $_POST['monto']; }
			if(!empty($_POST['equivalente'])){ $eqv = $_POST['equivalente']; }
			if(!empty($_POST['equivalente2'])){ $eqv2 = $_POST['equivalente2']; }
			if($tasa=="" && $serial==""){
				$eqv = "";
			}
			if(!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){				
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['id_cliente'];
			}
			$tipoPago = ucwords(mb_strtolower($tipoPago));
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

			if($id_banco != ""){
				$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
				$banco = $bancos[0];
				if($banco['nombre_banco']=="Provincial"){
					$buscar = ['ejecucion'=>true];
				}else{
					if($referencia!=""){
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$referencia}'");
					}else if($serial != ""){
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}'");						
					}
				}
			}else{
				if($forma_pago=="Divisas Dolares"){
					$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}'");
				}
				else if($forma_pago=="Divisas Euros"){
					$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$serial}'");
				}
				else if($forma_pago=="Efectivo Bolivares"){
					$buscar = ['ejecucion'=>true];
				}else{
					$buscar = ['ejecucion'=>true];
				}
			}
			// // print_r($buscar);
			if(Count($buscar)<2){
				if($id_banco != ""){
					$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
					$banco = $bancos[0];
					if($banco['nombre_banco']=="Provincial"){
						$buscar = ['ejecucion'=>true];
					}else{

						if($referencia!=""){
							// echo "asdasd1";
							$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$referencia}' and monto_pago = '{$monto}'");
						}else if($serial != ""){
							// echo "asdasd2";
							$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}'");

						}
					}
				}else{
					
					if($forma_pago=="Divisas Dolares"){
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}'");
					}
					else if($forma_pago=="Divisas Euros"){
						$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$serial}' and monto_pago = '{$monto}'");
					}
					else if($forma_pago=="Efectivo Bolivares"){
						$buscar = ['ejecucion'=>true];
					} else{
						$buscar = ['ejecucion'=>true];
					}
				}
				if(Count($buscar)<2){
					// echo "Todo OK";

					// if($id_banco==""){
						// echo "Cerca";
						// if($forma_pago=="Divisas Dolares"){
						// 	$query = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES (DEFAULT, $id_pedido, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 1)";
						// }
						// if($forma_pago=="Divisas Euros"){
						// 	$query = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES (DEFAULT, $id_pedido, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 1)";
						// }
						// if($forma_pago=="Efectivo Bolivares"){
						// 	$query = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES (DEFAULT, $id_pedido, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 1)";
						// }
						// $query = "INSERT INTO pagos (id_pago, id_pedido, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estado, estatus) VALUES (DEFAULT, $id_pedido, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 'Abonado', 1)";
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";

					// }else{
					// 	// echo $id_banco."<br>";
					// 	if($referencia!=""){
					// 		// echo "Hay Referencia no Serial";
					// 		$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES (DEFAULT, $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$referencia', '$monto', '$tasa', '$eqv', 1)";
					// 	}else if($serial!=""){
					// 		// echo "Hay Serial no Referencia";
					// 		$query = "INSERT INTO pagos (id_pago, id_pedido, id_banco, fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, estatus) VALUES (DEFAULT, $id_pedido, $id_banco, '$fechaPago', '".date('Y-m-d')."', '$forma_pago', '$tipoPago', '$serial', '$monto', '$tasa', '$eqv', 1)";
					// 	}
					// }
					$exec = $lider->registrar($query, "pagos", "id_pago");
					if($exec['ejecucion']==true){
						$response = "1";

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
					$response = "9";
				}
			}else{
				$response = "9";
			}
			$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
			$pago = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");
			$pago = $pago[0];
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

			$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
			$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.estatus = 1 and campanas.estatus = 1 and despachos.estatus = 1 and planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = despachos.id_campana and planes_campana.id_despacho = {$id_despacho}");
			$despacho = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
			$pago = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago = '{$id}'");


			if(Count($pago)>1){
				$pago = $pago[0];
				$despacho = $despacho[0];
				if(!empty($pedido)&&Count($pedido)>1){
					$pedido = $pedido[0];
				}
				if($numero_campana == 1){
					$yL = date('Y')-1;
					$limiteFechaMinimo = date($yL.'-01-01');
				}else{
					$limiteFechaMinimo = date('Y-01-01');				
				}

				// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
				// $pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.cantidad_aprobado > 0 and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
				// $query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho";
				// $facturas = $lider->consultarQuery($query);
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