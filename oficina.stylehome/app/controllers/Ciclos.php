<?php
	if(strtolower($url)=="ciclos"){
		if(!empty($action)){
			$accesoCiclosR = false;
			$accesoCiclosC = false;
			$accesoCiclosM = false;
			$accesoCiclosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Ciclos")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoCiclosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoCiclosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoCiclosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoCiclosE=true; }
					}
				}
			}
			if($action=="Consultar"){
				if($accesoCiclosC){
					$ciclos=$lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 ORDER BY nombre_usuario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoCiclosE){
							$query = "UPDATE ciclos SET estatus = 0 WHERE id_ciclo = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus = 1");
						if($ciclos['ejecucion']==1){
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
				if($accesoCiclosC){
					$ciclos=$lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo > 1 and estatus = 0 ORDER BY nombre_usuario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoCiclosE){
							$query = "UPDATE ciclos SET estatus = 1 WHERE id_ciclo = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus = 0");
						if($ciclos['ejecucion']==1){
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
			}
			if($action=="Registrar"){
				if($accesoCiclosR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$numero_ciclo = $_POST['numero_ciclo'];
							$ano_ciclo = $_POST['ano_ciclo'];
							$query = "SELECT * FROM ciclos WHERE numero_ciclo = {$numero_ciclo} and ano_ciclo = '{$ano_ciclo}' and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$response = "9"; //echo "Registro ya guardado.";
									// $res2 = $lider->consultarQuery("SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 0");
									// if($res2['ejecucion']==true){
									//   if(Count($res2)>1){
									//     $res3 = $lider->modificar("UPDATE campanas SET estatus = 1 WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana");
									//     if($res3['ejecucion']==true){
									//       $response = "1";
									//     
									//   }else
									//     $response = "9"; //echo "Registro ya guardado."
									//   
									// }
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							// echo "asd";
							echo $response;
						}
						if(empty($_POST['validarData']) && !empty($_POST['numero']) && !empty($_POST['ano'])){
							// print_r($_POST);
							$numero_ciclo = $_POST['numero'];
							$ano_ciclo = $_POST['ano'];
							$fecha_apertura = $_POST['apertura'];
							$fecha_cierre = $_POST['cierre'];
							$fecha_pago = $_POST['pago'];
							$cuotas = $_POST['cuotas'];
							$precio_minimo = $_POST['precio'];
							$puntos_pago_puntual = $_POST['puntos'];

							$cantidadPagosCiclosFill = [];
							$indexFill = 0;
							foreach ($cantidadPagosCiclos as $pagosC) {
								if($pagosC['numero_cuota'] < $cuotas){
									$cantidadPagosCiclosFill[$indexFill] = $pagosC;
									$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = "";
									if($pagosC['cod']=="INI"){
										$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $fecha_pago;
									}else{
										$fechaPagoCuotaAnt = $cantidadPagosCiclosFill[$indexFill-1]['fecha_pago_cuota'];
										$newFechaPagoCuota = date('Y-m-d', strtotime($fechaPagoCuotaAnt. ' + 7 days'));
										$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $newFechaPagoCuota;
									}
									$indexFill++;
								}
							}
							// echo json_encode($cantidadPagosCiclosFill);
							// foreach ($cantidadPagosCiclosFill as $pagosCF) {
							// 	print_r($pagosCF);
							// 	echo "<br>";
							// 	echo $pagosCF['name']. " - ".$pagosCF['fecha_pago_cuota'];
							// 	echo "<br><br>";
							// }

							$buscar = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.numero_ciclo = {$numero_ciclo} and ciclos.ano_ciclo = '{$ano_ciclo}'");
							if(count($buscar)<2){
								$query = "INSERT INTO ciclos (id_ciclo, numero_ciclo, ano_ciclo, apertura_seleccion, cierre_seleccion, pago_inicio, cantidad_cuotas, precio_minimo, puntos_cuotas, estado_ciclo, visibilidad_ciclo, estatus) VALUES (DEFAULT, {$numero_ciclo}, '{$ano_ciclo}', '{$fecha_apertura}', '{$fecha_cierre}', '{$fecha_pago}', {$cuotas}, {$precio_minimo}, '{$puntos_pago_puntual}', 1, 0, 1)";
								$exec = $lider->registrar($query, "ciclos", "id_ciclo");
								if($exec['ejecucion']==true){
									// $response = "1";
									$id_ciclo = $exec['id'];
									$errors=0; 
									foreach ($cantidadPagosCiclosFill as $pagosCF) {
										$nameCiclo = $pagosCF['name'];
										$fechaCiclo = $pagosCF['fecha_pago_cuota'];
										$querys = "INSERT INTO pagos_ciclo (id_pago_ciclo, id_ciclo, numero_cuota, fecha_pago_cuota, estatus) VALUES (DEFAULT, {$id_ciclo}, '{$nameCiclo}', '{$fechaCiclo}', 1)";
										$exec2 = $lider->registrar($querys, "pagos_ciclo", "id_pago_ciclo");
										if($exec2['ejecucion']!=true){
											$errors++;
										}
									}
									if($errors==0){
										$response = "1";
									}else{
										$response = "2";
									}
								}else{
									$response = "2";
								}
							}else{
								$response = "9";
							}

							if(!empty($action)){
								if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
									require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
								}else{
									require_once 'public/views/error404.php';
								}
							}
						}
					}
					if(empty($_POST)){
						$yearActual = date("Y");
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 and ano_ciclo = '{$yearActual}'");
						$numeCiclo = 1;
						if(count($ciclos)>1){
							$numeCiclo = $ciclos[count($ciclos)-2]['numero_ciclo']+1;
						}
						if(!empty($action)){
							if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
								require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
							}else{
								require_once 'public/views/error404.php';
							}
						}
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Modificar"){
				if($accesoCiclosM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$numero_ciclo = $_POST['numero_ciclo'];
							$ano_ciclo = $_POST['ano_ciclo'];
							$query = "SELECT * FROM ciclos WHERE numero_ciclo = {$numero_ciclo} and ano_ciclo = '{$ano_ciclo}' and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									if($id==$res1[0]['id_ciclo']){
										$response = "1"; //echo "Registro ES EL MISMO.";
									}else{
										$response = "9"; //echo "Registro YA EXISTE.";
									}
									// $res2 = $lider->consultarQuery("SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 0");
									// if($res2['ejecucion']==true){
									//   if(Count($res2)>1){
									//     $res3 = $lider->modificar("UPDATE campanas SET estatus = 1 WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana");
									//     if($res3['ejecucion']==true){
									//       $response = "1";
									    
									//   }else
									//     $response = "9"; //echo "Registro ya guardado."
									  
									// }
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(empty($_POST['validarData']) && !empty($_POST['numero']) && !empty($_POST['ano'])){
							// print_r($_POST);
							$numero_ciclo = $_POST['numero'];
							$ano_ciclo = $_POST['ano'];
							$fecha_apertura = $_POST['apertura'];
							$fecha_cierre = $_POST['cierre'];
							$fecha_pago = $_POST['pago'];
							$cuotas = $_POST['cuotas'];
							$precio_minimo = $_POST['precio'];
							$puntos_pago_puntual = $_POST['puntos'];

							$cantidadPagosCiclosFill = [];
							$indexFill = 0;
							foreach ($cantidadPagosCiclos as $pagosC) {
								if($pagosC['numero_cuota'] < $cuotas){
									$cantidadPagosCiclosFill[$indexFill] = $pagosC;
									$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = "";
									if($pagosC['cod']=="INI"){
										$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $fecha_pago;
									}else{
										$fechaPagoCuotaAnt = $cantidadPagosCiclosFill[$indexFill-1]['fecha_pago_cuota'];
										$newFechaPagoCuota = date('Y-m-d', strtotime($fechaPagoCuotaAnt. ' + 7 days'));
										$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $newFechaPagoCuota;
									}
									$indexFill++;
								}
							}
							// echo json_encode($cantidadPagosCiclosFill);
							// foreach ($cantidadPagosCiclosFill as $pagosCF) {
							// 	print_r($pagosCF);
							// 	echo "<br>";
							// 	echo $pagosCF['name']. " - ".$pagosCF['fecha_pago_cuota'];
							// 	echo "<br><br>";
							// }

							$buscar = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.numero_ciclo = {$numero_ciclo} and ciclos.ano_ciclo = '{$ano_ciclo}'");
							if(Count($buscar)>1){
								if($id==$buscar[0]['id_ciclo']){
									$continuar = "1"; //echo "Registro ES EL MISMO.";
								}else{
									$continuar = "9"; //echo "Registro YA EXISTE.";
								}
							}else{
								$continuar = "1";
							}

							if($continuar=="1"){
								$query = "UPDATE ciclos SET numero_ciclo=$numero_ciclo, ano_ciclo='{$ano_ciclo}', apertura_seleccion='{$fecha_apertura}', cierre_seleccion='{$fecha_cierre}', pago_inicio='{$fecha_pago}', cantidad_cuotas={$cuotas}, precio_minimo={$precio_minimo}, puntos_cuotas='{$puntos_pago_puntual}', estatus=1 WHERE id_ciclo={$id}";

								$exec = $lider->modificar($query);
								if($exec['ejecucion']==true){
									// $response = "1";
									$execc = $lider->eliminar("DELETE FROM pagos_ciclo WHERE pagos_ciclo.id_ciclo = {$id}");
									if($execc['ejecucion']==true){
										$errors=0; 
										foreach ($cantidadPagosCiclosFill as $pagosCF) {
											$nameCiclo = $pagosCF['name'];
											$fechaCiclo = $pagosCF['fecha_pago_cuota'];
											$querys = "INSERT INTO pagos_ciclo (id_pago_ciclo, id_ciclo, numero_cuota, fecha_pago_cuota, estatus) VALUES (DEFAULT, {$id}, '{$nameCiclo}', '{$fechaCiclo}', 1)";
											$exec2 = $lider->registrar($querys, "pagos_ciclo", "id_pago_ciclo");
											if($exec2['ejecucion']!=true){
												$errors++;
											}
										}
										if($errors==0){
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
							}else{
								$response = "9";
							}
							

							if(!empty($action)){
								if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
									require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
								}else{
									require_once 'public/views/error404.php';
								}
							}
						}
					}
					if(empty($_POST)){
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 and id_ciclo = {$id}");
						if(count($ciclos)>1){
							$ciclo = $ciclos[0];
							if(!empty($action)){
								if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
									require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
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
			}
			if($action=="Personalizar"){
				if($accesoCiclosR){
					if(!empty($_POST)){
						if(!empty($_POST['cuotas'])){
							if(!empty($_GET['ciclo'])){
								$id_ciclo = $_GET['ciclo'];
								$cuotas = $_POST['cuotas'];
								$cicloPagos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE estatus=1 and id_ciclo={$id_ciclo}");
								$errorss = 0;
								foreach ($cicloPagos as $ciclo){ if(!empty($ciclo['id_ciclo'])){ 
									foreach ($cuotas as $key) {
										if($key==$ciclo['numero_cuota']){
											$query = "UPDATE pagos_ciclo SET opcion_ciclo='Nota' WHERE id_pago_ciclo={$ciclo['id_pago_ciclo']} and numero_cuota='{$key}'";
											$exec = $lider->modificar($query);
											if($exec['ejecucion']!=true){
												$errorss++;
											}
										}
									}
								} }
								if($errorss==0){
									$response="1";
								}else{
									$response="2";
								}
								$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 ORDER BY ciclos.id_ciclo DESC");
								if(count($ciclos)>1){
									$cicloSelect = [];
									if(!empty($_GET['ciclo'])){
										$ciclosSelected = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 and ciclos.id_ciclo = {$_GET['ciclo']} ORDER BY ciclos.id_ciclo DESC");
										if(count($ciclosSelected)>1){
											$cicloSelect = $ciclosSelected[0];
										}
									}
									if(!empty($action)){
										if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
											require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
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
						}
						// if(!empty($_POST['validarData'])){
						// 	$numero_ciclo = $_POST['numero_ciclo'];
						// 	$ano_ciclo = $_POST['ano_ciclo'];
						// 	$query = "SELECT * FROM ciclos WHERE numero_ciclo = {$numero_ciclo} and ano_ciclo = '{$ano_ciclo}' and estatus = 1";
						// 	$res1 = $lider->consultarQuery($query);
						// 	if($res1['ejecucion']==true){
						// 		if(Count($res1)>1){
						// 			if($id==$res1[0]['id_ciclo']){
						// 				$response = "1"; //echo "Registro ES EL MISMO.";
						// 			}else{
						// 				$response = "9"; //echo "Registro YA EXISTE.";
						// 			}
						// 			// $res2 = $lider->consultarQuery("SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 0");
						// 			// if($res2['ejecucion']==true){
						// 			//   if(Count($res2)>1){
						// 			//     $res3 = $lider->modificar("UPDATE campanas SET estatus = 1 WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana");
						// 			//     if($res3['ejecucion']==true){
						// 			//       $response = "1";
									    
						// 			//   }else
						// 			//     $response = "9"; //echo "Registro ya guardado."
									  
						// 			// }
						// 		}else{
						// 			$response = "1";
						// 		}
						// 	}else{
						// 		$response = "5"; // echo 'Error en la conexion con la bd';
						// 	}
						// 	echo $response;
						// }
						// if(empty($_POST['validarData']) && !empty($_POST['numero']) && !empty($_POST['ano'])){
						// 	// print_r($_POST);
						// 	$numero_ciclo = $_POST['numero'];
						// 	$ano_ciclo = $_POST['ano'];
						// 	$fecha_apertura = $_POST['apertura'];
						// 	$fecha_cierre = $_POST['cierre'];
						// 	$fecha_pago = $_POST['pago'];
						// 	$cuotas = $_POST['cuotas'];
						// 	$precio_minimo = $_POST['precio'];
						// 	$puntos_pago_puntual = $_POST['puntos'];

						// 	$cantidadPagosCiclosFill = [];
						// 	$indexFill = 0;
						// 	foreach ($cantidadPagosCiclos as $pagosC) {
						// 		if($pagosC['numero_cuota'] < $cuotas){
						// 			$cantidadPagosCiclosFill[$indexFill] = $pagosC;
						// 			$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = "";
						// 			if($pagosC['cod']=="INI"){
						// 				$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $fecha_pago;
						// 			}else{
						// 				$fechaPagoCuotaAnt = $cantidadPagosCiclosFill[$indexFill-1]['fecha_pago_cuota'];
						// 				$newFechaPagoCuota = date('Y-m-d', strtotime($fechaPagoCuotaAnt. ' + 7 days'));
						// 				$cantidadPagosCiclosFill[$indexFill]['fecha_pago_cuota'] = $newFechaPagoCuota;
						// 			}
						// 			$indexFill++;
						// 		}
						// 	}
						// 	// echo json_encode($cantidadPagosCiclosFill);
						// 	// foreach ($cantidadPagosCiclosFill as $pagosCF) {
						// 	// 	print_r($pagosCF);
						// 	// 	echo "<br>";
						// 	// 	echo $pagosCF['name']. " - ".$pagosCF['fecha_pago_cuota'];
						// 	// 	echo "<br><br>";
						// 	// }

						// 	$buscar = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.numero_ciclo = {$numero_ciclo} and ciclos.ano_ciclo = '{$ano_ciclo}'");
						// 	if(Count($buscar)>1){
						// 		if($id==$buscar[0]['id_ciclo']){
						// 			$continuar = "1"; //echo "Registro ES EL MISMO.";
						// 		}else{
						// 			$continuar = "9"; //echo "Registro YA EXISTE.";
						// 		}
						// 	}else{
						// 		$continuar = "1";
						// 	}

						// 	if($continuar=="1"){
						// 		$query = "UPDATE ciclos SET numero_ciclo=$numero_ciclo, ano_ciclo='{$ano_ciclo}', apertura_seleccion='{$fecha_apertura}', cierre_seleccion='{$fecha_cierre}', pago_inicio='{$fecha_pago}', cantidad_cuotas={$cuotas}, precio_minimo={$precio_minimo}, puntos_cuotas='{$puntos_pago_puntual}', estatus=1 WHERE id_ciclo={$id}";

						// 		$exec = $lider->modificar($query);
						// 		if($exec['ejecucion']==true){
						// 			// $response = "1";
						// 			$execc = $lider->eliminar("DELETE FROM pagos_ciclo WHERE pagos_ciclo.id_ciclo = {$id}");
						// 			if($execc['ejecucion']==true){
						// 				$errors=0; 
						// 				foreach ($cantidadPagosCiclosFill as $pagosCF) {
						// 					$nameCiclo = $pagosCF['name'];
						// 					$fechaCiclo = $pagosCF['fecha_pago_cuota'];
						// 					$querys = "INSERT INTO pagos_ciclo (id_pago_ciclo, id_ciclo, numero_cuota, fecha_pago_cuota, estatus) VALUES (DEFAULT, {$id}, '{$nameCiclo}', '{$fechaCiclo}', 1)";
						// 					$exec2 = $lider->registrar($querys, "pagos_ciclo", "id_pago_ciclo");
						// 					if($exec2['ejecucion']!=true){
						// 						$errors++;
						// 					}
						// 				}
						// 				if($errors==0){
						// 					$response = "1";
						// 				}else{
						// 					$response = "2";
						// 				}
						// 			}else{
						// 				$response = "2";
						// 			}
						// 		}else{
						// 			$response = "2";
						// 		}
						// 	}else{
						// 		$response = "9";
						// 	}
							

						// 	if(!empty($action)){
						// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
						// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
						// 		}else{
						// 			require_once 'public/views/error404.php';
						// 		}
						// 	}
						// }
					}
					if(empty($_POST)){
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 ORDER BY ciclos.id_ciclo DESC");
						$ciclosPagos = [];
						if(count($ciclos)>1){
							$cicloSelect = [];
							if(!empty($_GET['ciclo'])){
								$ciclosPagos = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE id_ciclo={$_GET['ciclo']}");
								$ciclosSelected = $lider->consultarQuery("SELECT * FROM ciclos WHERE estatus = 1 and ciclos.id_ciclo = {$_GET['ciclo']} ORDER BY ciclos.id_ciclo DESC");
								if(count($ciclosSelected)>1){
									$cicloSelect = $ciclosSelected[0];
								}
							}
							if(!empty($action)){
								if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
									require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
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
			}
		}
	}

?>