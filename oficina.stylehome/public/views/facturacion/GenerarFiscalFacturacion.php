<?php
require_once'vendor/dompdf/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

// $comentario1 = "<!-- ";
// $comentario2 = " -->";
// CON ENCABEZADO OPEN
$borderTop = "border-bottom:1px solid ".$color_btn_sweetalert;
$opacityIMG=0.8;
// CON ENCABEZADO CLOSE

// // SIN ENCABEZADO OPEN
// $opacityIMG=0;
// $borderTop = "border-bottom:1px solid #FFFFFFFF";
// $color_btn_sweetalert="#FFFFFFFF";
// // SIN ENCABEZADO CLOSE

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
	$font = "times new roman";
		$info .= "<table class='' style='text-align:center;width:100%;".$borderTop.";color:".$color_btn_sweetalert.";'>
				<tr>
					<td style='width:25%;text-align:left;'>
						 <img src='public/assets/img/LogoTipo2.png' style='width:17em;opacity:".$opacityIMG.";'>
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
						<b style='color:".$color_btn_sweetalert.";font-size:1.2em;'>
							FORMA LIBRE
							<br>
							Nro DE CONTROL
						</b>
						<br>
						<b style='color:".$color_btn_sweetalert.";margin-left:-2em;font-size:1.8em;'>
							<span style='font-size:;'>00 </span>
							<span style='font-size:;'><b> - </b></span>
							<span style='font-size:;'> ".$num_factura."</span>
						</b>
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
								<span class='dates'>".$lider->formatFecha($pedido['fecha_emision'])."</span>
							</td>
						</tr>
						<tr>
							<td>
								<b>Vence: </b>
							</td>
							<td>
								<span class='dates'>".$lider->formatFecha($pedido['fecha_vencimiento'])."</span>
							</td>
						</tr>
						</table>
					</span>

					<br>
					<table class='table1'>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
							<td class='celcontent'><span class='content-table'>".$pedido['primer_nombre']." ".$pedido['primer_apellido']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
							<td class='celcontent' colspan='2'><span class='content-table'>".$pedido['direccion']."</span></td>
							
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
							<td class='celcontent'><span class='content-table'>".$pedido['cod_cedula']."-".number_format($pedido['cedula'],0,'','.')."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
							<td class='celcontent'><span class='content-table'>".$pedido['telefono']."</span></td>
							<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
							<td class='celcontent'><span class='content-table'>".$pedido['tipo_factura']."</span></td>
						</tr>
					</table>
					<br>
					<br>
					<br>
					<table class='table2' style='width:100%;'>
						<tr>
							<td class='celtitleL'><b>Cantidad</b></td>
							<td class='celtitleL'><b>Descripcion Ciclo ".$num_ciclo."-".$ano_ciclo."</b></td>
							<td class='celtitleR'><b>Unid.</b></td>
							<td class='celtitleR'><b>Precio</b></td>
							<td class='celtitleR'><b>I.V.A</b></td>
							<td class='celtitleR'><b>Total</b></td>
						</tr>
						<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>";
						$totalNeto = 0;
						foreach ($pedidosInv as $pedInv) { if(!empty($pedInv['id_factura'])){
							$precioInv = ($pedInv['precio_inventario']*$tasa); //Por ser en BS;
							$precioTotal = ($precioInv*$pedInv['cantidad_aprobada']);
							$totalNeto += $precioTotal;
							$info .= "
							<tr style='padding-top:25px;'>
								<td class='celcontent'><span class='content-table'>".$pedInv['cantidad_aprobada']."</span></td>
								<td class='celcontent'><span class='content-table'>".$pedInv['nombre_inventario']."</span></td>
								<td class='celcontentR'><span class='content-table'>01</span></td>
								<td class='celcontentR'><span class='content-table'>".number_format($precioInv,2,',','.')." Bs</span></td>
								<td class='celcontentR'><span class='content-table'>16%</span></td>
								<td class='celcontentR'><span class='content-table'>".number_format($precioTotal,2,',','.')." Bs</span></td>
							</tr>
							<tr><td colspan='6' style='text-align:center;'><hr style='margin:5px:padding:0;'></td></tr>
							";

						} }
						$totalIva = ($totalNeto/100)*$iva;
						$totalOperacion = $totalNeto+$totalIva;
						$info .= "
					</table>

					<div class='box-content-final'>
						<table style='width:100%;'>
							<tr>
								<td class='celtitleL'>Total Neto: </td>
								<td class='celcontentR'><span class='content-table'>".number_format($totalNeto,2,',','.')." Bs</span></td>
							</tr>
							<tr>
								<td class='celtitleL'>Impuesto (I.V.A): </td>
								<td class='celcontentR'><span class='content-table'>".number_format($totalIva,2,',','.')." Bs</span></td>
							</tr>
							<tr>
								<td class='celtitleL'>Total Operacion: </td>
								<td class='celcontentR'><span class='content-table'>".number_format($totalOperacion,2,',','.')." Bs</span></td>
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


// echo $info;
$dompdf->loadHtml($info);
$pgl1 = 96.001;
$ancho = 528.00;
$alto = 816.009;
$altoMedio = $alto / 2;
$dompdf->render();
$dompdf->stream("StyleHome ".$num_ciclo."-".$ano_ciclo." Fact ".$num_factura." - ".$pedido['primer_nombre']." ".$pedido['primer_apellido'], array("Attachment" => false));



?>