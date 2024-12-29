<?php 

$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
      $amInventario = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amInventarioR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amInventarioC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amInventarioE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amInventarioB = 1;
      }
    }
  }
}
if($amInventarioE == 1){
    if(!empty($_POST['validarData'])){
      
      // $nombre_producto = $_POST['nombre_producto'];
      $id_mercancia = $_POST['id_mercancia'];
      $query = "SELECT * FROM mercancia WHERE id_mercancia = $id_mercancia";
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


    if(!empty($_POST['nombre_mercancia']) && empty($_POST['validarData'])){
      // print_r($_POST);
      // die();
      $id_mercancia = $_POST['id_mercancia'];
      $nombre = ucwords(mb_strtolower($_POST['nombre_mercancia']));
      $codigo = mb_strtoupper($_POST['codigo_mercancia']);
      $medidas = mb_strtolower($_POST['medidas_mercancia']);
      $marca = mb_strtoupper($_POST['marca_mercancia']);
      $tamano = mb_strtoupper($_POST['tam_mercancia']);
      $color = mb_strtoupper($_POST['color_mercancia']);
      $descripcion = ucwords(mb_strtolower($_POST['descripcion_mercancia']));
      
      $query = "UPDATE mercancia SET codigo_mercancia='$codigo',  mercancia='$nombre', medidas_mercancia='$medidas', marca_mercancia='$marca', tam_mercancia='$tamano',  color_mercancia='$color', descripcion_mercancia='$descripcion',  estatus=1 WHERE id_mercancia = $id_mercancia";
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
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Mercancia', 'Editar', '{$fecha}', '{$hora}')";
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
        $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 and id_mercancia = $id");
      }
      if(!empty($_GET['cod'])){
        $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 and codigo_mercancia = '$cod'");
      }
      $mercancia = $mercancia[0];
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
        $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 and id_mercancia = $id");
      }
      if(!empty($_GET['cod'])){
        $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus = 1 and codigo_mercancia = '$cod'");
      }
      if(count($mercancia)>1){
          $mercancia = $mercancia[0];
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