<?php 
	set_time_limit(320);
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
			$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
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
				<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
				<title>Pedidos Aprobados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
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
						<br>
						<h2 style='font-size:1.5em;'> Solicitudes Aprobadas de Pedido - Campaña ".$numeroCampana."/".$anioCampana."</h2>
						<br>
				";		

					$info .= "<table class='table text-center' style='font-size:1.2em;width:110%;position:relative;left:-5%;'>
								<thead style='background:#efefef55;font-size:1.05em;'>
									<tr class='text-center'>
										<th>Nº</th>
										<th>Lider</th>
										<th>Pedido Solicitado</th>
										<th>Pedido Solicitado Colecciones</th>
										<th>Pedido Aprobado</th>
										<th>Pedido Aprobado Colecciones</th>
									</tr>
								</thead>
								<tbody> ";
									$num = 1;
									$cantidadPedido = 0;
									$cantidadAprobado = 0;

									$sumatorias = [];
									$sumatoriasPed = [];
							
									for ($i=0; $i < count($pedidosClientes)-1; $i++) {
										$ped = $pedidosClientes[$i];
										$sum = 0;
										$sum=$ped['cantidad_pedido'];
										$pedSec = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido = {$ped['id_pedido']}");
										foreach ($pedSec as $key) {
											if(!empty($key['id_pedido_sec'])){
												$sum+=$key['cantidad_pedido_sec'];
											}
										}
										$pedidosClientes[$i]['cantidad_pedido_total']=$sum;
										$ped = $pedidosClientes[$i];
									}
									foreach ($pedidosClientes as $data): if(!empty($data['id_pedido'])):
										foreach ($clientess as $data2): if(!empty($data2['id_cliente'])):
											if($data['id_cliente'] == $data2['id_cliente']):

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

												if($permitido=="1"):
													$query2 = "SELECT * FROM despachos_secundarios, pedidos_secundarios WHERE despachos_secundarios.id_despacho_sec=pedidos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho={$_GET['id']} and pedidos_secundarios.id_despacho={$_GET['id']} and pedidos_secundarios.id_cliente={$data['id_cliente']}";
													$pedSec = $lider->consultarQuery($query2);
													$info .= "<tr class='text-center'>
														<td style='width:7%;'>".$num."</td>
														<td style='width:31%;'>
															".number_format($data2['cedula'],0,'','.')." ".$data2['primer_nombre']." ".$data2['primer_apellido']."
														</td>
										
														<td style='width:31%;'>
															".$data['cantidad_pedido_total']." Colecciones";
															$cantidadPedido += $data['cantidad_pedido_total'];
															$info .= "
														</td>

														<td style='width:31%;'>
															".$data['cantidad_pedido']." Cols. Productos<br>";
															if(!empty($sumatorias['Productos'])){
																$sumatorias['Productos']['cantidad']+=$data['cantidad_pedido'];
															}else{
																$sumatorias['Productos']['cantidad']=$data['cantidad_pedido'];
																$sumatorias['Productos']['name']="Productos";
															}

															foreach ($pedSec as $key) {
																if(!empty($key['id_pedido_sec'])){
																	$info .= $key['cantidad_pedido_sec']." Cols. ".$key['nombre_coleccion_sec']."<br>";
																	if(!empty($sumatorias[$key['nombre_coleccion_sec']])){
																		$sumatorias[$key['nombre_coleccion_sec']]['cantidad']+=$key['cantidad_pedido_sec'];
																	}else{
																		$sumatorias[$key['nombre_coleccion_sec']]['cantidad']=$key['cantidad_pedido_sec'];
																		$sumatorias[$key['nombre_coleccion_sec']]['name']=$key['nombre_coleccion_sec'];
																	}
																}
															}

															
															$info .= "
															</td>
															<td style='width:31%;margin:auto;'>
																".$data['cantidad_aprobado']." Colecciones";
																$cantidadAprobado += $data['cantidad_aprobado'];
																$info .= "
															</td>
															<td style='width:31%;margin:auto;'>";
																$info .= $data['cantidad_aprobado_individual']." Cols. Productos<br>";
																if(!empty($sumatoriasPed['Productos'])){
																	$sumatoriasPed['Productos']['cantidad']+=$data['cantidad_aprobado_individual'];
																}else{
																	$sumatoriasPed['Productos']['cantidad']=$data['cantidad_aprobado_individual'];
																	$sumatoriasPed['Productos']['name']="Productos";
																}
											
																foreach ($pedSec as $key) {
																	if(!empty($key['id_pedido_sec'])){
																		$info .= $key['cantidad_aprobado_sec']." Cols. ".$key['nombre_coleccion_sec']."<br>";
																		if(!empty($sumatoriasPed[$key['nombre_coleccion_sec']])){
																			$sumatoriasPed[$key['nombre_coleccion_sec']]['cantidad']+=$key['cantidad_aprobado_sec'];
																		}else{
																			$sumatoriasPed[$key['nombre_coleccion_sec']]['cantidad']=$key['cantidad_aprobado_sec'];
																			$sumatoriasPed[$key['nombre_coleccion_sec']]['name']=$key['nombre_coleccion_sec'];
																		}
																	}
																}
																$info .= "
															</td>
															</tr>";
															
			                        			endif;

										$num++;
										endif;
									endif; endforeach;
								endif; endforeach;
					$info .= "		<tr style='background:#efefef55;'>
			                            <td></td>
			                            <td><b>Total: </b></td>
			                            <td>
			                              <b>".$cantidadPedido." Colecciones
			                              </b>
			                            </td>
										<td>
			                              <b>
										  	";
												foreach ($sumatorias as $keys) {
													$info .= $keys['cantidad']." Cols. ".$keys['name']."<br>";
												}
											$info .= "
			                              </b>
			                            </td>
			                            <td>
			                              <b>".$cantidadAprobado." Colecciones
			                              </b>
			                            </td>
										<td>
			                              <b>
										  	";
												foreach ($sumatoriasPed as $keys) {
													$info .= $keys['cantidad']." Cols. ".$keys['name']."<br>";
												}
											$info .= "
			                              </b>
			                            </td>
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

			// $pgl1 = 96.001;
			// $ancho = 528.00;
			// $alto = 816.009;
			// $altoMedio = $alto / 2;
			
			$dompdf->loadHtml($info);
			$dompdf->render();
			$dompdf->stream("Pedidos Aprobados de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>