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
	    if(!empty($modulo) && !empty($accion)){
	        $campAnt = $campAnt[0];
	        $elementos = array(
	          "Nombres"=> [0=>"Id", 1=>ucwords("Nombre De Campaña"), 2=> ucwords("Anio De Campaña"), 3=> ucwords("Numero De Campaña"), 4=>"Visibilidad", 5=>"Estatus"],
	          "Anterior"=> [ 0 =>$id, 1 =>$campAnt['nombre_campana'], 2 =>$campAnt['anio_campana'], 3 =>$campAnt['numero_campana'], 4=>$campAnt['visibilidad'], 5=>$campAnt['estatus'] ],
	          "Actual"=> [ 0=> $id, 1=> $campAnt['nombre_campana'], 2=> $campAnt['anio_campana'] , 3=>$campAnt['numero_campana'], 4=>$visibilidad, 5=>$campAnt['estatus'] ]
	        );
	        $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
	        $fecha = date('Y-m-d');
	        $hora = date('H:i:a');
	        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
	        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	      }
	  }else{
	    $response = "2";
	  }
	  echo $response;
	}

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

			$query = "UPDATE campanas SET estatus = 0 WHERE id_campana = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Borrar', '{$fecha}', '{$hora}')";
		          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		        }
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