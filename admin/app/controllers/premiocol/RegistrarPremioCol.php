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

if(!empty($_POST['premios']) && !empty($_POST['id_tppc']) && !empty($_POST['id_tipo_coleccion'])){
	// print_r($_POST);

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


	// print_r($id_existencia);
	// echo "<br>";
	// echo "<br>";
	// print_r($existenciaAct);
	// echo "<br>";
	// echo "<br>";
	// print_r($existenciaNew);
	// echo "<br>";
	// echo "<br>";


	// echo "<br>****************************************<br>";
	// print_r($id_existencia);
	// echo "<br><br>";
	// print_r($existenciaAct);
	// echo "<br><br>";
	// print_r($existenciaNew);
	// echo "<br><br>";



											// $i=0;
											// foreach ($id_tppc as $id) {
											// 	echo " | ";
											// 	echo $i+1;
											// 	echo " | ";
											// 	echo $id_tipo[$i];
											// 	echo " | ";
											// 	echo $id;
											// 	echo " | ";
											// 	echo $cantidad[$i];
											// 	echo " | ";
											// 	$i++;
											// 	echo "<br>";
											// }

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

		$h=0;
		$valid = [];
	if(!empty($id_existencia)){
		foreach ($id_existencia as $idid) {
			$existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = $idid");
			foreach ($existencias as $exx) {
				if(!empty($exx['id_existencia'])){
					if($exx['id_existencia']==$id_existencia[$h]){
						// echo "<br>Intento ".($h)." : <br>";
						// print_r($exx);
						// echo "<br>";
						// echo "Id Buscado: ".$exx['id_existencia']."<br>";
						// echo "ID: Recibido: ".$id_existencia[$h]."<br>";
						// echo $exx['cantidad_existencia']."<br>";
						// echo "Nueva: ".$existenciaNew[$h]."<br>";
						// echo "Actual: ".$existenciaAct[$h]."<br>";
						// echo "<br><br>";
						if($exx['cantidad_existencia'] >= $existenciaNew[$h]){
							if($exx['cantidad_existencia'] == $existenciaAct[$h]){
								$valid[$h]=0;
							}else{
								$caaant = $existenciaAct[$h]-$existenciaNew[$h];
								$resultt = $exx['cantidad_existencia']-$caaant;
								// echo "--: ".$caaant."<br>";
								// echo "Resultado: ".$resultt."<br><br>";
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
	// print_r($valid);
	$acumExis = 0;
	foreach ($valid as $valval) {
		$acumExis += $valval;
	}
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


					$query2 = "SELECT cantidad_premios_plan FROM premio_coleccion, tipos_premios_planes_campana WHERE tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = {$id_premio}";
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

					// print_r($cantidad);


					// echo "Premio: ".$id_premio."<br>";
					// echo "Real Existencia del premio: ".$exissReal."<br>";
					// echo "ID Existencia: ".$id_exis."<br>";
					// echo "Cantidad de premio elegidos: ".$cant."<br>";
					// echo "Limite Establecido: ".$realExistencia."<br>";
					// echo "Nueva Existencia: ".$nuevaExistenciaReal."<br>";
					// echo "<br>";
					// echo "".$query."<br><br><br>";

					// $query = "UPDATE existencias SET cantidad_existencia = {$existenciaNew[$g]}, estatus = 1 WHERE id_existencia = {$id_exis} and id_campana = {$id_campana} and cantidad_existencia = {$existenciaAct[$g]}";


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
	if($response=="1"){
		if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios De Colecciones', 'Registrar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
	}

	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista Supervisor")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana}");
	$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
	$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and planes_campana.estatus = 1");
		$pedido = $pedido[0];
	$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");
		
	$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT	* FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

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

	// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
	if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista Supervisor")){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id_cliente'];
	}
	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id} and planes_campana.id_campana = {$id_campana}");
	if(Count($planesCol)>1){

		$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$id}");
		// $planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and planes_campana.estatus = 1");
		$pedido = $pedido[0];

		// $premios_planes = $lider->consultarQuery("SELECT * FROM premios_planes_campana");


		// $tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, premios WHERE tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

		$premios_planes = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto FROM tipos_premios_planes_campana, premios_planes_campana WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");
		
		$tipo_premios_planes = $lider->consultarQuery("SELECT DISTINCT	* FROM premios, tipos_premios_planes_campana, premios_planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.tipo_premio_producto = 'Premios'");

		$tipo_premios_planespp = $lider->consultarQuery("SELECT DISTINCT id_premio, nombre_premio, estatus FROM premios");
		
		// $tipo_premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM tipos_premios_planes_campana, premios WHERE tipos_premios_planes_campana.id_premio = premios.id_premio");
		// print_r($tipo_premios_planes[0]);

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
		    require_once 'public/views/error404.php';
	}

}

// id_premio, nombre_premio, precio_premio, descripcion_premio, id_ppc, id_plan_campana, tipo_premio, tipo_premio_producto 
// premios_planes_campana.id_ppc, premios_planes_campana.id_plan_campana, premios_planes_campana.tipo_premio, tipos_premios_planes_campana.tipo_premio_producto 
?>