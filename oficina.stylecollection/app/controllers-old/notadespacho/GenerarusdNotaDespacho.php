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
	$coleccionesMinis=array(18, 19, 20); //Hace referencia a las campañas donde se manejan mini colecciones

	$lider = new Models();
	$query = "SELECT * FROM clientes, despachos, pedidos, nota_despacho WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_pedido = nota_despacho.id_pedido and pedidos.id_despacho = $id_despacho and nota_despacho.id_nota_despacho=$id";
	$notas = $lider->consultarQuery($query);

	$nota = $notas[0];
	$emision = $nota['fecha_emision'];
	// $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision'");
	// $tasa = $tasas[0];
	// $precio_coleccion = $tasa['monto_tasa'] * $nota['precio_coleccion'];
	
	$precio_coleccion = $nota['precioDolar'];
	$precio_coleccion_total = 0;
	// $precio_coleccion = $nota['precio_coleccion'];
	// $iva = $precio_coleccion/100*16;
	// $precio_coleccion_total = $precio_coleccion * $nota['cantidad_colecciones'];
	// $ivaT = $precio_coleccion_total/100*16;
	// $precio_final_nota = $ivaT+$precio_coleccion_total;
	 
	$numeronota = Count($notas)-1;
	$num_nota2 = $nota['numero_nota'];
	if(strlen($num_nota2)==1){$num_nota = "00000".$num_nota2;}
	else if(strlen($num_nota2)==2){$num_nota = "0000".$num_nota2;}
	else if(strlen($num_nota2)==3){$num_nota = "000".$num_nota2;}
	else if(strlen($num_nota2)==4){$num_nota = "00".$num_nota2;}
	else if(strlen($num_nota2)==5){$num_nota = "0".$num_nota2;}
	else if(strlen($num_nota2)==6){$num_nota = $num_nota2;}
	else {$num_nota = $num_nota2;}
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
	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE despachos.id_campana = campanas.id_campana and campanas.estatus =1 and despachos.estatus=1 and campanas.id_campana={$_GET['campaing']}");
			
	$font = "times new roman";
		$info .= "<table class='' style='text-align:center;width:100%;border-bottom:1px solid #ED2A77;color:#ED2A77;'>
				<tr>
					<td style='width:25%;text-align:left;'>
						<img src='public/assets/img/LogoTipo2.png' style='width:17em;opacity:0.8;'>
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
							<span style='font-size:;'> ".$num_nota."</span>
						</b>
					</td>
				</tr>
			</table>
			
			<img src='public/assets/img/iconoSinFondo.png' style='width:25em;height:30em;position:absolute;z-index:-10%;top:12%;left:33%;opacity:0.3;'>	
			<div class='row'>
				<div class='col-xs-12'>

						<span class='numeroFactura'><b>Nota de entrega N° </b> <span class='numFact'><b>".$num_nota."</b></span></span>			
					<span class='fecha'>
						<table class=''>
						<tr>
							<td>
								<b>Emision: </b> 
							</td>
							<td>
								<span class='dates'>".$lider->formatFecha($nota['fecha_emision'])."</span>
							</td>
						</tr>
						<tr>
							<td>
								<b>Vence: </b>
							</td>
							<td>
								<span class='dates'>".$lider->formatFecha($nota['fecha_vencimiento'])."</span>
							</td>
						</tr>
						</table>
					</span>

					<br><br>
					<table class='table1'>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cliente: </b></td>
							<td class='celcontent'><span class='content-table'>".$nota['primer_nombre']." ".$nota['segundo_nombre']." ".$nota['primer_apellido']." ".$nota['segundo_apellido']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Dirección: </b></td>
							<td class='celcontent' colspan='3'><span class='content-table'>".$nota['direccion']."</span></td>
							
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Cédula o RIF: </b></td>
							<!-- <td class='celcontent'><span class='content-table'>".$nota['cod_cedula']."-".number_format($nota['cedula'],0,'','.')."</span></td> -->
							<td class='celcontent'><span class='content-table'>".$nota['cod_rif']."".$nota['rif']."</span></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class='celtitle2'><b class='titulo-table'>Telefono: </b></td>
							<td class='celcontent'><span class='content-table'>".$nota['telefono']."</span></td>
							<td class='celtitle2R'><b class='titulo-table'>Forma de Pago: </b></td>
							<td class='celcontent'><span class='content-table'>".$nota['tipo_nota']."</span></td>
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
						<tr style='margin:0:padding:0;'><td colspan='6'><hr style='border-top:1px solid #ddd;margin:0:padding:0;'></td></tr>";
						foreach ($despachos as $desp) {
							if(!empty($desp['id_despacho'])){
								$nitem = "";
								if(($desp['numero_despacho']-1)>0){
									$nitem = ($desp['numero_despacho']-1);
								}
								$nameColeccion = "";
								if(in_array($desp['id_despacho'], $coleccionesMinis)){
									$nameColeccion .= "Minis ";
								}
								$nameColeccion .= "Colecciones Variadas ";
								if(!empty($desp['nombre_despacho']) && $desp['nombre_despacho']!=""){
									if($id_campana)
									$nameColeccion .= "- ".$desp['nombre_despacho'];
								}else{
									$nameColeccion .= " Campaña ".$numero_campana."-".$anio_campana;
								}
								// $iva = $precio_coleccion/100*16;
								$precio_coleccion_tot = $precio_coleccion * $nota['cantidad_colecciones'.$nitem];
								$precio_coleccion_total+=$precio_coleccion_tot;
								
								$info .= "<tr>
									<td class='celcontent'><span class='content-table'>".$nota['cantidad_colecciones'.$nitem]."</span></td>
									<td class='celcontent'><span class='content-table'>".$nameColeccion."</span></td>
									<td class='celcontentR'><span class='content-table'>01</span></td>
									<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_coleccion,2,',','.')."</span></td>
									<td class='celcontentR'><span class='content-table'>16%</span></td>
									<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_coleccion_tot,2,',','.')."</span></td>
								</tr>";
							}
						}
						$ivaT = $precio_coleccion_total/100*16;
						$precio_final_nota = $ivaT+$precio_coleccion_total;
					$info .= "</table>

					<div class='box-content-final'>
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
								<td class='celcontentR'><span class='content-table'>".$simbolo."".number_format($precio_final_nota,2,',','.')."</span></td>
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

// $pgl1 = 96.001;
// $ancho = 528.00;
// $alto = 816.009;
// $altoMedio = $alto / 2;



echo $info;
// $dompdf->loadHtml($info);
// $dompdf->render();
// $dompdf->stream("StyleCollection Nota ".$num_nota." - ".$nota['primer_nombre'], array("Attachment" => false));

?>