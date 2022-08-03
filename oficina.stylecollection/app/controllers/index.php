<?php 
	if($url=="PlanesCamp"){ $modulo = "Planes De Campaña"; }
	if($url=="Despachos"){ $modulo = "Pedidos"; }
	else if($url=="PremiosCamp"){ $modulo = "Premios De Campaña"; }
	else if($url=="Movimientos"){ $modulo = "Movimientos Bancarios"; }
	else if($url=="FacturaDespacho"){ $modulo = "Factura de Despacho"; }
	else if($url=="FacturaDespachoConfiguracion"){ $modulo = "Configuracion de Factura"; }
	else if($url=="DesperfectosNotif"){ $modulo = "Notificar Desperfectos"; }
	else if($url=="LiderazgosCamp"){ $modulo = "Liderazgos de Campaña"; }
	else if($url=="PlanCol"){ $modulo = "Planes de colecciones"; }
	else if($url=="PlanCamp"){ $modulo = "Planes de campaña"; }
	else if($url=="PremiosCol"){ $modulo = "Premios de colecciones"; }
	else if($url=="PremiosCamp"){ $modulo = "Premios de campaña"; }
	else{ $modulo = $url; }

	if(!empty($action)){ if($action=="Registrar"){	$accion="Registrar"; }	if($action=="Modificar"){	$accion="Editar"; } } else{ $accion="Consultar"; }
	if(!empty($_GET['permission'])&&!empty($id)){	$accion="Borrar"; }
	if(!empty($_POST['banco']) && empty($_POST['validarData']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Bancos";}
	if(!empty($_POST['banco']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){$accion="Editar";$modulo="Bancos";}
	if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Fragancias";}
	if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){$accion="Editar";$modulo="Fragancias";}

	if(!empty($_POST['precio_col']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Configuracion de Factura";}
	if(!empty($_POST['precio_col']) && !empty($_GET['operation']) && $_GET['operation']=="Modificar" ){$accion="Modificar";$modulo="Configuracion de Factura";}

	if(is_file('app/models/indexModels.php')){
		require_once'app/models/indexModels.php';
	}
	if(is_file('../app/models/indexModels.php')){
		require_once'../app/models/indexModels.php';
	}
	$lider = new Models();
	// if(!empty($modulo) && !empty($accion)){
	// 	$fecha = date('Y-m-d');
	// 	$hora = date('H:i:a');
	// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, '{$modulo}', '{$accion}', '{$fecha}', '{$hora}')";
	// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// }
	if(!empty($action)){
		if(is_file("app/controllers/".strtolower($url)."/".$action.$url.".php")){
			require_once "app/controllers/".strtolower($url)."/".$action.$url.".php";
		}else{
		    require_once 'public/views/error404.php';
		}
	}else{
		if(is_file("app/controllers/".$url.".php")){
			require_once "app/controllers/".$url.".php";
		}else{
		    require_once 'public/views/error404.php';
		}
	}
?>