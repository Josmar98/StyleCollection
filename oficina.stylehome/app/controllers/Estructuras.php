<?php 
	if(strtolower($url)=="estructuras"){
		if(!empty($action)){
			$accesoEstructurasR = false;
			$accesoEstructurasC = false;
			$accesoEstructurasM = false;
			$accesoEstructurasE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Estructuras")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoEstructurasR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoEstructurasC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoEstructurasM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoEstructurasE=true; }
					}
				}
			}
			if($action=="Consultar"){
				if($accesoEstructurasC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoEstructurasE){
							$query = "UPDATE estructuras SET estatus = 0 WHERE analista = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1");
						$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1");
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Borrados"){
				if($accesoEstructurasC){
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoEstructurasE){
							$query = "UPDATE estructuras SET estatus = 0 WHERE analista = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if(empty($_POST)){
						$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 0");
						$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1");
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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Detalles"){
				if($accesoEstructurasC){
					if(empty($_POST)){
						$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1 and usuarios.id_usuario = {$id}");
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, estructuras WHERE clientes.id_cliente = estructuras.id_cliente and clientes.estatus = 1 and estructuras.estatus = 1 and estructuras.analista={$id}");
						
						// $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
						// $estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1 and analista = {$id}");
						// $estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");
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
				if($accesoEstructurasR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id_usuario = $_POST['analista'];
							$query = "SELECT * FROM estructuras WHERE analista = $id_usuario";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$res2 = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = $id_usuario and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("DELETE FROM estructuras WHERE analista = $id_usuario");
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
						if(empty($_POST['validarData']) && !empty($_POST['analista']) && empty($_POST['clientes'])){
							$analista = $_POST['analista'];
							$lideres = [];
							if(!empty($_POST['lideres'])){
								$lideres = $_POST['lideres'];
							}
							$max = count($lideres);
							$result = 0;
							foreach ($lideres as $id_cliente) {
								$query = "INSERT INTO estructuras (id_estructura, id_cliente, analista, estatus) VALUES (DEFAULT, {$id_cliente}, {$analista}, 1)";
								$exec = $lider->registrar($query, "estructuras", "id_estructura");
								if($exec['ejecucion']==true){
									$result += "1";
								}else{
									$result += "2";
								}
							}
							if($max == $result){
								$response = "1";
							}else{
								$response = "2";
							}
							$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1");
							$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
							$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1");
							$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");

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
						$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1");
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

						$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1");
						$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");


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
				if($accesoEstructurasR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$id_usuario = $_POST['analista'];
							$query = "SELECT * FROM estructuras WHERE analista = $id_usuario";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$response = "1";
								}else{
									$res2 = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = $id_usuario and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE estructuras SET estatus = 1 WHERE analista = $id_usuario");
											if($res3['ejecucion']==true){
												$response = "1";
											}
										}else{
											$response = "9"; //echo "Registro ya guardado.";
										}
									}
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(empty($_POST['validarData']) && !empty($_POST['analista']) && empty($_POST['clientes'])){
							$analista = $_POST['analista'];
							$lideres = [];
							if(!empty($_POST['lideres'])){
								$lideres = $_POST['lideres'];
							}
							$max = count($lideres);
							$result = 0;
							$exec = $lider->eliminar("DELETE from estructuras WHERE analista = $id");
						    if($exec['ejecucion']==true){
								foreach ($lideres as $id_cliente) {
									$query = "INSERT INTO estructuras (id_estructura, id_cliente, analista, estatus) VALUES (DEFAULT, {$id_cliente}, {$analista}, 1)";
									$exec = $lider->registrar($query, "estructuras", "id_estructura");
									if($exec['ejecucion']==true){
										$result += "1";
									}else{
										$result += "2";
									}
								}
								if($max == $result){
									$response = "1";
								}else{
									$response = "2";
								}
							}else{
								$response = "2";
							}

							$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1 and usuarios.id_usuario = {$id}");
							$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

							$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1 and analista = {$id}");
							$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");

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
						$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1 and usuarios.id_usuario = {$id}");
						$clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

						$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1 and analista = {$id}");
						$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");
						
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