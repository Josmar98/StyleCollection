<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

	$bancos=$lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 ORDER BY nombre_banco asc;");

/* VALIDACION PARA AGREGAR */
if(!empty($_POST['validarData']) && empty($_GET['operation'])){
  $bancos = ucwords(mb_strtolower($_POST['banco']));
  $numero_cuenta = $_POST['numero_cuenta'];

  $query = "SELECT * FROM bancos WHERE nombre_banco = '$bancos' and numero_cuenta = '$numero_cuenta'";
  $res1 = $lider->consultarQuery($query);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
      $response = "9"; //echo "Registro ya guardado.";
    }else{
      $response = "1";
    }
  }else{
    $response = "5"; // echo 'Error en la conexion con la bd';
  }
  echo $response;
}


/* VALIDACION PARA MODIFICAR */
if(!empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
// echo 'asd';
  $banco = ucwords(mb_strtolower($_POST['banco']));
  $query = "SELECT * FROM bancos WHERE id_banco = $id";
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

/* AGREGAR */

if(!empty($_POST['banco']) && empty($_POST['validarData']) && empty($_GET['operation']) ){

  $bancos = ucwords(mb_strtolower($_POST['banco']));
  $cod_banco = $_POST['codigo_banco'];
  $disponibilidad = ucwords(mb_strtolower($_POST['disponibilidad']));
  $opcion_pago = ucwords(mb_strtolower($_POST['opcion_pago']));
  $tipo_cuenta = ucwords(mb_strtolower($_POST['tipo_cuenta']));
  $numero_cuenta = $_POST['numero_cuenta'];
  $nombre_propietario = ucwords(mb_strtolower($_POST['nombre_propietario']));
  $cedula_cuenta = ucwords(mb_strtolower($_POST['cedula_cuenta']));
  $telefono_cuenta = ucwords(mb_strtolower($_POST['telefono_cuenta']));


  $query = "INSERT INTO bancos (id_banco, nombre_banco, codigo_banco, opcion_pago, tipo_cuenta, numero_cuenta, nombre_propietario, cedula_cuenta, telefono_cuenta, disponibilidad, estatus) VALUES (DEFAULT, '{$bancos}', '{$cod_banco}', '{$opcion_pago}', '{$tipo_cuenta}', '{$numero_cuenta}', '{$nombre_propietario}', '{$cedula_cuenta}', '{$telefono_cuenta}', '{$disponibilidad}', 1)";
  // $query = "INSERT INTO bancos (id_banco, nombre_banco, codigo_banco, tipo_cuenta, numero_cuenta, nombre_propietario, cedula_cuenta, telefono_cuenta, estatus) VALUES (DEFAULT, '{$bancos}', '{$cod_banco}', '{$tipo_cuenta}', '{$numero_cuenta}', '{$nombre_propietario}', '{$cedula_cuenta}', '{$telefono_cuenta}', 1)";
  $exec = $lider->registrar($query, "bancos", "id_banco");
  if($exec['ejecucion']==true){
    $response = "1";
        if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Bancos', 'Registrar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
  }else{
    $response = "2";
  }   
  
  $bancos=$lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 ORDER BY nombre_banco asc;");
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


/*  	MODIFICAR	 */
if(!empty($_POST['banco']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){

  $banco = ucwords(mb_strtolower($_POST['banco']));
  $cod_banco = $_POST['codigo_banco'];
  $disponibilidad = ucwords(mb_strtolower($_POST['disponibilidad']));
  $opcion_pago = ucwords(mb_strtolower($_POST['opcion_pago']));
  $tipo_cuenta = ucwords(mb_strtolower($_POST['tipo_cuenta']));
  $numero_cuenta = $_POST['numero_cuenta'];
  $nombre_propietario = ucwords(mb_strtolower($_POST['nombre_propietario']));
  $cedula_cuenta = ucwords(mb_strtolower($_POST['cedula_cuenta']));
  $telefono_cuenta = ucwords(mb_strtolower($_POST['telefono_cuenta']));

  $query = "UPDATE bancos SET nombre_banco = '$banco', codigo_banco='{$cod_banco}', opcion_pago='{$opcion_pago}', tipo_cuenta='{$tipo_cuenta}', numero_cuenta='{$numero_cuenta}', nombre_propietario='{$nombre_propietario}', cedula_cuenta='{$cedula_cuenta}', telefono_cuenta='{$telefono_cuenta}', disponibilidad='{$disponibilidad}', estatus = 1 WHERE id_banco = $id";
  // $query = "UPDATE bancos SET nombre_banco = '$banco', codigo_banco='{$cod_banco}', tipo_cuenta='{$tipo_cuenta}', numero_cuenta='{$numero_cuenta}', nombre_propietario='{$nombre_propietario}', cedula_cuenta='{$cedula_cuenta}', telefono_cuenta='{$telefono_cuenta}', estatus = 1 WHERE id_banco = $id";
  $exec = $lider->modificar($query);

  if($exec['ejecucion']==true){
    $response = "1";
    if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Bancos', 'Editar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
  }else{
    $response = "2";
  }   

  $query = "SELECT * FROM bancos WHERE estatus = 1 and id_banco = $id";
  $bancos=$lider->consultarQuery($query);
  $datas = $bancos[0];
  
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
//   // print_r($exec);
}


/*		ELIMINAR	*/
if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

	$query = "UPDATE bancos SET estatus = 0 WHERE id_banco = $id";
	$res1 = $lider->eliminar($query);

	if($res1['ejecucion']==true){
		$response2 = "1";

        if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Bancos', 'Borrar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }

	}else{
		$response2 = "2"; // echo 'Error en la conexion con la bd';
	}
}



if(empty($_POST)){

	if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
		$query = "SELECT * FROM bancos WHERE estatus = 1 and id_banco = $id";
  		$banco=$lider->consultarQuery($query);
	}
	if($bancos['ejecucion']==1){
		if(!empty($action)){
			if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
				require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			}else{
			    require_once 'public/views/error404.php';
			}
		}else{
			if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
				if(Count($banco)>1){
					$datas = $banco[0];
					if (is_file('public/views/'.$url.'.php')) {
						require_once 'public/views/'.$url.'.php';
					}else{
					    require_once 'public/views/error404.php';
					}
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
}


?>