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
if($amPremiosR == 1){
        if(!empty($_POST['validarData'])){
          $nombre_premio = ucwords(mb_strtolower($_POST['nombre_premio']));
          $query = "SELECT * FROM premios WHERE nombre_premio = '$nombre_premio'";
          $res1 = $lider->consultarQuery($query);
          if($res1['ejecucion']==true){
            if(Count($res1)>1){
              // $response = "9"; //echo "Registro ya guardado.";

              $res2 = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio = '$nombre_premio' and estatus = 0");
              if($res2['ejecucion']==true){
                if(Count($res2)>1){
                  $res3 = $lider->modificar("UPDATE premios SET estatus = 1 WHERE nombre_premio = '$nombre_premio'");
                  if($res3['ejecucion']==true){
                    $response = "1";
                    if(!empty($modulo) && !empty($accion)){
                      $fecha = date('Y-m-d');
                      $hora = date('H:i:a');
                      $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios', 'Registrar', '{$fecha}', '{$hora}')";
                      $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                    }
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
        if(!empty($_POST['nombre_premio']) && empty($_POST['validarData'])){
          // print_r($_POST);

          $nombre_premio = ucwords(mb_strtolower($_POST['nombre_premio']));
          $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
          $precio = $_POST['precio'];
          
          $query = "INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '$nombre_premio', '$precio', '$descripcion', 1)";

          $exec = $lider->registrar($query, "premios", "id_premio");
          if($exec['ejecucion']==true){
            $response = "1";
                   //    $id_producto = $exec['id'];
                  	// foreach ($fragancias as $id_fragancia) {
                  	//   	$query = "INSERT INTO productos_fragancias (id_productos_fragancias, id_producto, id_fragancia) VALUES (DEFAULT, $id_producto, $id_fragancia)";
                  	//   	$exec = $lider->registrar($query, "productos_fragancias", "id_productos_fragancias");
                  	//   	if($exec['ejecucion']==true ){
                  	//   		$response = "1";
                  	//   	}else{
                  	//   		$response = "2";
                  	//   	}
        	             // }

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