<?php 
				if(is_file('app/models/indexModels.php')){
					 	require_once'app/models/indexModels.php';
					 }
					 if(is_file('../app/models/indexModels.php')){
					 	require_once'../app/models/indexModels.php';
					 }

				require_once'vendor/dompdf/dompdf/vendor/autoload.php';
				use Dompdf\Dompdf;
				$dompdf = new Dompdf();
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
					$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");
					$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho}");
					$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes.estatus = 1");

				  $nombreCampana = $pedidosClientes[0]['nombre_campana'];
				  $numeroCampana = $pedidosClientes[0]['numero_campana'];
				  $anioCampana = $pedidosClientes[0]['anio_campana'];

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
					<title>Porcentaje de Planes Seleccionados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
					
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
							<h2 style='font-size:1.9em;'> Porcentaje de Premios Seleccionados - Campaña ".$numeroCampana."/".$anioCampana."</h2>
							<br>
					";		

						$info .= "<table class='table text-center' style='font-size:1.3em;width:110%;position:relative;left:-5%;'>
									<thead style='background:#efefef55;font-size:1.05em;'>
										<tr class='text-center'>
											<th>Nº</th>
											<th>Plan</th>
											<th>Cantidad</th>
											<th>Colecciones</th>
											<th>Porcentaje</th>
										</tr>
									</thead>
									<tbody>";
				                        $num = 1; 
										$totalidad = 0;
										$PorcentajeAcum = 0;
                          				$cantidadTotal = 0;
										foreach ($planes as $data): if(!empty($data['id_plan'])):
					                        foreach ($planesCol as $data2): if(!empty($data2['id_plan'])):
												if($data['id_plan'] == $data2['id_plan']):
													$totalidad += $data2['cantidad_coleccion_plan'];
												endif;
											endif; endforeach;
										endif; endforeach;
										foreach ($planes as $data): if(!empty($data['id_plan'])):
								$info .= "<tr>
											<td style='width:10%;'>".$num."</td>
											<td style='width:35%;text-align:left;'>
				                                ".$data['nombre_plan']."
											</td>
											<td style='width:50%;text-align:justify;' colspan='3'>";
												$cantidadPlan = 0;
												foreach ($planesCol as $data2): if(!empty($data2['id_plan'])):
													if($data['id_plan'] == $data2['id_plan']):
														$cantidadPlan += $data2['cantidad_coleccion_plan'];
													endif;
												endif; endforeach;

										$info .= "<table class='table' style='background:none;'>
													<tr>
														<td style='width:50%;text-align:left;'>
															<b>".$cantidadPlan."</b> Plan ".$data['nombre_plan']." 
														</td>
														<td style='width:50%;text-align:left;'>";
                                                  			$accum = ($data['cantidad_coleccion']*$cantidadPlan);
                                                  			$cantidadTotal+=$accum;
                                                			
                                                $info .= $accum." Colecciones
														</td>
														<td style='width:30%;text-align:right;'>
															<b>";
																if($totalidad!=0){
																	$porcent = number_format($cantidadPlan*100/$totalidad,2);
																}else{
																	$porcent=0;
																}
			                                                    $PorcentajeAcum += $porcent;
													$info .= "(".$porcent."%)
			                                                </b>
														</td>
													</tr>
												</table>
											</td>
										</tr>";
				                            $num++;
				                        endif; endforeach;
							$info .= "
									<tr style='background:#efefef55;font-size:1.05em;'>
			                          <th></th>
			                          <th></th>
			                          <th></th>
			                          <th>".$cantidadTotal." Colecciones</th>
			                          <th></th>
			                        </tr>

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
				$dompdf->loadHtml($info);
				$pgl1 = 96.001;
				$ancho = 528.00;
				$alto = 816.009;
				$altoMedio = $alto / 2;
				$dompdf->render();
				$dompdf->stream("Porcentaje de Planes Seleccionados de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
				// echo $info;
}else{
  require_once 'public/views/error404.php';
}

?>