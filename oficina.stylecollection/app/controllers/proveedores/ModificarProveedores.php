<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Contable"){

		if(!empty($_POST['validarData'])){
			$codRif=$_POST['codRif'];
			$rif=$_POST['rif'];
			$query = "SELECT * FROM proveedores_compras WHERE codRif = '$codRif' and rif = '$rif'";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "1";
				}else{
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

			$query = "UPDATE proveedores_compras SET codRif='{$codRif}', rif='{$rif}', nombreProveedor='{$nombre}', estatus=1 WHERE id_proveedor_compras={$id}";
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
			
			$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_compras WHERE id_proveedor_compras={$id}");
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
			$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_compras WHERE id_proveedor_compras={$id}");
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