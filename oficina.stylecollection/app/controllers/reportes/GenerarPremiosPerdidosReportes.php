<?php 
	set_time_limit(320);
			require_once'vendor/dompdf/dompdf/vendor/autoload.php';
			use Dompdf\Dompdf;
			$dompdf = new Dompdf();
			if(is_file('app/models/indexModels.php')){
				 	require_once'app/models/indexModels.php';
				 }
				 if(is_file('../app/models/indexModels.php')){
				 	require_once'../app/models/indexModels.php';
				 }

$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
	if(!empty($access['id_acceso'])){
		if($access['nombre_modulo'] == "Reportes"){
	  		$amReportes = 1;
	    	if($access['nombre_permiso'] == "Ver"){
	    		$amReportesC = 1;
	  		}
		}
	}
}
if($amReportesC == 1){

	$id_despacho = $_GET['id'];
	$campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana");
	$campana = $campanas[0];
	$id_campana = $campana['id_campana'];


	if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
		$id = $_GET['lider'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
		$pedido = $pedidos[0];
		$id_pedido = $pedido['id_pedido'];
		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
	}else{
		$id = $_SESSION['id_cliente'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1");
		// print_r($pedidos);
	}

	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
	$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
	$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
	if(count($premios_planes)<2){
		$premios_planes = [];
		$premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
		foreach ($premios_planes2 as $premioplan) {
			if(!empty($premioplan['id_producto'])){
				// echo $premioplan['tipo_premio'];
				if($premioplan['tipo_premio']=="Inicial"){
					$premios_planes[0] = $premioplan;
				}
				if($premioplan['tipo_premio']=="Segundo"){
					$premios_planes[1] = $premioplan;
				}
			}
		}

	}
		$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
		$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
		$despacho = $despachos[0];

		// $pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];
		$iterRecor = 0;
		foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
			if($pagosD['tipo_pago_despacho']=="Inicial"){
				// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
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

		$nombreCampana = $campana['nombre_campana'];
		$numeroCampana = $campana['numero_campana'];
		$anioCampana = $campana['anio_campana'];

		$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
		$accesoBloqueo = "0";
		$superAnalistaBloqueo="1";
		$analistaBloqueo="1";
		foreach ($configuraciones as $config) {
			if(!empty($config['id_configuracion'])){
				if($config['clausula']=='Analistabloqueolideres'){
					$analistaBloqueo = $config['valor'];
				}
				if($config['clausula']=='Superanalistabloqueolideres'){
					$superAnalistaBloqueo = $config['valor'];
				}
			}
		}
		if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
		if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}
		if($accesoBloqueo=="0"){
			// echo "Acceso Abierto";
		}
		if($accesoBloqueo=="1"){
			// echo "Acceso Restringido";
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
		}

			$var = dirname(__DIR__, 3);
				$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
				$urlCss2 = $var . '/public/assets/css/';
				$urlImg = $var . '/public/assets/img/';

			ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
			date_default_timezone_set('america/caracas');

		$info = "
			<!DOCTYPE html>
			<html>
			<head>
				<style>*{font-size:0.98em;color:#434343;font-family:'Helvetica';} h2,h3{color:#656565;} th{font-size:0.82em;} .cellTam1{font-size:0.7em;} .cellTam2{font-size:0.8em;}</style>
				<title>Premios Perdidos de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
			</head>
			<body>
			<style>
			body{
				font-family:'arial';
			}
			</style>
			<div class='row' style='padding:0;margin:0;'>
				<div class='col-xs-12'  style='width:100%;'>

						<h3 style='text-align:right;float:right;'><small>StyleCollection-".$nombreCampana."</small></h3>
						<h2 style='font-size:1.2em;'> Premios Perdidos - Campaña ".$numeroCampana."/".$anioCampana."</h2>
						<br>
				";		

					$info .= "<table class='table  text-center' style='font-size:1.2em;width:110%;position:relative;left:-5%;'>
						<thead style='background:#efefef55;font-size:1.05em;'>
							<tr class='text-center'>
								<th style='width:8%;'>Nº</th>
								<th style='width:22%;'>Lider</th>
								<th style='width:20%;'>Colecciones</th>
								<th style='width:20%;'>Planes Seleccionado</th>
								<th style='width:40%;'>Premios Perdidos</th>
							</tr>
						</thead>
						<tbody>";
							$planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
							$premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

							$num = 1; 
							$acumColecciones = 0;
							$totalesPremios = [];
							foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
								$permitido = "0";
								if($accesoBloqueo=="1"){
									if(!empty($accesosEstructuras)){
										foreach ($accesosEstructuras as $struct) {
											if(!empty($struct['id_cliente'])){
												if($struct['id_cliente']==$data['id_cliente']){
													$permitido = "1";
												}
											}
										}
									}
								}else if($accesoBloqueo=="0"){
									$permitido = "1";
								}

								if($permitido=="1"){
									if($data['cantidad_aprobado']>0){
										$info .= "<tr class='elementTR'>
											<td style='width:10%;' class='cellTam1'>".$num."</td>
											<td style='width:20%;' class='cellTam1'>
												".number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']." <br> ".$data['cantidad_aprobado']." Colecciones Aprobadas
											</td>
											<td style='width:70%;text-align:justify;' class='cellTam2' colspan='3'>
												<table class='table table-striped table-hover' style='width:100%;background:none'>";
													foreach ($pagosRecorridos as $pagosR){
														if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
															foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){ 
																if ($data['id_pedido'] == $data2['id_pedido']){
																	if ($data2['cantidad_coleccion_plan']>0){
																		$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
																		$info .= "<tr>
																			<td style='text-align:left;width:25%'>";
																				$colss = ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']);
																				$acumColecciones += $colss;
																				$info .= $colss." Colecciones
																			</td>
																			<td style='text-align:left;width:25%'>".
																				$data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."<br>"; 
																				//$acumPlanes[$data2['nombre_plan']] += $data2['cantidad_coleccion_plan'];
																				if(!empty($totalesPremios[$data2['nombre_plan']]['colecciones'])){
																					$totalesPremios[$data2['nombre_plan']]['colecciones'] += $data2['cantidad_coleccion_plan'];
																				}else{
																					$totalesPremios[$data2['nombre_plan']]['colecciones'] = $data2['cantidad_coleccion_plan'];
																				}
																			$info .= "</td>
																			<td style='width:50%;'>
																				<table style='width:100%;background:none'> 
																					<tr>";
																						$porcentSelected = 0;
																						$porcentPerdido = 0;
																						$porcentResul = 0;
																						$info .= "<td style='text-align:left;'>";
																							foreach ($premios_perdidos as $dataperdidos) {
																								if(!empty($dataperdidos['id_premio_perdido'])){
																									if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																										$perdidos = $dataperdidos['cantidad_premios_perdidos'];
																										// for ($i=0; $i < count($acumPremios); $i++) { 
																										// 	if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
																										// 		$acumPremios[$i]['cantidad'] += $perdidos;
																										// 	}
																										// }
																										foreach ($premios_planes as $planstandard){
																											if ($planstandard['id_plan_campana']){
																												if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
																													if ($planstandard['tipo_premio']==$pagosR['name']){
																														$info .= "<table style='width:100%;'>
																															<tr>
																																<td style='text-align:left;'>".
																																	$perdidos." ".$planstandard['producto']."
																																</td>
																																<td style='text-align:right;'>";
																																	$porcentSelected = $data2['cantidad_coleccion_plan'];
																																	$porcentPerdido = $perdidos;
																																	$porcentResul = ($porcentPerdido/$porcentSelected)*100;
																																	if(!empty($totalesPremios[$data2['nombre_plan']][$planstandard['producto']])){
																																		$totalesPremios[$data2['nombre_plan']][$planstandard['producto']]['cantidad'] += $perdidos;
																																	}else{
																																		$totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
																																		$totalesPremios[$data2['nombre_plan']][$planstandard['producto']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$perdidos];
																																	}
																																	$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
																																</td>
																															</tr>
																														</table>";
																													}
																												}
																											}
																										}
																									}
																								}
																							}
																						$info .= "</td>
																					</tr>";
																					// $info .= "<tr><td colspan='5'><hr style='color:#DDD'></td></tr>";
																					$nx=0;
																					foreach ($premioscol as $data3){ if(!empty($data3['id_premio'])){
																						if ($data3['id_plan']==$data2['id_plan']){
																							if ($data['id_pedido']==$data3['id_pedido']){
																								$totalesPremios[$data2['nombre_plan']]['premios'][$nx] = $data3['nombre_premio'];
																								$nx++;
																								if($data3['cantidad_premios_plan']>0){
																									$info .= "<tr>";
																										$porcentSelected = 0;
																										$porcentPerdido = 0;
																										$porcentResul = 0;
																										$info .= "<td style='text-align:left;'>";
																											foreach ($premios_perdidos as $dataperdidos) {
																												if(!empty($dataperdidos['id_premio_perdido'])){
																													if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
																														$perdidos = $dataperdidos['cantidad_premios_perdidos'];
																														// for ($i=0; $i < count($acumPremios); $i++) { 
																														// 	if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
																														// 		for ($j=0; $j < count($acumPremios[$i]['premio']); $j++) { 
																														// 			if($acumPremios[$i]['premio'][$j]['nombre']==$data3['nombre_premio']){
																														// 				$acumPremios[$i]['premio'][$j]['cantidad'] += $perdidos;
																														// 			}
																														// 		}
																														// 	}
																														// }
																														$info .= "<table style='width:100%;'>
																															<tr>
																																<td style='text-align:left;'>".
																																	$perdidos." ".$data3['nombre_premio']."
																																</td>
																																<td style='text-align:right;'>";
																																	$porcentSelected = $data3['cantidad_premios_plan'];
																																	$porcentPerdido = $perdidos;
																																	$porcentResul = ($porcentPerdido/$porcentSelected)*100;
																																	if(!empty($totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']])){
																																		$totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']]['cantidad'] += $perdidos;
																																	}else{
																																		$totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
																																		$totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$perdidos];
																																	}
																																	$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
																																</td>
																															</tr>
																														</table>";
																													}
																												}
																											}
																										$info ."</td>
																									</tr>";
																									// $info .= "<tr><td colspan='5'><hr style='color:#DDD'></td></tr>";
																								}
																							}
																						}
																					} }
																				$info .= "</table>
																			</td>
																		</tr>";
																	}
																}
															} }
														}else{
															$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
															$info .= "<tr>
																<td style='text-align:left;'>".
																	$data['cantidad_aprobado']." Colecciones<br>
																</td>
																<td style='text-align:left;'>".
																	$data['cantidad_aprobado']." Premios de ".$pagosR['name']."<br>";
																	if(!empty($totalesPremios[$pagosR['name']]['colecciones'])){
																		$totalesPremios[$pagosR['name']]['colecciones'] += $data['cantidad_aprobado'];
																	}else{
																		$totalesPremios[$pagosR['name']]['colecciones'] = $data['cantidad_aprobado'];
																	}
																$info .= "</td>
																<td style='width:50%;'>
																	<table class='' style='width:100%;background:none'> 
																		<tr>";
																		$porcentSelected = 0;
																		$porcentPerdido = 0;
																		$porcentResul = 0;
																		$info .= "<td style='text-align:left;'>";
																			foreach ($premios_perdidos as $dataperdidos) {
																				if(!empty($dataperdidos['id_premio_perdido'])){
																					if(($dataperdidos['valor'] == $pagosR['id']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																						$perdidos = $dataperdidos['cantidad_premios_perdidos'];
																						foreach ($premios_planes as $planstandard){
																							if ($planstandard['id_plan_campana']){
																								if ($planstandard['tipo_premio']==$pagosR['name']){
																									$info .= "<table style='width:100%;'>
																										<tr>
																											<td style='text-align:left;'>".
																												$perdidos." ".$planstandard['producto']."
																											</td>
																											<td style='text-align:right;'>";
																												$porcentSelected = $data['cantidad_aprobado'];
																												$porcentPerdido = $perdidos;
																												$porcentResul = ($porcentPerdido/$porcentSelected)*100;
																												if(!empty($totalesPremios[$pagosR['name']][$planstandard['producto']])){
																													$totalesPremios[$pagosR['name']][$planstandard['producto']]['cantidad'] += $perdidos;
																												}else{
																													$totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
																													$totalesPremios[$pagosR['name']][$planstandard['producto']] = ['id'=>$pagosR['id'], 'name'=>$pagosR['name'], 'cantidad'=>$perdidos];
																												}
																												$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
																											</td>
																										</tr>
																									</table>";
																								}
																							}
																						}
																					}
																				}
																			}
																		$info .= "</td>
																		</tr>
																	</table>
																</td>
															</tr>";
														}
													}


													$info .= "
												</table>
											</td>
										</tr>";
										$info .= "<tr><td colspan='5' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
										$num++;
									}
								}
							} }

							

							$info .= "<tr style='background:#EDEDED'>
								<td></td>
								<td></td>
								<td style='text-align:left;' class='cellTam2'>".$acumColecciones." Colecciones</td>
								<td colspan='2' style='text-align:left;width:70%;' class='cellTam2'>
									<table class='table table-hover' style='width:100%;background:none;'>";
										foreach ($pagosRecorridos as $pagosR){
											if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
												foreach ($planes as $plan){
													if (!empty($plan['nombre_plan'])){
														if(!empty($totalesPremios[$plan['nombre_plan']]['colecciones'])){
															if($totalesPremios[$plan['nombre_plan']]['colecciones']>0){
																$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
																$info .= "<tr>
																	<td style='text-align:left;width:31%;'>".
																		$totalesPremios[$plan['nombre_plan']]['colecciones']." Plan ".$plan['nombre_plan']."<br>
																	</td>
																	<td style='text-align:left;width:64%;'>";
																		if ($plan['nombre_plan']=="Standard"){
																			foreach ($premios_planes as $planstandard){
																				if ($planstandard['id_plan_campana']){
																					if ($plan['nombre_plan'] == $planstandard['nombre_plan']){
																						if ($planstandard['tipo_premio']==$pagosR['name']){
																							foreach ($totalesPremios as $key) {
																								if(!empty($key['name']) && $key['name'] == $plan['nombre_plan']){
																									if(!empty($key[$planstandard['producto']])){
																										$cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
																										//if($key['cantidad']>0){
																											$info .= "<table style='width:100%;'>
																												<tr>
																													<td style='text-align:left;'>".
																														$cantidadMostrar." ".$planstandard['producto']."
																													</td>
																													<td style='text-align:right;'>";
																														$totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
																														$totPerdido = $cantidadMostrar;
																														$totResul = ($totPerdido/$totSelected)*100;
																														$info .= "<b>".number_format($totResul,2,',','.')."%</b>
																													</td>
																												</tr>
																											</table>";
																										//}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}else{
																			foreach ($totalesPremios as $key){
																				if (!empty($key['name']) && $plan['nombre_plan']==$key['name']){
																					if(!empty($key['premios'])){
																						$premios = $key['premios'];
																						foreach ($premios as $nombrePremio){
																							if(!empty($key[$nombrePremio])){
																								$cantidadMostrar = $key[$nombrePremio]['cantidad'];
																								//if ($prem2['cantidad']>0){
																									$info .= "<table style='width:100%;'>
																										<tr>
																											<td style='text-align:left;'>".
																												$cantidadMostrar." ".$nombrePremio."
																											</td>
																											<td style='text-align:right;'>";
																												$totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
																												$totPerdido = $cantidadMostrar;
																												$totResul = ($totPerdido/$totSelected)*100;
																												$info .= "<b>".number_format($totResul,2,',','.')."%</b>
																											</td>
																										</tr>
																									</table>";
																								//}
																							}
																						}
																					}
																				}
																			}
																		}
																	$info .= "</td>
																</tr>";
															}
														}
													}
												}
											}else{
												$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
												$info .= "<tr>
													<td style='text-align:left;'>".
														$acumColecciones." Premios de ".$pagosR['name']."
													</td>
													<td style=text-align:left;>";
														foreach ($premios_planes as $planstandard){
															if ($planstandard['id_plan_campana']){
																if ($planstandard['tipo_premio']==$pagosR['name']){
																	foreach ($totalesPremios as $key) {
																		if(!empty($key['name']) && $key['name'] == $planstandard['tipo_premio']){
																			if(!empty($key[$planstandard['producto']])){
																				$cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
																				//if($cantidadMostrar>0){
																					$info .= "<table style='width:100%;'>
																						<tr>
																							<td style='text-align:left;'>".
																								$cantidadMostrar." ".$planstandard['producto']."
																							</td>
																							<td style='text-align:right;'>";
																								$totSelected = $acumColecciones;
																								$totPerdido = $cantidadMostrar;
																								$totResul = ($totPerdido/$totSelected)*100;
																								$info .= "<b>".number_format($totResul,2,',','.')."%</b>
																							</td>
																						</tr>
																					</table>";
																				//}
																			}
																		}
																	}
																}
															}
														}
													$info .= "</td>
												</tr>";
											}
										}
									$info .= "</table>
								</td>
							</tr>";

						$info .= "</tbody>
					</table>
						
						<div class='row'>
							<div class='col-xs-12'>
							</div>
						</div>
					  ";
							

				$info .= "</div>
			</div><br>
			</body>
			</html>
			";


					// $dompdf->loadHtml( file_get_contents( 'public/views/home.php' ) );
					// $dompdf->loadHtml($file);
					//$dompdf->setPaper('A4', 'landscape'); // para contenido en pagina de lado

					// top:30%;left:33%; || para A4 y para MEDIA CARTA
					// top:35%;left:25%; || para pagina carta normal

					//$ancho = 616.56;
					//$alto = 842.292;

					//$dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta original
					// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
					
					// $pgl1 = 96.001;
					// $ancho = 528.00;
					// $alto = 816.009;
					// $altoMedio = $alto / 2;

			$dompdf->loadHtml($info);
			$dompdf->render();
			$dompdf->stream("Premios Perdidos de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
  require_once 'public/views/error404.php';
}
?>