<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Conciliador"){
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE canjeos SET estatus = 0 WHERE id_canjeo = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
		$clausula2 = "";
		if(!empty($_GET['camp'])){
			$clausula2 .= " and canjeos.id_despacho=".$_GET['camp'];
		}
		if(!empty($_GET['rI']) && !empty($_GET['rC'])){
			$clausula2 .=" and canjeos.fecha_canjeo BETWEEN '".$_GET['rI']."' and '".$_GET['rC']."'";
		}

		$lideres=$lider->consultarQuery("SELECT DISTINCT canjeos.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, cod_rif, rif, direccion, id_lider FROM clientes, canjeos WHERE clientes.id_cliente = canjeos.id_cliente and canjeos.estatus = 1".$clausula2);

		$clausula1 = "";
		if(!empty($_GET['opcion'])){
			if($_GET['opcion']==1){ $op = "IS NULL"; }
			if($_GET['opcion']==2){ $op = "IS NOT NULL"; }
			$clausula1 .=" and canjeos.estado_canjeo ".$op;
		}
		if(!empty($_GET['camp'])){
			$clausula1 .= " and canjeos.id_despacho=".$_GET['camp'];
		}
		if(!empty($_GET['rI']) && !empty($_GET['rC'])){
			$clausula1 .=" and canjeos.fecha_canjeo BETWEEN '".$_GET['rI']."' and '".$_GET['rC']."'";
		}
		$premiosCanjeados = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1".$clausula1);
		$pedidos = $lider->consultarQuery("SELECT * FROm campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 ORDER BY campanas.id_campana DESC");
		$clausula3 = "";
		if(!empty($_GET['camp'])){
			$clausula3 .= " and despachos.id_despacho=".$_GET['camp'];
		}
		$campanas = $lider->consultarQuery("SELECT * FROm campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 {$clausula3} ORDER BY campanas.id_campana DESC");
		if($lideres['ejecucion']==1){
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

?>