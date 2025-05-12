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
  if($access['nombre_modulo'] == "Reportes"){
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

// $empleadoss = $lider->consultarQuery("SELECT * FROM empleados WHERE estatus=1");
// $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
// $nombreCampana = $pedidosClientes[0]['nombre_campana'];
// $numeroCampana = $pedidosClientes[0]['numero_campana'];
// $anioCampana = $pedidosClientes[0]['anio_campana'];


// $optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");
// $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
// $pedido = $pedidos[0];
// $id_pedido = $pedido['id_pedido'];
// $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");


$nota = $_GET['cod'];
$notaentregas = $lider->consultarQuery("SELECT * FROM operaciones WHERE operaciones.numero_documento='{$nota}' and operaciones.tipo_operacion='Salida' ORDER BY operaciones.id_operacion DESC;");
// print_r($notaentregas);

$numFactura = "";
if(count($notaentregas)>1){
    $notaentrega = $notaentregas[0];
    // print_r($notaentrega);
    $tipo_persona = $notaentrega['tipo_persona'];
    $id_persona = $notaentrega['id_personal'];

    if($tipo_persona=="Empleado"){
        $persona = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado={$notaentrega['id_personal']}");
    }
    if($tipo_persona=="Cliente"){
        $persona = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$notaentrega['id_personal']}");
    }
	if($tipo_persona=="Interno"){
		$persona[0] = $infoInternos[$notaentrega['id_personal']];
    }
	if($tipo_persona=="Autorizado"){
		$persona[0] = $infoInternos[$notaentrega['id_personal']];
    }
    foreach ($persona as $key) {
        if(!empty($key['primer_nombre'])){
            $notaentrega+=$key;
        }
    }
    // echo "<br><br>";
    // print_r($notaentrega);
    // echo "<br><br>";

	$alternumFactura = substr($notaentrega['numero_documento'],0,3);
	$numFactura = substr($notaentrega['numero_documento'],3);
	switch (strlen($numFactura)) {
		case 1:
			$numFactura = "00000".$numFactura;
			break;
		case 2:
			$numFactura = "0000".$numFactura;
			break;
		case 3:
			$numFactura = "000".$numFactura;
			break;
		case 4:
			$numFactura = "00".$numFactura;
			break;
		case 5:
			$numFactura = "0".$numFactura;
			break;
		case 6:
			$numFactura = "".$numFactura;
			break;
		default:
			$numFactura = "".$numFactura;
			break;
	}
}
	
	// $mostrarListaNotas=$_SESSION['mostrarListaNotas'];
	// $mostrarListaNotas=$_SESSION['mostrarNotasResumidas'];
    $mostrarListaNotas=[];
    $index=0;
    foreach($notaentregas as $nt){
        if(!empty($nt['id_operacion'])){
            $mostrarListaNotas[$index]['cantidad']=$nt['stock_operacion'];
            $mostrarListaNotas[$index]['concepto']=$notaentrega['leyenda']." a ".$notaentrega['tipo_persona'];
            $mostrarListaNotas[$index]['id_inventario']=$nt['id_inventario'];
            $mostrarListaNotas[$index]['tipo_inventario']=$nt['tipo_inventario'];
            if($nt['tipo_inventario']=="Productos"){
                $inventario = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$nt['id_inventario']}");
            }
            if($nt['tipo_inventario']=="Mercancia"){
                $inventario = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$nt['id_inventario']}");
            }
            foreach ($inventario as $key) {
                if(!empty($key['elemento'])){
                    $mostrarListaNotas[$index]['elemento']=$key['elemento'];
                    $mostrarListaNotas[$index]['codigo']=$key['codigo'];
                    $mostrarListaNotas[$index]['descripcion']=$key['elemento'];
                }
            }
			$index++;
        }
    }

	$catalag = "1";
	
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
				<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
				<title>Orden de Venta - StyleCollection</title>
				
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
									<span>Rif.: J408497786</span>
									<br>
									<span>DEPARTAMENTO <u>Facturación</u></span>
								</div>
								<div style='clear:both;'></div>
								<div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:left;padding:0'>
									AV. LOS HORCONES ENTRE CALLES 9 Y 10 DE PUEBLO NUEVO, NRO. S/N. BARRIO PUEBLO NUEVO. BARQUISIMETO, EDO LARA, ZONA POSTAL 3001.
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
											<td><br><br><span><b>Nota De Entrega</b></span></td>
											<td><span></span></td>
										</tr>
										<tr>
											<td><span style='font-size:1.2em;'><b>N°: <u>".$alternumFactura.$numFactura."</u></b></span></td>
											<td></td>
										</tr>
									</table>
									
								</div>
								<br>
							</div>
							<div style='clear:both'> </div>
							<div style='position:relative;top:-40px;margin-bottom:-35px;width:100%;text-align:center;border-top:1px solid #777;border-bottom:1px solid #777;padding:5px;font-size:1.2em;'>".mb_strtoupper('Nota de entrega de Premios y Retos')."</div>
							<div style='width:35%;display:inline-block;font-size:1.1em;'>
								
							</div>
							<div style='width:35%;display:inline-block;font-size:1.1em;'>
								
							</div>
							<div style='width:30%;display:inline-block;font-size:1.2em;'>";
								if ($numFactura != ""){
									$info .= "Nota Entrega N°. <b>".$alternumFactura.$numFactura." </b>";
								}
								$info .= "
							</div>
							<table class='table table-bordered' style='border:none;'>
								<tr>
									<td colspan='3'>
										Cliente:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$notaentrega['primer_nombre']." ".$notaentrega['segundo_nombre']." ".$notaentrega['primer_apellido']." ".$notaentrega['segundo_apellido']."
									</td>
									<td colspan='2'>
										C.I / R.I.F:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$notaentrega['cod_rif'].$notaentrega['rif']."
									</td>
								</tr>
								<tr>
									<td colspan='3'>
										Dirección:
										<span style='margin-left:10px;margin-right:10px;'></span>
										".$notaentrega['direccion']."
									</td>
									<td colspan='2'>
										Nro. Tlf: 
										<span style='margin-left:10px;margin-right:10px;'></span>
										".separateDatosCuentaTel($notaentrega['telefono'])." ";
										if(strlen($notaentrega['telefono2'])>5){
											$info .= " / ".separateDatosCuentaTel($notaentrega['telefono2']);
										}
										$info .= "
									</td>
								</tr>
							</table>
					
							<br>
						
							<table class='table table-bordered text-left' >
								<thead style='background:#EEE;font-size:1.00em;'>
									<tr>
										<th style=text-align:center;width:5%;>Cant.</th>
										<th style=text-align:left;width:42%;>Descripcion</th>
										<th style=text-align:left;width:53%;>Concepto</th>
									</tr>
									<style>
										.col1{text-align:center;}
										.col2{text-align:left;}
										.col3{text-align:left;}
										.col4{text-align:left;}
										</style>
								</thead>
								<tbody>";
									$num = 1;
									foreach ($mostrarListaNotas as $notaM) {
										$id_unico = $notaM['cantidad'].$notaM['tipo_inventario'].$notaM['id_inventario'];
                                        $info .= "
                                            <tr>
                                                <td class='col1'>
                                                    ".$notaM['cantidad']."
                                                </td>
                                                <td class='col2'>
                                                    ".$notaM['descripcion']."
                                                </td>
                                                <td class='col3'>
                                                    ".$notaM['concepto']."
                                                </td>
                                            </tr>
                                        ";
									}
									// print_r($mostrarListaNotas);
									$info .="
								</tbody>
							</table>
							<br><br><br><br><br>
						</div>
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
	
	$nameFile = "Nota de entrega N.{$numFactura} - StyleCollection";
	$dompdf->loadHtml($info);
	$dompdf->render();
	$dompdf->stream($nameFile, array("Attachment" => false));
	// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>