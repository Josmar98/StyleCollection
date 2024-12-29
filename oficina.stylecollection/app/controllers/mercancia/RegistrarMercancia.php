<?php 

$amPremios = 0;
$amPremiosR = 0;
$amPremiosC = 0;
$amPremiosE = 0;
$amPremiosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
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
        // $nombre_producto = ucwords(mb_strtolower($_POST['nombre_mercancia']));
        $codigo_mercancia = mb_strtoupper($_POST['codigo_mercancia']);
        // $cantidad = mb_strtolower($_POST['cantidad']);
        $query = "SELECT * FROM mercancia WHERE codigo_mercancia = '$codigo_mercancia'";
        $res1 = $lider->consultarQuery($query);
          // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM mercancia WHERE codigo_mercancia = '$codigo_mercancia' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE mercancia SET estatus = 1 WHERE codigo_mercancia = '$codigo_mercancia'");
                if($res3['ejecucion']==true){
                  $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Mercancia', 'Registrar', '{$fecha}', '{$hora}')";
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


      if(!empty($_POST['nombre_mercancia']) && !empty($_POST['codigo_mercancia']) && empty($_POST['validarData'])){

        // print_r($_POST);
        // die();
        $nombre = ucwords(mb_strtolower($_POST['nombre_mercancia']));
        $codigo = mb_strtoupper($_POST['codigo_mercancia']);
        $medidas = mb_strtolower($_POST['medidas_mercancia']);
        $marca = mb_strtoupper($_POST['marca_mercancia']);
        $tamano = mb_strtoupper($_POST['tam_mercancia']);
        $color = mb_strtoupper($_POST['color_mercancia']);
        $descripcion = ucwords(mb_strtolower($_POST['descripcion_mercancia']));
        // $precio = $_POST['precio'];
        // $fragancias = $_POST['fragancias'];
        
        $query = "INSERT INTO mercancia (id_mercancia, mercancia, codigo_mercancia, medidas_mercancia, marca_mercancia, tam_mercancia, color_mercancia, descripcion_mercancia, estatus) VALUES (DEFAULT, '$nombre', '$codigo',  '$medidas', '$marca', '$tamano', '$color', '$descripcion', 1)";

        $exec = $lider->registrar($query, "mercancia", "id_mercancia");
        if($exec['ejecucion']==true){
          $response = "1";
          // $id_producto = $exec['id'];
        	// foreach ($fragancias as $id_fragancia) {
        	//   	$query = "INSERT INTO productos_fragancias (id_productos_fragancias, id_producto, id_fragancia) VALUES (DEFAULT, $id_producto, $id_fragancia)";
        	//   	$exec = $lider->registrar($query, "productos_fragancias", "id_productos_fragancias");
        	//   	if($exec['ejecucion']==true ){
        	//   		$response = "1";
        	//   	}else{
        	//   		$response = "2";
        	//   	}
        	// }
          if(!empty($modulo) && !empty($accion)){
            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Mercancia', 'Registrar', '{$fecha}', '{$hora}')";
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
      }
      if(empty($_POST)){
        // $fragancias = $lider->consultarQuery("SELECT * FROM fragancias WHERE estatus = 1 ORDER BY fragancia asc;");
        
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