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
	 $query = "SELECT * FROM clientes, despachos, pedidos, factura_despacho_personalizada WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_pedido = factura_despacho_personalizada.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho_personalizada.id_factura_despacho_perso=$id";
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
	

$buscarFacturasVariadas = $lider->consultarQuery("SELECT * FROM factura_despacho_variadas_perso WHERE id_factura_despacho_perso={$factura['id_factura_despacho_perso']} and estatus=1 ORDER BY factura_despacho_variadas_perso.id_pedido_factura ASC");
$procederVariado = false;
$colecciones = [];
$mostrarCantAprobadaTotal = 0;
$cantAprobadaTotal = 0;
if(count($buscarFacturasVariadas)>1){
	$procederVariado = true;
	foreach ($buscarFacturasVariadas as $variadas) {
		if(!empty($variadas['id_factura_despacho_perso'])){
			//Buscar despacho
			$idPedidoFactura=$variadas['id_pedido_factura'];
			$buscarDespacho = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido={$idPedidoFactura}");
			$idDespachoFactura = $buscarDespacho[0]['id_despacho'];
			$mostrarCantAprobadaTotal = $buscarDespacho[0]['cantidad_aprobado'];
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
			$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec, colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}");
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
	$mostrarCantAprobadaTotal = $factura['cantidad_aprobado'];
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

	$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec, colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}");
	$coleccioness = array_pop($colecciones);
	foreach ($coleccionesSec as $key) {
		if(!empty($key['id_coleccion'])){
			$colecciones[count($colecciones)]=$key;
		}
	}
	$colecciones[count($colecciones)]=['estatus'=>true];
}


$colecciones=[];
$colecciones = $_SESSION['mostrarFacturaFinalPerso'];

$listaColecciones = $_SESSION['listaColeccionesPerso'];
// $listaColecciones=[];
// $listaColecciones[count($listaColecciones)]=['cant'=>$mostrarCantAprobadaInd,'descripcion'=>"Cols. Cosmeticos"];
// $querySec="SELECT * FROM despachos_secundarios, pedidos_secundarios WHERE despachos_secundarios.id_despacho_sec=pedidos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho={$id_despacho} and pedidos_secundarios.id_despacho={$id_despacho} and pedidos_secundarios.id_pedido={$idPedidoFactura}";
// $secundarios = $lider->consultarQuery($querySec);
// foreach($secundarios as $sec){ 
// 	if(!empty($sec['nombre_coleccion_sec'])){
// 		if($sec['cantidad_aprobado_sec']>0){
// 			$listaColecciones[count($listaColecciones)]=['cant'=>$sec['cantidad_aprobado_sec'],'descripcion'=>"Cols. ".$sec['nombre_coleccion_sec']];
// 		}
// 	}
// }


$cantidadDiferentesCols = count($listaColecciones);
$limiteColsLista=6;
if($cantidadDiferentesCols>$limiteColsLista){
	$listaColecciones=[];
	$listaColecciones[count($listaColecciones)]=['cant'=>$mostrarCantAprobadaTotal, 'descripcion'=>"Cols. Variadas"];
}
$cantidadDiferentesCols = count($listaColecciones);
$complementarListaCols = "";
for ($i=0; $i < ($limiteColsLista-$cantidadDiferentesCols); $i++) { 
	$complementarListaCols.="<br>";
}

$colecciones[count($colecciones)]=['estatus'=>true];
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
							<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
							<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
						</tr>
						<tr>
							<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$factura['direccion']."</span></td>
							<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$factura['telefono']."</span></td>
						</tr>";
						if($factura['observacion']!=""){
							$info .= "
							<tr>
								<td class='celcontent' style='width:75% !important;' colspan='4'><span class='titulo-table'><b class='titulo-table'>Observación: </b>".$factura['observacion']."</span></td>
							</tr>";
						}
						$info .= "
					</table>
					";
						if($type==1){
							// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:12.1em;'></div>
						$info.="
						<br>
						<table class='table2 tablecontent' style='width:103%;border:1px solid #000;'>
							<tr>
						";
						}
						if($type==2){
							// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.35em;'></div>
						$info.="
						<br>
						<table class='table2 tablecontent' style='width:103%;font-size:1.02em;border:1px solid #000;'>
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
							<td colspan='6'><span style='width:100%;height:1px;display:block;background:#000;'></span></td>
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
									$cols['total'] = (float) ($cols['precio']*$cols['cantidad']);
									$info.="
									<tr style=''>
										<td style='' class='celcontent cantidades'><span class='content-table'>
											<span style='color:rgba(0,0,0,0);'>__</span>
											".$cols['cantidad']." 
										</span></td>
										<td class='celcontent descripciones' colspan='3'><span class='content-table'>
											".$cols['descripcion']."
										</span></td>
										<td class='celcontentR precios'><span class='content-table'>
											".$simbolo."".number_format($cols['precio'],2,',','.')."
										</span></td>
										<td class='celcontentR totales'><span class='content-table'>
											".$simbolo."".number_format($cols['total'],2,',','.')."
											<span style='color:rgba(0,0,0,0);'>_</span>
										</span></td>
									</tr>
									<tr style=''>
										<td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
									</tr>
									";
									$sumaTotales+=$cols['total'];
									$numeroReal++;
								}
								$numero++;
							}
						}


						$ivattt = ($sumaTotales/100)*$valorIva;
						// $igtf = ($sumaTotales/100)*$valorIgtf;
						$igtf = 0;
						// $precioFinal = $sumaTotales+$ivattt;
						$precioFinal = $sumaTotales+$ivattt+$igtf;
						if($conTotalResumen && $numero==$numeroReal && $numero==$numerosCols){
							$info.="
								<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>
								<tr>
									<td class='celcontent'><span class='content-table'>
										<span style='color:rgba(0,0,0,0);'>__</span>
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
										<small style='font-size:0.85em;'>
											";
											foreach($listaColecciones as $list){
												if($list['cant']>0){
													$info .= "".$list['cant']." ".$list['descripcion'].", ";
												}
											}
											// $info .= $complementarListaCols;
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
					<div class='box-content-final-R' style='text-align:right;'>
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
									<td class='celtitleR'>I.V.A. (".$valorIva."%): </td>
									<td class='celcontentR'><span class='content-table'>
										".$simbolo."".number_format($ivattt,2,',','.')."
									</span></td>
								</tr>
								<tr>
									<td class='celtitleR'>I.G.T.F. (".$valorIgtf."%): </td>
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
								<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
								<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
							</tr>
							<tr>
								<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$factura['direccion']."</span></td>
								<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$factura['telefono']."</span></td>
							</tr>
						</table>
						";
							if($type==1){
								// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
							$info.="
							<br>
							<table class='table2' style='width:100%;border:1px solid #000;'>
								<tr>
							";
							}
							if($type==2){
								// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
							$info.="
							<br>
							<table class='table2' style='width:100%;font-size:1.02em;border:1px solid #000;'>
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
								<td colspan='6'><span style='width:100%;height:1px;display:block;background:#000;'></span></td>
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
										
										$cols['total'] = (float) ($cols['precio']*$cols['cantidad']);
										$info.="
										<tr style=''>
											<td style='' class='celcontent cantidades'><span class='content-table'>
												<span style='color:rgba(0,0,0,0);'>__</span>
												".$cols['cantidad']." 
											</span></td>
											<td class='celcontent descripciones' colspan='3'><span class='content-table'>
												".$cols['descripcion']."
											</span></td>
											<td class='celcontentR precios'><span class='content-table'>
												".$simbolo."".number_format($cols['precio'],2,',','.')."
											</span></td>
											<td class='celcontentR totales'><span class='content-table'>
												".$simbolo."".number_format($cols['total'],2,',','.')."
												<span style='color:rgba(0,0,0,0);'>_</span>
											</span></td>
										</tr>
										<tr style=''>
											<td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
										</tr>
										";
										$sumaTotales+=$cols['total'];
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
											<small style='font-size:0.85em;'>
												";
												foreach($listaColecciones as $list){
													if($list['cant']>0){
														$info .= "".$list['cant']." ".$list['descripcion'].", ";
													}
												}
												// $info .= $complementarListaCols;
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
						<div class='box-content-final-R' style='text-align:right;'>
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
										<td class='celtitleR'>I.V.A. (".$valorIva."%): </td>
										<td class='celcontentR'><span class='content-table'>
											".$simbolo."".number_format($ivattt,2,',','.')."
										</span></td>
									</tr>
									<tr>
										<td class='celtitleR'>I.G.T.F. (".$valorIgtf."%): </td>
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
									<td class='celcontent' style='width:75% !important;' colspan='3'><b class='titulo-table'>Cliente: </b><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
									<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Cédula o RIF: </b><span class='content-table'>".$factura['cod_rif']."".$factura['rif']."</span></td>
								</tr>
								<tr>
									<td class='celcontent' style='width:75% !important;' colspan='3'><span class='titulo-table'><b class='titulo-table'>Dirección: </b>".$factura['direccion']."</span></td>
									<td class='celcontent' style='width:25% !important;text-align:right;'><b class='content-table'>Telefono: </b><span class='content-table'>".$factura['telefono']."</span></td>
								</tr>
							</table>
							";
								if($type==1){
									// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:13.25em;'></div>
								$info.="
								<br>
								<table class='table2' style='width:100%;border:1px solid #000;'>
									<tr>
								";
								}
								if($type==2){
									// <div class='box-content-final-CFT' style='border-bottom:1px solid #434343;top:14.67em;'></div>
								$info.="
								<br>
								<table class='table2' style='width:100%;font-size:1.02em;border:1px solid #000;'>
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
									<td colspan='6'><span style='width:100%;height:1px;display:block;background:#000;'></span></td>
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
											
											$cols['total'] = (float) ($cols['precio']*$cols['cantidad']);
											$info.="
											<tr style=''>
												<td style='' class='celcontent cantidades'><span class='content-table'>
													<span style='color:rgba(0,0,0,0);'>__</span>
													".$cols['cantidad']." 
												</span></td>
												<td class='celcontent descripciones' colspan='3'><span class='content-table'>
													".$cols['descripcion']."
												</span></td>
												<td class='celcontentR precios'><span class='content-table'>
													".$simbolo."".number_format($cols['precio'],2,',','.')."
												</span></td>
												<td class='celcontentR totales'><span class='content-table'>
													".$simbolo."".number_format($cols['total'],2,',','.')."
													<span style='color:rgba(0,0,0,0);'>_</span>
												</span></td>
											</tr>
											<tr style=''>
												<td colspan='6'><span style='width:100%;height:1px;display:block;background:#ccc;'></span></td>
											</tr>
											";
											$sumaTotales+=$cols['total'];
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
												<small style='font-size:0.85em;'>
													";
													foreach($listaColecciones as $list){
														if($list['cant']>0){
															$info .= "".$list['cant']." ".$list['descripcion'].", ";
														}
													}
													// $info .= $complementarListaCols;
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
							<div class='box-content-final-R' style='text-align:right;'>
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
											<td class='celtitleR'>I.V.A. (".$valorIva."%): </td>
											<td class='celcontentR'><span class='content-table'>
												".$simbolo."".number_format($ivattt,2,',','.')."
											</span></td>
										</tr>
										<tr>
											<td class='celtitleR'>I.G.T.F. (".$valorIgtf."%): </td>
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


$dompdf->loadHtml($info);
$dompdf->render();
$dompdf->stream("StyleCollection Fact ".$num_factura." - ".$factura['primer_nombre'], array("Attachment" => false));

// echo $info;
?>