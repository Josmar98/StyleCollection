<?php 
$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Inventarios"){
	  $amInventario = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amInventarioR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amInventarioC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amInventarioE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amInventarioB = 1;
	  }
	}
  }
}
if($amInventarioR){
	
	if(!empty($_POST['validarData'])){
		$codRif=$_POST['codRif'];
		$rif=$_POST['rif'];

		$query = "SELECT * FROM proveedores_inventarios WHERE codRif = '$codRif' and rif = '$rif'";
		$res1 = $lider->consultarQuery($query);
		if($res1['ejecucion']==true){
			if(Count($res1)>1){
				// $response = "9"; //echo "Registro ya guardado.";
				$res2 = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE codRif = '$codRif' and rif = '$rif' and estatus = 0");
				if($res2['ejecucion']==true){
					if(Count($res2)>1){
						$res3 = $lider->modificar("UPDATE proveedores_inventarios SET estatus = 1 WHERE codRif = '$codRif' and rif = '$rif'");
						if($res3['ejecucion']==true){
							$response = "1";
						}
					}else{
						$response = "9"; //echo "Registro ya guardado.";
					}
				}
			}else{
				$response = "1";
			}
		}else{
			$response = "5"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	if(empty($_POST['validarData']) && !empty($_POST['codRif']) && !empty($_POST['rif']) && !empty($_POST['nombre'])){
		// print_r($_POST);
		// die();
		$codRif=$_POST['codRif'];
		$rif=$_POST['rif'];
		$nombre=mb_strtoupper($_POST['nombre']);
		$tipo=json_encode($_POST['tipoInv']);
		$cod_tlfn = $_POST['cod_tlfn'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];

		$query = "INSERT INTO proveedores_inventarios (id_proveedor_inventario, codRif, rif, nombreProveedor, tipoInventario, cod_tlfn, telefono, direccion, estatus) VALUES (DEFAULT, '{$codRif}', '{$rif}', '{$nombre}', '{$tipo}', '{$cod_tlfn}', '{$telefono}', '{$direccion}', 1)";
		$exec = $lider->registrar($query, "proveedores_inventarios", "id_proveedor_inventario");
		
		// print_r($exec);

		// die();
		if($exec['ejecucion']==true){
			$response = "1";
				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Proveedores de Inventario', 'Registrar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
			
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
}else{
	require_once 'public/views/error404.php';
}


?>