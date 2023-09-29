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
	$id_plan = $_POST['planes'];
	$opcion = $_POST['opciones'];
		$query = "UPDATE confignotaentrega SET opcion = $opcion, estatus = 1 WHERE id_config_nota = $id";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2";
		}
	$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_config_nota = $id and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");
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

	// $planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_config_nota = $id and planes_campana.estatus = 1");
	$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_config_nota = $id and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");
	
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