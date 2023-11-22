<?php
	if(is_file('app/models/tsubida.php')){ require_once'app/models/tsubida.php'; }
	if(is_file('app/models/tdominios.php')){ require_once'app/models/tdominios.php'; }
	if(is_file('app/models/tusers.php')){ require_once'app/models/tusers.php'; }
	if(is_file('../app/models/tsubida.php')){ require_once'../app/models/tsubida.php'; }
	if(is_file('../app/models/tdominios.php')){ require_once'../app/models/tdominios.php'; }
	if(is_file('../app/models/tusers.php')){ require_once'../app/models/tusers.php'; }
	$app = new TSubida();
	$domains = new tDominios();
	$users = new tUsers();

	if(!empty($_GET['action'])){
		$action = $_GET['action'];
	}else{
		$action = "Consultar";
	}
	if(!empty($action)){
		if($action=="Consultar"){
			// echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			$users = $users->Consultar();
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
		if($action=="ConsultarSubidas"){
			// echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				//echo json_encode(["data"=>json_encode($_POST)]);
				$dominio = $_POST['dominio'];
				$users = $users->Consultar();
				if($users['msj']=="Good"){
					if(count($users['data'])>0){
						$result['msj']="Good";
						$result['data']=$users['data'];
						$subidas = $app->ConsultarSubidas($dominio);
						if($subidas['msj']=="Good"){
							if(count($subidas['data'])>0){
								$result['msjSubidos']="Good";
								$result['dataSubidos']=$subidas['data'];
							}else{
								$result['msjSubidos']="Vacio";
							}
							echo json_encode($result);
						}
						if($subidas['msj']=="Error"){
							echo json_encode($users);
						}
					}else{
						echo json_encode(['msj'=>"Vacio"]);
					}
				}
				if($users['msj']=="Error"){
					echo json_encode($users);
				}
			}
		}
		if($action=="SubirData"){
			// echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				// echo json_encode(["data"=>json_encode($_POST)]);
				$idUser = 0;
				$idDomain = 0;
				$users->setCedula($_POST['cedula']);
				$searchUsers = $users->ConsultarOne("cedula");
				if($searchUsers['msj']=="Good"){
					if(count($searchUsers['data'])>0){
						$idUser = $searchUsers['data'][0]['id'];
					}
				}
				$domains->setDominio($_POST['dominio']);
				$searchDomains = $domains->ConsultarOne("dominio");
				if($searchDomains['msj']=="Good"){
					if(count($searchDomains['data'])>0){
						$idDomain = $searchDomains['data'][0]['id'];
					}
				}
				if($idUser!=0 && $idDomain!=0){
					$general = $_POST['general'];
					$app->setIdUser($idUser);
					$app->setIdDominio($idDomain);

					$app->setCantM($general['CantM']);
					$app->setCantF($general['CantF']);
					$app->setCantTotal($general['CantTotal']);
					$app->setFecha(date('d/m/Y'));
					$app->setHora(date("h:iA"));
					$search = $app->ConsultarOne("idUserDomain");
					if($search['msj']=="Good"){
						if(count($search['data'])>0){
							$app->setId($search['data'][0]['id']);
							$searchCantG = intval($search['data'][0]['cantG']);
							$searchCantM = intval($search['data'][0]['cantM']);
							$searchCantF = intval($search['data'][0]['cantF']);
							if( ($general['CantTotal']>=$searchCantG) && ($general['CantM']>=$searchCantM) && ($general['CantF']>=$searchCantF) ){
								$resultExec = $app->Modificar();
								if($resultExec['msj']=="Good"){
									$data = [];
									$data['id_contador'] = $search['data'][0]['id'];
									$resultExec3 = $app->EliminarIglesias($data);
									if($resultExec3['msj']=="Good"){
										$data['id_users'] = $idUser;
										$data['id_dominio'] = $idDomain;
										$errores = 0;
										$iglesias = $_POST['iglesias'];
										foreach ($iglesias as $keys) {
											$data['nombre_iglesia'] = $keys['nombre'];
											$data['cantIgM'] = $keys['CantM'];
											$data['cantIgF'] = $keys['CantF'];
											$data['cantIgG'] = $keys['CantTotal'];
											$resultExec2 = $app->RegistrarIglesia($data);
											if($resultExec2['msj']!="Good"){
												$errores++;
											}
										}
										if($errores==0){
											$return = [
												"msj"=>"Good", 
												"data"=>[
													"fecha"=>$app->getFecha(), 
													"hora"=>$app->getHora(), 
													"cantM"=>$general['CantM'], 
													"cantF"=>$general['CantF'], 
													"cantTotal"=>$general['CantTotal'],
												],
											];
											echo json_encode($return);
										}else{
											echo json_encode($resultExec2);
										}
									}else{
										echo json_encode($resultExec);
									}
								}else{
									echo json_encode($resultExec3);
								}
							}else{
								$return = [
									"msj"=>"dataMenor", 
									"data"=>[
										"fecha"=>$search['data'][0]['fecha'], 
										"hora"=>$search['data'][0]['hora'], 
										"cantM"=>$searchCantM, 
										"cantF"=>$searchCantF, 
										"cantTotal"=>$searchCantG,
									],
								];
								echo json_encode($return);
							}
						}else{
							$resultExec = $app->Registrar();
							if($resultExec['msj']=="Good"){
								$data = [];
								$data['id_contador'] = $resultExec['id'];
								$data['id_users'] = $idUser;
								$data['id_dominio'] = $idDomain;
								$errores = 0;
								$iglesias = $_POST['iglesias'];
								foreach ($iglesias as $keys) {
									$data['nombre_iglesia'] = $keys['nombre'];
									$data['cantIgM'] = $keys['CantM'];
									$data['cantIgF'] = $keys['CantF'];
									$data['cantIgG'] = $keys['CantTotal'];
									$resultExec2 = $app->RegistrarIglesia($data);
									if($resultExec2['msj']!="Good"){
										$errores++;
									}
								}
								if($errores==0){
									$return = [
										"msj"=>"Good", 
										"data"=>[
											"fecha"=>$app->getFecha(), 
											"hora"=>$app->getHora(), 
											"cantM"=>$general['CantM'], 
											"cantF"=>$general['CantF'], 
											"cantTotal"=>$general['CantTotal'],
										],
									];
									echo json_encode($return);
									// echo json_encode($resultExec);
								}else{
									echo json_encode($resultExec2);
								}
							}else{
								echo json_encode($resultExec);
							}
						}
					}
					if($search['msj']=="Error"){
						echo json_encode($search);
					}
				}

			}
		}
		if($action=="BajarData"){
			//echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$_POST = json_decode(file_get_contents('php://input'), true);
				//echo json_encode(["data"=>json_encode($_POST)]);
				$dominio = $_POST['dominio'];
				// $dominio = "pruebas";
				$generalCM = 0;
				$generalCF = 0;
				$generalCG = 0;
				$results = $app->ConsultarBajadas($dominio);
				if($results['msj']=="Good"){
					if(count($results['data'])>0){
						$totalGeneral = $results['data'][0];
						if($totalGeneral['cantM']!=null && $totalGeneral['cantF']!=null && $totalGeneral['cantG']!=null){
							$return['msjGeneral'] = "Good";
							$return['General'] = [];
							$return['General']['cantM']=$totalGeneral['cantM'];
							$return['General']['cantF']=$totalGeneral['cantF'];
							$return['General']['cantG']=$totalGeneral['cantG'];
							$iglesias = $app->ConsultarListaIglesias();
							$index = 0;
							$return['iglesias'] = [];
							foreach ($iglesias['data'] as $iglesia) {
								$iglesia = $iglesia['nombre_iglesia'];
								$resultsIg = $app->ConsultarBajadasIglesias($dominio, $iglesia);
								if($resultsIg['msj']=="Good"){
									if(count($resultsIg['data'])>0){
										$return['msjIglesias'] = "Good";
										$totalIg = $resultsIg['data'][$index];
										$return['Iglesias'][$iglesia]['cantM']=$totalIg['cantM'];
										$return['Iglesias'][$iglesia]['cantF']=$totalIg['cantF'];
										$return['Iglesias'][$iglesia]['cantG']=$totalIg['cantG'];
									}else{
										$return['msjIglesias'] = "Vacio";
									}
								}
							}
						}else{
							$return['msjGeneral'] = "Vacio";
						}
						echo json_encode($return);
					}else{
						$return['msjGeneral'] = "Vacio";
					}
				}
			}
		}
		if($action=="BajarDatas"){
			//echo json_encode(['msj'=>"Peticion Consulta Recibida"]);
				$dominio = "pruebas";
				$generalCM = 0;
				$generalCF = 0;
				$generalCG = 0;
				$results = $app->ConsultarBajadas($dominio);
				if($results['msj']=="Good"){
					if(count($results['data'])>0){
						$totalGeneral = $results['data'][0];
						$return['msjGeneral'] = "Good";
						$return['General'] = [];
						$return['General']['cantM']=$totalGeneral['cantM'];
						$return['General']['cantF']=$totalGeneral['cantF'];
						$return['General']['cantG']=$totalGeneral['cantG'];
						$iglesias = $app->ConsultarListaIglesias();
						$index = 0;
						$return['iglesias'] = [];
						foreach ($iglesias['data'] as $iglesia) {
							$iglesia = $iglesia['nombre_iglesia'];
							$resultsIg = $app->ConsultarBajadasIglesias($dominio, $iglesia);
							if($resultsIg['msj']=="Good"){
								if(count($resultsIg['data'])>0){
									$return['msjIglesias'] = "Good";
									$totalIg = $resultsIg['data'][$index];
									$return['Iglesias'][$iglesia]['cantM']=$totalIg['cantM'];
									$return['Iglesias'][$iglesia]['cantF']=$totalIg['cantF'];
									$return['Iglesias'][$iglesia]['cantG']=$totalIg['cantG'];
								}else{
									$return['msjIglesias'] = "Vacio";
								}
							}
						}
						echo json_encode($return);
					}else{
						$return['msjGeneral'] = "Vacio";
					}
				}
		}
		// if($action=="Modificar"){
		// 	if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$_POST = json_decode(file_get_contents('php://input'), true);
		// 		// echo json_encode(["data"=>json_encode($_POST)]);
		// 		$app->setId($_POST['id']);
		// 		$app->setDominio($_POST['dominio']);
		// 		$search = $app->ConsultarOne("dominio");
		// 		//echo json_encode(["data"=>json_encode($search)]);
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
		// 				//echo json_encode(["data"=>json_encode($users)]);
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
		// if($action=="Eliminar"){
		// 	if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$_POST = json_decode(file_get_contents('php://input'), true);
		// 		// echo json_encode(["data"=>json_encode($_POST)]);
		// 		$app->setId($_POST['id']);
		// 		$search = $app->ConsultarOne("id");
		// 		//echo json_encode(["data"=>json_encode($search)]);
		// 		if($search['msj']=="Good"){
		// 			if(count($search['data'])>0){
		// 				$users = $app->Eliminar();
		// 				if($users['msj']=="Good"){
		// 					echo json_encode($users);
		// 				}
		// 				if($users['msj']=="Error"){
		// 					echo json_encode($users);
		// 				}
		// 			}else{
		// 				echo json_encode(['msj'=>"Repetido"]);
		// 			}
		// 		}
		// 		if($search['msj']=="Error"){
		// 			echo json_encode($search);
		// 		}
		// 	}
		// }
	}

?>