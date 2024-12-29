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
if($amProductosE == 1){
    if(!empty($_POST['validarData'])){
      
      // $nombre_producto = $_POST['nombre_producto'];
      $id_producto = $_POST['id_producto'];
      $query = "SELECT * FROM productos WHERE id_producto = $id_producto";
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


    if(!empty($_POST['nombre_producto']) && empty($_POST['validarData'])){
      // die();
      // print_r($_POST);
      $id_producto = $_POST['id_producto'];
      $nombre_producto = ucwords(mb_strtolower($_POST['nombre_producto']));
      $codigo_producto = mb_strtoupper($_POST['codigo_producto']);
      $cantidad = mb_strtolower($_POST['cantidad']);
      $marca = mb_strtoupper($_POST['marca_producto']);
      $color = mb_strtoupper($_POST['color_producto']);
      $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
      
      $query = "UPDATE productos SET codigo_producto='$codigo_producto',  producto='$nombre_producto', cantidad='$cantidad', marca_producto='$marca', color_producto='$color', descripcion = '$descripcion',  estatus=1 WHERE id_producto = $id_producto";
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";
        // $id_producto = $exec['id'];
        // foreach ($fragancias as $id_fragancia) {
        //     $query = "INSERT INTO productos_fragancias (id_productos_fragancias, id_producto, id_fragancia) VALUES (DEFAULT, $id, $id_fragancia)";
        //     $exec = $lider->registrar($query, "productos_fragancias", "id_productos_fragancias");
        //     if($exec['ejecucion']==true ){
        //       $response = "1";
        //     }else{
        //       $response = "2";
        //     }
        // }
        if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Editar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }

      }else{
        $response = "2";
      }
      // $exec = $lider->eliminar("DELETE FROM productos_fragancias WHERE id_producto = $id");
      // if($exec['ejecucion']==true){
      // }else{
      //   $response = "2";
      // }


      if(!empty($_GET['id'])){
        $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 and id_producto = $id");
      }
      if(!empty($_GET['cod'])){
        $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 and codigo_producto = '$cod'");
      }
      if(count($productos)<2){
        $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 and id_producto = $id_producto");
      }
      $producto = $productos[0];

      // $fragancias = $lider->consultarQuery("SELECT * FROM fragancias WHERE estatus = 1 ORDER BY fragancia asc");
      // $fraganciasp = $lider->consultarQuery("SELECT * FROM fragancias, productos_fragancias, productos WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia and productos.id_producto = productos_fragancias.id_producto and productos.id_producto = $id");
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
    if(empty($_POST)){
      if(!empty($_GET['id'])){
        $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 and id_producto = $id");
      }
      if(!empty($_GET['cod'])){
        $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 and codigo_producto = '$cod'");
      }
      // print_r($productos);
      // $fragancias = $lider->consultarQuery("SELECT * FROM fragancias WHERE estatus = 1 ORDER BY fragancia asc");
      // $fraganciasp = $lider->consultarQuery("SELECT * FROM fragancias, productos_fragancias, productos WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia and productos.id_producto = productos_fragancias.id_producto and productos.id_producto = $id");
      if(count($productos)>1){
          $producto = $productos[0];
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

    }

}else{
    require_once 'public/views/error404.php';
}

?>