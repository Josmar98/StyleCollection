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

	if(!empty($_POST['lider']) && !empty($_POST['premio']) && !empty($_POST['cantidad'])){
		// print_r($_POST);
		$id_cliente = $_POST['lider'];
		$id_premio = $_POST['premio'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = {$id_despacho} and id_cliente = {$id_cliente}");
		$pedido = $pedidos[0];
		$id_pedido = $pedido['id_pedido'];

		$cantidad = $_POST['cantidad'];
		$descripcion = ucwords( mb_strtolower($_POST['descripcion']) );
		$firma = "Premio Autorizado por ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
		$firma = ucwords(mb_strtolower($firma));
		$descripcion = trim($descripcion);
		$descripcion = ucwords(mb_strtolower($descripcion));

		// echo "<br>";
		// echo "Cliente: ".$id_cliente."<br>";
		// echo "Premio: ".$id_premio."<br>";
		// echo "Pedido: ".$id_pedido."<br>";
		// echo "cantidad: ".$cantidad."<br>";
		// echo "Descripcion: ".$descripcion."<br>";
		// echo "Firma: ".$firma."<br>";
		
		$query = "UPDATE premios_autorizados SET id_premio={$id_premio}, cantidad_PA={$cantidad}, descripcion_PA='{$descripcion}', estatus=1 WHERE id_PA = {$id}";

		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premio Autorizado', 'Modificar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
		}else{
			$response = "2";
		}




		$premios_autorizados = $lider->consultarQuery("SELECT * FROM premios_autorizados WHERE estatus = 1 and id_PA = {$id}");
		$premioAutorizado = $premios_autorizados[0];
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 and clientes.id_cliente = {$premioAutorizado['id_cliente']} ORDER BY clientes.id_cliente ASC;");
		$premios = $lider->consultarQuery("SELECT * FROM premios ORDER BY premios.nombre_premio");

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
		$premios_autorizados = $lider->consultarQuery("SELECT * FROM premios_autorizados WHERE estatus = 1 and id_PA = {$id}");
		$premioAutorizado = $premios_autorizados[0];
		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 and clientes.id_cliente = {$premioAutorizado['id_cliente']} ORDER BY clientes.id_cliente ASC;");
		$premios = $lider->consultarQuery("SELECT * FROM premios ORDER BY premios.nombre_premio");
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