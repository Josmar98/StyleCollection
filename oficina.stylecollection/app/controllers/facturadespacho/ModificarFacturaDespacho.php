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
			$buscar = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido} AND id_factura_despacho={$id} AND estatus = 1");
			if(count($buscar)>1){
				$query = "UPDATE factura_despacho SET id_pedido={$id_pedido}, numero_factura=$numero_factura, tipo_factura='$forma_pago', fecha_emision='$fecha_emision', fecha_vencimiento='$fecha_vencimiento', numero_control1={$control1}, numero_control2={$control2} WHERE id_factura_despacho={$id}";
				// echo $query;
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura De Despacho', 'Modificar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}else{
				$response = "9";
			}

			$query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.estatus = 1 and id_factura_despacho={$id}";
			$facturas = $lider->consultarQuery($query);
			$factura = $facturas[0];
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
			// $query = "SELECT MAX(numero_factura) FROM factura_despacho WHERE estatus = 1";
			// $factNum = $lider->consultarQuery($query);
			// $factNum = $factNum[0][0];
			// if($factNum==""){
			// 	$query = "SELECT * FROM factura_despacho WHERE estatus = 1";
			// 	$facturasss = $lider->consultarQuery($query);
			// 	$numero_factura = Count($facturasss);
			// }else{
			// 	$numero_factura = $factNum+1;	
			// }
			// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
			$pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.cantidad_aprobado > 0 and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
			$query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.estatus = 1 and id_factura_despacho={$id}";
			$facturas = $lider->consultarQuery($query);
			// print_r($facturas);
			if(count($facturas)>1){
				$factura = $facturas[0];
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
			} else {
				require_once 'public/views/error404.php';
			}

		}
	}else{
	   require_once 'public/views/error404.php';
	}
}else{
   require_once 'public/views/error404.php';
}
?>