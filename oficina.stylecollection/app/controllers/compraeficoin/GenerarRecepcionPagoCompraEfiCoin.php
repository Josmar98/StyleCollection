<?php 
if(is_file('app/models/indexModels.php')){
	require_once 'app/models/indexModels.php';
}
if(is_file('../app/models/indexModels.php')){
	require_once '../app/models/indexModels.php';
}

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
// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }
// $id_campana = $_GET['campaing'];
// $numero_campana = $_GET['n'];
// $anio_campana = $_GET['y'];
// $id_despacho = $_GET['dpid'];
// $num_despacho = $_GET['dp'];

// $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
// $nombreCampana = $pedidosClientes[0]['nombre_campana'];
// $numeroCampana = $pedidosClientes[0]['numero_campana'];
// $anioCampana = $pedidosClientes[0]['anio_campana'];


$id = $_GET['id'];
$query = "SELECT * FROM eficoin_divisas WHERE id_eficoin_div = '{$id}'";
$eficoins = $lider->consultarQuery($query);

// $notaentrega = $notaentregas[0];

// $optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

// $id = $notaentrega['id_cliente'];
// $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
// $pedido = $pedidos[0];
// $id_pedido = $pedido['id_pedido'];
// $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");


// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }
// $factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
// $numFactura = "";
if(count($eficoins)>1){
    $eficoin = $eficoins[0];
	$tasabcv=0;
	$tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '{$eficoin['fecha_pago']}'");
	if(Count($tasas)>1){
		$tasa = $tasas[0]; 
		$tasabcv = $tasa['monto_tasa'];
	}
	$tasaeficoin=0;
	$tasas = $lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 and fecha_tasa = '{$eficoin['fecha_pago']}'");
	if(Count($tasas)>1){
		$tasa = $tasas[0]; 
		$tasaeficoin = $tasa['monto_tasa'];
	}
	
	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido={$eficoin['id_pedido']}");
	$pedido=$pedidos[0];
	$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$pedido['id_cliente']}");
	$cliente=$clientes[0];
	$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho={$pedido['id_despacho']}");
	$despacho=$despachos[0];
	$campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE id_campana={$despacho['id_campana']}");
	$campana=$campanas[0];

	// $opcionDivisas=2; // BOLIVARES
	// $opcionDivisas=1; // DIVISAS
	// if($opcionDivisas==1){

	// }
	// if($opcionDivisas==2){
		
	// }
	
	// echo "recibido: ".$recibido."<br>";
	// echo "recibido2: ".$recibido2."<br>";
	// echo "equivalenteDiv: ".$equivalenteDiv."<br>";
	// echo "adicionalDiv: ".$adicionalDiv."<br>";
	// echo "abonadobs: ".$abonadobs."<br>";
	// echo "adicionalbs: ".$adicionalbs."<br>";

	// print_r($eficoin['id_eficoin_div']);
	$id_numero=$eficoin['numero_recibo'];
	// $id_numero = 0;
	// $eficoinssAll = $lider->consultarQuery("SELECT * FROM eficoin_divisas WHERE id_eficoin_div<={$eficoin['id_eficoin_div']}");
	// foreach ($eficoinssAll as $efiall) {
	// 	if(!empty($efiall['id_eficoin_div'])){
	// 		if(mb_strtolower($efiall['estado_pago'])==mb_strtolower("abonado")){
	// 			$id_numero++;	
	// 		}
	// 	}
	// }
	$eficoinssDetails = $lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE id_eficoin_div={$eficoin['id_eficoin_div']}");
	// print_r($eficoinssDetails);
	// $_GET['codigo']="bs";
	$nuevoEquivalenteTotalRecibido = 0;
	foreach ($eficoinssDetails as $efiDetal) {
		if(!empty($efiDetal['id_eficoin_div'])){
			$abonado = (float) number_format($efiDetal['equivalente_pago'],2);
			$abonadoAdd = (float) number_format(($efiDetal['equivalente_pago_total']-$efiDetal['equivalente_pago']),2);
			$abonadoTotal = (float) number_format($efiDetal['equivalente_pago_total'],2);
			if(!empty($_GET['codigo']) && mb_strtolower($_GET['codigo'])=="bs"){
				$bcvtasa=$efiDetal['tasa_bcv'];
				$abonado = (float) number_format(($abonado*$bcvtasa),2,'.','');
			}
			$nuevoEquivalenteTotalRecibido+=(float) $abonado;
		}
	}
	$recibido = (float) $nuevoEquivalenteTotalRecibido;
	// $recibido = (float) $eficoin['equivalente_pago_extra'];
	// $recibido2 = (float) $eficoin['equivalente_pago']*$tasaeficoin;
	// $equivalenteDiv = (float) $recibido2/$tasabcv;
	
	// $adicionalDiv = (float) $equivalenteDiv-$eficoin['equivalente_pago'];
	// $recibido = (float) $eficoin['equivalente_pago']+$adicionalDiv;
	// $abonadobs = (float) $eficoin['equivalente_pago'];
	// $adicionalbs = (float) $adicionalDiv;

	// if(!empty($_GET['codigo']) && mb_strtolower($_GET['codigo'])=="bs"){
	// 	$recibido = (float) $recibido*$tasabcv;
	// }
	
	// foreach ($eficoinssDetails as $kys) {
	// 	print_r($kys);
	// 	echo "<br><br>";
	// }
	// echo "id_numero: ";
    $lim = 7;
    $falta = $lim-strlen($id_numero);
    $num_doc="";
    for ($i=0; $i < $falta; $i++) {
        $num_doc.="0";
    }
    $num_doc .= $id_numero;
	
	$catalag = "1";
	// $almacen = $lider->consultarQuery("SELECT * FROM almacenes WHERE id_almacen={$notaentrega['id_almacen']}");
    // $almacen = $almacen[0];
	
	
	$var = dirname(__DIR__, 3);
	$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
	$urlCss2 = $var . '/public/assets/css/';
	$urlImg = $var . '/public/assets/img/';
	
	ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
	date_default_timezone_set('america/caracas');
    // AV LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL NRO S/N BARRIO PUEBLO NUEVO BARQUISIMETO EDO LARA ZONA POSTAL 3001
	$info = "
		<!DOCTYPE html>
		<html>
			<head>
				<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
				<title>Recepción de Pago - StyleCollection</title>
				
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
							<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1.2em;'>
								<div style='width:40%;display:inline-block;background:;text-align:left;'>
									<h3 style='font-size:1.5em;font-weight:700;'>Recepción de Pagos</h3>
								</div>
								<div style='width:28%;display:inline-block;background:;text-align:left;'>
									<span><b>N° de Control:</b> <u>00-".$num_doc."</u></span>
								</div>
								<div style='width:28%;display:inline-block;background:;text-align:left;'>
									<span><b>Fecha:</b> <u>".$eficoin['fecha_pago']."</u></span>
								</div>
							</div>
							<br>
							<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1.2em;'>
								<div style='width:22%;display:inline-block;background:;text-align:right;'>
									<span>Hemos recibido de:</span>
								</div>
								<div style='width:33%;display:inline-block;background:;text-align:left;'>
									<span><u>".$cliente['primer_nombre']." ".$cliente['primer_apellido']."</u></span>
								</div>
								<div style='width:15%;display:inline-block;background:;text-align:right;'>
									<span>R.I.F. / C.I.:</span>
								</div>
								<div style='width:30%;display:inline-block;background:;text-align:left;'>
									<span><u>".$cliente['cod_rif']."".$cliente['rif']."</u></span>
								</div>
							</div>
							<br>
							<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1.2em;'>
								<div style='width:22%;display:inline-block;background:;text-align:right;'>
									<span>La cantidad de:</span>
								</div>
								<div style='width:78%;display:inline-block;background:;text-align:left;font-size:1.4em;'>
									<span><u>".number_format($recibido,2,',','.')."</u></span>
								</div>
							</div>
							<br>
							<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1.2em;'>
								<div style='width:22%;display:inline-block;background:;text-align:right;'>
									<span>Por Concepto de:</span>
								</div>
								<div style='width:78%;display:inline-block;background:;text-align:left;'>
									<span><u>Abono de ".$eficoin['tipo_pago']." - Campaña ".$campana['numero_campana']."/".$campana['anio_campana']." - Pedido ".$despacho['numero_despacho']." - N° ".$pedido['id_pedido']."</u></span>
								</div>
							</div>
							<br>";
							$sumatoriaTotal=0;
							foreach ($eficoinssDetails as $efiDetal) {
								if(!empty($efiDetal['id_eficoin_div'])){
									$abonado = (float) number_format($efiDetal['equivalente_pago'],2);
									$abonadoAdd = (float) number_format(($efiDetal['equivalente_pago_total']-$efiDetal['equivalente_pago']),2);
									$abonadoTotal = (float) number_format($efiDetal['equivalente_pago_total'],2);
									if(!empty($_GET['codigo']) && mb_strtolower($_GET['codigo'])=="bs"){
										$bcvtasa=$efiDetal['tasa_bcv'];
										// $abonado = (float) $abonado*$tasabcv;
										// $abonadoAdd = (float) $abonadoAdd*$tasabcv;
										// $abonadoTotal = (float) $abonadoTotal*$tasabcv;
										$abonado = (float) number_format(($abonado*$bcvtasa),2,'.','');
										$abonadoAdd = (float) number_format(($abonadoAdd*$bcvtasa),2,'.','');
										$abonadoTotal = (float) ($abonado+$abonadoAdd);
									}
									$mensajeTurno = "";
									if($efiDetal['turno']=="1"){
										$mensajeTurno = " (Mañana)";
									}
									if($efiDetal['turno']=="2"){
										$mensajeTurno = " (Tarde)";
									}
									$sumatoriaTotal+=(float) $abonadoTotal;
									$info .= "
									<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1em;'>
										<div style='width:25%;display:inline-block;background:;text-align:right;'>
											<span>Reportado el: <u>".$lider->formatFechaSlash($eficoin['fecha_pago'])."</u></span>
										</div>
										<div style='width:23%;display:inline-block;background:;text-align:left;'>
											<span> tasa".$mensajeTurno." de <u>".number_format($efiDetal['tasa_eficoin'],2,',','.')."</u></span>
										</div>
										<div style='width:32%;display:inline-block;background:;text-align:right;'>
											<span>EQV: <u>".number_format($abonado,2,',','.')."</u> + <u>".number_format($abonadoAdd,2,',','.')." Des. EfiCoin</span>
										</div>
										<div style='width:17%;display:inline-block;background:;text-align:center;'>
											<span><u><b>Total</b> <u style='width:10px;'></u>".number_format($abonadoTotal,2,',','.')." </u> </span>
										</div>
									</div>
									<br>";
								}
							}
							$info .="
							<div class='text-center' style='width:100%;text-center;display:inline-block;background:;font-size:1.1em;'>
								<div style='width:25%;display:inline-block;background:;text-align:right;'>
								</div>
								<div style='width:25%;display:inline-block;background:;text-align:left;'>
								</div>
								<div style='width:13%;display:inline-block;background:;text-align:right;'>
								</div>
								<div style='width:35%;display:inline-block;background:;text-align:right;'>
									<span><b> TOTAL ABONADO <span style='display:inline-block;width:20px;'></span>".number_format($sumatoriaTotal,2,',','.')." </b> <span style='display:inline-block;width:25px;'></span></span>
								</div>
							</div>
							<br>
						</div>
						<br>
						<table style='width:100%;font-size:1em;' class='tableinfofinal'>
							<tr>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;background:pink;'><b>Líder</b></td>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;background:pink;'><b>Dpto. Comercialización</b></td>
								<td style='padding:4px;width:50%;text-align:left;border:1px solid #CCC;background:pink;'><b>Observaciones</b></td>
							</tr>
							<tr>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;'><div><br><br><br></div></td>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;'><div><br><br><br></div></td>
								<td style='padding:4px;width:50%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-top:1px solid #CCC;'><div></div></td>
							</tr>
							<tr>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;'>Firma</td>
								<td style='padding:4px;width:25%;text-align:center;border:1px solid #CCC;'>Firma</td>
								<td style='padding:4px;width:50%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-bottom:1px solid #CCC;'></td>
							</tr>
						</table>
						";
                        // <div class='' style='width:50%;display:inline-block;text-align:right;'>
                            
                        //     <div style='display:inline-block;'>Despachado por:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        //     <br><br>
                        //     <div style='display:inline-block;margin-left:100px;'>C.I:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        // </div>
                        
                        // <div class='' style='width:50%;display:inline-block;text-align:right;'>
                        //     <div style='display:inline-block;margin-left:13px;'>Recibido por:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        //     <br><br>
                        //     <div style='display:inline-block;margin-left:85px;'>C.I:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        // </div>
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
	$dompdf->stream("Recepcion de pago - StyleCollection", array("Attachment" => false));
	// echo $info;
}

}else{
    require_once 'public/views/error404.php';
}

?>