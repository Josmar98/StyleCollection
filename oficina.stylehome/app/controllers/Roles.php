<?php
	if(strtolower($url)=="roles"){
		if(!empty($action)){
			$accesoRoles = false;
			$accesoRolesR = false;
			$accesoRolesC = false;
			$accesoRolesM = false;
			$accesoRolesE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Roles")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoRolesR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoRolesC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoRolesM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoRolesE=true; }
					}
				}
			}
			if($action=="Consultar"){
				if($accesoRolesC){
					$roles=$lider->consultar("roles");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoRolesE){
							$query = "UPDATE roles SET estatus = 0 WHERE id_rol = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Roles', 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						if($roles['ejecucion']==1){
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
				if($accesoRolesC){
					$roles=$lider->consultarQuery("SELECT * FROM roles WHERE estatus = 0");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoRolesE){
							$query = "UPDATE roles SET estatus = 1 WHERE id_rol = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Roles', 'Borrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						if($roles['ejecucion']==1){
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
				if($accesoRolesR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$query = "SELECT * FROM roles WHERE nombre_rol = '$nombre'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$res2 = $lider->consultarQuery("SELECT * FROM roles WHERE nombre_rol = '$nombre' and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE roles SET estatus = 1 WHERE nombre_rol = '$nombre'");
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
						if(!empty($_POST['nombre']) && empty($_POST['validarData'])){
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$query = "INSERT INTO roles (id_rol, nombre_rol,  estatus) VALUES (DEFAULT, '$nombre', 1)";
							$exec = $lider->registrar($query, "roles", "id_rol");
							if($exec['ejecucion']==true){
								if(!empty($_POST['accesos'])){
									$accesos = $_POST['accesos'];
									$id_rol = $exec['id'];
									foreach ($accesos as $key) {
										$id_permiso = $_POST["permiso".$key];
										$id_modulo = $_POST["modulo".$key];
										$query = "INSERT INTO accesos (id_acceso, id_rol, id_permiso, id_modulo) VALUES (DEFAULT, $id_rol, $id_permiso, $id_modulo)";
										$exec = $lider->registrar($query, "accesos", "id_acceso");
										if($exec['ejecucion']==true ){
											$response = "1";
										}else{
											$response = "2";
										}
									}
								}else{
									$response = "1";
								}
								// if(!empty($modulo) && !empty($accion)){
								// 	$fecha = date('Y-m-d');
								// 	$hora = date('H:i:a');
								// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Roles', 'Registrar', '{$fecha}', '{$hora}')";
								// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
								// }
							}else{
								$response = "2";
							}
							$modulos = $lider->consultar("modulos");
							$permisos = $lider->consultar("permisos");
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
						$modulos = $lider->consultar("modulos");
						$permisos = $lider->consultar("permisos");
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
				if($accesoRolesM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$query = "SELECT * FROM roles WHERE id_rol = $id";
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
						if(!empty($_POST['nombre']) && empty($_POST['validarData'])){
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$query = "UPDATE roles SET nombre_rol='$nombre', estatus=1 WHERE id_rol = $id";
							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$exec = $lider->eliminar("DELETE from accesos WHERE id_rol = $id");
								if($exec['ejecucion']==true){
									if(!empty($_POST['accesos'])){
										$accesoss = $_POST['accesos'];
										foreach ($accesoss as $key) {
											$id_permiso = $_POST["permiso".$key];
											$id_modulo = $_POST["modulo".$key];
											$query = "INSERT INTO accesos (id_acceso, id_rol, id_permiso, id_modulo) VALUES (DEFAULT, $id, $id_permiso, $id_modulo)";
											$exec = $lider->registrar($query, "accesos", "id_acceso");
											if($exec['ejecucion']==true ){
												$response = "1";
											}else{
												$response = "2";
											}
										}
									}else{
										$response = "1";
									}
									// if(!empty($modulo) && !empty($accion)){
									// 	$fecha = date('Y-m-d');
									// 	$hora = date('H:i:a');
									// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Roles', 'Editar', '{$fecha}', '{$hora}')";
									// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
									// }
								}else{
									$response = "2";
								}
							}else{
								$response = "2";
							}
							$rol2 = $lider->consultarQuery("SELECT * FROM roles WHERE id_rol = $id");
							$rols = $rol2[0];
							$modulos = $lider->consultar("modulos");
							$permisos = $lider->consultar("permisos");
							$accesoss = $lider->consultarQuery("SELECT * from accesos WHERE id_rol = $id");
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
						$rol2 = $lider->consultarQuery("SELECT * FROM roles WHERE id_rol = $id");
						$modulos = $lider->consultar("modulos");
						$permisos = $lider->consultar("permisos");
						$accesoss = $lider->consultarQuery("SELECT * from accesos WHERE id_rol = $id");
						if(Count($rol2)>1){
							$rols = $rol2[0];
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