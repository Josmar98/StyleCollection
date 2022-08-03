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

if(empty($_POST)){
	if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
		$id = $_GET['lider'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
		$pedido = $pedidos[0];
		$id_pedido = $pedido['id_pedido'];
		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
	}else{
		$id = $_SESSION['id_cliente'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1");
	}

	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");


		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
	
		$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
		$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");


		$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

		$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT	* FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		
		$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");

		// foreach ($pedidos as $data){ 
		// 	if(!empty($data['id_pedido'])){
		// 		echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']. " <br> " . $data['cantidad_aprobado']." Colecciones Aprobadas<br><br>" ;
		// 					foreach ($premios_perdidos as $dataperdidos) {
		// 						if(!empty($dataperdidos['id_premio_perdido'])){
		// 							if(($dataperdidos['valor'] == "Inicial") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
		// 								$nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
							
		// 					echo $data['cantidad_aprobado']."  Premios de Inicial";

		// 								echo " (-) ".$dataperdidos['cantidad_premios_perdidos']." Premios de ".$dataperdidos['valor'];
		// 								echo " (=) ".$nuevoResult." Premios de ".$dataperdidos['valor'];
		// 								echo "<br>";
		// 							}
		// 						}
		// 					}

		// 		foreach ($planesCol as $data2) {
		// 			if($data['id_pedido'] == $data2['id_pedido']){
		// 				if($data2['cantidad_coleccion_plan']>0){
		// 					$colecciones = $data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan'];
							
		// 					foreach ($premios_perdidos as $dataperdidos) {
		// 						if(!empty($dataperdidos['id_premio_perdido'])){
		// 							if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
		// 								$nuevoResult = $colecciones - $dataperdidos['cantidad_premios_perdidos'];
							
		// 					echo $colecciones." Colecciones de Plan ".$data2['nombre_plan'];

		// 								echo " (-) ".$dataperdidos['cantidad_premios_perdidos']." Colecciones de Plan ".$dataperdidos['valor'];
		// 								echo " (=) ".$nuevoResult." Colecciones de Plan ".$dataperdidos['valor'];
		// 								echo "<br>";
		// 							}
		// 						}
		// 					}

		// 					// echo "<br>";
		// 					foreach ($premioscol as $data3) {
		// 						if(!empty($data3['id_premio'])){
		// 							if($data2['id_plan']==$data3['id_plan']){
		// 								if($data['id_pedido']==$data3['id_pedido']){
		// 									if($data3['cantidad_premios_plan']>0){
		// 										foreach ($premios_perdidos as $dataperdidos) {
		// 											if(!empty($dataperdidos['id_premio_perdido'])){
		// 												if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
		// 													$nuevoResult = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
		// 										echo " -> ".$data3['cantidad_premios_plan']." ".$data3['nombre_premio'];
		// 													echo " (-) ".$dataperdidos['cantidad_premios_perdidos']." ".$data3['nombre_premio'];
		// 													echo " (=) ".$nuevoResult." ".$data3['nombre_premio'];
		// 													echo "<br>";
		// 												}
		// 											}
		// 										}
		// 										// echo "<br>";
		// 									}
		// 								}
		// 							}
		// 						}
		// 					}
		// 				}
		// 			}
		// 		}
		// 					foreach ($premios_perdidos as $dataperdidos) {
		// 						if(!empty($dataperdidos['id_premio_perdido'])){
		// 							if(($dataperdidos['valor'] == "Segundo") && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
		// 								$nuevoResult = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
							
		// 					echo $data['cantidad_aprobado']."  Premios de ".$dataperdidos['valor'];

		// 								echo " (-) ".$dataperdidos['cantidad_premios_perdidos']." Premios de ".$dataperdidos['valor'];
		// 								echo " (=) ".$nuevoResult." Premios de ".$dataperdidos['valor'];
		// 								echo "<br>";
		// 							}
		// 						}
		// 					}

		// 					echo "<br><br><br>";
		// 	}
		// }

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
		    // require_once 'public/views/error404.php';
	// }

}

// id_premio, nombre_premio, precio_premio, descripcion_premio, id_ppc, id_plan_campana, tipo_premio, tipo_premio_producto 
// premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto 
?>