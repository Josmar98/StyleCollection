<?php 

	$digitosParaCodigo = 6;
	$digitosParaCodigo2 = 8;
	$cantidadIVA = 16;

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Contable"){
	$meses = ['01'=>"Enero", '02'=>"Febrero", '03'=>"Marzo", '04'=>"Abril", '05'=>"Mayo", '06'=>"Junio", '07'=>"Julio", '08'=>"Agosto", '09'=>"Septiembre", '10'=>"Octubre", '11'=>"Noviembre", '12'=>"Diciembre"];
	$range = ['01'=>31,'02'=>28,'03'=>31,'04'=>30,'05'=>31,'06'=>30,'07'=>31,'08'=>31,'09'=>30,'10'=>31,'11'=>30,'12'=>31];
	if(!empty($_GET['anio'])){
		if( ($_GET['anio']%4)==0 ){ $range['02']=29; }
	}

	if(!empty($_POST['validarData'])){
		$idProveedor = $_POST['idProveedor'];
		$numeroFactura = mb_strtoupper($_POST['numeroFactura']);
		$numeroControl = mb_strtoupper($_POST['numeroControl']);
		$totalCompra = $_POST['totalCompra'];
		$query = "SELECT * FROM factura_compras WHERE id_proveedor_compras = {$idProveedor} and numeroFactura='{$numeroFactura}'";
		$res1 = $lider->consultarQuery($query);

		if($res1['ejecucion']==true){
			if(Count($res1)>1){
				// $response = "9"; //echo "Registro ya guardado.";
				if($res1[0]['estatus']==0){
					$res3 = $lider->modificar("UPDATE factura_compras SET estatus = 1 WHERE id_proveedor_compras = {$idProveedor} and numeroFactura='{numeroFactura}' and totalCompra={$totalCompra}");
					if($res3['ejecucion']==true){
						$response = "1";
					}
				}else{
					$response = "9"; //echo "Registro ya guardado.";
				}
			}else{
				$response = "1";
			}
		}else{
			$response = "5"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	if( !empty($_POST['fechaFactura']) && !empty($_POST['idProveedor']) && !empty($_POST['numeroFactura']) && !empty($_POST['numeroControl']) && isset($_POST['totalCompra']) && isset($_POST['comprasExentas']) && !empty($_POST['ivaH']) && isset($_POST['opRetencion']) ){

		$periodoAnio = $_POST['periodoAnio'];
		$periodoMes = $_POST['periodoMes'];
		$fechaFactura = $_POST['fechaFactura'];
		$id_proveedor_compras = $_POST['idProveedor'];
		$numeroFactura = mb_strtoupper($_POST['numeroFactura']);
		$numeroControl = mb_strtoupper($_POST['numeroControl']);
		$totalCompra = (float) $_POST['totalCompra'];
		$comprasExentas = (float) $_POST['comprasExentas'];
		$ivaH = $_POST['iva'];
		$iva = $_POST['ivaH'];
		// $comprasInternasGravadas = $_POST['comprasInternasGravadas'];
		// $ivaGeneral = $_POST['ivaGeneral'];
		$comprasInternasGravadas=0;
		$ivaGeneral=0;
		if(($totalCompra>0) && ($comprasExentas==0) ){
			$comprasInternasGravadas=$totalCompra / (($iva/100)+1 );
			$ivaGeneral=$comprasInternasGravadas*($iva/100);
		}else if(($totalCompra>0) && ($comprasExentas>0) ){
			$comprasInternasGravadas=($totalCompra-$comprasExentas) / (($iva/100)+1 );
			$ivaGeneral=$comprasInternasGravadas*($iva/100);
		}
		$comprasInternasGravadas=(float)number_format($comprasInternasGravadas,2,'.','');
		$ivaGeneral=(float)number_format($ivaGeneral,2,'.','');

		$opRetencion = $_POST['opRetencion'];
		if($opRetencion==1){
			$porcentajeRetencion = $_POST['porcentajeRetencion'];
			$retencionIva = (float) $_POST['retencionIva'];
			$comprobante = mb_strtoupper($_POST['comprobante']);
			$fechaComprobante = $_POST['fechaComprobante'];
			$query = "INSERT INTO factura_compras (id_factura_compra, id_proveedor_compras, periodoAnio, periodoMes, fechaFactura, numeroFactura, numeroControl, totalCompra, 	comprasExentas, comprasInternasGravadas, iva, ivaGeneral, opRetencion, porcentajeRetencion, retencionIva, comprobante, fechaComprobante, estatus) VALUES (DEFAULT, {$id_proveedor_compras}, '{$periodoAnio}', '{$periodoMes}', '{$fechaFactura}', '{$numeroFactura}', '{$numeroControl}', {$totalCompra}, 	{$comprasExentas}, {$comprasInternasGravadas}, {$iva}, {$ivaGeneral}, {$opRetencion}, {$porcentajeRetencion}, {$retencionIva}, '{$comprobante}', '{$fechaComprobante}', 1)";
		}else{
			$query = "INSERT INTO factura_compras (id_factura_compra, id_proveedor_compras, periodoAnio, periodoMes, fechaFactura, numeroFactura, numeroControl, totalCompra, comprasExentas, comprasInternasGravadas, iva, ivaGeneral, opRetencion, estatus) VALUES (DEFAULT, {$id_proveedor_compras},  '{$periodoAnio}', '{$periodoMes}', '{$fechaFactura}', '{$numeroFactura}', '{$numeroControl}', {$totalCompra}, {$comprasExentas}, {$comprasInternasGravadas}, {$iva}, {$ivaGeneral}, {$opRetencion}, 1)";
		}


		// echo $query;
		$exec = $lider->registrar($query, "factura_compras", "id_factura_compra");
		// die();
		if($exec['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura de Compras', 'Registrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
		
		$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_compras WHERE estatus=1");
		if(!empty($action)){
			if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
				require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}else{
			if (is_file('public/views/'.$url.'.php')) {
				require_once 'public/views/'.$url.'.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}	


		// print_r($exec);
	}
	if(empty($_POST)){
		$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_compras WHERE estatus=1");
		if(!empty($action)){
			if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
				require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}else{
			if (is_file('public/views/'.$url.'.php')) {
				require_once 'public/views/'.$url.'.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}	
	}
}else{
	require_once 'public/views/error404.php';
}


?>