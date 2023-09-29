<?php
	if(strtolower($url)=="inventario"){
		if(!empty($action)){
			$accesoInventariosR = false;
			$accesoInventariosC = false;
			$accesoInventariosM = false;
			$accesoInventariosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Inventarios")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoInventariosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoInventariosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoInventariosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoInventariosE=true; }
					}
				}
			}
			if($action=="Consultar"){
				if($accesoInventariosC){
					$inventarios=$lider->consultarQuery("SELECT * FROM inventarios WHERE estatus = 1 ORDER BY nombre_inventario asc;");
					if(!empty($_GET['operation'])){
						$nValor = 0;
						if(mb_strtolower($_GET['operation'])==mb_strtolower("Ocultar")){
							$nValor = 0;
						}
						if(mb_strtolower($_GET['operation'])==mb_strtolower("Mostrar")){
							$nValor = 1;
						}
						$query="UPDATE inventarios SET inventario_visible={$nValor} WHERE cod_inventario='{$id}'";
						$exec = $lider->modificar($query);
						if($exec['ejecucion']==true){
							$response2 = "1";
						}else{
							$response2 = "2";
						}
					}
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoInventariosE){
							$query = "UPDATE inventarios SET estatus = 0 WHERE cod_inventario = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 1");
						if($inventarios['ejecucion']==1){
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
				if($accesoInventariosC){
					$inventarios=$lider->consultarQuery("SELECT * FROM inventarios WHERE estatus = 0 ORDER BY nombre_inventario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoInventariosE){
							$query = "UPDATE inventarios SET estatus = 1 WHERE id_inventario = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
					}
					if(empty($_POST)){
						$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE inventarios.estatus = 0");
						if($inventarios['ejecucion']==1){
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
				if($accesoInventariosR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$codigo = mb_strtoupper($_POST['codigo']);
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$precio = $_POST['precio'];

							$query = "SELECT * FROM inventarios WHERE cod_inventario='{$codigo}' and nombre_inventario = '{$nombre}' and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							// print_r($res1);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									// $response = "9"; //echo "Registro ya guardado.";
									$res2 = $lider->consultarQuery("SELECT * FROM inventarios WHERE cod_inventario='{$codigo}' and nombre_inventario = '{$nombre}' and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE inventarios SET estatus = 1 WHERE cod_inventario='{$codigo}' and nombre_inventario = '{$nombre}' and precio_inventario = $precio");
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
						if(empty($_POST['validarData']) && isset($_POST['codigo']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['puntos'])){
							$codigo = "";
							$nombre = "";
							$precio = "";
							$puntos = "";
							$imagen = "";

							$codigo = mb_strtoupper($_POST['codigo']);
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$precio = $_POST['precio'];
							$puntos = $_POST['puntos'];
							$descripcion = ucwords(strtolower($_POST['descripcion']));
							$dirCatalogo = "public/assets/img/inventario/";
							// print_r($_FILES);
							if(!empty($_FILES['imagen'])){
								$imgCatalogo = $_FILES['imagen'];

								$nameImg = $imgCatalogo['name'];
								if(isset($nameImg) && $nameImg!=""){
									$tipoImg = $imgCatalogo['type'];
									$extPos = strpos($tipoImg, "/");
									$extImg = substr($tipoImg, $extPos+1);
									$sizeImg = $imgCatalogo['size'];
									$tempImg = $imgCatalogo['tmp_name'];
									$errorImg = $imgCatalogo['error'];
									// echo "<br><br>";
									// echo "Tipo IMG: ".$tipoImg."<br>";
									// echo "Extension IMG: ".$extImg."<br>";
									// echo "Tamanio IMG: ".($sizeImg/1000000)." MB<br>";
									// echo "archivo temp IMG: ".$tempImg."<br>";
									// echo "Error IMG: ".$errorImg."<br>";

									if(!( strpos($tipoImg, 'jpeg') || strpos($tipoImg, 'jpg') || strpos($tipoImg, 'png') || strpos($tipoImg, 'JPEG') || strpos($tipoImg, 'JPG') || strpos($tipoImg, 'PNG') )){
										$responseImg = "73";  // Formato error
									}else{
										if(!( $sizeImg < 10000000 )){ // 10 MB - 10000 KB - 10000000 Bytes
											$responseImg = "74";   // tam limite Superado error
										}else{
											if($extImg=="jpeg"||$extImg=="jpg"||$extImg=="JPEG"||$extImg=="JPG"){$extImg = "jpg";}
											if($extImg=="png"||$extImg=="PNG"){ $extImg = "png";}
											$final = $dirCatalogo.$codigo.$nombre.$precio.'.'.$extImg;
											if($errorImg=="0"){
												if(move_uploaded_file($tempImg, $final)){
													$responseImg = "1";
													$imagen = $final;
												}else{
													$responseImg = "72";  // Error al cargar
												}
											}else{
												$responseImg = "75"; // Error error
											}
										}
									}
								}
							}

							$query = "INSERT INTO inventarios (cod_inventario, nombre_inventario, imagen_inventario, precio_inventario, puntos_inventario, descripcion_inventario, estatus) VALUES ('{$codigo}', '{$nombre}', '{$imagen}', {$precio}, {$puntos}, '{$descripcion}', 1)";
							$exec = $lider->registrar($query, "inventarios", "cod_inventario");
							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
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
				if($accesoInventariosM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$codigo = mb_strtoupper($_POST['codigo']);
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$precio = $_POST['precio'];
							$puntos = $_POST['puntos'];

							$query = "SELECT * FROM inventarios WHERE cod_inventario='{$codigo}' and nombre_inventario = '{$nombre}' and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									if($id==$res1[0]['cod_inventario']){
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
						if(empty($_POST['validarData']) && isset($_POST['codigo']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['puntos'])){
							$codigo = "";
							$nombre = "";
							$precio = "";
							$puntos = "";
							$imagen = "";

							$codigo = mb_strtoupper($_POST['codigo']);
							$nombre = ucwords(mb_strtolower($_POST['nombre']));
							$precio = $_POST['precio'];
							$puntos = $_POST['puntos'];
							$descripcion = ucwords(strtolower($_POST['descripcion']));
							$dirCatalogo = "public/assets/img/inventario/";
							// print_r($_FILES);
							if(!empty($_FILES['imagen'])){
								$imgCatalogo = $_FILES['imagen'];

								$nameImg = $imgCatalogo['name'];
								if(isset($nameImg) && $nameImg!=""){
									$tipoImg = $imgCatalogo['type'];
									$extPos = strpos($tipoImg, "/");
									$extImg = substr($tipoImg, $extPos+1);
									$sizeImg = $imgCatalogo['size'];
									$tempImg = $imgCatalogo['tmp_name'];
									$errorImg = $imgCatalogo['error'];
									// echo "<br><br>";
									// echo "Tipo IMG: ".$tipoImg."<br>";
									// echo "Extension IMG: ".$extImg."<br>";
									// echo "Tamanio IMG: ".($sizeImg/1000000)." MB<br>";
									// echo "archivo temp IMG: ".$tempImg."<br>";
									// echo "Error IMG: ".$errorImg."<br>";

									if(!( strpos($tipoImg, 'jpeg') || strpos($tipoImg, 'jpg') || strpos($tipoImg, 'png') || strpos($tipoImg, 'JPEG') || strpos($tipoImg, 'JPG') || strpos($tipoImg, 'PNG') )){
										$responseImg = "73";  // Formato error
									}else{
										if(!( $sizeImg < 10000000 )){ // 10 MB - 10000 KB - 10000000 Bytes
											$responseImg = "74";   // tam limite Superado error
										}else{
											if($extImg=="jpeg"||$extImg=="jpg"||$extImg=="JPEG"||$extImg=="JPG"){$extImg = "jpg";}
											if($extImg=="png"||$extImg=="PNG"){ $extImg = "png";}
											$final = $dirCatalogo.$codigo.$nombre.$precio.'.'.$extImg;
											if($errorImg=="0"){
												if(move_uploaded_file($tempImg, $final)){
													$responseImg = "1";
													$imagen = $final;
												}else{
													$responseImg = "72";  // Error al cargar
												}
											}else{
												$responseImg = "75"; // Error error
											}
										}
									}
								}
							}
							if($imagen==""){
								$query = "UPDATE inventarios SET cod_inventario='{$codigo}', nombre_inventario='{$nombre}', precio_inventario={$precio}, puntos_inventario={$puntos}, descripcion_inventario='{$descripcion}', estatus=1 WHERE cod_inventario='{$id}'";
							}else{
								$query = "UPDATE inventarios SET cod_inventario='{$codigo}', nombre_inventario='{$nombre}', imagen_inventario='{$imagen}', precio_inventario={$precio}, puntos_inventario={$puntos}, descripcion_inventario='{$descripcion}', estatus=1 WHERE cod_inventario='{$id}'";
							}
							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
							}

							$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE estatus = 1 and cod_inventario = '{$codigo}'");
							// print_r($inventarios);
							if(count($inventarios)>1){
								$inventario = $inventarios[0];
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
					}
					if(empty($_POST)){
						$inventarios = $lider->consultarQuery("SELECT * FROM inventarios WHERE estatus = 1 and cod_inventario = '{$id}'");
						if(count($inventarios)>1){
							$inventario = $inventarios[0];
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
			if($action=="Fechas"){
				if($personalAdmin){
					// $apertura = "";
					// $cierre = "";
					$fechaInventarios = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE estatus = 1");
					if(count($fechaInventarios)>1){
						$apertura = $fechaInventarios[0]['fecha_apertura_catalogo'];
						$cierre = $fechaInventarios[0]['fecha_cierre_catalogo'];
						// print_r($fechaInventario);
					}

					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$apertura = $_POST['apertura'];
							$cierre = $_POST['cierre'];
							$query = "SELECT * FROM fechas_catalogo WHERE fecha_apertura_catalogo = '{$apertura}' and fecha_cierre_catalogo = '{$cierre}' and id_fecha_catalogo = 1 and estatus = 1";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$res2 = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE fecha_apertura_catalogo = '{$apertura}' and fecha_cierre_catalogo = '{$cierre}' and id_fecha_catalogo = 1 and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE fechas_catalogo SET estatus = 1, fecha_apertura_catalogo = '{$apertura}', fecha_cierre_catalogo = '{$cierre}' WHERE id_fecha_catalogo = 1");
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
						if(empty($_POST['validarData']) && isset($_POST['apertura']) && isset($_POST['cierre'])){
							$apertura = $_POST['apertura'];
							$cierre = $_POST['cierre'];
							$buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
							if(count($buscar)>1){
								$query = "UPDATE fechas_catalogo SET fecha_apertura_catalogo='$apertura', fecha_cierre_catalogo='$cierre', estatus=1 WHERE id_fecha_catalogo=1";
								$exec = $lider->modificar($query);
								if($exec['ejecucion']==true){
									$response = "1";
								}else{
									$response = "2";
								}
							}else{
								$query = "INSERT INTO fechas_catalogo (id_fecha_catalogo, fecha_apertura_catalogo, fecha_cierre_catalogo, estatus) VALUES (1, '$apertura', '$cierre', 1)";
								$exec = $lider->registrar($query, "fechas_catalogo", "id_fecha_catalogo");
								if($exec['ejecucion']==true){
									$response = "1";
								}else{
									$response = "2";
								}
							}
							$buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
							$apertura = "";
							$cierre = "";
							if(count($buscar)>1){
								$apertura = $buscar[0]['fecha_apertura_catalogo'];
								$cierre = $buscar[0]['fecha_cierre_catalogo'];
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
			}
		}
	}

?>