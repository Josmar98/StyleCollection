<?php 
if(is_file('app/models/indexModels.php')){
    require_once 'app/models/indexModels.php';
}
if(is_file('../app/models/indexModels.php')){
    require_once '../app/models/indexModels.php';
}


// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }

require_once 'vendor/dompdf/dompdf/vendor/autoload.php';
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
function separateDatosCuentaTel($num){
	$set = 0;
	$newNum = '';
	for ($i=0; $i < strlen($num); $i++) { 
		if($i==4){
			$newNum .= '-';
		}
		if($i==7){
			$newNum .= '-';
		}
		if($i==9){
			$newNum .= '-';
		}
		$newNum .= $num[$i];
	}
	return $newNum;
}

$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
$id_despacho = $_GET['dpid'];
$num_despacho = $_GET['dp'];

$clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
$nombreCampana = $pedidosClientes[0]['nombre_campana'];
$numeroCampana = $pedidosClientes[0]['numero_campana'];
$anioCampana = $pedidosClientes[0]['anio_campana'];


$nota = $_GET['nota'];
$notaentregas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega = $nota");
$notaentrega = $notaentregas[0];

$optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

$id = $notaentrega['id_cliente'];
$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
$pedido = $pedidos[0];
$id_pedido = $pedido['id_pedido'];
$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");



$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
$numFactura = "";
if(count($factura)>1){
	$numFactura = $factura[0]['numero_factura'];
	switch (strlen($factura[0]['numero_factura'])) {
		case 1:
			$numFactura = "00000".$factura[0]['numero_factura'];
			break;
			case 2:
				$numFactura = "0000".$factura[0]['numero_factura'];
				break;
			case 3:
				$numFactura = "000".$factura[0]['numero_factura'];
				break;
			case 4:
				$numFactura = "00".$factura[0]['numero_factura'];
				break;
			case 5:
				$numFactura = "0".$factura[0]['numero_factura'];
				break;
			case 6:
				$numFactura = "".$factura[0]['numero_factura'];
				break;
			default:
			$numFactura = "".$factura[0]['numero_factura'];
			break;
		}
	}
	
	// $mostrarListaNotas=$_SESSION['mostrarListaNotasNota'];
	// $mostrarListaNotas=$_SESSION['mostrarNotasResumidasNota'];
	$id_nota = $_GET['nota'];
	$nameModuloFactu="Notas";
	$facturados = $lider->consultarQuery("SELECT * FROM operaciones, notasentrega WHERE operaciones.id_factura=notasentrega.id_nota_entrega and notasentrega.id_nota_entrega={$id_nota} and operaciones.id_factura={$id_nota} and operaciones.modulo_factura='{$nameModuloFactu}' ORDER BY operaciones.id_operacion ASC;");
	// echo count($facturados);
	$mostrarListaNotas = [];
	$index=0;
	foreach ($facturados as $facts) {
		if(!empty($facts['id_factura'])){
			$codFacts=$facts['tipo_inventario'].$facts['id_inventario'];
			if($facts['tipo_inventario']=="Productos"){
				$inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$facts['id_inventario']}");
			}
			if($facts['tipo_inventario']=="Mercancia"){
				$inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$facts['id_inventario']}");
			}
			if($facts['tipo_inventario']=="Catalogo" || $facts['tipo_inventario']=="Catalogos" || $facts['tipo_inventario']=="Servicios"){
				$inventario = $lider->consultarQuery("SELECT *, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$facts['id_inventario']}");
			}
			// foreach ($inventario as $inv) {
			// 	if(!empty($inv['elemento'])){
			// 		$mostrarListaNotas[$index]['cantidad']=$facts['stock_operacion'];
			// 		$mostrarListaNotas[$index]['descripcion']=$inv['elemento'];
			// 		$mostrarListaNotas[$index]['concepto']=$facts['concepto_factura'];
			// 		$mostrarListaNotas[$index]['tipo_inventario']=$facts['tipo_inventario'];
			// 		$mostrarListaNotas[$index]['id_inventario']=$facts['id_inventario'];
			// 	}
			// }
			foreach ($inventario as $inv) {
				if(!empty($inv['elemento'])){
					if(!empty($mostrarListaNotas[$codFacts])){
						if($facts['tipo_operacion']=="Salida"){
						  $mostrarListaNotas[$codFacts]['cantidad']+=$facts['stock_operacion'];
						}
						if($facts['tipo_operacion']=="Entrada"){
						  $mostrarListaNotas[$codFacts]['cantidad']-=$facts['stock_operacion'];
						}
					}else{
						$mostrarListaNotas[$codFacts]['cantidad']=0;
						$mostrarListaNotas[$codFacts]['descripcion']=$inv['elemento'];
						$mostrarListaNotas[$codFacts]['concepto']=$facts['concepto_factura'];
						$mostrarListaNotas[$codFacts]['tipo_inventario']=$facts['tipo_inventario'];
						$mostrarListaNotas[$codFacts]['id_inventario']=$facts['id_inventario'];
						if($facts['tipo_operacion']=="Salida"){
						  $mostrarListaNotas[$codFacts]['cantidad']+=$facts['stock_operacion'];
						}
						if($facts['tipo_operacion']=="Entrada"){
						  $mostrarListaNotas[$codFacts]['cantidad']-=$facts['stock_operacion'];
						}
					}
				}
			}
			$index++;
		}
	}
	// foreach ($mostrarListaNotas as $key) {
	// 	print_r($key);
	// 	echo "<br><br><br>";
	// }

	$catalag = "1";
	
	switch (strlen($notaentrega['numero_nota_entrega'])) {
		case 1:
			$numero_nota_entrega = "000000".$notaentrega['numero_nota_entrega'];
			break;
		case 2:
			$numero_nota_entrega = "00000".$notaentrega['numero_nota_entrega'];
			break;
		case 3:
			$numero_nota_entrega = "0000".$notaentrega['numero_nota_entrega'];
			break;
		case 4:
			$numero_nota_entrega = "000".$notaentrega['numero_nota_entrega'];
			break;
		case 5:
			$numero_nota_entrega = "00".$notaentrega['numero_nota_entrega'];
			break;
		case 6:
			$numero_nota_entrega = "0".$notaentrega['numero_nota_entrega'];
			break;
		case 7:
			$numero_nota_entrega = "".$notaentrega['numero_nota_entrega'];
			break;
		default:
			$numero_nota_entrega = "".$notaentrega['numero_nota_entrega'];
			break;
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
				<title>Pedidos Solicitados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
			</head>
			<body>
				<style>
				body{
					font-family:'arial';
					font-size:1.6em;
				}
				</style>
				<div class='row' style='padding:0;margin:0;'>
					<div class='col-xs-12'  style='width:100%;'>
						<div class='box-body' style='background:;'>
							<div class='text-center' style='width:60%;text-center;display:inline-block;background:;'>
								<div style='width:40%;display:inline-block;background:;'>
									<img src='public/assets/img/logoTipo1.png' style='width:100%;'>
								</div>
								<div style='width:60%;display:inline-block;background:;text-align:left;'>
									<span>Inversiones Style Collection C.A</span>
									<br>
									<span>Rif.: J408497786</span>
									<br>
									<span>DEPARTAMENTO <u>Facturación</u></span>
								</div>
								<div style='clear:both;'></div>
								<div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:left;padding:0'>
									".$notaentrega['direccion_emision']."
								</div>
							</div>
							<div class='text-center'  style='width:40%;text-left;display:inline-block;'>
								<br><br>
								<div>
									<table class='text-left' style='width:100%;margin-left:10px;'>
										<tr>
											<td><span>LUGAR DE EMISION</span></td>
											<td><span>FECHA DE EMISION</span></td>
										</tr>
										<tr>
											<td>".$notaentrega['lugar_emision']."</td>
											<td>".$lider->formatFecha($notaentrega['fecha_emision'])."</td>
										</tr>
										<tr>
											<td><br><br><span><b>Nota De Entrega</b></span></td>
											<td><span></span></td>
										</tr>
										<tr>
											<td><span style='font-size:1.2em;'><b>N°: <u>".$numero_nota_entrega."</u></b></span></td>
											<td></td>
										</tr>
									</table>
									
								</div>
								<br>
							</div>
							<div style='clear:both'> </div>
							<div style='position:relative;top:-40px;margin-bottom:-35px;width:100%;text-align:center;border-top:1px solid #777;border-bottom:1px solid #777;padding:5px;font-size:1.2em;'>".mb_strtoupper('Nota de entrega de Premios y Retos')."</div>
							<div style='width:35%;display:inline-block;font-size:1.1em;'>
								Campaña ".$numeroCampana."/".$anioCampana."
							</div>
							<div style='width:35%;display:inline-block;font-size:1.1em;'>
								Analista: ".$notaentrega['nombreanalista']."
							</div>
							<div style='width:30%;display:inline-block;font-size:1.2em;'>";
								if ($numFactura != ""){
									$info .= "Factura N°. <b>".$numFactura." </b>";
								}
								$info .= "
							</div>
							<table class='table table-bordered' style='border:none;'>
								<tr>
									<td colspan='3'>
										Cliente:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']."
									</td>
									<td colspan='2'>
										C.I / R.I.F:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$pedido['cod_rif'].$pedido['rif']."
									</td>
								</tr>
								<tr>
									<td colspan='3'>
										Dirección:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$pedido['direccion']."
									</td>
									<td colspan='2'>
										Nro. Tlf: 
										<span style='margin-left:10px;margin-right:10px;'></span>
										".separateDatosCuentaTel($pedido['telefono'])." ";
										if(strlen($pedido['telefono2'])>5){
											$info .= " / ".separateDatosCuentaTel($pedido['telefono2']);
										}
										$info .= "
									</td>
								</tr>";
								if($notaentrega['observaciones']!=""){
									$info .= "<tr>
										<td colspan='5'>
											Observación:
											<span style='margin-left:10px;margin-right:10px;'></span>
											".$notaentrega['observaciones']."
										</td>
									</tr>";
								}
								$info .= "
							</table>
					
							<br>
						
							<table class='table table-bordered text-left' >
								<thead style='background:#EEE;font-size:1.00em;'>
									<tr>
										<th style=text-align:center;width:5%;>Cant.</th>
										<th style=text-align:left;width:45%;>Descripcion</th>
										<th style=text-align:left;width:50%;>Concepto</th>
									</tr>
									<style>
										.col1{text-align:center;}
										.col2{text-align:left;}
										.col3{text-align:left;}
										.col4{text-align:left;}
										</style>
								</thead>
								<tbody>";
									$num = 1;
									foreach ($mostrarListaNotas as $notaM) {
										if($notaM['cantidad']>0){
											$id_unico = $notaM['cantidad'].$notaM['tipo_inventario'].$notaM['id_inventario'];
											if($_GET['opts'][$id_unico]=='Y'){
												$info .= "
													<tr>
														<td class='col1'>
															".$notaM['cantidad']."
														</td>
														<td class='col2' style='font-size:0.9em;'>
															".$notaM['descripcion']."
														</td>
														<td class='col3' style='font-size:0.9em;'>
															".$notaM['concepto']."
														</td>
													</tr>
												";
											}
										}
									}
									// print_r($mostrarListaNotas);
									$info .="
								</tbody>
							</table>
							<br><br><br><br><br>
						</div>
						<div class='row' style='position:absolute;top:97%;'>
							<div class='' style='width:50%;display:inline-block;text-align:right;'>
								
								<div style='display:inline-block;'>Despachado por:</div>
								<div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
								<br><br>
								<div style='display:inline-block;margin-left:100px;'>C.I:</div>
								<div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
							</div>
							
							<div class='' style='width:50%;display:inline-block;text-align:right;'>
								<div style='display:inline-block;margin-left:13px;'>Recibido por:</div>
								<div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
								<br><br>
								<div style='display:inline-block;margin-left:85px;'>C.I:</div>
								<div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
							</div>

						</div>
						";
						//<span class='string'>Copyright &copy; 2021-2022 <b>Style Collection</b>.</span> <span class='string'>Todos los derechos reservados.</span>
						//<h2>tengo mucha hambre, y sueño, aparte tengo que hacer muchas cosas lol jajaja xd xd xd xd xd xd xd xd hangria </h2>
						$info .= "
					</div>
				</div>
				<br>
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
	
	//$dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta 
	// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
	
	// $pgl1 = 96.
	// $ancho = 528.
	// $alto = 816.
	// $altoMedio = $alto / 2;
	
	
	$dompdf->loadHtml($info);
	$dompdf->render();
	$dompdf->stream("Nota de entrega N.{$numero_nota_entrega} {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
	// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>