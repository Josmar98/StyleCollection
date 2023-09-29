<?php 
if(strtolower($url)=="cart"){
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
			if(!empty($_GET['op']) && $_GET['op']=="Editar"){
				$addUrlAdmin .= "&op=".$_GET['op'];
			}
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
		if($action=="Consultar"){
			$carrito = $lider->consultarQuery("SELECT * FROM inventarios, carrito WHERE inventarios.cod_inventario=carrito.cod_inventario AND inventarios.estatus=1 and carrito.estatus=1 AND carrito.id_ciclo={$id_ciclo} AND carrito.id_cliente={$id_cliente}");

			$deudaEnCiclosAnteriores = 0;
			// VERIFICAR QUE TENGA O NO DEUDA PENDIENTE EN OTRAS FACTURAS ABIERTAS
				$pedidosAnt = $lider->consultarQuery("SELECT * FROM ciclos, pedidos WHERE ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and ciclos.estatus = 1 and ciclos.estado_ciclo=1 and pedidos.id_cliente = {$id_cliente}");
				$nIndex = 0;
				foreach ($pedidosAnt as $key1) { if(!empty($key1['id_ciclo'])){
					$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$key1['id_ciclo']} and pedidos_inventarios.id_ciclo = {$key1['id_ciclo']} and pedidos.id_cliente = {$id_cliente}");
					if(count($pedidosInv)>1){
						$pedidosInvent=$pedidosInv[0];
						// $pedidosAnt[$nIndex]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
						// $pedidosAnt[$nIndex]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
						// $pedidosAnt[$nIndex]['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$key1['cantidad_cuotas'];
						$key1['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
						$key1['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
						$key1['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$key1['cantidad_cuotas'];
					}
					// CONSULTA DE PAGOS
						$pagosT=['reportado'=>0, 'abonado'=>0, 'diferido'=>0];
						$pagosTReportado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$key1['id_ciclo']} and pedidos.id_cliente = {$id_cliente}");
						$pagosT['reportado']+=$pagosTReportado[0][0];
						$pagosTAbonado = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$key1['id_ciclo']} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Abonado'");
						$pagosT['abonado']+=$pagosTAbonado[0][0];
						$pagosTDiferido = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos, pedidos WHERE pagos.id_pedido = pedidos.id_pedido and pagos.id_ciclo = {$key1['id_ciclo']} and pedidos.id_cliente = {$id_cliente} and pagos.estado='Diferido'");
						$pagosT['diferido']+=$pagosTDiferido[0][0];
					// CONSULTA DE PAGOS
					$cuotasCiclos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE pagos_ciclo.id_ciclo={$key1['id_ciclo']} and pagos_ciclo.fecha_pago_cuota <= '{$fechaActual}' ORDER BY pagos_ciclo.id_pago_ciclo DESC");
					$fechaCondicion = "";
					$cuotaPagar = 0;
					foreach ($cuotasCiclos as $key2) { if( !empty($key2['id_pago_ciclo']) ){
						$cuotaPagar += $key1['precio_cuotas'];
					} }
					// echo "PAGAR POR CUOTA: ".$key1['precio_cuotas']."<br>";
					// echo "HABER PAGADO: ".$cuotaPagar."<br>";
					// echo "ABONADO REALMENTE: ".$pagosT['abonado']."<br>";
					if($pagosT['abonado']<$cuotaPagar){
						// echo "TIENE DEUDA PENDIENTE";
						$deudaEnCiclosAnteriores++;
					}else{
						// echo "TODO BIEN";
					}
					// echo "<br>";
					$nIndex++;
				} }
			// VERIFICAR QUE TENGA O NO DEUDA PENDIENTE EN OTRAS FACTURAS ABIERTAS
			if(!empty($_POST)){
				if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
					$num = number_format($_POST['val'],2,',','.');
					echo $num;
				}
				if(!empty($_POST['cod_inventario']) && !empty($_POST['cantidad_inventario'])){
					// print_r($_POST);
					$ids=$_POST['id_carrito'];
					$cantidads=$_POST['cantidad_inventario'];
					$index=0;
					$errors = 0;
					foreach ($ids as $idCarrito) {
						$query = "UPDATE carrito SET cantidad_inventario={$cantidads[$index]} WHERE id_carrito={$ids[$index]}";
						$exec = $lider->modificar($query);
						if($exec['ejecucion']!=true){
							$errors++;
						}
						$index++;
					}
					if($errors==0){
						$response = "1";
					}else{
						$response = "2";
					}
					if($carrito['ejecucion']==1){
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
				if(!empty($_POST['solicitarPedido']) && !empty($_POST['totalFactura'])){
					if($accesoPedidosClienteR || $accesoPedidosClienteM){
						// $totalFactura = $_POST['totalFactura'];
						// $id_pedido = 1;
						$fechaActual = date('Y-m-d');
						$horaActual = date('h:ia');
						$fechaAprobado = "";
						$horaAprobado = "";
						$vistoAdmin = 1;
						$vistoCliente = 0;
						$buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente}");
						if($buscar['ejecucion']==true){
							if(count($buscar)>1){
								$busc = $buscar[0];
								$exec['id'] = $busc['id_pedido'];
								$responses = "111";
								// $query = "UPDATE pedidos SET "
							}else{
								$query = "INSERT INTO pedidos (id_pedido, id_ciclo, id_cliente, fecha_pedido, hora_pedido, fecha_aprobado, hora_aprobado, visto_admin, visto_cliente, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_cliente}, '{$fechaActual}', '{$horaActual}', '{$fechaAprobado}', '{$horaAprobado}', {$vistoAdmin}, {$vistoCliente}, 1)";
								$exec = $lider->registrar($query, "pedidos", "id_pedido");
								if($exec['ejecucion']==true){
									$responses = "11";
								}else{
									$responses = "22";
								}
							}
							if($responses=="11" || $responses=="111"){
								$id_pedido = $exec['id'];
								// MANEJO DE EXISTENCIAS --- VOLVER A COLOCAR EN DISPONIBLES LOS BLOQUEADOS DEL PEDIDO
									// $newDisponible = 0;
									// $newBloqueada = 0;
									// foreach ($carrito as $cart){ if(!empty($cart['cod_inventario'])){
									// 	$invent = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE id_ciclo={$id_ciclo} and id_pedido={$id_pedido} and cod_inventario='{$cart['cod_inventario']}'");
									// 	if(count($invent)>1){
									// 		$in = $invent[0];
									// 		$aprobada = $in['cantidad_aprobada'];
									// 		$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cart['cod_inventario']}'");
									// 		if(count($existencias)>1){
									// 			$exist=$existencias[0];
									// 			$newDisponible=$exist['cantidad_disponible']+$aprobada;
									// 			$newBloqueada=$exist['cantidad_bloqueada']-$aprobada;
									// 		}
									// 	}
									// 	$query="UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE cod_inventario='{$cart['cod_inventario']}'";
									// 	$execExist = $lider->modificar($query);
									// 	if($execExist['ejecucion']==true){
									// 		$execExists = "1";
									// 	}else{
									// 		$execExists = "1";
									// 	}
									// } }
									$newDisponible = 0;
									$newBloqueada = 0;
									foreach ($carrito as $cart){ if(!empty($cart['cod_inventario'])){
										$invent = $lider->consultarQuery("SELECT cod_inventario, SUM(cantidad_solicitada) as cantidad_solicitada, SUM(cantidad_aprobada) as cantidad_aprobada FROM pedidos_inventarios WHERE cod_inventario='{$cart['cod_inventario']}'");
										$aprobadas = 0;
										foreach ($invent as $in){ if(!empty($in['cod_inventario'])){
											$aprobadas += $in['cantidad_aprobada'];
										} }

										$canjeoss = $lider->consultarQuery("SELECT * FROM canjeos WHERE cod_inventario='{$cart['cod_inventario']}' and estatus = 1");
										$numCanjeo = 0;
										foreach ($canjeoss as $can) { if(!empty($can['id_canjeo'])){
											$numCanjeo++;
										} }
										$aprobadas+=$numCanjeo;
										// echo " | ".$cart['cod_inventario']." | ".$aprobadas."<br><br>";

										$invent = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE id_ciclo={$id_ciclo} and id_pedido={$id_pedido} and cod_inventario='{$cart['cod_inventario']}'");
										$editarExistencia = 0;
										if(count($invent)>1){
											$in = $invent[0];
											// print_r($invent);
											// echo "<br><br>";
											$aprobada = $in['cantidad_aprobada'];
											// echo $cart['nombre_inventario']." | ".$cart['cod_inventario'].": ".$aprobadas." | ".$aprobada."<br><br>";
											$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cart['cod_inventario']}' and estatus=1");
											if(count($existencias)>1){
												$exist=$existencias[0];
												$newDisponible=$exist['cantidad_total']+$exist['cantidad_exportada']-$aprobadas+$aprobada;
												$newBloqueada=$exist['cantidad_total']-$newDisponible;
												// $newDisponible=$exist['cantidad_disponible']+$aprobada;
												// $newBloqueada=$exist['cantidad_bloqueada']-$aprobada;
											}

											$editarExistencia = 1;
										}else{
											$editarExistencia = 0;
										}
										if($editarExistencia==1){
											$query="UPDATE existencias SET cantidad_disponible={$newDisponible}, cantidad_bloqueada={$newBloqueada} WHERE cod_inventario='{$cart['cod_inventario']}'";
											// echo $query."<br><br><br><br>";
											$execExist = $lider->modificar($query);
											if($execExist['ejecucion']==true){
												$execExists = "1";
											}else{
												$execExists = "1";
											}
										}
									} }
								// MANEJO DE EXISTENCIAS --- VOLVER A COLOCAR EN DISPONIBLES LOS BLOQUEADOS DEL PEDIDO

								$execDeletePoint = $lider->eliminar("DELETE FROM puntos WHERE id_pedido={$id_pedido} and concepto='1'");

								if($responses=="111"){
									$delete = $lider->eliminar("DELETE FROM pedidos_inventarios WHERE id_pedido = {$id_pedido}");
									if($delete['ejecucion']==true){
										$execs = "1";
									}else{
										$execs = "1";
									}
								}
								if($responses=="11"){
									$execs = "1";
								}
								if($execs=="1"){
									$errors=0;
									foreach ($carrito as $cart){ if(!empty($cart['cod_inventario'])){
										$query = "INSERT INTO pedidos_inventarios (id_pedido_inventario, id_ciclo, id_pedido, cod_inventario, cantidad_solicitada, cantidad_aprobada, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_pedido}, '{$cart['cod_inventario']}', '{$cart['cantidad_inventario']}', 0, 1)";
										// echo $query."<br><br>";
										$exec2 = $lider->registrar($query, "pedidos", "id_pedido");
										if($exec2['ejecucion']!=true){
											$errors++;
										}
									} }

								}
								if($errors==0){
									$response = "1111";
								}else{
									$response = "2222";
								}
							}else{
								$response = "2222";
							}
						}else{
							$response = "5555";
						}
						
						// die();
						if($carrito['ejecucion']==1){
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
				if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
					if(($addUrlAdmin!="" && $accesoPedidosClienteE) || $addUrlAdmin==""){
						$query = "UPDATE carrito SET estatus = 0 WHERE id_carrito = $id";
						$res1 = $lider->eliminar($query);
						if($res1['ejecucion']==true){
							$response = "11";
						}else{
							$response = "22"; // echo 'Error en la conexion con la bd';
						}
					}
				}
				if($carrito['ejecucion']==1){
					$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente}");
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					
					$notaExistente = 0;
					if(!empty($_GET['lider'])){
						$notaExist = $lider->consultarQuery("SELECT * FROM notas,pedidos WHERE notas.id_pedido = pedidos.id_pedido and notas.id_ciclo={$id_ciclo} and pedidos.id_ciclo={$id_ciclo} and pedidos.id_cliente={$_GET['lider']} and notas.estatus=1 and pedidos.estatus=1");
						if(count($notaExist)>1){
							$notaExistente = 1;
						}else{
							$notaExistente = 0;
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
	}
}


?>