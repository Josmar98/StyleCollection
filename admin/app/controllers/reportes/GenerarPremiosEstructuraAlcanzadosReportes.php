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
function consultarEstructura($id_c, $id_despacho, $lider){
  // $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE pedidos.id_cliente = clientes.id_cliente and clientes.id_lider = $id_c");

  $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");
  if(Count($lideres)>1){
    foreach ($lideres as $lid) {
      if(!empty($lid['id_cliente'])){
        $_SESSION['ids_general_estructura'][] = $lid;
        consultarEstructura($lid['id_cliente'], $id_despacho, $lider);
      }
    }
  }
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
      $campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho");
      $campana = $campanas[0];
      $id_campana = $campana['id_campana'];
      // print_r($campanas);
      $id_cliente = $_GET['lider'];
        $clientee = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$id_cliente}");
        // $clientee = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id_cliente");
        $_SESSION['ids_general_estructura'] = [];
        $nombreReport = "";
        if(count($clientee)>1){
	        $cliente1 = $clientee[0];
			$nombreReport = $cliente1['primer_nombre']." ".$cliente1['primer_apellido'];
	        $_SESSION['ids_general_estructura'][] = $cliente1;
	        consultarEstructura($id_cliente, $id_despacho, $lider);
        }
        $nuevosClientes = $_SESSION['ids_general_estructura'];

      // if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
      //   $id = $_GET['lider'];
      //   $pedido = $pedidos[0];
      //   $id_pedido = $pedido['id_pedido'];
      //   $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
      // }else{
      //   $id = $_SESSION['id_cliente'];
      //   $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
        $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1");
      // // print_r($pedidos);
      // }

      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
      $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");
      $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho");

      $retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
        
        $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

        $canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana}");

        $canjeosUnic = $lider->consultarQuery("SELECT DISTINCT nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana}");


        $arrayt2 = [];
        $numCC2 = 0;
        foreach ($canjeosUnic as $canUnic) {
          if(!empty($canUnic['nombre_catalogo'])){
            $arrayt2[$numCC2]['nombre'] = $canUnic['nombre_catalogo'];
            $arrayt2[$numCC2]['cantidad'] = 0;
            $numCC2++;
          }
        }


	$nombreCampana = $campana['nombre_campana'];
	$numeroCampana = $campana['numero_campana'];
	$anioCampana = $campana['anio_campana'];

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
		<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
		<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
		<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
			<link rel='shortcut icon' type='image/k-icon' href='public/assets/img/icon.jpg' class='img-circle'>
		<title>Premios Alcanzados (Estructura de {$nombreReport}) - Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
		
	</head>
	<body>
	<style>
	body{
		font-family:'arial';
	}
	</style>
	<div class='row' style='padding:0;margin:0;'>
		<div class='col-xs-12'  style='width:100%;'>
			<h3 style='text-align:right;float:right;'><small>StyleCollection- ".$nombreCampana."</small></h3><br>
			<h2 style='font-size:1.9em;'> Premios Alcanzados (Estructura de {$nombreReport}) - Campaña ".$numeroCampana."/".$anioCampana."</h2>
			<br>
		";		

		$info .= "<table class='table  text-center' style='font-size:1.2em;width:110%;position:relative;left:-5%;'>
					<thead style='background:#efefef55;font-size:1.05em;'>
						<tr class='text-center'>
							<th style='width:8%;'>Nº</th>
							<th style='width:22%;'>Lider</th>
							<th style='width:20%;'>Colecciones</th>
							<th style='width:20%;'>Planes Seleccionado</th>
							<th style='width:40%;'>Premios Alcanzados</th>
						</tr>
					</thead>
					<tbody> ";
						$planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
						$premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
						$num = 1; 
						$acumColecciones = 0;
						$nume = 1;
						$acumPremios[0]['plan'] = "Inicial";
						$acumPremios[0]['cantidad'] = 0;
						if(count($planes)>1){
							foreach ($planes as $plan) {
								if(!empty($plan['nombre_plan'])){
									$nume2 = 0;
									$acumPlanes[$plan['nombre_plan']]=0;
									$acumPremios[$nume]['plan'] = $plan['nombre_plan'];
									if($plan['nombre_plan']=='Standard'){
										$acumPremios[$nume]['cantidad'] = 0;
									}
									if(count($premios)>1){
										foreach ($premios as $premio) {
											if(!empty($premio['nombre_premio'])){
												if($plan['id_plan'] == $premio['id_plan']){
													$acumPremios[$nume]['premio'][$nume2]['nombre'] = $premio['nombre_premio'];
													$acumPremios[$nume]['premio'][$nume2]['cantidad'] = 0;
													$nume2++;
												}
											}
										}
									}
									$nume++;
								}
							}
						}

						$acumPremios[$nume]['plan'] = "Segundo";
						$acumPremios[$nume]['cantidad'] = 0;
						$acumRetos;
						$numb = 0;
						foreach ($retosCamp as $ret) {
							if(!empty($ret['id_premio'])){
								$acumRetos[$numb]['nombre'] = $ret['nombre_premio'];
								$acumRetos[$numb]['cantidad'] = 0;
								$numb++;
							}
						}
                
							$num = 1;
							foreach ($nuevosClientes as $data): if(!empty($data['id_pedido'])):
						$info .= "<tr class='text-center'>
								<td style='width:8%;'>".$num."</td>
								<td style='width:22%;'>
									".number_format($data['cedula'],0,'','.')."<br>".$data['primer_nombre']." ".$data['primer_apellido']."<br>
									".$data['cantidad_aprobado']." Colecciones<br>Aprobadas"."

								</td>
								
								<td style='width:70%;text-align:justify;' colspan='3'>
									<table class='table' style='background:none;'>
										<tr>
		                                    <td style='text-align:left;'>
		                                        ".$data['cantidad_aprobado']." Colecciones<br>
		                                    </td>
		                                    <td style='text-align:left;'>
		                                        ".$data['cantidad_aprobado']." Premios de Inicial<br>
		                                    </td>
		                                    <td style='width:50%;'>
		                                      <table class='' style='background:none'> 
		                                          <tr>
		                                            <td style='text-align:left;'>";
													foreach ($premios_perdidos as $dataperdidos) {
														if(!empty($dataperdidos['id_premio_perdido'])){
															if(($dataperdidos['valor'] == 'Inicial') && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																$alcanzados = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];

																for ($i=0; $i < count($acumPremios); $i++) { 
																	if($acumPremios[$i]['plan'] == $dataperdidos['valor']){
																		$acumPremios[$i]['cantidad'] += $alcanzados;
																	}
																}
																foreach ($premios_planes as $planstandard):
																	if ($planstandard['id_plan_campana']):
																		if ($dataperdidos['valor'] == $planstandard['tipo_premio']):
																	$info .= $alcanzados." ".$planstandard['producto']."<br>";
																		endif;
																	endif;
																endforeach;
															}
														}
													}
											$info .= "</td>
		                                          </tr>
		                                      </table>
		                                    </td>
		                                  </tr>";

	                              foreach ($planesCol as $data2): if(!empty($data2['id_cliente'])):
	                                  if ($data['id_cliente'] == $data2['id_cliente']):
	                                      if ($data2['cantidad_coleccion_plan']>0):
								$info .= "<tr >
											<td style='width:30%;text-align:left;'>";
												$colss = ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']);
                                          		$acumColecciones += $colss;

											$info .= $acumColecciones." Colecciones 
											</td>
											<td style='width:30%;text-align:left;'>";
												$info .=$data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."<br>";
												$acumPlanes[$data2['nombre_plan']] += $data2['cantidad_coleccion_plan'];
										$info .= "</td>
											<td style='width:40%;text-align:left;'>

												<table class='' style='background:none'>
													<tr>
														<td style='text-align:left;'>";
														foreach ($premios_perdidos as $dataperdidos) {
															if(!empty($dataperdidos['id_premio_perdido'])){
																if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																$alcanzados = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                                
                                                                for ($i=0; $i < count($acumPremios); $i++) { 
                                                                  if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
                                                                    $acumPremios[$i]['cantidad'] += $alcanzados;
                                                                  }
                                                                }
                                                                foreach ($premios_planes as $planstandard):
                                                                  if ($planstandard['id_plan_campana']):
                                                                      if ($data2['nombre_plan'] == $planstandard['nombre_plan']):
                                                                        if ($planstandard['tipo_premio']=="Primer"):
																			$info .= $alcanzados." ".$planstandard['producto']."<br>";
                                                                        endif;
                                                                      endif;
                                                                  endif;
                                                                endforeach;
                                                            }
                                                          }
                                                        }


											$info .= " </td>
													</tr>

												"; 
													foreach ($premioscol as $data3): if(!empty($data3['id_premio'])):
														if ($data3['id_plan']==$data2['id_plan']):
															if ($data['id_pedido']==$data3['id_pedido']):
																if($data3['cantidad_premios_plan']>0):
											$info.= "<tr>
														<td style='text-align:left;'>";
														foreach ($premios_perdidos as $dataperdidos) {
															if(!empty($dataperdidos['id_premio_perdido'])){
																if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
																	$alcanzados = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
																		for ($i=0; $i < count($acumPremios); $i++) { 
																			if($acumPremios[$i]['plan'] == $data2['nombre_plan']){
																				for ($j=0; $j < count($acumPremios[$i]['premio']); $j++) { 
																					if($acumPremios[$i]['premio'][$j]['nombre']==$data3['nombre_premio']){
																						$acumPremios[$i]['premio'][$j]['cantidad'] += $alcanzados;
																					}
																				}
																			}
																		}
																	$info .= $alcanzados." ".$data3['nombre_premio']."<br>";
																}
															}
														}

											$info .= " </td>
													</tr>";
																endif;
															endif;
														endif;
													endif; endforeach;


										$info .= "</table>
											</td>
										</tr>";
	                                      endif;
	                                  endif;
	                              endif; endforeach;
	                       $info .= "	<tr>
		                                    <td style='text-align:left;'>
		                                        ".$data['cantidad_aprobado']." Colecciones<br>
		                                    </td>
		                                    <td style='text-align:left;'>
		                                        ".$data['cantidad_aprobado']." Premios de Segundo <br>
		                                    </td>
		                                    <td style='width:50%;'>
		                                      <table class='' style='background:none'> 
		                                          <tr>
		                                            <td style='text-align:left;'>";
													foreach ($premios_perdidos as $dataperdidos) {
														if(!empty($dataperdidos['id_premio_perdido'])){
															if(($dataperdidos['valor'] == 'Segundo') && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																$alcanzados = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];

																for ($i=0; $i < count($acumPremios); $i++) { 
																	if($acumPremios[$i]['plan'] == $dataperdidos['valor']){
																		$acumPremios[$i]['cantidad'] += $alcanzados;
																	}
																}
																foreach ($premios_planes as $planstandard):
																	if ($planstandard['id_plan_campana']):
																		if ($dataperdidos['valor'] == $planstandard['tipo_premio']):
																	$info .= $alcanzados." ".$planstandard['producto']."<br>";
																		endif;
																	endif;
																endforeach;
															}
														}
													}
											$info .= "</td>
		                                          </tr>
		                                      </table>
		                                    </td>
										</tr>
										<tr>
		                                    <td style='text-align:left;'>
		                                      ".$data['cantidad_aprobado']." Colecciones
		                                    </td>
		                                    <td style='text-align:left;'>
		                                      Retos Solicitados
		                                    </td>
		                                    <td style='text-align:left;'>";
											foreach ($retos as $reto):
												if (!empty($reto['id_reto'])):
													if ($reto['id_pedido']==$data['id_pedido']):
														if ($reto['cantidad_retos']):
															$info .= $reto['cantidad_retos']." ".$reto['nombre_premio']."<br>";
															for ($i=0; $i < count($acumRetos); $i++) {
																if($acumRetos[$i]['nombre']==$reto['nombre_premio']){
																	$acumRetos[$i]['cantidad'] += $reto['cantidad_retos'];
																} 
															}
														endif;
													endif;
												endif;
											endforeach;
								$info .= "</td>
										</tr>";
										$liddd = 0;
										foreach ($canjeos as $canje){
											if (!empty($canje['id_cliente'])){
												if ($canje['id_cliente']==$data['id_cliente']){
													$liddd = 1;
												}
											}
										}
										if ($liddd == "1"){
										$info .= "
										<tr>
											<td></td>
											<td style='text-align:left;'>Premios Canjeados</td>
											<td style='text-align:left;'>";
											$arrayt = [];
											$numCC = 0;
											foreach ($canjeosUnic as $canUnic) {
												if(!empty($canUnic['nombre_catalogo'])){
													$arrayt[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
													$arrayt[$numCC]['cantidad'] = 0;
													$numCC++;
												}
											}
											foreach ($canjeos as $canje){
												if (!empty($canje['id_cliente'])){
													if ($canje['id_cliente']==$data['id_cliente']){
														for ($i=0; $i < count($arrayt); $i++) { 
															if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
																$arrayt[$i]['cantidad']++;
															}
														}
														for ($i=0; $i < count($arrayt2); $i++) { 
															if($canje['nombre_catalogo']==$arrayt2[$i]['nombre']){
																$arrayt2[$i]['cantidad']++;
															}
														}
													}
												}
											}
											foreach ($arrayt as $arr) {
												if($arr['cantidad']>0){
													$info .= $arr['cantidad']." ".$arr['nombre']."<br>";
												}
											}

		                                  	$info .= "
			                                    </td>
			                                  </tr>";
			                              }
			                        $info .= " 
	                       			</table></td>

							</tr>";
								$num++;
						endif; endforeach;





				$info .= " <tr style='background:#CCc'>
								<td></td>
								<td></td>
								<td style='text-align:left;'>".$acumColecciones." Colecciones</td>
								<td colspan='2' style='text-align:left;'>
									<table class='table table-hover' style='width:100%;background:none;'>
										<tr>
											<td style='text-align:left;'>
												".$acumColecciones." Premios de Inicial
											</td>
											<td style='text-align:left;'>";
											
											foreach ($premios_planes as $planstandard):
												if ($planstandard['id_plan_campana']):
													if ($planstandard['tipo_premio']=='Inicial'):
														foreach ($acumPremios as $key) {
															if($key['plan'] == $planstandard['tipo_premio']){
																if($key['cantidad']>0){
															$info .= $key['cantidad']." ".$planstandard['producto']."<br>";
																}
															}
														}
													endif;
												endif;
											endforeach;
										$info .= "
											</td>
										</tr>";
	                             
							foreach ($planes as $plan):
								if (!empty($plan['nombre_plan'])):
									if($acumPlanes[$plan['nombre_plan']]>0){
									$info .= "
										<tr>
											<td style='text-align:left;width:31%;'>
												".$acumPlanes[$plan['nombre_plan']]." Plan ".$plan['nombre_plan']."<br>
											</td>
											<td style='text-align:left;width:64%;'>";
												if ($plan['nombre_plan']=='Standard'):
													foreach ($premios_planes as $planstandard):
														if ($planstandard['id_plan_campana']):
															if ($plan['nombre_plan'] == $planstandard['nombre_plan']):
																if ($planstandard['tipo_premio']=='Primer'):
																	foreach ($acumPremios as $key) {
																		if($key['plan'] == $plan['nombre_plan']){
																			if($key['cantidad']>0){
																		$info .= $key['cantidad']." ".$planstandard['producto']."<br>";
																			}
																		}
																	}
																endif;
															endif;
														endif;
													endforeach;
												else:
													foreach ($acumPremios as $prem):
														if ($plan['nombre_plan']==$prem['plan']):
															foreach ($prem['premio'] as $prem2):
																if ($prem2['cantidad']>0):
															$info .= $prem2['cantidad']." ".$prem2['nombre']."<br>";
																endif;
															endforeach;
														endif;
													endforeach;
	                                          endif;
	                                          $info .= "
											</td>
										</tr>";
	                              			}
	                                  endif;
	                              endforeach;
	                              	$info .= "
										<tr>
											<td style=text-align:left;>
												".$acumColecciones." Premios de Segundo pago
											</td>
											<td style='text-align:left;'>";
												foreach ($premios_planes as $planstandard):
													if ($planstandard['id_plan_campana']):
														if ($planstandard['tipo_premio']=="Segundo"):
															foreach ($acumPremios as $key) {
																if($key['plan'] == $planstandard['tipo_premio']){
																	if($key['cantidad']>0){
													$info .= $key['cantidad']." ".$planstandard['producto']."<br>";
																	}
																}
															}
														endif;
													endif;
												endforeach;
										$info .= "
	                                        </td>
	                                      </tr>
	                                      <tr>
			                                        <td style='text-align:left;width:45%;'>
			                                          Retos Solicitados
			                                        </td>
			                                        <td style='text-align:left;width:55%;'>";
			                                          foreach ($acumRetos as $key):
			                                          	if($key['cantidad']>0){
			                                        $info .= $key['cantidad']." ".$key['nombre']."<br>";
			                                          	}
			                                          endforeach;
			                                    $info .= "
			                                        </td>
			                              </tr>
			                              <tr>
			                              	<td style='text-align:left;'>Premios Canjeados</td>
			                              	<td style='text-align:left;'>";
			                              		
			                              		foreach ($arrayt2 as $arr) {
			                              			if($arr['cantidad']>0){
			                              				$info .= $arr['cantidad']." ".$arr['nombre']."<br>";
			                              			}
			                              		}
			$info .= "				
		                                 	</td>
		                                </tr>
	                              </table>
	                            </td>
	                          </tr>
					</tbody>
				</table>
				
				<div class='row'>
					<div class='col-xs-12'>

					
						

					</div>
				</div>
			  ";
					// print_r($acumPlanes);
					// print_r($acumPremios);
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

	$dompdf->loadHtml($info);
	$pgl1 = 96.001;
	$ancho = 528.00;
	$alto = 816.009;
	$altoMedio = $alto / 2;
	$dompdf->render();
	$dompdf->stream("Premios Alcanzados (Estructura de {$nombreReport}) - Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
	// echo $info;
}else{
  require_once 'public/views/error404.php';
}
?>