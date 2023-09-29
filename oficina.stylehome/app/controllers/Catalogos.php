<?php 
if(strtolower($url)=="catalogos"){
	// $id_ciclo = $_GET['c'];
	// $num_ciclo = $_GET['n'];
	// $ano_ciclo = $_GET['y'];
	// $menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
	$menu = "";
	if(!empty($action)){
		$accesoCatalogosR = false;
		$accesoCatalogosC = false;
		$accesoCatalogosM = false;
		$accesoCatalogosE = false;
		$accesoCatalogosClienteR = false;
		$accesoCatalogosClienteC = false;
		$accesoCatalogosClienteM = false;
		$accesoCatalogosClienteE = false;
		foreach ($_SESSION['home']['accesos'] as $acc) {
			if(!empty($acc['id_rol'])){
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Catalogos")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoCatalogosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoCatalogosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoCatalogosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoCatalogosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Catalogos clientes")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoCatalogosClienteR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoCatalogosClienteC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoCatalogosClienteM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoCatalogosClienteE=true; }
				}
			}
		}
		// MANEJO DE Catalogos
			if(!empty($_GET['admin']) && !empty($_GET['lider'])){
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['home']['id_cliente'];
			}
			$addUrlAdmin = "";
			
			if(!empty($_GET['lider'])){
				$addUrlAdmin .= "&lider=".$_GET['lider'];
			}
			$cantidadCarrito = 0;
			$classHidden="";
			// $buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and carrito.estatus = 1");
			// if($buscar['ejecucion']==true){
			// 	$cantidadCarrito = count($buscar)-1;
			// }
			if($cantidadCarrito==0){
				$classHidden="d-none";
			}
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente=usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1");
		// MANEJO DE Catalogos
		// $ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo = $id_ciclo");
		// $ciclo = $ciclos[0];
		//$ciclo['cierre_seleccion']=$fechaActual; // // /// // /// / // / 
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
		if($action=="Consultar"){
			$catalogos = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 and inventarios.inventario_visible=1 ORDER BY inventarios.nombre_inventario ASC;");
			if(!empty($_POST)){
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
				// print_r($_POST);
				if(!empty($_POST['canjearPremios'])){
					$id_lider = $_GET['lider'];
					$inventario = $lider->consultarQuery("SELECT * FROM inventarios WHERE cod_inventario='{$cod}'");
					if(count($inventario)>1){
						$inventario = $inventario[0];
						$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod}'");
						$existencia = [];
						if(count($existencias)>1){
							$existencia = $existencias[0];
						}
						// echo $existencia['cantidad_disponible'];
						// print_r($inventario);
						// echo "<br><br>";
						// print_r($existencia);
						if($existencia['cantidad_disponible']>=1){
							$nDisp = $existencia['cantidad_disponible']-1;
							$nBloq = $existencia['cantidad_bloqueada']+1;
							$query = "UPDATE existencias SET cantidad_disponible={$nDisp}, cantidad_bloqueada={$nBloq} WHERE id_existencia={$existencia['id_existencia']}";
							$execExist = $lider->modificar($query);
							if($execExist['ejecucion']==true){
								$resp="1";
							}else{
								$resp="2";
							}
						}
						
						$query = "INSERT INTO canjeos (id_canjeo, cod_inventario, id_cliente, fecha_canjeo, hora_canjeo, estado_canjeo, id_ciclo, estatus) VALUES (DEFAULT, '{$cod}', {$id_lider}, '{$fechaActual}', '{$horaActual}', 0, 0, 1)";
						$exec = $lider->registrar($query, "canjeos", "id_canjeo");
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
						// echo $query;

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

					}
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
		if($action=="Canjeos"){
			if(!empty($_POST)){

			}
			if(empty($_POST)){
				$query1 = "SELECT DISTINCT clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido, clientes.cedula FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 ORDER BY canjeos.fecha_canjeo ASC";
				$lideres = $lider->consultarQuery($query1);
				$op = "";
				if(!empty($_GET['op'])){
					if($_GET['op']==1){
						$op = " and canjeos.id_ciclo=0 ";
					}
					if($_GET['op']==2){
						$op = " and canjeos.id_ciclo!=0 ";
					}
					if($_GET['op']==3){
						$op = "";
					}
				}
				$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 {$op} ORDER BY canjeos.fecha_canjeo ASC";
				$canjeos = $lider->consultarQuery($query2);
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
			}
		}
		if($action=="Asignar"){
			if(!empty($_POST)){
				$id_canjeo = $_POST['id_canjeo'];
				$id_ciclo_selected = $_POST['id_ciclo'];

				$query = "UPDATE canjeos SET id_ciclo = {$id_ciclo_selected} WHERE id_canjeo={$id_canjeo}";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}

				if(!empty($id)){
					$query1 = "SELECT DISTINCT clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido, clientes.cedula FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 and clientes.id_cliente = {$id} ORDER BY canjeos.fecha_canjeo ASC";
					$lideres = $lider->consultarQuery($query1);
					$cliente = $lideres[0];
					$op = "";
					if(!empty($_GET['op'])){
						if($_GET['op']==1){
							$op = " and canjeos.id_ciclo=0 ";
						}
						if($_GET['op']==2){
							$op = " and canjeos.id_ciclo!=0 ";
						}
						if($_GET['op']==3){
							$op = "";
						}
					}
					$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 and clientes.id_cliente = {$id} {$op} ORDER BY canjeos.fecha_canjeo ASC";
					$canjeos = $lider->consultarQuery($query2);
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					$ciclosDisponibles = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE ciclos.id_ciclo = pedidos.id_ciclo and pedidos.id_cliente = clientes.id_cliente and ciclos.estatus=1 and pedidos.estatus=1 and clientes.estatus=1 and clientes.id_cliente = {$id} ORDER BY ciclos.id_ciclo DESC;");
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
			if(empty($_POST)){
				if(!empty($id)){
					$query1 = "SELECT DISTINCT clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido, clientes.cedula FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 and clientes.id_cliente = {$id} ORDER BY canjeos.fecha_canjeo ASC";
					$lideres = $lider->consultarQuery($query1);
					$cliente = $lideres[0];
					$op = "";
					if(!empty($_GET['op'])){
						if($_GET['op']==1){
							$op = " and canjeos.id_ciclo=0 ";
						}
						if($_GET['op']==2){
							$op = " and canjeos.id_ciclo!=0 ";
						}
						if($_GET['op']==3){
							$op = "";
						}
					}
					$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 and clientes.id_cliente = {$id} {$op} ORDER BY canjeos.fecha_canjeo ASC";
					$canjeos = $lider->consultarQuery($query2);
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					$ciclosDisponibles = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE ciclos.id_ciclo = pedidos.id_ciclo and pedidos.id_cliente = clientes.id_cliente and ciclos.estatus=1 and pedidos.estatus=1 and clientes.estatus=1 and clientes.id_cliente = {$id} ORDER BY ciclos.id_ciclo DESC;");
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
		if($action=="Historial"){
			// $catalogos = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 and inventarios.inventario_visible=1 ORDER BY inventarios.nombre_inventario ASC;");
			if(!empty($_POST)){
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
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC;");
				$ciclosAll = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus = 1 ORDER BY ciclos.id_ciclo DESC;");
				$query1 = "";
				$query2 = "";
				if($personalInterno){
					if(!empty($_GET['option'])){
						if(mb_strtolower($_GET['option'])==mb_strtolower("All")){
							$query1 = "SELECT * FROM ciclos, puntos, clientes, pedidos WHERE ciclos.id_ciclo=puntos.id_ciclo and puntos.id_cliente=clientes.id_cliente and puntos.id_pedido = pedidos.id_pedido and ciclos.estatus=1 and clientes.estatus=1 and puntos.estatus = 1 and puntos.estado_puntos=1";
							$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1";
						}
						if(mb_strtolower($_GET['option'])==mb_strtolower("Filtrar")){
							$query1 = "SELECT * FROM ciclos, puntos, clientes, pedidos WHERE ciclos.id_ciclo=puntos.id_ciclo and puntos.id_cliente=clientes.id_cliente and puntos.id_pedido = pedidos.id_pedido and ciclos.estatus=1 and clientes.estatus=1 and puntos.estatus = 1 and puntos.estado_puntos=1";
							$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1";
							if(!empty($_GET['lider'])){
								$query1 .= " and clientes.id_cliente={$_GET['lider']}";
								$query2 .= " and clientes.id_cliente={$_GET['lider']}";
							}
							if(!empty($_GET['ciclo'])){
								$query1 .= " and ciclos.id_ciclo={$_GET['ciclo']}";
								$query2 .= " and canjeos.id_ciclo={$_GET['ciclo']}";
							}
						}
						$query1 .= " ORDER BY fecha_puntos ASC";
						$query2 .= " ORDER BY canjeos.fecha_canjeo ASC";
					}
				}else{
					$query1 = "SELECT * FROM ciclos, puntos, clientes, pedidos WHERE ciclos.id_ciclo=puntos.id_ciclo and puntos.id_cliente=clientes.id_cliente and puntos.id_pedido = pedidos.id_pedido and ciclos.estatus=1 and clientes.estatus=1 and puntos.estatus = 1 and clientes.id_cliente={$id_cliente} and puntos.estado_puntos=1";
					$query2 = "SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario = canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and clientes.estatus = 1 and canjeos.estatus = 1 and clientes.id_cliente={$id_cliente}";
				}
				$puntos = $lider->consultarQuery($query1);
				$canjeos = $lider->consultarQuery($query2);
				$historial = [];
				$index=0;
				foreach ($puntos as $key){ if(!empty($key['id_punto'])){
					if($key['concepto']=="1"){
						$historial[$index]['fecha'] = $key['fecha_aprobado'];
						$historial[$index]['hora'] = $key['hora_aprobado'];
						$historial[$index]['concepto'] = "Por factura directa<br><small>Ciclo {$key['numero_ciclo']}/{$key['ano_ciclo']}</small>";
					}else{
						$historial[$index]['fecha'] = $key['fecha_puntos'];
						$historial[$index]['hora'] = $key['hora_puntos'];
						$historial[$index]['concepto'] = $key['concepto'];
					}
					$historial[$index]['lider'] = $key['primer_nombre']." ".$key['primer_apellido'];
					$historial[$index]['cantidad'] = $key['cantidad_puntos'];
					$historial[$index]['operacion'] = "+";
					$historial[$index]['num'] = $index;
					$index++;
				} }

				foreach ($canjeos as $key){ if(!empty($key['id_canjeo'])){
					$historial[$index]['fecha'] = $key['fecha_canjeo'];
					$historial[$index]['hora'] = $key['hora_canjeo'];
					$historial[$index]['concepto'] = "Por canjeo de Premio";
					$historial[$index]['lider'] = $key['primer_nombre']." ".$key['primer_apellido'];
					$historial[$index]['cantidad'] = $key['puntos_inventario'];
					$historial[$index]['operacion'] = "-";
					$historial[$index]['num'] = $index;
					$index++;
				} }

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
			}
		}
		
	}
}

?>