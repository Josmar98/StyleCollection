<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();


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
	if(!empty($_POST['cantidad_plan']) && !empty($_POST['id_pedido'])){
		// print_r($_POST);

		$id_pedido = $_POST['id_pedido'];
		$id_cliente = $_POST['id_cliente'];
		$cantidad_plan = $_POST['cantidad_plan'];
		$id_reto_campana = $_POST['id_reto_campana'];
		$max = count($id_reto_campana);

		// echo "/";
		// echo $id_pedido;
		// echo "<br>";
		// print_r($cantidad_plan);
		// echo "<br>";
		// print_r($id_plan_campana);

		// $forma_pago = ucwords(mb_strtolower($_POST['forma']));
		// $fecha_emision = $_POST['fecha1'];
		// $fecha_vencimiento = $_POST['fecha2'];
		// $query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho";
		// $pedidos = $lider->consultarQuery($query);
		// $numero_factura = Count($pedidos);

		$i=0;
		$responses = [];
		foreach ($id_reto_campana as $id_reto_campana) {
			$buscar = $lider->consultarQuery("SELECT * FROM retos WHERE id_reto_campana = $id_reto_campana and id_pedido = {$id_pedido} and id_cliente = {$id_cliente} and cantidad_coleccion = {$cantidad_plan[$i]}");
			if($buscar['ejecucion'] == 1 && Count($buscar)>1){
				$responses[$i] = "1";
			}else{
				$query = "INSERT INTO retos (id_reto, id_reto_campana, id_pedido, id_cliente, id_campana, cantidad_retos, estatus) VALUES (DEFAULT, $id_reto_campana, {$id_pedido}, {$id_cliente}, {$id_campana}, {$cantidad_plan[$i]}, 1)";
				$exec = $lider->registrar($query, "retos", "id_reto");
				if($exec['ejecucion']==true){
					$responses[$i] = "1";
				}else{
					$responses[$i] = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}
			$i++;
		}
		$sum = 0;
		foreach ($responses as $key) {
			$sum += $key;
		}
		if($sum==$max){
			$response = "1";
		}else{
			$response = "2";
		}

		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista Supervisor")){
			$id = $_GET['lider'];
		}else{
			$id = $_SESSION['id_cliente'];
		}
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		if(Count($pedido)>1){
			$retos = $lider->consultarQuery("SELECT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} ORDER BY retos_campana.cantidad_coleccion ASC");
			// print_r($retos);
			$pedido = $pedido[0];
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

		// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor")){
			$id = $_GET['lider'];
		}else{
			$id = $_SESSION['id_cliente'];
		}
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		if(Count($pedido)>1){
			$retos = $lider->consultarQuery("SELECT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} ORDER BY retos_campana.cantidad_coleccion ASC");
			$pedido = $pedido[0];
		}
		$liderRetos = $lider->consultarQuery("SELECT * FROM clientes, retos, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and retos.id_cliente = clientes.id_cliente and retos.id_pedido = pedidos.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1");
		

			// $premios_planes = $lider->consultarQuery("SELECT * FROM premios_planes_campana");
			// $tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, productos WHERE tipos_premios_planes_campana.id_premio = productos.id_producto");
			// $tipo_premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, premios WHERE tipos_premios_planes_campana.id_premio = premios.id_premio");
			// print_r($tipo_premios_planes);
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
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