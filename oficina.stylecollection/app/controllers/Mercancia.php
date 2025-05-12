<?php 

$amPremios = 0;
$amPremiosR = 0;
$amPremiosC = 0;
$amPremiosE = 0;
$amPremiosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Premios"){
	  $amPremios = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amPremiosR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amPremiosC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amPremiosE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amPremiosB = 1;
	  }
	}
  }
}
if($amPremiosC == 1){
	
	$mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 ORDER BY mercancia asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amPremiosB == 1){

			$query = "UPDATE mercancia SET estatus = 0 WHERE codigo_mercancia = '$cod'";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		}else{
			require_once 'public/views/error404.php';
		}
	}


	if(empty($_POST)){

		$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
		for ($i=0; $i < count($mercancia)-1; $i++) { 
			$mer = $mercancia[$i];
			// print_r($mer);
			// echo "<br><br>";
			$sumaTotal = 0;
			foreach($almacenes as $alm){
				if(!empty($alm['id_almacen'])){
					// echo "<br> ----- =>".$alm['nombre_almacen'].": ";
					$operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$mer['id_mercancia']} and id_almacen={$alm['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
					if(count($operacionesInv)>1){
						// echo $operacionesInv[0]['stock_operacion_almacen'];
						$mercancia[$i]['stock_almacen'.$alm['id_almacen']]=$operacionesInv[0]['stock_operacion_almacen'];
						$sumaTotal+=$operacionesInv[0]['stock_operacion_almacen'];
					}else{
						$mercancia[$i]['stock_almacen'.$alm['id_almacen']]=0;
						$sumaTotal+=0;
						// echo 0;
						
					}
					
				}
			}
			$mercancia[$i]['stock_total']=$sumaTotal;
			// echo "<br><br><br>";
		}




		// foreach($mercancia as $mer){
		// 	print_r($mer);
		// 	echo "<br><br>";
		// }
		
		if($mercancia['ejecucion']==1){
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