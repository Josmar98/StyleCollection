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

			$numero_nota = $_POST['num_nota'];
			$id_pedido = $_POST['pedido'];
			
			$cantidad_coleccion = $_POST['cantidad'];

			$precio_dolar = $_POST['preciodolar'];
			// $precio_bs = $_POST['preciobs'];
			$precio_bs_fiscal = $_POST['preciobsfiscal'];
			
			$forma_pago = ucwords(mb_strtolower($_POST['forma']));
			$fecha_emision = $_POST['fecha1'];
			$fecha_vencimiento = $_POST['fecha2'];



			// $query = "SELECT MAX(numero_nota) FROM factura_despacho";
			// $factNum = $lider->consultarQuery($query);
			// $factNum = $factNum[0][0];
			// if($factNum==""){
			// 	$query = "SELECT * FROM factura_despacho";
			// 	$facturasss = $lider->consultarQuery($query);
			// 	$numero_nota = Count($facturasss);
			// }else{
			// 	$numero_nota = $factNum+1;	
			// }
			// echo $numero_nota;




			

			$buscar = $lider->consultarQuery("SELECT * FROM nota_despacho WHERE id_pedido = {$id_pedido}");
			if(count($buscar)>1){
				$response = "9";
			}else{

				// $query = "INSERT INTO nota_despacho (id_nota_despacho, id_pedido, numero_nota, cantidad_colecciones, precioDolar, precioBs, precioBsfiscal, tipo_nota, fecha_emision, fecha_vencimiento, estatus) VALUES (DEFAULT, $id_pedido, $numero_nota, $cantidad_coleccion, '$precio_dolar', '$precio_bs', '$precio_bs_fiscal', '$forma_pago', '$fecha_emision', '$fecha_vencimiento', 1)";
				$query = "INSERT INTO nota_despacho (id_nota_despacho, id_pedido, numero_nota, cantidad_colecciones, precioDolar, precioBsfiscal, tipo_nota, fecha_emision, fecha_vencimiento, estatus) VALUES (DEFAULT, $id_pedido, $numero_nota, $cantidad_coleccion, '$precio_dolar', '$precio_bs_fiscal', '$forma_pago', '$fecha_emision', '$fecha_vencimiento', 1)";
				// echo $query;
				$exec = $lider->registrar($query, "nota_despacho", "id_nota_despacho");
				if($exec['ejecucion']==true){
					$response = "1";

					if(!empty($modulo) && !empty($accion)){
		              $fecha = date('Y-m-d');
		              $hora = date('H:i:a');
		              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Nota De Despacho', 'Registrar', '{$fecha}', '{$hora}')";
		              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		            }
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}

			}


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
			$query = "SELECT MAX(numero_nota) FROM nota_despacho";
			$notaNum = $lider->consultarQuery($query);
			$notaNum = $notaNum[0][0];
			if($notaNum==""){
				$query = "SELECT * FROM nota_despacho";
				$notasss = $lider->consultarQuery($query);
				$numero_nota = Count($notasss);
			}else{
				$numero_nota = $notaNum+1;	
			}
			$pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.cantidad_aprobado > 0 and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
			$query = "SELECT * FROM pedidos, nota_despacho WHERE pedidos.id_pedido = nota_despacho.id_pedido and pedidos.id_despacho = $id_despacho";
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