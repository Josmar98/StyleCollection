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
	// $id_despacho = $_GET['dpid'];
	// $num_despacho = $_GET['dp'];
	$menu = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&";

    $id_despacho = $_GET['dpid'];
    $num_despacho = $_GET['dp'];
    $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";




if(!empty($_POST)){
	// print_r($_POST);
	$planes = $_POST['planes'];
	$opciones = $_POST['opciones'];
	$max = count($opciones);
	$n = 0;
	$responses = [];
	$exec = $lider->eliminar("DELETE FROM confignotaentrega WHERE id_campana = $id_campana and id_despacho = $id_despacho");
	if($exec['ejecucion']==true){
		foreach ($planes as $id_plan) {
			$query = "INSERT INTO confignotaentrega (id_config_nota, id_campana, id_despacho, id_plan, opcion, estatus) VALUES (DEFAULT, $id_campana, $id_despacho, $id_plan, $opciones[$n], 1)";
			$exec = $lider->registrar($query, "confignotaentrega", "id_config_nota");
			if($exec['ejecucion']==true){
				$responses[$n] = "1";
			}else{
				$responses[$n] = "2";
			}
			$n++;
		}
		$acumRes = 0;
		foreach ($responses as $key) {
			$acumRes += $key;
		}
		if($acumRes==$max){
			$response = "1";
		}else{
			$response = "2";		
		}
	}

	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

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
if(empty($_POST)){

	$planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");
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
?>