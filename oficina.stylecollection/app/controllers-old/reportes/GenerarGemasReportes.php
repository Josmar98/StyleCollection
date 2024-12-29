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
      if(!empty($_GET['id'])){
        $id_despacho = $_GET['id'];

        // $camp = $_GET['P'];
        // $camps = $lider->consultarQuery("SELECT * FROM campanas,despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$camp}");
        // if(count($camps)>1){
        //   $campp = $camps[0];
	       //  $nombreCampana = $campp['nombre_campana'];
	       //  $numeroCampana = $campp['numero_campana'];
	       //  $anioCampana = $campp['anio_campana'];
        // }

        $historial1 = [];
        // $historial1 = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_perso} and canjeos.estatus = 1");
        $historial2 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, pedidos, despachos, campanas WHERE pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana and  pedidos.id_pedido = gemas.id_pedido and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso} and despachos.id_despacho = {$camp}");
        $historial3 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, campanas, despachos, pedidos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_pedido = gemas.id_pedido and campanas.id_campana and despachos.id_campana and campanas.id_campana = gemas.id_campana and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema != 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso}  and despachos.id_despacho = {$camp}");
        $historial4 = $lider->consultarQuery("SELECT * FROM nombramientos, liderazgos, campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = nombramientos.id_campana and nombramientos.id_liderazgo = liderazgos.id_liderazgo and nombramientos.estatus = 1 and nombramientos.id_cliente = {$id_perso} and despachos.id_despacho = {$camp}");
        $historial5 = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, descuentos_gemas WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = descuentos_gemas.id_pedido and descuentos_gemas.id_cliente = {$id_perso} and pedidos.id_despacho = {$camp}");
        $historial6 = $lider->consultarQuery("SELECT * FROM campanas, despachos, canjeos_gemas, clientes WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = canjeos_gemas.id_campana and despachos.id_despacho = canjeos_gemas.id_despacho and canjeos_gemas.id_cliente = clientes.id_cliente and canjeos_gemas.id_despacho = {$camp} and canjeos_gemas.id_cliente = {$id_perso}");
        $historial7 = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and obsequiogemas.id_despacho = {$camp} and obsequiogemas.id_cliente = {$id_perso} and clientes.estatus = 1 and obsequiogemas.estatus = 1");

      }else{
          $historial1 = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_perso} and canjeos.estatus = 1");
          $historial2 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, pedidos, despachos, campanas WHERE pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana and  pedidos.id_pedido = gemas.id_pedido and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso}");
          $historial3 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, campanas, despachos, pedidos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_pedido = gemas.id_pedido and campanas.id_campana and despachos.id_campana and campanas.id_campana = gemas.id_campana and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema != 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso}");
          $historial4 = $lider->consultarQuery("SELECT * FROM nombramientos, liderazgos, campanas WHERE campanas.id_campana = nombramientos.id_campana and nombramientos.id_liderazgo = liderazgos.id_liderazgo and nombramientos.estatus = 1 and nombramientos.id_cliente = {$id_perso}");
          $historial5 = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, descuentos_gemas WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = descuentos_gemas.id_pedido and descuentos_gemas.id_cliente = {$id_perso}");
          $historial6 = $lider->consultarQuery("SELECT * FROM campanas, despachos, canjeos_gemas, clientes WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = canjeos_gemas.id_campana and despachos.id_despacho = canjeos_gemas.id_despacho and canjeos_gemas.id_cliente = clientes.id_cliente and canjeos_gemas.id_cliente = {$id_perso}");
          $historial7 = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and obsequiogemas.id_cliente = {$id_perso} and clientes.estatus = 1 and obsequiogemas.estatus = 1");
      }

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
      if(!empty($historial2)){
        foreach ($historial2 as $data) {
          if(!empty($data['id_gema'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }
      if(!empty($historial3)){
        foreach ($historial3 as $data) {
          if(!empty($data['id_gema'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }
      if(!empty($historial4)){
        foreach ($historial4 as $data) {
          if(!empty($data['id_nombramiento'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }
      if(!empty($historial5)){
        foreach ($historial5 as $data) {
          if(!empty($data['id_descuento_gema'])){
            $historialx[$num] = $data;
            $cantidad_gemas = $data['cantidad_descuento_gemas'];
            $historialx[$num]['cantidad_gemas'] = $cantidad_gemas;
            $num++;
          }
        }
      }
      if(!empty($historial6)){
        foreach ($historial6 as $data) {
          if(!empty($data['id_canjeo_gema'])){
            $historialx[$num] = $data;
            $cantidad_gemas = $data['cantidad'];
            $historialx[$num]['cantidad_gemas'] = $cantidad_gemas;
            $num++;
          }
        }
      }
      if(!empty($historial7)){
        foreach ($historial7 as $data) {
          // print_r($data);
          if(!empty($data['id_obsequio_gema'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }

      $newData[$index]['id_cliente'] = $lids['id_cliente'];
      $newData[$index]['cedula'] = $lids['cedula'];
      $newData[$index]['primer_nombre'] = $lids['primer_nombre'];
      $newData[$index]['primer_apellido'] = $lids['primer_apellido'];
      $newData[$index]['disponibles'] = 0;
      $newData[$index]['bloqueadas'] = 0;
      $newData[$index]['canjeadas'] = 0;
      // if($id_perso == 8){
      foreach($historialx as $data){
        $gemas = 0;
        $gemasbloq = 0;
        $gemascanjeadas = 0;
        if(!empty($data['fecha_canjeo'])){
          $razon = '-';
          $concepto = "Por Canjeo de premio";
          // $fechaMostrar = $data['fecha_canjeo'];
          // $newData[$index]['canjeadas'] += $data['cantidad_gemas'];
          $gemas = $data['cantidad_gemas'];
          $gemascanjeadas = $data['cantidad_gemas'];
        }else if(!empty($data['nombreconfiggema']) && $data['nombreconfiggema'] == 'Por Colecciones De Factura Directa'){
          $razon = '+';
          $concepto = "Por Factura Directa <br><small>Pedido ";
          if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
          $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
          // $fechaMostrar = $lider->formatFechaInver($data['fecha_aprobado']);

          if($data['estado'] == "Disponible"){
            $gemas = $data['activas'];
            // $newData[$index]['disponibles'] += $data['activas'];
          }
          if($data['estado']=="Bloqueado"){
            $gemasbloq = $data['inactivas'];
            // $newData[$index]['bloqueadas'] += $data['inactivas'];
          }
        }else if(!empty($data['nombreconfiggema']) && $data['nombreconfiggema'] != 'Por Colecciones De Factura Directa'){
          $razon = '+';
          $concepto = $data['nombreconfiggema']." <br><small>Pedido ";
          if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
          $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
          // $fechaMostrar = $data['fecha_gemas'];

          // $newData[$index]['disponibles'] += $data['activas'];
          $gemas = $data['activas'];
        }else if(!empty($data['fecha_nombramiento'])){
          $razon = '+';
          $concepto = "Por Nombramiento <br><small> ".$data['nombre_liderazgo']."</small>";
          // $fechaMostrar = $data['fecha_nombramiento'];

          // $newData[$index]['disponibles'] += $data['cantidad_gemas'];
          $gemas = $data['cantidad_gemas'];
        }else if(!empty($data['fecha_descuento_gema'])){
          $razon = '-';
          $concepto = "Por Liquidación de gemas <br><small>Pedido";
          if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
          $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
          // $fechaMostrar = $data['fecha_descuento_gema'];

          $gemas = $data['cantidad_gemas'];
        }else if(!empty($data['fecha_canjeo_gema'])){
          $razon = '-';
          $concepto = "Por Canjeo de Gemas por Divisas en Físico <br><small>Pedido";
          if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
          $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
          // $fechaMostrar = $data['fecha_canjeo_gema'];

          $gemas = $data['cantidad_gemas'];
        }else if(!empty($data['fecha_obsequio'])){
          $razon = '+';

          if($data['descripcion_gemas']==""){
            $concepto = "Obsequio otorgado por ".$data['firma_obsequio'];
          }else{
            $concepto = $data['descripcion_gemas'];
          }
          $concepto .= "<br><small>Pedido";
          if($data['numero_despacho']!="1"){ $concepto .=  $data['numero_despacho']; }
          $concepto .= " de Campaña ".$data['numero_campana']."/".$data['anio_campana']."</small>";
          // $fechaMostrar = $data['fecha_obsequio'];

          // $concepto = "Por Canjeo de Gemas por Divisas en Físico <br><small>Pedido";

          $gemas = $data['cantidad_gemas'];
        }
        // if(!empty($data['hora_canjeo'])){
        //   $horaMostrar = $data['hora_canjeo'];
        // }else if(!empty($data['hora_aprobado'])){
        //   $horaMostrar = $data['hora_aprobado'];
        // }else if(!empty($data['hora_gemas'])){
        //   $horaMostrar = $data['hora_gemas'];
        // }else if(!empty($data['hora_nombramiento'])){
        //   $horaMostrar = $data['hora_nombramiento'];
        // }else if(!empty($data['hora_descuento_gema'])){
        //   $horaMostrar = $data['hora_descuento_gema'];
        // }else if(!empty($data['hora_canjeo_gema'])){
        //   $horaMostrar = $data['hora_canjeo_gema'];
        // }else if(!empty($data['hora_obsequio'])){
        //   $horaMostrar = $data['hora_obsequio'];
        // }

        if($razon=="+"){
          $newData[$index]['disponibles']+=$gemas;
          $newData[$index]['bloqueadas']+=$gemasbloq;
          $newData[$index]['canjeadas']-=$gemascanjeadas;
        }
        if($razon=="-"){
          $newData[$index]['disponibles']-=$gemas;
          $newData[$index]['bloqueadas']-=$gemasbloq;
          $newData[$index]['canjeadas']+=$gemascanjeadas;
        }

        // echo " /// ";
        // echo $razon." ".$gemas;
        // echo " /// ";
        // echo $razon." ".$gemasbloq;
        // echo " /// ";

        // print_r($key['gemas_inactiva']);
        // echo "<br>";
        // echo " | ".$razon." ".$gemas." | ".$concepto." | <br>";
      }
      
      // echo "Cliente: ".$lids['id_cliente']." ".$lids['primer_nombre']." ".$lids['primer_apellido']." - ";
      // echo "Historiales: ".count($historialx)."<br>";
      // echo "Disponible: ".$newData[$index]['disponibles']." | ";
      // echo "Bloqueadas: ".$newData[$index]['bloqueadas']." | ";
      // echo "Canjeadas: ".$newData[$index]['canjeadas']." | ";
      // echo "<br>";
      // echo "<br>";


      // }
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
				<title>Listado de Gemas de Líderes ";
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
						<h2 style='font-size:1.9em;'> Listado de Gemas de Líderes";
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
										<th>Gemas Bloqueadas</th>
										<th>Gemas Disponibles</th>
									</tr>
								</thead>
								<tbody> ";
									$num = 1;
                          $acumDisponible = 0;
                          $gemasCanjeadas = 0;
                          $gemasBloqueadas = 0;
                          $gemasDisponibles = 0;
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
													if (($data['canjeadas']+$data['bloqueadas']+$data['disponibles'])>0):

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
											".number_format($data['bloqueadas'],2,',','.')." Gemas";
											$gemasBloqueadas += $data['bloqueadas'];
										$info .= "</td>

										<td style='width:20%;margin:auto;'>
											".number_format($data['disponibles'],2,',','.')." Gemas";
											$gemasDisponibles += $data['disponibles'];
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
			                              	number_format($gemasCanjeadas,2,',','.')." Gemas
			                              </b>
			                            </td>
			                            <td>
			                              <b>".
			                              	number_format($gemasBloqueadas,2,',','.')." Gemas
			                              </b>
			                            </td>
			                            <td>
			                              <b>".
			                              	number_format($gemasDisponibles,2,',','.')." Gemas
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

				$namedoc = "Listado de Gemas de Líderes ";
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