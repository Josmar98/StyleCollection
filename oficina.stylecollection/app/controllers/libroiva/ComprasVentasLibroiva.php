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

	if( !empty($_POST['RestaurarData']) && !empty($_POST['id']) ){
		$idss = $_POST['id'];
		$query = "UPDATE factura_ventas SET estatus=1 WHERE id_factura_ventas = {$idss}";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura de Ventas', 'Restaruar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	if( !empty($_POST['BorrarData']) && !empty($_POST['id']) ){
		$idss = $_POST['id'];
		$query = "UPDATE factura_ventas SET estatus=0 WHERE id_factura_ventas = {$idss}";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura de Ventas', 'Borrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	// if(!empty($_POST['validarData'])){
	// 	$nombre_liderazgo = mb_strtoupper($_POST['nombre_liderazgo']);
	// 	$query = "SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo'";
	// 	$res1 = $lider->consultarQuery($query);
	// 	if($res1['ejecucion']==true){
	// 		if(Count($res1)>1){
	// 			// $response = "9"; //echo "Registro ya guardado.";
	// 		  $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
	// 	      if($res2['ejecucion']==true){
	// 	        if(Count($res2)>1){
	// 	          $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
	// 	          if($res3['ejecucion']==true){
	// 	            $response = "1";
	// 	          }
	// 	        }else{
	// 	          $response = "9"; //echo "Registro ya guardado.";
	// 	        }
	// 	      }


	// 		}else{
	// 			$response = "1";
	// 		}
	// 	}else{
	// 		$response = "5"; // echo 'Error en la conexion con la bd';
	// 	}
	// 	echo $response;
	// }
	$excedenteCreditosFiscalesPendienteAnterior = 0;
	$debitosFiscalesPendienteAnterior = 0;
	$operacionMostrarInformacion = false;
	if( 
		(!empty($_GET['tipo']) && $_GET['tipo']=="1") && (!empty($_GET['anio'])) ||
		(!empty($_GET['tipo']) && $_GET['tipo']=="2") && ( !empty($_GET['anio']) && !empty($_GET['mes']) )
	){
		$operacionMostrarInformacion = true;
		$tipo=$_GET['tipo'];
		if( !empty($_GET['mes']) ){
			$inicioFecha = $_GET['anio']."-".$_GET['mes']."-01";
			$finFecha = $_GET['anio']."-".$_GET['mes']."-".$range[$_GET['mes']];
			$compras=$lider->consultarQuery("SELECT * FROM proveedores_compras, factura_compras WHERE proveedores_compras.id_proveedor_compras = factura_compras.id_proveedor_compras and factura_compras.estatus=1 and factura_compras.periodoAnio='{$_GET['anio']}' and factura_compras.periodoMes='{$_GET['mes']}' ORDER BY factura_compras.periodoAnio DESC, factura_compras.periodoMes DESC, factura_compras.fechaFactura ASC;");
			$actualAnio = $_GET['anio'];
			$actualMes = $_GET['mes'];

			if($actualMes=="01"){
				$anteriorMes="12";
				$anteriorAnio=$actualAnio-1;
			}else{
				$anteriorAnio=$actualAnio;
				if(strlen($actualMes-1)==1){
					$anteriorMes="0";
					$anteriorMes.=($actualMes-1);
				}else{
					$anteriorMes=$actualMes-1;
				}
			}
			$resumenCompra = $lider->consultarQuery("SELECT * FROM resumen_compras WHERE periodoAnio='{$anteriorAnio}' and periodoMes='{$anteriorMes}'");
			foreach ($resumenCompra as $resumenes) {
				if(!empty($resumenes['id_resumen_compra'])){
					$excedenteCreditosFiscalesPendienteAnterior+=$resumenes['creditoFiscal'];
					$debitosFiscalesPendienteAnterior+=$resumenes['debitoFiscal'];
				}
			}

		} else {
			$inicioFecha = $_GET['anio']."-"."01"."-01";
			$finFecha = $_GET['anio']."-"."12"."-".$range['12'];
			$compras=$lider->consultarQuery("SELECT * FROM proveedores_compras, factura_compras WHERE proveedores_compras.id_proveedor_compras = factura_compras.id_proveedor_compras and factura_compras.estatus=1 and factura_compras.periodoAnio='{$_GET['anio']}' ORDER BY factura_compras.periodoAnio DESC, factura_compras.periodoMes DESC, factura_compras.fechaFactura ASC;");

			$actualAnio = $_GET['anio'];
			$resumenCompra = $lider->consultarQuery("SELECT * FROM resumen_compras WHERE periodoAnio='{$actualAnio}'");
			foreach ($resumenCompra as $resumenes) {
				if(!empty($resumenes['id_resumen_compra'])){
					$excedenteCreditosFiscalesPendienteAnterior+=$resumenes['creditoFiscal'];
					$debitosFiscalesPendienteAnterior+=$resumenes['debitoFiscal'];
				}
			}
		}
		$query="SELECT *, factura_ventas.estatus as estado_ventas, factura_despacho.estatus as estado_factura FROM factura_ventas, factura_despacho, pedidos, despachos, clientes WHERE factura_ventas.id_factura_despacho = factura_despacho.id_factura_despacho and factura_despacho.id_pedido=pedidos.id_pedido and pedidos.id_despacho=despachos.id_despacho and pedidos.id_cliente=clientes.id_cliente and factura_despacho.fecha_emision BETWEEN '{$inicioFecha}' AND '{$finFecha}'  ORDER BY factura_despacho.fecha_emision, factura_despacho.numero_factura, factura_despacho.numero_control1 ASC;";
		//
		$facturasFiscales = $lider->consultarQuery($query);

	}
	if(isset($_POST['credito']) && isset($_POST['debito'])){
		$periodoAnio=$_POST['anio'];
		$periodoMes=$_POST['mes'];
		$credito=(float) number_format($_POST['credito'],2,'.','');
		$debito=(float) number_format($_POST['debito'],2,'.','');

		$buscar = $lider->consultarQuery("SELECT * FROM resumen_compras WHERE periodoAnio='{$periodoAnio}' and periodoMes='{$periodoMes}'");
		if(count($buscar)>1){
			$idUpdate = $buscar[0]['id_resumen_compra'];
			$query = "UPDATE resumen_compras SET periodoAnio='{$periodoAnio}', periodoMes='{$periodoMes}', creditoFiscal={$credito}, debitoFiscal={$debito}, estatus=1 WHERE id_resumen_compra={$idUpdate}";
			$exec = $lider->modificar($query);
		}else{
			$query = "INSERT INTO resumen_compras (id_resumen_compra, periodoAnio, periodoMes, creditoFiscal, debitoFiscal, estatus) VALUES (DEFAULT, '{$periodoAnio}', '{$periodoMes}', {$credito}, {$debito}, 1)";
			$exec = $lider->registrar($query, "resumen_compras", "id_resumen_compra");
		}
		// echo $query;
		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
		echo $response;
	}
	if(empty($_POST)){
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