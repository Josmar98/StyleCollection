<?php 
if(strtolower($url)=="chome"){
	$id_ciclo = $_GET['c'];
	$num_ciclo = $_GET['n'];
	$ano_ciclo = $_GET['y'];
	$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
	if(!empty($action)){
		$accesoPedidosR = false;
		$accesoPedidosC = false;
		$accesoPedidosM = false;
		$accesoPedidosE = false;
		$accesoPedidosCliente = false;
		$accesoPedidosClienteR = false;
		$accesoPedidosClienteC = false;
		$accesoPedidosClienteM = false;
		$accesoPedidosClienteE = false;
		$accesoAprobarPedidos = false;
		$accesoAprobarPedidosR = false;
		$accesoAprobarPedidosC = false;
		$accesoAprobarPedidosM = false;
		$accesoAprobarPedidosE = false;
		foreach ($_SESSION['home']['accesos'] as $acc) {
			if(!empty($acc['id_rol'])){
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("pedidos")){
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPedidosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPedidosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPedidosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPedidosE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("pedidos clientes")){
					$accesoPedidosCliente = true;
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPedidosClienteR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPedidosClienteC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPedidosClienteM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPedidosClienteE=true; }
				}
				if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("aprobar pedidos")){
					$accesoAprobarPedidos = true;
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoAprobarPedidosR=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoAprobarPedidosC=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoAprobarPedidosM=true; }
					if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoAprobarPedidosE=true; }
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
		$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
		if($action=="Consultar"){
			$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_cliente = {$id_cliente} and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
			$precioTotalFactura = 0;
			$precioTotalFacturaAprobada = 0;
			foreach ($pedidosInv as $keys) { if(!empty($keys['id_pedido_inventario'])){
				// echo $keys['cantidad_solicitada']." * ".$keys['precio_inventario']."<br>";
				$precioTotalFactura += (($keys['cantidad_solicitada'])*($keys['precio_inventario']));
				$precioTotalFacturaAprobada += (($keys['cantidad_aprobada'])*($keys['precio_inventario']));
			} }
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_cliente and pedidos.id_ciclo = {$id_ciclo}");
			$pedidosAll = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = $id_ciclo ORDER BY pedidos.id_pedido DESC");
			$pedidosInvAll = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
			
			if(!empty($_POST)){
				// if(!empty($_POST['pedidos_historicos']) && !empty($_POST['id_pedido'])){
				// 	$id_pedido = $_POST['id_pedido'];
				// 	$pedidos_historicos = $lider->consultarQuery("SELECT id_pedidos_historicos, id_despacho, id_pedido, cantidad_aprobado, fecha_aprobado, hora_aprobado, pedidos_historicos.estatus, usuarios.id_usuario, usuarios.nombre_usuario, clientes.id_cliente, clientes.primer_nombre, clientes.primer_apellido FROM pedidos_historicos, usuarios, clientes WHERE pedidos_historicos.id_usuario=usuarios.id_usuario and usuarios.id_cliente = clientes.id_cliente and pedidos_historicos.id_despacho = {$id_despacho} and pedidos_historicos.id_pedido = {$id_pedido}");
				// 	if(count($pedidos_historicos)>1){
				// 		$result['msj']="Good";
				// 		$result['data'] = [];
				// 		$ind = 0;
				// 		foreach ($pedidos_historicos as $key) {
				// 			if(!empty($key['id_pedido'])){
				// 				if($key['id_pedido']==$id_pedido){
				// 					$result['data'][$ind] = $key;
				// 					$ind++;
				// 				}
				// 			}
				// 		}
				// 		echo json_encode($result);
				// 	}
				// }
				if(!empty($_POST['validarVisibilidad'])){
					$visibilidad = $_POST['visibilidad'];
					$query = "UPDATE ciclos SET visibilidad_ciclo = {$visibilidad} WHERE id_ciclo = {$id_ciclo}";
					$exec = $lider->modificar($query);
					if($exec['ejecucion']==true){
						$response = "1";
						// if(!empty($modulo) && !empty($accion)){
						// 	$campAnt = $campAnt[0];
						// 	$elementos = array(
						// 		"Nombres"=> [0=>"Id", 1=>ucwords("Nombre De Campaña"), 2=> ucwords("Anio De Campaña"), 3=> ucwords("Numero De Campaña"), 4=>"Visibilidad", 5=>"Estatus"],
						// 		"Anterior"=> [ 0 =>$id, 1 =>$campAnt['nombre_campana'], 2 =>$campAnt['anio_campana'], 3 =>$campAnt['numero_campana'], 4=>$campAnt['visibilidad'], 5=>$campAnt['estatus'] ],
						// 		"Actual"=> [ 0=> $id, 1=> $campAnt['nombre_campana'], 2=> $campAnt['anio_campana'] , 3=>$campAnt['numero_campana'], 4=>$visibilidad, 5=>$campAnt['estatus'] ]
						// 	);
						// 	$elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
						// 	$fecha = date('Y-m-d');
						// 	$hora = date('H:i:a');
						// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
						// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
						// }
					}else{
						$response = "2";
					}
					echo $response;
				}
				if(!empty($_POST['validarEstadoCamp'])){
					$estadoCiclo = $_POST['estadoCiclo'];
					// $campAnt = $lider->consultarQuery("SELECT * FROM campanas WHERE id_campana = $id");
					$query = "UPDATE ciclos SET estado_ciclo = $estadoCiclo WHERE id_ciclo = {$id_ciclo}";
					$exec = $lider->modificar($query);
					if($exec['ejecucion']==true){
						$response = "1";
						// if(!empty($modulo) && !empty($accion)){
						// 	$campAnt = $campAnt[0];
						// 	$elementos = array(
						// 		"Nombres"=> [0=>"Id", 1=>ucwords("Nombre De Campaña"), 2=> ucwords("Anio De Campaña"), 3=> ucwords("Numero De Campaña"), 4=>"Estado de Campaña", 5=>"Estatus"],
						// 		"Anterior"=> [ 0 =>$id, 1 =>$campAnt['nombre_campana'], 2 =>$campAnt['anio_campana'], 3 =>$campAnt['numero_campana'], 4=>$campAnt['estado_campana'], 5=>$campAnt['estatus'] ],
						// 		"Actual"=> [ 0=> $id, 1=> $campAnt['nombre_campana'], 2=> $campAnt['anio_campana'] , 3=>$campAnt['numero_campana'], 4=>$estadoCamp, 5=>$campAnt['estatus'] ]
						// 	);
						// 	$elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
						// 	$fecha = date('Y-m-d');
						// 	$hora = date('H:i:a');
						// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
						// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
						// }
					}else{
						$response = "2";
					}
					echo $response;
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
				if($pedidos['ejecucion']==1){
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
		if($action=="Aprobar"){
			if($accesoAprobarPedidosR){
				$existencias = $lider->consultarQuery("SELECT * FROM inventarios, existencias WHERE inventarios.cod_inventario=existencias.cod_inventario and inventarios.estatus=1 and existencias.estatus=1");
				// foreach ($existencias as $key) {
				// 	print_r($key);
				// 	echo "<br><br><br>";
				// }
				$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario AND inventarios.estatus=1 AND pedidos_inventarios.estatus=1 and pedidos_inventarios.id_pedido={$id}");
				$pedidos = $lider->consultarQuery("SELECT * FROM usuarios, clientes, pedidos WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente=pedidos.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 and pedidos.estatus=1 and pedidos.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$id}");

				if(!empty($_POST)){
					if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
						$num = number_format($_POST['val'],2,',','.');
						echo $num;
					}
					if(!empty($_POST['aprobarPedido']) && !empty($_POST['pedido_inventario']) && !empty($_POST['cantidad_aprobada'])){
						if($accesoPedidosClienteR || $accesoPedidosClienteM){
							$pedido_inventario = $_POST['pedido_inventario'];
							$cod_inventario = $_POST['cod_inventario'];
							$cantidad_aprobada = $_POST['cantidad_aprobada'];

							$id_cliente = $pedidos[0]['id_cliente'];
							$fechaActual = date('Y-m-d');
							$horaActual = date('h:ia');
							$fechaAprobado = "";
							$horaAprobado = "";
							$vistoAdmin = 0;
							$vistoCliente = 1;
							$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo = {$id_ciclo} and id_pedido = {$id}");
							if($buscar['ejecucion']==true){
								if(count($buscar)>1){
									$busc = $buscar[0];
									$query = "UPDATE pedidos SET fecha_aprobado='{$fechaActual}', hora_aprobado='{$horaActual}', visto_admin={$vistoAdmin}, visto_cliente={$vistoCliente}, estatus=1 WHERE pedidos.id_pedido={$id}";
									$exec = $lider->modificar($query);
									if($exec['ejecucion']==true){
										$responses = "11";
									}else{
										$responses = "22";
									}
								}
								if($responses=="11"){
									$errors3=0;
									$errors2=0;
									$errors=0;
									$index=0;
									foreach ($pedido_inventario as $id_PI){
										$query = "UPDATE pedidos_inventarios SET cantidad_aprobada={$cantidad_aprobada[$index]} WHERE id_pedido_inventario={$id_PI}";
										$exec2 = $lider->modificar($query);
										if($exec2['ejecucion']!=true){
											$errors++;
										}
										
										// MANEJO DE EXISTENCIAS --- COLOCAR EN BLOQUEADO LO QUE SE APRUEBA DE LOS DISPONIBLES DEL PEDIDO
											// $existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod_inventario[$index]}'");
											// if(count($existencias)){
											// 	$existencia = $existencias[0];
											// 	$newDisponible=$existencia['cantidad_disponible']-$cantidad_aprobada[$index];
											// 	$newBloqueada=$existencia['cantidad_bloqueada']+$cantidad_aprobada[$index];
											// 	$query = "UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE id_existencia={$existencia['id_existencia']}";
											// 	$exec3 = $lider->modificar($query);
											// 	if($exec3['ejecucion']!=true){
											// 		$errors3++;
											// 	}
											// }
											$newDisponible = 0;
											$newBloqueada = 0;
											$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod_inventario[$index]}' and estatus=1");
											if(count($existencias)){
												$existencia = $existencias[0];
												$inventario = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE cod_inventario='{$cod_inventario[$index]}'");
												$aprobadas = 0;
												foreach ($inventario as $in) { if(!empty($in['id_pedido_inventario'])){
													$aprobadas+=$in['cantidad_aprobada'];
												} }
												$canjeoss = $lider->consultarQuery("SELECT * FROM canjeos WHERE cod_inventario='{$cod_inventario[$index]}'");
												$numCanjeo = 0;
												foreach ($canjeoss as $can) { if(!empty($can['id_canjeo'])){
													$numCanjeo++;
												} }
												$aprobadas+=$numCanjeo;

												$newDisponible=$existencia['cantidad_total']+$existencia['cantidad_exportada']-$aprobadas;
												$newBloqueada=$existencia['cantidad_total']-$newDisponible;
												$query = "UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE id_existencia={$existencia['id_existencia']}";
												// echo $query."<br><br>";
												$exec3 = $lider->modificar($query);
												if($exec3['ejecucion']!=true){
													$errors3++;
												}
											}
										// MANEJO DE EXISTENCIAS --- COLOCAR EN BLOQUEADO LO QUE SE APRUEBA DE LOS DISPONIBLES DEL PEDIDO

										$index++;
									}
									if($errors==0){
										$response = "1";
										// MANEJO DE PUNTOS DEL PEDIDO
											$pedidosAprobadoInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_cliente = {$id_cliente} and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
											$precioTotalAprobada = 0;
											foreach ($pedidosAprobadoInv as $keys) { if(!empty($keys['id_pedido_inventario'])){
												$precioTotalAprobada += (($keys['cantidad_aprobada'])*($keys['precio_inventario']));
											} }

											// --------------------------------------------------------------
											$nPrecioTotalAprobadaWhile = $precioTotalAprobada;
											$nPrecioTotalAprobadaFactura = 0;
											while($nPrecioTotalAprobadaWhile >= $ciclo['precio_minimo']){
												$nPrecioTotalAprobadaWhile -= $ciclo['precio_minimo'];
												$nPrecioTotalAprobadaFactura+=$ciclo['precio_minimo'];
											}
											$points = (($nPrecioTotalAprobadaFactura/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
											// $points = (($precioTotalAprobada/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
											$points = (float) number_format($points,2);
											$nPoints = 0;
											for ($i=0; $i < $ciclo['cantidad_cuotas']; $i++) { 
												$nPoints += $points;
											}
											$points = $nPoints;
											// --------------------------------------------------------------


											$concepto_puntos = "1";
											$puntos_disponibles=0;
											$puntos_bloqueados=$points;
											$estado_puntos=0;

											$buscar = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_ciclo={$id_ciclo} and puntos.id_pedido = {$id} and puntos.concepto=1");
											if(count($buscar)>1){
												$delete = $lider->eliminar("DELETE FROM puntos WHERE puntos.id_pedido = {$id} and puntos.concepto='1'");
											}

											$query = "INSERT INTO puntos (id_punto, id_ciclo, id_cliente, id_pedido, fecha_puntos, hora_puntos, concepto, cantidad_puntos, puntos_disponibles, puntos_bloqueados, estado_puntos, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_cliente}, {$id}, '{$fechaActual}', '{$horaActual}', '{$concepto_puntos}', {$points}, {$puntos_disponibles}, {$puntos_bloqueados}, {$estado_puntos}, 1)";
											// echo $query."<br><br>";
											$exec3 = $lider->registrar($query, "puntos", "id_punto");
											if($exec3['ejecucion']==true){
												$response1 = "2";
											}else{
												$response2 = "2";
											}
										// MANEJO DE PUNTOS DEL PEDIDO
									}else{
										$response = "2";
									}
								}else{
									$response = "2";
								}
							}else{
								$response = "5";
							}
							// die();
							if($pedidos['ejecucion']==1){
								$pedido = $pedidos[0];
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
						}else{
							require_once 'public/views/error404.php';
						}
					}
				}
				if(empty($_POST)){
					// if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					// 	if(($addUrlAdmin!="" && $accesoPedidosClienteE) || $addUrlAdmin==""){
					// 		$query = "UPDATE carrito SET estatus = 0 WHERE id_carrito = $id";
					// 		$res1 = $lider->eliminar($query);
					// 		if($res1['ejecucion']==true){
					// 			$response = "11";
					// 		}else{
					// 			$response = "22"; // echo 'Error en la conexion con la bd';
					// 		}
					// 	}
					// }
					if($pedidos['ejecucion']==1){
						$pedido = $pedidos[0];
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
			}else{
				require_once 'public/views/error404.php';
			}
		}
		if($action=="Modificar"){
			if($accesoAprobarPedidosR){
				$existencias = $lider->consultarQuery("SELECT * FROM inventarios, existencias WHERE inventarios.cod_inventario=existencias.cod_inventario and inventarios.estatus=1 and existencias.estatus=1");
				// foreach ($existencias as $key) {
				// 	print_r($key);
				// 	echo "<br><br><br>";
				// }
				$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario AND inventarios.estatus=1 AND pedidos_inventarios.estatus=1 and pedidos_inventarios.id_pedido={$id}");
				$pedidos = $lider->consultarQuery("SELECT * FROM usuarios, clientes, pedidos WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente=pedidos.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 and pedidos.estatus=1 and pedidos.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$id}");

				if(!empty($_POST)){
					if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
						$num = number_format($_POST['val'],2,',','.');
						echo $num;
					}
					if(!empty($_POST['aprobarPedido']) && !empty($_POST['pedido_inventario']) && !empty($_POST['cantidad_aprobada'])){
						if($accesoPedidosClienteR || $accesoPedidosClienteM){
							$pedido_inventario = $_POST['pedido_inventario'];
							$cod_inventario = $_POST['cod_inventario'];
							$cantidad_aprobada = $_POST['cantidad_aprobada'];

							$id_cliente = $pedidos[0]['id_cliente'];
							$fechaActual = date('Y-m-d');
							$horaActual = date('h:ia');
							$fechaAprobado = "";
							$horaAprobado = "";
							$vistoAdmin = 0;
							$vistoCliente = 1;
							$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo = {$id_ciclo} and id_pedido = {$id}");
							if($buscar['ejecucion']==true){
								if(count($buscar)>1){
									$busc = $buscar[0];
									$query = "UPDATE pedidos SET fecha_aprobado='{$fechaActual}', hora_aprobado='{$horaActual}', visto_admin={$vistoAdmin}, visto_cliente={$vistoCliente}, estatus=1 WHERE pedidos.id_pedido={$id}";
									$exec = $lider->modificar($query);
									if($exec['ejecucion']==true){
										$responses = "11";
									}else{
										$responses = "22";
									}
								}
								if($responses=="11"){
									$errors3=0;
									$errors2=0;
									$errors=0;
									$index=0;

									$invent = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE id_ciclo={$id_ciclo} and id_pedido={$id}");
									$error4 = 0;
									foreach ($invent as $key){ if(!empty($key['id_pedido_inventario'])){
										$nDisp = 0;
										$nBloq = 0;
										$existenciaAct = $lider->consultarQuery("SELECT * FROM existencias WHERE existencias.cod_inventario = '{$key['cod_inventario']}' and estatus=1");
										if(count($existenciaAct)>1){
											$existAct = $existenciaAct[0];
											$nDisp = $existAct['cantidad_disponible']+$key['cantidad_aprobada'];
											$nBloq = $existAct['cantidad_bloqueada']-$key['cantidad_aprobada'];
											// echo " | ";
											// echo "PREMIO : ".$key['cod_inventario'];
											// echo " | ";
											// echo "Aprobados: ".$key['cantidad_aprobada'];
											// echo " | ";
											// echo "Disponible: ".$existAct['cantidad_disponible'];
											// echo " | ";
											// echo "Bloqueado: ".$existAct['cantidad_bloqueada'];
											// echo " | ";
											// echo "TOTAL Disponible: ".$nDisp;
											// echo " | ";
											// echo "TOTAL Bloqueado: ".$nBloq;
											// echo " | ";
											// echo "ID: ".$existAct['id_existencia'];
											// echo " | ";
											// echo "<br>";
											// echo "<br>";
											// // print_r($existAct);
											// echo "<br>";
											$query = "UPDATE existencias SET cantidad_disponible={$nDisp}, cantidad_bloqueada={$nBloq} WHERE cod_inventario='{$key['cod_inventario']}' and id_existencia={$existAct['id_existencia']}";
											// echo " | ".$query."<br><br>";
											$exec4 = $lider->modificar($query);
											if($exec4['ejecucion']!=true){
												$error4++;
											}
										}
									} }
									
									// echo "<br>";
									// echo "<br>";
									// print_r($invent);


									foreach ($pedido_inventario as $id_PI){
										$query = "UPDATE pedidos_inventarios SET cantidad_aprobada={$cantidad_aprobada[$index]} WHERE id_pedido_inventario={$id_PI}";
										$exec2 = $lider->modificar($query);
										if($exec2['ejecucion']!=true){
											$errors++;
										}
										
										// MANEJO DE EXISTENCIAS --- COLOCAR EN BLOQUEADO LO QUE SE APRUEBA DE LOS DISPONIBLES DEL PEDIDO
											// $existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod_inventario[$index]}'");
											// if(count($existencias)){
											// 	$existencia = $existencias[0];
											// 	$newDisponible=$existencia['cantidad_disponible']-$cantidad_aprobada[$index];
											// 	$newBloqueada=$existencia['cantidad_bloqueada']+$cantidad_aprobada[$index];
											// 	$query = "UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE id_existencia={$existencia['id_existencia']}";
											// 	$exec3 = $lider->modificar($query);
											// 	if($exec3['ejecucion']!=true){
											// 		$errors3++;
											// 	}
											// }
											$newDisponible = 0;
											$newBloqueada = 0;
											$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod_inventario[$index]}' and estatus=1");
											if(count($existencias)){
												$existencia = $existencias[0];
												$inventario = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE cod_inventario='{$cod_inventario[$index]}'");
												$aprobadas = 0;
												foreach ($inventario as $in) { if(!empty($in['id_pedido_inventario'])){
													$aprobadas+=$in['cantidad_aprobada'];
												} }

												$canjeoss = $lider->consultarQuery("SELECT * FROM canjeos WHERE cod_inventario='{$cod_inventario[$index]}' and estatus = 1");
												$numCanjeo = 0;
												foreach ($canjeoss as $can) { if(!empty($can['id_canjeo'])){
													$numCanjeo++;
												} }
												$aprobadas+=$numCanjeo;

												$newDisponible=$existencia['cantidad_total']+$existencia['cantidad_exportada']-$aprobadas;
												$newBloqueada=$existencia['cantidad_total']-$newDisponible;
												$query = "UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE id_existencia={$existencia['id_existencia']}";
												// echo $query."<br>";
												$exec3 = $lider->modificar($query);
												if($exec3['ejecucion']!=true){
													$errors3++;
												}
											}
										// MANEJO DE EXISTENCIAS --- COLOCAR EN BLOQUEADO LO QUE SE APRUEBA DE LOS DISPONIBLES DEL PEDIDO

										$index++;
									}
									if($errors==0){
										$response = "1";
										// MANEJO DE PUNTOS DEL PEDIDO
											$pedidosAprobadoInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_cliente = {$id_cliente} and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
											$precioTotalAprobada = 0;
											foreach ($pedidosAprobadoInv as $keys) { if(!empty($keys['id_pedido_inventario'])){
												$precioTotalAprobada += (($keys['cantidad_aprobada'])*($keys['precio_inventario']));
											} }
											// --------------------------------------------------------------
											$nPrecioTotalAprobadaWhile = $precioTotalAprobada;
											$nPrecioTotalAprobadaFactura = 0;
											while($nPrecioTotalAprobadaWhile >= $ciclo['precio_minimo']){
												$nPrecioTotalAprobadaWhile -= $ciclo['precio_minimo'];
												$nPrecioTotalAprobadaFactura+=$ciclo['precio_minimo'];
											}
											$points = (($nPrecioTotalAprobadaFactura/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
											// $points = (($precioTotalAprobada/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
											$points = (float) number_format($points,2);
											$nPoints = 0;
											for ($i=0; $i < $ciclo['cantidad_cuotas']; $i++) { 
												$nPoints += $points;
											}
											$points = $nPoints;
											// --------------------------------------------------------------
											// $points = (($precioTotalAprobada/$ciclo['precio_minimo'])*$ciclo['puntos_cuotas']);
											// $points = (float) number_format($points,2);

											$concepto_puntos = "1";
											$puntos_disponibles=0;
											$puntos_bloqueados=$points;
											$estado_puntos=0;

											$buscar = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_ciclo={$id_ciclo} and puntos.id_pedido = {$id} and puntos.concepto=1");
											if(count($buscar)>1){
												$delete = $lider->eliminar("DELETE FROM puntos WHERE puntos.id_pedido = {$id} and puntos.concepto='1'");
											}

											$query = "INSERT INTO puntos (id_punto, id_ciclo, id_cliente, id_pedido, concepto, cantidad_puntos, puntos_disponibles, puntos_bloqueados, estado_puntos, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_cliente}, {$id}, '{$concepto_puntos}', {$points}, {$puntos_disponibles}, {$puntos_bloqueados}, {$estado_puntos}, 1)";
											// echo "<br><br> | ".$query."<br><br>";
											$exec3 = $lider->registrar($query, "puntos", "id_punto");
											if($exec3['ejecucion']==true){
												$response1 = "2";
											}else{
												$response2 = "2";
											}
										// MANEJO DE PUNTOS DEL PEDIDO
									}else{
										$response = "2";
									}
								}else{
									$response = "2";
								}
							}else{
								$response = "5";
							}
							// die();
							if($pedidos['ejecucion']==1){
								$pedido = $pedidos[0];
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
						}else{
							require_once 'public/views/error404.php';
						}
					}
				}
				if(empty($_POST)){
					// if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					// 	if(($addUrlAdmin!="" && $accesoPedidosClienteE) || $addUrlAdmin==""){
					// 		$query = "UPDATE carrito SET estatus = 0 WHERE id_carrito = $id";
					// 		$res1 = $lider->eliminar($query);
					// 		if($res1['ejecucion']==true){
					// 			$response = "11";
					// 		}else{
					// 			$response = "22"; // echo 'Error en la conexion con la bd';
					// 		}
					// 	}
					// }
					if($pedidos['ejecucion']==1){
						$pedido = $pedidos[0];
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
			}else{
				require_once 'public/views/error404.php';
			}
		}
		if($action=="Eliminar"){
			if($accesoAprobarPedidosR){
				$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_cliente = {$id_cliente} and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
				$precioTotalFactura = 0;
				$precioTotalFacturaAprobada = 0;
				foreach ($pedidosInv as $keys) { if(!empty($keys['id_pedido_inventario'])){
					// echo $keys['cantidad_solicitada']." * ".$keys['precio_inventario']."<br>";
					$precioTotalFactura += (($keys['cantidad_solicitada'])*($keys['precio_inventario']));
					$precioTotalFacturaAprobada += (($keys['cantidad_aprobada'])*($keys['precio_inventario']));
				} }
				$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_cliente and pedidos.id_ciclo = {$id_ciclo}");
				$pedidosAll = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = $id_ciclo ORDER BY pedidos.id_pedido DESC");
				$pedidosInvAll = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo}");
				if(empty($_POST)){
					if(!empty($_GET['admin'])){
						if($accesoAprobarPedidosE){
							$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo = {$id_ciclo} and id_pedido = {$id}");
							$invent = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE id_ciclo={$id_ciclo} and id_pedido={$id}");
							$error4 = 0;
							foreach ($invent as $key){ if(!empty($key['id_pedido_inventario'])){
								$nDisp = 0;
								$nBloq = 0;
								$existenciaAct = $lider->consultarQuery("SELECT * FROM existencias WHERE existencias.cod_inventario = '{$key['cod_inventario']}' and estatus=1");
								if(count($existenciaAct)>1){
									$existAct = $existenciaAct[0];
									$nDisp = $existAct['cantidad_disponible']+$key['cantidad_aprobada'];
									$nBloq = $existAct['cantidad_bloqueada']-$key['cantidad_aprobada'];
									$query = "UPDATE existencias SET cantidad_disponible={$nDisp}, cantidad_bloqueada={$nBloq} WHERE cod_inventario='{$key['cod_inventario']}' and id_existencia={$existAct['id_existencia']}";
									$exec4 = $lider->modificar($query);
									if($exec4['ejecucion']!=true){
										$error4++;
									}
								}
							} }

							$query = "UPDATE pedidos SET fecha_aprobado='', hora_aprobado='', visto_cliente=0 WHERE id_pedido={$id}";
							$exec=$lider->modificar($query);
							if($exec['ejecucion']==true){
								// $response="1";
								$query = "DELETE FROM puntos WHERE id_ciclo={$id_ciclo} and id_pedido={$id} and concepto=1";
								$exec2 = $lider->eliminar($query);
								if($exec2['ejecucion']==true){
									$response="1";
								}else{
									$response="2";
								}
								$query = "UPDATE pedidos_inventarios SET cantidad_aprobada=0 WHERE id_pedido={$id}";
								$exec3 = $lider->eliminar($query);
								if($exec3['ejecucion']==true){
									$response="1";
								}else{
									$response="2";
								}
							}else{
								$response="2";
							}
							

							if($pedidos['ejecucion']==1){
								$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
								if(!empty($action)){
									$action="Consultar";
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
						}else{
							require_once 'public/views/error404.php';
						}
					}
				}
			}else{
				require_once 'public/views/error404.php';
			}
		}
	}
}


?>