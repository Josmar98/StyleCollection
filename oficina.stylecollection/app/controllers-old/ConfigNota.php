<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
	$id_campana = $_GET['campaing'];
  	$numero_campana = $_GET['n'];
  	$anio_campana = $_GET['y'];
	$menu = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana;


    $id_despacho = $_GET['dpid'];
    $num_despacho = $_GET['dp'];
    $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";



	$notas=$lider->consultarQuery("SELECT * FROM planes, confignotaentrega WHERE planes.id_plan = confignotaentrega.id_plan and confignotaentrega.estatus = 1 and confignotaentrega.id_campana = {$id_campana} and confignotaentrega.id_despacho = {$id_despacho}");

if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Conciliador"){
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE confignotaentrega SET estatus = 0 WHERE id_config_nota = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
		if($notas['ejecucion']==1){
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