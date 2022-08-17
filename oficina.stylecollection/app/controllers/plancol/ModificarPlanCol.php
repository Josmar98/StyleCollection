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
if(!empty($_POST['cantidad_plan'])){
	// print_r($_POST);
	$id_tipo = $_POST['id_tipo_coleccion'];
	$id_pedido = $_POST['id_pedido'];
	$cantidad_plan = $_POST['cantidad_plan'];
	$id_plan_campana = $_POST['id_plan_campana'];

																// foreach ($id_plan_campana as $id_plan) {
																// 	echo $id_tipo[$i];
																// 	echo " | ";
																// 	echo $id_plan;
																// 	echo " | ";
																// 	echo $id_pedido;
																// 	echo " | ";
																// 	echo $cantidad_plan[$i];

																// 	echo "<br>";
																// 	$i++;
																// }
	$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");


	$i=0;
	foreach ($id_plan_campana as $id_plan) {
		$query = "UPDATE tipos_colecciones SET id_plan_campana={$id_plan}, id_pedido={$id_pedido}, cantidad_coleccion_plan={$cantidad_plan[$i]}, estatus=1 WHERE id_tipo_coleccion={$id_tipo[$i]}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$execc = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana WHERE tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and premio_coleccion.id_tipo_coleccion = {$id_tipo[$i]}");
			// echo 'asdasd';
			// print_r($execc);
			if($execc['ejecucion']){
				foreach ($existencias as $existen) {
					if(!empty($existen['id_premio'])){
						foreach ($execc as $execExis) {
							if(!empty($execExis['id_premio'])){
								if($existen['id_premio']==$execExis['id_premio']){
									$cantExis = $execExis['cantidad_premios_plan'];
									$antExis = $existen['cantidad_existencia'];
									$resExist = $cantExis+$antExis;
									$query = "UPDATE existencias SET cantidad_existencia = {$resExist} WHERE id_existencia = {$existen['id_existencia']} and id_premio = {$existen['id_premio']} and id_campana = {$id_campana}";
									// echo $query."<br><br>";
									$execActExis = $lider->modificar($query);
									if($exec2['ejecucion']==true){
										$response = "1";
									}else{
										$response = "2";
									}
								}
							}
						}		
					}
				}
			}
			$exec2 = $lider->eliminar("DELETE FROM premio_coleccion WHERE id_tipo_coleccion = {$id_tipo[$i]}");
			if($exec2['ejecucion']==true){
				$exec3 = $lider->eliminar("UPDATE premios_perdidos SET estatus = 0 WHERE id_pedido = {$id_pedido}");
				$response = "1";
			}else{
				$response = "2";
			}
			$response = "1";
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
		// echo $query."<br><br>";
		$i++;
	}
	if($response=="1"){
            if(!empty($modulo) && !empty($accion)){
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Colecciones', 'Editar', '{$fecha}', '{$hora}')";
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            }
	}
										// $pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");
										// $planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and planes_campana.estatus = 1");
										// 	$pedido = $pedido[0];
	


	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id}");
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
	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana}");
	if(Count($planesCol)>1){
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		$pedido = $pedido[0];

		$aprob = $pedido['cantidad_aprobado'];
		$resto = 0;
		foreach ($planesCol as $plan): if(!empty($plan['id_plan_campana'])):
			$resto += $plan['cantidad_coleccion_plan']*$plan['cantidad_coleccion'];
		endif; endforeach;
		$restoFinal = $aprob-$resto;


		// $planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and planes_campana.estatus = 1");
		// $premios_planes = $lider->consultarQuery("SELECT * FROM premios_planes_campana");
		// $tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, productos WHERE tipos_premios_planes_campana.id_premio = productos.id_producto");
		// $tipo_premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, premios WHERE tipos_premios_planes_campana.id_premio = premios.id_premio");
		// print_r($tipo_premios_planes);
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
		if (is_file('public/views/'.$url.'.php')) {
			require_once 'public/views/'.$url.'.php';
		}else{
		    require_once 'public/views/error404.php';
		}
	}

}

?>