<?php
	if(strtolower($url)=="usuarios"){
		if(!empty($action)){
			$accesoUsuariosR = false;
			$accesoUsuariosC = false;
			$accesoUsuariosM = false;
			$accesoUsuariosE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Usuarios")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoUsuariosR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoUsuariosC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoUsuariosM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoUsuariosE=true; }
					}
				}
			}
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoUsuariosC){
					$usuarios=$lider->consultarQuery("SELECT * FROM usuarios WHERE estatus = 1 ORDER BY nombre_usuario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoUsuariosE){
							$query = "UPDATE usuarios SET estatus = 0 WHERE id_usuario = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$usuarios = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1");
						if($usuarios['ejecucion']==1){
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
				if($accesoUsuariosC){
					$usuarioss=$lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario > 1 and estatus = 0 ORDER BY nombre_usuario asc;");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoUsuariosE){
							$query = "UPDATE usuarios SET estatus = 1 WHERE id_usuario = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$usuarioss = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 0 and usuarios.id_usuario > 1");
						if($usuarioss['ejecucion']==1){
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
				if($accesoUsuariosR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
							$query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									// $response = "9"; //echo "Registro ya guardado.";
									$res2 = $lider->consultarQuery("SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE usuarios SET estatus = 1 WHERE nombre_usuario = '$nombre_usuario'");
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
						if(!empty($_POST['nombre_usuario']) && !empty($_POST['password'])){
							$nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
							$password = $_POST['password'];
							$id_rol = $_POST['rol'];
							$id_cliente = $_POST['cliente'];
							$buscar = $lider->consultarQuery("SELECT * FROM usuarios WHERE usuarios.id_cliente = {$id_cliente}");
							if(count($buscar)<2){
								$query = "INSERT INTO usuarios (id_usuario, id_rol, id_cliente, nombre_usuario, password, estatus) VALUES (DEFAULT, $id_rol, $id_cliente, '$nombre_usuario', '$password', 1)";
								$exec = $lider->registrar($query, "usuarios", "id_usuario");
								if($exec['ejecucion']==true){
									$response = "1";
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
						$usuarios = $lider->consultarQuery("SELECT * FROM usuarios");
						$roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 ORDER BY id_rol asc");
						$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
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
				if($accesoUsuariosM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$query = "SELECT * FROM usuarios WHERE id_usuario = $id";
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
						if(!empty($_POST['nombre_usuario']) && !empty($_POST['password'])){
							$nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
							$password = $_POST['password'];
							$id_rol = $_POST['rol'];
							$id_cliente = $_POST['cliente'];
							$campAnt = $lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario = $id");
							$query = "UPDATE usuarios SET id_rol=$id_rol, id_cliente=$id_cliente, nombre_usuario='$nombre_usuario', password='$password', estatus = 1 WHERE id_usuario = $id";

							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
							}

							$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
							$usuarios = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
							$usuario = $usuarios[0];
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
						}
					}
					if(empty($_POST)){
						$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
						$roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 ORDER BY id_rol asc");
						$usuarios = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
						if(Count($usuarios)>1){
							$usuario = $usuarios[0];
							if(!empty($action)){
								if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
									require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
								}else{
									require_once 'public/views/error404.php';
								}
							}
						}
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
	}
?>