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



if(!empty($_POST['id_producto']) && !empty($_POST['cantidad_desperfectos'])){

	$id_pedido = $_POST['id_pedido'];
	$id_producto = $_POST['id_producto'];
	$cantidad_desperfectos = $_POST['cantidad_desperfectos'];
	$descripcion_desperfectos = $_POST['descripcion_desperfectos'];
	$id_desperfecto = $_POST['id_desperfecto'];
	
	$buscar = $lider->consultarQuery("SELECT * FROM notificar_desperfectos WHERE id_pedido = {$id_pedido}");
	if($buscar['ejecucion'] == 1 && Count($buscar)>1){
		$response = "9";
	}else{
		$errores = 0;
		$i = 0;
		foreach ($cantidad_desperfectos as $cantDes) {
			if($cantDes>0){
				$descrip = ucwords(mb_strtolower($descripcion_desperfectos[$i]));
				// echo "<br><br>";
				// echo "Pedido: ".$id_pedido." ||| Desperfecto: ".$id_desperfecto.' ||| Producto: '.$id_producto[$i]." ||| Cantidad: ".$cantDes." ||| Descripcion: ".$descrip;
				$query = "INSERT INTO notificar_desperfectos (id_notificar_desperfecto, id_desperfecto, id_pedido, id_producto, cantidad_desperfectos, descripcion_desperfectos, estatus) VALUES (DEFAULT, {$id_desperfecto}, {$id_pedido}, {$id_producto[$i]}, {$cantDes}, '{$descrip}', 1)";
				$exec = $lider->registrar($query, "notificar_desperfectos", "id_notificar_desperfecto");
				// print_r($exec);
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
					$errores++;
				}
			}	
			$i++;	
		}	
		if($errores==0){
			$response = "1";
			// if($response=="1"){
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Notificar Desperfectos', 'Registrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2";
		}
	}


	$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");

	$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana and despachos.id_despacho =$id_despacho");
	$desperfecto = $lider->consultarQuery("SELECT * FROM desperfectos WHERE id_campana = {$id_campana}");
		$desperfecto = $desperfecto[0];
		$pedido = $pedido[0];
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

	$pedido = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");

	$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = $id_campana and despachos.id_despacho =$id_despacho");

	if(Count($pedido)>1){
		$desperfecto = $lider->consultarQuery("SELECT * FROM desperfectos WHERE id_campana = {$id_campana}");
		$desperfecto = $desperfecto[0];
		$pedido = $pedido[0];

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

?>