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
	 $query = "SELECT * FROM clientes, factura_personalizada WHERE factura_personalizada.id_cliente = clientes.id_cliente and factura_personalizada.id_factura_personalizada={$id}";
	$facturas = $lider->consultarQuery($query);

	// die();
	 $factura = $facturas[0];
	 $emision = $factura['fecha_emision'];
	 // $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision'");
	 // $tasa = $tasas[0];
	 // $precio_coleccion = $tasa['monto_tasa'] * $factura['precio_coleccion'];
	 // $query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1";
	 // $facturas = $lider->consultarQuery($query);
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
	

$buscarFacturasVariadas = $lider->consultarQuery("SELECT * FROM lista_factura_personalizada WHERE id_factura_personalizada={$id} and estatus=1");
$procederVariado = false;
$colecciones = [];
$cantAprobadaTotal = 0;
if(count($buscarFacturasVariadas)>1){
	$procederVariado = true;
	$contarColecciones = 0;
	foreach ($buscarFacturasVariadas as $variadas) {
		if(!empty($variadas['id_factura_personalizada'])){
			$contarColecciones+=$variadas['cantidades'];
		}
	}

	foreach ($buscarFacturasVariadas as $variadas) {
		if(!empty($variadas['id_factura_personalizada'])){
			//Buscar despacho

			$buscarRubro = [];
			if($variadas['tipos']=="Productos"){
				$buscarRubro = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus=1 and productos.id_producto={$variadas['id_productos']}");
			}
			if($variadas['tipos']=="Premios"){
				$buscarRubro = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus=1 and premios.id_premio={$variadas['id_premios']}");
			}
			// foreach ($buscarRubro as $keys) {
			// 	if(!empty($keys['estatus'])){
			// 		print_r($keys);
			// 	}
			// }
			// echo $contarColecciones;
			foreach ($buscarRubro as $keys) {
				if(!empty($keys['estatus'])){
					$longCol = count($colecciones);
					$colecciones[$longCol] = $variadas;
					// $colecciones[$longCol]['cantidad_productos'] = $colecciones[$longCol]['cantidades'];
					$colecciones[$longCol]['precio_producto'] = $colecciones[$longCol]['precios'];
					foreach ($keys as $key => $value) {
						if(is_string($key)){
							$colecciones[$longCol][$key] = $value;
						}
					}
					if($colecciones[$longCol]['tipos']=="Productos"){
						$colecciones[$longCol]['rubro'] = $colecciones[$longCol]['producto'];
					}
					if($colecciones[$longCol]['tipos']=="Premios"){
						$colecciones[$longCol]['rubro'] = $colecciones[$longCol]['nombre_premio'];
					}
					
				}
			}
			$cantAprobadaTotal = $contarColecciones;
			// $buscarDespacho = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido={$variadas['id_pedido_factura']}");
			// $idDespachoFactura = $buscarDespacho[0]['id_despacho'];
			// $cantidadAprobadoFactura = $buscarDespacho[0]['cantidad_aprobado'];
			// $cantAprobadaTotal+=$cantidadAprobadoFactura;

			// $coleccionesss=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$idDespachoFactura}");
			// foreach ($coleccionesss as $key) {
			// 	if(!empty($key['id_coleccion'])){
			// 		$key['cantidad_aprobado']=$cantidadAprobadoFactura;
			// 		$colecciones[count($colecciones)]=$key;
			// 	}
			// }
		}
	}
	$colecciones[count($colecciones)]=['estatus'=>true];
}else{
	$procederVariado = false;
	$cantAprobadaTotal = $factura['cantidad_aprobado'];
	$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$id_despacho}");
}


// $coleccioness = array_pop($colecciones);
// $coleccioness = $colecciones;
// // $colecciones = [];
// for ($i=0; $i < 150; $i++) { 
// 	$countNum = 1;
// 	foreach($coleccioness as $cols){
// 		if($countNum <= 1 ){ $colecciones[count($colecciones)] = $cols; }
// 		$countNum++;
// 	}
// }
// $colecciones+=['estatus'=>true];
		

// foreach ($colecciones as $key) {
// 	print_r($key);
// 	echo "<br><br>";
// }





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
		$info .= "<table class='' style='text-align:center;width:100%;margin-top:-10px;border-bottom:1px solid #FFFFFF;color:#FFFFFF;'>
				<tr>
				<br>
					<td style='width:25%;text-align:left;'>
						<img src='public/assets/img/LogoTipo2.png' style='width:17em;opacity:0;'>
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
						<b style='color:#FFFFFF;font-size:1.2em;'>
							FORMA LIBRE
							<br>
							Nro DE CONTROL
						</b>
						<br>
						<b style='color:#FFFFFF;margin-left:-2em;font-size:1.8em;'>
							<span style='font-size:;'>00 </span>
							<span style='font-size:;'><b> - </b></span>
							<span style='font-size:;'> ".$num_factura."</span>
						</b>
					</td>
				</tr>
			</table>
			
			<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:12%;left:33%;opacity:0;'>	
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
							<td class='celcontent'><span class='content-table'>".$factura['forma_pago']."</span></td>
						</tr>
					</table>
					";
						if($type==1){
						$info.="
						<br>
						<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:12.1em;'>x</div>
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
						$num_factura++;
							$num_factura2 = $num_factura;
							if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
							else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
							else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
							else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
							else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
							else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
							else{$num_factura = $num_factura2;}

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
							if(!empty($cols['rubro'])){
								if($procederVariado){
									$cantAprobada = $cols['cantidades'];
								}else{
									$cantAprobada = $factura['cantidad_aprobado'];
								}
								// echo "numeroLimite: ".$numLim."<br>";
								// if( $numerosCols  
								if($numero<=$numLim){
									$cantProduct = $cantAprobada;
									// $cantProduct = $cols['cantidad_productos']*$cantAprobada;
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
									$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo);
									// $sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
									//font-size:0.98em;
									$info.="
									<tr style=''>
										<td style='' class='celcontent'><span class='content-table' style='padding-left:15px;'>
											".$mostrarCantProduct." 
										</span></td>
										<td class='celcontent'><span class='content-table'>
											 ".$cols['rubro']."
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
										<span style='color:#FFF;'>".$cantAprobadaTotal." Colecciones Variadas</span><br>
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
			  $font = "times new roman";
		$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #FFFFFF;color:#FFFFFF;'>
				<tr>
					<td style='width:25%;text-align:left;'>
						<img src='public/assets/img/LogoTipo2.png' style='width:17em;opacity:0;'>
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
						<b style='color:#FFFFFF;font-size:1.2em;'>
							FORMA LIBRE
							<br>
							Nro DE CONTROL
						</b>
						<br>
						<b style='color:#FFFFFF;margin-left:-2em;font-size:1.8em;'>
							<span style='font-size:;'>00 </span>
							<span style='font-size:;'><b> - </b></span>
							<span style='font-size:;'> ".$num_factura."</span>
						</b>
					</td>
				</tr>
			</table>
			
			<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:12%;left:33%;opacity:0;'>	
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
								<td class='celcontent'><span class='content-table'>".$factura['forma_pago']."</span></td>
							</tr>
						</table>
						";
						$num_factura++;
						$num_factura2 = $num_factura;
							if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
							else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
							else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
							else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
							else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
							else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
							else{$num_factura = $num_factura2;}
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
							<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.79em;'></div>
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
								if(!empty($cols['rubro'])){
									if($procederVariado){
										$cantAprobada = $cols['cantidades'];
									}else{
										$cantAprobada = $factura['cantidad_aprobado'];
									}
									if($numero>$numLim2 && $numero<=$numLim){
										$cantProduct = $cantAprobada;
										// $cantProduct = $cols['cantidad_productos']*$cantAprobada;
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
									$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo);
									// $sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
										//font-size:0.98em;
										$info.="
										<tr style=''>
											<td class='celcontent'><span class='content-table'>
												".$mostrarCantProduct."
											</span></td>
											<td class='celcontent'><span class='content-table'>
												".$cols['rubro']."
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
											<span style='color:#FFF;'>".$cantAprobadaTotal." Colecciones Variadas</span><br>
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
				  $font = "times new roman";
		$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #FFFFFF;color:#FFFFFF;'>
				<tr>
					<td style='width:25%;text-align:left;'>
						<img src='public/assets/img/LogoTipo2.png' style='width:17em;opacity:0;'>
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
						<b style='color:#FFFFFF;font-size:1.2em;'>
							FORMA LIBRE
							<br>
							Nro DE CONTROL
						</b>
						<br>
						<b style='color:#FFFFFF;margin-left:-2em;font-size:1.8em;'>
							<span style='font-size:;'>00 </span>
							<span style='font-size:;'><b> - </b></span>
							<span style='font-size:;'> ".$num_factura."</span>
						</b>
					</td>
				</tr>
			</table>
			
			<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:12%;left:33%;opacity:0;'>	
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
									<td class='celcontent'><span class='content-table'>".$factura['forma_pago']."</span></td>
								</tr>
							</table>
							";
							$num_factura++;
							$num_factura2 = $num_factura;
							if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
							else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
							else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
							else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
							else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
							else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
							else{$num_factura = $num_factura2;}
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
								<div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.79em;'></div>
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
									if(!empty($cols['rubro'])){
										if($procederVariado){
											$cantAprobada = $cols['cantidades'];
										}else{
											$cantAprobada = $factura['cantidad_aprobado'];
										}
										if($numero>$numLim2 && $numero<=$numLim){
											$cantProduct = $cantAprobada;
											// $cantProduct = $cols['cantidad_productos']*$cantAprobada;
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
											$sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo);
											// $sumPrecioFinal += ($precioUnidProduct*$cifraMultiplo)*$cols['cantidad_productos'];
											//font-size:0.98em;
											$info.="
											<tr style=''>
												<td class='celcontent'><span class='content-table'>
													".$mostrarCantProduct."
												</span></td>
												<td class='celcontent'><span class='content-table'>
													".$cols['rubro']."
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
												<span style='color:#FFF;'>".$cantAprobadaTotal." Colecciones Variadas</span><br>
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
// echo $info;
$dompdf->loadHtml($info);
$pgl1 = 96.001;
$ancho = 528.00;
$alto = 816.009;
$altoMedio = $alto / 2;
// $dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta original
$dompdf->render();
$dompdf->stream("StyleCollection Fact ".$num_factura." - ".$factura['primer_nombre'], array("Attachment" => false));

?>