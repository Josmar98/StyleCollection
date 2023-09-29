<?php 
	

	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE campanas.estatus = 1");

	if(!empty($_POST['validarVisibilidad'])){
	  $visibilidad = $_POST['visibilidad'];
	  $id = $_POST['id_camp'];
	  $campAnt = $lider->consultarQuery("SELECT * FROM campanas WHERE id_campana = $id");
	  $query = "UPDATE campanas SET visibilidad = $visibilidad WHERE id_campana = $id";
	  $exec = $lider->modificar($query);
	  if($exec['ejecucion']==true){
	    $response = "1";

	  }else{
	    $response = "2";
	  }
	  echo $response;
	}
	if(isset($_POST['visibilidad']) && isset($_POST['id'])){
		// print_r($_POST);
		// echo "asd";
		$query = "UPDATE campanas SET visibilidad = {$_POST['visibilidad']} WHERE id_campana = {$_POST['id']}";
		$res1 = $lider->modificar($query);
		if($res1['ejecucion']==true){
			$response2 = "1";

		}else{
			$response2 = "2"; // echo 'Error en la conexion con la bd';
		}
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
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

			$query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

			// if(!empty($action)){
			// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
			// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }else{
			// 	if (is_file('public/views/'.$url.'.php')) {
			// 		require_once 'public/views/'.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }
	}
	
	if(empty($_POST)){
		
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