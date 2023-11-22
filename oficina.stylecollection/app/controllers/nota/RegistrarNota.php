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

	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){

	function separateDatosCuentaTel($num){
		// echo $num[0];
		// echo strlen($num);
		$set = 0;
		$newNum = '';
		for ($i=0; $i < strlen($num); $i++) { 
			if($i==4){
				$newNum .= '-';
			}
			if($i==7){
				$newNum .= '-';
			}
			if($i==9){
				$newNum .= '-';
			}
			$newNum .= $num[$i];
		}
		return $newNum;
	}
	if (!empty($_POST)) {
		// print_r($_POST);
		$nameAnalista = "";
		if(!empty($_POST['nombreanalista'])){
			$nameAnalista = ucwords(mb_strtolower($_POST['nombreanalista']));
		}
		$direccion = mb_strtoupper($_POST['direccion_emision']);
		$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
		$fecha = $_POST['fecha_emision'];
		$num = $_POST['numero'];
		$id_lider = $_POST['id_cliente'];
		$pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
		$id_pedido = $pedidoss[0]['id_pedido'];
		$opts = [];
		if(!empty($_POST['opts'])){
			$opts = $_POST['opts'];
		}
		$max = count($opts);
		$query = "INSERT INTO notasentrega (id_nota_entrega, id_cliente, id_campana, direccion_emision, lugar_emision, fecha_emision, numero_nota_entrega, nombreanalista, id_pedido, estatus) VALUES (DEFAULT, {$id_lider}, {$id_campana}, '{$direccion}', '{$lugar}', '{$fecha}', {$num}, '{$nameAnalista}', {$id_pedido}, 1)";
		// echo $query."<br>";
		$exec = $lider->registrar($query, "notasentrega", "id_nota_entrega");
		// print_r($exec);
		$responses2 = [];
		if($exec['ejecucion']==true){
			$id_nota = $exec['id'];
			$nume = 0;
			foreach ($opts as $cod => $val) {
				$query2 = "INSERT INTO opcionesentrega (id_opcion_entrega, id_nota_entrega, cod, val, estatus) VALUES (DEFAULT, {$id_nota}, '{$cod}', '{$val}', 1)";
				$exec2 = $lider->registrar($query2, "opcionesentrega", "id_opcion_entrega");
				if($exec2['ejecucion']==true){
					$responses2[$nume] = 1;
				}else{
					$responses2[$nume] = 2;
				}
				$nume++;
			}
			$sum = 0;
			foreach ($responses2 as $key) {
				$sum += $key;
			}
			if($sum == $max){
				$response = "1";
			}else{
				$response = "2";
			}
		}else{
			$response = "2";
		}

		// echo $response;
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$id = $_GET['lider'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");

			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			$numFactura = "";
			if(count($factura)>1){
				$numFactura = $factura[0]['numero_factura'];
				switch (strlen($factura[0]['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura[0]['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura[0]['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura[0]['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura[0]['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura[0]['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura[0]['numero_factura'];
						break;
				}
			}

			// $planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.opcion = 1 and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
			$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_campana = {$id_campana} and planes_campana.id_campana = {$id_campana} and planes_campana.id_plan = planes.id_plan and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and tipos_colecciones.id_pedido = {$id_pedido} and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");
			$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
			$premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
			$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
			// if(count($premios_planes) < 2){
			// 	$pplan_momentaneo = $planesCol[0]['nombre_plan'];
			// 	$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes.nombre_plan = '{$pplan_momentaneo}'");
			// }

			$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");

			$retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

			$canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho} and canjeos.id_cliente = {$id}");

			$canjeosUnic = $lider->consultarQuery("SELECT DISTINCT catalogos.id_catalogo, nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

			$premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA = ''");

			$premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA <> ''");

			$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
			$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
			$despacho = $despachos[0];
			$iterRecor = 0;
			foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
				if($pagosD['tipo_pago_despacho']=="Inicial"){
					// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
					$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'cod'=>'I', 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
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
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
								$iterRecor++;
							}
							if($i == $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
								$iterRecor++;
							}
						}
					}}
				}
			}

			// ========================== // =============================== // ============================== //
			if(count($premios_planes)<2){
				$premios_planes = [];
				$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

				$id_planes_camp = [];
				$nidxp = 0;
				foreach ($pagosRecorridos as $pagosR) {
					if(!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
					}else{
						$id_planes_camp[$nidxp]['id_tipo'] = $pagosR['name'];
						$id_planes_camp[$nidxp]['id_plan'] = 0;
						$nidxp++;
					}
				}
				for ($i=0; $i < count($id_planes_camp); $i++) { 
					foreach ($premios_planes as $key) {
						if(!empty($key['id_plan_campana'])){
							if($id_planes_camp[$i]['id_tipo']==$key['tipo_premio']){
								if($id_planes_camp[$i]['id_plan']==0){
									$id_planes_camp[$i]['id_plan'] = $key['id_plan_campana'];
								}
							}
						}
					}
				}

				$n1 = 0;
				$premios_planes = [];
				foreach ($id_planes_camp as $keys) {
					$id_plan_camp = $keys['id_plan'];
					$tipo_plan_camp = $keys['id_tipo'];
					$newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
					foreach ($newPlan as $nplan) {
						if(!empty($nplan['id_plan_campana'])){
							$premios_planes[$n1] = $nplan;
							$n1++;
						}
					}
				}
			}

			$premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
			$controladorPremios = [];
			$numeroX = 0;
			foreach ($planesCol as $key1) {
				if(!empty($key1['id_plan'])){
					$numeroX2 = 0;
					foreach ($pagosRecorridos as $pagosR) {
						if(!empty($controladorPremios[$numeroX]['plan'])){
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}else{
							$controladorPremios[$numeroX]['id_plan'] = $key1['id_plan'];
							$controladorPremios[$numeroX]['plan'] = $key1['nombre_plan'];
							$controladorPremios[$numeroX]['cantidad_colecciones'] = $key1['cantidad_coleccion'];
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']] = [];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}
						$numeroX2++;
					}
					$numeroX++;
				}
			}
			// print_r($controladorPremios);
			// ========================== // =============================== // ============================== //
			# ==================================================================================
				$fechas_promociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
				$abonoCantPromo = [];
				if(!empty($fechas_promociones[0])){
					$fechaPromocion = $fechas_promociones[0];
					$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and promociones.id_campana={$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.id_cliente = {$id} and promociones.id_pedido = {$id_pedido}");

					$promosTomarEnCuenta = "";
					$numIndex = 0;
					foreach ($promociones as $keys) {
						if(!empty($keys['id_promociones'])){
							$promosTomarEnCuenta .= "'".$keys['nombre_promocion']."'";
							$abonoCantPromo[$keys['id_promociones']]['id'] = $keys['id_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['ids'] = $keys['id_promociones'];
							$abonoCantPromo[$keys['id_promociones']]['promocion'] = $keys['nombre_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['costo'] = $keys['precio_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['aprobadas'] = $keys['cantidad_aprobada_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['abonado'] = 0;
							$abonoCantPromo[$keys['id_promociones']]['cantidad'] = 0;
							if($numIndex < (count($promociones)-2)){
								$promosTomarEnCuenta .= ", ";
							}
							$numIndex++;
						}
					}
					$fechaPagoPromocion = $fechaPromocion['fecha_pago_promocion'];
					$pagosPromos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.id_pedido = {$id_pedido} and pagos.tipo_pago IN ({$promosTomarEnCuenta}) and pagos.fecha_pago <= '{$fechaPagoPromocion}'");
					foreach ($pagosPromos as $pagosP) { if(!empty($pagosP['id_pago'])){
						foreach ($promociones as $keys) { if(!empty($keys['id_promociones'])){
							if($pagosP['tipo_pago']==$keys['nombre_promocion']){
								if($pagosP['estado']=="Abonado"){
									$abonoCantPromo[$keys['id_promociones']]['abonado'] += $pagosP['equivalente_pago'];
								}
							}
						} }
					} }

					foreach ($abonoCantPromo as $promos) {
						$nombrePromos = "";
						$nombrePromos = $abonoCantPromo[$promos['ids']]['promocion'];
						$distribucionPromociones = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$id_pedido} and distribucion_pagos.estatus = 1 and distribucion_pagos.tipo_distribucion = '{$nombrePromos}'");
						$distribucionPromoActual = 0;
						foreach ($distribucionPromociones as $dist) {
							if(!empty($dist['id_distribucion_pagos'])){
								$distribucionPromoActual += $dist['cantidad_distribucion'];
							}
						}
						$promoAbonado = 0;
						$promoAbonado += $promos['abonado'];
						$promoAbonado += $distribucionPromoActual;
						$cantidad = ($promoAbonado/$promos['costo']);
						$cantidadFormat = number_format($cantidad, 2, ",",".");
						$cantidadVal = intval($cantidadFormat);
						if($cantidadVal > $abonoCantPromo[$promos['ids']]['aprobadas']){
							$cantidadVal = $abonoCantPromo[$promos['ids']]['aprobadas'];
						}
						$abonoCantPromo[$promos['ids']]['cantidad'] = $cantidadVal;
					}
					$premios_promocion = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana}");
					$productos = $lider->consultarQuery("SELECT * FROM productos, premios_promocion WHERE productos.id_producto = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and productos.estatus = 1");
					$premios = $lider->consultarQuery("SELECT * FROM premios, premios_promocion WHERE premios.id_premio = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and premios.estatus = 1");
				}
			# ==================================================================================

		}

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
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
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$id = $_GET['lider'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");

			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			$numFactura = "";
			if(count($factura)>1){
				$numFactura = $factura[0]['numero_factura'];
				switch (strlen($factura[0]['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura[0]['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura[0]['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura[0]['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura[0]['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura[0]['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura[0]['numero_factura'];
						break;
				}
			}
			

			$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_campana = {$id_campana} and planes_campana.id_campana = {$id_campana} and planes_campana.id_plan = planes.id_plan and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and tipos_colecciones.id_pedido = {$id_pedido} and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");
			// $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
			// print_r($planesCol);
			$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

			$premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
			$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");

			$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");

			$retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

			$canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho} and canjeos.id_cliente = {$id}");

			$canjeosUnic = $lider->consultarQuery("SELECT DISTINCT catalogos.id_catalogo, nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

			$premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA = ''");

			$premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA <> ''");

			$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");

			$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");

			$despacho = $despachos[0];

			// $pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];

			$iterRecor = 0;

			foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
				if($pagosD['tipo_pago_despacho']=="Inicial"){
					// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
					$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'cod'=>'I', 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
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
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
								$iterRecor++;
							}
							if($i == $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
								$iterRecor++;
							}
						}
					}}
				}
			}

			// ========================== // =============================== // ============================== //
			if(count($premios_planes)<2){
				$premios_planes = [];
				$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

				$id_planes_camp = [];
				$nidxp = 0;
				foreach ($pagosRecorridos as $pagosR) {
					if(!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
					}else{
						$id_planes_camp[$nidxp]['id_tipo'] = $pagosR['name'];
						$id_planes_camp[$nidxp]['id_plan'] = 0;
						$nidxp++;
					}
				}
				for ($i=0; $i < count($id_planes_camp); $i++) { 
					foreach ($premios_planes as $key) {
						if(!empty($key['id_plan_campana'])){
							if($id_planes_camp[$i]['id_tipo']==$key['tipo_premio']){
								if($id_planes_camp[$i]['id_plan']==0){
									$id_planes_camp[$i]['id_plan'] = $key['id_plan_campana'];
								}
							}
						}
					}
				}

				$n1 = 0;
				$premios_planes = [];
				foreach ($id_planes_camp as $keys) {
					$id_plan_camp = $keys['id_plan'];
					$tipo_plan_camp = $keys['id_tipo'];
					$newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
					foreach ($newPlan as $nplan) {
						if(!empty($nplan['id_plan_campana'])){
							$premios_planes[$n1] = $nplan;
							$n1++;
						}
					}
				}
			}

			$premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
			$controladorPremios = [];
			$numeroX = 0;
			foreach ($planesCol as $key1) {
				if(!empty($key1['id_plan'])){
					$numeroX2 = 0;
					foreach ($pagosRecorridos as $pagosR) {
						if(!empty($controladorPremios[$numeroX]['plan'])){
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}else{
							$controladorPremios[$numeroX]['id_plan'] = $key1['id_plan'];
							$controladorPremios[$numeroX]['plan'] = $key1['nombre_plan'];
							$controladorPremios[$numeroX]['cantidad_colecciones'] = $key1['cantidad_coleccion'];
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']] = [];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}
						$numeroX2++;
					}
					$numeroX++;
				}
			}
			// print_r($controladorPremios);
			// ========================== // =============================== // ============================== //

			# ==================================================================================
				$fechas_promociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
				$abonoCantPromo = [];
				if(!empty($fechas_promociones[0])){
					$fechaPromocion = $fechas_promociones[0];
					$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and promociones.id_campana={$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.id_cliente = {$id} and promociones.id_pedido = {$id_pedido}");

					$promosTomarEnCuenta = "";
					$numIndex = 0;
					foreach ($promociones as $keys) {
						if(!empty($keys['id_promociones'])){
							$promosTomarEnCuenta .= "'".$keys['nombre_promocion']."'";
							$abonoCantPromo[$keys['id_promociones']]['id'] = $keys['id_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['ids'] = $keys['id_promociones'];
							$abonoCantPromo[$keys['id_promociones']]['promocion'] = $keys['nombre_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['costo'] = $keys['precio_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['aprobadas'] = $keys['cantidad_aprobada_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['abonado'] = 0;
							$abonoCantPromo[$keys['id_promociones']]['cantidad'] = 0;
							if($numIndex < (count($promociones)-2)){
								$promosTomarEnCuenta .= ", ";
							}
							$numIndex++;
						}
					}
					$fechaPagoPromocion = $fechaPromocion['fecha_pago_promocion'];
					$pagosPromos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.id_pedido = {$id_pedido} and pagos.tipo_pago IN ({$promosTomarEnCuenta}) and pagos.fecha_pago <= '{$fechaPagoPromocion}'");
					foreach ($pagosPromos as $pagosP) { if(!empty($pagosP['id_pago'])){
						foreach ($promociones as $keys) { if(!empty($keys['id_promociones'])){
							if($pagosP['tipo_pago']==$keys['nombre_promocion']){
								if($pagosP['estado']=="Abonado"){
									$abonoCantPromo[$keys['id_promociones']]['abonado'] += $pagosP['equivalente_pago'];
								}
							}
						} }
					} }

					foreach ($abonoCantPromo as $promos) {
						$nombrePromos = "";
						$nombrePromos = $abonoCantPromo[$promos['ids']]['promocion'];
						$distribucionPromociones = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$id_pedido} and distribucion_pagos.estatus = 1 and distribucion_pagos.tipo_distribucion = '{$nombrePromos}'");
						$distribucionPromoActual = 0;
						foreach ($distribucionPromociones as $dist) {
							if(!empty($dist['id_distribucion_pagos'])){
								$distribucionPromoActual += $dist['cantidad_distribucion'];
							}
						}
						$promoAbonado = 0;
						$promoAbonado += $promos['abonado'];
						$promoAbonado += $distribucionPromoActual;
						$cantidad = ($promoAbonado/$promos['costo']);
						$cantidadFormat = number_format($cantidad, 2, ",",".");
						$cantidadVal = intval($cantidadFormat);
						if($cantidadVal > $abonoCantPromo[$promos['ids']]['aprobadas']){
							$cantidadVal = $abonoCantPromo[$promos['ids']]['aprobadas'];
						}
						$abonoCantPromo[$promos['ids']]['cantidad'] = $cantidadVal;
					}
					$premios_promocion = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana}");
					$productos = $lider->consultarQuery("SELECT * FROM productos, premios_promocion WHERE productos.id_producto = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and productos.estatus = 1");
					$premios = $lider->consultarQuery("SELECT * FROM premios, premios_promocion WHERE premios.id_premio = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and premios.estatus = 1");
				}
			# ==================================================================================
		}

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus = 1");
		$nume = 0;
		if(count($notas)>1){
			foreach ($notas as $key) {
				if(!empty($key['id_nota_entrega'])){
					if($key['numero_nota_entrega'] > $nume){
						$nume = $key['numero_nota_entrega'];
					}
				}
			}
		}
		$nume++;

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
		// }else{
			    // require_once 'public/views/error404.php';
		// }

	}
}else{
   require_once 'public/views/error404.php';
}
?>