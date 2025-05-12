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
	$id_cliente = $_SESSION['id_cliente'];

// if(!empty($_POST['validarData'])){
// 	$id_liderazgo = $_POST['id_liderazgo'];
// 	$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1";
// 	$res1 = $lider->consultarQuery($query);
// 	if($res1['ejecucion']==true){
// 		if(Count($res1)>1){
// 			$response = "9"; //echo "Registro ya guardado.";
// 		  // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
// 	   //    if($res2['ejecucion']==true){
// 	   //      if(Count($res2)>1){
// 	   //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
// 	   //        if($res3['ejecucion']==true){
// 	   //          $response = "1";
// 	   //        }
// 	   //      }else{
// 	   //        $response = "9"; //echo "Registro ya guardado.";
// 	   //      }
// 	   //    }


// 		}else{
// 			$response = "1";
// 		}
// 	}else{
// 		$response = "5"; // echo 'Error en la conexion con la bd';
// 	}
// 	echo $response;
// }
// if(!empty($_POST['cantidad_plan'])){

// 	$id_pedido = $_POST['id_pedido'];
// 	$cantidad_plan = $_POST['cantidad_plan'];
// 	$id_plan_campana = $_POST['id_plan_campana'];

// 	// echo "/";
// 	// echo $id_pedido;
// 	// echo "<br>";
// 	// print_r($cantidad_plan);
// 	// echo "<br>";
// 	// print_r($id_plan_campana);

// 	// $forma_pago = ucwords(mb_strtolower($_POST['forma']));
// 	// $fecha_emision = $_POST['fecha1'];
// 	// $fecha_vencimiento = $_POST['fecha2'];
// 	// $query = "SELECT * FROM pedidos, factura_despacho WHERE pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho";
// 	// $pedidos = $lider->consultarQuery($query);
// 	// $numero_factura = Count($pedidos);
// 	$i=0;
// 	foreach ($id_plan_campana as $id_plan) {
// 		$buscar = $lider->consultarQuery("SELECT * FROM tipos_colecciones WHERE id_plan_campana = $id_plan and id_pedido = {$id_pedido} and cantidad_coleccion_plan = {$cantidad_plan[$i]}");

// 		if($buscar['ejecucion'] == 1 && Count($buscar)>1){
// 			$response = "1";
// 		}else{
// 			$query = "INSERT INTO tipos_colecciones (id_tipo_coleccion, id_plan_campana, id_pedido, cantidad_coleccion_plan, estatus) VALUES (DEFAULT, $id_plan, {$id_pedido}, {$cantidad_plan[$i]}, 1)";
// 			$exec = $lider->registrar($query, "tipos_colecciones", "id_tipo_coleccion");
// 			if($exec['ejecucion']==true){
// 				$response = "1";


// 					if(!empty($modulo) && !empty($accion)){
// 						$fecha = date('Y-m-d');
// 						$hora = date('H:i:a');
// 						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Colecciones', 'Registrar', '{$fecha}', '{$hora}')";
// 						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
// 					}
// 			}else{
// 				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
// 			}
// 		}
// 		$i++;
// 	}

// 	$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");
// 	$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and planes_campana.estatus = 1");
// 		$pedido = $pedido[0];
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


// 	// print_r($exec);
// }


if(empty($_POST)){

	// $pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");
	if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}

	$lideres = $lider->consultarQuery("SELECT DISTINCT clientes.id_cliente, primer_nombre, primer_apellido, cedula, pedidos.id_pedido FROM clientes, retos, pedidos WHERE pedidos.id_pedido = retos.id_pedido and clientes.id_cliente = retos.id_cliente and retos.id_campana = {$id_campana}");

	$retoss = $lider->consultarQuery("SELECT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = {$id_campana} and retos_campana.estatus = 1 ORDER BY retos_campana.cantidad_coleccion ASC");
	$totalRetos = [];
	$numIndex = 0;
	foreach ($retoss as $key) {
		if($key['id_reto_campana']){
			$totalRetos[$numIndex] = ['id'=>$key['id_reto_campana'], 'nombre'=>$key['nombre_premio'], 'cantidad'=>0];
			$numIndex++;
		}
	}

	$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = {$id_campana} and retos_campana.estatus = 1 ORDER BY retos_campana.cantidad_coleccion ASC");

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
	// }else{
	// 	    require_once 'public/views/error404.php';
	// }

}

?>