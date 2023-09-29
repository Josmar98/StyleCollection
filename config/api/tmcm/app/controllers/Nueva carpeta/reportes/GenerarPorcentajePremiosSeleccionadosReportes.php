<?php 
	set_time_limit(240);
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
			      $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
			      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");
			      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho}");
			      $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = {$id_despacho}");
			        $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");

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
					<title>Porcentaje de Premios Seleccionados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
					
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
											<th>Planes</th>
											<th>Cantidad y Premios</th>
											<th>Porcentaje</th>
										</tr>
									</thead>
									<tbody>";
				                        $num = 1; 
                        				$nume = 0;
										foreach ($planes_campana as $data): if(!empty($data['id_plan_campana'])):
											foreach ($premioscol as $data4): if(!empty($data4['id_premio'])):   
												if ($data['id_plan_campana']==$data4['id_plan_campana']): 
													$nume+= $data4['cantidad_premios_plan']; 
												endif;
											endif; endforeach; 
										endif; endforeach; 
										foreach ($planes_campana as $data): if(!empty($data['id_plan_campana'])):
											$array = [];
										$info .= "<tr class='elementTR'>
				                            <td style='width:10%;'>".$num."</td>
				                            <td style='text-align:left;width:20%'>
												Plan ".$data['nombre_plan']."<br>
				                            </td>
				                            <td style='width:70%;text-align:justify;' colspan='2'>
				                                        <table class='table ' style='background:none'>
				                                          <tr>
				                                              <td style='width:100%;'>
				                                                  <table class='table table-hover' style='background:none'>";
				                                                  foreach ($premioscol as $data4): if(!empty($data4['id_premio'])):  
				                                                     if ($data['id_plan_campana']==$data4['id_plan_campana']):
				                                                        if(isset($array['id'][$data4['id_tppc']])){
				                                                            $array['id'][$data4['id_tppc']]['cantidad'] += $data4['cantidad_premios_plan'];
				                                                        }else{
				                                                            $array['id'][$data4['id_tppc']]['cantidad'] = $data4['cantidad_premios_plan'] ;
				                                                            $array['id'][$data4['id_tppc']]['nombre_premio'] = $data4['nombre_premio'];
				                                                        }
				                                                    endif;
				                                                  endif; endforeach;
				                                                  $porcent = 0;

				                                                  foreach ($array as $key):
				                                                    foreach ($key as $key2):
																			$porcent = $key2['cantidad']*100/$nume; 
				                                                    $info .= "
				                                                      <tr>
				                                                        <td style='width:70%;text-align:left;'>
				                                                          <b>".$key2['cantidad']."</b>
				                                                          ".$key2['nombre_premio']."
				                                                        </td>
				                                                        <td style='width:30%;text-align:right;'>
				                                                          <b>
				                                                            (".number_format($porcent,2,',','.')."%)
				                                                          </b>
				                                                        </td>
				                                                      </tr>";
				                                                    endforeach;
				                                                  endforeach;

				                                   		$info .= "</table>
				                                              </td>
				                                          </tr>
				                                        </table>
				                            </td>
				                          </tr>";
				                            	$num++;
				                        		endif; endforeach;
							$info .= "</tbody>
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
				$dompdf->stream("Porcentaje de Premios Seleccionados de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
				// echo $info;
}else{
  require_once 'public/views/error404.php';
}

?>