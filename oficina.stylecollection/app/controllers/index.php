<?php 
	if($url=="PlanesCamp"){ $modulo = "Planes De Campaña"; }
	if($url=="Despachos"){ $modulo = "Pedidos"; }
	else if($url=="PremiosCamp"){ $modulo = "Premios De Campaña"; }
	else if($url=="Movimientos"){ $modulo = "Movimientos Bancarios"; }
	else if($url=="FacturaDespacho"){ $modulo = "Factura Fiscal"; }
	else if($url=="FacturaDespachoConfiguracion"){ $modulo = "Configuracion de Factura"; }
	else if($url=="DesperfectosNotif"){ $modulo = "Notificar Desperfectos"; }
	else if($url=="LiderazgosCamp"){ $modulo = "Liderazgos de Campaña"; }
	else if($url=="PlanCol"){ $modulo = "Planes de colecciones"; }
	else if($url=="PlanCamp"){ $modulo = "Planes de campaña"; }
	else if($url=="PremiosCol"){ $modulo = "Premios de colecciones"; }
	else if($url=="PremiosCamp"){ $modulo = "Premios de campaña"; }
	else if($url=="Libroiva"){ $modulo = "Libros de IVA"; }
	else if($url=="Proveedoresinv"){ $modulo = "Proveedores de Inventario"; }
	else if($url=="Promocionesinv"){ $modulo = "Promociones"; }
	else if($url=="PromocionesinvBorradas"){ $modulo = "Promociones Borradas"; }
	else if($url=="Retosinv"){ $modulo = "Retos"; }
	else if($url=="RetosinvBorrados"){ $modulo = "Retos Borrados"; }
	else if($url=="EmpleadosBorrados"){ $modulo = "Empleados"; }
	else if($url=="EmpleadosBorrados"){ $modulo = "Empleados"; }
	else if($url=="PreciosInventario"){ $modulo = "Precios de Venta"; }
	else if($url=="PreciosNotas"){ $modulo = "Precios de Notas"; }
	else if($url=="FacturaDespachoPerso"){ $modulo = "Factura Personalizada"; }
	else if($url=="ReporteResumenGemas"){ $modulo = "Reporte de Resumen de Gemas"; }
	else if($url=="Servicioss"){ $modulo = "Servicios"; }
	else if($url=="ServiciosCamp"){ $modulo = "Servicios"; }
	else if($url=="DevolucionVentas"){ $modulo = "Devolucion de Ventas"; }
	else if($url=="CompraEfiCoin"){ $modulo = "EfiCoin"; }
	else if($url=="PremiosAutorizados"){ $modulo = "Premios Autorizados"; }
	else{ $modulo = $url; }
	
	if(!empty($action)){ if($action=="Registrar"){	$accion="Registrar"; }	if($action=="Modificar"){	$accion="Editar"; } } else{ $accion="Consultar"; }


	if(!empty($_GET['permission'])&&!empty($id)){	$accion="Borrar"; }
	if(!empty($_POST['banco']) && empty($_POST['validarData']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Bancos";}
	if(!empty($_POST['banco']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){$accion="Editar";$modulo="Bancos";}
	if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Fragancias";}
	if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){$accion="Editar";$modulo="Fragancias";}

	if(!empty($_POST['precio_col']) && empty($_GET['operation']) ){$accion="Registrar";$modulo="Configuracion de Factura";}
	if(!empty($_POST['precio_col']) && !empty($_GET['operation']) && $_GET['operation']=="Modificar" ){$accion="Modificar";$modulo="Configuracion de Factura";}
	
	if(!empty($action)){ 
		if($action=="ComprasVentas"){	$nameaccion="Compras y Ventas"; }	
		if($action=="RegistrarCompras"){ $nameaccion="Registro"; }	
		if($action=="ModificarCompras"){ $nameaccion="Modificar"; }	
		if($action=="ModificarVentas"){ $nameaccion="Modificar Ventas"; }	
		if($action=="VerCompras"){	$nameaccion="Ver"; }	
		if($action=="VerFiscal"){	$nameaccion="Ver"; }	
	} else{ 
		$nameaccion=""; 
	}

	if(is_file('app/models/indexModels.php')){
		require_once 'app/models/indexModels.php';
	} else if(is_file('../app/models/indexModels.php')){
		require_once '../app/models/indexModels.php';
	}

	if(is_file('app/models/indexModelss.php')){
		require_once 'app/models/indexModelss.php';
	} else if(is_file('../app/models/indexModelss.php')){
		require_once '../app/models/indexModelss.php';
	}
	$lider = new Models();
	$lid3r = new Modelss();


	$tipoInventarios=[
		// 0=>["id"=>"Materia Prima", "name"=>"Materia Prima"],
		// 1=>["id"=>"Insumos", "name"=>"Insumos"],
		2=>["id"=>"Productos", "name"=>"Productos Terminados"],
		3=>["id"=>"Mercancia", "name"=>"Mercancía"]
	];

	$infoInternos=[
		'-1'=>[
			'id_interno'=>"-1",
			'cod_cedula'=>"V",
			'cedula'=>"129634517",
			'cod_rif'=>"V",
			'rif'=>"129634517",
			'primer_nombre'=>"Juan",
			'segundo_nombre'=>"Carlos",
			'primer_apellido'=>"Aguilar",
			'segundo_apellido'=>"Cuellar",
			'telefono'=>"",
			'telefono2'=>"",
			'direccion'=>"CR 1 Entre Calles 56 y 57 Casa Nro 56-29 Barrio Brisas Del Aeropuerto Barquisimeto Lara Zona Postal 3001",
		],
		'-2'=>[
			'id_interno'=>"-2",
			'cod_cedula'=>"V",
			'cedula'=>"152650104",
			'cod_rif'=>"V",
			'rif'=>"152650104",
			'primer_nombre'=>"Amarilis",
			'segundo_nombre'=>"Annis",
			'primer_apellido'=>"Rojas",
			'segundo_apellido'=>"Escobar",
			'telefono'=>"",
			'telefono2'=>"",
			'direccion'=>"CR 1 Entre Calles 56 y 57 Casa Nro 56-29 Barrio Brisas Del Aeropuerto Barquisimeto Lara Zona Postal 3001",
		],
	];
	
	// if(!empty($modulo) && !empty($accion)){
	// 	$fecha = date('Y-m-d');
	// 	$hora = date('H:i:a');
	// 	$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, '{$modulo}', '{$accion}', '{$fecha}', '{$hora}')";
	// 	$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// }
	
	if(!empty($action)){
		// echo "URL: ".$url."<br>";
		// echo "action: ".$action."<br>";
		//echo "app/controllers/".strtolower($url)."/".$action.$url.".php";
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