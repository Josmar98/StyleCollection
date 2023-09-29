<?php
	if(strtolower($url)=="liderazgosciclos"){
		$id_ciclo = $_GET['c'];
		$num_ciclo = $_GET['n'];
		$ano_ciclo = $_GET['y'];
		$menu = "c=".$id_ciclo."&n=".$num_ciclo."&y=".$ano_ciclo;
		if(!empty($action)){
			$accesoLiderazgosCiclosR = false;
			$accesoLiderazgosCiclosC = false;
			$accesoLiderazgosCiclosM = false;
			$accesoLiderazgosCiclosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos De Ciclos")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoLiderazgosCiclosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoLiderazgosCiclosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoLiderazgosCiclosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoLiderazgosCiclosE=true; }
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
				if($accesoLiderazgosCiclosC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoLiderazgosCiclosE){
							$query = "UPDATE liderazgos_ciclos SET estatus = 0 WHERE id_lc = $id";
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
						$query = "SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1";
						$liderazgos = $lider->consultarQuery($query);
						if($liderazgos['ejecucion']==1){
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
				if($accesoLiderazgosCiclosC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoLiderazgosCiclosE){
							$query = "UPDATE liderazgos_ciclos SET estatus = 1 WHERE id_lc = $id";
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
						$query = "SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos_ciclos.id_liderazgo = liderazgos.id_liderazgo and liderazgos_ciclos.id_ciclo = $id_ciclo and liderazgos_ciclos.estatus = 0";
						$liderazgos = $lider->consultarQuery($query);
						if($liderazgos['ejecucion']==1){
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
				if($accesoLiderazgosCiclosR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id_liderazgo = $_POST['id_liderazgo'];
							$query = "SELECT * FROM liderazgos_ciclos WHERE id_liderazgo = $id_liderazgo and id_ciclo = $id_ciclo and estatus = 1";
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
								$totalDescuento = (Float) $descuento_coleccion+$canDescuento;
								$query = "INSERT INTO liderazgos_ciclos (id_lc, id_liderazgo, id_ciclo, precio_minimo, precio_maximo, descuento_liderazgos, descuento_total, estatus) VALUES (DEFAULT, $id_liderazgo, $id_ciclo, $minima, $maxima, $descuento_coleccion, $totalDescuento, 1)";
								
								$exec = $lider->registrar($query, "liderazgos_ciclos", "id_lc");
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

							}else{
								$response = '2';
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
						$liderazgos=$lider->consultar("liderazgos");
						$liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_ciclos WHERE liderazgos.id_liderazgo = liderazgos_ciclos.id_liderazgo and liderazgos_ciclos.id_ciclo = {$id_ciclo} and liderazgos_ciclos.estatus = 1 ORDER BY liderazgos_ciclos.id_liderazgo ASC");
						$cant = count($liderss)-1;
						$idLim = $cant;
						if($cant>0){
							$max = $liderss[$cant-1]['descuento_total'];
							$idLim = $liderss[$cant-1]['id_liderazgo'];
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Modificar"){
				if($accesoLiderazgosCiclosM){
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
			
		}
	}

?>