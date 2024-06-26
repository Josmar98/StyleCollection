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
	// echo "<br><br>";
	// foreach ($_POST as $key => $value) {
	// 	echo $key."<br>";
	// 	print_r($value);
	// 	echo "<br><br>";
	// }


	$id_premio_col = $_POST['id_premio_coleccion'];
	$id_tipo = $_POST['id_tipo_coleccion'];
	$id_tppc = $_POST['id_tppc'];
	$cantidad = $_POST['cantidad_premios_plan'];
	$id_pedido = $_POST['id_pedido'];
	
	if(isset($_POST['id_existencia'])){
		$id_existencia = $_POST['id_existencia'];
	}
	if(isset($_POST['existenciaAct'])){
		$existenciaAct = $_POST['existenciaAct'];
	}
	if(isset($_POST['existenciaNew'])){
		$existenciaNew = $_POST['existenciaNew'];
	}
	if(isset($_POST['existenciaAnt'])){
		$existenciaAnt = $_POST['existenciaAnt'];
	}

	$id_premio_col_opcion = $_POST['id_premio_coleccion1'];
	$id_tipo_opcion = $_POST['id_tipo_coleccion1'];
	$id_tppc_opcion = $_POST['id_tppc1'];
	$cantidad_opcion = $_POST['cantidad_premios_plan1'];
	
	// echo "id_premio_col_opcion: ";
	// print_r($id_premio_col_opcion);
	// echo "<br>";

	// echo "id_tipo_opcion: ";
	// print_r($id_tipo_opcion);
	// echo "<br>";

	// echo "id_tppc_opcion: ";
	// print_r($id_tppc_opcion);
	// echo "<br>";

	// echo "cantidad_opcion: ";
	// print_r($cantidad_opcion);
	// echo "<br>";

	// die();


	$h=0;
	$valid = [];
	if(!empty($id_existencia)){
		foreach ($id_existencia as $idid) {
			$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = $idid");
			foreach ($existencias as $exx) {
				if(!empty($exx['id_existencia'])){
					if($exx['id_existencia']==$id_existencia[$h]){
						if($exx['cantidad_existencia'] <= $existenciaAct[$h]){
							if($existenciaNew[$h] >= $existenciaAnt[$h]){
								$valid[$h]=0;
							}else{	
								if($exx['cantidad_existencia']==$existenciaAnt[$h]){
									$valid[$h]=0;
								}else{
									$caaant = $existenciaAnt[$h]-$existenciaNew[$h];
									$resultt = $exx['cantidad_existencia']-$caaant;
									if($resultt >= 0){								
										$valid[$h]=0;
									}else{
										$valid[$h]=1;								
									}
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

	if($acumExis<1){
		$i=0;
		foreach ($id_tppc as $id_t) {
			$query = "UPDATE premio_coleccion SET id_tipo_coleccion={$id_tipo[$i]}, id_tppc={$id_t}, cantidad_premios_plan={$cantidad[$i]}, estatus=1 WHERE id_premio_coleccion = {$id_premio_col[$i]}";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}
				// echo $query."<br><br>";
			$i++;
		}
		if($response=="1"){
			if(!empty($id_existencia)){
				$g=0;
				foreach ($id_existencia as $id_exis) {
					$query3 = "SELECT * FROM existencias WHERE id_existencia = {$id_exis} and id_campana = {$id_campana}";
					$execc2 = $lider->consultarQuery($query3);
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
			$exec3 = $lider->eliminar("UPDATE premios_perdidos SET estatus = 0 WHERE id_pedido = {$id_pedido}");
		}

	}else{
		$response="77";
	}

	$x=0;
	foreach ($id_tppc_opcion as $id_t1) {
		$query = "UPDATE premio_coleccion_opcion SET id_tipo_coleccion={$id_tipo_opcion[$x]}, id_tppc={$id_t1}, cantidad_premios_plan={$cantidad_opcion[$x]}, estatus=1 WHERE id_premio_coleccion_opcion = {$id_premio_col_opcion[$x]}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
			// echo $query."<br><br>";
		$x++;
	}				

	if($response=="1"){
		if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios de Colecciones', 'Editar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
	}
	
		if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"|| $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
			$id = $_GET['id'];
		}else{
			$id = $_SESSION['id_cliente'];
		}
		// $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$_SESSION['id_cliente']} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
		$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
		$premioscol_opcion = $lider->consultarQuery("SELECT * FROM premio_coleccion_opcion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion_opcion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion_opcion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");

		$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		$pedido = $pedido[0];
		$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_campana = {$id_campana}");
		
		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
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
	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"|| $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}

	$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
	$premioscol_opcion = $lider->consultarQuery("SELECT * FROM premio_coleccion_opcion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion_opcion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion_opcion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
	if(Count($premioscol)>1){
		$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		$pedido = $pedido[0];
		$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_campana = {$id_campana}");
		
		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
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

// id_premio, nombre_premio, precio_premio, descripcion_premio, id_ppc, id_plan_campana, tipo_premio, tipo_premio_producto 
// premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto 
?>