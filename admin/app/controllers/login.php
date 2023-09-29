<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }

if(!empty($_POST['validarData'])){
  $username = ucwords(mb_strtolower($_POST['username']));
  $pass = $_POST['pass'];
  $recuerdame = $_POST['recuerdame'];

  $query = "SELECT * FROM clientes,usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.correo = 'josrod.2112@gmail.com'";
  $resIn = $lider->consultarQuery($query);
  $userAdmin = "";
  $passAdmin = "";
  if($resIn['ejecucion']==true){
    $resAdmin = $resIn[0];
    $userAdmin = $resAdmin['nombre_usuario'];
    $passAdmin = $resAdmin['password'];
  }

  if($username == $userAdmin && $pass == $passAdmin){
    // $_SESSION['admin1Page'] = true;
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$username' and password = '$pass'";
  }else{
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$username' and password = '$pass' and estatus = 1  ";    
  }
  $res1 = $lider->consultarQuery($query);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
    	$cuenta = $res1[0];
      $accesosUsuarios = ['estatus'=>true, 'ejecucion'=>true];
      // $accesosUsuarios = $lider->consultarQuery("SELECT * FROM accesosUsuarios WHERE id_cliente = {$cuenta['id_cliente']}");
      // $niveles = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE clientes.id_cliente = usuarios.id_cliente and roles.id_rol = usuarios.id_rol and clientes.id_cliente = {$cuenta['id_cliente']}");
      // $niveles = $niveles[0];
      // if($niveles['nombre_rol']=="Superusuario" || $niveles['nombre_rol']=="Administrador"){
      //   if(Count($accesosUsuarios)>1){
      //   }else{
      //     $accesosUsuarios = [0=>['permiso_accesos'=>"on", 'id_cliente'=>$cuenta['id_cliente']], "ejecucion"=>true];
      //   }
      // }

      if(Count($accesosUsuarios)>1){
        // $acc = $accesosUsuarios[0];
        $acc['permiso_accesos']="on";
        // echo $cuenta['id_cliente'];
        // echo $acc['permiso_accesos'];
        if($acc['permiso_accesos']=="on"){
          // print_r($cuenta);
          	// $_SESSION['id_rol'] = $cuenta['id_rol'];
          	$_SESSION['id_usuarioPage'] = $cuenta['id_usuario'];
          	$_SESSION['id_clientePage'] = $cuenta['id_cliente'];
          	$_SESSION['usernamePage'] = $cuenta['nombre_usuario'];
          	$_SESSION['passPage'] = $cuenta['password'];
          	$_SESSION['page_style'] = true;
          	$id_cliente = $_SESSION['id_clientePage'];
          	// $id_rol = $cuenta['id_rol'];
            $_SESSION['cuentaUsuarioPage'] = $cuenta;


            $_SESSION['recuerdamePage'] = "0";

            if($recuerdame=="1"){
              $_SESSION['recuerdamePage'] = "1";
            }else{
              $_SESSION['recuerdamePage'] = "0";    
            }


          	// $query = "SELECT * FROM roles WHERE id_rol=$id_rol";
          	// $roles = $lider->consultarQuery($query);
          	// if($roles['ejecucion']){
          	// 	$_SESSION['nombre_rol'] = $roles[0]['nombre_rol'];
          	// }
          	
          	// $query = "SELECT * FROM accesos as a, roles as r, permisos as p, modulos as m  WHERE a.id_rol = r.id_rol and a.id_permiso = p.id_permiso and a.id_modulo = m.id_modulo and r.id_rol = '$id_rol'";
          	// $resAccesos = $lider->consultarQuery($query);
          	// if($resAccesos['ejecucion']){
          	// 	$_SESSION['accesos'] = $resAccesos;
          	// }

          	$query = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
          	$res2 = $lider->consultarQuery($query);
          	if($res2['ejecucion']==true){
          		if(Count($res2)>1){
          			$_SESSION['cuentaPage'] = $res2[0];
            		$response = "1";

                  // if(!empty($modulo) && !empty($accion)){
                  //   $fecha = date('Y-m-d');
                  //   $hora = date('H:i:a');
                  //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Sistema', 'Inicio de Sesion', '{$fecha}', '{$hora}')";
                  //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  // }
          		}else{
            			$response = "5";
          		}
          	}else{
          		unset($_SESSION['cuentaPage']);
          		// unset($_SESSION['accesos']);
      	    	unset($_SESSION['id_usuarioPage']);
      	    	// unset($_SESSION['id_rol']);
      	    	unset($_SESSION['nombre_rolPage']);
      	    	unset($_SESSION['id_clientePage']);
      	    	unset($_SESSION['usernamePage']);
      	    	unset($_SESSION['passPage']);
      	    	unset($_SESSION['page_style']);
              unset($_SESSION['admin1Page']);
              unset($_SESSION['recuerdame']);
              unset($_SESSION['cuentaUsuario']);
                session_unset();
                session_destroy();
            	$response = "5";
          	}
        }else{

          $response = "2";
        }
      }else{
        $response = "2";
      }

    }else{
      $response = "9"; //echo "Registro ya guardado.";
    }
  }else{
    $response = "5"; // echo 'Error en la conexion con la bd';
  }
  echo $response;
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


?>