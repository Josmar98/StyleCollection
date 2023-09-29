<?php 
	$configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones");
	$seleccionAdmin = 0;
	if(Count($configuraciones)>1){
		foreach ($configuraciones as $keys) {
			if(!empty($keys['id_configuracion'])){
				if($keys['clausula']=="Seleccion Admin"){
					$seleccionAdmin = $keys['valor'];
				}
			}
		}
	}

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";



	// if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" ){
	// 	$campanas=$lider->consultar("campanas");
	// }else{
	// 	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1");
	// }

	// print_r($_POST);
$_SESSION['tomandoEnCuentaLiderazgo'] = "1"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
$_SESSION['tomandoEnCuentaDistribucion'] = "0"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
// if($_SESSION['nombre_rol']!="Vendedor")

$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
	$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
	$accesoBloqueo = "0";
	$superAnalistaBloqueo="1";
	$analistaBloqueo="1";
	foreach ($configuraciones as $config) {
		if(!empty($config['id_configuracion'])){
			if($config['clausula']=='Analistabloqueolideres'){
				$analistaBloqueo = $config['valor'];
			}
			if($config['clausula']=='Superanalistabloqueolideres'){
				$superAnalistaBloqueo = $config['valor'];
			}
		}
	}
	if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
	if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

	if($accesoBloqueo=="0"){
	// echo "Acceso Abierto";
	}
	if($accesoBloqueo=="1"){
	// echo "Acceso Restringido";
	$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
	}

	// echo " - ID: ".$id." - ";
	$permitir = "1";
	if($accesoBloqueo=="1"){
		$permitir = "0";
		if(Count($pedidos)>1){
			$pedido=$pedidos[0];
			if(!empty($accesosEstructuras)){
				foreach ($accesosEstructuras as $struct) {
					if(!empty($struct['id_cliente'])){
						// echo "<br> Struct: ".$struct['id_cliente']."";
						if($struct['id_cliente']==$pedido['id_cliente']){
							$permitir = "1";
						}
					}
				}
			}
		}
	}


if($permitir=="1"){
	$accesoSinPost = "0";
	$accesoSinPostPago = "0";
	if($_SESSION['nombre_rol']!="Vendedor" || ($_SESSION['nombre_rol']=="Vendedor" && $pedidos[0]['id_cliente']==$_SESSION['id_cliente'])){
		$accesoSinPostPago = "1";
		$accesoSinPost = "1";
	}else{
		$_SESSION['ids_general_estructuraID'] = [];
		$_SESSION['id_despacho'] = $id_despacho;
		consultarEstructuraID($_SESSION['id_cliente'], $lider);
		$estructuraHijos = $_SESSION['ids_general_estructuraID'];
		// $idTem = $_SESSION['id_cliente'];
		// $pedidosPerson = $lider->consultarQuery("SELECT id_cliente, id_pedido FROM pedidos WHERE id_despacho = $id_despacho and id_cliente = $idTem");
		// $index = count($estructuraHijos);
		// $estructuraHijos[$index] = $pedidosPerson[0];
		// print_r($estructuraHijos);
		foreach ($estructuraHijos as $struct) {
			if($struct['id_pedido']==$id){
				$accesoSinPost = "1";
			}
		}
	}
	if(!empty($_POST['precioGema']) && !empty($_POST['id_pedido_modal']) && isset($_POST['valoresLiquidacion']) && isset($_POST['totalesLiquidacion'])){
		// print_r($_POST);
		$id_pedido = $_POST['id_pedido_modal'];
		$id_pedido = $id;
		$id_cliente = $lider->consultarQuery("SELECT id_cliente FROM pedidos WHERE id_pedido={$id}");
		$id_cliente = $id_cliente[0]['id_cliente'];
		$valor = 0;
		if($_POST['valoresLiquidacion']>0){
			$valor = $_POST['valoresLiquidacion'];
		}
		// $valor = 0;
		// $valor = 8;

		$precioGema = $_POST['precioGema'];
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE id_campana = {$id_campana}");
		$precioGema = $precio_gema[0]['precio_gema'];
		$totalesLiquidacion = $_POST['totalesLiquidacion'];
		$totalesLiquidacion = $precioGema*$valor;
		$fecha = date('Y-m-d');
		$hora = date('h:i a');

		// echo "Pedido: ".$id_pedido."<br>";
		// echo "Cliente: ".$id_cliente."<br>";
		// echo "Precio: ".$precioGema."<br>";
		// echo "Cantidad_descuento_gemas: ".$valor."<br>";
		// echo "<br><br>";


		if($valor == 0){
			$query = "DELETE FROM descuentos_gemas WHERE id_pedido = {$id_pedido} and id_cliente = {$id_cliente}";
			$exec = $lider->eliminar($query);
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2";
			}
		}else{
			$query = "SELECT * FROM descuentos_gemas WHERE id_pedido = $id_pedido and id_cliente = $id_cliente";
			$buscar = $lider->consultarQuery($query);
			if(count($buscar)>1){
				$query = "UPDATE descuentos_gemas SET precio_gema = {$precioGema}, cantidad_descuento_gemas='{$valor}', total_descuento_gemas='{$totalesLiquidacion}', estatus = 1 WHERE id_pedido = {$id_pedido} and id_cliente = {$id_cliente}";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
			}else{
				$query = "INSERT INTO descuentos_gemas (id_descuento_gema, id_pedido, id_cliente, precio_gema, cantidad_descuento_gemas, total_descuento_gemas, fecha_descuento_gema, hora_descuento_gema, estatus) VALUES (DEFAULT, {$id_pedido}, {$id_cliente}, '{$precioGema}', '{$valor}', '{$totalesLiquidacion}', '{$fecha}', '{$hora}', 1)";
				$exec = $lider->registrar($query, "descuentos_gemas", "id_descuento_gema");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
			}
		}
		// echo $response;

		$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");
		$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");

		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];
					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query); 

						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad");
						$maxima = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_despacho = {$id_despacho} ORDER BY liderazgos_campana.minima_cantidad DESC;");
						if(count($maxima)>1){
							$maxmax = $maxima[0];
							if($maxmax['minima_cantidad'] <= $total){
								$id_liderazgoTemp = $maxmax['id_liderazgo'];
								$minima_cantidadTemp = $maxmax['minima_cantidad'];
								$maxima_cantidadTemp = $maxmax['minima_cantidad']*10;
								$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos.id_liderazgo = {$id_liderazgoTemp} and $total > minima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
							}else{

								$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
							}
						}

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}

	}


	if(!empty($_POST['id_pedido_modal']) && !empty($_POST['tipo_bono']) && !empty($_POST['descuentoContado']) && isset($_POST['valoresContado']) && isset($_POST['totalesContado'])){



		$tipo_bono = $_POST['tipo_bono'];
		$id_pedido = $_POST['id_pedido_modal'];
		$descuentos = $_POST['descuentoContado'];
		$colecciones = number_format($_POST['valoresContado'],0);
		$totales = $_POST['totalesContado'];

		$num = 0;

		$query = "DELETE FROM bonoscontado WHERE id_pedido = $id_pedido";
		$exec = $lider->eliminar($query);
		if($exec['ejecucion']==true){
				$query = "INSERT INTO bonoscontado (id_bonocontado, id_pedido, descuentos_bono, colecciones_bono, totales_bono, estatus) VALUES (DEFAULT, $id_pedido, '$descuentos', '$colecciones', '$totales', 1)";
				$exec = $lider->registrar($query, "bonoscontado", "id_bonocontado");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
		}

		$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");
		$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");





		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query);


						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}

	}

	

	if(!empty($_POST['id_pedido_modal']) && !empty($_POST['tipo_bono']) && !empty($_POST['descuentoContado']) && isset($_POST['valoresContado']) && isset($_POST['totalesContado'])){



		$tipo_bono = $_POST['tipo_bono'];
		$id_pedido = $_POST['id_pedido_modal'];
		$descuentos = $_POST['descuentoContado'];
		$colecciones = number_format($_POST['valoresContado'],0);
		$totales = $_POST['totalesContado'];

		$num = 0;

		$query = "DELETE FROM bonoscontado WHERE id_pedido = $id_pedido";
		$exec = $lider->eliminar($query);
		if($exec['ejecucion']==true){
				$query = "INSERT INTO bonoscontado (id_bonocontado, id_pedido, descuentos_bono, colecciones_bono, totales_bono, estatus) VALUES (DEFAULT, $id_pedido, '$descuentos', '$colecciones', '$totales', 1)";
				$exec = $lider->registrar($query, "bonoscontado", "id_bonocontado");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
		}

		$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");
		$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");


		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query);



						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}

	}


	if(!empty($_POST['id_pedido_modal']) && !empty($_POST['id']) && !empty($_POST['tipo_bono']) && !empty($_POST['descuentos']) && isset($_POST['valores']) && isset($_POST['totales'])){

		$tipo_bono = $_POST['tipo_bono'];
		$id_pedido = $_POST['id_pedido_modal'];
		$id_plan_campana = $_POST['id'];
		$descuentos = $_POST['descuentos'];
		$colecciones = $_POST['valores'];
		$totales = $_POST['totales'];

		$num = 0;
		$query = "DELETE FROM bonospagos WHERE id_pedido = $id_pedido and tipo_bono = '$tipo_bono'";
		$exec = $lider->eliminar($query);
		if($exec['ejecucion']==true){
			foreach ($id_plan_campana as $id_plan) {
				// echo "Tipo Bono: ".$tipo_bono." || ";
				// echo "Id Pedido: ".$id_pedido." || ";
				// echo "Id Plan: ".$id_plan." || ";
				// echo "Descuentos: ".$descuentos[$num]." || ";
				// echo "Colecciones: ".$colecciones[$num]." || ";
				// echo "Totales: ".$totales[$num]." || ";
				// echo "<br>";

				$descuento = $descuentos[$num];
				$coleccion = number_format($colecciones[$num],0);
				$total = $totales[$num];

				$query = "INSERT INTO bonospagos (id_bonoPago, id_pedido, id_plan_campana, tipo_bono, descuentos_bono, colecciones_bono, totales_bono, estatus) VALUES (DEFAULT, $id_pedido, $id_plan, '$tipo_bono', '$descuento', '$coleccion', '$total', 1)";
				$exec = $lider->registrar($query, "bonospagos", "id_bonoPago");
				if($exec['ejecucion']==true){
					$response = "1";
				}else{
					$response = "2";
				}
				$num++;
			}
		}

		$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");
		$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");


		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query);


						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}

	}
	if(isset($_POST['cantidadTraspaso']) && !empty($_POST['restoDisponible']) && !empty($_POST['id_cliente_receptor']) && !empty($_POST['id_pedido_receptor']) && isset($_POST['id_cliente_emisor']) && isset($_POST['id_pedido_emisor'])){
		// print_r($_POST);

		$cantidad = $_POST['cantidadTraspaso'];
		if($cantidad==""){
			$cantidad = 0;
		}
		$restoDisponible = $_POST['restoDisponible'];
		$id_cliente_receptor = $_POST['id_cliente_receptor'];
		$id_pedido_receptor = $_POST['id_pedido_receptor'];
		$id_cliente_emisor = $_POST['id_cliente_emisor'];
		$id_pedido_emisor = $_POST['id_pedido_emisor'];

		// echo "<br>";
		// echo "Yo mi ID ".$id_cliente_emisor."<br>";
		// echo "Yo mi Pedido ".$id_pedido_emisor."<br>";
		// echo "La otra persona su ID ".$id_cliente_receptor."<br>";
		// echo "La otra persona su Pedido ".$id_pedido_receptor."<br>";
		// echo "<br>";

		$traspasos = $lider->consultarQuery("SELECT * FROM traspasos WHERE estatus = 1 and id_pedido_emisor = {$id_pedido_emisor} and id_pedido_receptor = {$id_pedido_receptor}");

		// print_r($traspasos);
		// echo "<br>";
		if(count($traspasos)>1){
			$exec1 = $lider->eliminar("DELETE FROM traspasos WHERE estatus = 1 and id_pedido_emisor = {$id_pedido_emisor} and id_pedido_receptor = {$id_pedido_receptor}");
			if($exec1['ejecucion']==true){
				if($cantidad>0){
					$query = "INSERT INTO traspasos (id_traspaso, id_pedido_emisor, id_pedido_receptor, cantidad_traspaso, estatus) VALUES (DEFAULT, $id_pedido_emisor, $id_pedido_receptor, '$cantidad', 1)";
					$exec = $lider->registrar($query, "traspasos", "id_traspaso");
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2";
					}	
				}else{
					$response = "1";
				}
			}else{
				$response = "2";
			}
		}else{
			$query = "INSERT INTO traspasos (id_traspaso, id_pedido_emisor, id_pedido_receptor, cantidad_traspaso, estatus) VALUES (DEFAULT, $id_pedido_emisor, $id_pedido_receptor, '$cantidad', 1)";
			$exec = $lider->registrar($query, "traspasos", "id_traspaso");
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2";
			}
		}

		// CODIGO PARA MOSTRAR NUEVAMENTE LA VISTA;
		if(!empty($_GET['liderTraspaso'])){
				$liderEmisor = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_GET['liderTraspaso']}");
				$liderEmisor = $liderEmisor[0];

				$traspasoEmitido = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and clientes.id_cliente = {$_GET['liderTraspaso']}");
			}

			$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id");
			$traspasosRecibidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_emisor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_receptor = $id");

		$bonosPago1 = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");
		

		// $fecha = date('Y-m-d');
		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$cierresEstructura = 0;

					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query);


						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}
						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;


					$lideres = $lider->consultar("clientes");

					

					$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
					$configgema = $configgemas[0];
					$id_configgema = $configgema['id_configgema'];
					$cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
					$cantidad_gemas = 0;
					// if($configgema['condicion']=="Dividir"){
						$cantidad_gemas = $cantidad / $cantidad_gemas_correspondientes;
					// }
					// if($configgema['condicion']=="Multiplicar"){
						// $cantidad_gemas = $cantidad * $cantidad_gemas_correspondientes;
					// }

					$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

					$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, {$id_cliente}, {$id_configgema}, '{$cantidad}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', 0, '{$cantidad_gemas}', 'Bloqueado', 1)";
					$lider->registrar($query, "gemas", "id_gema");


					// $estructura2 = [];
					// $estructura = consultarEstructura($id_cliente, $lider, 0, $estructura2);
					// echo "Cantidad: "; echo count($estructura)-1;
					// print_r($estructura);
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}
	}

	if(!empty($_POST['cantidad'])){
		// print_r($_POST);  // APROBAR PEDIDOS

		$cantidad = $_POST['cantidad'];

		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		$pedido = $pedidos[0];
		
		$fecha_aprobado = date('d-m-Y');
		$hora_aprobado = date('g:ia');
		$query = "UPDATE pedidos SET cantidad_aprobado = $cantidad, fecha_aprobado = '$fecha_aprobado', hora_aprobado = '$hora_aprobado', visto_admin = 1, visto_cliente = 2, estatus = 1 WHERE id_pedido = $id";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$response = "1";

			$id_cliente = $pedido['id_cliente'];
			/* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/

			/* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/
			$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
			$cantidadClientesBajos = Count($clientesBajas)-1;
			$cantidad_total = 0;
			if($cantidadClientesBajos > 0){
				$tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
				$cantidad_total = $cantidad+$tot;
				// $cantidad_total = $tot;
			}else{
				$cantidad_total = $cantidad;
			}

			/* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/
			$query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id";
			$exec = $lider->modificar($query);
			$res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);

			/* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

			$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
			$cliente = $clientes[0];
			$totalActual = $pedido['cantidad_total'];
			$id_lider = $cliente['id_lider'];
			if($id_lider > 0 ){
				$request = comprobarLider($cantidad_total, $id_lider, $id_despacho, $lider);
			}

			// //Esto Nooo se Descomentara
			$request = "1";


				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', '
					Aprobar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}

		}else{
			$response = "2";
		}


		// CODIGO PARA MOSTRAR NUEVAMENTE LA VISTA;
		$bonosPago1 = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
	 	$bonosCierre = $lider->consultarQuery("SELECT * FROm bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

	 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
		$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
		$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");

		// $fecha = date('Y-m-d');
		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgosAll = $lider->consultarQuery($query);
		if(!empty($id)){

			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
			if(count($pedidos)>1){
				if($pedidos['ejecucion']==1){
					$cierresEstructura = 0;

					$pedido = $pedidos[0];
					$id_cliente = $pedido['id_cliente'];
					$id_despacho = $pedido['id_despacho'];
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
					if($cuenta['id_cliente']==$id_cliente){
						$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
					}


					$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
					$cliente = $clientes[0];

					$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
					$despacho = $despachos[0];

					if(strlen($pedido['fecha_aprobado'])>0){
						// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
						// print_r($coleccionesPlan);

						$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

						$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
						$clientesPedidos = $lider->consultarQuery($query);

						$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

						// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
						$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");

						$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");

						if(count($liderazgos)>1){
			                $clientePedidos = $clientesPedidos[0];
							$lidera = $liderazgos[0];					
							$precio_coleccion = $clientePedidos['precio_coleccion'];
			                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
			                $total_costo = $precio_coleccion * $cantidad_aprobado;
			                $descuentoXColeccion = $lidera['total_descuento'];
			                $color_liderazgo = $lidera['color_liderazgo'];
			                $nombre_liderazgo = $lidera['nombre_liderazgo'];
			                $cantidad_total = $clientePedidos['cantidad_total'];
							$descuentoAdicional = 0;
							$abonado = 0;
							if(Count($clienteHijas)>1){

								$calculo = [];
								$in = 0;
								foreach ($clienteHijas as $key) {
									if(!empty($key['id_cliente'])){
										$id_liderazgoE = $key['id_lc'];
										$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
											// print_r($liderazgosE);

										if(!empty($liderazgosE[0])){
											$liderazgoHijo = $liderazgosE[0];

											if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
												$calculo[$in]['aprobadas'] = $key['cantidad_total'];
												$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
											}
											$in++;
										}
									}
								}
								// print_r($calculo);
								if(Count($calculo)>0){
									foreach ($calculo as $calc) {
										$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
									}
								}
							}
			                
			                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

				                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
				                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
				                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

				               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
				                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
				               }
				               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
			                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
				               }
							    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
				                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

			                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
			                // echo "Colecciones: ".$cantidad_aprobado."<br>";
			                // echo "Descuento Personal: ".$descuento_total."<br>";
			                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
			                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

			                
			            }
					}
					// $limite = $clientePedidos['limite_pedido'];
					// comprobarFechasLimites($limite);
					if(count($userCliente)>1){
						$userCliente = $userCliente[0];
						if($userCliente['fotoPerfil'] == ""){
					      $fotoPerfilCliente = "public/assets/img/profile/";
					      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

					    }else{
					      $fotoPerfilCliente = $userCliente['fotoPerfil'];
					    }

					    if($userCliente['fotoPortada'] == ""){
					      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
					    }else{
					      $fotoPortadaCliente = $userCliente['fotoPortada'];
					    }
					    $rrollCliente = $userCliente['nombre_rol'];
				        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
				        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
				        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
					}else{
						$fotoPerfilCliente = "public/assets/img/profile/";
					    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
					    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
					    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
					    $rrollCliente = "Agente";
					}
					if(!empty($_GET['liderEstruct'])){
						$id_liderEstruct = $_GET['liderEstruct'];
						// echo "Pedido: ".$id."<br>";
						// echo "Lider: ".$id_liderEstruct."<br>";
						$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
						// print_r($bonosEstructura);
					}
					$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} ORDER BY fecha_pago asc");
					$reportado = 0;
					$diferido = 0;
					$abonado = 0;


					$lideres = $lider->consultar("clientes");

					
					$cantidad = $_POST['cantidad'];
					$configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
					$configgema = $configgemas[0];
					$id_configgema = $configgema['id_configgema'];
					$cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
					$cantidad_gemas = 0;
					// if($configgema['condicion']=="Dividir"){
						$cantidad_gemas = $cantidad / $cantidad_gemas_correspondientes;
					// }
					// if($configgema['condicion']=="Multiplicar"){
						// $cantidad_gemas = $cantidad * $cantidad_gemas_correspondientes;
					// }

					$lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

					$query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, {$id_cliente}, {$id_configgema}, '{$cantidad}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', 0, '{$cantidad_gemas}', 'Bloqueado', 1)";
					$lider->registrar($query, "gemas", "id_gema");


					// $estructura2 = [];
					// $estructura = consultarEstructura($id_cliente, $lider, 0, $estructura2);
					// echo "Cantidad: "; echo count($estructura)-1;
					// print_r($estructura);
					if(count($pagos)){
		              foreach ($pagos as $data) {
		                if(!empty($data['id_pago'])){
		                  $reportado += $data['equivalente_pago'];
		                  if($data['estado']=="Diferido"){
		                    $diferido += $data['equivalente_pago'];
		                  }
		                  if($data['estado']=="Abonado"){
		                    $abonado += $data['equivalente_pago'];
		                  }
		                }
		              }
					}
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
			}else{
				require_once 'public/views/error404.php';
			}
		}else{
		    require_once 'public/views/error404.php';
		}
	}

	if(empty($_POST) && (!empty($_GET['reclamarporcentaje']) && $_GET['reclamarporcentaje'] == 1 ) && !empty($_GET['gema']) && !empty($_GET['porcentaje'])){
		$pedido = $pedidos[0];
		$id_gema = $_GET['gema'];
		$porcentaje = number_format($_GET['porcentaje'],2);
		$gemas = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id_gema}");
		$gema = $gemas[0];
		$inactivas = $gema['cantidad_gemas'] - $porcentaje;
		$activas = $porcentaje;

		$porcentajeReal = $_GET['porcentPago'];
		if($porcentajeReal >= 100){
			// echo "TODO BIEN <br><br>";
			$porcentajeReal = 100;
		}
		$cantidad_unidades = $pedido['cantidad_aprobado'];
		$cantidad_gemas = $cantidad_unidades / 5;

		$porcentajeCalc = ($cantidad_gemas/100)*$porcentajeReal;
		$porcentajeCalc = number_format($porcentajeCalc,2,'.','');
		$inactivasCalc = $cantidad_gemas - $porcentajeCalc;
		$activasCalc = $porcentajeCalc;
		// echo "Cantidad Gemas: ".$gema['cantidad_gemas']." <br>";

		// echo "COLECCIONES APROBADAS: ".$pedido['cantidad_aprobado']." <br>";
		// echo "Cantidad Unidades: ".$cantidad_unidades." <br>";
		// echo "Cantidad Gemas calc: ".$cantidad_gemas." <br>";
		// echo "Porcentaje Calculado: ".$porcentajeCalc."<br>";
		// echo "INACTIVAS Calculado: ".$inactivasCalc."<br>";
		// echo "ACTIVAS Calculado: ".$activasCalc."<br>";
		$query = "UPDATE gemas SET cantidad_unidades='{$cantidad_unidades}', cantidad_gemas='{$cantidad_gemas}', activas = '{$activasCalc}', inactivas = '{$inactivasCalc}', estado = 'Disponible' WHERE id_gema = {$id_gema}";
		// echo $query."<br>";
		$res1 = $lider->modificar($query);
		if($res1['ejecucion']==true){
			$responseGema = "1";
		}else{
			$responseGema = "2"; // echo 'Error en la conexion con la bd';
		}
	}


	if(empty($_POST) && (!empty($_GET['reclamar']) && $_GET['reclamar'] == 1 ) && !empty($_GET['gema'])){
		$pedido = $pedidos[0];
		$id_gema = $_GET['gema'];
		$gemas = $lider->consultarQuery("SELECT * FROM gemas WHERE id_gema = {$id_gema}");
		$gema = $gemas[0];
		$activas = $gema['cantidad_gemas'];

		$cantidad_unidades = $pedido['cantidad_aprobado'];
		$cantidad_gemas = $cantidad_unidades / 5;
		$inactivasCalc = $cantidad_gemas - $cantidad_gemas;
		$activasCalc = $cantidad_gemas;
		// echo "COLECCIONES APROBADAS: ".$pedido['cantidad_aprobado']." <br>";
		// echo "Cantidad Unidades: ".$cantidad_unidades." <br>";
		// echo "Cantidad Gemas calc: ".$cantidad_gemas." <br>";
		// echo "INACTIVAS Calculado: ".$inactivasCalc."<br>";
		// echo "ACTIVAS Calculado: ".$activasCalc."<br>";

		// $query = "UPDATE gemas SET activas = '{$activas}', inactivas = '0', estado = 'Disponible' WHERE id_gema = {$id_gema}";
		$query = "UPDATE gemas SET cantidad_unidades='{$cantidad_unidades}', cantidad_gemas='{$cantidad_gemas}', activas = '{$activasCalc}', inactivas = '{$inactivasCalc}', estado = 'Disponible' WHERE id_gema = {$id_gema}";
		// echo $query."<br>";
		$res1 = $lider->modificar($query);
		if($res1['ejecucion']==true){
			$responseGema = "1";
		}else{
			$responseGema = "2"; // echo 'Error en la conexion con la bd';
		}
	}


	if(!empty($_POST['cerrarExcedenteLider']) && !empty($_POST['cantidad_excedente']) ){
		$id_pedido = $_GET['id'];
		$cantidad = $_POST['cantidad_excedente'];
		$descripcion = ucwords(mb_strtolower($_POST['descripcion_excedente']));
		// echo "Pedido: ".$id_pedido." - Cantidad: ".$cantidad;
		// $porcentaje = number_format($_GET['porcentaje'],2);
		$buscar = $lider->consultarQuery("SELECT * FROM excedentes WHERE id_pedido = {$id_pedido}");
		// print_r($buscar);
		if(count($buscar)>1){
			$response = "1";
		}else{
			$query = "INSERT INTO excedentes (id_excedente, id_pedido, cantidad_excedente, descripcion_excedente, estatus) VALUES (DEFAULT, {$id_pedido}, '{$cantidad}', '{$descripcion}', 1)";
			$res1 = $lider->registrar($query,"excedentes", "id_excedente");
			if($res1['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		}
		echo $response;
	}


	if($accesoSinPost == "1"){
		if(empty($_POST)){	


			if(!empty($_GET['liderTraspaso'])){
				$liderEmisor = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_GET['liderTraspaso']}");
				$liderEmisor = $liderEmisor[0];
				$traspasoEmitido = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id and clientes.id_cliente = {$_GET['liderTraspaso']}");

			}

			$traspasosEmitidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_receptor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_emisor = $id");
			$traspasosRecibidos = $lider->consultarQuery("SELECT * FROM traspasos, pedidos, clientes WHERE traspasos.id_pedido_emisor = pedidos.id_pedido and pedidos.id_cliente = clientes.id_cliente and traspasos.estatus = 1 and traspasos.id_pedido_receptor = $id");

			$clientesAll = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho");
			$bonosContado = $lider->consultarQuery("SELECT * FROM bonoscontado WHERE id_pedido = $id");
			$bonosPago1 = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Primer Pago' and id_pedido = $id");
		 	$bonosCierre = $lider->consultarQuery("SELECT * FROM bonospagos WHERE tipo_bono = 'Cierre' and id_pedido = $id");

		 	$bonoCierreEstructura = $lider->consultarQuery("SELECT * FROM bonoscierres WHERE id_pedido = $id");
			$detallesEstructura = $lider->consultarQuery("SELECT * FROM clientes, bonoscierres, liderazgos WHERE clientes.id_cliente = bonoscierres.id_cliente and bonoscierres.id_liderazgo = liderazgos.id_liderazgo and bonoscierres.id_pedido = $id");


			$id_cliente = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
		 	$id_cliente = $id_cliente[0]['id_cliente'];

		 	$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente}");
		 	$liquidacion_gemas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_pedido = {$id}");
			$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}");

		 	// print_r($liquidacion_gemas);

			// $fecha = date('Y-m-d');
		 	// print_r($bonoCierreEstructura);

			$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";

			$liderazgosAll = $lider->consultarQuery($query);
			if(!empty($id)){

				$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");

				if(count($pedidos)>1){
					if($pedidos['ejecucion']==1){
						$cierresEstructura = 0;
						$pedido = $pedidos[0];

						$id_cliente = $pedido['id_cliente'];
						$id_despacho = $pedido['id_despacho'];
						$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id_cliente'");
						if($cuenta['id_cliente']==$id_cliente){
							$exec = $lider->modificar("UPDATE pedidos SET visto_cliente = 1 WHERE id_pedido = {$pedido['id_pedido']}");
						}


						$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
						$cliente = $clientes[0];

						$despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
						$despacho = $despachos[0];

						if(strlen($pedido['fecha_aprobado'])>0){
							// $coleccionesPlan = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_pedido = {$id}");
							// print_r($coleccionesPlan);

							$colss = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");

							$query = "SELECT * FROM pedidos, clientes, despachos, campanas WHERE clientes.id_cliente = $id_cliente and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = despachos.id_despacho and despachos.id_campana = campanas.id_campana and pedidos.estatus = 1 ORDER BY pedidos.id_pedido DESC";
							$clientesPedidos = $lider->consultarQuery($query); 


							$pedidosAcumulados = $lider->consultarQuery("SELECT * FROM despachos, pedidos WHERE despachos.id_despacho = pedidos.id_despacho and despachos.estatus = 1 and pedidos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = {$id_cliente}");

							$sumatoria_cantidad_aprobado = 0;
							$sumatoria_cantidad_total = 0;
							foreach ($pedidosAcumulados as $keyss) {
								if(!empty($keyss['cantidad_aprobado'])){
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
										$total = $pedido['cantidad_total'];
										$sumatoria_cantidad_total += $keyss['cantidad_total'];
									}
									if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
										$total = $pedido['cantidad_aprobado'];
										$sumatoria_cantidad_aprobado += $keyss['cantidad_aprobado'];
									}
								}
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
								$total = $pedido['cantidad_total'];
								$total = $sumatoria_cantidad_total;
							}
							if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
								$total = $pedido['cantidad_aprobado'];
								$total = $sumatoria_cantidad_aprobado;
							}

							// $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_lc = {$cliente['id_lc']}");
							$maxima = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.id_despacho = {$id_despacho} ORDER BY liderazgos_campana.minima_cantidad DESC;");
							if(count($maxima)>1){
								$maxmax = $maxima[0];
								if($maxmax['minima_cantidad'] <= $total){
									$id_liderazgoTemp = $maxmax['id_liderazgo'];
									$minima_cantidadTemp = $maxmax['minima_cantidad'];
									$maxima_cantidadTemp = $maxmax['minima_cantidad']*10;
									$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos.id_liderazgo = {$id_liderazgoTemp} and $total > minima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
								}else{

									$liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}");
								}
							}

							$clienteHijas = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1 and clientes.id_lider = $id_cliente");
							// print_r($clientesPedidos);
							if(count($liderazgos)>1){
				                $clientePedidos = $clientesPedidos[0];
								$lidera = $liderazgos[0];					
								$precio_coleccion = $clientePedidos['precio_coleccion'];
				                $cantidad_aprobado = $clientePedidos['cantidad_aprobado'];
				                $total_costo = $precio_coleccion * $cantidad_aprobado;
				                $descuentoXColeccion = $lidera['total_descuento'];
				                $color_liderazgo = $lidera['color_liderazgo'];
				                $nombre_liderazgo = $lidera['nombre_liderazgo'];
				                $cantidad_total = $clientePedidos['cantidad_total'];
								$descuentoAdicional = 0;
								$abonado = 0;
								if(Count($clienteHijas)>1){

									$calculo = [];
									$in = 0;
									foreach ($clienteHijas as $key) {
										if(!empty($key['id_cliente'])){
											$id_liderazgoE = $key['id_lc'];
											$liderazgosE = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and id_lc = $id_liderazgoE and liderazgos_campana.id_despacho = {$id_despacho}");
												// print_r($liderazgosE);

											if(!empty($liderazgosE[0])){
												$liderazgoHijo = $liderazgosE[0];

												if($lidera['id_liderazgo'] > $liderazgoHijo['id_liderazgo']){
													$calculo[$in]['aprobadas'] = $key['cantidad_total'];
													$calculo[$in]['descuento'] = $liderazgoHijo['total_descuento'];
												}
												$in++;
											}
										}
									}
									// print_r($calculo);
									if(Count($calculo)>0){
										foreach ($calculo as $calc) {
											$descuentoAdicional += $calc['descuento'] * $calc['aprobadas'];
										}
									}
								}
				                
				                $descuento_total = $descuentoXColeccion * $cantidad_aprobado;

					                $total_cantidad_hijas = $cantidad_total - $cantidad_aprobado;
					                $descuento_full_hijos = $total_cantidad_hijas * $descuentoXColeccion;
					                $descuento_distribucion_real = $descuento_full_hijos - $descuentoAdicional;

					               if($_SESSION['tomandoEnCuentaDistribucion'] == "1"){
					                $total_descuento_distribucion = $descuento_total + $descuento_distribucion_real; // TOMANDO EN CUENTA LA DISTRIBUCION
					               }
					               if($_SESSION['tomandoEnCuentaDistribucion'] == "0"){
				                	$total_descuento_distribucion = $descuento_total;  // NOOOOO TOMANDO EN CUENTA LA DISTRIBUCION
					               }
								    // $total_descuento_distribucion = $descuento_total + $descuentoAdicional;
					                // $total_responsabilidad = $total_costo - $total_descuento_distribucion;

				                // echo "Descuento por coleccion: ".$descuentoXColeccion."<br>";
				                // echo "Colecciones: ".$cantidad_aprobado."<br>";
				                // echo "Descuento Personal: ".$descuento_total."<br>";
				                // echo "Descuento Adicional: ".$descuento_distribucion_real."<br>";
				                // echo "Total Descuento: ".$total_descuento_distribucion."<br>";

				                
				            }
						}
						// $limite = $clientePedidos['limite_pedido'];
						// comprobarFechasLimites($limite);
						if(count($userCliente)>1){
							$userCliente = $userCliente[0];
							if($userCliente['fotoPerfil'] == ""){
						      $fotoPerfilCliente = "public/assets/img/profile/";
						      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
						      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

						    }else{
						      $fotoPerfilCliente = $userCliente['fotoPerfil'];
						    }

						    if($userCliente['fotoPortada'] == ""){
						      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
						    }else{
						      $fotoPortadaCliente = $userCliente['fotoPortada'];
						    }
						    $rrollCliente = $userCliente['nombre_rol'];
					        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
					        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
					        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
						}else{
							$fotoPerfilCliente = "public/assets/img/profile/";
						    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
						    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
						    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";			
						    $rrollCliente = "Agente";
						}

						if(!empty($_GET['liderEstruct'])){
							$id_liderEstruct = $_GET['liderEstruct'];
							// echo "Pedido: ".$id."<br>";
							// echo "Lider: ".$id_liderEstruct."<br>";
							$bonosEstructura = $lider->consultarQuery("SELECT * FROm bonoscierres WHERE id_pedido = $id and id_cliente = $id_liderEstruct");
							// print_r($bonosEstructura);
						}

						$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
						$reportado = 0;
						$diferido = 0;
						$abonado = 0;


						$lideres = $lider->consultar("clientes");
						$_SESSION['ids_general_estructura'] = [];
						$_SESSION['id_despacho'] = $id_despacho;
						consultarEstructura($id_cliente, $lider);
						$estructuraLideres = $_SESSION['ids_general_estructura'];
						$number = 1;
						// foreach ($estructuraLideres as $keyss) {
						// 	echo $number;
						// 	echo "  --- | ---  ";
						// 	echo $keyss['id_cliente'];
						// 	echo "  --- | ---  ";
						// 	echo $keyss['id_pedido'];
						// 	echo "  --- | ---  ";
						// 	echo $keyss['cantidad_aprobado'];
						// 	echo "  --- | ---  ";
						// 	echo $keyss['estatus'];
						// 	echo "  --- | ---  ";
						// 	echo "<br>";
						// 	$number++;
						// }

						if(count($pagos)){
			              foreach ($pagos as $data) {
			                if(!empty($data['id_pago'])){
			                  $reportado += $data['equivalente_pago'];
			                  if($data['estado']=="Diferido"){
			                    $diferido += $data['equivalente_pago'];
			                  }
			                  if($data['estado']=="Abonado"){
			                    $abonado += $data['equivalente_pago'];
			                  }
			                }
			              }
						}

			
						// $despacho['fecha_segunda_senior'] = '2022-04-26';
						$pagosGemas = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pedido = {$id} and estado = 'Abonado' and fecha_pago <= '{$despacho['fecha_segunda_senior']}' ORDER BY fecha_pago DESC");
						$num = 0;
						$abonado_lider_gemas = 0;
						$fecha_pago_cierre_lider = "";
						if(count($pagosGemas)>1){
							foreach ($pagosGemas as $key) {
								if(!empty($key['fecha_pago'])){
									$abonado_lider_gemas += $key['equivalente_pago']; 
								}
							}
							$fecha_pago_cierre_lider = $pagosGemas[0]['fecha_pago'];
						}
						$gemasReclamar = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_campana = {$id_campana} and gemas.id_pedido = {$id} and gemas.id_cliente = {$pedido['id_cliente']} and gemas.estado = 'Bloqueado' and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa'");



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
}else{
	require_once 'public/views/error404.php';
}

function consultarEstructura($id_c, $lider){
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c");

	// $lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				$lideress = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$lid['id_cliente']}");
				if(count($lideress)>1){
					$lid2 = $lideress[0];
					$_SESSION['ids_general_estructura'][] = $lid2;
					// print_r($lid);
					// echo "<br><br>";
					// print_r($lid2);
					// echo "<br><br><br><br>";
				}
				consultarEstructura($lid['id_cliente'], $lider);
			}
		}
	}
}

// function consultarEstructura($id_c, $lider){
// 	$id_despacho = $_SESSION['id_despacho'];
// 	$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");

// 	if(Count($lideres)>1){
// 		foreach ($lideres as $lid) {
// 			if(!empty($lid['id_cliente'])){
// 				$_SESSION['ids_general_estructura'][] = $lid;
// 				consultarEstructura($lid['id_cliente'], $lider);
// 			}
// 		}
// 	}
// }

function consultarEstructuraID($id_c, $lider){
	$id_despacho = $_SESSION['id_despacho'];
	$lideres = $lider->consultarQuery("SELECT clientes.id_cliente, pedidos.id_pedido FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_lider = $id_c");
	if(Count($lideres)>1){
		foreach ($lideres as $lid) {
			if(!empty($lid['id_cliente'])){
				$_SESSION['ids_general_estructuraID'][] = $lid;
				consultarEstructuraID($lid['id_cliente'], $lider);
			}
		}
	}
}

function comprobarLider($cantidad, $id_lider, $id_despacho, $lider){
	// echo "Mis Colecciones Total: ".$cantidad."<br>";
	$responseRequest = false;
	$pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_lider and id_despacho = $id_despacho");
	$clientesLider = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_lider");
	if(Count($pedidosLider)>1){
		$pedidoLider = $pedidosLider[0];
		$cantidad = $pedidoLider['cantidad_aprobado'];
		$id_pedido = $pedidoLider['id_pedido'];
		// echo "pedido: ".$id_pedido." <br>";
	}

	if(Count($clientesLider)>1){
		$clienteLider = $clientesLider[0];
		$id_cliente = $clienteLider['id_cliente'];
		$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

		$cantidadClientesBajos = Count($clientesBajas)-1;
		$cantidad_total = 0;
		if($cantidadClientesBajos > 0){
			$tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
			$cantidad_total = $cantidad+$tot;
			// $cantidad_total = $tot;	
		}else{
			$cantidad_total = $cantidad;
		}
		if(Count($pedidosLider)>1){
			$query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id_pedido";
			$exec = $lider->modificar($query);
		}
		/*  CODIGO PARA ESTABLECER CUAL SERA MI LIDERAZGO  */ 
		$res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);
		$new_id_lider = $clienteLider['id_lider'];
		if($new_id_lider > 0 ){
			$responseRequest = comprobarLider($cantidad, $new_id_lider, $id_despacho, $lider);
		}
	}
	return $responseRequest;
}

function comprobarVendedoras($clientes, $id_despacho, $lider){
	$total = 0;
	$vez = "";
	foreach ($clientes as $client) {
		if(!empty($client['id_cliente'])){
			$id_cliente = $client['id_cliente'];
			$vez = $id_cliente;
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_cliente and id_despacho = $id_despacho");
			if(Count($pedidos)>1){
				$pedido = $pedidos[0];
				$total += $pedido['cantidad_aprobado'];
			}

			$clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
			if(Count($clientesBajas)>1){
				$total += comprobarVendedoras($clientesBajas, $id_despacho, $lider);
			}

		}
	}
	// echo "ID: ".$vez." | Total aprobadas: ".$total."<br>";
	return $total;
}


function aplicarLiderazgo($id, $id_despacho, $lider){
	$pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id and id_despacho = $id_despacho");
	if(Count($pedidos)>1){
		$pedido = $pedidos[0];
		if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
			$total = $pedido['cantidad_total'];
		}
		if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
			$total = $pedido['cantidad_aprobado'];
		}
		$query = "SELECT * FROM liderazgos_campana WHERE $total BETWEEN minima_cantidad and maxima_cantidad and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgos = $lider->consultarQuery($query);
		if(Count($liderazgos)>1){
			$liderazgo = $liderazgos[0];
			$id_liderazgo = $liderazgo['id_lc'];

			$query = "UPDATE clientes SET id_lc = $id_liderazgo WHERE id_cliente = $id";
			$exec = $lider->modificar($query);
		}
	}
}

?>