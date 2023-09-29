<?php
	if(strtolower($url)=="puntosautorizados"){
		$id_ciclo = $_GET['c'];
		$num_ciclo = $_GET['n'];
		$ano_ciclo = $_GET['y'];
		$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
		if(!empty($action)){
			$accesoPuntosAutorizadosR = false;
			$accesoPuntosAutorizadosC = false;
			$accesoPuntosAutorizadosM = false;
			$accesoPuntosAutorizadosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos De Ciclos")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPuntosAutorizadosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPuntosAutorizadosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPuntosAutorizadosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPuntosAutorizadosE=true; }
					}
				}
			}
			$addUrlAdmin = "";
			$id_cliente = $_SESSION['home']['id_cliente'];
			$cantidadCarrito = 0;
			$classHidden="";
			$buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and carrito.estatus=1");
			if($buscar['ejecucion']==true){
				$cantidadCarrito = count($buscar)-1;
			}
			if($cantidadCarrito==0){
				$classHidden="d-none";
			}
			$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo = $id_ciclo");
			$ciclo = $ciclos[0];
			// CONSULTA DE PAGOS
				$pagosT=['reportado'=>0, 'abonado'=>0, 'diferido'=>0];
				$pagosTReportado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente}");
				$pagosT['reportado']+=$pagosTReportado[0][0];
				$pagosTAbonado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Abonado'");
				$pagosT['abonado']+=$pagosTAbonado[0][0];
				$pagosTDiferido = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Diferido'");
				$pagosT['diferido']+=$pagosTDiferido[0][0];
			// CONSULTA DE PAGOS
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoPuntosAutorizadosC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoPuntosAutorizadosE){
							$query = "UPDATE puntos SET estatus = 0 WHERE id_punto = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos de Campaña, 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(!empty($_GET['bloqueo']) && $_GET['bloqueo'] == 1 ){
						$buscar = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_punto = {$id}");
						if(count($buscar)>1){
							$busq = $buscar[0];
							$query = "UPDATE puntos SET estado_puntos = 0, puntos_disponibles=0, puntos_bloqueados={$busq['cantidad_puntos']} WHERE id_punto = {$id}";
							$res1 = $lider->modificar($query);
							if($res1['ejecucion']==true){
								$response = "11";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Bloquear', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}else{
							$response = "2";
						}
					}
					if(!empty($_GET['desbloqueo']) && $_GET['desbloqueo'] == 1 ){
						$buscar = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_punto = {$id}");
						if(count($buscar)>1){
							$busq = $buscar[0];
							$query = "UPDATE puntos SET estado_puntos = 0, puntos_disponibles={$busq['cantidad_puntos']}, puntos_bloqueados=0 WHERE id_punto = {$id}";
							$res1 = $lider->modificar($query);
							if($res1['ejecucion']==true){
								$response = "11";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Gemas', 'Bloquear', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}else{
							$response = "2";
						}
					}
					if(empty($_POST)){
						$query = "SELECT * FROM ciclos, pedidos, puntos, clientes WHERE ciclos.id_ciclo=pedidos.id_ciclo and pedidos.id_pedido = puntos.id_pedido and puntos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo={$id_ciclo} and pedidos.estatus=1 and clientes.estatus=1 and puntos.estatus=1";
						$puntos = $lider->consultarQuery($query);
						if($puntos['ejecucion']==1){
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Borrados"){
				if($accesoPuntosAutorizadosC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoPuntosAutorizadosE){
							$query = "UPDATE puntos SET estatus = 1 WHERE id_punto = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos de Campaña, 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$query = "SELECT * FROM ciclos, pedidos, puntos, clientes WHERE ciclos.id_ciclo=pedidos.id_ciclo and pedidos.id_pedido = puntos.id_pedido and puntos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo={$id_ciclo} and pedidos.estatus=1 and clientes.estatus=1 and puntos.estatus=0";
						$puntos = $lider->consultarQuery($query);
						if($puntos['ejecucion']==1){
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Registrar"){
				if($accesoPuntosAutorizadosR){
					if(!empty($_POST)){
						// if(!empty($_POST['validarData'])){
						// 	$id_liderazgo = $_POST['id_liderazgo'];
						// 	$query = "SELECT * FROM liderazgos_ciclos WHERE id_liderazgo = $id_liderazgo and id_ciclo = $id_ciclo and estatus = 1";
						// 	$res1 = $lider->consultarQuery($query);
						// 	if($res1['ejecucion']==true){
						// 		if(Count($res1)>1){
						// 			$response = "9"; //echo "Registro ya guardado.";
						// 		}else{
						// 			$response = "1";
						// 		}
						// 	}else{
						// 		$response = "5"; // echo 'Error en la conexion con la bd';
						// 	}
						// 	echo $response;
						// }
						if(!empty($_POST['lider'])){
							$id_pedido = $_POST['lider'];
							$cantidad = $_POST['cantidad'];
							$concepto = ucwords(mb_strtolower($_POST['descripcion']));
							$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo={$id_ciclo} and id_pedido={$id_pedido}");
							$id_cliente = $buscar[0]['id_cliente'];
							$query = "INSERT INTO puntos (id_punto, id_ciclo, id_cliente, id_pedido, fecha_puntos, hora_puntos, concepto, cantidad_puntos, puntos_disponibles, puntos_bloqueados, estado_puntos, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_cliente}, {$id_pedido}, '{$fechaActual}', '{$horaActual}', '{$concepto}', {$cantidad}, {$cantidad}, 0, 1, 1)";
							$exec = $lider->registrar($query, "puntos", "id_punto");
							if($exec['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
							}

							$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo={$id_ciclo}");
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
					if(empty($_POST)){
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo={$id_ciclo}");
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Modificar"){
				if($accesoPuntosAutorizadosR){
					if(!empty($_POST)){
						// if(!empty($_POST['validarData'])){
						// 	$id_liderazgo = $_POST['id_liderazgo'];
						// 	$query = "SELECT * FROM liderazgos_ciclos WHERE id_liderazgo = $id_liderazgo and id_ciclo = $id_ciclo and estatus = 1";
						// 	$res1 = $lider->consultarQuery($query);
						// 	if($res1['ejecucion']==true){
						// 		if(Count($res1)>1){
						// 			$response = "9"; //echo "Registro ya guardado.";
						// 		}else{
						// 			$response = "1";
						// 		}
						// 	}else{
						// 		$response = "5"; // echo 'Error en la conexion con la bd';
						// 	}
						// 	echo $response;
						// }
						if(!empty($_POST['lider'])){
							$id_pedido = $_POST['lider'];
							$cantidad = $_POST['cantidad'];
							$concepto = ucwords(mb_strtolower($_POST['descripcion']));
							$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo={$id_ciclo} and id_pedido={$id_pedido}");
							$id_cliente = $buscar[0]['id_cliente'];
							$query = "UPDATE puntos SET fecha_puntos='{$fechaActual}', hora_puntos='{$horaActual}', concepto='{$concepto}', cantidad_puntos={$cantidad}, puntos_disponibles={$cantidad}, puntos_bloqueados=0, estado_puntos=1, estatus=1 WHERE id_punto={$id}";
							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
							}

							$puntos = $lider->consultarQuery("SELECT * FROM puntos, clientes WHERE puntos.id_cliente = clientes.id_cliente and puntos.id_ciclo={$id_ciclo} and puntos.estatus=1 and clientes.estatus=1 and puntos.id_punto = {$id}");
							if(count($puntos)>1){
								$punto=$puntos[0];
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
					if(empty($_POST)){
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo={$id_ciclo}");
						$puntos = $lider->consultarQuery("SELECT * FROM puntos, clientes WHERE puntos.id_cliente = clientes.id_cliente and puntos.id_ciclo={$id_ciclo} and puntos.estatus=1 and clientes.estatus=1 and puntos.id_punto = {$id}");
						if(count($puntos)>1){
							$punto=$puntos[0];
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			
		}
	}

?>