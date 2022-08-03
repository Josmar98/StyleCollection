<?php 

$amFragancias = 0;
$amFraganciasR = 0;
$amFraganciasC = 0;
$amFraganciasE = 0;
$amFraganciasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Fragancias"){
      $amFragancias = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amFraganciasR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amFraganciasC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amFraganciasE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amFraganciasB = 1;
      }
    }
  }
}
if($amFragancias == 1){

    if($amFraganciasC == 1){

	     $fragancias=$lider->consultarQuery("SELECT * FROM fragancias WHERE estatus = 1 ORDER BY fragancia asc;");
            /* VALIDACION PARA AGREGAR */
        if(!empty($_POST['validarData']) && empty($_GET['operation'])){
          if($amFraganciasR == 1){
              $fragancia = ucwords($_POST['fragancia']);
              $query = "SELECT * FROM fragancias WHERE fragancia = '$fragancia'";
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
          }else{
            require_once 'public/views/error404.php';
          }
        }

            /* AGREGAR */
        if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && empty($_GET['operation']) ){
          if($amFraganciasR == 1){

              // print_r($_POST);
              $fr = strtolower($_POST['fragancia']);
              $fragancia = ucwords($fr);
              $query = "INSERT INTO fragancias (id_fragancia, fragancia, estatus) VALUES (DEFAULT, '$fragancia', 1)";
              $exec = $lider->registrar($query, "fragancias", "id_fragancia");
              if($exec['ejecucion']==true){
                $response = "1";

                        if(!empty($modulo) && !empty($accion)){
                          $fecha = date('Y-m-d');
                          $hora = date('H:i:a');
                          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Fragancias', 'Registrar', '{$fecha}', '{$hora}')";
                          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                        }
              }else{
                $response = "2";
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
          }else{
            require_once 'public/views/error404.php';
          }
        }

            /* VALIDACION PARA MODIFICAR */
          if(!empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
            if($amFraganciasE == 1){
              $fragancia = ucwords($_POST['fragancia']);
              $query = "SELECT * FROM fragancias WHERE id_fragancia = $id";
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
          }
         
            /*  	MODIFICAR	 */
          if(!empty($_POST['fragancia']) && empty($_POST['validarData']) && !empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
            if($amFraganciasE == 1){

              // print_r($_POST);
              $fragancia = ucwords($_POST['fragancia']);
              $query = "UPDATE fragancias SET fragancia = '$fragancia', estatus = 1 WHERE id_fragancia = $id";
              $exec = $lider->modificar($query);
              if($exec['ejecucion']==true){
                $response = "1";

                        if(!empty($modulo) && !empty($accion)){
                          $fecha = date('Y-m-d');
                          $hora = date('H:i:a');
                          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Fragancias', 'Editar', '{$fecha}', '{$hora}')";
                          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                        }
              }else{
                $response = "2";
              }   
              $query = "SELECT * FROM fragancias WHERE estatus = 1 and id_fragancia = $id";
              $fragancia=$lider->consultarQuery($query);
              $datas = $fragancia[0];
              
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
            }else{
              require_once 'public/views/error404.php';
            }
          }

          /*		ELIMINAR	*/
          if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
            if($amFraganciasB == 1){

            	$query = "UPDATE fragancias SET estatus = 0 WHERE id_fragancia = $id";
            	$res1 = $lider->eliminar($query);

            	if($res1['ejecucion']==true){
            		$response2 = "1";
            	}else{
            		$response2 = "2"; // echo 'Error en la conexion con la bd';
            	}
            }else{
              require_once 'public/views/error404.php';
            }
          }

          if(empty($_POST)){

          	if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
          		$query = "SELECT * FROM fragancias WHERE estatus = 1 and id_fragancia = $id";
            		$fragancia=$lider->consultarQuery($query);
          	}
          	if($fragancias['ejecucion']==1){
          		if(!empty($action)){
          			if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
          				require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
          			}else{
          			    require_once 'public/views/error404.php';
          			}
          		}else{
          			if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){
          				if(Count($fragancia)>1){
          					$datas = $fragancia[0];
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
    }else{
      require_once 'public/views/error404.php';
    }



}else{
  require_once 'public/views/error404.php';
}


?>