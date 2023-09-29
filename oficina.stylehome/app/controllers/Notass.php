<?php
	if(strtolower($url)=="notass"){
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
			// $cantidadCarrito = 0;
			$classHidden="";
			// $buscar = $lider->consultarQuery("SELECT * FROM carrito WHERE id_ciclo = {$id_ciclo} and id_cliente = {$id_cliente} and carrito.estatus=1");
			// if($buscar['ejecucion']==true){
			// 	$cantidadCarrito = count($buscar)-1;
			// }
			// if($cantidadCarrito==0){
			// 	$classHidden="d-none";
			// }

			$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus=1 and ciclos.visibilidad_ciclo=1 ORDER BY ciclos.id_ciclo DESC;");
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			
			if($action=="Redirigir"){
				if($accesoNotasR || $accesoNotasC){
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
						$cicloNotas = [];
						$index2 = 0;
						foreach ($ciclos as $ciclo){ if(!empty($ciclo['id_ciclo'])){
							$id_ciclo = $ciclo['id_ciclo'];
							$pagosCiclos = $lider->consultarQuery("SELECT * FROM ciclos, pagos_ciclo WHERE ciclos.id_ciclo = pagos_ciclo.id_ciclo and ciclos.id_ciclo = {$id_ciclo}");

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
								$cicloNotas[$index2] = $ciclo;
								$cicloNotas[$index2] += $ultimaCuota;
								$index2++;
							}
						} }
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
		}
	}

?>