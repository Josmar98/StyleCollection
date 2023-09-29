<?php
	if(strtolower($url)=="notas"){
		$id_ciclo = $_GET['c'];
		$num_ciclo = $_GET['n'];
		$ano_ciclo = $_GET['y'];
		$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
		if(!empty($action)){
			$accesoNotasR = false;
			$accesoNotasC = false;
			$accesoNotasM = false;
			$accesoNotasE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Notas")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoNotasR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoNotasC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoNotasM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoNotasE=true; }
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
			$pagosCiclos = $lider->consultarQuery("SELECT * FROM ciclos, pagos_ciclo WHERE ciclos.id_ciclo = pagos_ciclo.id_ciclo and ciclos.id_ciclo = {$id_ciclo}");
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoNotasC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoNotasE){
							$notas = $lider->consultarQuery("SELECT * FROM notas WHERE id_nota={$id} and estatus=1");
							if(count($notas)>1){
								$nota = $notas[0];
								$id_pedido = $nota['id_pedido'];
								
								// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
									$opcinesEntrega = $lider->consultarQuery("SELECT * FROM opciones_nota WHERE id_nota = {$id}");

									$numeroNota = $nota['numero_nota'];
									$numFactura = "";
									$pedido = [];
									$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} and estatus = 1");
									if(count($factura)>1){
										$numFactura = $factura[0]['numero_factura'];
										switch (strlen($factura[0]['numero_factura'])) {
											case 1:
												$numFactura = "00000".$factura[0]['numero_factura'];
												break;
											case 2:
												$numFactura = "0000".$factura[0]['numero_factura'];
												break;
											case 3:
												$numFactura = "000".$factura[0]['numero_factura'];
												break;
											case 4:
												$numFactura = "00".$factura[0]['numero_factura'];
												break;
											case 5:
												$numFactura = "0".$factura[0]['numero_factura'];
												break;
											case 6:
												$numFactura = "".$factura[0]['numero_factura'];
												break;
										}
									}
									$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$id_pedido} and ciclos.id_ciclo = {$id_ciclo}");
									if(Count($pedidos)>1){
										$pedido = $pedidos[0];
										$id_pedido = $pedido['id_pedido'];
										$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
										if(count($pedidosInv)>1){
											$pedidosInvent=$pedidosInv[0];
											$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
											$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
											$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
										}
									}
									$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo}");
									$nIndex = 0;
									$canjeosPedidos=[];
									foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
										$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}'");
										$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
										$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
										$canjeosPedidos[$nIndex]['cantidad']=0;
										foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
											if($key['cod_inventario']==$key2['cod_inventario']){
												$canjeosPedidos[$nIndex]['cantidad']+=1;
											}
										} }
										$nIndex++;
									} }
								// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$data = [];
								foreach ($pedidosInv as $key){ if(!empty($key['cod_inventario'])){
									if(!empty($data[$key['cod_inventario']])){
										$data[$key['cod_inventario']]['cantidad']+=$key['cantidad_aprobada'];
									}else{
										$data[$key['cod_inventario']]['cod_inventario']=$key['cod_inventario'];
										$data[$key['cod_inventario']]['cantidad']=$key['cantidad_aprobada'];
									}
									// echo " | ".$key['cod_inventario']." | ".$key['cantidad_aprobada']." | "."<br><br>";
								} }
								foreach ($canjeosPedidos as $key){ if(!empty($key['cod_inventario'])){
									// echo " | ".$key['cod_inventario']." | ".$key['cantidad']." | "."<br><br>";
									if(!empty($data[$key['cod_inventario']])){
										$data[$key['cod_inventario']]['cantidad']+=$key['cantidad'];
									}else{
										$data[$key['cod_inventario']]['cod_inventario']=$key['cod_inventario'];
										$data[$key['cod_inventario']]['cantidad']=$key['cantidad'];
									}
								} }

								$errors = 0;
								foreach ($data as $key) {
									$cod = $key['cod_inventario'];
									$cant = $key['cantidad'];
									$existencia = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$cod}' and estatus=1");
									if(count($existencia)>1){
										$existencia=$existencia[0];
										$id_existencia = $existencia['id_existencia'];
										$total = $existencia['cantidad_total'];
										$bloqueado = $existencia['cantidad_bloqueada'];
										$exportado = $existencia['cantidad_exportada'];
										// echo "<br>"."CODIGO: ".$cod." | Cantidad: ".$cant." | "."<br>"."Actual TOTAL: ".$total." | "."Actual Bloqueado: ".$bloqueado." | "."Actual Exportado: ".$exportado." | ";
										$total += $cant;
										$bloqueado += $cant;
										$exportado -= $cant;
										// echo "<br>"."Nuevo TOTAL: ".$total." | "."Nuevo Bloqueado: ".$bloqueado." | "."Nuevo Exportado: ".$exportado." | "."<br>";

										$query = "UPDATE existencias SET cantidad_total={$total}, cantidad_bloqueada={$bloqueado}, cantidad_exportada={$exportado} WHERE id_existencia={$id_existencia}";
										$exec = $lider->modificar($query);
										if($exec['ejecucion']!=true){
											$errors++;
										}
										// echo $query."<br>";
										// echo "<br>";
									}
								}
								if($errors==0){
									$query = "UPDATE notas SET estatus = 0 WHERE id_nota = $id";
									$res1 = $lider->eliminar($query);
									if($res1['ejecucion']==true){
										$response = "1";
									}else{
										$response = "2"; // echo 'Error en la conexion con la bd';
									}
								}else{
									$response="2";
								}
							}else{
								$response="2";
							}
							// die();
						}
					}
					if(empty($_POST)){
						$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

						$notas = $lider->consultarQuery("SELECT * FROM notas, pedidos, clientes WHERE notas.id_pedido=pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente and clientes.estatus=1 and notas.estatus=1 and notas.id_ciclo = {$id_ciclo}");
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
			if($action=="Borrados"){
				if($accesoNotasC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoNotasE){
							$query = "UPDATE notas SET estatus = 1 WHERE id_nota = $id";
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
						// $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

						$notas = $lider->consultarQuery("SELECT * FROM notas, pedidos, clientes WHERE notas.id_pedido=pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente and clientes.estatus=1 and notas.estatus=0 and notas.id_ciclo = {$id_ciclo}");
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
			if($action=="Registrar"){
				if($accesoNotasR){
					if(!empty($_POST)){
						if(!empty($_POST['validarDataNota'])){
							$id_pedido = $_POST['id_pedido'];
							$query = "SELECT * FROM notas WHERE id_pedido = $id_pedido and id_ciclo = $id_ciclo and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$response = "9"; //echo "Registro ya guardado.";
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if (!empty($_POST['direccion_emision']) && !empty($_POST['id_cliente']) ) {
							// print_r($_POST);
							$direccion = mb_strtoupper($_POST['direccion_emision']);
							$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
							$fecha = $_POST['fecha_emision'];
							$num = $_POST['numero'];
							$id_lider = $_POST['id_cliente'];
							$id_pedido = $_GET['pedido'];
							// $pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
							// $id_pedido = $pedidoss[0]['id_pedido'];
							$opts = [];
							if(!empty($_POST['opts'])){
								$opts = $_POST['opts'];
							}
							$max = count($opts);



							$query = "INSERT INTO notas (id_nota, id_ciclo, id_pedido, direccion_emision, lugar_emision, fecha_emision, numero_nota, estatus) VALUES (DEFAULT, {$id_ciclo}, {$id_pedido}, '{$direccion}', '{$lugar}', '{$fecha}', {$num}, 1)";
							$exec = $lider->registrar($query, "notas", "id_nota");
							if($exec['ejecucion']==true){
								$id_nota = $exec['id'];
								$nume = 0;
								foreach ($opts as $cod => $val) {
									$query2 = "INSERT INTO opciones_nota (id_opcion_nota, id_nota, cod, val, estatus) VALUES (DEFAULT, {$id_nota}, '{$cod}', '{$val}', 1)";
									$exec2 = $lider->registrar($query2, "opciones_nota", "id_opcion_nota");
									if($exec2['ejecucion']==true){
										$responses2[$nume] = 1;
									}else{
										$responses2[$nume] = 2;
									}
									$nume++;
								}
								$sum = 0;
								foreach ($responses2 as $key) {
									$sum += $key;
								}
								if($sum == $max){
									$response = "1";
									$existencias = $lider->consultarQuery("SELECT * FROM existencias WHERE estatus = 1");
									foreach($existencias as $exist){ if(!empty($exist['id_existencia'])){
										$codInventario = $exist['cod_inventario'];
										$inventarios = $lider->consultarQuery("SELECT * FROM pedidos_inventarios WHERE id_pedido = {$id_pedido} and cod_inventario='{$codInventario}'");
										$cantidadAExportar=0;
										foreach ($inventarios as $pedInv){ if(!empty($pedInv['id_pedido_inventario'])){
											$cantidadAExportar += $pedInv['cantidad_aprobada'];
										} }
										$existenciasss = $lider->consultarQuery("SELECT * FROM existencias WHERE cod_inventario='{$codInventario}' and estatus=1");
										if(count($existenciasss)>1){
											$existt = $existenciasss[0];
											$canjeoss = $lider->consultarQuery("SELECT * FROM canjeos WHERE id_cliente={$id_lider} and id_ciclo={$id_ciclo} and cod_inventario='{$codInventario}' and estatus = 1");
											$numCanjeo = 0;
											foreach ($canjeoss as $can) { if(!empty($can['id_canjeo'])){
												$numCanjeo++;
											} }
											$cantidadAExportar+=$numCanjeo;
											$newExistenciaTotal = $exist['cantidad_total']-$cantidadAExportar;
											$newExistenciaDisponible = $exist['cantidad_disponible'];
											$newExistenciaBloqueada = $exist['cantidad_bloqueada']-$cantidadAExportar;
											$newExistenciaExportada = $exist['cantidad_exportada']+$cantidadAExportar;

											$query = "UPDATE existencias SET cantidad_total={$newExistenciaTotal}, cantidad_bloqueada={$newExistenciaBloqueada}, cantidad_exportada={$newExistenciaExportada} WHERE id_existencia = {$exist['id_existencia']}";
											// echo $query."<br><br>";
											$exec2 = $lider->modificar($query);
											if($exec2['ejecucion']==true){
												$response="1";
											}else{
												$response="2";
											}

											// echo "CODIGO Inventario: ".$codInventario." <br> ";
											// echo "Cantidad A Exportar: ".$cantidadAExportar;
											// echo " <br> ============================================== <br> ";
											// echo " ------- EXISTENCIA ACTUAL ------- <br>";
											// echo "Existencia Total: ".$exist['cantidad_total']." <br> ";
											// echo "Existencia Disponible: ".$exist['cantidad_disponible']." <br> ";
											// echo "Existencia Bloqueada: ".$exist['cantidad_bloqueada']." <br> ";
											// echo "Existencia Exportada: ".$exist['cantidad_exportada']." <br> ";
											// echo "Existencia ID: ".$exist['id_existencia'];
											// echo " <br> ============================================== <br> ";
											// echo " ------- EXISTENCIA NUEVA ------- <br>";
											// echo "Existencia Total: ".$newExistenciaTotal." <br> ";
											// echo "Existencia Disponible: ".$newExistenciaDisponible." <br> ";
											// echo "Existencia Bloqueada: ".$newExistenciaBloqueada." <br> ";
											// echo "Existencia Exportada: ".$newExistenciaExportada." <br> ";
											// echo "Existencia ID: ".$exist['id_existencia'];
											// echo " <br> ============================================== <br> ";
											// echo "<br><br><br>";
										}
									} }
									
								}else{
									$response = "2";
								}
							}else{
								$response = "2";
							}

							// ----- ANTES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$pedidosNotas = [];
								$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and ciclos.estatus=1 and clientes.estatus=1 and pedidos.estatus=1 and ciclos.id_ciclo={$id_ciclo}");
								$index = 0;
								$index2 = 0;
								$ultimaCuota = [];
								$numCuota=1;
								foreach ($pagosCiclos as $key){ if(!empty($key['id_ciclo'])){
									if($key['fecha_pago_cuota']<=$fechaActual){
										$ultimaCuota = $key;
										$ultimaCuota['numero'] = $numCuota;
									}
									$numCuota++;
								} }
								if(mb_strtolower($ultimaCuota['opcion_ciclo'])==mb_strtolower("Nota")){
									foreach ($pedidos as $key){ if(!empty($key['id_pedido'])){
										$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$key['id_pedido']}");
										if(count($pedidosInv)>1){
											$pedidosInvent=$pedidosInv[0];
											$pedidos[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
											$pedidos[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
											$pedidos[$index]['precio_cuotas']=$pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
										}
										if($pedidos[$index]['cantidad_aprobada']>0){
											$nAbonadoPuntual = 0;
											$pagos = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos WHERE pagos.id_pedido = {$pedidos[$index]['id_pedido']} and pagos.estado='Abonado' and pagos.estatus = 1 and pagos.fecha_pago <= '{$ultimaCuota['fecha_pago_cuota']}'");
											$nPrecioCuota = $pedidos[$index]['precio_cuotas']*$ultimaCuota['numero'];
											$nAbonadoPuntual += $pagos[0][0];
											// if($nAbonadoPuntual>0){
											// 	$nAbonadoPuntual*=4;
											// }
											if($nPrecioCuota<=$nAbonadoPuntual){
												$pedidos[$index]['alDia'] = 1;
											}else{
												$pedidos[$index]['alDia'] = 0;
											}
											// echo $pedidos[$index]['id_pedido']." | ";
											// echo $pedidos[$index]['id_cliente']." | ";
											// echo $ultimaCuota['numero_cuota']." | ".$ultimaCuota['fecha_pago_cuota']." | ";
											// echo $pedidos[$index]['alDia']." | ";
											// echo $nPrecioCuota." | ";
											// echo $nAbonadoPuntual." | ";
											// echo "<br>";
											$pedidosNotas[$index2] = $pedidos[$index];
											$index2++;
										}
										$index++;
									} }
								}
							// ----- ANTES DE SELECCIOANR EL PEDIDO ---------------------------------------
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$numeroNota = 0;
								$notasEntregas = $lider->consultarQuery("SELECT MAX(notas.numero_nota) FROM notas WHERE estatus=1");
								if( count($notasEntregas)>1 ){
									$numeroNota += $notasEntregas[0][0];
									$numeroNota += 1;
								}
								$numFactura = "";
								$pedido = [];
								if(!empty($_GET['pedido'])){
									$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$_GET['pedido']} and estatus = 1");
									if(count($factura)>1){
										$numFactura = $factura[0]['numero_factura'];
										switch (strlen($factura[0]['numero_factura'])) {
											case 1:
												$numFactura = "00000".$factura[0]['numero_factura'];
												break;
											case 2:
												$numFactura = "0000".$factura[0]['numero_factura'];
												break;
											case 3:
												$numFactura = "000".$factura[0]['numero_factura'];
												break;
											case 4:
												$numFactura = "00".$factura[0]['numero_factura'];
												break;
											case 5:
												$numFactura = "0".$factura[0]['numero_factura'];
												break;
											case 6:
												$numFactura = "".$factura[0]['numero_factura'];
												break;
										}
									}
									$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$_GET['pedido']} and ciclos.id_ciclo = {$id_ciclo}");
									if(Count($pedidos)>1){
										$pedido = $pedidos[0];
										$id_pedido = $pedido['id_pedido'];
										$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
										if(count($pedidosInv)>1){
											$pedidosInvent=$pedidosInv[0];
											$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
											$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
											$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
										}
										$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} AND clientes.id_cliente={$pedido['id_cliente']}");
										$nIndex = 0;
										$canjeosPedidos=[];
										foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
											$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}' AND clientes.id_cliente={$pedido['id_cliente']}");
											$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
											$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
											$canjeosPedidos[$nIndex]['cantidad']=0;
											foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
												if($key['cod_inventario']==$key2['cod_inventario']){
													$canjeosPedidos[$nIndex]['cantidad']+=1;
												}
											} }
											$nIndex++;
										} }
									}
								}
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
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

						// ----- ANTES DE SELECCIOANR EL PEDIDO ---------------------------------------
							$pedidosNotas = [];
							$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_ciclo = ciclos.id_ciclo and ciclos.estatus=1 and clientes.estatus=1 and pedidos.estatus=1 and ciclos.id_ciclo={$id_ciclo}");
							$index = 0;
							$index2 = 0;
							$ultimaCuota = [];
							$numCuota=1;
							foreach ($pagosCiclos as $key){ if(!empty($key['id_ciclo'])){
								if($key['fecha_pago_cuota']<=$fechaActual){
									$ultimaCuota = $key;
									$ultimaCuota['numero'] = $numCuota;
								}
								$numCuota++;
							} }
							if(mb_strtolower($ultimaCuota['opcion_ciclo'])==mb_strtolower("Nota")){
								foreach ($pedidos as $key){ if(!empty($key['id_pedido'])){
									$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$key['id_pedido']}");
									if(count($pedidosInv)>1){
										$pedidosInvent=$pedidosInv[0];
										$pedidos[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
										$pedidos[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
										$pedidos[$index]['precio_cuotas']=$pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
									}
									if($pedidos[$index]['cantidad_aprobada']>0){
										$nAbonadoPuntual = 0;
										$pagos = $lider->consultarQuery("SELECT SUM(pagos.equivalente_pago) FROM pagos WHERE pagos.id_pedido = {$pedidos[$index]['id_pedido']} and pagos.estado='Abonado' and pagos.estatus = 1 and pagos.fecha_pago <= '{$ultimaCuota['fecha_pago_cuota']}'");
										$nPrecioCuota = $pedidos[$index]['precio_cuotas']*$ultimaCuota['numero'];
										$nAbonadoPuntual += $pagos[0][0];
										// if($nAbonadoPuntual>0){
										// 	$nAbonadoPuntual*=4;
										// }
										if($nPrecioCuota<=$nAbonadoPuntual){
											$pedidos[$index]['alDia'] = 1;
										}else{
											$pedidos[$index]['alDia'] = 0;
										}
										// echo $pedidos[$index]['id_pedido']." | ";
										// echo $pedidos[$index]['id_cliente']." | ";
										// echo $ultimaCuota['numero_cuota']." | ".$ultimaCuota['fecha_pago_cuota']." | ";
										// echo $pedidos[$index]['alDia']." | ";
										// echo $nPrecioCuota." | ";
										// echo $nAbonadoPuntual." | ";
										// echo "<br>";
										$pedidosNotas[$index2] = $pedidos[$index];
										$index2++;
									}
									$index++;
								} }
							}
							$notas = $lider->consultarQuery("SELECT * FROM notas, pedidos, clientes WHERE notas.id_pedido=pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente and clientes.estatus=1 and notas.estatus=1 and notas.id_ciclo = {$id_ciclo}");
						// ----- ANTES DE SELECCIOANR EL PEDIDO ---------------------------------------
						
						// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
							$numeroNota = 0;
							$notasEntregas = $lider->consultarQuery("SELECT MAX(notas.numero_nota) FROM notas WHERE estatus=1");
							if( count($notasEntregas)>1 ){
								$numeroNota += $notasEntregas[0][0];
								$numeroNota += 1;
							}
							$numFactura = "";
							$pedido = [];
							if(!empty($_GET['pedido'])){
								$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$_GET['pedido']} and estatus = 1");
								if(count($factura)>1){
									$numFactura = $factura[0]['numero_factura'];
									switch (strlen($factura[0]['numero_factura'])) {
										case 1:
											$numFactura = "00000".$factura[0]['numero_factura'];
											break;
										case 2:
											$numFactura = "0000".$factura[0]['numero_factura'];
											break;
										case 3:
											$numFactura = "000".$factura[0]['numero_factura'];
											break;
										case 4:
											$numFactura = "00".$factura[0]['numero_factura'];
											break;
										case 5:
											$numFactura = "0".$factura[0]['numero_factura'];
											break;
										case 6:
											$numFactura = "".$factura[0]['numero_factura'];
											break;
									}
								}
								$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$_GET['pedido']} and ciclos.id_ciclo = {$id_ciclo}");
								if(Count($pedidos)>1){
									$pedido = $pedidos[0];
									$id_pedido = $pedido['id_pedido'];
									$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
									if(count($pedidosInv)>1){
										$pedidosInvent=$pedidosInv[0];
										$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
										$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
										$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
									}
									$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} AND clientes.id_cliente={$pedido['id_cliente']}");
									$nIndex = 0;
									$canjeosPedidos=[];
									foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
										$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}' AND clientes.id_cliente={$pedido['id_cliente']}");
										$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
										$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
										$canjeosPedidos[$nIndex]['cantidad']=0;
										foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
											if($key['cod_inventario']==$key2['cod_inventario']){
												$canjeosPedidos[$nIndex]['cantidad']+=1;
											}
										} }
										$nIndex++;
									} }
								}
							}
						// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------

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
				if($accesoNotasM){
					if(!empty($_POST)){
						if(!empty($_POST['validarDataNota'])){
							$id_pedido = $_POST['id_pedido'];
							$query = "SELECT * FROM notas WHERE id_pedido = $id_pedido and id_ciclo = $id_ciclo and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									if($res1[0]['id_nota']==$id){
										$response = "1";
									}else{
										$response = "9"; //echo "Registro ya guardado.";
									}
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if (!empty($_POST['direccion_emision']) && !empty($_POST['id_cliente']) ) {
							$direccion = mb_strtoupper($_POST['direccion_emision']);
							$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
							$fecha = $_POST['fecha_emision'];
							$num = $_POST['numero'];
							$id_lider = $_POST['id_cliente'];
							$id_pedido = $_POST['id_pedido'];
							$opts = [];
							if(!empty($_POST['opts'])){
								$opts = $_POST['opts'];
							}
							$max = count($opts);
							$query = "UPDATE notas SET direccion_emision='{$direccion}', lugar_emision='{$lugar}', fecha_emision='{$fecha}', numero_nota={$num} WHERE id_nota = {$id}";
							$exec = $lider->modificar($query);
							$responses2 = [];
							if($exec['ejecucion']==true){
								$nume = 0;
								$execc = $lider->eliminar("DELETE FROM opciones_nota WHERE id_nota={$id}");
								if($execc['ejecucion']==true){
									foreach ($opts as $cod => $val) {
										$query2 = "INSERT INTO opciones_nota (id_opcion_nota, id_nota, cod, val, estatus) VALUES (DEFAULT, {$id}, '{$cod}', '{$val}', 1)";
										$exec2 = $lider->registrar($query2, "opciones_nota", "id_opcion_nota");
										if($exec2['ejecucion']==true){
											$responses2[$nume] = 1;
										}else{
											$responses2[$nume] = 2;
										}
										$nume++;
									}
									$sum = 0;
									foreach ($responses2 as $key) {
										$sum += $key;
									}
									if($sum == $max){
										$response = "1";
									}else{
										$response = "2";
									}
								}else{
									$response = "2";
								}
							}else{
								$response = "2";
							}


							$notas = $lider->consultarQuery("SELECT * FROM notas WHERE id_nota={$id}");
							if(count($notas)>1){
								$nota = $notas[0];
								$id_pedido = $nota['id_pedido'];
								
								// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
									$opcinesEntrega = $lider->consultarQuery("SELECT * FROM opciones_nota WHERE id_nota = {$id}");
									
									$numeroNota = $nota['numero_nota'];
									$numFactura = "";
									$pedido = [];
									$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} and estatus = 1");
									if(count($factura)>1){
										$numFactura = $factura[0]['numero_factura'];
										switch (strlen($factura[0]['numero_factura'])) {
											case 1:
												$numFactura = "00000".$factura[0]['numero_factura'];
												break;
											case 2:
												$numFactura = "0000".$factura[0]['numero_factura'];
												break;
											case 3:
												$numFactura = "000".$factura[0]['numero_factura'];
												break;
											case 4:
												$numFactura = "00".$factura[0]['numero_factura'];
												break;
											case 5:
												$numFactura = "0".$factura[0]['numero_factura'];
												break;
											case 6:
												$numFactura = "".$factura[0]['numero_factura'];
												break;
										}
									}
									$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$id_pedido} and ciclos.id_ciclo = {$id_ciclo}");
									if(Count($pedidos)>1){
										$pedido = $pedidos[0];
										$id_pedido = $pedido['id_pedido'];
										$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
										if(count($pedidosInv)>1){
											$pedidosInvent=$pedidosInv[0];
											$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
											$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
											$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
										}
									}
									$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo}");
									$nIndex = 0;
									$canjeosPedidos=[];
									foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
										$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}'");
										$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
										$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
										$canjeosPedidos[$nIndex]['cantidad']=0;
										foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
											if($key['cod_inventario']==$key2['cod_inventario']){
												$canjeosPedidos[$nIndex]['cantidad']+=1;
											}
										} }
										$nIndex++;
									} }
								// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
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
						$notas = $lider->consultarQuery("SELECT * FROM notas WHERE id_nota={$id}");
						if(count($notas)>1){
							$nota = $notas[0];
							$id_pedido = $nota['id_pedido'];
							
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$opcinesEntrega = $lider->consultarQuery("SELECT * FROM opciones_nota WHERE id_nota = {$id}");

								$numeroNota = $nota['numero_nota'];
								$numFactura = "";
								$pedido = [];
								$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} and estatus = 1");
								if(count($factura)>1){
									$numFactura = $factura[0]['numero_factura'];
									switch (strlen($factura[0]['numero_factura'])) {
										case 1:
											$numFactura = "00000".$factura[0]['numero_factura'];
											break;
										case 2:
											$numFactura = "0000".$factura[0]['numero_factura'];
											break;
										case 3:
											$numFactura = "000".$factura[0]['numero_factura'];
											break;
										case 4:
											$numFactura = "00".$factura[0]['numero_factura'];
											break;
										case 5:
											$numFactura = "0".$factura[0]['numero_factura'];
											break;
										case 6:
											$numFactura = "".$factura[0]['numero_factura'];
											break;
									}
								}
								$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$id_pedido} and ciclos.id_ciclo = {$id_ciclo}");
								if(Count($pedidos)>1){
									$pedido = $pedidos[0];
									$id_pedido = $pedido['id_pedido'];
									$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
									if(count($pedidosInv)>1){
										$pedidosInvent=$pedidosInv[0];
										$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
										$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
										$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
									}
								}
								$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo}");
								$nIndex = 0;
								$canjeosPedidos=[];
								foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
									$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}'");
									$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
									$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
									$canjeosPedidos[$nIndex]['cantidad']=0;
									foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
										if($key['cod_inventario']==$key2['cod_inventario']){
											$canjeosPedidos[$nIndex]['cantidad']+=1;
										}
									} }
									$nIndex++;
								} }
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
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
			if($action=="Ver"){
				if($accesoNotasC){
					if(empty($_POST)){
						$notas = $lider->consultarQuery("SELECT * FROM notas WHERE id_nota={$id}");
						if(count($notas)>1){
							$nota = $notas[0];
							$id_pedido = $nota['id_pedido'];
							
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$opcinesEntrega = $lider->consultarQuery("SELECT * FROM opciones_nota WHERE id_nota = {$id}");

								$numeroNota = $nota['numero_nota'];
								$numFactura = "";
								$pedido = [];
								$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} and estatus = 1");
								if(count($factura)>1){
									$numFactura = $factura[0]['numero_factura'];
									switch (strlen($factura[0]['numero_factura'])) {
										case 1:
											$numFactura = "00000".$factura[0]['numero_factura'];
											break;
										case 2:
											$numFactura = "0000".$factura[0]['numero_factura'];
											break;
										case 3:
											$numFactura = "000".$factura[0]['numero_factura'];
											break;
										case 4:
											$numFactura = "00".$factura[0]['numero_factura'];
											break;
										case 5:
											$numFactura = "0".$factura[0]['numero_factura'];
											break;
										case 6:
											$numFactura = "".$factura[0]['numero_factura'];
											break;
									}
								}
								$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$id_pedido} and ciclos.id_ciclo = {$id_ciclo}");
								if(Count($pedidos)>1){
									$pedido = $pedidos[0];
									$id_pedido = $pedido['id_pedido'];
									$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
									if(count($pedidosInv)>1){
										$pedidosInvent=$pedidosInv[0];
										$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
										$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
										$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
									}
								}
								$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo}");
								$nIndex = 0;
								$canjeosPedidos=[];
								foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
									$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}'");
									$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
									$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
									$canjeosPedidos[$nIndex]['cantidad']=0;
									foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
										if($key['cod_inventario']==$key2['cod_inventario']){
											$canjeosPedidos[$nIndex]['cantidad']+=1;
										}
									} }
									$nIndex++;
								} }
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
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
			if($action=="GenerarPDF"){
				if($accesoNotasC){
					if(empty($_POST)){
						$notas = $lider->consultarQuery("SELECT * FROM notas WHERE id_nota={$id}");
						if(count($notas)>1){
							$nota = $notas[0];
							$id_pedido = $nota['id_pedido'];
							
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
								$opcinesEntrega = $lider->consultarQuery("SELECT * FROM opciones_nota WHERE id_nota = {$id}");

								$numeroNota = $nota['numero_nota'];
								$numFactura = "";
								$pedido = [];
								$factura = $lider->consultarQuery("SELECT * FROM facturas WHERE id_pedido = {$id_pedido} and estatus = 1");
								if(count($factura)>1){
									$numFactura = $factura[0]['numero_factura'];
									switch (strlen($factura[0]['numero_factura'])) {
										case 1:
											$numFactura = "00000".$factura[0]['numero_factura'];
											break;
										case 2:
											$numFactura = "0000".$factura[0]['numero_factura'];
											break;
										case 3:
											$numFactura = "000".$factura[0]['numero_factura'];
											break;
										case 4:
											$numFactura = "00".$factura[0]['numero_factura'];
											break;
										case 5:
											$numFactura = "0".$factura[0]['numero_factura'];
											break;
										case 6:
											$numFactura = "".$factura[0]['numero_factura'];
											break;
									}
									switch (strlen($nota['numero_nota'])) {
										case 1:
											$numeroNota = "000000".$nota['numero_nota'];
											break;
										case 2:
											$numeroNota = "00000".$nota['numero_nota'];
											break;
										case 3:
											$numeroNota = "0000".$nota['numero_nota'];
											break;
										case 4:
											$numeroNota = "000".$nota['numero_nota'];
											break;
										case 5:
											$numeroNota = "00".$nota['numero_nota'];
											break;
										case 6:
											$numeroNota = "0".$nota['numero_nota'];
											break;
										case 7:
											$numeroNota = "".$nota['numero_nota'];
											break;
										default:
											$numeroNota = "".$nota['numero_nota'];
											break;
									}
								}
								$pedidos = $lider->consultarQuery("SELECT * FROM ciclos, pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and ciclos.estatus = 1 and ciclos.id_ciclo = pedidos.id_ciclo and pedidos.estatus = 1 and pedidos.id_pedido = {$id_pedido} and ciclos.id_ciclo = {$id_ciclo}");
								if(Count($pedidos)>1){
									$pedido = $pedidos[0];
									$id_pedido = $pedido['id_pedido'];
									$pedidosInv = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_cliente = {$pedido['id_cliente']}");
									if(count($pedidosInv)>1){
										$pedidosInvent=$pedidosInv[0];
										$pedido['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
										$pedido['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
										$pedido['precio_cuotas'] = $pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
									}
								}
								$canjeosPedidosName = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo}");
								$nIndex = 0;
								$canjeosPedidos=[];
								foreach ($canjeosPedidosName as $key){ if(!empty($key['cod_inventario'])){
									$canjeosPedidoss = $lider->consultarQuery("SELECT * FROM inventarios, canjeos, clientes WHERE inventarios.cod_inventario=canjeos.cod_inventario and canjeos.id_cliente = clientes.id_cliente and inventarios.estatus=1 and canjeos.estatus =1 and clientes.estatus=1 and canjeos.id_ciclo={$id_ciclo} and inventarios.cod_inventario='{$key['cod_inventario']}'");
									$canjeosPedidos[$nIndex]['cod_inventario']=$key['cod_inventario'];
									$canjeosPedidos[$nIndex]['nombre_inventario']=$key['nombre_inventario'];
									$canjeosPedidos[$nIndex]['cantidad']=0;
									foreach ($canjeosPedidoss as $key2){ if(!empty($key2['cod_inventario'])){
										if($key['cod_inventario']==$key2['cod_inventario']){
											$canjeosPedidos[$nIndex]['cantidad']+=1;
										}
									} }
									$nIndex++;
								} }
							// ----- DESPUES DE SELECCIOANR EL PEDIDO ---------------------------------------
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
	function separateDatosCuentaTel($num){
		// echo $num[0];
		// echo strlen($num);
		$set = 0;
		$newNum = '';
		for ($i=0; $i < strlen($num); $i++) { 
			if($i==4){
				$newNum .= '-';
			}
			if($i==7){
				$newNum .= '-';
			}
			if($i==9){
				$newNum .= '-';
			}
			$newNum .= $num[$i];
		}
		return $newNum;
	}
?>