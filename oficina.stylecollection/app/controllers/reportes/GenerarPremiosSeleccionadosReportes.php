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
			  $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");
			  $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho}");

			  $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");

      		  $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho");

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
						<h2 style='font-size:1.9em;'> Planes y Premios Seleccionados - Campaña ".$numeroCampana."/".$anioCampana."</h2>
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
									foreach ($pedidosClientes as $data): if(!empty($data['id_pedido'])):
			                        	foreach ($clientess as $data2): if(!empty($data2['id_cliente'])):
			                        		if($data['id_cliente'] == $data2['id_cliente']):
								$info .= "<tr class='text-center'>
										<td style='width:8%;'>".$num."</td>
										<td style='width:22%;'>
											".number_format($data2['cedula'],0,'','.')."<br>".$data2['primer_nombre']." ".$data2['primer_apellido']."<br>
											".$data['cantidad_aprobado']." Colecciones<br>Aprobadas"."

										</td>
										
										<td style='width:70%;text-align:justify;' colspan='3'>
											<table class='table' style='background:none;'>";
			                              foreach ($planesCol as $data3): if(!empty($data3['id_cliente'])):
			                                  if ($data2['id_cliente'] == $data3['id_cliente']):
			                                      if ($data3['cantidad_coleccion_plan']>0):
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
															foreach ($premios_planes as $planstandard):
		                                                      if ($planstandard['id_plan_campana']):
		                                                          if ($data3['nombre_plan'] == $planstandard['nombre_plan']):
		                                                            if ($planstandard['tipo_premio']=="Primer"):
		                                                     $info .= "<tr>
		                                                          <td style='text-align:left;'>
		                                                          	".$data3['cantidad_coleccion_plan']." ".$planstandard['producto']."<br>
		                                                          </td>
		                                                        </tr>";
		                                                            endif;
		                                                          endif;
		                                                      endif;
		                                                    endforeach;

															foreach ($premioscol as $data4): if(!empty($data4['id_premio'])):
																if ($data4['id_plan']==$data3['id_plan']):
																	if ($data['id_pedido']==$data4['id_pedido']):
																		if($data4['cantidad_premios_plan']>0):
													$info.= "<tr>
																<td style='text-align:left;'>
			                                                        ".$data4['cantidad_premios_plan']." ".$data4['nombre_premio']."<br>
																</td>
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
			                       $info .= "</table></td>

									</tr>";
										$num++;
										endif;
									endif; endforeach;
								endif; endforeach;
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
				
				$dompdf->loadHtml($info);
				$pgl1 = 96.001;
				$ancho = 528.00;
				$alto = 816.009;
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