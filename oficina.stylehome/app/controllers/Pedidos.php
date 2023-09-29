<?php 
if(strtolower($url)=="pedidos"){
	$id_ciclo = $_GET['c'];
	$num_ciclo = $_GET['n'];
	$ano_ciclo = $_GET['y'];
	$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
	if(!empty($action)){
		$accesoPedidosR = false;
		$accesoPedidosC = false;
		$accesoPedidosM = false;
		$accesoPedidosE = false;
		$accesoPedidosClienteR = false;
		$accesoPedidosClienteC = false;
		$accesoPedidosClienteM = false;
		$accesoPedidosClienteE = false;
		foreach ($_SESSION['home']['accesos'] as $acc) {
			if(!empty($acc['id_rol'])){
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("pedidos")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPedidosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPedidosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPedidosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPedidosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("pedidos clientes")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPedidosClienteR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPedidosClienteC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPedidosClienteM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPedidosClienteE=true; }
				}
			}
		}
		// MANEJO DE PEDIDOS
			if(!empty($_GET['admin']) && !empty($_GET['lider'])){
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['home']['id_cliente'];
			}
			$addUrlAdmin = "";
			if(!empty($_GET['admin'])){
				$addUrlAdmin .= "&admin=1";
			}
			if(!empty($_GET['lider'])){
				$addUrlAdmin .= "&lider=".$_GET['lider'];
			}
			$cantidadCarrito = 0;
			$classHidden="";
			$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and carrito.estatus = 1");
			if($buscar['ejecucion']==true){
				$cantidadCarrito = count($buscar)-1;
			}
			if($cantidadCarrito==0){
				$classHidden="d-none";
			}
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente=usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1");
		// MANEJO DE PEDIDOS
		$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo = $id_ciclo");
		$ciclo = $ciclos[0];
		//$ciclo['cierre_seleccion']=$fechaActual; // // /// // /// / // / 
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
		if($action=="Registrar"){
			$catalogos = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 and inventarios.inventario_visible=1 ORDER BY inventarios.nombre_inventario ASC;");
			// if(!empty($_POST)){
			
			// }
			if(empty($_POST)){
				if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					// $query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
					// $res1 = $lider->eliminar($query);
					// if($res1['ejecucion']==true){
					// 	$response = "1";
					// }else{
					// 	$response = "2"; // echo 'Error en la conexion con la bd';
					// }
					// if(!empty($action)){
					// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
					// 	}else{
					// 	    require_once 'public/views/error404.php';
					// 	}
					// }else{
					// 	if (is_file('public/views/'.$url.'.php')) {
					// 		require_once 'public/views/'.$url.'.php';
					// 	}else{
					// 	    require_once 'public/views/error404.php';
					// 	}
					// }
				}
				if($catalogos['ejecucion']==1){
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					if(!empty($action)){
						if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
							require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
						}else{
							require_once 'public/views/error404.php';
						}
					}else{
						require_once 'public/views/error404.php';
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
		if($action=="Detalles"){
			$catalogos = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 and inventarios.cod_inventario='{$cod}' ORDER BY inventarios.nombre_inventario ASC;");
			if(!empty($_POST)){
				if(!empty($_POST['addCart']) && !empty($_POST['codigo']) && !empty($_POST['cantidad'])){
					$cantidad = $_POST['cantidad'];
					$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and cod_inventario='{$cod}'");
					if($buscar['ejecucion']==true){
						if(count($buscar)>1){
							// "existe";
							$cart = $buscar[0];
							$id_carrito = $cart['id_carrito'];
							if($cart['estatus']==1){
								$cantActual = $cart['cantidad_inventario'];
							}else{
								$cantActual = 0;
							}
							$newCant = $cantActual+$cantidad;
							$query = "UPDATE carrito SET cantidad_inventario={$newCant}, estatus = 1 WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and cod_inventario='{$cod}' and id_carrito = {$id_carrito}";
							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente}");

								$response['exec'] = "1";
								$response['data']['op']="2";
								$response['data']['cantidad'] = count($buscar)-1;
							}else{
								$response['exec'] = "2";
							}

						}else{
							$query = "INSERT INTO carrito (id_carrito, id_ciclo, id_cliente, cod_inventario, cantidad_inventario, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_cliente}, '{$cod}', {$cantidad}, 1)";
							$exec = $lider->registrar($query, "carrito", "id_carrito");
							if($exec['ejecucion']==true){
								$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente}");
								$response['exec'] = "1";
								$response['data']['op']="1";
								$response['data']['cantidad'] = count($buscar)-1;
							}else{
								$response['exec'] = "2";
							}
						}
					}else{
						$response['exec'] = "5";
					}
					echo json_encode($response);
				}
			}
			if(empty($_POST)){
				if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					// $query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
					// $res1 = $lider->eliminar($query);
					// if($res1['ejecucion']==true){
					// 	$response = "1";
					// }else{
					// 	$response = "2"; // echo 'Error en la conexion con la bd';
					// }
					// if(!empty($action)){
					// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
					// 	}else{
					// 	    require_once 'public/views/error404.php';
					// 	}
					// }else{
					// 	if (is_file('public/views/'.$url.'.php')) {
					// 		require_once 'public/views/'.$url.'.php';
					// 	}else{
					// 	    require_once 'public/views/error404.php';
					// 	}
					// }
				}
				if($catalogos['ejecucion']==1){
					$cat = $catalogos[0];
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					if(!empty($action)){
						if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
							require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
						}else{
							require_once 'public/views/error404.php';
						}
					}else{
						require_once 'public/views/error404.php';
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
	}
}


?>