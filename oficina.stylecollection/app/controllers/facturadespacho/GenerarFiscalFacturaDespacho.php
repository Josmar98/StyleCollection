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

  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";


	 $lider = new Models();
	 $query = "SELECT * FROM clientes, despachos, pedidos, factura_despacho WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.id_factura_despacho=$id";
	$facturas = $lider->consultarQuery($query);

	 $factura = $facturas[0];
	 $emision = $factura['fecha_emision'];
	 // $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision'");
	 // $tasa = $tasas[0];
	 // $precio_coleccion = $tasa['monto_tasa'] * $factura['precio_coleccion'];
	 $query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1";
	 $facturas = $lider->consultarQuery($query);
	 // $facturas = $facturas[0];
	 // $precio_coleccion = $facturas['precio_coleccion_campana'];
	 // $iva = $precio_coleccion/100*16;
	 // $precio_coleccion_total = $precio_coleccion * $factura['cantidad_aprobado'];
	 // $ivaT = $precio_coleccion_total/100*16;
	 // $precio_final_factura = $ivaT+$precio_coleccion_total;
	 
	// $numeroFactura = Count($facturas)-1;
	$num_factura2 = $factura['numero_factura'];
	if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
	else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
	else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
	else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
	else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
	else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
	else{$num_factura = $num_factura2;}


	// $simbolo="Bss";
	$simbolo="";
$var = dirname(__DIR__, 3);
	$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
	$urlCss2 = $var . '/public/assets/css/';
	$urlImg = $var . '/public/assets/img/';

ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
date_default_timezone_set('america/caracas');
	

$buscarFacturasVariadas = $lider->consultarQuery("SELECT * FROM factura_despacho_variadas WHERE id_factura_despacho={$factura['id_factura_despacho']} and estatus=1 ORDER BY factura_despacho_variadas.id_pedido_factura ASC");
$procederVariado = false;
$colecciones = [];
$cantAprobadaTotal = 0;
if(count($buscarFacturasVariadas)>1){
	$procederVariado = true;
	foreach ($buscarFacturasVariadas as $variadas) {
		if(!empty($variadas['id_factura_despacho'])){
			//Buscar despacho
			$idPedidoFactura=$variadas['id_pedido_factura'];
			$buscarDespacho = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido={$idPedidoFactura}");
			$idDespachoFactura = $buscarDespacho[0]['id_despacho'];
			$cantidadAprobadoFactura = $buscarDespacho[0]['cantidad_aprobado_individual'];
			$cantAprobadaTotal+=$cantidadAprobadoFactura;

			$coleccionesss=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$idDespachoFactura}");
			foreach ($coleccionesss as $key) {
				if(!empty($key['id_coleccion'])){
					$key['cantidad_aprobado']=$cantidadAprobadoFactura;
					$colecciones[count($colecciones)]=$key;
				}
			}
			// echo "SELECT colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}";
			$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}");
			foreach ($coleccionesSec as $key) {
				if(!empty($key['id_coleccion'])){
					$colecciones[count($colecciones)]=$key;
				}
			}

		}
	}
	// echo "<br><br>";
	// echo "APROBADOS: ".$cantAprobadaTotal;
	// foreach ($colecciones as $key) {
	// 	print_r($key);
	// 	echo "<br><br>";
	// }
	$colecciones[count($colecciones)]=['estatus'=>true];
}else{
	$procederVariado = false;
	$cantAprobadaTotal = $factura['cantidad_aprobado_individual'];
	$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$id_despacho}");

	for ($i=0; $i < count($colecciones); $i++) {
		if(!empty($colecciones[$i]['id_coleccion'])){
			$colecciones[$i]['cantidad_aprobado']=$cantAprobadaTotal;
		}
	}
	$idPedidoFactura=$factura['id_pedido'];
	$idDespachoFactura = $factura['id_despacho'];
	// echo "Despacho: ".$idPedidoFactura."<br>";
	// echo "Pedido: ".$idDespachoFactura."<br>";

	$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}");
	$coleccioness = array_pop($colecciones);
	foreach ($coleccionesSec as $key) {
		if(!empty($key['id_coleccion'])){
			$colecciones[count($colecciones)]=$key;
		}
	}
	$colecciones[count($colecciones)]=['estatus'=>true];
}
// print_r($colecciones);
// foreach ($colecciones as $key) {
// 	print_r($key);
// 	echo "<br><br>";
// }
// echo "CANTIDAD ELEMENTOS : ".count($colecciones);

$conTotalResumen = false;
$extrem = 15;
$topEM=30;
if(!empty($_GET['t'])){
	$type=$_GET['t'];
	if($type==1){
		$extrem = 15;
		$topEM=30;
	}
	if($type==2){
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
$nameFactura = "Factura N°";
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
	top:".($topEM+6.3)."em;
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
	top:".($topEM+6.3)."em;
	width:35%; 
}
</style>
<div class='row col-xs-12' style='padding:0;margin:0;'>
	<div class='col-xs-12'  style='padding-left:50px;padding-right:20px;width:100%;'>
		";

		// $coleccioness = array_pop($colecciones);
		// $coleccioness = $colecciones;
		// // $colecciones = [];
		// for ($i=0; $i < 7; $i++) { 
		// 	$countNum = 1;
		// 	foreach($coleccioness as $cols){
		// 		if($countNum <= 12 ){ $colecciones[count($colecciones)] = $cols; }
		// 		$countNum++;
		// 	}
		// }
		// $colecciones+=['estatus'=>true];
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
			$info .= "<table class='' style='text-align:center;width:100%;margin-top:-10px;'>
				<tr>
					<td style='width:25%'>
					</td>
					
					<td style='width:45%'>
						<h3 style='width:100%;font-size:2em;margin-bottom:0;'>
							<br>
						</h3>
						<p style='font-size:1.2em;' class='sans-serif'>
						<br>
						</p>
						<small class='sans-serif'>
							<br>
							<br>
						</small>
					</td>

					<td style='width:20%;text-align:left;margin-left:50px'>
					</td>
				</tr>
			</table>
			<img src='public/assets/img/icon2.jpg' style='width:15em;height:15em;position:absolute;z-index:-10%;top:18%;left:40%;opacity:0;'>	
			<div class='row'>
				<div class='col-xs-12'>
					";
					if((count($colecciones)-1)>($extrem-3)){
						$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
					}
					$info.="
					<span class='numeroFactura {$classMayus}'><b>{$nameFactura}</b> <span class='numFact'><b>".$num_factura."</b></span></span>			
					<span class='fecha'>
						<table class='{$classMayus}'>
							<tr>
								<td>
									<b>Emision: </b> 
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($factura['fecha_emision'])."</span>
								</td>
							</tr>
							<tr>
								<td>
									<b>Vence: </b>
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($factura['fecha_vencimiento'])."</span>
								</td>
							</tr>
						</table>
					</span>

					<br><br>
					<table class='table1 {$classMayus}'>
						<tr>
							<td class='celtitle2' style='width:15% !important;'><b class='titulo-table'>Cliente: </b></td>
							<td class='celcontent' style='width:80% !important;' colspan='3'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2' style='width:15% !important;'><b class='titulo-table'>Dirección: <br><br></b></td>
							<td class='celcontent' style='width:80% !important;' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
						</tr>
						<tr>
							<td class='celtitle2 style='width:15% !important;'><b class='titulo-table'>Cédula o RIF: </b></td>
							<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
							<td class='celcontent' style='width:80% !important;'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2' style='width:15% !important;'><b class='titulo-table'>Telefono: </b></td>
							<td class='celcontent' style='width:80% !important;'><span class='content-table'>".$factura['telefono']."</span></td>
							<td class='celtitle2R' style='width:30%;'><b class='titulo-table'>Forma de Pago: </b></td>
							<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
						</tr>
					</table>
					";
						if($type==1){
						$info.="
						<br>
						<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:12.1em;'></div>
						<table class='table2' style='width:100%;'>
							<tr>
						";
						}
						if($type==2){
						$info.="
						<br>
						<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.35em;'></div>
						<table class='table2' style='width:100%;font-size:1.02em;'>
							<tr style='font-size:1.01em;'>
						";
						}
					
					$info.="
							<td class='celtitleL'><b>Cantidad</b></td>
							<td class='celtitleL'><b>Descripcion</b></td>
							<td class='celtitleR'><b>Unid.</b></td>
							<td class='celtitleR'><b>Precio</b></td>
							<td class='celtitleR'><b>I.V.A</b></td>
							<td class='celtitleR'><b>Total</b></td>
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

						foreach ($colecciones as $cols) {
							if(!empty($cols['id_producto'])){
								if($procederVariado){
									$cantAprobada = $cols['cantidad_aprobado'];
								}else{
									$cantAprobada = $cols['cantidad_aprobado'];
								}
								// echo "numeroLimite: ".$numLim."<br>";
								// if( $numerosCols  
								if($numero<=$numLim){
									$cantProduct = $cols['cantidad_productos']*$cantAprobada;
									// $cantProduct *= $cifraMultiplo; 
									
									$precioUnidProduct = $cols['precio_producto'];
									// $precioUnidProduct *= $cifraMultiplo;

									$total = ($cantProduct*$precioUnidProduct);
									$total *= $cifraMultiplo;

									$sumaTotales+=$total;
									
									$mostrarCantProduct = ""; 
									if( strlen($cantProduct) == 1 ){
										$mostrarCantProduct = "0".$cantProduct;
									}else{
										$mostrarCantProduct = $cantProduct;
									}

									$sumCantProd += $cantProduct;
									$sumPrecioProductos += $precioUnidProduct;
									$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
									//font-size:0.98em;
									if($mostrarCantProduct>0){
									$info.="
										<tr style=''>
											<td style='' class='celcontent'><span class='content-table' style='padding-left:15px;'>
												".$mostrarCantProduct." 
											</span></td>
											<td class='celcontent'><span class='content-table'>
												 ".$cols['producto']."
											</span></td>
											<td class='celcontentR'><span class='content-table'>01</span></td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
											</span></td>
											<td class='celcontentR'><span class='content-table'>16%</span></td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($total,2,',','.')."
											</span></td>
										</tr>
										";
									}
									$numeroReal++;
								}
							$numero++;
							}
						}


						$ivattt = ($sumaTotales/100)*16;
						$precioFinal = $sumaTotales+$ivattt;
						if($conTotalResumen && $numero==$numeroReal && $numero==$numerosCols){
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
									<td class='celtitleL' style='width:40%;'>Observaciones: <br><span style='color:white;'>-</span></td>
									<td class='celcontentR' style='width:60%;'><span class='content-table'>
										".$cantAprobadaTotal." Colecciones Variadas<br>
										<b>Campaña ".$numero_campana."-".$anio_campana."</b>
									</span></td>
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
									<td class='celtitleL'>Total Neto: </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleL'>Impuesto (I.V.A): </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($ivattt,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleL'><b>Total Operacion: </b></td>
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
			  $info .= "
			  <table class='' style='text-align:center;width:100%;margin-top:-10px;'>
					<tr>
						<td style='width:25%'>
						</td>
						
						<td style='width:45%'>
							<h3 style='width:100%;font-size:2em;margin-bottom:0;'>
								<br>
							</h3>
							<p style='font-size:1.2em;' class='sans-serif'>
							<br>
							</p>
							<small class='sans-serif'>
								<br>
								<br>
							</small>
						</td>

						<td style='width:20%;text-align:left;margin-left:50px'>
						</td>
					</tr>
				</table>
				
				<img src='public/assets/img/icon2.jpg' style='width:15em;height:15em;position:absolute;z-index:-10%;top:18%;left:40%;opacity:0;'>	
				<div class='row'>
					<div class='col-xs-12'>
						";
						if((count($colecciones)-1)>($extrem-3)){
							$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
						}
						$info.="
						<span class='numeroFactura {$classMayus}' style='position:absolute;right:36.5%;top:30%;'><br><b>{$nameFactura}</b> 
							<span class='numFact'><b style='position:absolute;left:14.5%;'>".$num_factura."</b></span>
						</span>			
						<span class='fecha'>
							<table class='{$classMayus}'>
							<tr>
								<td>
									<b>Emision: </b> 
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($factura['fecha_emision'])."</span>
								</td>
							</tr>
							<tr>
								<td>
									<b>Vence: </b>
								</td>
								<td>
									<span class='dates'>".$lider->formatFecha($factura['fecha_vencimiento'])."</span>
								</td>
							</tr>
							</table>
						</span>

						<br><br>
						<table class='table1 {$classMayus}'>
							<tr>
								<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Cliente: </b></td>
								<td class='celcontent' style='width:76% !important;'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Dirección: <br><br></b></td>
								<td class='celcontent' style='width:76% !important;' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
								
							</tr>
							<tr>
								<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
								<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Cédula o RIF: </b></td>
								<td class='celcontent' style='width:76% !important;'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Telefono: </b></td>
								<td class='celcontent' style='width:76% !important;'><span class='content-table'>".$factura['telefono']."</span></td>
								<td class='celtitle2R' style='width:30%;'><b class='titulo-table'>Forma de Pago: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
							</tr>
						</table>
						";
							if($type==1){
							$info.="
							<br>
							<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
							<table class='table2' style='width:100%;'>
								<tr>
							";
							}
							if($type==2){
							$info.="
							<br>
							<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
							<table class='table2' style='width:100%;font-size:1.02em;'>
								<tr style='font-size:1.01em;'>
							";
							}
						$info.="
								<td class='celtitleL'><b>Cantidad</b></td>
								<td class='celtitleL'><b>Descripcion</b></td>
								<td class='celtitleR'><b>Unid.</b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>I.V.A</b></td>
								<td class='celtitleR'><b>Total</b></td>
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

							foreach ($colecciones as $cols) {
								if(!empty($cols['id_producto'])){
									if($procederVariado){
										$cantAprobada = $cols['cantidad_aprobado'];
									}else{
										$cantAprobada = $cols['cantidad_aprobado'];
									}
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cols['cantidad_productos']*$cantAprobada;
										// $cantProduct *= $cifraMultiplo; 
										
										$precioUnidProduct = $cols['precio_producto'];
										// $precioUnidProduct *= $cifraMultiplo;

										$total = ($cantProduct*$precioUnidProduct);
										$total *= $cifraMultiplo;

										$sumaTotales+=$total;
										
										$mostrarCantProduct = ""; 
										if( strlen($cantProduct) == 1 ){
											$mostrarCantProduct = "0".$cantProduct;
										}else{
											$mostrarCantProduct = $cantProduct;
										}

										$sumCantProd += $cantProduct;
										$sumPrecioProductos += $precioUnidProduct;
										$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
										//font-size:0.98em;
										if($mostrarCantProduct>0){
										$info.="
											<tr style=''>
												<td class='celcontent'><span class='content-table'>
													".$mostrarCantProduct."
												</span></td>
												<td class='celcontent'><span class='content-table'>
													".$cols['producto']."
												</span></td>
												<td class='celcontentR'><span class='content-table'>01</span></td>
												<td class='celcontentR'><span class='content-table'>
													".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
												</span></td>
												<td class='celcontentR'><span class='content-table'>16%</span></td>
												<td class='celcontentR'><span class='content-table'>
													".$simbolo."".number_format($total,2,',','.')."
												</span></td>
											</tr>
											";
										}
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*16;
							$precioFinal = $sumaTotales+$ivattt;
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
										<td class='celtitleL' style='width:40%;'>Observaciones: <br><span style='color:white;'>-</span></td>
										<td class='celcontentR' style='width:60%;'><span class='content-table'>
											".$cantAprobadaTotal." Colecciones Variadas<br>
											<b>Campaña ".$numero_campana."-".$anio_campana."</b>
										</span></td>
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
										<td class='celtitleL'>Total Neto: </td>
										<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleL'>Impuesto (I.V.A): </td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($ivattt,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleL'><b>Total Operacion: </b></td>
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
				  $info .= "
				  <table class='' style='text-align:center;width:100%;margin-top:-10px;'>
						<tr>
							<td style='width:25%'>
							</td>
							
							<td style='width:45%'>
								<h3 style='width:100%;font-size:2em;margin-bottom:0;'>
									<br>
								</h3>
								<p style='font-size:1.2em;' class='sans-serif'>
								<br>
								</p>
								<small class='sans-serif'>
									<br>
									<br>
								</small>
							</td>

							<td style='width:20%;text-align:left;margin-left:50px'>
							</td>
						</tr>
					</table>
					
					<img src='public/assets/img/icon2.jpg' style='width:15em;height:15em;position:absolute;z-index:-10%;top:18%;left:40%;opacity:0;'>	
					<div class='row'>
						<div class='col-xs-12'>
							";
							if((count($colecciones)-1)>($extrem-3)){
								$info.="<span style='font-size:1em;'><b>{$numPage}/{$countPage}</b></span>";
							}
							$info.="
							<span class='numeroFactura {$classMayus}' style='position:absolute;right:36.5%;top:30%;'><br><b>{$nameFactura}</b> 
								<span class='numFact'><b style='position:absolute;left:14.5%;'>".$num_factura."</b></span>
							</span>				
							<span class='fecha'>
								<table class='{$classMayus}'>
								<tr>
									<td>
										<b>Emision: </b> 
									</td>
									<td>
										<span class='dates'>".$lider->formatFecha($factura['fecha_emision'])."</span>
									</td>
								</tr>
								<tr>
									<td>
										<b>Vence: </b>
									</td>
									<td>
										<span class='dates'>".$lider->formatFecha($factura['fecha_vencimiento'])."</span>
									</td>
								</tr>
								</table>
							</span>

							<br><br>
							<table class='table1 {$classMayus}'>
								<tr>
									<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Cliente: </b></td>
									<td class='celcontent' style='width:86% !important;'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Dirección: <br><br></b></td>
									<td class='celcontent' style='width:86% !important;' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
									
								</tr>
								<tr>
									<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
									<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Cédula o RIF: </b></td>
									<td class='celcontent' style='width:86% !important;'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td class='celtitle2' style='width:24% !important;'><b class='titulo-table'>Telefono: </b></td>
									<td class='celcontent' style='width:86% !important;'><span class='content-table'>".$factura['telefono']."</span></td>
									<td class='celtitle2R' style='width:30%;'><b class='titulo-table'>Forma de Pago: </b></td>
									<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
								</tr>
							</table>
							";
								if($type==1){
								$info.="
								<br>
								<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
								<table class='table2' style='width:100%;'>
									<tr>
								";
								}
								if($type==2){
								$info.="
								<br>
								<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
								<table class='table2' style='width:100%;font-size:1.02em;'>
									<tr style='font-size:1.01em;'>
								";
								}
							$info.="
									<td class='celtitleL'><b>Cantidad</b></td>
									<td class='celtitleL'><b>Descripcion</b></td>
									<td class='celtitleR'><b>Unid.</b></td>
									<td class='celtitleR'><b>Precio</b></td>
									<td class='celtitleR'><b>I.V.A</b></td>
									<td class='celtitleR'><b>Total</b></td>
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
								
								foreach ($colecciones as $cols) {
									if(!empty($cols['id_producto'])){
										if($procederVariado){
											$cantAprobada = $cols['cantidad_aprobado'];
										}else{
											$cantAprobada = $cols['cantidad_aprobado'];
										}
										if($numero>$numLim2 && $numero<=$numLim){
											$cantProduct = $cols['cantidad_productos']*$cantAprobada;
											// $cantProduct *= $cifraMultiplo; 
											
											$precioUnidProduct = $cols['precio_producto'];
											// $precioUnidProduct *= $cifraMultiplo;

											$total = ($cantProduct*$precioUnidProduct);
											$total *= $cifraMultiplo;

											$sumaTotales+=$total;
											
											$mostrarCantProduct = ""; 
											if( strlen($cantProduct) == 1 ){
												$mostrarCantProduct = "0".$cantProduct;
											}else{
												$mostrarCantProduct = $cantProduct;
											}

											$sumCantProd += $cantProduct;
											$sumPrecioProductos += $precioUnidProduct;
											$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
											//font-size:0.98em;
											if($mostrarCantProduct>0){
												$info.="
												<tr style=''>
													<td class='celcontent'><span class='content-table'>
														".$mostrarCantProduct."
													</span></td>
													<td class='celcontent'><span class='content-table'>
														".$cols['producto']."
													</span></td>
													<td class='celcontentR'><span class='content-table'>01</span></td>
													<td class='celcontentR'><span class='content-table'>
														".$simbolo."".number_format($precioUnidProduct*$cifraMultiplo,2,',','.')."
													</span></td>
													<td class='celcontentR'><span class='content-table'>16%</span></td>
													<td class='celcontentR'><span class='content-table'>
														".$simbolo."".number_format($total,2,',','.')."
													</span></td>
												</tr>
												";
											}
											$numeroReal++;
										}
										$numero++;
									}
								}
								$ivattt = ($sumaTotales/100)*16;
								$precioFinal = $sumaTotales+$ivattt;
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
											<td class='celtitleL' style='width:40%;'>Observaciones: <br><span style='color:white;'>-</span></td>
											<td class='celcontentR' style='width:60%;'><span class='content-table'>
												".$cantAprobadaTotal." Colecciones Variadas<br>
												<b>Campaña ".$numero_campana."-".$anio_campana."</b>
											</span></td>
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
											<td class='celtitleL'>Total Neto: </td>
											<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($sumaTotales,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleL'>Impuesto (I.V.A): </td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($ivattt,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleL'><b>Total Operacion: </b></td>
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
// echo $info;
$dompdf->loadHtml($info);
$dompdf->render();
$dompdf->stream("StyleCollection Fact ".$num_factura." - ".$factura['primer_nombre'], array("Attachment" => false));

?>