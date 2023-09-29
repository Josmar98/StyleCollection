<?php
require_once'vendor/dompdf/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$resumen = [];
$porcentaje = ['solicitado'=>0, 'aprobado'=>0, 'porcentaje_solicitado'=>0, 'porcentaje_aprobado'=>0];
foreach ($productosInventario as $data){ if(!empty($data['cod_inventario'])){
	$codInv = $data['cod_inventario'];
	$pedidosInventarios = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos_inventarios.estatus=1 and inventarios.estatus=1 and inventarios.cod_inventario='{$codInv}'");
	foreach ($pedidosInventarios as $key){ if(!empty($key['cod_inventario'])){
		if(!empty($resumen[$codInv])){
			$resumen[$codInv]['cantidad_solicitada'] += $key['cantidad_solicitada'];
			$resumen[$codInv]['cantidad_aprobada'] += $key['cantidad_aprobada'];
		}else{
			$resumen[$codInv]['cod'] = $key['cod_inventario'];
			$resumen[$codInv]['nombre'] = $key['nombre_inventario'];
			$resumen[$codInv]['cantidad_solicitada'] = $key['cantidad_solicitada'];
			$resumen[$codInv]['cantidad_aprobada'] = $key['cantidad_aprobada'];
		}
		$porcentaje['solicitado'] += $key['cantidad_solicitada'];
		$porcentaje['aprobado'] += $key['cantidad_aprobada'];
	} }
} }

$info = "
<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
	<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
	<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
	<title>Porcentaje de productos en Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']." - StyleHome</title>
</head>
<body>
<style>
body{
	font-family:'arial';
}
</style>
<div class='row' style='padding:0;margin:0;'>
	<div class='col-xs-12' style='width:100%;'>
		<h2 style='font-size:1.9em;'> Porcentaje de productos - Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']."</h2>
		<br>
		<br>
		";
		$info .= "<table class='table table-bordered' style='text-align:center;width:100%;font-size:1.4em;'>
			<thead>
				<tr style='background:#DDD;'>
                    <th style='width:5% !important;'>N°</th>
                    <th style='width:55% !important;text-align:left !important'>Producto</th>
                    <th style='width:20% !important;text-align:center !important;' colspan='2'>Solicitado</th>
                    <th style='width:20% !important;text-align:center !important;' colspan='2'>Aprobado</th>
                  </tr>
			</thead>
			<tbody>
			";
			$num = 1;
			foreach ($productosInventario as $data){ if(!empty($data['cod_inventario'])){
				$codInv = $data['cod_inventario'];
				$porcentaje['solicitado_porcentaje'] = ($resumen[$codInv]['cantidad_solicitada']*100)/$porcentaje['solicitado'];
				$porcentaje['aprobado_porcentaje'] = ($resumen[$codInv]['cantidad_aprobada']*100)/$porcentaje['aprobado'];
				$porcentaje['porcentaje_solicitado'] += $porcentaje['solicitado_porcentaje'];
				$porcentaje['porcentaje_aprobado'] += $porcentaje['aprobado_porcentaje'];
				$porcentaje['solicitado_porcentaje'] = (float) number_format($porcentaje['solicitado_porcentaje'],2);
				$porcentaje['aprobado_porcentaje'] = (float) number_format($porcentaje['aprobado_porcentaje'],2);
				$info .= "
				<tr style='font-size:1em;'>
					<td style='width:5%;'>
						<span class='contenido2'>
							".$num++."
						</span>
					</td>
					<td style='width:55% !important;text-align:left !important;'>
						<span class='contenido2'>
							".$resumen[$codInv]['nombre']."
						<span>
					</td>
					<td style='width:20% !important;text-align:center;'>
						<span class='contenido2'>
							".$resumen[$codInv]['cantidad_solicitada']." Unds"."
						</span>
					</td>
					<td style='width:5% !important;text-align:center;'>
						<span class='contenido2'>
							<b>(".$porcentaje['solicitado_porcentaje']."%".")</b>
						</span>
					</td>
					<td style='width:20% !important;text-align:center;'>
						<span class='contenido2'>
							".$resumen[$codInv]['cantidad_aprobada']." Unds"."
						</span>
					</td>
					<td style='width:5% !important;text-align:center;'>
						<span class='contenido2'>
							<b>(".$porcentaje['aprobado_porcentaje']."%".")</b>
						</span>
					</td>
				</tr>
				";
			} }
			$info .= "
			<tbody>
			<tfoot style='background:#ccc;'>";
				$info.="
				<tr>
					<th></th>
					<th></th>
					<th style='text-align:center !important;'>".$porcentaje['solicitado']." Unds"."</th>
					<th style='text-align:center !important;'>".$porcentaje['porcentaje_solicitado']."%"."</th>
					<th style='text-align:center !important;'>".$porcentaje['aprobado']." Unds"."</th>
					<th style='text-align:center !important;'>".$porcentaje['porcentaje_aprobado']."%"."</th>
				</tr>
				";
			$info .= "</tfoot>
		</table>";
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
$dompdf->stream("StyleHome ".$ciclo['numero_ciclo']."-".$ciclo['ano_ciclo']." Porcentaje de productos", array("Attachment" => false));



?>