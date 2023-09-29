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
	<title>Pedidos solicitados de Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']." - StyleHome</title>
</head>
<body>
<style>
body{
	font-family:'arial';
	font-size:1.5em;
}
</style>
<div class='row' style='padding:0;margin:0;'>
	<div class='col-xs-12' style='width:100%;'>
		<h2 style='font-size:1.9em;'> Solicitudes de Pedidos - Ciclo ".$ciclo['numero_ciclo']."/".$ciclo['ano_ciclo']."</h2>
		<br>
		<br>
		";
		$info .= "<table class='table' style='text-align:center;width:100%;font-size:1.5em;'>
			<thead>
				<tr>
					<th>N°</th>
					<th>Líder</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
		";
			$resumen = [];
			$num = 1;
			foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
				$id_pedido = $data['id_pedido'];
				$pedidosInventarios = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos_inventarios.estatus=1 and inventarios.estatus=1 and pedidos.id_pedido={$id_pedido}");
				$info .= "
					<tr style='font-size:;'>
						<td style='width:5%;font-size:.8em;'>
							<span class='contenido2'>
								".$num++."
							</span>
						</td>
						<td style='width:25%;text-align:left;font-size:.8em;'>
							<span class='contenido2'>
								<span style='margin-left:5px;'>".number_format($data['cedula'],0,',','.')."</span>
								<span style='margin-left:10px;'>".$data['primer_nombre']."</span>
								<span style='margin-left:5px;'>".$data['primer_apellido']."</span>
							<span>
						</td>
						<td style='width:70%;text-align:left;font-size:.8em;'>
							<table class='table' style='width:100%;text-align:left;background:none;'>
								<thead>
									<tr>
										<th style='text-align:left !important;'>Producto</th>
										<th style='text-align:center !important;'>Solicitado</th>
										<th style='text-align:center !important;'>Aprobado</th>
									</tr>
								</thead>
								<tbody>";
									foreach ($pedidosInventarios as $pedInv){ if(!empty($pedInv['cod_inventario'])){
										if(!empty($resumen[$pedInv['cod_inventario']])){
											$resumen[$pedInv['cod_inventario']]['cantidad_solicitada'] += $pedInv['cantidad_solicitada'];
										}else{
											$resumen[$pedInv['cod_inventario']]['nombre'] = $pedInv['nombre_inventario'];
											$resumen[$pedInv['cod_inventario']]['cantidad_solicitada'] = $pedInv['cantidad_solicitada'];
										}
										$info .= "<tr style='text-align:center;'>
											<td style='width:60%;text-align:left;padding-left:25px;'>
												<span class='contenido2'>
													".$pedInv['nombre_inventario']."
												</span>
											</td>
											<td style='width:20%;text-align:center;'>
												<span class='contenido2'>
													".$pedInv['cantidad_solicitada']." Unds
												</span>
											</td>
											<td style='width:20%;text-align:center;'>
												<span class='contenido2'>
													<span style='font-size:1.5em;margin-left:1.5em;border:1px solid #ccc;padding:0;color:#00000000;''> __ </span>
												</span>
											</td>
										</tr>";
									} }
								$info .= "
								</tbody>
							</table>
						</td>
					</tr>
				";
			} }
			$info .= "
			<tbody>
			<tfoot style='background:#ccc;'>";
				foreach ($resumen as $key) {
					$info.="
					<tr>
						<th></th>
						<th></th>
						<th>
							<table class='table' style='width:100%;text-align:left;background:none;border:none;'>
								<tr>
									<th style='width:60%;text-align:left;padding-left:25px;'>
										".$key['nombre']."
									</th>
									<th style='width:20%;text-align:center;'>
										".$key['cantidad_solicitada']." Unds
									</th>
									<th style='width:20%;text-align:center;'>
									</th>
								</tr>
							</table>
						</th>
					</tr>
					";
				}
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
$dompdf->stream("StyleHome ".$ciclo['numero_ciclo']."-".$ciclo['ano_ciclo']." Productos Seleccionados", array("Attachment" => false));



?>