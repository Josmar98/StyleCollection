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
$notaentregas = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = $nota");
$notaentrega = $notaentregas[0];

$optNotas = $lider->consultarQuery("SELECT * FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = $nota");


$id = $notaentrega['id_cliente'];
$id_cliente = $notaentrega['id_cliente'];
if(mb_strtolower($notaentrega['leyenda'])=="credito style"){
	$persona = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado={$id_cliente}");
}else{
	$persona = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$id_cliente}");
}
if(count($persona)>1){
	$persona=$persona[0];
}
$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
$pedido = $pedidos[0];
$id_pedido = $pedido['id_pedido'];
$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");



$numFactura = "";
// $factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
// if(count($factura)>1){
// 	$numFactura = $factura[0]['numero_factura'];
// 	switch (strlen($factura[0]['numero_factura'])) {
// 		case 1:
// 			$numFactura = "00000".$factura[0]['numero_factura'];
// 			break;
// 		case 2:
// 			$numFactura = "0000".$factura[0]['numero_factura'];
// 			break;
// 		case 3:
// 			$numFactura = "000".$factura[0]['numero_factura'];
// 			break;
// 		case 4:
// 			$numFactura = "00".$factura[0]['numero_factura'];
// 			break;
// 		case 5:
// 			$numFactura = "0".$factura[0]['numero_factura'];
// 			break;
// 		case 6:
// 			$numFactura = "".$factura[0]['numero_factura'];
// 			break;
// 		default:
// 		$numFactura = "".$factura[0]['numero_factura'];
// 		break;
// 	}
// }
	
	// $mostrarListaNotas=$_SESSION['mostrarListaNotasNotaPerso'];
	// $mostrarListaNotas=$_SESSION['mostrarNotasResumidasNotaPerso'];
	$moduloFacturacion="NotasP";
	$id_nota = $_GET['nota'];
	$mostrarNotasResumidas=[];
	$mostrarListaNotas=[];
	$index=0;
	$facturados = $lider->consultarQuery("SELECT * FROM operaciones, notasentrega WHERE operaciones.id_factura=notasentrega.id_nota_entrega and notasentrega.id_nota_entrega={$id_nota} and operaciones.id_factura={$id_nota} and operaciones.modulo_factura='{$moduloFacturacion}' ORDER BY operaciones.id_operacion ASC;");
	foreach ($facturados as $facts) {
		if(!empty($facts['id_factura'])){
			$codigoIndex=$facts['tipo_inventario'].$facts['id_inventario'];
			if(!empty($mostrarNotasResumidas[$codigoIndex])){
				if($facts['tipo_operacion']=="Entrada"){
					$mostrarNotasResumidas[$codigoIndex]['cantidad']-=$facts['stock_operacion'];
				}
				if($facts['tipo_operacion']=="Salida"){
					$mostrarNotasResumidas[$codigoIndex]['cantidad']+=$facts['stock_operacion'];
				}
			}else{
				$mostrarNotasResumidas[$codigoIndex]['cantidad']=0;
				if($facts['tipo_inventario']=="Productos"){
					$inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$facts['id_inventario']}");
				}
				if($facts['tipo_inventario']=="Mercancia"){
					$inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$facts['id_inventario']}");
				}
				// if($facts['tipo_inventario']=="Catalogos"){
				// 	$inventario = $lider->consultarQuery("SELECT *, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$facts['id_inventario']}");
				// }
				foreach ($inventario as $inv) {
					if(!empty($inv['elemento'])){
						$mostrarNotasResumidas[$codigoIndex]['descripcion']=$inv['elemento'];
						$mostrarNotasResumidas[$codigoIndex]['concepto']=$facts['concepto_factura'];
						$mostrarNotasResumidas[$codigoIndex]['tipo_inventario']=$facts['tipo_inventario'];
						$mostrarNotasResumidas[$codigoIndex]['id_inventario']=$facts['id_inventario'];
						if($facts['tipo_operacion']=="Entrada"){
							$mostrarNotasResumidas[$codigoIndex]['cantidad']-=$facts['stock_operacion'];
						}
						if($facts['tipo_operacion']=="Salida"){
							$mostrarNotasResumidas[$codigoIndex]['cantidad']+=$facts['stock_operacion'];
						}
					}
				}
				$preciosNota = $lider->consultarQuery("SELECT precios_nota FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada={$id_nota} and tipo='{$facts['tipo_inventario']}' and producto_premio={$facts['id_inventario']}");
				foreach ($preciosNota as $inv) {
					if(!empty($inv['precios_nota'])){
						$mostrarNotasResumidas[$codigoIndex]['precio_nota']=$inv['precios_nota'];
					}
				}
				// $index++;
			}
		}
	}
	$mostrarListaNotas=$mostrarNotasResumidas;

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
// print_r($colecciones);
// foreach ($colecciones as $key) {
// 	print_r($key);
// 	echo "<br><br>";
// }
// echo "CANTIDAD ELEMENTOS : ".count($colecciones);
$colecciones = $mostrarListaNotas;
// $colecciones=[];
// for ($i=0; $i < 35; $i++) { 
// 	foreach ($mostrarListaNotas as $key) {
// 		$colecciones[count($colecciones)]=$key;
// 	}
// }
$colecciones+=['ejecucion'=>true];


$conTotalResumen = false;
$extrem = 15;
$topEM=30;
if(!empty($_GET['type'])){
	if($_GET['type']=="SP1"){
		$type=1;
	}
	if($_GET['type']=="SP2"){
		$type=2;
	}
	// $type=$_GET['type'];
	if($type==1){
		$topPorcenImg=12;
		$extrem = 15;
		$topEM=30;
	}
	if($type==2){
		$topPorcenImg=25;
		$extrem = 43;
		$topEM=75;
	}
}else{
	$type=1;
}
$classMayus="";
if($type==2){
	$classMayus="mayus";
}
if(!$conTotalResumen){ $extrem++; }
$cifraMultiplo = 1;
$sumPrecioFinal = 0;
$nameFactura = "Nota de Entrega N°";

$simbolo="";
$valorAutomatico=0;
$valorAutomatico=-1;

$info = "
<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
	<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.css'>
	
</head>
<body>
<style>
body{
	font-family:'arial';
}
.mayus{
	text-transform:uppercase;
}
.box-content-final-CFL{
	display:inline-block;
	position:absolute;
	left:1%;
	top:".($topEM+1.5)."em;
	width:37.5%; 
}
.box-content-final-L{
	display:inline-block;
	position:absolute;
	left:2%;
	top:{$topEM}em;
	width:36%; 
	padding-left:5px;
}
.box-content-final-FL{
	display:inline-block;
	position:absolute;
	left:1%;
	top:".($topEM+9)."em;
	width:37.5%; 
}


.box-content-final-CFR{
	display:inline-block;
	position:absolute;
	right:1.27%;
	top:".($topEM+1.5)."em;
	width:35%; 
}
.box-content-final-R{
	display:inline-block;
	position:absolute;
	right:1.27%;
	top:{$topEM}em;
	width:35%; 
	/*padding-right:5px;*/
}
.box-content-final-FR{
	display:inline-block;
	position:absolute;
	right:1.27%;
	top:".($topEM+9)."em;
	width:35%; 
}
.descripciones{
	font-size:0.8em;
}
</style>
<div class='row col-xs-12' style='padding:0;margin:0;'>
	<div class='col-xs-12'  style='padding-left:50px;padding-right:20px;width:100%;'>
		";

		// $coleccioness = array_pop($colecciones);
		// $coleccioness = $colecciones;
		// // $colecciones = [];
		// for ($i=0; $i < 10; $i++) { 
		// 	$countNum = 1;
		// 	foreach($coleccioness as $cols){
		// 		if($countNum <= 12 ){ $colecciones[count($colecciones)] = $cols; }
		// 		$countNum++;
		// 	}
		// }
		// $colecciones+=['estatus'=>true];
		// echo "CANTIDAD ELEMENTOS : ".count($colecciones);
		


		$countProducts = count($colecciones)-1;
		$countPage = 0;
		if($countProducts <= ($extrem-4)){
			$countPage = 1;
		} else {
			$newExtrem = 0;
			$countPage++;
			while($countProducts > (($extrem-4)+$newExtrem)){
				$countPage++;
				$newExtrem += $extrem-1;
			}
		}
		$numPage=1;
		
		$font = "times new roman";
			$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #ED2A77;color:#ED2A77;'>
				<tr>
					<td style='width:25%;text-align:left;'>
						<img src='public/assets/img/logoTipo2.png' style='width:17em;opacity:0.8;'>
					</td>
					
					<td style='width:50%;margin-bottom:0;padding-bottom:0;'>
						<p style='width:100%;font-size:1.7em;margin-bottom:0;transform:scaleY(1.5);'>
							<b style='font-family:".$font." !important;'>INVERSIONES STYLECOLLECTION, CA</b>
						</p>
						<p style='font-size:0.9em;margin-bottom:0;padding-bottom:0;'>
							<b>Rif.:J408497786</b>
						</p>
						<p style='font-size:1em;margin-bottom:0;padding-bottom:0;'>
							<b>
								AV. LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL<br>NRO S/N BARRIO PUEBLO NUEVO BARQUISIMETO<br>EDO LARA ZONA POSTAL 3001
							</b>
						</p>
					</td>

					<td style='width:25%;text-align:left;padding-left:10px'>
						<b style='color:#ED2A77;font-size:1.2em;'>
							FORMA LIBRE
							<br>
							Nro DE CONTROL
						</b>
						<br>
						<b style='color:#ED2A77;margin-left:-2em;font-size:1.8em;'>
							<span style='font-size:;'>00 </span>
							<span style='font-size:;'><b> - </b></span>
							<span style='font-size:;'> ".$numero_nota_entrega."</span>
						</b>
					</td>
				</tr>
			</table>
			<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:".$topPorcenImg."%;left:33%;opacity:0.1;'>
			<div class='row'>
				<div class='col-xs-12'>
					";
					if((count($colecciones)-1)>($extrem-3)){
						$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
					}
					$info.="
					<span class='numeroFactura {$classMayus}'><b>{$nameFactura}</b> <span class='numFact'><b>".$numero_nota_entrega."</b></span></span>			
					<span class='fecha'>
						<table class='{$classMayus}'>
							<tr>
								<td>
									<b>Emision: </b> 
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($notaentrega['fecha_emision'])."</span>
								</td>
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>
							</tr>
						</table>
					</span>

					<br><br>
					<table class='table1 {$classMayus}'>
						<tr>
							<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$persona['primer_nombre']." ".$persona['segundo_nombre']." ".$persona['primer_apellido']." ".$persona['segundo_apellido']."</span></td>
							<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$persona['cod_rif']."".$persona['rif']."</span></td>
						</tr>
						<tr>
							<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$persona['direccion']."</span></td>
							<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$persona['telefono']."</span></td>
						</tr>
					</table>
					";
						if($type==1){
							// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:12.1em;'></div>
						$info.="
						<br>
						<table class='table2 tablecontent' style='width:103%;border:1px solid #AAAAAA;'>
							<tr>
						";
						}
						if($type==2){
							// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.35em;'></div>
						$info.="
						<br>
						<table class='table2 tablecontent' style='width:103%;font-size:1.02em;border:1px solid #AAAAAA;'>
							<tr style='font-size:1.01em;'>
						";
						}
					
					$info.="
							<td class='celtitleL'><b><span style='color:rgba(0,0,0,0);'>__</span>Cantidad</b></td>
							<td class='celtitleL descrip'><b>Descripcion</b></td>
							<td class='celtitleR'><b></b></td>
							<td class='celtitleR'><b></b></td>
							<td class='celtitleR'><b>Precio</b></td>
							<td class='celtitleR'><b>Total<span style='color:rgba(0,0,0,0);'>__</span></b></td>
						</tr>
						<tr style=''>
							<td colspan='6'><span style='width:100%;height:1px;display:block;background:#222222;'></span></td>
						</tr>
						";
						

						$sumaTotales = 0;
						$sumCantProd = 0;
						$sumPrecioProductos = 0;
						$numero=1;
						$numeroReal=1;
						$numerosCols = count($colecciones);

						// echo $numerosCols." | ";
						if($numerosCols >= 1 && $numerosCols <= $extrem){
							$numLim=($extrem-4);
						}else if($numerosCols>$extrem){
							$numLim=($extrem-1);
						}

						// foreach ($colecciones as $cols) {
						// 	if(!empty($cols['id_producto'])){
						// 		if($procederVariado){
						// 			$cantAprobada = $cols['cantidad_aprobado'];
						// 		}else{
						// 			$cantAprobada = $cols['cantidad_aprobado'];
						// 		}
						// 		// echo "numeroLimite: ".$numLim."<br>";
						// 		// if( $numerosCols  
						// 		if($numero<=$numLim){
						// 			$cantProduct = $cols['cantidad_productos']*$cantAprobada;
						// 			// $cantProduct *= $cifraMultiplo; 
									
						// 			$precioUnidProduct = $cols['precio_producto'];
						// 			// $precioUnidProduct *= $cifraMultiplo;

						// 			$total = ($cantProduct*$precioUnidProduct);
						// 			$total *= $cifraMultiplo;

						// 			$sumaTotales+=$total;
									
						// 			$mostrarCantProduct = ""; 
						// 			if( strlen($cantProduct) == 1 ){
						// 				$mostrarCantProduct = "0".$cantProduct;
						// 			}else{
						// 				$mostrarCantProduct = $cantProduct;
						// 			}

						// 			$sumCantProd += $cantProduct;
						// 			$sumPrecioProductos += $precioUnidProduct;
						// 			$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
						// 			//font-size:0.98em;
						// 			if($mostrarCantProduct>0){
						// 				$info.="
						// 				<tr style=''>
						// 					<td style='' class='celcontent cantidades'><span class='content-table'>
						// 						<span style='color:rgba(0,0,0,0);'>__</span>
						// 						".$mostrarCantProduct." 
						// 					</span></td>
						// 					<td class='celcontent descripciones' colspan='3'><span class='content-table'>
						// 						 ".$cols['producto']."
						// 					</span></td>
						// 					<td class='celcontentR precios'><span class='content-table'>
						// 						".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
						// 					</span></td>
						// 					<td class='celcontentR totales'><span class='content-table'>
						// 						".$simbolo."".number_format($total,2,',','.')."
						// 						<span style='color:rgba(0,0,0,0);'>_</span>
						// 					</span></td>
						// 				</tr>
						// 				<tr style=''>
						// 					<td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
						// 				</tr>
						// 				";
						// 			}
						// 			$numeroReal++;
						// 		}
						// 	$numero++;
						// 	}
						// }
						$sumaTotales=0;
						foreach($colecciones as $cols){
							if(!empty($cols['descripcion'])){
								if($numero<=$numLim){
                                    $cols['precio']=$valorAutomatico;
                                    $cols['total']=$valorAutomatico;
									$info.="
									<tr style=''>
										<td style='' class='celcontent cantidades'><span class='content-table'>
											<span style='color:rgba(0,0,0,0);'>__</span>
											".$cols['cantidad']." 
										</span></td>
										<td class='celcontent descripciones' colspan='3'><span class='content-table'>
											".$cols['descripcion'];
											if($notaentrega['leyenda']!="Promociones"){
												$info .= ": ".$cols['concepto'];
											}
											$info .= "
										</span></td>
										<td class='celcontentR precios'><span class='content-table'>
											";
                                            if($valorAutomatico==0){
                                                $info.=$simbolo."".number_format($cols['precio'],2,',','.');
                                            }else{
                                                $info.="---";
                                            }
                                            $info.="
										</span></td>
										<td class='celcontentR totales'><span class='content-table'>
                                            ";
                                            if($valorAutomatico==0){
                                                $info.=$simbolo."".number_format($cols['total'],2,',','.');
                                            }else{
                                                $info.="---";
                                            }
                                            $info.="
											<span style='color:rgba(0,0,0,0);'>_</span>
										</span></td>
									</tr>
									<tr style=''>
										<td colspan='6'><span style='width:100%;height:1px;display:block;background:#AAAAAA;'></span></td>
									</tr>
									";
                                    if($valorAutomatico==0){
                                        $sumaTotales+=$cols['total'];
                                    }else{
                                        $sumaTotales=0;
                                    }
									$numeroReal++;
								}
								$numero++;
							}
						}


						$ivattt = ($sumaTotales/100)*$valorIva;
						// $igtf = ($sumaTotales/100)*3;
						$igtf = 0;
						// $precioFinal = $sumaTotales+$ivattt;
						$precioFinal = $sumaTotales+$ivattt+$igtf;
						if($conTotalResumen && $numero==$numeroReal && $numero==$numerosCols){
							$info.="
								<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
								<tr>
									<td class='celcontent'><span class='content-table'>
										<span style='color:rgba(0,0,0,0);'>__</span>
										".$notaentrega['cantidad_aprobado']."
									</span></td>
									<td class='celcontent'><span class='content-table'>
										Colecciones Cosméticos Campaña ".$numero_campana."-".$anio_campana."
									</span></td>
									<td class='celcontentR'><span class='content-table'>01</span></td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumPrecioFinal,2,',','.')."
									</span></td>
									<td class='celcontentR'><span class='content-table'>16%</span></td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
									</span></td>
								</tr>
							";
						}

						$info .= "
					</table>
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
								<div class='box-content-final-CFL' style='border-bottom:1px solid #434343;'></div>
								<div class='box-content-final-CFR' style='border-bottom:1px solid #434343;'></div>
							";
						}
						$info .= "
					<div class='box-content-final-L'>
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
							<br>
							<table style='width:100%;'>
								<tr>
									<td class='celtitleL' style='width:100%;'>
										Observaciones: 
										<small style='font-size:0.85em;'>";
											if($notaentrega['leyenda']=="Promociones"){
												$info.="<span style='font-size:0.9em;'>".$notaentrega['observacion']."</span>";
											}else{
												$info.="Premios variados";
											}
											$info .= "
										</small>
										<br><b>Campaña ".$numero_campana."-".$anio_campana."</b>
										<span style='color:white;'>-</span>
									</td>
								</tr>
							</table>";
						}
						$info .= "
					</div>
					<div class='box-content-final-R'>
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
							<br>
							<table style='width:100%;'>
								<tr>
									<td class='celtitleR'>Total Neto: </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleR'>I.V.A (".$valorIva."%): </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($ivattt,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleR'>I.G.T.F (".$valorIgtf."%): </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($igtf,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleR'><b>Total Operacion: </b></td>
									<td class='celcontentR'><b><span class='content-table'>".$simbolo."".number_format($precioFinal,2,',','.')."</span></b></td>
								</tr>
							</table>";
						}
						$info .= "
					</div>
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
								<div class='box-content-final-FL' style='border-bottom:1px solid #434343;'></div>
								<div class='box-content-final-FR' style='border-bottom:1px solid #434343;'></div>
							";
						}
						$info .= "
					
				</div>
			</div>

			<footer class='main-footer' style='position:absolute;bottom:0;font-size:1.5em;width:100%;'>
				<!-- <hr class='hr-box'><hr class='hr-box'> -->
				<div >
					<span>
							<br><br>
					</span>
				</div>
		  </footer>";
		 	
		 	if($numeroReal<$numero){
		 		$numPage++;
		 		//margin-top:42.5%;
		  		$info .= "<div style='page-break-after:always;'></div>";
				$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #ED2A77;color:#ED2A77;'>
					<tr>
						<td style='width:25%;text-align:left;'>
							<img src='public/assets/img/logoTipo2.png' style='width:17em;opacity:0.8;'>
						</td>
					
						<td style='width:50%;margin-bottom:0;padding-bottom:0;'>
							<p style='width:100%;font-size:1.7em;margin-bottom:0;transform:scaleY(1.5);'>
								<b style='font-family:".$font." !important;'>INVERSIONES STYLECOLLECTION, CA</b>
							</p>
							<p style='font-size:0.9em;margin-bottom:0;padding-bottom:0;'>
								<b>Rif.:J408497786</b>
							</p>
							<p style='font-size:1em;margin-bottom:0;padding-bottom:0;'>
								<b>
									AV. LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL<br>NRO S/N BARRIO PUEBLO NUEVO BARQUISIMETO<br>EDO LARA ZONA POSTAL 3001
								</b>
							</p>
						</td>
					
						<td style='width:25%;text-align:left;padding-left:10px'>
							<b style='color:#ED2A77;font-size:1.2em;'>
								FORMA LIBRE
								<br>
								Nro DE CONTROL
							</b>
							<br>
							<b style='color:#ED2A77;margin-left:-2em;font-size:1.8em;'>
								<span style='font-size:;'>00 </span>
								<span style='font-size:;'><b> - </b></span>
								<span style='font-size:;'> ".$numero_nota_entrega."</span>
							</b>
						</td>
					</tr>
				</table>
				
				<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:".$topPorcenImg."%;left:33%;opacity:0.1;'>
				<div class='row'>
					<div class='col-xs-12'>
						";
						if((count($colecciones)-1)>($extrem-3)){
							$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
						}
						$info.="
						<span class='numeroFactura {$classMayus}' style='position:absolute;right:36.5%;top:30%;'><br><b>{$nameFactura}</b> 
							<span class='numFact'><b style='position:absolute;left:14.5%;'>".$numero_nota_entrega."</b></span>
						</span>			
						<span class='fecha'>
							<table class='{$classMayus}'>
							<tr>
								<td>
									<b>Emision: </b> 
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($notaentrega['fecha_emision'])."</span>
								</td>
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>
							</tr>
							</table>
						</span>

						<br><br>
						<table class='table1 {$classMayus}'>
							<tr>
								<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']."</span></td>
								<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$pedido['cod_rif']."".$pedido['rif']."</span></td>
							</tr>
							<tr>
								<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$pedido['direccion']."</span></td>
								<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$pedido['telefono']."</span></td>
							</tr>
						</table>
						";
							if($type==1){
								// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
							$info.="
							<br>
							<table class='table2' style='width:100%;border:1px solid #AAAAAA;'>
								<tr>
							";
							}
							if($type==2){
								// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
							$info.="
							<br>
							<table class='table2' style='width:100%;font-size:1.02em;border:1px solid #AAAAAA;'>
								<tr style='font-size:1.01em;'>
							";
							}
						$info.="
								<td class='celtitleL'><b><span style='color:rgba(0,0,0,0);'>__</span>Cantidad</b></td>
								<td class='celtitleL descrip'><b>Descripcion</b></td>
								<td class='celtitleR'><b></b></td>
								<td class='celtitleR'><b></b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>Total<span style='color:rgba(0,0,0,0);'>__</span></b></td>
							</tr>
							<tr style=''>
								<td colspan='6'><span style='width:100%;height:1px;display:block;background:#222222;'></span></td>
							</tr>
							";

							$sumCantProd = 0;
							$sumPrecioProductos = 0;
							$numero=1;
							$numLim2 = $numLim;

							// $info.="numerosCols ".$numerosCols."<br>";
							// $info.="extrem ".$extrem."<br>";
							// $info.="numLim2: ".$numLim2."<br>";
							// $info.="numLim: ".$numLim."<br>";

							if($numerosCols >= (1+$numLim2) && $numerosCols <= ($extrem+$numLim2)){
								$numLim=($extrem-4+$numLim2);
							}else if($numerosCols>($extrem+$numLim2)){
								$numLim=($extrem-1+$numLim2);
							}
							// $info.="numLim: ".$numLim."<br>";

							// foreach ($colecciones as $cols) {
							// 	if(!empty($cols['id_producto'])){
							// 		if($procederVariado){
							// 			$cantAprobada = $cols['cantidad_aprobado'];
							// 		}else{
							// 			$cantAprobada = $cols['cantidad_aprobado'];
							// 		}
							// 		if($numero>$numLim2 && $numero<=$numLim){
							// 			$cantProduct = $cols['cantidad_productos']*$cantAprobada;
							// 			// $cantProduct *= $cifraMultiplo; 
										
							// 			$precioUnidProduct = $cols['precio_producto'];
							// 			// $precioUnidProduct *= $cifraMultiplo;

							// 			$total = ($cantProduct*$precioUnidProduct);
							// 			$total *= $cifraMultiplo;

							// 			$sumaTotales+=$total;
										
							// 			$mostrarCantProduct = ""; 
							// 			if( strlen($cantProduct) == 1 ){
							// 				$mostrarCantProduct = "0".$cantProduct;
							// 			}else{
							// 				$mostrarCantProduct = $cantProduct;
							// 			}

							// 			$sumCantProd += $cantProduct;
							// 			$sumPrecioProductos += $precioUnidProduct;
							// 			$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
							// 			//font-size:0.98em;
							// 			if($mostrarCantProduct>0){
							// 				$info.="
							// 					<tr style=''>
							// 						<td class='celcontent cantidades'><span class='content-table'>
							// 							<span style='color:rgba(0,0,0,0);'>__</span>
							// 							".$mostrarCantProduct."
							// 						</span></td>
							// 						<td class='celcontent descripciones' colspan='3'><span class='content-table'>
							// 							".$cols['producto']."
							// 						</span></td>
							// 						<td class='celcontentR precios'><span class='content-table'>
							// 							".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
							// 						</span></td>
							// 						<td class='celcontentR totales'><span class='content-table'>
							// 							".$simbolo."".number_format($total,2,',','.')."
							// 							<span style='color:rgba(0,0,0,0);'>__</span>
							// 						</span></td>
							// 					</tr>
							// 					";
							// 			}
							// 			$numeroReal++;
							// 		}
							// 		$numero++;
							// 	}
							// }
							foreach($colecciones as $cols){
								if(!empty($cols['descripcion'])){
									if($numero>$numLim2 && $numero<=$numLim){
                                        $cols['precio']=$valorAutomatico;
                                        $cols['total']=$valorAutomatico;
										$info.="
										<tr style=''>
											<td style='' class='celcontent cantidades'><span class='content-table'>
												<span style='color:rgba(0,0,0,0);'>__</span>
												".$cols['cantidad']." 
											</span></td>
											<td class='celcontent descripciones' colspan='3'><span class='content-table'>
												".$cols['descripcion'];
												if($notaentrega['leyenda']!="Promociones"){
													$info .= ": ".$cols['concepto'];
												}
												$info .= "
											</span></td>
											<td class='celcontentR precios'><span class='content-table'>
												";
                                                if($valorAutomatico==0){
                                                    $info.=$simbolo."".number_format($cols['precio'],2,',','.');
                                                }else{
                                                    $info.="---";
                                                }
                                                $info.="
											</span></td>
											<td class='celcontentR totales'><span class='content-table'>
												";
                                                if($valorAutomatico==0){
                                                    $info.=$simbolo."".number_format($cols['total'],2,',','.');
                                                }else{
                                                    $info.="---";
                                                }
                                                $info.="
												<span style='color:rgba(0,0,0,0);'>_</span>
											</span></td>
										</tr>
										<tr style=''>
											<td colspan='6'><span style='width:100%;height:1px;display:block;background:#AAAAAA;'></span></td>
										</tr>
										";
										if($valorAutomatico==0){
                                            $sumaTotales+=$cols['total'];
                                        }else{
                                            $sumaTotales=0;
                                        }
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*$valorIva;
							// $igtf = ($sumaTotales/100)*3;
							$igtf = 0;
							// $precioFinal = $sumaTotales+$ivattt;
							$precioFinal = $sumaTotales+$ivattt+$igtf;
							if($conTotalResumen && $numero==$numeroReal&&$numero==$numerosCols){
								$info.="
								<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
								<tr>
									<td class='celcontent'><span class='content-table'>
										".$factura['cantidad_aprobado']."
									</span></td>
									<td class='celcontent'><span class='content-table'>
										Colecciones Cosméticos Campaña ".$numero_campana."-".$anio_campana."
									</span></td>
									<td class='celcontentR'><span class='content-table'>01</span></td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumPrecioFinal,2,',','.')."
									</span></td>
									<td class='celcontentR'><span class='content-table'>16%</span></td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
									</span></td>
								</tr>
								";
							}

							$info .= "
						</table>

						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
								<div class='box-content-final-CFL' style='border-bottom:1px solid #434343;'></div>
								<div class='box-content-final-CFR' style='border-bottom:1px solid #434343;'></div>
							";
						}
						$info .= "
						<div class='box-content-final-L'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
								<br>
								<table style='width:100%;'>
									<tr>
										<td class='celtitleL' style='width:100%;'>
											Observaciones: 
											<small style='font-size:0.85em;'>";
												if($notaentrega['leyenda']=="Promociones"){
													$info.="<span style='font-size:0.9em;'>".$notaentrega['observacion']."</span>";
												}else{
													$info.="Premios variados";
												}
												$info .= "
											</small>
											<br><b>Campaña ".$numero_campana."-".$anio_campana."</b>
											<span style='color:white;'>-</span>
										</td>
									</tr>
								</table>";
							}
							$info .= "
						</div>
						<div class='box-content-final-R'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
								<br>
								<table style='width:100%;'>
									<tr>
										<td class='celtitleR'>Total Neto: </td>
										<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleR'>I.V.A (".$valorIva."%): </td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($ivattt,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleR'>I.G.T.F (".$valorIgtf."%): </td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($igtf,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleR'><b>Total Operacion: </b></td>
										<td class='celcontentR' style='padding-right:2px;'><b><span class='content-table'>".$simbolo."".number_format($precioFinal,2,',','.')."</span></b></td>
									</tr>
								</table>";
							}
							$info .= "
						</div>
											
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
								<div class='box-content-final-FL' style='border-bottom:1px solid #434343;'></div>
								<div class='box-content-final-FR' style='border-bottom:1px solid #434343;'></div>
							";
						}
						$info .= "

					</div>
				</div>

				<footer class='main-footer' style='position:absolute;bottom:0;font-size:1.5em;width:100%;'>
					<!-- <hr class='hr-box'><hr class='hr-box'> -->
					<div >
						<span>
							<br><br>
						</span>
					</div>
			  </footer>";

		 	}

		 	while($numeroReal<$numero){
		 		$numPage++;
			 	if($numeroReal<$numero){
			 		//margin-top:42.5%;
					$info .= "<div style='page-break-after:always;'></div>";
					$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #ED2A77;color:#ED2A77;'>
						<tr>
							<td style='width:25%;text-align:left;'>
								<img src='public/assets/img/logoTipo2.png' style='width:17em;opacity:0.8;'>
							</td>
							<td style='width:50%;margin-bottom:0;padding-bottom:0;'>
								<p style='width:100%;font-size:1.7em;margin-bottom:0;transform:scaleY(1.5);'>
									<b style='font-family:".$font." !important;'>INVERSIONES STYLECOLLECTION, CA</b>
								</p>
								<p style='font-size:0.9em;margin-bottom:0;padding-bottom:0;'>
									<b>Rif.:J408497786</b>
								</p>
								<p style='font-size:1em;margin-bottom:0;padding-bottom:0;'>
									<b>
										AV. LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL<br>NRO S/N BARRIO PUEBLO NUEVO BARQUISIMETO<br>EDO LARA ZONA POSTAL 3001
									</b>
								</p>
							</td>

							<td style='width:25%;text-align:left;padding-left:10px'>
								<b style='color:#ED2A77;font-size:1.2em;'>
									FORMA LIBRE
									<br>
									Nro DE CONTROL
								</b>
								<br>
								<b style='color:#ED2A77;margin-left:-2em;font-size:1.8em;'>
									<span style='font-size:;'>00 </span>
									<span style='font-size:;'><b> - </b></span>
									<span style='font-size:;'> ".$numero_nota_entrega."</span>
								</b>
							</td>
						</tr>
					</table>
					
					<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:".$topPorcenImg."%;left:33%;opacity:0.1;'>
					<div class='row'>
						<div class='col-xs-12'>
							";
							if((count($colecciones)-1)>($extrem-3)){
								$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
							}
							$info.="
							<span class='numeroFactura {$classMayus}' style='position:absolute;right:36.5%;top:30%;'><br><b>{$nameFactura}</b> 
								<span class='numFact'><b style='position:absolute;left:14.5%;'>".$numero_nota_entrega."</b></span>
							</span>				
							<span class='fecha'>
								<table class='{$classMayus}'>
								<tr>
									<td>
										<b>Emision: </b> 
									</td>
									<td>
										<span class='dates'>".$lider->formatFecha($notaentrega['fecha_emision'])."</span>
									</td>
								</tr>
								<tr>
									<td>
									</td>
									<td>
									</td>
								</tr>
								</table>
							</span>

							<br><br>
							<table class='table1 {$classMayus}'>
								<tr>
									<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']."</span></td>
									<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$pedido['cod_rif']."".$pedido['rif']."</span></td>
								</tr>
								<tr>
									<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$pedido['direccion']."</span></td>
									<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$pedido['telefono']."</span></td>
								</tr>
							</table>
							";
								if($type==1){
									// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
								$info.="
								<br>
								<table class='table2' style='width:100%;border:1px solid #AAAAAA;'>
									<tr>
								";
								}
								if($type==2){
									// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
								$info.="
								<br>
								<table class='table2' style='width:100%;font-size:1.02em;border:1px solid #AAAAAA;'>
									<tr style='font-size:1.01em;'>
								";
								}
							$info.="
									<td class='celtitleL'><b><span style='color:rgba(0,0,0,0);'>__</span>Cantidad</b></td>
									<td class='celtitleL descrip'><b>Descripcion</b></td>
									<td class='celtitleR'><b></b></td>
									<td class='celtitleR'><b></b></td>
									<td class='celtitleR'><b>Precio</b></td>
									<td class='celtitleR'><b>Total<span style='color:rgba(0,0,0,0);'>__</span></b></td>
								</tr>
								<tr style=''>
									<td colspan='6'><span style='width:100%;height:1px;display:block;background:#222222;'></span></td>
								</tr>
								";
								// $sumaTotales = 0;
								$sumCantProd = 0;
								$sumPrecioProductos = 0;
								$numero=1;
								$numLim2 = $numLim;

								// $extrem *= 2;
								if($numerosCols >= (($extrem+1)) && $numerosCols <= $extrem+$numLim2){
									$numLim=($extrem-4+$numLim2);
								}else if($numerosCols>($extrem+$numLim)){
									$numLim=($extrem-1+$numLim2);
								}
								
								// foreach ($colecciones as $cols) {
								// 	if(!empty($cols['id_producto'])){
								// 		if($procederVariado){
								// 			$cantAprobada = $cols['cantidad_aprobado'];
								// 		}else{
								// 			$cantAprobada = $cols['cantidad_aprobado'];
								// 		}
								// 		if($numero>$numLim2 && $numero<=$numLim){
								// 			$cantProduct = $cols['cantidad_productos']*$cantAprobada;
								// 			// $cantProduct *= $cifraMultiplo; 
											
								// 			$precioUnidProduct = $cols['precio_producto'];
								// 			// $precioUnidProduct *= $cifraMultiplo;

								// 			$total = ($cantProduct*$precioUnidProduct);
								// 			$total *= $cifraMultiplo;

								// 			$sumaTotales+=$total;
											
								// 			$mostrarCantProduct = ""; 
								// 			if( strlen($cantProduct) == 1 ){
								// 				$mostrarCantProduct = "0".$cantProduct;
								// 			}else{
								// 				$mostrarCantProduct = $cantProduct;
								// 			}

								// 			$sumCantProd += $cantProduct;
								// 			$sumPrecioProductos += $precioUnidProduct;
								// 			$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
								// 			//font-size:0.98em;
								// 			if($mostrarCantProduct>0){
								// 				$info.="
								// 				<tr style=''>
								// 					<td class='celcontent cantidades'><span class='content-table'>
								// 						<span style='color:rgba(0,0,0,0);'>__</span>
								// 						".$mostrarCantProduct."
								// 					</span></td>
								// 					<td class='celcontent descripciones' colspan='3'><span class='content-table'>
								// 						".$cols['producto']."
								// 					</span></td>
								// 					<td class='celcontentR precios'><span class='content-table'>
								// 						".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
								// 					</span></td>
								// 					<td class='celcontentR totales'><span class='content-table'>
								// 						".$simbolo."".number_format($total,2,',','.')."
								// 						<span style='color:rgba(0,0,0,0);'>__</span>
								// 					</span></td>
								// 				</tr>
								// 				";
								// 			}
								// 			$numeroReal++;
								// 		}
								// 		$numero++;
								// 	}
								// }
								foreach($colecciones as $cols){
									if(!empty($cols['descripcion'])){
										if($numero>$numLim2 && $numero<=$numLim){
                                            $cols['precio']=$valorAutomatico;
                                            $cols['total']=$valorAutomatico;
											$info.="
											<tr style=''>
												<td style='' class='celcontent cantidades'><span class='content-table'>
													<span style='color:rgba(0,0,0,0);'>__</span>
													".$cols['cantidad']." 
												</span></td>
												<td class='celcontent descripciones' colspan='3'><span class='content-table'>
													".$cols['descripcion'];
													if($notaentrega['leyenda']!="Promociones"){
														$info .= ": ".$cols['concepto'];
													}
													$info .= "
												</span></td>
												<td class='celcontentR precios'><span class='content-table'>
													";
                                                    if($valorAutomatico==0){
                                                        $info.=$simbolo."".number_format($cols['precio'],2,',','.');
                                                    }else{
                                                        $info.="---";
                                                    }
                                                    $info.="
												</span></td>
												<td class='celcontentR totales'><span class='content-table'>
													";
                                                    if($valorAutomatico==0){
                                                        $info.=$simbolo."".number_format($cols['total'],2,',','.');
                                                    }else{
                                                        $info.="---";
                                                    }
                                                    $info.="
													<span style='color:rgba(0,0,0,0);'>_</span>
												</span></td>
											</tr>
											<tr style=''>
												<td colspan='6'><span style='width:100%;height:1px;display:block;background:#AAAAAA;'></span></td>
											</tr>
											";
											if($valorAutomatico==0){
                                                $sumaTotales+=$cols['total'];
                                            }else{
                                                $sumaTotales=0;
                                            }
											$numeroReal++;
										}
										$numero++;
									}
								}
								$ivattt = ($sumaTotales/100)*$valorIva;
								// $igtf = ($sumaTotales/100)*3;
								$igtf = 0;
								// $precioFinal = $sumaTotales+$ivattt;
								$precioFinal = $sumaTotales+$ivattt+$igtf;
								if($conTotalResumen && $numero==$numeroReal&&$numero==$numerosCols){
									$info.="
									<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
									<tr>
										<td class='celcontent'><span class='content-table'>
											".$factura['cantidad_aprobado']."
										</span></td>
										<td class='celcontent'><span class='content-table'>
											Colecciones Cosméticos Campaña ".$numero_campana."-".$anio_campana."
										</span></td>
										<td class='celcontentR'><span class='content-table'>01</span></td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($sumPrecioFinal,2,',','.')."
										</span></td>
										<td class='celcontentR'><span class='content-table'>16%</span></td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($sumaTotales,2,',','.')."
										</span></td>
									</tr>
									";
								}

								$info .= "
							</table>

							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
									<div class='box-content-final-CFL' style='border-bottom:1px solid #434343;'></div>
									<div class='box-content-final-CFR' style='border-bottom:1px solid #434343;'></div>
								";
							}
							$info .= "
							<div class='box-content-final-L'>
								";
								if($numero==$numeroReal&&$numero==$numerosCols){
									$info .= "
									<br>
									<table style='width:100%;'>
										<tr>
											<td class='celtitleL' style='width:100%;'>
												Observaciones: 
												<small style='font-size:0.85em;'>";
													if($notaentrega['leyenda']=="Promociones"){
														$info.="<span style='font-size:0.9em;'>".$notaentrega['observacion']."</span>";
													}else{
														$info.="Premios variados";
													}
													$info .= "
												</small>
												<br><b>Campaña ".$numero_campana."-".$anio_campana."</b>
												<span style='color:white;'>-</span>
											</td>
										</tr>
									</table>";
								}
								$info .= "
							</div>
							<div class='box-content-final-R'>
								";
								if($numero==$numeroReal&&$numero==$numerosCols){
									$info .= "
									<br>
									<table style='width:100%;'>
										<tr>
											<td class='celtitleR'>Total Neto: </td>
											<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleR'>I.V.A (".$valorIva."%): </td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($ivattt,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleR'>I.G.T.F (".$valorIgtf."%): </td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($igtf,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleR'><b>Total Operacion: </b></td>
											<td class='celcontentR'><b><span class='content-table'>".$simbolo."".number_format($precioFinal,2,',','.')."</span></b></td>
										</tr>
									</table>";
								}
								$info .= "
							</div>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
									<div class='box-content-final-FL' style='border-bottom:1px solid #434343;'></div>
									<div class='box-content-final-FR' style='border-bottom:1px solid #434343;'></div>
								";
							}
							$info .= "
						</div>
					</div>

					<footer class='main-footer' style='position:absolute;bottom:0;font-size:1.5em;width:100%;'>
						<!-- <hr class='hr-box'><hr class='hr-box'> -->
						<div >
							<span>
								<br><br>
							</span>
						</div>
				  </footer>";
			 	}
		 	}

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

		// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
// $pgl1 = 96.001;
// $ancho = 528.00;
// $alto = 816.009;
// $altoMedio = $alto / 2;
// // $dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta original

$titleDoc = "StyleCollection Fact ".$numero_nota_entrega." - ".$pedido['primer_nombre'];
$dompdf->loadHtml($info);
$dompdf->render();
$dompdf->stream($titleDoc, array("Attachment" => false));
// echo $info;
?>