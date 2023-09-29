<?php
	if(strtolower($url)=="existencias"){
		if(!empty($action)){
			$accesoExistenciasR = false;
			$accesoExistenciasC = false;
			$accesoExistenciasM = false;
			$accesoExistenciasE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Existencias")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoExistenciasR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoExistenciasC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoExistenciasM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoExistenciasE=true; }
					}
				}
			}
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoExistenciasC){
					$inventarios=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.estatus = 1 ORDER BY inventarios.nombre_inventario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoExistenciasE){
							$query = "UPDATE existencias SET estatus = 0 WHERE id_existencia = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$existencias=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and inventarios.estatus = 1 and existencias.estatus = 1 ORDER BY inventarios.nombre_inventario asc;");
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
			if($action=="Borrados"){
				if($accesoExistenciasC){
					$inventarios=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.estatus = 0 ORDER BY inventarios.nombre_inventario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoExistenciasE){
							$query = "UPDATE existencias SET estatus = 1 WHERE id_existencia = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$existencias=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and inventarios.estatus = 1 and existencias.estatus = 0 ORDER BY inventarios.nombre_inventario asc;");
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
			if($action=="Registrar"){
				if($accesoExistenciasR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$premio = $_POST['premio'];
							$total = $_POST['total'];

							$query = "SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.cod_inventario = '{$premio}'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									// $response = "9"; //echo "Registro ya guardado.";
									$query = "SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.cod_inventario = '{$premio}' and existencias.estatus = 0 ORDER BY inventarios.nombre_inventario asc;";
									$res2 = $lider->consultarQuery($query);

									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE existencias SET estatus = 1 WHERE existencias.cod_inventario = '{$premio}'");
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
						if(empty($_POST['validarData']) && isset($_POST['premio']) && isset($_POST['total']) ){
							// print_r($_POST);
							$cod_inventario = $_POST['premio'];
							$cantidad_total = $_POST['total'];
							$query = "INSERT INTO existencias (id_existencia, cod_inventario, cantidad_total, cantidad_disponible, cantidad_bloqueada, cantidad_exportada, estatus) VALUES (DEFAULT, '{$cod_inventario}', {$cantidad_total}, {$cantidad_total}, 0, 0, 1)";
							$exec = $lider->registrar($query, "existencias", "id_existencia");
							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
							}

							$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 ORDER BY inventarios.nombre_inventario ASC;");
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
						$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1 ORDER BY inventarios.nombre_inventario ASC;");
						$existencias=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and inventarios.estatus = 1 and existencias.estatus = 1 ORDER BY inventarios.nombre_inventario asc;");
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
				if($accesoExistenciasM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$premio = $_POST['premio'];
							$total = $_POST['total'];

							$query = "SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.cod_inventario = '{$premio}';";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									if($res1[0]['id_existencia']==$id){
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
						if(empty($_POST['validarData']) && isset($_POST['premio']) && isset($_POST['total']) ){
							// print_r($_POST);
							$cod_inventario = $_POST['premio'];
							$disponibles = $_POST['disponible'];
							$cantidad_total = $_POST['total'];
							$buscar = $lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and existencias.cod_inventario = '{$cod_inventario}' and existencias.id_existencia={$id}");
							if(count($buscar)>1){
								$busc = $buscar[0];
								// $disp = $cantidad_total - $busc['cantidad_bloqueada'];
								$query = "UPDATE existencias SET cod_inventario = '{$cod_inventario}', cantidad_total = {$cantidad_total}, cantidad_disponible = {$disponibles}, cantidad_bloqueada = {$busc['cantidad_bloqueada']}, estatus = 1 WHERE id_existencia = {$id}";
								$exec = $lider->modificar($query);
								if($exec['ejecucion']==true){
									$response = "1";
								}else{
									$response = "2";
								}
							}else{
								$response = "2";
							}
							$existencias=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and inventarios.estatus = 1 and existencias.estatus = 1 and existencias.id_existencia = {$id} ORDER BY inventarios.nombre_inventario asc;");
							if(count($existencias)>1){
								$existencia = $existencias[0];
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
						$existencias=$lider->consultarQuery("SELECT * FROM existencias, inventarios WHERE existencias.cod_inventario = inventarios.cod_inventario and inventarios.estatus = 1 and existencias.estatus = 1 and existencias.id_existencia = {$id} ORDER BY inventarios.nombre_inventario asc;");
						if(count($existencias)>1){
							$existencia = $existencias[0];
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