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
$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
if(!empty($access['id_acceso'])){
  if($access['nombre_modulo'] == "Inventarios"){
    $amReportes = 1;
    if($access['nombre_permiso'] == "Ver"){
      $amReportesC = 1;
    }
  }
}
}
if($amReportesC == 1){
function separateDatosCuentaTel($num){
	$set = 0;
	$newNum = '';
	for ($i=0; $i < strlen($num); $i++) { 
		if($i==4){
			$newNum .= '-';
		}
		if($i==7){
			$newNum .= '-';
		}
		if($i==9){
			$newNum .= '-';
		}
		$newNum .= $num[$i];
	}
	return $newNum;
}

// $id_campana = $_GET['campaing'];
// $numero_campana = $_GET['n'];
// $anio_campana = $_GET['y'];
// $id_despacho = $_GET['dpid'];
// $num_despacho = $_GET['dp'];

// $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
// $nombreCampana = $pedidosClientes[0]['nombre_campana'];
// $numeroCampana = $pedidosClientes[0]['numero_campana'];
// $anioCampana = $pedidosClientes[0]['anio_campana'];


$cod = $_GET['cod'];
$query = "SELECT * FROM operaciones WHERE numero_documento = '{$cod}' and tipo_operacion='Entrada'";
$operacionesTraslados = $lider->consultarQuery($query);
// print_r($operacionesTraslados);
// $notaentrega = $notaentregas[0];

// $optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

// $id = $notaentrega['id_cliente'];
// $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
// $pedido = $pedidos[0];
// $id_pedido = $pedido['id_pedido'];
// $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");



// $factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
// $numFactura = "";
if(count($operacionesTraslados)>1){
    $notaentrega = $operacionesTraslados[0];

	$alternumFactura = substr($notaentrega['numero_documento'],0,3);
	$numFactura = substr($notaentrega['numero_documento'],3);
    // print_r($notaentrega);
    $lim = 7;
    $falta = $lim-strlen($numFactura);
    $num_doc="";
    for ($i=0; $i < $falta; $i++) {
        $num_doc.="0";
    }
    $num_doc .= $numFactura;

	
	$catalag = "1";
	$almacen = $lider->consultarQuery("SELECT * FROM almacenes WHERE id_almacen={$notaentrega['id_almacen']}");
    $almacen = $almacen[0];
	
	
	$var = dirname(__DIR__, 3);
	$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
	$urlCss2 = $var . '/public/assets/css/';
	$urlImg = $var . '/public/assets/img/';
	
	ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
	date_default_timezone_set('america/caracas');
    // AV LOS HORCONES ENTRE CALLES 9 Y 10 LOCAL NRO S/N BARRIO PUEBLO NUEVO BARQUISIMETO EDO LARA ZONA POSTAL 3001
	$info = "
		<!DOCTYPE html>
		<html>
			<head>
				<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
				<title>Orden de Traslado - StyleCollection</title>
				
			</head>
			<body>
				<style>
				body{
					font-family:'arial';
					font-size:1.6em;
				}
				</style>
				<div class='row' style='padding:0;margin:0;'>
					<div class='col-xs-12'  style='width:100%;'>
						<div class='box-body' style='background:;'>
							<div class='text-center' style='width:60%;text-center;display:inline-block;background:;'>
								<div style='width:40%;display:inline-block;background:;'>
									<img src='public/assets/img/logoTipo1.png' style='width:100%;'>
								</div>
								<div style='width:60%;display:inline-block;background:;text-align:left;'>
									<span>Inversiones Style Collection C.A</span>
									<br>
									<span>Rif.: J-40849778-6</span>
									<br><br>
								</div>
								<div style='clear:both;'></div>
								<div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:left;padding:0'>
									Destino ".$almacen['nombre_almacen'].": ".$almacen['direccion_almacen']." 
								</div>
							</div>
							<div class='text-center'  style='width:40%;text-left;display:inline-block;'>
								<br><br>
								<div>
									<table class='text-left' style='width:100%;margin-left:10px;'>
										<tr>
											<td><span>LUGAR DE EMISION</span></td>
											<td><span>FECHA DE EMISION</span></td>
										</tr>
										<tr>
											<td>Barquisimeto</td>
											<td>".$lider->formatFecha($notaentrega['fecha_documento'])."</td>
										</tr>
										<tr>
											<td><br><br><span><b>Nota De Traslado</b></span></td>
											<td><span></span></td>
										</tr>
										<tr>
											<td><span style='font-size:1.2em;'><b>N°: <u>".$alternumFactura.$num_doc."</u></b></span></td>
											<td></td>
										</tr>
									</table>
									
								</div>
								<br>
							</div>
							<div style='clear:both'> </div>
							<div style='position:relative;top:-40px;margin-bottom:-35px;width:100%;text-align:center;border-top:1px solid #777;border-bottom:1px solid #777;padding:5px;font-size:1.2em;'>
                                ".mb_strtoupper('Nota de Traslado')."
                            </div>
							<table class='table table-bordered text-left' >
								<thead style='background:#EEE;font-size:1.00em;'>
									<tr>
										<th style=text-align:center;width:10%;>Cant.</th>
										<th style=text-align:left;width:70%;>Descripcion</th>
										<th style=text-align:right;width:10%;>Precio</th>
										<th style=text-align:right;width:10%;>Total</th>
									</tr>
									<style>
										.col1{text-align:center;}
										.col2{text-align:left;}
										.col3{text-align:right;}
										.col4{text-align:right;}
										</style>
								</thead>
								<tbody>";
									$num = 1;
									$totalSumatoria = 0;
									foreach ($operacionesTraslados as $notaM) {
                                        if(!empty($notaM['id_inventario'])){
                                            $id_unico = $notaM['stock_operacion'].$notaM['tipo_inventario'].$notaM['id_inventario'];
                                            if($notaM['tipo_inventario']=="Productos"){
                                                $inventario = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$notaM['id_inventario']}");
                                            }
                                            if($notaM['tipo_inventario']=="Mercancia"){
                                                $inventario = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$notaM['id_inventario']}");
                                            }
                                            $stock=$notaM['stock_operacion'];
                                            $precio_nota=(float) number_format($notaM['precio_nota'],2,'.','');
											$total = (float) number_format(($precio_nota * $stock),2,'.','');
											$totalSumatoria+=$total;
                                            $descripcion="";
                                            foreach ($inventario as $key) {
                                                if(!empty($key['elemento'])){
                                                    $descripcion="#".$key['codigo']." ".$key['elemento'];
                                                }
                                            }
                                            $info .= "
                                                <tr>
                                                    <td class='col1'>
                                                        ".$stock."
                                                    </td>
                                                    <td class='col2'>
                                                        ".$descripcion."
                                                    </td>
                                                    <td class='col3'>
                                                        ".number_format($precio_nota,2,',','.')."
                                                    </td>
                                                    <td class='col4'>
                                                        ".number_format($total,2,',','.')."
                                                    </td>
                                                </tr>
                                            ";
                                        }
									}
									// print_r($mostrarListaNotas);
									$info .="
									<tr>
										<td class='col1' colspan='2'></td>
										<td class='col3'></td>
										<td class='col4'>
											<b>".number_format($totalSumatoria,2,',','.')."</b>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class='row' style='margin-top:15px;'>
                            <div class='col-xs-12'>
                                <table class='table'>
                                    <tr>
                                        <td style='width:20%;' ></td>
                                        <td style='width:35%;' >Nombre y Apellido</td>
                                        <td style='width:15%;' >Fecha</td>
                                        <td style='width:30%;' >Firma</td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;border:1px solid #444;' ><b>Elaborado por</b></td>
                                        <td style='width:35%;border:1px solid #444;' ></td>
                                        <td style='width:15%;border:1px solid #444;' >_____/_____/_______</td>
                                        <td style='width:30%;border:1px solid #444;' ></td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;border:1px solid #444;' ><b>Despachado por</b></td>
                                        <td style='width:35%;border:1px solid #444;' ></td>
                                        <td style='width:15%;border:1px solid #444;' >_____/_____/_______</td>
                                        <td style='width:30%;border:1px solid #444;' ></td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;border:1px solid #444;' ><b>Recibido por</b></td>
                                        <td style='width:35%;border:1px solid #444;' ></td>
                                        <td style='width:15%;border:1px solid #444;' >_____/_____/_______</td>
                                        <td style='width:30%;border:1px solid #444;' ></td>
                                    </tr>
                                </table>
                                <span style='text-align:center;font-size:0.9em;'>
                                <center>INVERSIONES STYLE COLLECTION, C.A.   R.I.F.: J-40849778-6</center>
                                <center>AV. LOS HORCONES ENTRE CALLES 9 Y 10 DE PUEBLO NUEVO, NRO. S/N. BARRIO PUEBLO NUEVO. BARQUISIMETO, EDO LARA, ZONA POSTAL 3001.</center>
                                </span>
                            </div>
						</div>
						";
                        // <div class='' style='width:50%;display:inline-block;text-align:right;'>
                            
                        //     <div style='display:inline-block;'>Despachado por:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        //     <br><br>
                        //     <div style='display:inline-block;margin-left:100px;'>C.I:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        // </div>
                        
                        // <div class='' style='width:50%;display:inline-block;text-align:right;'>
                        //     <div style='display:inline-block;margin-left:13px;'>Recibido por:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        //     <br><br>
                        //     <div style='display:inline-block;margin-left:85px;'>C.I:</div>
                        //     <div style='display:inline-block;border-bottom:1px solid #555;width:50% !important;'></div>
                        // </div>
						//<span class='string'>Copyright &copy; 2021-2022 <b>Style Collection</b>.</span> <span class='string'>Todos los derechos reservados.</span>
						//<h2>tengo mucha hambre, y sueño, aparte tengo que hacer muchas cosas lol jajaja xd xd xd xd xd xd xd xd hangria </h2>
						$info .= "
					</div>
				</div>
				<br>
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
	
	//$dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta 
	// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
	
	// $pgl1 = 96.
	// $ancho = 528.
	// $alto = 816.
	// $altoMedio = $alto / 2;
	
	
	$dompdf->loadHtml($info);
	$dompdf->render();
	$dompdf->stream("Orden de Traslado N.{$num_doc} - StyleCollection", array("Attachment" => false));
	// echo $info;
}

}else{
    require_once 'public/views/error404.php';
}

?>