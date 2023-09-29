<?php 
	if(strtolower($url)=="clientes"){
		if(!empty($action)){
			$accesoClientesR = false;
			$accesoClientesC = false;
			$accesoClientesM = false;
			$accesoClientesE = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Clientes")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoClientesR=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoClientesC=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoClientesM=true; }
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoClientesE=true; }
					}
				}
			}
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if($action=="Consultar"){
				if($accesoClientesC){
					$clientes=$lider->consultar("clientes");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoClientesE){
							$query = "UPDATE clientes SET estatus = 1 WHERE id_cliente = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
					if($clientes['ejecucion']==1){
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
			if($action=="Borrados"){
				if(
					mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
					mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador")
				){
					$clientess=$lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 0 and id_cliente > 1");
					if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
						if($accesoClientesE){
							$query = "UPDATE clientes SET estatus = 1 WHERE id_cliente = $id";
							$res1 = $lider->eliminar($query);
							if($res1['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2"; // echo 'Error en la conexion con la bd';
							}
						}
					}
					if($clientess['ejecucion']==1){
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
			if($action=="Detalles"){
				if($accesoClientesC){
					$cliente=$lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = '$id'");
					$userCliente=$lider->consultarQuery("SELECT * FROM usuarios, roles WHERE roles.id_rol = usuarios.id_rol and usuarios.id_cliente = '$id'");

					if(!empty($_POST['selectedCiclo'])){
						$id_ciclo = $_POST['selectedCiclo'];
						$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus=1 and ciclos.id_ciclo={$id_ciclo}");
						$ciclo = $ciclos[0];
						// $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
						// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = $id_despacho");
						$pedidosClientes = $lider->consultarQuery("SELECT * FROM clientes, pedidos, ciclos WHERE clientes.id_cliente=pedidos.id_cliente and pedidos.id_ciclo = {$id_ciclo} and ciclos.id_ciclo=pedidos.id_ciclo and pedidos.estatus=1 and ciclos.estatus=1");
						$index = 0;
						foreach ($pedidosClientes as $data){ if(!empty($data['id_pedido'])){
							$pedidosInv = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_solicitada * inventarios.precio_inventario) as cantidad_solicitada, SUM(pedidos_inventarios.cantidad_aprobada * inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido = pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario = inventarios.cod_inventario and pedidos.id_ciclo = {$id_ciclo} and pedidos_inventarios.id_ciclo = {$id_ciclo} and pedidos.id_pedido = {$data['id_pedido']}");
							if(count($pedidosInv)>1){
								$pedidosInvent=$pedidosInv[0];
								$pedidosClientes[$index]['cantidad_solicitada']=$pedidosInvent['cantidad_solicitada'];
								$pedidosClientes[$index]['cantidad_aprobada']=$pedidosInvent['cantidad_aprobada'];
								$pedidosClientes[$index]['precio_cuotas']=$pedidosInvent['cantidad_aprobada']/$ciclo['cantidad_cuotas'];
							}
							$index++;
						} }
					}
					if(count($cliente)>1){
						$cliente = $cliente[0];
						$liderCliente = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_cliente = {$cliente['id_lider']}");
						if(count($liderCliente)>1){
							$liderCliente = $liderCliente[0];
						}else{
							$liderCliente['primer_nombre'] = "Ningun(a)";
							$liderCliente['primer_apellido'] = "Lider";
						}
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
							$fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.png";
							$rrollCliente = $userCliente['nombre_rol'];
							if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
							if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
							if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
						}else{
							$fotoPerfilCliente = "public/assets/img/profile/";
							if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
							if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
							$fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
							$fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.png";
							$rrollCliente = "Agente";
						}
						$fotoPortada = "public/assets/img/profile/PortadaGeneral.png";

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
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if($action=="Registrar"){
				if($accesoClientesR){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$cedula = $_POST['cedula'];
							$correo = $_POST['correo'];
							$query = "SELECT * FROM clientes WHERE cedula = '$cedula'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									// $response = "9"; //echo "Registro ya guardado.";
									$res2 = $lider->consultarQuery("SELECT * FROM clientes WHERE cedula = '$cedula' and estatus = 0");
									if($res2['ejecucion']==true){
										if(Count($res2)>1){
											$res3 = $lider->modificar("UPDATE clientes SET estatus = 1 WHERE cedula = '$cedula'");
											if($res3['ejecucion']==true){
												$response = "1";
											}
										}else{
											$response = "9"; //echo "Registro ya guardado.";
										}
									}
								}else{
									$correolen1 = strlen($correo) - 4;
									$correolen2 = strlen($correo);
									$correoterminator = substr($correo, $correolen1, $correolen2);
									if($correoterminator == ".com"){
										$response = "1";
									}else{
										$response = "4";
									}
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(!empty($_POST['nombre1']) && !empty($_POST['cedula'])){
							$nombre1 = ucwords(mb_strtolower($_POST['nombre1']));
							$nombre2 = ucwords(mb_strtolower($_POST['nombre2']));
							$apellido1 = ucwords(mb_strtolower($_POST['apellido1']));
							$apellido2 = ucwords(mb_strtolower($_POST['apellido2']));
							$cod_cedula = $_POST['cod_cedula'];
							$cedula = $_POST['cedula'];
							$fechaNacimiento = $_POST['fechaNacimiento'];
							$cod_rif = $_POST['cod_rif'];
							$rif = $_POST['rif'];
							$cod_tlfn = $_POST['cod_tlfn'];
							$numtelefono = $_POST['telefono'];
							$telefono = $cod_tlfn.$numtelefono;
							$cod_tlfn2 = $_POST['cod_tlfn2'];
							$numtelefono2 = $_POST['telefono2'];
							$telefono2 = $cod_tlfn2.$numtelefono2;

							$correo = $_POST['correo'];
							$sexo = ucwords(mb_strtolower($_POST['sexo']));
							$id_lider = $_POST['lider'];
							$direccion = ucwords(mb_strtolower($_POST['direccion']));

							$correolen1 = strlen($correo) - 4;
							$correolen2 = strlen($correo);
							$correoterminator = substr($correo, $correolen1, $correolen2);

							$query = "INSERT INTO clientes (id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cod_cedula, cedula, sexo, fecha_nacimiento, telefono, telefono2, correo, cod_rif, rif, direccion, id_lider, estatus) VALUES (DEFAULT, '$nombre1', '$nombre2', '$apellido1', '$apellido2', '$cod_cedula', '$cedula', '$sexo', '$fechaNacimiento', '$telefono', '$telefono2', '$correo', '$cod_rif', '$rif', '$direccion', $id_lider, 1)";

							$exec = $lider->registrar($query, "clientes", "id_cliente");
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
							}
						}
					}
					if(empty($_POST)){
						$clientes = $lider->consultar("clientes");
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
				if($accesoClientesM){
					if(!empty($_POST)){
						if(!empty($_POST['validarData'])){
							$cedula = $_POST['cedula'];
							$correo = $_POST['correo'];
							$query = "SELECT * FROM clientes WHERE cedula = '$cedula'";
							$res1 = $lider->consultarQuery($query);
							if($res1['ejecucion']==true){
								if(Count($res1)>1){
									$correolen1 = strlen($correo) - 4;
									$correolen2 = strlen($correo);
									$correoterminator = substr($correo, $correolen1, $correolen2);
									if($correoterminator == ".com"){
										$response = "1";
									}else{
										$response = "4";
									}
								}else{
									$response = "9"; //echo "Registro ya guardado.";
								}
							}else{
								$response = "5"; // echo 'Error en la conexion con la bd';
							}
							echo $response;
						}
						if(!empty($_POST['nombre1']) && !empty($_POST['cedula'])){
							$nombre1 = ucwords(mb_strtolower($_POST['nombre1']));
							$nombre2 = ucwords(mb_strtolower($_POST['nombre2']));
							$apellido1 = ucwords(mb_strtolower($_POST['apellido1']));
							$apellido2 = ucwords(mb_strtolower($_POST['apellido2']));
							$cedula = $_POST['cedula'];
							$fechaNacimiento = $_POST['fechaNacimiento'];
							$cod_rif = $_POST['cod_rif'];
							$rif = $_POST['rif'];

							$cod_tlfn = $_POST['cod_tlfn'];
							$numtelefono = $_POST['telefono'];
							$telefono = $cod_tlfn.$numtelefono;

							$cod_tlfn2 = $_POST['cod_tlfn2'];
							$numtelefono2 = $_POST['telefono2'];
							$telefono2 = $cod_tlfn2.$numtelefono2;

							$correo = $_POST['correo'];
							$id_lider = $_POST['lider'];
							$sexo = ucwords(mb_strtolower($_POST['sexo']));
							$direccion = ucwords(mb_strtolower($_POST['direccion']));

							$correolen1 = strlen($correo) - 4;
							$correolen2 = strlen($correo);
							$correoterminator = substr($correo, $correolen1, $correolen2);
							$campAnt = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id");
							$query = "UPDATE clientes SET primer_nombre = '$nombre1', segundo_nombre = '$nombre2', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', cedula = '$cedula', sexo = '$sexo', fecha_nacimiento = '$fechaNacimiento', telefono = '$telefono', telefono2 = '$telefono2', correo = '$correo', cod_rif = '$cod_rif', rif = '$rif', direccion = '$direccion', id_lider = $id_lider, estatus = 1 WHERE id_cliente = $id";

							$exec = $lider->modificar($query);
							if($exec['ejecucion']==true){
								$response = "1";
							}else{
								$response = "2";
							}

							$query = "SELECT * FROM clientes WHERE estatus = 1 and id_cliente = $id";
							$clientes=$lider->consultarQuery($query);
							$datas = $clientes[0];
							$cod_tlfn = substr($datas['telefono'], 0, 4);
							$numtelefono = substr($datas['telefono'], 4, strlen($datas['telefono']) );

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
						$query = "SELECT * FROM clientes WHERE id_cliente = $id";
						$clientes=$lider->consultarQuery($query);
						$lideress = $lider->consultar("clientes");
						if(Count($clientes)>1){
							$datas = $clientes[0];
							$cod_tlfn = substr($datas['telefono'], 0, 4);
							$numtelefono = substr($datas['telefono'], 4, strlen($datas['telefono']) );
							$cod_tlfn2 = substr($datas['telefono2'], 0, 4);
							$numtelefono2 = substr($datas['telefono2'], 4, strlen($datas['telefono2']) );
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