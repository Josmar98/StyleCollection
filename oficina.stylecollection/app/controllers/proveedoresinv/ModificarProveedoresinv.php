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
if($amInventarioE){
	if(!empty($_POST['validarData'])){
		$codRif=$_POST['codRif'];
		$rif=$_POST['rif'];
		$query = "SELECT * FROM proveedores_inventarios WHERE rif = '$rif'";
		$res1 = $lider->consultarQuery($query);
		if($res1['ejecucion']==true){
			if(Count($res1)>1){
				$response = "1";
			}else{
				// if($res1[0]['rif']==$rif){
				// 	$response = "1";
				// }else{
				// 	$response = "9"; //echo "Registro ya guardado.";
				// }
				$response = "9"; //echo "Registro ya guardado.";
			}
		}else{
			$response = "5"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}
	if(empty($_POST['validarData']) && !empty($_POST['codRif']) && !empty($_POST['rif']) && !empty($_POST['nombre'])){

		$codRif=$_POST['codRif'];
		$rif=$_POST['rif'];
		$nombre=mb_strtoupper($_POST['nombre']);
		$tipo=json_encode($_POST['tipoInv']);
		$cod_tlfn = $_POST['cod_tlfn'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];

		$query = "UPDATE proveedores_inventarios SET codRif='{$codRif}', rif='{$rif}', nombreProveedor='{$nombre}', tipoInventario='{$tipo}', cod_tlfn='{$cod_tlfn}', telefono='{$telefono}', direccion='{$direccion}', estatus=1 WHERE id_proveedor_inventario={$id}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$response = "1";

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Proveedores', 'Editar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
		}
		
		$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE id_proveedor_inventario={$id}");
		$proveedor = $proveedores[0];
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
		$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE id_proveedor_inventario={$id}");
		if(count($proveedores)>1){
			$proveedor = $proveedores[0];
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
		} else {
			require_once 'public/views/error404.php';
		}
	}
}else{
	require_once 'public/views/error404.php';
}


?>