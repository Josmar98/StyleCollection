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
	 
	 $precio_coleccion = $factura['precio_coleccion'];
	 $iva = $precio_coleccion/100*16;
	 $precio_coleccion_total = $precio_coleccion * $factura['cantidad_aprobado'];
	 $ivaT = $precio_coleccion_total/100*16;
	 $precio_final_factura = $ivaT+$precio_coleccion_total;
	 
	 $numeroFactura = Count($facturas)-1;
	$num_factura2 = $factura['numero_factura'];
	if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
	else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
	else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
	else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
	else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
	else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
	else{$num_factura = $num_factura2;}
	$simbolo="$";
	


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

						<span class='numeroFactura'><b>Nota de entrega N° </b> <span class='numFact'><b>".$num_factura."</b></span></span>			
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
							<td class='celcontent' colspan='3'><span class='content-table'>".$factura['primer_nombre']." ".$factura['segundo_nombre']." ".$factura['primer_apellido']." ".$factura['segundo_apellido']."</span></td>
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
					<br>
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
						<tr>
							<td class='celcontent'><span class='content-table'>".$factura['cantidad_aprobado']."</span></td>
							<td class='celcontent'><span class='content-table'>Colecciones Cosméticos Campaña ".$numero_campana."-".$anio_campana."</span></td>
							<td class='celcontentR'><span class='content-table'>01</span></td>
							<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_coleccion,2,',','.')."</span></td>
							<td class='celcontentR'><span class='content-table'>16%</span></td>
							<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_coleccion_total,2,',','.')."</span></td>
						</tr>
					</table>

					<div class='box-content-final'>
						<!-- 
						precio 1 coleccion: <span class='content-table'>".number_format($precio_coleccion,2,',','.')."</span>
						<br>
						Iva 1 coleccion: <span class='content-table'>".number_format($iva,2,',','.')."</span>
						-->
						<table style='width:100%;'>
							<tr>
								<td class='celtitleL'>Total Neto: </td>
								<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_coleccion_total,2,',','.')."</span></td>
							</tr>
							<tr>
								<td class='celtitleL'>Impuesto (I.V.A): </td>
								<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($ivaT,2,',','.')."</span></td>
							</tr>
							<tr>
								<td class='celtitleL'>Total Operacion: </td>
								<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_final_factura,2,',','.')."</span></td>
							</tr>
						</table>
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
// echo $info;
$dompdf->loadHtml($info);
$pgl1 = 96.001;
$ancho = 528.00;
$alto = 816.009;
$altoMedio = $alto / 2;
$dompdf->render();
$dompdf->stream("StyleCollection Fact ".$num_factura." - ".$factura['primer_nombre'], array("Attachment" => false));

?>