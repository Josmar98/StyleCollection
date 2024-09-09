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


$nota = $_GET['nota'];
$notaentregas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega = $nota");
$notaentrega = $notaentregas[0];

$optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

$id = $notaentrega['id_cliente'];
$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
$pedido = $pedidos[0];
$id_pedido = $pedido['id_pedido'];
$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");



$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
		$numFactura = "";
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
	          default:
	            $numFactura = "".$factura[0]['numero_factura'];
	          	break;
	        }
		}

$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_campana = {$id_campana} and planes_campana.id_campana = {$id_campana} and planes_campana.id_plan = planes.id_plan and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and tipos_colecciones.id_pedido = {$id_pedido} and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");
$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
$premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
// if(count($premios_planes) < 2){
// 	$pplan_momentaneo = $planesCol[0]['nombre_plan'];
// 	$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes.nombre_plan = '{$pplan_momentaneo}'");
// }

$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");

$retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

$canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho} and canjeos.id_cliente = {$id}");
$canjeosUnic = $lider->consultarQuery("SELECT DISTINCT catalogos.id_catalogo, nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

$premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA = ''");
$premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA <> ''");
			$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
			$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
			$despacho = $despachos[0];
			$iterRecor = 0;
			foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
				if($pagosD['tipo_pago_despacho']=="Inicial"){
					// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
					$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'cod'=>'I', 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
					$iterRecor++;
				}
			} }

			$cantidadPagosDespachosFild = [];

			for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
				$key = $cantidadPagosDespachos[$i];
				if($key['cantidad'] <= $despacho['cantidad_pagos']){
					$cantidadPagosDespachosFild[$i] = $key;
					foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
						if($pagosD['tipo_pago_despacho']==$key['name']){
							if($i < $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
								$iterRecor++;
							}
							if($i == $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
								$iterRecor++;
							}
						}
					}}
				}
			}

			// ========================== // =============================== // ============================== //
			if(count($premios_planes)<2){
				$premios_planes = [];
				$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

				$id_planes_camp = [];
				$nidxp = 0;
				foreach ($pagosRecorridos as $pagosR) {
					if(!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
					}else{
						$id_planes_camp[$nidxp]['id_tipo'] = $pagosR['name'];
						$id_planes_camp[$nidxp]['id_plan'] = 0;
						$nidxp++;
					}
				}
				for ($i=0; $i < count($id_planes_camp); $i++) { 
					foreach ($premios_planes as $key) {
						if(!empty($key['id_plan_campana'])){
							if($id_planes_camp[$i]['id_tipo']==$key['tipo_premio']){
								if($id_planes_camp[$i]['id_plan']==0){
									$id_planes_camp[$i]['id_plan'] = $key['id_plan_campana'];
								}
							}
						}
					}
				}

				$n1 = 0;
				$premios_planes = [];
				foreach ($id_planes_camp as $keys) {
					$id_plan_camp = $keys['id_plan'];
					$tipo_plan_camp = $keys['id_tipo'];
					$newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
					foreach ($newPlan as $nplan) {
						if(!empty($nplan['id_plan_campana'])){
							$premios_planes[$n1] = $nplan;
							$n1++;
						}
					}
				}
			}

			$premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
			$controladorPremios = [];
			$numeroX = 0;
			foreach ($planesCol as $key1) {
				if(!empty($key1['id_plan'])){
					$numeroX2 = 0;
					foreach ($pagosRecorridos as $pagosR) {
						if(!empty($controladorPremios[$numeroX]['plan'])){
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}else{
							$controladorPremios[$numeroX]['id_plan'] = $key1['id_plan'];
							$controladorPremios[$numeroX]['plan'] = $key1['nombre_plan'];
							$controladorPremios[$numeroX]['cantidad_colecciones'] = $key1['cantidad_coleccion'];
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']] = [];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}
						$numeroX2++;
					}
					$numeroX++;
				}
			}
			// ========================== // =============================== // ============================== //

			# ==================================================================================
				$fechas_promociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
				$abonoCantPromo = [];
				if(!empty($fechas_promociones[0])){
					$fechaPromocion = $fechas_promociones[0];
					$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and promociones.id_campana={$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.id_cliente = {$id} and promociones.id_pedido = {$id_pedido}");

					$promosTomarEnCuenta = "";
					$numIndex = 0;
					foreach ($promociones as $keys) {
						if(!empty($keys['id_promociones'])){
							$promosTomarEnCuenta .= "'".$keys['nombre_promocion']."'";
							$abonoCantPromo[$keys['id_promociones']]['id'] = $keys['id_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['ids'] = $keys['id_promociones'];
							$abonoCantPromo[$keys['id_promociones']]['promocion'] = $keys['nombre_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['costo'] = $keys['precio_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['aprobadas'] = $keys['cantidad_aprobada_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['abonado'] = 0;
							$abonoCantPromo[$keys['id_promociones']]['cantidad'] = 0;
							if($numIndex < (count($promociones)-2)){
								$promosTomarEnCuenta .= ", ";
							}
							$numIndex++;
						}
					}
					$fechaPagoPromocion = $fechaPromocion['fecha_pago_promocion'];
					$pagosPromos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.id_pedido = {$id_pedido} and pagos.tipo_pago IN ({$promosTomarEnCuenta}) and pagos.fecha_pago <= '{$fechaPagoPromocion}'");
					foreach ($pagosPromos as $pagosP) { if(!empty($pagosP['id_pago'])){
						foreach ($promociones as $keys) { if(!empty($keys['id_promociones'])){
							if($pagosP['tipo_pago']==$keys['nombre_promocion']){
								if($pagosP['estado']=="Abonado"){
									$abonoCantPromo[$keys['id_promociones']]['abonado'] += $pagosP['equivalente_pago'];
								}
							}
						} }
					} }

					foreach ($abonoCantPromo as $promos) {
						$nombrePromos = "";
						$nombrePromos = $abonoCantPromo[$promos['ids']]['promocion'];
						$distribucionPromociones = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$id_pedido} and distribucion_pagos.estatus = 1 and distribucion_pagos.tipo_distribucion = '{$nombrePromos}'");
						$distribucionPromoActual = 0;
						foreach ($distribucionPromociones as $dist) {
							if(!empty($dist['id_distribucion_pagos'])){
								$distribucionPromoActual += $dist['cantidad_distribucion'];
							}
						}
						$promoAbonado = 0;
						$promoAbonado += $promos['abonado'];
						$promoAbonado += $distribucionPromoActual;
						$cantidad = ($promoAbonado/$promos['costo']);
						$cantidadFormat = number_format($cantidad, 2, ",",".");
						$cantidadVal = intval($cantidadFormat);
						if($cantidadVal > $abonoCantPromo[$promos['ids']]['aprobadas']){
							$cantidadVal = $abonoCantPromo[$promos['ids']]['aprobadas'];
						}
						$abonoCantPromo[$promos['ids']]['cantidad'] = $cantidadVal;
					}
					$premios_promocion = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana}");
					$productos = $lider->consultarQuery("SELECT * FROM productos, premios_promocion WHERE productos.id_producto = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and productos.estatus = 1");
					$premios = $lider->consultarQuery("SELECT * FROM premios, premios_promocion WHERE premios.id_premio = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and premios.estatus = 1");
				}
			# ==================================================================================

	$catalag = "1";

				switch (strlen($notaentrega['numero_nota_entrega'])) {
          case 1:
            $numero_nota_entrega = "000000".$notaentrega['numero_nota_entrega'];
            break;
          case 2:
            $numero_nota_entrega = "00000".$notaentrega['numero_nota_entrega'];
            break;
          case 3:
            $numero_nota_entrega = "0000".$notaentrega['numero_nota_entrega'];
            break;
          case 4:
            $numero_nota_entrega = "000".$notaentrega['numero_nota_entrega'];
            break;
          case 5:
            $numero_nota_entrega = "00".$notaentrega['numero_nota_entrega'];
            break;
          case 6:
            $numero_nota_entrega = "0".$notaentrega['numero_nota_entrega'];
            break;
          case 7:
            $numero_nota_entrega = "".$notaentrega['numero_nota_entrega'];
            break;
          default:
            $numero_nota_entrega = "".$notaentrega['numero_nota_entrega'];
          	break;
        }


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

					<div class='box-body' style='background:;'>
              <div class='text-center' style='width:60%;text-center;display:inline-block;'>
                <img src='public/assets/img/logoTipo1.png' style='width:70%;'>
                <br>
                	<span>Rif.: J408497786</span>
                	<br>
                <div style='border:none;min-width:100%;max-width:100%;min-height:50px;max-height:50px;text-align:center;padding:0'>
                	".$notaentrega['direccion_emision']."
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
												".$notaentrega['lugar_emision']."
                			</td>
                			<td>
												".$lider->formatFecha($notaentrega['fecha_emision'])."
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
      	            N° ".$numero_nota_entrega."
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
              	Analista: ".$notaentrega['nombreanalista']."
              </div>
              <div style='width:30%;display:inline-block;font-size:1.2em;'>";
              	if ($numFactura != ""){
              	$info .= "
                    Factura N°. 
                    <b>
                    ".$numFactura." 
                    </b>";
              	}
              $info .= "</div>
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
                  $info .= "</td>
                </tr>
              </table>
            	<br>

              <table class='table table-bordered text-left' >
                <thead style='background:#EEE;font-size:1.00em;'>
                  <tr>
                    <th style=text-align:center;width:4%;>Cant.</th>
                    <th style=text-align:left;width:50%;>Descripcion</th>
                    <th style=text-align:left;width:40%;>Concepto</th>
                    <th style=text-align:left;width:6%;></th>
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
                    foreach ($pedidos as $data){ 
                      if(!empty($data['id_pedido'])){
                        // ========================== // =============================== // ============================== //
                      $coleccionesPlanPremioPedido = [];
                      // ========================== // =============================== // ============================== //
                      foreach ($pagosRecorridos as $pagosR){
                      	$arrayMostrarNota = [];
                      	$arrayMostrarNota[$pagosR['name']] = [];
                        if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
                          foreach ($planesCol as $data2){
                            if(!empty($data2['id_cliente'])) { 
                              if ($data['id_pedido'] == $data2['id_pedido']) { 
                                if ($data2['cantidad_coleccion_plan']>0) {
                                  // ========================== // =============================== // ============================== //
                                  $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_seleccionada'] = $data2['cantidad_coleccion_plan'];
                                  $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = 0;
                                  // ========================== // =============================== // ============================== //
                                  foreach ($premios_perdidos as $dataperdidos) {
                                    if(!empty($dataperdidos['id_premio_perdido'])){
                                    	if($dataperdidos['id_pedido'] == $data['id_pedido']){
	                                      $comparedPlan = "";
	                                      if($dataperdidos['codigo']=="nombre"){
	                                      	$comparedPlan = $data2['nombre_plan'];
	                                      }
	                                      if($dataperdidos['codigo']=="nombreid"){
	                                      	$comparedPlan = $data2['id_plan'];
	                                      }
	                                      if( ($dataperdidos['valor'] == $comparedPlan) ){
	                                      	$nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
	                                        // ========================== // =============================== // ============================== //
	                                        if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
	                                          if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
	                                            $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoResult;
	                                          }
	                                        }
	                                        // ========================== // =============================== // ============================== //
	                                        if($nuevoResult>0){
	                                          foreach ($premios_planes3 as $planstandard){
	                                            if ($planstandard['id_plan_campana']){
	                                              if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
	                                                if ($planstandard['tipo_premio']==$pagosR['name']){
	                                                  $option = "";
	                                                  $planIDACT=$data2['id_plan'];
	                                                  foreach ($optNotas as $opt){
	                                                    if(!empty($opt['id_opcion_entrega'])){
	                                                      if($opt['cod']==$planIDACT.$planstandard['id_premio']){
	                                                        $option = $opt['val'];
	                                                      }
	                                                    }
	                                                  }
	                                                  if($catalag=="1"){
	                                                  	$condicion = $_GET[$planIDACT.$planstandard['id_premio']];	
	                                                  }
	                                                  if($catalag=="0"){
	                                                  	$condicion = $option;
	                                                  }
	                                                  if($condicion=="Y"){
	                                                  	$info .= "
	                                                    <tr>
	                                                      <td class='col1'>
	                                                        ".$nuevoResult."
	                                                      </td>
	                                                      <td class='col2'>
	                                                        ".$planstandard['producto']."
	                                                      </td>
	                                                      <td class='col3'>
	                                                        Premio de ".$pagosR['name']." <small style='font-size:.8em;'>(Plan ".$planstandard['nombre_plan'].")</small>
	                                                      </td>
	                                                      <td class='col4'>
	                                                      </td>
	                                                    </tr>";
	                                                  } 
	                                                }
	                                              }
	                                            }
	                                          }
	                                        }
	                                      }
                                      }
                                    }
                                  }
                                  // ========================== // =============================== // ============================== //
                                  $nuevoTSelected = 0;
                                  // ========================== // =============================== // ============================== //
                                  foreach ($premioscol as $data3){
                                    if(!empty($data3['id_premio'])){
                                      if ($data3['id_plan']==$data2['id_plan']){
                                        if ($data['id_pedido']==$data3['id_pedido']){
                                          if($data3['cantidad_premios_plan']>0){
                                            foreach ($premios_perdidos as $dataperdidos) {
                                              if(!empty($dataperdidos['id_premio_perdido'])){
                                                if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
                                                  $nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                  // ========================== // =============================== // ============================== //
                                                  $nuevoTSelected += $nuevoResult;
                                                  // ========================== // =============================== // ============================== //
                                                  if($nuevoResult>0){
                                                    $option = "";
                                                    foreach ($optNotas as $opt){
                                                      if(!empty($opt['id_opcion_entrega'])){
                                                        if($opt['cod']=="P".$data3['id_plan'].$data3['id_premio']){
                                                          $option = $opt['val'];
                                                        }
                                                      }
                                                    }
                                                    if($catalag=="1"){
                                                    	$condicion = $_GET['P'.$data3['id_plan'].$data3['id_premio']];	
                                                    }
                                                    if($catalag=="0"){
                                                    	$condicion = $option;
                                                    }
                                                    if($condicion=="Y"){
                                                      $info .= "
                                                      <tr>
                                                        <td class='col1'>
                                                          ".$nuevoResult."
                                                        </td>
                                                        <td class='col2'>
                                                          ".$data3['nombre_premio']."
                                                        </td>
                                                        <td class='col3'>
                                                          Premio de ".$pagosR['name']." <small style='font-size:.8em;'>(Plan ".$data3['nombre_plan'].")</small>
                                                        </td>
                                                        <td class='col4'>
                                                        </td>
                                                      </tr>";
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        }
                                      }
                                    }
                                  }
                                  // ========================== // =============================== // ============================== //
                                  // echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
                                  if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                    if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
                                      $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoTSelected;
                                    }
                                  }
                                  // echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
                                  // ========================== // =============================== // ============================== //
                                }
                              }
                            }
                          }
                        }else{
                          // ========================== // =============================== // ============================== //
                          $maxDisponiblePremiosSeleccion = 0;
                          $opMaxDisp = 0;
                          $opPlansinPremio = false;
                          $cantidadRestar = 0;
                          foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                            if ($data['id_pedido'] == $data2['id_pedido']){
                              if ($data2['cantidad_coleccion_plan']>0){
                                if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
                                  $opMaxDisp = 1;
                                  $seleccionado = $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'];
                                  $cantidadCols = $data2['cantidad_coleccion'] * $seleccionado;
                                  $premiosDispPlanSeleccion = $controladorPremios[$data2['nombre_plan']][$pagosR['name']];
                                  $multiDisponiblePremiosSeleccion = ($premiosDispPlanSeleccion*$cantidadCols);
                                  $maxDisponiblePremiosSeleccion += $multiDisponiblePremiosSeleccion;
                                  // echo $premiosDispPlanSeleccion."*".$cantidadCols." = ".$multiDisponiblePremiosSeleccion." Cols. de Plan ".$data2['nombre_plan']."<br>";
                                  // if($premiosDispPlanSeleccion==0){
                                  //   $opPlansinPremio = true;
                                  //   $cantidadRestar+=$cantidadCols;
                                  // }
                                }
                              }
                            }
                          } }
                          if($opMaxDisp==0){
                            $maxDisponiblePremiosSeleccion = -1;
                          }
                          // ========================== // =============================== // ============================== //
                          foreach ($premios_perdidos as $dataperdidos) {
                            if(!empty($dataperdidos['id_premio_perdido'])){
                              // if(($dataperdidos['valor'] == $pagosR['id']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                              if($dataperdidos['id_pedido'] == $data['id_pedido']){
                              	// $posOrigin = strpos($dataperdidos['valor'], "_pago");
                                // $posIDPago = strpos($dataperdidos['valor'], "_pago") + strlen("_pago");
                                if(strtolower($pagosR['name'])=="inicial"){
                                	$posOrigin = strpos($dataperdidos['valor'], "cial");
                                	$posIDPago = strpos($dataperdidos['valor'], "cial") + strlen("cial");
                                }else{
                                	$posOrigin = strpos($dataperdidos['valor'], "_pago");
                                	$posIDPago = strpos($dataperdidos['valor'], "_pago") + strlen("_pago");
                                }
                                $dataNamePerdido = substr($dataperdidos['valor'], 0, $posIDPago);
                                $dataNamePerdidoIdPlan = substr($dataperdidos['valor'], $posIDPago);
                                $dataComparar = "";
                                if($posOrigin==""){
                                  $dataComparar = $dataperdidos['valor'];
                                }else{
                                  $dataComparar = $dataNamePerdido;
                                }
                                if(($dataComparar == $pagosR['id'])){
                                	if($dataNamePerdidoIdPlan==""){
		                                $nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
		                                // ========================== // =============================== // ============================== //
		                                if($opPlansinPremio){
		                                  $nuevoResult -= $cantidadRestar;
		                                  // if($maxDisponiblePremiosSeleccion>0){
		                                  //   if($nuevoResult>$maxDisponiblePremiosSeleccion){
		                                  //     $nuevoResult = $maxDisponiblePremiosSeleccion;
		                                  //   }
		                                  // }
		                                }
		                                // ========================== // =============================== // ============================== //
			                              if(!empty($dataperdidos['id_premio_perdido'])){
			                                if($nuevoResult>0){
			                                  foreach ($premios_planes as $planstandard){
			                                    if (!empty($planstandard['id_plan_campana'])){
			                                      if ($planstandard['tipo_premio'] == $pagosR['name']){
			                                      	$codigoPagoAdd = $pagosR['cod'].$planstandard['id_premio'];
			                                        $option = "";
			                                        foreach ($optNotas as $opt){
			                                          if(!empty($opt['id_opcion_entrega'])){
			                                            if($opt['cod']==$codigoPagoAdd){
			                                              $option = $opt['val'];
			                                            }
			                                          }
			                                        }
			                                        if($catalag=="1"){
			                                        	$condicion = $_GET[$codigoPagoAdd];	
			                                        }
			                                        if($catalag=="0"){
			                                        	$condicion = $option;
			                                        }
			                                      	if($condicion=="Y"){
			                                      		if(!empty($arrayMostrarNota[$pagosR['name']][$planstandard['producto']])){
	                                                $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]['cantidad']+=($nuevoResult*$data2['cantidad_coleccion']);
	                                                $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]['planes'].=" | ".$data2['nombre_plan'];
	                                              }else{
	                                                $arrayMostrarNota[$pagosR['name']][$planstandard['producto']]=[
	                                                  'id'=>$planstandard['id_producto'],
	                                                  'nombre'=>$planstandard['producto'],
	                                                  'cantidad'=>($nuevoResult*$data2['cantidad_coleccion']),
	                                                  'tipo'=>$pagosR['name'],
	                                                  'planes'=>$data2['nombre_plan'],
	                                                ];
	                                              }
			                                        	// $info .= "
			                                          // <tr>
			                                          //   <td class='col1'>
			                                          //     ".($nuevoResult*$data2['cantidad_coleccion'])."
			                                          //   </td>
			                                          //   <td class='col2'>
			                                          //     ".$planstandard['producto']."
			                                          //   </td>
			                                          //   <td class='col3'>
			                                          //     Premio de ".$pagosR['name']."
			                                          //   </td>
			                                          //   <td class='col4'>
			                                          //   </td>
			                                          //   <td class='col5'>
			                                          //   </td>
			                                          // </tr>";
			                                      	}
			                                      }
			                                    }
			                                  }
			                                }
			                              }
		                              }else{
		                              	foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                      if ($data['id_pedido'] == $data2['id_pedido']){
                                        if ($data2['cantidad_coleccion_plan']>0){
                                          if($dataNamePerdidoIdPlan==$data2['id_plan']){
                                            if(!empty($dataperdidos['id_premio_perdido'])){
                                              // echo $data2['cantidad_coleccion_plan']." | ";
                                              $nuevoResult = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                              // ========================== // =============================== // ============================== //
                                              if($opPlansinPremio){
                                                $nuevoResult -= $cantidadRestar;
                                                // if($maxDisponiblePremiosSeleccion>0){
                                                //   if($nuevoResult>$maxDisponiblePremiosSeleccion){
                                                //     $nuevoResult = $maxDisponiblePremiosSeleccion;
                                                //   }
                                                // }
                                              }
                                              // ========================== // =============================== // ============================== //
                                              if($nuevoResult>0){
                                                foreach ($premios_planes3 as $premiosP) {
                                                  if(!empty($premiosP['nombre_plan'])){
                                                    if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                      if($pagosR['name']==$premiosP['tipo_premio']){
                                                        $codigoPagoAdd = $pagosR['cod'].$premiosP['id_plan']."-".$premiosP['id_premio'];
                                                        $codigoPagoAdd = $pagosR['cod'].$premiosP['id_premio'];
								                                        $option = "";
								                                        foreach ($optNotas as $opt){
								                                          if(!empty($opt['id_opcion_entrega'])){
								                                            if($opt['cod']==$codigoPagoAdd){
								                                              $option = $opt['val'];
								                                            }
								                                          }
								                                        }
								                                        if($catalag=="1"){
								                                        	$condicion = $_GET[$codigoPagoAdd];	
								                                        }
								                                        if($catalag=="0"){
								                                        	$condicion = $option;
								                                        }
								                                      	if($condicion=="Y"){
								                                      		if(!empty($arrayMostrarNota[$pagosR['name']][$premiosP['producto']])){
                                                            $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]['cantidad']+=($nuevoResult*$data2['cantidad_coleccion']);
                                                            $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]['planes'].=" | ".$premiosP['nombre_plan'];
                                                          }else{
                                                            $arrayMostrarNota[$pagosR['name']][$premiosP['producto']]=[
                                                              'id'=>$premiosP['id_premio'],
                                                              'nombre'=>$premiosP['producto'],
                                                              'cantidad'=>($nuevoResult*$data2['cantidad_coleccion']),
                                                              'tipo'=>$premiosP['tipo_premio'],
                                                              'planes'=>$premiosP['nombre_plan'],
                                                            ];
                                                          }
								                                        	// $info .= "
								                                          // <tr>
								                                          //   <td class='col1'>
								                                          //     ".($nuevoResult*$data2['cantidad_coleccion'])."
								                                          //   </td>
								                                          //   <td class='col2'>
								                                          //     ".$premiosP['producto']."
								                                          //   </td>
								                                          //   <td class='col3'>
								                                          //     Premio de ".$premiosP['tipo_premio']." P. ".$premiosP['nombre_plan']."
								                                          //   </td>
								                                          //   <td class='col4'>
								                                          //   </td>
								                                          //   <td class='col5'>
								                                          //   </td>
								                                          // </tr>";
								                                          
								                                      	}
                                                       
                                                      }
                                                    }
                                                  }
                                                }
                                                //echo "<br>";
                                                // echo $data2['nombre_plan']." | ".$dataperdidos['id_premio_perdido']." | ".$nuevoResult." | <br>";
                                              }
                                            }
                                          }
                                        }
                                      }
                                    } }
		                              }
                                }

                              }
                            }
                          }

                          // $info .=$pagosR['name']."<br>";
                          foreach ($arrayMostrarNota[$pagosR['name']] as $key) {
                          	$nameTPlan = "";
                          	$posiposi = strpos($key['planes'], "|");
                          	$nameTPlan = ($posiposi=='') ? 'Plan' : 'Planes';
                          	$info .= "
                              <tr>
                                <td class='col1'>
                                  ".$key['cantidad']."
                                </td>
                                <td class='col2'>
                                  ".$key['nombre']."
                                </td>
                                <td class='col3'>
                                  Premio de ".$key['tipo']." <small style='font-size:.8em;'>(".$nameTPlan." ".$key['planes'].")</small>
                                </td>
                                <td class='col4'>
                                </td>
                              </tr>";
                          }



                        }
                      }
                      foreach ($retos as $reto){
                        if (!empty($reto['id_reto'])){
                          if ($reto['id_pedido']==$data['id_pedido']){
                            if ($reto['cantidad_retos']){
                                foreach ($optNotas as $opt){ 
                                  if(!empty($opt['id_opcion_entrega'])){ 
                                    if($opt['cod']=="R".$reto['id_premio']){
                                       $option = $opt['val'];
                                    }
                                  }
                                } 
                                // retos
                                if($catalag=="1"){
                                	$condicion = $_GET['R'.$reto['id_premio']];	
                                }
                                if($catalag=="0"){
                                	$condicion = $option;
                                }
                                if($condicion=="Y"){
                                $info .= "
                                  <tr>
                                    <td class='col1'>
                                      ".$reto['cantidad_retos']."
                                    </td>
                                    <td class='col2'>
                                      ".$reto['nombre_premio']."
                                    </td>
                                    <td class='col3'>
                                        Premio de Reto Junior
                                    </td>
                                    <td class='col4'></td>
                                  </tr>";
                            		}
                            }
                          }
                        }
                      }
                      foreach ($abonoCantPromo as $promos){
                      	foreach($premios_promocion as $premioP){ if(!empty($premioP['id_promocion'])){
                          if($premioP['id_promocion']==$promos['id']){
                            $idPromo = 0;
                            $cantPromo = 0;
                            $nombrePremioPromo = "";
                            $nombrePromocion = $promos['promocion'];
                            if($premioP['tipo_premio']=="Producto"){
                              foreach ($productos as $pPromo){ if(!empty($pPromo['id_producto'])){
                                if($pPromo['id_producto']==$premioP['id_premio']){
                                  // $idPromo = $promos['ids'].$premioP['id_premio'];
                                  $idPromo = "PD".$premioP['id_premio'];
                                  $cantPromo = $promos['cantidad'];
                                  $nombrePremioPromo = $pPromo['producto'];
                                }
                              }}
                            }
                            if($premioP['tipo_premio']=="Premio"){
                              foreach ($premios as $pPromo){ if(!empty($pPromo['id_premio'])){
                                if($pPromo['id_premio']==$premioP['id_premio']){
                                  $idPromo = "PR".$premioP['id_premio'];
                                  $cantPromo = $promos['cantidad'];
                                  $nombrePremioPromo = $pPromo['nombre_premio'];
                                }
                              }}
                            }
                            if($cantPromo>0){
                              	$option = "";
                                foreach ($optNotas as $opt){ 
                                	if(!empty($opt['id_opcion_entrega'])){ 
                                		if($opt['cod']==$idPromo){
                                			$option = $opt['val'];
                                    }
                                  }
                                }
                                // foreach ($optNotas as $opt){ 
                                //   if(!empty($opt['id_opcion_entrega'])){ 
                                //     if($opt['cod']==$idPromo){
                                //     	$option = $opt['val'];
                                //     }
                                //   }
                                // } 
                                // retos
                                if($catalag=="1"){
                                	$condicion = $_GET[$idPromo];	
                                }
                                if($catalag=="0"){
                                	$condicion = $option;
                                }
                                if($condicion=="Y"){
                                $info .= "
                                  <tr>
                                    <td class='col1'>
                                      ".$cantPromo."
                                    </td>
                                    <td class='col2'>
                                      ".$nombrePremioPromo."
                                    </td>
                                    <td class='col3'>
                                        Premio de ".$nombrePromocion."
                                    </td>
                                    <td class='col4'></td>
                                  </tr>";
                            		}
                            }
                          }
                      	} }
                      }
                      foreach ($premios_autorizados as $premiosAutorizados){
                        if (!empty($premiosAutorizados['id_PA'])){
                          if ($premiosAutorizados['id_pedido']==$data['id_pedido']){
                            if ($premiosAutorizados['cantidad_PA']){
                                foreach ($optNotas as $opt){ 
                                  if(!empty($opt['id_opcion_entrega'])){ 
                                    if($opt['cod']=="PA".$premiosAutorizados['id_PA']){
                                       $option = $opt['val'];
                                    }
                                  }
                                } 
                                // premiosAutorizadoss
                                 if($catalag=="1"){
                                 	$condicion = $_GET['PA'.$premiosAutorizados['id_PA']];	
                                 }
                                 if($catalag=="0"){
                                 	$condicion = $option;
                                 }
                                if($condicion=="Y"){
                                	$conten = "";
                                	if($premiosAutorizados['descripcion_PA']==""){
                                		$conten = $premiosAutorizados['firma_PA'];
                                	}else{
                                		$conten = $premiosAutorizados['descripcion_PA'];
                                	}
                                $info .= "
                                  <tr>
                                    <td class='col1'>
                                      ".$premiosAutorizados['cantidad_PA']."
                                    </td>
                                    <td class='col2'>
                                      ".$premiosAutorizados['nombre_premio']."
                                    </td>
                                    <td class='col3'>
                                      ".$conten."
                                    </td>
                                    <td class='col4'></td>
                                  </tr>";
                            		}
                            }
                          }
                        }
                      }
                      foreach ($premios_autorizados_obsequio as $premiosAutorizados){
                        if (!empty($premiosAutorizados['id_PA'])){
                          if ($premiosAutorizados['id_pedido']==$data['id_pedido']){
                            if ($premiosAutorizados['cantidad_PA']){
                                foreach ($optNotas as $opt){ 
                                  if(!empty($opt['id_opcion_entrega'])){ 
                                    if($opt['cod']=="PA".$premiosAutorizados['id_PA']){
                                       $option = $opt['val'];
                                    }
                                  }
                                } 
                                // premiosAutorizadoss
                                 if($catalag=="1"){
                                 	$condicion = $_GET['PA'.$premiosAutorizados['id_PA']];	
                                 }
                                 if($catalag=="0"){
                                 	$condicion = $option;
                                 }
                                if($condicion=="Y"){
                                	$conten = "";
                                	if($premiosAutorizados['descripcion_PA']==""){
                                		$conten = $premiosAutorizados['firma_PA'];
                                	}else{
                                		$conten = $premiosAutorizados['descripcion_PA'];
                                	}
                                $info .= "
                                  <tr>
                                    <td class='col1'>
                                      ".$premiosAutorizados['cantidad_PA']."
                                    </td>
                                    <td class='col2'>
                                      ".$premiosAutorizados['nombre_premio']."
                                    </td>
                                    <td class='col3'>
                                      ".$conten."
                                    </td>
                                    <td class='col4'></td>
                                  </tr>";
                            		}
                            }
                          }
                        }
                      }
                      $arrayt = [];
                      $numCC = 0;
                      foreach ($canjeosUnic as $canUnic) {
                      	if(!empty($canUnic['nombre_catalogo'])){
                      		$arrayt[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                          $arrayt[$numCC]['cantidad'] = 0;
                          $arrayt[$numCC]['id_catalogo'] = $canUnic['id_catalogo']; 
                          $numCC++;
                        }
                      }
                      foreach ($canjeos as $canje){
                        if (!empty($canje['id_cliente'])){
                          // if ($canje['id_cliente']==$data['id_cliente']){
                            for ($i=0; $i < count($arrayt); $i++) { 
                              if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
                                $arrayt[$i]['cantidad']++;
                              }
                            }
                          // }
                        }
                      }
                      foreach ($arrayt as $canjeos){
                       	if (!empty($canjeos['id_catalogo'])){
                       		if ($canjeos['cantidad']){
                       			$option = "";
                       			foreach ($optNotas as $opt){ 
                       				if(!empty($opt['id_opcion_entrega'])){ 
                       					if($opt['cod']=="CG".$canjeos['id_catalogo']){
                       						$option = $opt['val'];
                       					}
                       				}
                       			} 
                       			if($catalag=="1"){
                       				$condicion = $_GET['CG'.$canjeos['id_catalogo']];	
                       			}
                       			if($catalag=="0"){
                       				$condicion = $option;	
                       			}
                       			if($condicion == "Y"){
                              
                              $info .= "
                                  <tr>
                                    <td class='col1'>
                                      ".$canjeos['cantidad']."
                                    </td>
                                    <td class='col2'>
                                      ".$canjeos['nombre']."
                                    </td>
                                    <td class='col3'>
                                        Premios Canjeados
                                    </td>
                                    <td class='col4'>
                                    </td>
                                  </tr>";
                              	}
                              }
                          }
                      }
                      $num++;
                    }
                  }
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
			$dompdf->stream("Nota de entrega N.{$numero_nota_entrega} {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>