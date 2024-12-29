<?php 

$amMovimientos = 0;
$amMovimientosR = 0;
$amMovimientosC = 0;
$amMovimientosE = 0;
$amMovimientosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Movimientos Bancarios"){
      $amMovimientos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amMovimientosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amMovimientosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amMovimientosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amMovimientosB = 1;
      }
    }
  }
}
if($amMovimientosE == 1){


	if(!empty($_POST['validarData'])){
		$mov = $_POST['movimiento'];
		$query = "SELECT * FROM movimientos WHERE num_movimiento = $mov and estatus = 1";
		$res1 = $lider->consultarQuery($query);
		// print_r($res1);
		if($res1['ejecucion']==true){
			if(Count($res1)>1){
				$response = "1aa";
			}else{
				$response = "9aa"; //echo "Registro ya guardado.";
			}
		}else{
			$response = "5aa"; // echo 'Error en la conexion con la bd';
		}
		echo $response;
	}


	if(!empty($_POST['banco']) && !empty($_POST['movimiento']) && !empty($_POST['fecha']) && !empty($_POST['monto'])){

		$banco = $_POST['banco'];
		$movimiento = $_POST['movimiento'];
		$fecha = $_POST['fecha'];
		$monto = $_POST['monto'];
		$monto = (Float) $_POST['monto'];

    $movimiento = trim($movimiento);
		// $montoActual = (Float) $monto;
		// $monto = $montoActual;

		$query = "SELECT * from movimientos WHERE id_movimiento = '$id' and id_banco = $banco and estatus = 1";
		$resp = $lider->consultarQuery($query);
		if($resp['ejecucion']){
			if(Count($resp)>1){
				$query = "UPDATE movimientos SET id_banco = $banco, num_movimiento = '$movimiento', fecha_movimiento = '$fecha', monto_movimiento = '$monto' WHERE id_movimiento = '$id'";
				$respon = $lider->modificar($query);
				if($respon['ejecucion']==true){
					$response = "1";
					if(!empty($modulo) && !empty($accion)){
		              $fecha = date('Y-m-d');
		              $hora = date('H:i:a');
		              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Movimientos Bancarios', 'Editar', '{$fecha}', '{$hora}')";
		              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		            }
				}else{
					$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
				}
			}else{
				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}

		}else{
			$response = '2';
		}

		$query = "SELECT * FROM movimientos WHERE id_movimiento = '$id' and movimientos.estatus = 1";
		$movimiento=$lider->consultarQuery($query);
		$datas = $movimiento[0];
		$bancos = $lider->consultarQuery("SELECT * from bancos WHERE estatus = 1 and id_banco = {$datas['id_banco']}");
		$banco = $bancos[0];
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

		if(!empty($id)){
			$query = "SELECT * FROM movimientos WHERE id_movimiento = '$id' and movimientos.estatus = 1";
			$movimiento=$lider->consultarQuery($query);
			if(Count($movimiento)>1){
				$datas = $movimiento[0];
				$bancos = $lider->consultarQuery("SELECT * from bancos WHERE estatus = 1 and id_banco = {$datas['id_banco']}");
				$banco = $bancos[0];
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
		}else{
			require_once 'public/views/error404.php';		
		}

	}


}else{
    require_once 'public/views/error404.php';
}

?>