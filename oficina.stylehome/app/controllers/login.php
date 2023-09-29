<?php

  if(strtolower($url)=="login"){
    if(!empty($action)){
      if($action=="Consultar"){
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
            // $_SESSION['home']['admin1'] = true;
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$username' and password = '$pass'";
          }else{
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$username' and password = '$pass' and estatus = 1";    
          }
          $res1 = $lider->consultarQuery($query);
          if($res1['ejecucion']==true){
            if(Count($res1)>1){
            	$cuenta = $res1[0];
              $accesosUsuarios = ['estatus'=>true, 'ejecucion'=>true];
              $accesosUsuarios = $lider->consultarQuery("SELECT * FROM accesosUsuarios WHERE id_cliente = {$cuenta['id_cliente']}");
              $niveles = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE clientes.id_cliente = usuarios.id_cliente and roles.id_rol = usuarios.id_rol and clientes.id_cliente = {$cuenta['id_cliente']}");
              $niveles = $niveles[0];
              if($niveles['nombre_rol']=="Superusuario" || $niveles['nombre_rol']=="Administrador"){
                if(Count($accesosUsuarios)>1){
                }else{
                  $accesosUsuarios = [0=>['permiso_accesos'=>"on", 'id_cliente'=>$cuenta['id_cliente']], "ejecucion"=>true];
                }
              }
              if(Count($accesosUsuarios)>1){
                $acc = $accesosUsuarios[0];
                $acc['permiso_accesos']="on";
                // echo $cuenta['id_cliente'];
                // echo $acc['permiso_accesos'];
                if($acc['permiso_accesos']=="on"){
                  // print_r($cuenta);
                  	$_SESSION['home']['id_rol'] = $cuenta['id_rol'];
                  	$_SESSION['home']['id_usuario'] = $cuenta['id_usuario'];
                  	$_SESSION['home']['id_cliente'] = $cuenta['id_cliente'];
                  	$_SESSION['home']['username'] = $cuenta['nombre_usuario'];
                  	$_SESSION['home']['pass'] = $cuenta['password'];
                  	$_SESSION['home']['home_style'] = true;
                  	$id_cliente = $_SESSION['home']['id_cliente'];
                  	$id_rol = $cuenta['id_rol'];
                    $_SESSION['home']['cuentaUsuario'] = $cuenta;


                    $_SESSION['home']['recuerdame'] = "0";

                    if($recuerdame=="1"){
                      $_SESSION['home']['recuerdame'] = "1";
                    }else{
                      $_SESSION['home']['recuerdame'] = "0";    
                    }


                  	$query = "SELECT * FROM roles WHERE id_rol=$id_rol";
                  	$roles = $lider->consultarQuery($query);
                  	if($roles['ejecucion']){
                  		$_SESSION['home']['nombre_rol'] = $roles[0]['nombre_rol'];
                  	}
                  	
                  	$query = "SELECT * FROM accesos as a, roles as r, permisos as p, modulos as m  WHERE a.id_rol = r.id_rol and a.id_permiso = p.id_permiso and a.id_modulo = m.id_modulo and r.id_rol = '$id_rol'";
                  	$resAccesos = $lider->consultarQuery($query);
                  	if($resAccesos['ejecucion']){
                  		$_SESSION['home']['accesos'] = $resAccesos;
                  	}

                  	$query = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
                  	$res2 = $lider->consultarQuery($query);
                  	if($res2['ejecucion']==true){
                  		if(Count($res2)>1){
                  			$_SESSION['home']['cuenta'] = $res2[0];
                    		$response = "1";

                          // if(!empty($modulo) && !empty($accion)){
                          //   $fecha = date('Y-m-d');
                          //   $hora = date('H:i:a');
                          //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Sistema', 'Inicio de Sesion', '{$fecha}', '{$hora}')";
                          //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                          // }
                  		}else{
                    			$response = "5";
                  		}
                  	}else{
                  		unset($_SESSION['home']['cuenta']);
                  		unset($_SESSION['home']['accesos']);
              	    	unset($_SESSION['home']['id_usuario']);
              	    	unset($_SESSION['home']['id_rol']);
              	    	unset($_SESSION['home']['nombre_rol']);
              	    	unset($_SESSION['home']['id_cliente']);
              	    	unset($_SESSION['home']['username']);
              	    	unset($_SESSION['home']['pass']);
              	    	unset($_SESSION['home']['home_style']);
                      unset($_SESSION['home']['admin1']);
                      unset($_SESSION['home']['recuerdame']);
                      unset($_SESSION['home']['cuentaUsuario']);
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
    			if (is_file('public/views/'.$url.'.php')) {
    				require_once 'public/views/'.$url.'.php';
    			}else{
    			    require_once 'public/views/error404.php';
    			}
        }
      }
    }
  }
?>