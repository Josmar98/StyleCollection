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

		$query = "UPDATE rutas SET estatus = 0 WHERE id_ruta = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
		$rutalider = $lider->consultarQuery("SELECT * FROM clientes, rutaslideres, rutas WHERE rutaslideres.id_cliente = clientes.id_cliente and rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta ORDER BY rutaslideres.posicion ASC");
		$rutas=$lider->consultarQuery("SELECT DISTINCT rutas.id_ruta, rutas.nombre_ruta, rutaslideres.estatus FROM rutas, rutaslideres WHERE rutas.id_ruta = rutaslideres.id_ruta and rutas.estatus = 1 and rutaslideres.estatus = 1 ORDER BY rutas.id_ruta ASC");
		if($rutas['ejecucion']==1){
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