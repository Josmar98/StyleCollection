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

		if(!empty($_POST['clientes']) && !empty($_POST['cantidad_gemas'])){
			// print_r($_POST);
			$id_cliente = $_POST['clientes'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = {$id_despacho} and id_cliente = {$id_cliente}");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$gemas = $_POST['cantidad_gemas'];
			$descripcion = ucwords(mb_strtolower($_POST['descripcion']));
			$fecha = date('Y-m-d');
			$hora = date('h:i a');
			$name = $_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];

			// echo "<br>-******-<br>";
			// echo "Cliente: ".$id_cliente."<br>";
			// echo "Pedido: ".$id_pedido."<br>";
			// echo "Campaña: ".$id_campana."<br>";
			// echo "Despacho: ".$id_despacho."<br>";
			// echo "Cantidad de Gemas: ".$gemas."<br>";
			// echo "Descripcion: ".$descripcion."<br>";
			// echo "Firma: ".$name."<br>";
			// echo "Estatus: 1"."<br>";

			// $buscar = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE id_campana = {$id_campana} and id_despacho = {$id_despacho} and id_cliente = {$id_cliente} and id_pedido = {$id_pedido} and estatus = 1");
			// print_r($buscar);
			// if(count($buscar)>1){

			// // 	$response = "9";
			// }else{
				$query = "UPDATE obsequiogemas SET cantidad_gemas='{$gemas}', descripcion_gemas='{$descripcion}', firma_obsequio='{$name}', estatus=1 WHERE id_obsequio_gema = {$id}";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";
					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Obsequio Gemas', 'Editar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2";
				}
			// }

			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
			$obsequios = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and despachos.id_despacho = {$id_despacho} and campanas.id_campana = {$id_campana} and clientes.estatus = 1 and obsequiogemas.estatus = 1 and obsequiogemas.id_obsequio_gema = {$id}");
			$obsequio = $obsequios[0];
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
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC;");
			$obsequios = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and despachos.id_despacho = {$id_despacho} and campanas.id_campana = {$id_campana} and clientes.estatus = 1 and obsequiogemas.estatus = 1 and obsequiogemas.id_obsequio_gema = {$id}");
			$obsequio = $obsequios[0];
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
}else{
   require_once 'public/views/error404.php';
}
?>