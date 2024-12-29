<?php 


if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){

		  $id_campana = $_GET['campaing'];
		  $numero_campana = $_GET['n'];
		  $anio_campana = $_GET['y'];
			$id_despacho = $_GET['dpid'];
			$num_despacho = $_GET['dp'];
			$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
			$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
	    $estado_campana = $estado_campana2[0]['estado_campana'];
	    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
			$estado_campana = "1";
		}
	if($estado_campana=="1"){
		if(!empty($_POST['validarData'])){
			$id_liderazgo = $_POST['id_liderazgo'];
			$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "9"; //echo "Registro ya guardado.";
				  // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
			   //    if($res2['ejecucion']==true){
			   //      if(Count($res2)>1){
			   //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
			   //        if($res3['ejecucion']==true){
			   //          $response = "1";
			   //        }
			   //      }else{
			   //        $response = "9"; //echo "Registro ya guardado.";
			   //      }
			   //    }


				}else{
					$response = "1";
				}
			}else{
				$response = "5"; // echo 'Error en la conexion con la bd';
			}
			echo $response;
		}

		if(!empty($_POST['pedido'])){

			$id_pedido = $_POST['pedido'];
			$forma_pago = ucwords(mb_strtolower($_POST['forma']));
			$fecha_emision = $_POST['fecha1'];
			$fecha_vencimiento = $_POST['fecha2'];
			$numero_factura = $_POST['num_factura'];

			$control1 = $_POST['control1'];
			$control2 = $_POST['control2'];

			$proceder = false;
			if(count($_POST['pedidoss'])>0){
				if( count($_POST['pedidoss'])==1 and $_POST['pedidoss']==$_GET['dpid'] ){
					$proceder = false;
				}else if(count($_POST['pedidoss'])>1){
					$proceder = true;
				}
			}
			if($proceder){
				$despachoss = $_POST['pedidoss'];
				$infoPedido = $lider->consultarQuery("SELECT id_cliente FROM pedidos WHERE id_pedido={$id_pedido} ");
				$id_cliente = 0;
				foreach ($infoPedido as $key) {
					if(!empty($key['id_cliente'])){
						$id_cliente = $key['id_cliente'];
					}
				}
				$pedidosVariados = [];
				foreach ($despachoss as $keys) {
					$buscarPedidos = $lider->consultarQuery("SELECT id_pedido FROM pedidos WHERE pedidos.estatus=1 and pedidos.id_cliente = {$id_cliente} and pedidos.id_despacho={$keys}");
					if(count($buscarPedidos)>1){
						$pedidosVariados[count($pedidosVariados)] = $buscarPedidos[0]['id_pedido'];
					}
				}
				// echo "Cliente = ".$id_cliente."<br>";
				// print_r($pedidosVariados);
			}
			// $query = "SELECT MAX(numero_factura) FROM factura_despacho";
			// $factNum = $lider->consultarQuery($query);
			// $factNum = $factNum[0][0];
			// if($factNum==""){
			// 	$query = "SELECT * FROM factura_despacho";
			// 	$facturasss = $lider->consultarQuery($query);
			// 	$numero_factura = Count($facturasss);
			// }else{
			// 	$numero_factura = $factNum+1;	
			// }
			// echo $numero_factura;
			
			// die();
			$buscar = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido} AND estatus = 1");
			if(count($buscar)>1){
				$response = "9";
			}else{
				$fechaHoraActual = date('Y-m-d H:i:s');
				$query = "INSERT INTO factura_despacho (id_factura_despacho, id_pedido, numero_factura, tipo_factura, fecha_emision, fecha_vencimiento, numero_control1, numero_control2, fecha_creacion, estatus) VALUES (DEFAULT, $id_pedido, $numero_factura, '$forma_pago', '$fecha_emision', '$fecha_vencimiento', {$control1}, {$control2}, '{$fechaHoraActual}', 1)";
				// echo $query;
				$exec = $lider->registrar($query, "factura_despacho", "id_factura_despacho");
				if($exec['ejecucion']==true){
					$response = "1";
					$pedido = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_pedido = {$id_pedido}");
					if(count($pedido)>1){
						$pedid=$pedido[0];
						$id_factura_despacho = $exec['id'];
						$precioTotalDeuda = 0;
						if($proceder){
							foreach ($pedidosVariados as $pedidoVariado) {
								foreach( $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_pedido = $pedidoVariado") as $key){
									if(!empty($key['id_pedido'])){
										$precioDeuda = (float) number_format($key['cantidad_aprobado'] * $key['precio_coleccion'],2,'.','');
										$precioTotalDeuda += $precioDeuda;
									}
								}
							}
						}
						if($precioTotalDeuda==0){
							$totalVenta = (float) number_format(($pedid['cantidad_aprobado']*$pedid['precio_coleccion']),2,'.','');
						}else{
							$totalVenta=$precioTotalDeuda;
						}
						$querys = "INSERT INTO factura_ventas (id_factura_ventas, id_factura_despacho, totalVenta, estatus) VALUES (DEFAULT, {$id_factura_despacho}, {$totalVenta}, 1)";
						$exec = $lider->registrar($querys, "factura_ventas", "id_factura_ventas");
						// print_r($exec);
						// echo "asdasd";

						if($proceder){
							foreach ($pedidosVariados as $pedidoVariado) {
								$query = "INSERT INTO factura_despacho_variadas (id_factura_despacho_variada, id_factura_despacho, id_pedido_factura, estatus) VALUES (DEFAULT, {$id_factura_despacho}, {$pedidoVariado}, 1);";
								$exec = $lider->registrar($query, "factura_despacho_variadas", "id_factura_despacho_variada");
								if($exec['ejecucion']==true){
									
								}
							}
						}
						
					}



					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura De Despacho', 'Registrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}

			// die();

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
			$query = "SELECT MAX(numero_factura) FROM factura_despacho WHERE estatus = 1";
			$factNum = $lider->consultarQuery($query);
			$factNum = $factNum[0][0];
			if($factNum==""){
				$query = "SELECT * FROM factura_despacho WHERE estatus = 1";
				$facturasss = $lider->consultarQuery($query);
				$numero_factura = Count($facturasss);
			}else{
				$numero_factura = $factNum+1;	
			}

			$querys2 = "SELECT MAX(numero_control2) FROM factura_despacho WHERE estatus = 1";
			$factControl = $lider->consultarQuery($querys2);
			$factControl = $factControl[0][0];
			if($factControl==""){
				$query = "SELECT * FROM factura_despacho WHERE estatus = 1";
				$facturasss = $lider->consultarQuery($query);
				$numero_control2 = Count($facturasss);
			}else{
				$numero_control2 = $factControl+1;	
			}
			// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
			$pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.cantidad_aprobado > 0 and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
			$query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.estatus = 1";
			$facturas = $lider->consultarQuery($query);
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
}else{
   require_once 'public/views/error404.php';
}
?>