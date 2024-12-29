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
  if(isset($_GET['C']) || isset($_GET['ID'])){
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

    $lideres = $lider->consultarQuery("SELECT clientes.id_cliente, clientes.cedula, clientes.primer_nombre, clientes.primer_apellido FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC;");
    $catalogo = $lider->consultarQuery("SELECT * FROM catalogos ORDER BY id_catalogo ASC;");
    $newDataAcum = [];
    // $index = 0;
    foreach ($catalogo as $key) {
      if(!empty($key['id_catalogo'])){
        $index = $key['id_catalogo'];
        $newDataAcum[$index]['cantidad'] = 0;
        $newDataAcum[$index]['id'] = $key['id_catalogo'];
        $newDataAcum[$index]['gemas'] = $key['cantidad_gemas'];
        $newDataAcum[$index]['nombre'] = $key['nombre_catalogo'];
        $newDataAcum[$index]['marca'] = $key['marca_catalogo'];
        $index++;
      }
    }



    if(isset($_GET['C'])){
      if($_GET['C'] == 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL");
      }
      if($_GET['C'] > 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL and catalogos.cantidad_gemas = {$_GET['C']}");
      }
    }
    if(isset($_GET['ID'])){
      if($_GET['ID'] == 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL");
      }
      if($_GET['ID'] > 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL and catalogos.id_catalogo = {$_GET['ID']}");
      }
      
    }

    
    $newData2 = [];
    foreach ($lideres as $data): if(!empty($data['id_cliente'])):
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
        $indx = 0;
        foreach ($listado as $elemento) {
          if(!empty($elemento['id_cliente'])){
            if($elemento['id_cliente']==$data['id_cliente']){
              if(empty($newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo'])){
                $newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo']=0;
              }
              $newData2[$data['id_cliente']]['id_cliente'] = $data['id_cliente'];
              $newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo']++;
              // $newDataAcum[$elemento['id_catalogo']]['cantidad']++;
              $indx++;
            }
          }
        }  

      endif;

    endif; endforeach;

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
				<title>Premios canjeados de líderes Asignados";
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
						<h2 style='font-size:1.9em;'> Premios canjeados de líderes Asignados";
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
										<th>Líder</th>
										<th>Premios Canjeados Asignados</th>
									</tr>
								</thead>
								<tbody> ";
									$num = 1;
									foreach ($lideres as $data): if(!empty($data['id_cliente'])):
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
											foreach ($newData2 as $infos): if (!empty($infos['id_cliente'])): if($data['id_cliente']==$infos['id_cliente']):

												$info .= "<tr class='text-center'>
													<td style='width:10%;'>".$num."</td>
													<td style='width:40%;'>
														".number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido']."
													</td>
													
													<td style='width:50%;text-align:left;'>";
													$newData = [];
													foreach ($listado as $elemento){
														if(!empty($elemento['id_cliente'])){
															if($elemento['id_cliente']==$data['id_cliente']){
																if(empty($newData[$elemento['id_catalogo']]['cantidad_canjeo'])){
																	$newData[$elemento['id_catalogo']]['cantidad_canjeo']=0;
																}
																$newData[$elemento['id_catalogo']]['id_catalogo'] = $elemento['id_catalogo'];
																$newData[$elemento['id_catalogo']]['nombre_catalogo'] = $elemento['nombre_catalogo'];
																$newData[$elemento['id_catalogo']]['cantidad_gemas'] = $elemento['cantidad_gemas'];
																$newData[$elemento['id_catalogo']]['marca_catalogo'] = $elemento['marca_catalogo'];
																$newData[$elemento['id_catalogo']]['cantidad_canjeo']++;
																$newDataAcum[$elemento['id_catalogo']]['cantidad']++;
															}
														}
													}
													foreach ($newData as $infos2) { if(!empty($infos2['id_catalogo'])){
														$info .= "(".$infos2['cantidad_canjeo'].") ".$infos2['nombre_catalogo']." ".$infos2['marca_catalogo']."<br>";
													} }
													$info .= "</td>

												</tr>";
												
												$num++;
											endif; endif; endforeach;
										endif;

									endif; endforeach;
					$info .= "		<tr style='background:#efefef55;'>
			                            <td></td>
			                            <td><b>Total: </b></td>
			                            <td style='text-align:left;'>
			                              <b>";
			                              	foreach ($newDataAcum as $key) { if($key['cantidad']>0){
			                              		$info .= "(".$key['cantidad'].") ".$key['nombre']." ".$key['marca']."<br>";
			                              	} }
			                              $info .= "</b>
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

				$namedoc = "Premios canjeados de líderes Asignados";
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