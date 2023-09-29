<?php
	if(strtolower($url)=="liderazgos"){
		if(!empty($action)){
			$accesoLiderazgosR = false;
			$accesoLiderazgosC = false;
			$accesoLiderazgosM = false;
			$accesoLiderazgosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoLiderazgosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoLiderazgosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoLiderazgosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoLiderazgosE=true; }
					}
				}
			}
			if($action=="Consultar"){
				if($accesoLiderazgosC){
					$liderazgos=$lider->consultar("liderazgos");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoLiderazgosE == 1){
							$query = "UPDATE liderazgos SET estatus = 0 WHERE id_liderazgo = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}else{
							$response = "2"; // echo 'Error en la conexion con la bd';
						}
					}
					if(empty($_POST)){
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
				if($accesoLiderazgosC){
					$liderazgos=$lider->consultarQuery("SELECT * FROM liderazgos WHERE estatus = 0");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoLiderazgosE == 1){
							$query = "UPDATE liderazgos SET estatus = 1 WHERE id_liderazgo = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
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
				if($accesoLiderazgosR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$nombre_liderazgo = mb_strtoupper($_POST['nombre_liderazgo']);
							$query = "SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									// $response = "9"; //echo "Registro ya guardado.";
									$res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
											if($res3['ejecucion']==true){
												$response = "1";
											}
										}else{
											$response = "9"; //echo "Registro ya guardado.";
										}
									}
								}else{
									$response = "1";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(!empty($_POST['titulo'])){
							$nombre_liderazgo = mb_strtoupper($_POST['titulo']);
							$color_liderazgo = mb_strtoupper($_POST['color']);
							$query = "INSERT INTO liderazgos (id_liderazgo, nombre_liderazgo, color_liderazgo, estatus) VALUES (DEFAULT, '$nombre_liderazgo', '$color_liderazgo', 1)";
							$exec = $lider->registrar($query, "liderazgos", "id_liderazgo");
							if($exec['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Registrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
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
				if($accesoLiderazgosM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id = $_POST['id'];
							$query = "SELECT * FROM liderazgos WHERE id_liderazgo = $id";
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
							$id_liderazgo = $_POST['id'];
							$nombre_liderazgo = mb_strtoupper($_POST['titulo']);
							$color_liderazgo = mb_strtoupper($_POST['color']);

							$query = "UPDATE liderazgos SET nombre_liderazgo = '$nombre_liderazgo', color_liderazgo = '$color_liderazgo', estatus = 1 WHERE id_liderazgo = $id";
							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Liderazgos', 'Editar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2";
							}
							$query = "SELECT * FROM liderazgos WHERE estatus = 1 and id_liderazgo = $id";
							$liderazgo=$lider->consultarQuery($query);
							$datas = $liderazgo[0];

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
						$query = "SELECT * FROM liderazgos WHERE estatus = 1 and id_liderazgo = $id";
						$liderazgo=$lider->consultarQuery($query);
						if(Count($liderazgo)>1){
							$datas = $liderazgo[0];
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