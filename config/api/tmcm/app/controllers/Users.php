<?php
	if(is_file('app/models/tusers.php')){
		require_once'app/models/tusers.php';
	}
	if(is_file('../app/models/tusers.php')){
		require_once'../app/models/tusers.php';
	}
	$app = new TUsers();

	if(!empty($_GET['action'])){
		$action = $_GET['action'];
	}else{
		$action = "Consultar";
	}
	if(!empty($action)){
		if($action=="Consultar"){
			// echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			$users = $app->Consultar();
			if($users['msj']=="Good"){
				if(count($users['data'])>0){
					echo json_encode($users);
				}else{
					echo json_encode(['msj'=>"Vacio"]);
				}
			}
			if($users['msj']=="Error"){
				echo json_encode($users);
			}
		}
		if($action=="ConsultarSesion"){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				$app->setCedula($_POST['cedula']);
				$app->setPassword($_POST['passw']);
				$users = $app->ConsultarSesion();
				// echo json_encode($_POST);
				if($users['msj']=="Good"){
					if(count($users['data'])>0){
						echo json_encode($users);
					}else{
						echo json_encode(['msj'=>"Vacio"]);
					}
				}
				if($users['msj']=="Error"){
					echo json_encode($users);
				}
			}
		}
		if($action=="Registrar"){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(['data'=>json_encode($datosk)]);
				// echo json_encode(['msj'=>"Good", "id"=>"1"]);
				// $app->setRol(ucwords(mb_strtolower("Usuario")));

				$app->setRol(ucwords(mb_strtolower($_POST['rol'])));
				$app->setCedula($_POST['cedula']);
				$app->setNombre(ucwords(mb_strtolower($_POST['nombre'])));
				$app->setApellido(ucwords(mb_strtolower($_POST['apellido'])));
				$app->setTelefono($_POST['telefono']);
				// $app->setIglesia(ucwords(mb_strtolower($_POST['iglesia'])));
				$app->setIglesia($_POST['iglesia']);
				$app->setPassword($_POST['passw']);
				$search = $app->ConsultarOne("cedula");
				if($search['msj']=="Good"){
					if(count($search['data'])>0){
						if($search['data'][0]['estatus']==0){
							$users = $app->Modificar();
							if($users['msj']=="Good"){
								echo json_encode($users);
							}
							if($users['msj']=="Error"){
								echo json_encode($users);
							}
						}else{
							echo json_encode(['msj'=>"Repetido"]);
						}
					}else{
						$users = $app->Registrar();
						if($users['msj']=="Good"){
							echo json_encode($users);
						}
						if($users['msj']=="Error"){
							echo json_encode($users);
						}
					}
				}
				if($search['msj']=="Error"){
					echo json_encode($search);
				}
			}
		}
		if($action=="Editar"){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(['data'=>json_encode($_POST)]);
				// echo json_encode(['msj'=>"Good", "id"=>"1"]);
				// $app->setRol(ucwords(mb_strtolower("Usuario")));
				$app->setId($_POST['id']);
				$app->setRol(ucwords(mb_strtolower($_POST['rol'])));
				$app->setCedula($_POST['cedula']);
				$app->setNombre(ucwords(mb_strtolower($_POST['nombre'])));
				$app->setApellido(ucwords(mb_strtolower($_POST['apellido'])));
				$app->setTelefono($_POST['telefono']);
				$app->setIglesia($_POST['iglesia']);
				$app->setPassword($_POST['passw']);
				$search = $app->ConsultarOne("id");
				if($search['msj']=="Good"){
					if(count($search['data'])>0){
						if( $search['data'][0]['id']==$app->getId() ){
							$users = $app->Modificar();
							if($users['msj']=="Good"){
								echo json_encode($users);
							}
							if($users['msj']=="Error"){
								echo json_encode($users);
							}
						}else{
							echo json_encode(['msj'=>"Repetido"]);
						}
					}else{
						$users = $app->Modificar();
						if($users['msj']=="Good"){
							echo json_encode($users);
						}
						if($users['msj']=="Error"){
							echo json_encode($users);
						}
					}
				}
				if($search['msj']=="Error"){
					echo json_encode($search);
				}
			}
		}
		// if($action=="Eliminar"){
		// 	if(!empty($_POST)){
		// 		$app->setId($_POST['id']);
		// 		$search = $app->ConsultarOne("id");
		// 		if($search['msj']=="Good"){
		// 			if(count($search['data'])>0){
		// 				if($search['data'][0]['id']==$app->getId()){
		// 					$users = $app->Modificar();
		// 					if($users['msj']=="Good"){
		// 						echo json_encode($users);
		// 					}
		// 					if($users['msj']=="Error"){
		// 						echo json_encode($users);
		// 					}
		// 				}else{
		// 					echo json_encode(['msj'=>"Repetido"]);
		// 				}
		// 			}else{
		// 				$users = $app->Modificar();
		// 				if($users['msj']=="Good"){
		// 					echo json_encode($users);
		// 				}
		// 				if($users['msj']=="Error"){
		// 					echo json_encode($users);
		// 				}
		// 			}
		// 		}
		// 		if($search['msj']=="Error"){
		// 			echo json_encode($search);
		// 		}
		// 	}
		// }
	}

?>