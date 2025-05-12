<?php 

$amProductos = 0;
$amProductosR = 0;
$amProductosC = 0;
$amProductosE = 0;
$amProductosB = 0;
$amFragancias = 0;
$amFraganciasR = 0;
$amFraganciasC = 0;
$amFraganciasE = 0;
$amFraganciasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
      $amProductos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amProductosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amProductosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amProductosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amProductosB = 1;
      }
    }
  }
}
if($amProductosC == 1){
	
	$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 ORDER BY producto asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amProductosB == 1){

			$query = "UPDATE productos SET estatus = 0 WHERE codigo_producto = '$cod'";
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
		for ($i=0; $i < count($productos)-1; $i++) { 
			$mer = $productos[$i];
			$sumaTotal = 0;
			foreach($almacenes as $alm){
				if(!empty($alm['id_almacen'])){
					$operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$mer['id_producto']} and id_almacen={$alm['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
					if(count($operacionesInv)>1){
						$productos[$i]['stock_almacen'.$alm['id_almacen']]=$operacionesInv[0]['stock_operacion_almacen'];
						$sumaTotal+=$operacionesInv[0]['stock_operacion_almacen'];
					}else{
						$productos[$i]['stock_almacen'.$alm['id_almacen']]=0;
						$sumaTotal+=0;
					}
					
				}
			}
			$productos[$i]['stock_total']=$sumaTotal;
		}
		

		// foreach($productos as $mer){
		// 	print_r($mer);
		// 	echo "<br><br>";
		// }
		// $fragancias = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		
		if($productos['ejecucion']==1){
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