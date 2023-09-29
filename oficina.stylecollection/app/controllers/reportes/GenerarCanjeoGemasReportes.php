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
	
	$lideres = $lider->consultarQuery("SELECT clientes.id_cliente, clientes.cedula, clientes.primer_nombre, clientes.primer_apellido FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC;");
  $newData = [];
  $index = 0;
  if(!empty($_GET['id'])){
  	$camp = $_GET['id'];
    $camps = $lider->consultarQuery("SELECT * FROM campanas,despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$camp}");
    if(count($camps)>1){
      $campp = $camps[0];
	    $nombreCampana = $campp['nombre_campana'];
	    $numeroCampana = $campp['numero_campana'];
	    $anioCampana = $campp['anio_campana'];
    }
  }
  foreach ($lideres as $lids) {
    if(!empty($lids['id_cliente'])){
      $id_perso = $lids['id_cliente'];
      
          $historial1 = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_perso} and canjeos.estatus = 1");
      
      $historialx = [];
      $num = 0;
      if(!empty($historial1)){
        foreach ($historial1 as $data) {
          if(!empty($data['id_canjeo'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }

      $newData[$index]['id_cliente'] = $lids['id_cliente'];
      $newData[$index]['cedula'] = $lids['cedula'];
      $newData[$index]['primer_nombre'] = $lids['primer_nombre'];
      $newData[$index]['primer_apellido'] = $lids['primer_apellido'];
      $newData[$index]['canjeadas'] = 0;
      $newData[$index]['asignadas'] = 0;
      $newData[$index]['noasignadas'] = 0;
      foreach($historialx as $data){
        $gemascanjeadas = 0;
        $gemasAsignadas = 0;
        $gemasNoAsignadas = 0;
        if(!empty($data['fecha_canjeo'])){
          $razon = '-';
          $concepto = "Por Canjeo de premio";
          $gemas = $data['cantidad_gemas'];
          $gemascanjeadas = $data['cantidad_gemas'];
          if($data['estado_canjeo']=="Asignado"){
            $gemasAsignadas += $data['cantidad_gemas']; 
          }
          if($data['estado_canjeo']==""){
            $gemasNoAsignadas += $data['cantidad_gemas']; 
          }
          $newData[$index]['canjeadas']+=$gemascanjeadas;
          $newData[$index]['asignadas']+=$gemasAsignadas;
          $newData[$index]['noasignadas']+=$gemasNoAsignadas;
        }

        
      }
      $index++;
    }
  }
			





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
				<title>Listado de Gemas Canjeadas de Líderes ";
				if(!empty($_GET['id'])){
					$info .= $numeroCampana."/".$anioCampana;
				}
				$info .= " - StyleCollection</title>
				
			</head>
			<body>
			<style>
			body{
				font-family:'arial';
			}
			</style>
			<div class='row' style='padding:0;margin:0;'>
				<div class='col-xs-12'  style='width:100%;'>

						<h3 style='text-align:right;float:right;'>
							<small>StyleCollection ";
								if(!empty($_GET['id'])){
									$info .= " - ".$nombreCampana;
								}
							$info .= "</small></h3>
						<h2 style='font-size:1.9em;'> Listado de Gemas Canjeadas de Líderes";
								if(!empty($_GET['id'])){
									$info .= "- Campaña ".$numeroCampana."/".$anioCampana;
								}
						$info .= "</h2>
						<br>
				";		

					$info .= "<table class='table text-center' style='font-size:1.3em;width:110%;position:relative;left:-5%;'>
								<thead style='background:#efefef55;font-size:1.05em;'>
									<tr class='text-center'>
										<th>Nº</th>
										<th>Lider</th>
										<th>Gemas Canjeadas</th>
										<th>Gemas Asignadas</th>
										<th>Gemas No Asignadas</th>
									</tr>
								</thead>
								<tbody> ";
									$num = 1;
                          $gemasCanjeadas = 0;
                          $gemasAsignadas = 0;
                          $gemasNoAsignadas = 0;
									foreach ($newData as $data): if(!empty($data['id_cliente'])):

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
													if (($data['canjeadas']+$data['asignadas']+$data['noasignadas'])>0):

							$info .= "<tr class='text-center'>
										<td style='width:7%;'>".$num."</td>
										<td style='width:33%;'>
											".number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']."
										</td>
										
										<td style='width:20%;'>
											".number_format($data['canjeadas'],2,',','.')." Gemas";
											$gemasCanjeadas += $data['canjeadas'];
										$info .= "</td>

										<td style='width:20%;margin:auto;'>
											".number_format($data['asignadas'],2,',','.')." Gemas";
											$gemasAsignadas += $data['asignadas'];
										$info .= "</td>

										<td style='width:20%;margin:auto;'>
											".number_format($data['noasignadas'],2,',','.')." Gemas";
											$gemasNoAsignadas += $data['noasignadas'];
										$info .= "</td>
									</tr>";
												
										$num++;
												endif;
											endif;

								endif; endforeach;
					$info .= "		<tr style='background:#efefef55;'>
			                            <td></td>
			                            <td><b>Total: </b></td>
			                            <td>
			                              <b>".
			                              	number_format($gemasCanjeadas,2,',','.')." Gemas Canjeadas
			                              </b>
			                            </td>
			                            <td>
			                              <b>".
			                              	number_format($gemasAsignadas,2,',','.')." Gemas Asignadas
			                              </b>
			                            </td>
			                            <td>
			                              <b>".
			                              	number_format($gemasNoAsignadas,2,',','.')." Gemas No Asignadas
			                              </b>
			                            </td>
			                          </tr>
								</tbody>
						</table>
			
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

				$namedoc = "Listado de Gemas Canjeadas de Líderes ";
				if(!empty($_GET['id'])){
					$namedoc .= $numeroCampana." - ".$anioCampana;
				}
				$namedoc .= " - StyleCollection";

			$pgl1 = 96.001;
			$ancho = 528.00;
			$alto = 816.009;
			$altoMedio = $alto / 2;
			
			$dompdf->loadHtml($info);
			$dompdf->render();
			$dompdf->stream($namedoc, array("Attachment" => false));

			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>