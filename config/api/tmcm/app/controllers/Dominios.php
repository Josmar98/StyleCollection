<?php
	if(is_file('app/models/tdominios.php')){
		require_once'app/models/tdominios.php';
	}
	if(is_file('../app/models/tdominios.php')){
		require_once'../app/models/tdominios.php';
	}
	$app = new TDominios();

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
		if($action=="Registrar"){
			// echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(["data"=>json_encode($_POST)]);
				$app->setDominio($_POST['dominio']);
				$search = $app->ConsultarOne("dominio");
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
		if($action=="Modificar"){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(["data"=>json_encode($_POST)]);
				$app->setId($_POST['id']);
				$app->setDominio($_POST['dominio']);
				$search = $app->ConsultarOne("dominio");
				//echo json_encode(["data"=>json_encode($search)]);
				if($search['msj']=="Good"){
					if(count($search['data'])>0){
						if($search['data'][0]['id']==$app->getId()){
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
						//echo json_encode(["data"=>json_encode($users)]);
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
		if($action=="Eliminar"){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(["data"=>json_encode($_POST)]);
				$app->setId($_POST['id']);
				$search = $app->ConsultarOne("id");
				//echo json_encode(["data"=>json_encode($search)]);
				if($search['msj']=="Good"){
					if(count($search['data'])>0){
						$users = $app->Eliminar();
						if($users['msj']=="Good"){
							echo json_encode($users);
						}
						if($users['msj']=="Error"){
							echo json_encode($users);
						}
					}else{
						echo json_encode(['msj'=>"Repetido"]);
					}
				}
				if($search['msj']=="Error"){
					echo json_encode($search);
				}
			}
		}
	}

?>