<?php 

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
$pagosObligatorios = $despacho['opcionInicialObligatorio'];
################################################

$pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];
$iterRecor = 1;
foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
	if($pagosD['tipo_pago_despacho']=="Inicial"){
		$pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
		$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
		$iterRecor++;
	}
} }
$cantidadPagosDespachosFild = [];
if($pagosObligatorios == "Y"){
	$cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
	for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
		$key = $cantidadPagosDespachos[$i];
		if($key['cantidad'] <= $despacho['cantidad_pagos']){
			$cantidadPagosDespachosFild[$i+1] = $key;
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
}
if($pagosObligatorios == "N"){
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
		$tasa = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fecha}'");
		if(Count($tasa)>1){
			$tasa['elementos']="1";
		}else{
			$tasa['elementos']="0";
		}
		echo json_encode($tasa);
	}

	if(!empty($_POST['valForma']) && !empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) ){
		
		$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = {$id_despacho} and estatus = 1");
		$despacho = $despachos[0];

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
			// if(!empty($_POST['tipo_cedula'])){
			// }
			$referencia = $tipo_cedula."-".$cedula; 
		}

		if(!empty($_POST['telefono'])){ $referencia = $_POST['telefono']; }
		if(!empty($_POST['serial'])){ $serial = mb_strtoupper($_POST['serial']); }
		if(!empty($_POST['monto'])){ $monto = (float) $_POST['monto']; }
		if(!empty($_POST['equivalente'])){ $eqv = (float) $_POST['equivalente']; }
		if(!empty($_POST['equivalente2'])){ $eqv2 = $_POST['equivalente2']; }
		if($tasa=="" && $serial==""){
			$eqv = "";
		}
		if(!empty($_GET['admin']) && !empty($_GET['select']) && !empty($_GET['lider'])){				
			// $id_cliente = $_POST['id_cliente'];
			$id_cliente = $_GET['lider'];
		}else{
			$id_cliente = $_SESSION['id_cliente'];
		}


		// print_r($pedido);
		// if(Count($pedido)>1){
		// 	$pedido = $pedido[0];
		// 	$id_pedido = $pedido['id_pedido'];		
		// }

		// echo "<br>id_banco: ".$id_banco;
		// echo "<br>fechaPago: ".$fechaPago;
		// echo "<br>forma_pago: ".$forma_pago;
		// echo "<br>tipoPago: ".$tipoPago;
		// echo "<br>referencia: ".$referencia;
		// echo "<br>monto: ".$monto;
		// echo "<br>tasa: ".$tasa;
		// echo "<br>eqv: ".$eqv;
		// echo "<br>eqv2: ".$eqv2;
		// $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago = '{$fechaPago}' and referencia_pago = '{$referencia}' and monto_pago = '{$monto}'");
		// print_r($buscar);
		// if(Count($buscar)<2){

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

		$pago = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago='{$id}'");
		$pago = $pago[0];
		// $pedido=$lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and pedidos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho} and pedidos.id_cliente = {$pago['id_cliente']}");
		$pedido=$lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and pedidos.estatus = 1 and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho} and pedidos.id_cliente = {$pago['id_cliente']}");
		// print_r($pedido);
		$pedido = $pedido[0];

		$infopago = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago='{$id}'");
		$buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE referencia_pago = '{$referencia}'");
		// print_r($buscar);
		if (count($buscar)>1 && count($buscar)<3){
			$infopago = $infopago[0];
			$busc = $buscar[0];
			$posibilidad = 0;
			// echo "<br>";
			// echo "Buscado: ".$busc['referencia_pago']."<br>";
			// echo "Actual: ".$infopago['referencia_pago']."<br>";
			// echo "<br>";
			if($busc['referencia_pago']==$infopago['referencia_pago']){
			}else{
				$posibilidad++;
			}
			// echo "<br>";
			// echo "Buscado: ".$busc['monto_pago']."<br>";
			// echo "Actual: ".$infopago['monto_pago']."<br>";
			// echo "<br>";
			if($busc['monto_pago']==$infopago['monto_pago']){
			}else{
				$posibilidad++;
			}
			if($posibilidad==2){
				// echo "Registro Repetido Y se quiere meter 2 veces<br><b>Negar actualizacion</b>";
				$response = "9";
			}else{
				// echo "Registro con error en la referencia o en el monto<br><b>Permitir Actualizar</b>";
				if($id_banco==""){
					if($pago['estado'] == "Abonado"){
						if($referencia!=""){
							// echo "Referencia Sin Banco";
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";

						}else if($serial!=""){
							// echo "Serial Sin Banco";
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
						}else{
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
						}
					}else{

						if($referencia!=""){
							// echo "Referencia Sin Banco";
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";

						}else if($serial!=""){
							// echo "Serial Sin Banco";
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
						}else{
							$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
						}
					}
				}else{
					if($pago['estado'] == "Abonado"){
						if($referencia!=""){
							// echo "Referencia Con Banco";
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
						}else if($serial!=""){
							// echo "Serial Con Banco";
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";

						}else{
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
						}
					}else{

						if($referencia!=""){
							// echo "Referencia Con Banco";
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
						}else if($serial!=""){
							// echo "Serial Con Banco";
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";

						}else{
							$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
						}
					}
				}
				
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pago', 'Modificar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}



			}
		}else{
			// echo "Positivo <b>Permitir Actualizar</b>";

			if($id_banco==""){
				if($pago['estado'] == "Abonado"){
					if($referencia!=""){
						// echo "Referencia Sin Banco";
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";

					}else if($serial!=""){
						// echo "Serial Sin Banco";
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
					}else{
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
					}
				}else{

					if($referencia!=""){
						// echo "Referencia Sin Banco";
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";

					}else if($serial!=""){
						// echo "Serial Sin Banco";
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
					}else{
						$query = "UPDATE pagos SET fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
					}
				}
			}else{
				if($pago['estado'] == "Abonado"){
					if($referencia!=""){
						// echo "Referencia Con Banco";
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
					}else if($serial!=""){
						// echo "Serial Con Banco";
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";

					}else{
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estatus=1 WHERE id_pago='$id'";
					}
				}else{

					if($referencia!=""){
						// echo "Referencia Con Banco";
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$referencia', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
					}else if($serial!=""){
						// echo "Serial Con Banco";
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', referencia_pago='$serial', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";

					}else{
						$query = "UPDATE pagos SET id_banco=$id_banco, fecha_pago='$fechaPago', forma_pago='$forma_pago', tipo_pago='$tipoPago', monto_pago='$monto', tasa_pago='$tasa', equivalente_pago='$eqv', estado='', estatus=1 WHERE id_pago='$id'";
					}
				}
			}
			
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				$response = "1";

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pago', 'Modificar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
			}else{
				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}

		}


		$pago = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago='{$id}'");
		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
		$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.estatus = 1 and campanas.estatus = 1 and despachos.estatus = 1 and planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = despachos.id_campana and planes_campana.id_despacho = {$id_despacho}");
		$despacho = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
		$fechasPromociones = [];
		$fechasPromo = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
		if(count($fechasPromo)>1){
			$fechasPromociones = $fechasPromo[0];
		}
		$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");

		$pago = $pago[0];
			$despacho = $despacho[0];

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
		// echo $id_banco;
		$mov = $lider->consultarQuery("SELECT DISTINCT max(fecha_movimiento) FROM movimientos WHERE id_banco = {$id_banco} ORDER BY fecha_movimiento DESC");
		if(!empty($mov[0][0])){
			$mov['elementos'] = "1";
		}else{
			$mov['elementos'] = "0";
		}
		echo json_encode($mov);
	}

	if(empty($_POST)){
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$pago = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pagos.id_pago='{$id}'");
			

		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado'");
		$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.estatus = 1 and campanas.estatus = 1 and despachos.estatus = 1 and planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = despachos.id_campana and planes_campana.id_despacho = {$id_despacho}");
		$despacho = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");


		if(Count($pago)>1){
			$pago = $pago[0];
			$pedido = $lider->consultarQuery("SELECT * FROM campanas, despachos,pedidos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho} and despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = {$pago['id_cliente']}");
			if(count($pedido)>1){
				$id_ped = $pedido[0]['id_pedido'];
				$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$pago['id_cliente']} and pedidos.id_pedido = $id_ped");
			}else{
				$pagos = $lider->consultarQuery("SELECT * FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.estatus = 1 and pedidos.id_cliente = {$pago['id_cliente']}");					
			}
			$fechasPromociones = [];
			$fechasPromo = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
			if(count($fechasPromo)>1){
				$fechasPromociones = $fechasPromo[0];
			}
			$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$pago['id_cliente']} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");

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