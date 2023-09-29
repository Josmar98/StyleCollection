<?php
	if(strtolower($url)=="facturacion"){
		$id_ciclo = $_GET['c'];
		$num_ciclo = $_GET['n'];
		$ano_ciclo = $_GET['y'];
		$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
		if(!empty($action)){
			$accesoFacturacionR = false;
			$accesoFacturacionC = false;
			$accesoFacturacionM = false;
			$accesoFacturacionE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos De Ciclos")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoFacturacionR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoFacturacionC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoFacturacionM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoFacturacionE=true; }
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
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoFacturacionC){
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
						$query = "SELECT * FROM clientes, pedidos, facturas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_pedido = facturas.id_pedido and pedidos.id_ciclo = {$id_ciclo} and facturas.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$pedidosFull = $lider->consultarQuery($query);
						$index = 0;
						foreach ($pedidosFull as $key) {
							if(!empty($key['id_pedido'])){
								$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
								if(count($pedidosInv)>1){
									$pedidosInvent=$pedidosInv[0];
									$pedidosFull[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
									$pedidosFull[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								}
								$index++;
							}
						}
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoFacturacionE){
							$query = "UPDATE facturas SET estatus = 0 WHERE id_factura = {$id}";
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
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$facturas = $pedidosFull;
						if($facturas['ejecucion']==1){
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
				if($accesoFacturacionC){
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
						$query = "SELECT * FROM clientes, pedidos, facturas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_pedido = facturas.id_pedido and pedidos.id_ciclo = {$id_ciclo} and facturas.estatus = 0 ORDER BY pedidos.id_pedido DESC";
						$pedidosFull = $lider->consultarQuery($query);
						$index = 0;
						foreach ($pedidosFull as $key) {
							if(!empty($key['id_pedido'])){
								$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
								if(count($pedidosInv)>1){
									$pedidosInvent=$pedidosInv[0];
									$pedidosFull[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
									$pedidosFull[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								}
								$index++;
							}
						}
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoFacturacionE){
							$query = "UPDATE facturas SET estatus = 1 WHERE id_factura = {$id}";
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
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$facturas = $pedidosFull;
						if($facturas['ejecucion']==1){
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
				if($accesoFacturacionR){
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
						$query = "SELECT * FROM clientes, pedidos WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_ciclo = {$id_ciclo} ORDER BY pedidos.id_pedido DESC";
						$pedidosFull = $lider->consultarQuery($query);
						$index = 0;
						foreach ($pedidosFull as $key) {
							if(!empty($key['id_pedido'])){
								$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$key['id_cliente']}");
								if(count($pedidosInv)>1){
									$pedidosInvent=$pedidosInv[0];
									$pedidosFull[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
									$pedidosFull[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								}
								$index++;
							}
						}
					/// PEDIDOS Y PRECIO TOTAL SOLICITADO Y PRECIO TOTAL APROBADO
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id_liderazgo = $_POST['id_liderazgo'];
							$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_ciclo = $id_ciclo and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$response = "9"; //echo "Registro ya guardado.";
									// $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
									// if($res2['ejecucion']==true){
									// 	if(Count($res2)>1){
									// 		$res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
									// 		if($res3['ejecucion']==true){
									// 			$response = "1";
									// 		}
									// 	}else{
									// 		$response = "9"; //echo "Registro ya guardado.";
									// 	}
									// }
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(!empty($_POST['pedido'])){
							$id_pedido = $_POST['pedido'];
							$forma_pago = ucwords(mb_strtolower($_POST['forma']));
							$fecha_emision = $_POST['fecha1'];
							$fecha_vencimiento = $_POST['fecha2'];
							$numero_factura = $_POST['num_factura'];
							$buscar = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} AND estatus = 1");
							if(count($buscar)>1){
								$response = "9";
							}else{
								$query = "INSERT INTO facturas (id_factura, id_ciclo, id_pedido, numero_factura, tipo_factura, fecha_emision, fecha_vencimiento, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_pedido}, {$numero_factura}, '{$forma_pago}', '{$fecha_emision}', '{$fecha_vencimiento}', 1)";
								$exec = $lider->registrar($query, "facturas", "id_factura");
								if($exec['ejecucion']==true){
									$response = "1";
									// if(!empty($modulo) && !empty($accion)){
									// 	$fecha = date('Y-m-d');
									// 	$hora = date('H:i:a');
									// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura De Despacho', 'Registrar', '{$fecha}', '{$hora}')";
									// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
									// }
								}else{
									$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
								}
							}


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
						$query = "SELECT MAX(numero_factura) FROM facturas WHERE estatus = 1";
						$factNum = $lider->consultarQuery($query);
						$factNum = $factNum[0][0];
						if($factNum==""){
							$query = "SELECT * FROM facturas WHERE estatus = 1";
							$facturasss = $lider->consultarQuery($query);
							$numero_factura = Count($facturasss);
						}else{
							$numero_factura = $factNum+1;	
						}

						$query = "SELECT * FROM pedidos, facturas WHERE pedidos.id_pedido = facturas.id_pedido and pedidos.id_ciclo = {$id_ciclo} and facturas.estatus = 1";
						$facturas = $lider->consultarQuery($query);
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
				if($accesoFacturacionM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id_liderazgo = $_POST['id_liderazgo'];
							$query = "SELECT * FROM liderazgos_ciclos WHERE id_liderazgo = $id_liderazgo and id_ciclo = $id_ciclo and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$response = "1";
								}else{
									$response = "9"; //echo "Registro ya guardado.";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(!empty($_POST['titulo'])){
							// print_r($_POST);
							$id_buscar = $_POST['id_buscar'];
							$id_liderazgo = $_POST['titulo'];
							$minima = $_POST['minima'];
							$maxima = $_POST['maxima'];
							$descuento_coleccion = (Float) $_POST['descuento_coleccion'];
							$query = "SELECT * from liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = $id_ciclo and liderazgos_ciclos.estatus = 1";
							$resp = $lider->consultarQuery($query);
							if($resp['ejecucion']){
								if(Count($resp)>1){
									$query = "SELECT * FROM liderazgos_ciclos WHERE id_ciclo = $id_ciclo and id_liderazgo = $id_buscar";
									$respon = $lider->consultarQuery($query);
									if($respon['ejecucion']){
										if(Count($respon)>1){
											$canDescuento = $respon[0]['descuento_total'];
										}else{
											$canDescuento = 0.00;
										}
									}else{
										$canDescuento = 0.00;
									}
								}else{
									$canDescuento = 0.00;
								}
								$totalDescuento = (Float) $canDescuento+$descuento_coleccion;
								$query = "UPDATE liderazgos_ciclos SET precio_minimo=$minima, precio_maximo=$maxima, descuento_liderazgos=$descuento_coleccion, descuento_total=$totalDescuento, estatus=1 WHERE id_lc = $id";		
								// echo $query;
								$exec = $lider->modificar($query);
								if($exec['ejecucion']==true){
									$response = "1";
									// if(!empty($modulo) && !empty($accion)){
									// 	$fecha = date('Y-m-d');
									// 	$hora = date('H:i:a');
									// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos De Campaña', 'Editar', '{$fecha}', '{$hora}')";
									// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
									// }
								}else{
									$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
								}
							}else{
								$response = '2';
							}

							$query = "SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1 and liderazgos_ciclos.id_lc = {$id}";
							$liderazgo=$lider->consultarQuery($query);
							if(Count($liderazgo)>1){
								$datas = $liderazgo[0];
								$idLim = $datas['id_liderazgo']-1;
								$liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1 and liderazgos_ciclos.id_liderazgo = {$idLim} ORDER BY liderazgos_ciclos.id_liderazgo ASC");
								$cant = count($liderss)-1;
								if($cant>0){
									$max = $liderss[$cant-1]['descuento_total'];
								}
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
						$query = "SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1 and liderazgos_ciclos.id_lc = {$id}";
						$liderazgo=$lider->consultarQuery($query);
						if(Count($liderazgo)>1){
							$datas = $liderazgo[0];
							$idLim = $datas['id_liderazgo']-1;
							$liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1 and liderazgos_ciclos.id_liderazgo = {$idLim} ORDER BY liderazgos_ciclos.id_liderazgo ASC");
							$cant = count($liderss)-1;
							if($cant>0){
								$max = $liderss[$cant-1]['descuento_total'];
							}
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
			if($action=="Fiscal"){
				if(!empty($_POST)){
					// registrar
					if(!empty($_POST['precio_col']) && empty($_GET['operation'])){
						$precio_col = $_POST['precio_col'];
						$buscar = $lider->consultarQuery("SELECT * FROM precio_fiscal WHERE id_ciclo = {$id_ciclo} and estatus = 1");
						if($buscar['ejecucion'] && count($buscar)>1){
							$response = "9";
						}else{
							$buscar = $lider->consultarQuery("SELECT * FROM precio_fiscal WHERE id_ciclo = {$id_ciclo} and estatus = 0");
							if($buscar['ejecucion'] && count($buscar)>1){
								$query = "UPDATE precio_fiscal SET precio_dolar_fiscal = {$precio_col}, estatus = 1 WHERE id_ciclo = {$id_ciclo}";
								$exec = $lider->modificar($query);
								if($exec['ejecucion']==true){
									$response = "1";
								}else{
									$response = "2";
								} 
							}else{
								$query = "INSERT INTO precio_fiscal (id_fiscal, id_ciclo, precio_dolar_fiscal, estatus) VALUES (DEFAULT, {$id_ciclo}, {$precio_col}, 1)";
								$exec = $lider->registrar($query, "precio_fiscal", "id_fiscal");
								if($exec['ejecucion']==true){
									$response = "1";
								}else{
									$response = "2";
								}  
							}
							// if(!empty($modulo) && !empty($accion)){
							// 	$fecha = date('Y-m-d');
							// 	$hora = date('H:i:a');
							// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Registrar', '{$fecha}', '{$hora}')";
							// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
							// }
						}

						$query = "SELECT * FROM precio_fiscal WHERE precio_fiscal.id_ciclo = {$id_ciclo}";
						$facturas = $lider->consultarQuery($query);
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
					}
					// modificar
					if(!empty($_POST['precio_col']) && !empty($_GET['operation']) && $_GET['operation']=="Modificar"){
						// print_r($_POST['precio_col']);
						$precio_col = $_POST['precio_col'];
						$query = "UPDATE precio_fiscal SET precio_dolar_fiscal = {$precio_col}, estatus = 1 WHERE id_ciclo = {$id_ciclo}";
						$exec = $lider->modificar($query);
						if($exec['ejecucion']==true){
							$response = "1";
							if(!empty($modulo) && !empty($accion)){
								$fecha = date('Y-m-d');
								$hora = date('H:i:a');
								$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Editar', '{$fecha}', '{$hora}')";
								$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
							}
						}else{
							$response = "2";
						} 
						$query = "SELECT * FROM precio_fiscal WHERE precio_fiscal.id_ciclo = {$id_ciclo}";
						$facturas = $lider->consultarQuery($query);
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
					}
				}
				if(empty($_POST)){
					if($accesoFacturacionC){
						// eliminar
						if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
							if($accesoFacturacionE){
								$query = "UPDATE precio_fiscal SET estatus = 0 WHERE id_fiscal = $id";
								$res1 = $lider->eliminar($query);
								if($res1['ejecucion']==true){
									$response = "1";
									// if(!empty($modulo) && !empty($accion)){
									// 	$fecha = date('Y-m-d');
									// 	$hora = date('H:i:a');
									// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Borrar', '{$fecha}', '{$hora}')";
									// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
									// }
								}else{
									$response = "2"; // echo 'Error en la conexion con la bd';
								}
							}
						}

						$query = "SELECT * FROM precio_fiscal WHERE id_ciclo = {$id_ciclo} and estatus = 1";
						$facturas = $lider->consultarQuery($query);
						if($facturas['ejecucion']==1){
						
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
			if($action=="Generarbs" || $action=="Generarusd" || $action=="GenerarFiscal"){
				if(empty($_POST)){
					$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, facturas WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_pedido = facturas.id_pedido and pedidos.id_ciclo = {$id_ciclo} and facturas.estatus = 1 and facturas.id_factura = {$id} ORDER BY pedidos.id_pedido DESC");
					$pedidosInv = $lider->consultarQuery("SELECT * FROM facturas, pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = facturas.id_pedido and facturas.estatus = 1 and pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and facturas.id_factura = {$id}");
					if($pedidos['ejecucion']==1){
						$pedido = $pedidos[0];

						$emision = $pedido['fecha_emision'];
						$fechaActual = date('Y-m-d');
						$tasa = 1;
						if($action=="GenerarFiscal"){
							$tasas = $lider->consultarQuery("SELECT * FROM precio_fiscal WHERE id_ciclo={$id_ciclo} and estatus = 1");
							if(count($tasas)>1){
								$tasa=$tasas[0]['precio_dolar_fiscal'];
							}
						}else{
							$tasas = $lid3r->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '{$fechaActual}'");
							if(count($tasas)>1){
								$tasa=$tasas[0]['monto_tasa'];
							}
						}
						$iva = 16;
						$num_factura = $pedido['numero_factura'];
						if(strlen($num_factura)==1){$num_factura = "00000".$num_factura;}
						else if(strlen($num_factura)==2){$num_factura = "0000".$num_factura;}
						else if(strlen($num_factura)==3){$num_factura = "000".$num_factura;}
						else if(strlen($num_factura)==4){$num_factura = "00".$num_factura;}
						else if(strlen($num_factura)==5){$num_factura = "0".$num_factura;}
						else if(strlen($num_factura)==6){$num_factura = $num_factura;}
						else{$num_factura = $num_factura;}
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