<?php 
$amLiderazgosCamp = 0;
$amLiderazgosCampR = 0;
$amLiderazgosCampC = 0;
$amLiderazgosCampE = 0;
$amLiderazgosCampB = 0;
foreach ($accesos as $access) {
	if(!empty($access['id_acceso'])){
	  if($access['nombre_modulo'] == "Liderazgos De Campaña"){
	    $amLiderazgosCamp = 1;
	    if($access['nombre_permiso'] == "Registrar"){
	      $amLiderazgosCampR = 1;
	    }
	    if($access['nombre_permiso'] == "Ver"){
	      $amLiderazgosCampC = 1;
	    }
	    if($access['nombre_permiso'] == "Editar"){
	      $amLiderazgosCampE = 1;
	    }
	    if($access['nombre_permiso'] == "Borrar"){
	      $amLiderazgosCampB = 1;
	    }
	  }
	}
}
if($amLiderazgosCampE == 1){
	  $id_campana = $_GET['campaing'];
	  $numero_campana = $_GET['n'];
	  $anio_campana = $_GET['y'];

	  $id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_POST['validarData'])){
		$id_liderazgo = $_POST['id_liderazgo'];
		$query = "SELECT * FROM liderazgos_campana WHERE id_liderazgo = $id_liderazgo and id_campana = $id_campana and estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$res1 = $lider->consultarQuery($query);
		if($res1['ejecucion']==true){
			if(Count($res1)>1){
			  // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
		   //    if($res2['ejecucion']==true){
		   //      if(Count($res2)>1){
		   //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
		   //        if($res3['ejecucion']==true){
		   //          $response = "1";
		   //        }
		   //      }else{
		   //        $response = "9"; //echo "Registro ya guardado.";
		   //      }
		   //    }


				$response = "1";
			}else{
				$response = "9"; //echo "Registro ya guardado.";
			}
		}else{
			$response = "5"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}


	if(!empty($_POST['titulo'])){

		// print_r($_POST);
		$id_buscar = $_POST['id_buscar'];
		// echo $id_buscar;
		$id_liderazgo = $_POST['titulo'];
		$minima = $_POST['minima'];
		$maxima = $_POST['maxima'];
		// if($maxima==0){ $maxima = ""; }
		$descuento_coleccion = $_POST['descuento_coleccion'];
		$query = "SELECT * from liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho}";
		$resp = $lider->consultarQuery($query);
		// print_r($resp);
		if($resp['ejecucion']){
			if(Count($resp)>1){
				$query = "SELECT * FROM liderazgos_campana WHERE id_campana = $id_campana and id_liderazgo = $id_buscar and liderazgos_campana.id_despacho = {$id_despacho}";
				$respon = $lider->consultarQuery($query);
				if($respon['ejecucion']){
					if(Count($respon)>1){
						$canDescuento = $respon[0]['total_descuento'];
					}else{
						$canDescuento = 0;
					}
				}else{
					$canDescuento = 0;
				}
			}else{
				$canDescuento = 0;
			}
			
			$totalDescuento = $canDescuento+$descuento_coleccion;
			// $query = "INSERT INTO liderazgos_campana (id_lc, id_liderazgo, id_campana, minima_cantidad, maxima_cantidad, descuento_coleccion, total_descuento, estatus) VALUES (DEFAULT, $id_liderazgo, $id_campana, $minima, $maxima, $descuento_coleccion, $totalDescuento, 1)";
			$query = "UPDATE liderazgos_campana SET minima_cantidad=$minima, maxima_cantidad=$maxima, descuento_coleccion=$descuento_coleccion, total_descuento=$totalDescuento, estatus=1 WHERE id_lc = $id";		
			// echo $query;
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				$response = "1";

				if(!empty($modulo) && !empty($accion)){
	              $fecha = date('Y-m-d');
	              $hora = date('H:i:a');
	              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos De Campaña', 'Editar', '{$fecha}', '{$hora}')";
	              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	            }
			}else{
				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}

		}else{
			$response = '2';
		}

			
		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.estatus = 1 and liderazgos_campana.id_lc = $id and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgo=$lider->consultarQuery($query);
		$datas = $liderazgo[0];
		
			// $max = $liderss[$cant-1]['total_descuento'];
			$idLim = $datas['id_liderazgo']-1;
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


		// print_r($exec);
	}


	if(empty($_POST)){
		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.estatus = 1 and liderazgos_campana.id_lc = $id and liderazgos_campana.id_despacho = {$id_despacho}";
		$liderazgo=$lider->consultarQuery($query);
		// $liderss = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 ORDER BY liderazgos_campana.id_liderazgo ASC");
		// $cant = count($liderss)-1;
		// $idLim = $cant;
		// if($cant>0){
		// 	$idLim = $liderss[$cant-1]['id_liderazgo'];
		// }
		// echo $id;
		if(Count($liderazgo)>1){
			$datas = $liderazgo[0];
			$idLim = $datas['id_liderazgo']-1;
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