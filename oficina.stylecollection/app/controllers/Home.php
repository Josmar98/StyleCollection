<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }

	if($_SESSION['nombre_rol']=="Gestor De Campañas" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Contable"){
		$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 ORDER BY id_campana DESC");
	}else{
		$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1 ORDER BY id_campana DESC");
	}


if(empty($_POST)){

	// // $canjeos = $lider->consultarQuery("SELECT * FROM canjeos");
	// // $cantRegistros = count($canjeos)-1;
	// // echo "Cantidad Registros: ".$cantRegistros;
	// // echo "<br>";
	// $canjeosTotales = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo");
	// // $cantRegistros = count($canjeosTotales)-1;
	// // echo "Cantidad Registros: ".$cantRegistros;
	// // echo "<br>";
	// $errores=0;
	// foreach ($canjeosTotales as $c) {
	// 	if(!empty($c['id_catalogo'])){
	// 		// print_r($c);
	// 		// echo "PRECIO: ".$c['cantidad_gemas']." | ";
	// 		// echo "ID: ".$c['id_canjeo']." | ";
	// 		// echo "NOMBRE: ".$c['nombre_catalogo']." | ";
	// 		// echo "<br>";
	// 		$precio = (float) $c['cantidad_gemas'];
	// 		$id_canjeo = $c['id_canjeo'];
	// 		$query="UPDATE canjeos SET precio_gemas={$precio} WHERE id_canjeo={$id_canjeo}";
	// 		// echo $query."<br>";
	// 		// echo "<br><br>";
	// 		$execCanjeo = $lider->modificar($query);
	// 		if($execCanjeo['ejecucion']==true){
	// 		}else{
	// 			$errores++;
	// 		}
	// 	}
	// }
	// if($errores==0){
	// 	echo "NO Hubo errores";
	// }

	// $campanass = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
	$fecha = date('Y-m-d');
	$tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '$fecha'");
	if($campanas['ejecucion']==1){
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


?>