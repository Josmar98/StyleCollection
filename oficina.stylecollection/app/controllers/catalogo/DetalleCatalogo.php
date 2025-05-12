<?php 


	$catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 and id_catalogo = $id ORDER BY cantidad_gemas asc;");
	if(!empty($_POST['valueCanjeo'])){
		if(count($catalogos)>1){
			$catalogo = $catalogos[0];
			if((!empty($_GET['admin']) && $_GET['admin']==1) && (isset($_GET['lider']) && $_GET['lider']>0)){
				$id_cliente = $_GET['lider'];
			}else{
				$id_cliente = $_SESSION['id_cliente'];
			}
			$fecha = date('Y-m-d');
			$hora = date('h:i a');
			// print_r($catalogo['cantidad_gemas']);

			// echo "Catalogo: ". $id." - ";
			// echo "Cliente: ". $id_cliente." - ";
			// echo "Fecha: ". $fecha." - ";
			// echo "Hora: ". $hora." - ";
			// echo "Costo: ".$costo." - ";
			$cant = $_POST['cantidad'];
			$precio=$catalogo['cantidad_gemas'];

			$query = "INSERT INTO canjeos (id_canjeo, id_catalogo, id_cliente, unidades, precio_gemas, fecha_canjeo, hora_canjeo, estatus) VALUES (DEFAULT, $id, $id_cliente, {$cant}, {$precio}, '$fecha', '$hora', 1)";
			$exec = $lider->registrar($query, "canjeos", "id_canjeo");
			if($exec['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2";
			}		
			echo $response;
		}
	}
	if(empty($_POST)){
		if((!empty($_GET['admin']) && $_GET['admin']==1) && (isset($_GET['lider']))){
			$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.estatus=1");
		}
		$cantidades = $lider->consultarQuery("SELECT DISTINCT cantidad_gemas FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas ASC;");
		if($catalogos['ejecucion']==1){
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