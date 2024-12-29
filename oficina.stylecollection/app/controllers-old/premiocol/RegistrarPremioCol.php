<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

$opcionesSecondTxt = "Segunda opción";


$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
$id_despacho = $_GET['dpid'];
$num_despacho = $_GET['dp'];
$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and campanas.estatus = 1");
$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");

$despacho = $despachos[0];
$cantidadPagosDespachosFild = [];
for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
	$key = $cantidadPagosDespachos[$i];
	if($key['cantidad'] <= $despacho['cantidad_pagos']){
		$cantidadPagosDespachosFild[$i] = $key;
	}
}

if(!empty($_POST['validarData'])){
	$id_liderazgo = $_POST['id_liderazgo'];
	$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
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

if(!empty($_POST['premios']) && !empty($_POST['id_tppc']) && !empty($_POST['id_tipo_coleccion'])){
	// print_r($_POST);

	// echo "<br><br>";
	// foreach ($_POST as $key => $value) {
	// 	echo $key."<br>";
	// 	print_r($value);
	// 	echo "<br><br>";
	// }

	$id_tipo = $_POST['id_tipo_coleccion'];
	$id_tppc = $_POST['id_tppc'];
	$cantidad = $_POST['cantidad_premios_plan'];

	if(isset($_POST['id_existencia'])){
		$id_existencia = $_POST['id_existencia'];
	}
	if(isset($_POST['existenciaAct'])){
		$existenciaAct = $_POST['existenciaAct'];
	}
	if(isset($_POST['existenciaNew'])){
		$existenciaNew = $_POST['existenciaNew'];
	}

	$id_tipo_opcion = $_POST['id_tipo_coleccion1'];
	$id_tppc_opcion = $_POST['id_tppc1'];
	$cantidad_opcion = $_POST['cantidad_premios_plan1'];
	// echo "<br><br>id_tipo: ";
	// print_r($id_tipo);
	// echo "<br><br>id_tipo_opcion: ";
	// print_r($id_tipo_opcion);
	// echo "<br><br>id_tppc: ";
	// print_r($id_tppc);
	// echo "<br><br>id_tppc_opcion" ;
	// print_r($id_tppc_opcion);
	// echo "<br><br>cantidad: ";
	// print_r($cantidad);
	// echo "<br><br>cantidad_opcion: ";
	// print_r($cantidad_opcion);
	// echo "<br><br>";

	// die();
	
	$h=0;
	$valid = [];
	if(!empty($id_existencia)){
		foreach ($id_existencia as $idid) {
			$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = $idid");
			foreach ($existencias as $exx) {
				if(!empty($exx['id_existencia'])){
					if($exx['id_existencia']==$id_existencia[$h]){
						if($exx['cantidad_existencia'] >= $existenciaNew[$h]){
							if($exx['cantidad_existencia'] == $existenciaAct[$h]){
								$valid[$h]=0;
							}else{
								$caaant = $existenciaAct[$h]-$existenciaNew[$h];
								$resultt = $exx['cantidad_existencia']-$caaant;
								if($resultt>=0){
									$valid[$h]=0;
								}else{
									$valid[$h]=1;
								}
							}
						}else{
							$valid[$h]=1;
						}
					}
					$h++;
				}
			}
		}
	}

	$acumExis = 0;
	foreach ($valid as $valval) {
		$acumExis += $valval;
	}
	// echo "<b> ".$acumExis."</b><br><br>";
	if($acumExis<1){
		$i=0;
		foreach ($id_tppc as $id_t) {
			$buscar = $lider->consultarQuery("SELECT * FROM premio_coleccion WHERE id_tipo_coleccion = {$id_tipo[$i]} and id_tppc = {$id_t} and cantidad_premios_plan = {$cantidad[$i]}");
			if($buscar['ejecucion'] == 1 && Count($buscar)>1){
				$response = "1";
			}else{
				$query = "INSERT INTO premio_coleccion (id_premio_coleccion, id_tipo_coleccion, id_tppc, cantidad_premios_plan, estatus) VALUES (DEFAULT, {$id_tipo[$i]}, {$id_t}, {$cantidad[$i]}, 1)";

				$exec = $lider->registrar($query, "premio_coleccion", "id_premio_coleccion");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}
			$i++;
		}
		if($response=="1"){
			if(!empty($id_existencia)){
				$g=0;
				foreach ($id_existencia as $id_exis) {
					$query3 = "SELECT * FROM existencias WHERE id_existencia = {$id_exis} and id_campana = {$id_campana}";
					$execc2 = $lider->consultarQuery($query3);
					// print_r($execc2);
					foreach ($execc2 as $keyy2) {
						if(!empty($keyy2['id_existencia'])){
							$id_premio = $keyy2['id_premio'];
							$exissReal = $keyy2['cantidad_existencia_real'];
						}
					}

					$query2 = "SELECT cantidad_premios_plan FROM planes_campana, tipos_colecciones, premio_coleccion, tipos_premios_planes_campana WHERE planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = {$id_premio} and planes_campana.id_campana = {$id_campana}";
					$execc = $lider->consultarQuery($query2);
					$cant = 0;

					foreach ($execc as $key2) {
						if(!empty($key2['cantidad_premios_plan'])){
							$cant += $key2['cantidad_premios_plan'];
						}
					}
					$realExistencia = $execc2[0]['cantidad_existencia_real'];
					$nuevaExistenciaReal = $realExistencia-$cant;
					$query = "UPDATE existencias SET cantidad_existencia = {$nuevaExistenciaReal}, estatus = 1 WHERE id_existencia = {$id_exis} and id_campana = {$id_campana}";

					$exec = $lider->modificar($query);
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
					}
					$g++;
				}
			}
		}
	}else{
		$response="77";
	}

	// ======================== Registro de segunda opcion ======================== ========================
	$x = 0;
	foreach ($id_tppc_opcion as $id_t1) {
		$buscar = $lider->consultarQuery("SELECT * FROM premio_coleccion_opcion WHERE id_tipo_coleccion = {$id_tipo_opcion[$x]} and id_tppc = {$id_t1}");
		// $buscar = $lider->consultarQuery("SELECT * FROM premio_coleccion_opcion WHERE id_tipo_coleccion = {$id_tipo_opcion[$x]} and id_tppc = {$id_t1} and cantidad_premios_plan = {$cantidad_opcion[$x]}");
		if($buscar['ejecucion'] == 1 && Count($buscar)>1){
			$response = "1";
		}else{
			$query = "INSERT INTO premio_coleccion_opcion (id_premio_coleccion_opcion, id_tipo_coleccion, id_tppc, cantidad_premios_plan, estatus) VALUES (DEFAULT, {$id_tipo[$x]}, {$id_t1}, {$cantidad_opcion[$x]}, 1)";

			$exec = $lider->registrar($query, "premio_coleccion_opcion", "id_premio_coleccion_opcion");
			if($exec['ejecucion']==true){
				$response_opcion = "1";
			}else{
				$response_opcion = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}
		}
		$x++;
	}
	// ======================== Registro de segunda opcion ======================== ========================


	if($response=="1"){
		if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios De Colecciones', 'Registrar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
	}

	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"|| $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");

	$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
	$pedido = $pedido[0];
	$sqlQuery = "SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}";

	$premios_planes = $lider->consultarQuery($sqlQuery);
	$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");
	//  and premios_planes_campana.tipo_premio = 'Primer Pago'

	$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");

	$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
	if(!empty($action)){
		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
		}else{
		    require_once 'public/views/error404.php';
		}
	}else{
		    require_once 'public/views/error404.php';
	}	


}


if(empty($_POST)){

	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"|| $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");

	if(Count($planesCol)>1){
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		$pedido = $pedido[0];
		$sqlQuery = "SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}";
		// foreach ($pagos_despacho as $keys) {
		// 	if(!empty($keys['id_despacho'])){
		// 		if($keys['asignacion_pago_despacho']=="seleccion_premios"){
		// 			// echo " *".$keys['tipo_pago_despacho']."* ";
		// 			$tipo_pago_despacho = $keys['tipo_pago_despacho'];
		// 			$sqlQuery .= "and premios_planes_campana.tipo_premio = '{$tipo_pago_despacho}'";
		// 		}
		// 	}
		// }
		$premios_planes = $lider->consultarQuery($sqlQuery);
		$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");
		//  and premios_planes_campana.tipo_premio = 'Primer Pago'

		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");

		$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
		 
		// foreach ($pagos_despacho as $pDesp){ if(!empty($pDesp['id_despacho'])){ if($pDesp['asignacion_pago_despacho']=="seleccion_premios"){
		// 	$tipo_pago_despacho = $pDesp['tipo_pago_despacho'];
		// 	echo $tipo_pago_despacho;
		// 	echo "<br>=======================================<br>";
		// 	foreach ($planesCol as $plan){ if(!empty($plan['id_tipo_coleccion'])){
		// 		echo "PLAN: ".$plan['id_plan']." | ".$plan['nombre_plan']." | ";
		// 		echo "EN CAMP: ".$plan['id_plan_campana']." | <br>";
		// 		foreach ($premios_planes as $premios){ if(!empty($premios['id_plan_campana'])){ if($plan['id_plan_campana']==$premios['id_plan_campana']){ if($premios['tipo_premio']==$tipo_pago_despacho){
		// 			echo "ID PPC: ".$premios['id_ppc']." | ";
		// 			echo "TIPO: ".$premios['tipo_premio']." | <br>";
		// 			foreach ($tipo_premios_planes as $premiosPlan){ if(!empty($premiosPlan['id_plan_campana'])){ if( ($plan['id_plan_campana'] == $premiosPlan['id_plan_campana']) && ($premios['id_plan_campana'] == $premiosPlan['id_plan_campana']) ){ 
		// 				if($premiosPlan['id_ppc'] == $premios['id_ppc']){
		// 				echo " +++ PREMIO: ".$premiosPlan['id_premio']." | ".$premiosPlan['nombre_premio']." | <br>";
		// 				} 
		// 			} } }
		// 		} } } }
		// 		echo "<br>";
		// 	}}
		// 	echo "<br>=======================================<br>";
		// } } }

			
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

// id_premio, nombre_premio, precio_premio, descripcion_premio, id_ppc, id_plan_campana, tipo_premio, tipo_premio_producto 
// premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto 
?>