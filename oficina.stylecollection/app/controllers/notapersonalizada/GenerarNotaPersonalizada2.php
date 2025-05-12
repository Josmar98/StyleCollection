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

	$id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];

			  $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
			  $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
			  $nombreCampana = $pedidosClientes[0]['nombre_campana'];
			  $numeroCampana = $pedidosClientes[0]['numero_campana'];
			  $anioCampana = $pedidosClientes[0]['anio_campana'];


$id_nota=$_GET['nota'];
$notaP = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
$notaP = $notaP[0];
			$id_cliente = $notaP['id_cliente'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_cliente = $id_cliente");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
			$numFactura = "";
			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			if(count($factura)>1){
				$numFactura = $factura[0]['numero_factura'];
				switch (strlen($factura[0]['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura[0]['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura[0]['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura[0]['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura[0]['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura[0]['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura[0]['numero_factura'];
						break;
				}
			}
			$nombreanalista = $notaP['nombreanalista'];
			$nume = $notaP['numero_nota_entrega'];
			$productos = $lider->consultarQuery("SELECT * FROM productos");
			$premios = $lider->consultarQuery("SELECT * FROM premios");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");


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
				<title>Pedidos Solicitados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
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

					<div class='box-body'>
	                    <div class='text-center' style='width:60%;text-center;display:inline-block;'>
	                      <img src='public/assets/img/logoTipo1.png' style='width:70%;'>
	                      <br>
	                      	<span>Rif.: J408497786</span>
	                      	<br>
	                      <div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:center;padding:0'>
	                      	".$notaP['direccion_emision']."
	                      </div>
	                    </div>
	                    <div class='text-center'  style='width:40%;text-center;display:inline-block;'>
	                      <br>
	                      <br>
	                      <br>
	                      <div>
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
										".$notaP['lugar_emision']."
	                      			</td>
	                      			<td>
										".$lider->formatFecha($notaP['fecha_emision'])."
	                      			</td>
	                      		</tr>
	                      	</table>
	                      </div>
	                      <div>
		                      <br><br><br>
	    	                  <h4 style='margin-top:0;margin-bottom:0;'>
	        	                <b>
	            	            NOTA DE ENTREGA
	                	        </b>
	                    	  </h4>
	                    	  <br>
	                    	  <h3 style='margin:0;padding:0;'>
	        	                <b>
	            	            N° ".$nume."
	                	        </b>
	                    	  </h3>
	                    	</div>
	                    </div>
	                    <div style='clear:both'> </div>
	                    <div style='position:relative;top:-40px;margin-bottom:-35px;width:100%;text-align:center;border-top:1px solid #777;border-bottom:1px solid #777;padding:5px;font-size:1.2em;'>".mb_strtoupper('Nota de entrega de Premios y Retos')."</div>
	                    <div style='width:25%;display:inline-block;font-size:1.1em;'>
	                    	Campaña ".$numeroCampana."/".$anioCampana."
	                    </div>
	                    <div style='width:45%;display:inline-block;font-size:1.1em;'>
	                    	Analista: ".$notaP['nombreanalista']."
	                    </div>
	                    <div style='width:30%;display:inline-block;font-size:1.2em;'>";
	                    	if ($numFactura != ""){
	                    	$info .= "
	                          Factura N°. 
	                          <b>
	                          ".$numFactura." 
	                          </b>";
	                    	}
	                    $info .= "
	                    </div>
	                        <table class='table table-bordered' style='border:none;'>
	                          <tr>
	                            <td colspan='3'>
	                              NOMBRES Y APELLIDOS:
	                              <span style='margin-left:10px;margin-right:10px;'></span>
	                              ".$pedido['primer_nombre']." ".$pedido['segundo_nombre']." ".$pedido['primer_apellido']." ".$pedido['segundo_apellido']."
	                            </td>
	                            <td colspan='2'>
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
			                        $info .= "
	                            </td>
	                          </tr>
	                        </table>
	                    <br>

	                      <table class='table table-bordered text-left' >
	                        <thead style='background:#EEE;font-size:1.05em;'>
	                          <tr>
	                            <th style=text-align:center;width:4%;>Cantidad</th>
	                            <th style=text-align:left;width:38%;>Descripcion</th>
	                            <th style=text-align:left;width:38%;>Concepto</th>
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
	                        	foreach($opcionesEntregas as $entregas){ if(!empty($entregas['id_opcion_entrega_personalizada'])){
	                        		$opcionTemp=$entregas['opcion'];
	                        		if($_GET["P".$entregas['id_opcion_entrega_personalizada']]=="Y"){
		                            $info .= "<tr>
		                              <td class='col1'>
		                                ".$entregas['cantidad']."
		                              </td>
		                              <td class='col2'>";
		                              	$premio_producto = [];
		                                $id_p = "";
		                                $name_p = "";
		                                if($entregas['tipo']=="Productos"){
		                                  $premio_producto = $productos;
		                                  $id_p = "id_producto";
		                                  $name_p = "producto";
		                                }
		                                if($entregas['tipo']=="Premios"){
		                                  $premio_producto = $premios;
		                                  $id_p = "id_premio";
		                                  $name_p = "nombre_premio";
		                                }
		                                foreach ($premio_producto as $premio) {
		                                  if(!empty($premio[$id_p])){
		                                    if($premio[$id_p]==$entregas['producto_premio']){
		                                      $info .= $premio[$name_p];
		                                    }
		                                  }
		                                }
		                              $info .= "</td>
		                              <td class='col3'>
		                                ".$entregas['concepto']."
		                              </td>
		                              <td class='col4'>
		                              </td>
		                              <td class='col5'>
		                              </td>
		                            </tr>";
		                          }
		                        } }
	                          $info .="
	                        </tbody>
	                      </table>
	                      <br><br><br><br><br><br><br><br><br>
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
			
			$pgl1 = 96.001;
			$ancho = 528.00;
			$alto = 816.009;
			$altoMedio = $alto / 2;
			$dompdf->loadHtml($info);
			$dompdf->render();
			$dompdf->stream("Nota de entrega N.{$nume} {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>