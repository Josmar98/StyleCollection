<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	// $id_campana = $_GET['campaing'];
	// $numero_campana = $_GET['n'];
	// $anio_campana = $_GET['y'];
	// $id_despacho = $_GET['dpid'];
	// $num_despacho = $_GET['dp'];
	// $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	// print_r($_POST);
	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['observacion'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$estado = $_POST['estado'];
	// 	$firma = $_POST['firma'];
	// 	$observacion = $_POST['observacion'];
	// 	$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', observacion='{$observacion}', estado='{$estado}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}

	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}
		

	// }


	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['estado']) && !empty($_POST['firma']) &&  !empty($_POST['leyenda'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$estado = $_POST['estado'];
	// 	$firma = $_POST['firma'];
	// 	$leyenda = $_POST['leyenda'];
	// 	$exec = $lider->modificar("UPDATE pagos SET firma='{$firma}', leyenda='{$leyenda}', estado='{$estado}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}

	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}


	// }

	// if(!empty($_POST['id_pago_modal']) && !empty($_POST['tipo_pago']) && !empty($_POST['tasa'])){
	// 	$id_pago = $_POST['id_pago_modal'];
	// 	$tasa = $_POST['tasa'];
	// 	$pago = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago = $id_pago");
	// 	$pago=$pago[0];
	// 	$equivalente_pago = "";
	// 	if($tasa!=""){
	// 		$equivalente_pago = $pago['monto_pago']/$tasa;
	// 		$equivalente_pago = number_format($equivalente_pago,2);
	// 	}
	// 	$tipo_pago = $_POST['tipo_pago'];
	// 	$exec = $lider->modificar("UPDATE pagos SET tasa_pago='{$tasa}', tipo_pago='{$tipo_pago}', equivalente_pago='{$equivalente_pago}' WHERE id_pago=$id_pago");
	// 	if($exec['ejecucion']==true){
	// 		$response = "1";
	// 	}else{
	// 		$response = "2";
	// 	}



	// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
	// 	if(!empty($_GET['admin'])&&!empty($_GET['lider'])){
	// 		$id_cliente = $_GET['lider'];
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
	// 	}else{
	// 		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 ORDER BY fecha_pago asc");
	// 		$id_cliente = $_SESSION['id_cliente'];
	// 	}

	// 	$planes = $lider->consultarQuery("SELECT * FROm planes, planes_campana, tipos_colecciones, pedidos, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho = despachos.id_despacho and despachos.estatus = 1 and planes.estatus = 1 and pedidos.estatus = 1");
	// 	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	// 	$reportado = 0;
	// 	$diferido = 0;
	// 	$abonado = 0;
	// 	if(count($pagos)){
 //          foreach ($pagos as $data) {
 //            if(!empty($data['id_pago'])){
 //              $reportado += $data['equivalente_pago'];
 //              if($data['estado']=="Diferido"){
 //                $diferido += $data['equivalente_pago'];
 //              }
 //              if($data['estado']=="Abonado"){
 //                $abonado += $data['equivalente_pago'];
 //              }
 //            }
 //          }
	// 	}
	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 		    require_once 'public/views/error404.php';
	// 		}
	// 	}
	// }

	// if(!empty($_POST['ajax']) && !empty($_POST['id_pago'])){
	// 	$id = $_POST['id_pago'];
	// 	$pedido = $lider->consultarQuery("SELECT * FROm pagos,pedidos,clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and pagos.id_pedido = pedidos.id_pedido and pagos.id_pago = $id");
	// 	echo json_encode($pedido);	
	// 	// $pago = $lider->consultarQuery("SELECT * FROM pagos WHERE ")

	// }

	if(empty($_POST)){

		$campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 ORDER BY campanas.id_campana DESC");
		
		if($campanas['ejecucion']==1){
		
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
		}else{
			require_once 'public/views/error404.php';
		}
	}
}else{
	require_once 'public/views/error404.php';
}


?>