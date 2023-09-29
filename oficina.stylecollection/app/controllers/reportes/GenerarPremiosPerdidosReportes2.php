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

      // $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");


      // $tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
      
      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
      $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");


      // $premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

      // $tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT  * FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

      // $tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
        
      // $existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");


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

						<h3 style='text-align:right;float:right;'><small>StyleCollection- ".$nombreCampana."</small></h3>
						<h2 style='font-size:1.9em;'> Premios Perdidos - Campaña ".$numeroCampana."/".$anioCampana."</h2>
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
								<tbody> ";
									$num = 1;
									foreach ($pedidos as $data): if(!empty($data['id_pedido'])):
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
				                                            <td>";
				                                              foreach ($premios_perdidos as $dataperdidos) {
				                                                if(!empty($dataperdidos['id_premio_perdido'])){
				                                                  if(($dataperdidos['valor'] == 'Inicial') && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
				                                                  	$perdidos = $dataperdidos['cantidad_premios_perdidos'];

																	$info .= $perdidos." Premios de ".$dataperdidos['valor']."<br>";
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
													<td style='width:30%;text-align:left;'>                                            
														".($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan'])." Colecciones 
													</td>
													<td style='width:30%;text-align:left;'>
														".$data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."
														<br>                                                
													</td>
													<td style='width:40%;text-align:left;'>

														<table class='' style='width:100%;background:none'>
															<tr>
																<td style='text-align:left;'>";
																foreach ($premios_perdidos as $dataperdidos) {
																	if(!empty($dataperdidos['id_premio_perdido'])){
																		if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
																		$perdidos = $dataperdidos['cantidad_premios_perdidos'];
																		$info .= $perdidos." Premios*** de ".$dataperdidos['valor']."<br>";
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
																			$perdidos = $dataperdidos['cantidad_premios_perdidos'];
																		$info .= $perdidos." ".$data3['nombre_premio']."<br>";
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
				                                            <td>";
				                                              foreach ($premios_perdidos as $dataperdidos) {
				                                                if(!empty($dataperdidos['id_premio_perdido'])){
				                                                  if(($dataperdidos['valor'] == 'Segundo') && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
				                                                    $perdidos = $dataperdidos['cantidad_premios_perdidos'];
																	$info .= $perdidos.' Premios de '.$dataperdidos['valor']."<br>";
				                                                  }
				                                                }
				                                              }
													$info .= "</td>
				                                          </tr>
				                                      </table>
				                                    </td>
				                                  </tr>
			                       			</table></td>

									</tr>";
										$num++;
								endif; endforeach;
					$info .= "				
							</tbody>
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

			$dompdf->loadHtml($info);
			$pgl1 = 96.001;
			$ancho = 528.00;
			$alto = 816.009;
			$altoMedio = $alto / 2;
			$dompdf->render();
			$dompdf->stream("Premios Perdidos de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
  require_once 'public/views/error404.php';
}
?>