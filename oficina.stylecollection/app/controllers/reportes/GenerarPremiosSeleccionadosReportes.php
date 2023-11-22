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
	$clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
	$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC;");

	$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

	$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");

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

	$nombreCampana = $pedidosClientes[0]['nombre_campana'];
	$numeroCampana = $pedidosClientes[0]['numero_campana'];
	$anioCampana = $pedidosClientes[0]['anio_campana'];

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
				<title>Planes y Premios Seleccionados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
			</head>
			<body>
			<style>
			body{
				font-family:'arial';
			}
			</style>
			<div class='row' style='padding:0;margin:0;'>
				<div class='col-xs-12'  style='width:100%;'>

						<h3 style='text-align:right;float:right;'><small>StyleCollection- ".$nombreCampana."</small></h3>
						<h2 style='font-size:1.2em;'> Planes y Premios Seleccionados - Campaña ".$numeroCampana."/".$anioCampana."</h2>
						<br>
				";		

					$info .= "<table class='table  text-center' style='font-size:1.2em;width:110%;position:relative;left:-5%;'>
								<thead style='background:#efefef55;font-size:1.05em;'>
									<tr class='text-center'>
										<th style='width:8%;'>Nº</th>
										<th style='width:22%;'>Lider</th>
										<th style='width:20%;'>Colecciones</th>
										<th style='width:20%;'>Planes Seleccionado</th>
										<th style='width:40%;'>Premios Seleccionado</th>
									</tr>
								</thead>
								<tbody> ";
									$num = 1;
									foreach ($pedidosClientes as $data){ if(!empty($data['id_pedido'])){
                  	foreach ($clientess as $data2){ if(!empty($data2['id_cliente'])){
                  		if($data['id_cliente'] == $data2['id_cliente']){
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
														$info .= "<tr class='text-center'>
															<td style='width:8%;' class='cellTam1'>".$num."</td>
															<td style='width:22%;' class='cellTam1'>
																".number_format($data2['cedula'],0,'','.')."<br>".$data2['primer_nombre']." ".$data2['primer_apellido']."<br>
																".$data['cantidad_aprobado']." Colecciones<br>Aprobadas"."

															</td>
															
															<td style='width:70%;text-align:justify;' colspan='3' class='cellTam2'>
																<table class='table' style='background:none;width:100%;'>";
																	foreach ($pagosRecorridos as $pagosR){
																		if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
																			foreach ($planesCol as $data3){ if(!empty($data3['id_cliente'])){
																				if ($data2['id_cliente'] == $data3['id_cliente']){
																					if ($data3['cantidad_coleccion_plan']>0){
																						$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
																						$info .= "<tr >
																							<td style='width:30%;text-align:left;'>                                            
																								".($data3['cantidad_coleccion']*$data3['cantidad_coleccion_plan'])." Colecciones 
																							</td>
																							<td style='width:30%;text-align:left;'>
																								".$data3['cantidad_coleccion_plan']." Plan ".$data3['nombre_plan']."
																								<br>                                                
																							</td>
																							<td style='width:40%;text-align:left;'>
																								<table class='' style='background:none'>"; 
																									$colsss = ($data3['cantidad_coleccion']*$data3['cantidad_coleccion_plan']);
																									$sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$data3['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
																									$tempPlanes = $lider->consultarQuery($sql0);
																									$nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
																									$namePlanesTemp = $data3['nombre_plan'];
																									$sql1 = "";
																									$cantTxtPrem = 0;
																									$namecantTxtPrem = "";
																									$nameTxtPrem = "";
																									if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){
																										$sql1 = "SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = '{$nameTPlanesTemp}' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
																										$nameTxtPrem = "producto";
																									}
																									if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Premios")){
																										$sql1 = "SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and planes.nombre_plan = '{$namePlanesTemp}' and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_pedido = {$data['id_pedido']}";
																										$namecantTxtPrem = "cantidad_premios_plan";
																										$nameTxtPrem = "nombre_premio";
																									}
																									if($sql1!=""){
																										$premios_planes_seleccionados = $lider->consultarQuery($sql1);
																										foreach ($premios_planes_seleccionados as $dataPrem) {
																											if(!empty($dataPrem['id_plan_campana'])){
																												if($namecantTxtPrem==""){
																													$cantTxtPrem = $colsss;
																												}else{
																													$cantTxtPrem = $dataPrem[$namecantTxtPrem];
																												}
																												if($cantTxtPrem>0){
																													$info .= "<tr>
																														<td style='text-align:left;'>
																															(".$cantTxtPrem.") ".$dataPrem[$nameTxtPrem]."<br>
																														</td>
																													</tr>";
																												}
																											}
																										}
																									}

																									// foreach ($premios_planes as $planstandard){
																									// 	if ($planstandard['id_plan_campana']){
																									// 		if ($data3['nombre_plan'] == $planstandard['nombre_plan']){
																									// 			if ($planstandard['tipo_premio']==$pagosR['name']){
																									// 				$info .= "<tr>
																									// 					<td style='text-align:left;'>
																									// 						".$data3['cantidad_coleccion_plan']." ".$planstandard['producto']."<br>
																									// 					</td>
																									// 				</tr>";
																									// 			}
																									// 		}
																									// 	}
																									// }

																									// foreach ($premioscol as $data4){ if(!empty($data4['id_premio'])){
																									// 	if ($data4['id_plan']==$data3['id_plan']){
																									// 		if ($data['id_pedido']==$data4['id_pedido']){
																									// 			if($data4['cantidad_premios_plan']>0){
																									// 				$info.= "<tr>
																									// 					<td style='text-align:left;'>
																									// 						".$data4['cantidad_premios_plan']." ".$data4['nombre_premio']."<br>
																									// 					</td>
																									// 				</tr>";
																									// 			}
																									// 		}
																									// 	}
																									// } } 
																								$info .= "</table>
																							</td>
																						</tr>";
																					}
																				}
																			} }
																		}
																	}
																$info .= "</table></td>
														</tr>";
														$info .= "<tr><td colspan='5' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
													}
												}
											$num++;
											}
									} }
								} }
					$info .= "				
							</tbody>
						</table>
						
						<div class='row'>
							<div class='col-xs-12'>

							
								

							</div>
						</div>
					  ";
							
							    //<span class='string'>Copyright &copy; 2021-2022 <b>Style Collection</b>.</span> <span class='string'>Todos los derechos reservados.</span>
							//<h2>tengo mucha hambre, y sueño, aparte tengo que hacer muchas cosas lol jajaja xd xd xd xd xd xd xd xd hangria </h2>
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
			try {
				$pgl1 = 96.001;
				$ancho = 528.00;
				$alto = 816.009;
				// echo $info;
				$dompdf->loadHtml($info);
				$altoMedio = $alto / 2;
				$dompdf->render();
				$dompdf->stream("Planes y Premios Seleccionados de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			} catch (Exception $e) {
				print_r($e);
			}
			// echo $info;
}else{
  require_once 'public/views/error404.php';
}
?>