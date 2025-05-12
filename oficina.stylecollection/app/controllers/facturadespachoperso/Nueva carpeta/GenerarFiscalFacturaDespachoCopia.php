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
	 $facturas = $facturas[0];
	 $precio_coleccion = $facturas['precio_coleccion_campana'];
	 // $iva = $precio_coleccion/100*16;
	 // $precio_coleccion_total = $precio_coleccion * $factura['cantidad_aprobado'];
	 // $ivaT = $precio_coleccion_total/100*16;
	 // $precio_final_factura = $ivaT+$precio_coleccion_total;
	 
	 $numeroFactura = Count($facturas)-1;
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

$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$id_despacho}");

// print_r($colecciones[0]);
$cifraMultiplo = 1;
$extrem = 14;
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
</style>
<div class='row col-xs-12' style='padding:0;margin:0;'>
	<div class='col-xs-12'  style='width:100%;'>
	";		
	$coleccioness = array_pop($colecciones);
	$coleccioness = $colecciones;
	$countNum = 1;
	// $colecciones = [];
	foreach($coleccioness as $cols){
		if($countNum <= 21 ){
			$colecciones[count($colecciones)] = $cols;
		}
		$countNum++;
	}
	$countNum = 1;
	foreach($coleccioness as $cols){
		if($countNum <= 11 ){
			$colecciones[count($colecciones)] = $cols;
		}
		$countNum++;
	}
	$colecciones+=['estatus'=>true];


			$info .= "<table class='' style='text-align:center;width:100%;'>
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

						<span class='numeroFactura'><b>Factura N° </b> <span class='numFact'><b>".$num_factura."</b></span></span>			
					<span class='fecha'>
						<table class=''>
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
					<table class='table1'>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
							<td class='celcontent'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
							<td class='celcontent' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
							
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
							<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
							<td class='celcontent'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
							<td class='celcontent'><span class='content-table'>".$factura['telefono']."</span></td>
							<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
							<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
						</tr>
					</table>
					<br>
					<table class='table2' style='width:100%;'>
						<tr>
							<td class='celtitleL'><b>Cantidad</b></td>
							<td class='celtitleL'><b>Descripcion</b></td>
							<td class='celtitleR'><b>Unid.</b></td>
							<td class='celtitleR'><b>Precio</b></td>
							<td class='celtitleR'><b>I.V.A</b></td>
							<td class='celtitleR'><b>Total</b></td>
						</tr>
						<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
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
								// echo "numeroLimite: ".$numLim."<br>";
								// if( $numerosCols  
								if($numero<=$numLim){
								$cantProduct = $cols['cantidad_productos']*$factura['cantidad_aprobado'];
								// $cantProduct *= $cifraMultiplo; 

								$total = ($cantProduct*$cols['precio_producto']);
								$total *= $cifraMultiplo;
								
								$precioUnidProduct = $cols['precio_producto'];
								// $precioUnidProduct *= $cifraMultiplo;

								$sumaTotales+=$total;
								
								$mostrarCantProduct = ""; 
								if( strlen($cantProduct) == 1 ){
									$mostrarCantProduct = "0".$cantProduct;
								}else{
									$mostrarCantProduct = $cantProduct;
								}

								$sumCantProd += $cantProduct;
								$sumPrecioProductos += $precioUnidProduct;

							$info.="
							<tr style='border-top:1px solid #'>
								<td class='celcontent'><span class='content-table'>
									".$mostrarCantProduct."
								</span></td>
								<td class='celcontent'><span class='content-table'>
									 ".$numero." ".$numeroReal." ".$numerosCols." ".$cols['producto']."
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
							$numeroReal++;
							}
							$numero++;
							}
						}
						$ivattt = ($sumaTotales/100)*16;
						$precioFinal = $sumaTotales+$ivattt;
						// echo $numero."|".$numeroReal."|".$numerosCols."";
						if($numero==$numeroReal && $numero==$numerosCols){

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
								".$simbolo."".number_format($precio_coleccion*$cifraMultiplo,2,',','.')."
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

					<div class='box-content-final'>
						";
						if($numero==$numeroReal&&$numero==$numerosCols){
							$info .= "
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
									<td class='celtitleL'>Total Operacion: </td>
									<td class='celcontentR'><span class='content-table'>".number_format($precioFinal,2,',','.')." ".$simbolo."</span></td>
								</tr>
							</table>";
						}
						$info .= "
					</div>

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
		 		//margin-top:42.5%;
		  	$info .= "<div style='page-break-after:always;'></div>";
			  $info .= "
			  <table class='' style='text-align:center;width:100%;'>
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

							<span class='numeroFactura'><b>Factura N° </b> <span class='numFact' stlye='margin-left:5%'><b>".$num_factura."</b></span></span>			
						<span class='fecha'>
							<table class=''>
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
						<table class='table1'>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
								<td class='celcontent' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
								
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
								<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
								<td class='celcontent'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['telefono']."</span></td>
								<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
							</tr>
						</table>
						<br>
						<table class='table2' style='width:100%;'>
							<tr>
								<td class='celtitleL'><b>Cantidad</b></td>
								<td class='celtitleL'><b>Descripcion</b></td>
								<td class='celtitleR'><b>Unid.</b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>I.V.A</b></td>
								<td class='celtitleR'><b>Total</b></td>
							</tr>
							<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
							";

							// $sumaTotales = 0;
							$sumCantProd = 0;
							$sumPrecioProductos = 0;
							$numero=1;
							$numLim2 = $numLim;

							if($numerosCols >= (($extrem+1)) && $numerosCols <= $extrem+$numLim2){
								$numLim=($extrem-4+$numLim2);
							}else if($numerosCols>($extrem+$numLim)){
								$numLim=($extrem-1+$numLim2);
							}

							foreach ($colecciones as $cols) {
								if(!empty($cols['id_producto'])){
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cols['cantidad_productos']*$factura['cantidad_aprobado'];
										// $cantProduct *= $cifraMultiplo; 

										$total = ($cantProduct*$cols['precio_producto']);
										$total *= $cifraMultiplo;
										
										$precioUnidProduct = $cols['precio_producto'];
										// $precioUnidProduct *= $cifraMultiplo;

										$sumaTotales+=$total;
										
										$mostrarCantProduct = ""; 
										if( strlen($cantProduct) == 1 ){
											$mostrarCantProduct = "0".$cantProduct;
										}else{
											$mostrarCantProduct = $cantProduct;
										}

										$sumCantProd += $cantProduct;
										$sumPrecioProductos += $precioUnidProduct;

										$info.="
										<tr style='border-top:1px solid #'>
											<td class='celcontent'><span class='content-table'>
												".$mostrarCantProduct."
											</span></td>
											<td class='celcontent'><span class='content-table'>
												".$numero." ".$numeroReal." ".$numerosCols." ".$cols['producto']."
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
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*16;
							$precioFinal = $sumaTotales+$ivattt;
							if($numero==$numeroReal&&$numero==$numerosCols){
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
										".$simbolo."".number_format($precio_coleccion*$cifraMultiplo,2,',','.')."
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

						<div class='box-content-final'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
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
										<td class='celtitleL'>Total Operacion: </td>
										<td class='celcontentR'><span class='content-table'>".number_format($precioFinal,2,',','.')." ".$simbolo."</span></td>
									</tr>
								</table>";
							}
							$info .= "
						</div>

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


		 	if($numeroReal<$numero){
		 		//margin-top:42.5%;
		  	$info .= "<div style='page-break-after:always;'></div>";
			  $info .= "
			  <table class='' style='text-align:center;width:100%;'>
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

							<span class='numeroFactura'><b>Factura N° </b> <span class='numFact' style='margin-left:5%;'><b>".$num_factura."</b></span></span>			
						<span class='fecha'>
							<table class=''>
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
						<table class='table1'>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
								<td class='celcontent' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
								
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
								<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
								<td class='celcontent'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['telefono']."</span></td>
								<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
							</tr>
						</table>
						<br>
						<table class='table2' style='width:100%;'>
							<tr>
								<td class='celtitleL'><b>Cantidad</b></td>
								<td class='celtitleL'><b>Descripcion</b></td>
								<td class='celtitleR'><b>Unid.</b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>I.V.A</b></td>
								<td class='celtitleR'><b>Total</b></td>
							</tr>
							<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
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
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cols['cantidad_productos']*$factura['cantidad_aprobado'];
										// $cantProduct *= $cifraMultiplo; 

										$total = ($cantProduct*$cols['precio_producto']);
										$total *= $cifraMultiplo;
										
										$precioUnidProduct = $cols['precio_producto'];
										// $precioUnidProduct *= $cifraMultiplo;

										$sumaTotales+=$total;
										
										$mostrarCantProduct = ""; 
										if( strlen($cantProduct) == 1 ){
											$mostrarCantProduct = "0".$cantProduct;
										}else{
											$mostrarCantProduct = $cantProduct;
										}

										$sumCantProd += $cantProduct;
										$sumPrecioProductos += $precioUnidProduct;

										$info.="
										<tr style='border-top:1px solid #'>
											<td class='celcontent'><span class='content-table'>
												".$mostrarCantProduct."
											</span></td>
											<td class='celcontent'><span class='content-table'>
												".$numero." ".$numeroReal." ".$numerosCols." ".$cols['producto']."
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
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*16;
							$precioFinal = $sumaTotales+$ivattt;
							if($numero==$numeroReal&&$numero==$numerosCols){
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
										".$simbolo."".number_format($precio_coleccion*$cifraMultiplo,2,',','.')."
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

						<div class='box-content-final'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
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
										<td class='celtitleL'>Total Operacion: </td>
										<td class='celcontentR'><span class='content-table'>".number_format($precioFinal,2,',','.')." ".$simbolo."</span></td>
									</tr>
								</table>";
							}
							$info .= "
						</div>

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

		 	if($numeroReal<$numero){
		 		//margin-top:42.5%;
		  	$info .= "<div style='page-break-after:always;'></div>";
			  $info .= "
			  <table class='' style='text-align:center;width:100%;'>
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

							<span class='numeroFactura'><b>Factura N° </b> <span class='numFact' style='margin-left:5%;'><b>".$num_factura."</b></span></span>			
						<span class='fecha'>
							<table class=''>
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
						<table class='table1'>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
								<td class='celcontent' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
								
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
								<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
								<td class='celcontent'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['telefono']."</span></td>
								<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
							</tr>
						</table>
						<br>
						<table class='table2' style='width:100%;'>
							<tr>
								<td class='celtitleL'><b>Cantidad</b></td>
								<td class='celtitleL'><b>Descripcion</b></td>
								<td class='celtitleR'><b>Unid.</b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>I.V.A</b></td>
								<td class='celtitleR'><b>Total</b></td>
							</tr>
							<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
							";
							// $sumaTotales = 0;
							$sumCantProd = 0;
							$sumPrecioProductos = 0;
							$numero=1;
							$numLim2 = $numLim;

							if($numerosCols >= (($extrem+1)) && $numerosCols <= $extrem+$numLim2){
								$numLim=($extrem-4+$numLim2);
							}else if($numerosCols>($extrem+$numLim)){
								$numLim=($extrem-1+$numLim2);
							}
							
							foreach ($colecciones as $cols) {
								if(!empty($cols['id_producto'])){
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cols['cantidad_productos']*$factura['cantidad_aprobado'];
										// $cantProduct *= $cifraMultiplo; 

										$total = ($cantProduct*$cols['precio_producto']);
										$total *= $cifraMultiplo;
										
										$precioUnidProduct = $cols['precio_producto'];
										// $precioUnidProduct *= $cifraMultiplo;

										$sumaTotales+=$total;
										
										$mostrarCantProduct = ""; 
										if( strlen($cantProduct) == 1 ){
											$mostrarCantProduct = "0".$cantProduct;
										}else{
											$mostrarCantProduct = $cantProduct;
										}

										$sumCantProd += $cantProduct;
										$sumPrecioProductos += $precioUnidProduct;

										$info.="
										<tr style='border-top:1px solid #'>
											<td class='celcontent'><span class='content-table'>
												".$mostrarCantProduct."
											</span></td>
											<td class='celcontent'><span class='content-table'>
												".$numero." ".$numeroReal." ".$numerosCols." ".$cols['producto']."
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
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*16;
							$precioFinal = $sumaTotales+$ivattt;
							if($numero==$numeroReal&&$numero==$numerosCols){
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
										".$simbolo."".number_format($precio_coleccion*$cifraMultiplo,2,',','.')."
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

						<div class='box-content-final'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
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
										<td class='celtitleL'>Total Operacion: </td>
										<td class='celcontentR'><span class='content-table'>".number_format($precioFinal,2,',','.')." ".$simbolo."</span></td>
									</tr>
								</table>";
							}
							$info .= "
						</div>

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

		 	if($numeroReal<$numero){
		 		//margin-top:42.5%;
		  	$info .= "<div style='page-break-after:always;'></div>";
			  $info .= "
			  <table class='' style='text-align:center;width:100%;'>
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

							<span class='numeroFactura'><b>Factura N° </b> <span class='numFact' style='margin-left:5%;'><b>".$num_factura."</b></span></span>			
						<span class='fecha'>
							<table class=''>
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
						<table class='table1'>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
								<td class='celcontent' colspan='3'><span class='content-table'>".$factura['direccion']."</span></td>
								
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
								<!-- <td class='celcontent'><span class='content-table'>".$factura['cod_cedula']."-".number_format($factura['cedula'],0,'','.')."</span></td> -->
								<td class='celcontent'><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['telefono']."</span></td>
								<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
								<td class='celcontent'><span class='content-table'>".$factura['tipo_factura']."</span></td>
							</tr>
						</table>
						<br>
						<table class='table2' style='width:100%;'>
							<tr>
								<td class='celtitleL'><b>Cantidad</b></td>
								<td class='celtitleL'><b>Descripcion</b></td>
								<td class='celtitleR'><b>Unid.</b></td>
								<td class='celtitleR'><b>Precio</b></td>
								<td class='celtitleR'><b>I.V.A</b></td>
								<td class='celtitleR'><b>Total</b></td>
							</tr>
							<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
							";
							// $sumaTotales = 0;
							$sumCantProd = 0;
							$sumPrecioProductos = 0;
							$numero=1;
							$numLim2 = $numLim;

							if($numerosCols >= (($extrem+1)) && $numerosCols <= $extrem+$numLim2){
								$numLim=($extrem-4+$numLim2);
							}else if($numerosCols>($extrem+$numLim)){
								$numLim=($extrem-1+$numLim2);
							}
							
							foreach ($colecciones as $cols) {
								if(!empty($cols['id_producto'])){
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cols['cantidad_productos']*$factura['cantidad_aprobado'];
										// $cantProduct *= $cifraMultiplo; 

										$total = ($cantProduct*$cols['precio_producto']);
										$total *= $cifraMultiplo;
										
										$precioUnidProduct = $cols['precio_producto'];
										// $precioUnidProduct *= $cifraMultiplo;

										$sumaTotales+=$total;
										
										$mostrarCantProduct = ""; 
										if( strlen($cantProduct) == 1 ){
											$mostrarCantProduct = "0".$cantProduct;
										}else{
											$mostrarCantProduct = $cantProduct;
										}

										$sumCantProd += $cantProduct;
										$sumPrecioProductos += $precioUnidProduct;

										$info.="
										<tr style='border-top:1px solid #'>
											<td class='celcontent'><span class='content-table'>
												".$mostrarCantProduct."
											</span></td>
											<td class='celcontent'><span class='content-table'>
												".$numero." ".$numeroReal." ".$numerosCols." ".$cols['producto']."
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
										$numeroReal++;
									}
									$numero++;
								}
							}
							$ivattt = ($sumaTotales/100)*16;
							$precioFinal = $sumaTotales+$ivattt;
							if($numero==$numeroReal&&$numero==$numerosCols){
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
										".$simbolo."".number_format($precio_coleccion*$cifraMultiplo,2,',','.')."
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

						<div class='box-content-final'>
							";
							if($numero==$numeroReal&&$numero==$numerosCols){
								$info .= "
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
										<td class='celtitleL'>Total Operacion: </td>
										<td class='celcontentR'><span class='content-table'>".number_format($precioFinal,2,',','.')." ".$simbolo."</span></td>
									</tr>
								</table>";
							}
							$info .= "
						</div>

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

		// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
echo $info;
// $dompdf->loadHtml($info);
// $pgl1 = 96.001;
// $ancho = 528.00;
// $alto = 816.009;
// $altoMedio = $alto / 2;
// // $dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta original
// $dompdf->render();
// $dompdf->stream("StyleCollection Fact ".$num_factura." - ".$factura['primer_nombre'], array("Attachment" => false));

?>