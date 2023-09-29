<?php
require_once'vendor/dompdf/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();


$info = "
<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
	<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
	<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
	<title>Pedidos de Ciclo ".$num_ciclo."/".$ano_ciclo." - StyleHome</title>
</head>
<body>
<style>
body{
	font-family:'arial';
	font-size:1.6em;
}
</style>
<div class='row' style='padding:0;margin:0;'>
	<div class='col-xs-12' style='width:100%;'>
		<br>
		<div class='width:100%;display:block;'>
			<div class='text-center' style='width:60%;text-center;display:inline-block;'>
				<br>
				<img src='public/assets/img/logo5.png' style='width:90%;'>
				<br><br>
				<span>Rif.: J408497786</span>
				<br>
				<div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:center;padding:0'>
					".$nota['direccion_emision']."
				</div>
			</div>
			<div class='text-center' style='width:40%;text-center;display:inline-block;float:right;'>
				<div>
					<br>
					<table class='text-center' style='width:100%;'>
						<tr>
							<td>
								<span>LUGAR DE EMISION</span>
							</td>
							<td>
								<span>FECHA DE EMISION</span>
							</td>
						</tr>
						<tr>
							<td>
								".$nota['lugar_emision']."
							</td>
							<td>
								".$lider->formatFecha($nota['fecha_emision'])."
							</td>
						</tr>
					</table>
				</div>
				<div>
					<br><br><br>
					<h4 style='margin-top:0;margin-bottom:0;'>
						<b>NOTA DE ENTREGA</b>
					</h4>
					<br>
					<h3 style='margin:0;padding:0;'>
						<b>N° ".$numeroNota."</b>
					</h3>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div style='position:relative;top:-40px;margin-bottom:-35px;width:100%;text-align:center;border-top:1px solid #777;border-bottom:1px solid #777;padding:5px;font-size:1.2em;'>
			".mb_strtoupper('Nota de entrega de Premios')."
		</div>

		<div style='width:25%;display:inline-block;font-size:1.1em;'>
			Ciclo ".$num_ciclo."/".$ano_ciclo."
		</div>
		<div style='width:45%;display:inline-block;font-size:1.1em;'>
		</div>
		<div style='width:30%;display:inline-block;font-size:1.2em;'>";
			if ($numFactura != ""){
				$info .= "Factura N°. <b>".$numFactura." </b>";
			}
		$info .= "</div>

		<table class='table table-bordered' style='border:none;'>
			<tr>
				<td colspan='3'>
					NOMBRES Y APELLIDOS:
					<span style='margin-left:10px;margin-right:10px;'></span>
					".$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']."
				</td>
				<td colspan='2' >
					CEDULA:
					<span style='margin-left:10px;margin-right:10px;'></span>
					".number_format($pedido['cedula'],0,'','.')."
				</td>
			</tr>
			<tr>
				<td colspan='3'>
					DIRECCION:
					<span style='margin-left:10px;margin-right:10px;'></span>
					".$pedido['direccion']."
				</td>
				<td colspan='2'>
					TELEFONO: 
					<span style='margin-left:10px;margin-right:10px;'></span>
					".separateDatosCuentaTel($pedido['telefono'])." ";
					if(strlen($pedido['telefono2'])>5){
						$info .= " / ".separateDatosCuentaTel($pedido['telefono2']);
					}
				$info .= "</td>
			</tr>
		</table>
		<table class='table table-bordered text-left' >
			<thead style='background:#EEE;font-size:1.00em;'>
				<tr>
				<th style=text-align:center;width:4%;>Cantidad</th>
				<th style=text-align:left;width:48%;>Descripcion</th>
				<th style=text-align:left;width:28%;>Concepto</th>
				<th style=text-align:left;width:10%;></th>
				<th style=text-align:left;width:10%;></th>
				</tr>
				<style>
					.col1{text-align:center;}
					.col2{text-align:left;}
					.col3{text-align:left;}
					.col4{text-align:left;}
					.col5{text-align:left;}
				</style>
			</thead>
			<tbody>";
				$num = 1;
				foreach ($pedidosInv as $data){ if(!empty($data['id_pedido'])){
					$option = "";
					foreach ($opcinesEntrega as $opt) {
						if(!empty($opt['id_nota'])){
							if("P".$data['cod_inventario']==$opt['cod']){
								$option=$opt['val'];
							}
						}
					}
					$condicion = $_GET['P'.$data['cod_inventario']];
					if(mb_strtoupper($condicion)=="Y"){
						$info .="
						<tr>
							<td class='col1'>
								".$data['cantidad_aprobada']."
							</td>
							<td class='col2'>
								".$data['nombre_inventario']."
							</td>
							<td class='col3'>
								Pedido de factura directa
							</td>
							<td class='col4'></td>
							<td class='col5'></td>
						</tr>
						";
					}
				} }
				foreach ($canjeosPedidos as $data){ if(!empty($data['cod_inventario'])){
					$option = "";
					foreach ($opcinesEntrega as $opt) {
						if(!empty($opt['id_nota'])){
							if("P".$data['cod_inventario']==$opt['cod']){
								$option=$opt['val'];
							}
						}
					}
					$condicion = $_GET['C'.$data['cod_inventario']];
					if(mb_strtoupper($condicion)=="Y"){
						$info .="
						<tr>
							<td class='col1'>
								".$data['cantidad']."
							</td>
							<td class='col2'>
								".$data['nombre_inventario']."
							</td>
							<td class='col3'>
								Pedido de factura directa
							</td>
							<td class='col4'></td>
							<td class='col5'></td>
						</tr>
						";
					}
				} }
				$info .="
			</tbody>
		</table>
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
	$info .= "</div>
	<br>
</div>
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
$dompdf->stream("StyleHome ".$num_ciclo."-".$ano_ciclo." Nota de entrega - ".$pedido['primer_nombre']." ".$pedido['primer_apellido'], array("Attachment" => false));



?>