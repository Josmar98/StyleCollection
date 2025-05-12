<?php 

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
	$limitesOpciones = 10;
	$limitesElementos = 10;

	if(!empty($_POST['lider']) && !empty($_POST['precio']) && !empty($_POST['cantidad'])){
		// print_r($_POST);
		// foreach($_POST as $info => $value){
		// 	echo "<br>";
		// 	print_r($info);
		// 	echo ":<br>";
		// 	print_r($value);
		// }
		// echo "<br><br><br><br>";
		$firma = "Premio Autorizado por ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
		$firma = ucwords(mb_strtolower($firma));
		$id_cliente = $_POST['lider'];
		
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = {$id_despacho} and id_cliente = {$id_cliente}");
		$pedido = $pedidos[0];
		$id_pedido = $pedido['id_pedido'];
		
		$cantOpciones = $_POST['cantidad_opciones'];

		$errores = 0;
		for ($x=0; $x < $cantOpciones; $x++) {
			$nombre_premio = ucwords(mb_strtolower($_POST['name_opcion'][$x]));
			$cantidad = $_POST['cantidad'][$x];
			$descripcion = $_POST['descripcion'][$x];
			$elementos = $_POST['cantidad_elementos'][$x];
			$unidades[$x] = [];
			$inventarios[$x] = [];
			$tipos[$x] = [];
			$precios[$x] = [];
			$precios_nota[$x] = [];
			for ($z=0; $z <$elementos; $z++) {
				$unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
				// $unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
				$inventarios[$x][count($inventarios[$x])] = $_POST['inventarios'][$x][$z];
				$tipos[$x][count($tipos[$x])] = $_POST['tipos'][$x][$z];
				$precios[$x][count($precios[$x])] = $_POST['precio'][$x][$z];
				$precios_nota[$x][count($precios_nota[$x])] = $_POST['precio_nota'][$x][$z];
			}

			// AQUI HASTA AQUI
			$query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
			// echo "<br>".$query."<br><br>"; $execPremio=['ejecucion'=>true, 'id'=>3552];
			$execPremio = $lider->registrar($query, "premios", "id_premio");
			if($execPremio['ejecucion']==true){
				$id_premio = $execPremio['id'];
				$tipoPremio = "Premio";
				// echo "id_premio: ".$id_premio;
				for ($z=0; $z < $elementos; $z++){
					$unidad = $unidades[$x][$z];
					$precio = $precios[$x][$z];
					$precio_nota = $precios_nota[$x][$z];
					$tipo = $tipos[$x][$z];
					$id_inventario = $inventarios[$x][$z];
					$posMercancia = strpos($id_inventario,'m');
					if(strlen($posMercancia)==0){
						$id_element = $id_inventario;
					}else{
						$id_element = preg_replace("/[^0-9]/", "", $id_inventario);
					}
					// echo $unidad." DE ".$id_element." | ".$precio."";
					$query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, precio_inventario, precio_notas, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidad}, '{$tipo}', {$precio}, {$precio_nota}, 1)";
					// echo "<br>".$query."<br><br>";
					$execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
					if($execPI['ejecucion']==true){
					}else{
						$errores++;
					}
				}
				
				$query = "INSERT INTO premios_autorizados (id_PA, id_pedido, id_cliente, id_premio, cantidad_PA, descripcion_PA, firma_PA, estatus) VALUES (DEFAULT, {$id_pedido}, {$id_cliente}, {$id_premio}, {$cantidad}, '{$descripcion}', '{$firma}', 1)";
				// echo "<br>".$query."<br><br>";
				$exec = $lider->registrar($query, "premios_autorizados", "id_PA");
				if($exec['ejecucion']==true ){
				}else{
				$errores++;
				}
			}else{
				$errores++;
			}

			// AQUI HASTA AQUI
		
		}

		// $id_premio = $_POST['premio'];
		
		// $cantidad = $_POST['cantidad'];
		// $descripcion = ucwords( mb_strtolower($_POST['descripcion']) );
		// $firma = "Premio Autorizado por ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
		// $firma = ucwords(mb_strtolower($firma));
		// $descripcion = trim($descripcion);
		// $descripcion = ucwords(mb_strtoupper($descripcion));
		
		// // echo "<br>";
		// // echo "Cliente: ".$id_cliente."<br>";
		// // echo "Premio: ".$id_premio."<br>";
		// // echo "Pedido: ".$id_pedido."<br>";
		// // echo "cantidad: ".$cantidad."<br>";
		// // echo "Descripcion: ".$descripcion."<br>";
		// // echo "Firma: ".$firma."<br>";
		
		// $query = "INSERT INTO premios_autorizados (id_PA, id_pedido, id_cliente, id_premio, cantidad_PA, descripcion_PA, firma_PA, estatus) VALUES (DEFAULT, {$id_pedido}, {$id_cliente}, {$id_premio}, {$cantidad}, '{$descripcion}', '{$firma}', 1)";
		
		// $exec = $lider->registrar($query, "premios_autorizados", "id_PA");
		// if($exec['ejecucion']==true){
		// 	$response = "1";
		// 	if(!empty($modulo) && !empty($accion)){
			// 		$fecha = date('Y-m-d');
			// 		$hora = date('H:i:a');
			// 		$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premio Autorizado', 'Registrar', '{$fecha}', '{$hora}')";
			// 		$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			// 	}
		// }else{
		// 	$response = "2";
		// }
		
		// die();
		
		if($errores==0){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios Autorizados', 'Registrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2";
		}
		$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    	$mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
		if(Count($lideres)>1){
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


	if(empty($_POST)){
		$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    	$mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
		// $premios = $lider->consultarQuery("SELECT * FROM premios ORDER BY premios.nombre_premio");
		// if(Count($lideres)>1){
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
		// 	require_once 'public/views/error404.php';				
		// }
	}

}else{
   require_once 'public/views/error404.php';
}
?>