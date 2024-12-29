<?php 

$amProductos = 0;
$amProductosR = 0;
$amProductosC = 0;
$amProductosE = 0;
$amProductosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
      $amProductos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amProductosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amProductosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amProductosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amProductosB = 1;
      }
    }
    
  }
}
if($amProductosR == 1){

      if(!empty($_POST['validarData'])){
        $nombre_producto = ucwords(mb_strtolower($_POST['nombre_producto']));
        $codigo_producto = mb_strtoupper($_POST['codigo_producto']);
        $cantidad = mb_strtolower($_POST['cantidad']);
        $query = "SELECT * FROM productos WHERE codigo_producto = '$codigo_producto'";
        $res1 = $lider->consultarQuery($query);
          // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM productos WHERE codigo_producto = '$codigo_producto' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE productos SET estatus = 1 WHERE codigo_producto = '$codigo_producto'");
                if($res3['ejecucion']==true){
                  $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Registrar', '{$fecha}', '{$hora}')";
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


      if(!empty($_POST['nombre_producto']) && !empty($_POST['cantidad']) && empty($_POST['validarData'])){

        // print_r($_POST);
        $nombre_producto = ucwords(mb_strtolower($_POST['nombre_producto']));
        $codigo_producto = mb_strtoupper($_POST['codigo_producto']);
        $cantidad = mb_strtolower($_POST['cantidad']);
        $marca = mb_strtoupper($_POST['marca_producto']);
        $color = mb_strtoupper($_POST['color_producto']);
        $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
        // $precio = $_POST['precio'];
        // $fragancias = $_POST['fragancias'];
        
        $query = "INSERT INTO productos (id_producto, producto, codigo_producto, cantidad, marca_producto, color_producto, descripcion, estatus) VALUES (DEFAULT, '$nombre_producto', '$codigo_producto',  '$cantidad', '$marca', '$color', '$descripcion', 1)";

        $exec = $lider->registrar($query, "productos", "id_producto");
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
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Registrar', '{$fecha}', '{$hora}')";
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