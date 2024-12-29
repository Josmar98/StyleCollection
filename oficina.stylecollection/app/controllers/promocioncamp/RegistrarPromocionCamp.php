<?php 
if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){
  
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $precio = (Float) $_POST['precio'];

    $query = "SELECT * FROM promocion WHERE nombre_promocion = '{$nombre}' and precio_promocion = {$precio} and id_campana = {$id_campana} and estatus = 1";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        $response = "9"; //echo "Registro ya guardado.";
        // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
        // if($res2['ejecucion']==true){
        //   if(Count($res2)>1){
        //     $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
        //     if($res3['ejecucion']==true){
        //       $response = "1";
        //     }
        //   }else{
        //     $response = "9"; //echo "Registro ya guardado.";
        //   }
        // }
      }else{
        $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }

  if(!empty($_POST['nombre']) && !empty($_POST['precio']) && !empty($_POST['productos']) && !empty($_POST['premios']) ){
    // print_r($_POST);
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $precio = (Float) $_POST['precio'];
    $productos = $_POST['productos'];
    $premios = $_POST['premios'];
    $query = "INSERT INTO promocion (id_promocion, id_campana, nombre_promocion, precio_promocion, estatus) VALUES (DEFAULT, {$id_campana}, '{$nombre}', {$precio}, 1)";
    // $exec = ['ejecucion'=>true, 'id'=>1];
    $errores = 0;
    $exec = $lider->registrar($query, "promocion", "id_promocion");
    if($exec['ejecucion']==true ){
      $id_promocion = $exec['id'];
      // $exec2 = $lider->eliminar("DELETE FROM productos_promocion WHERE id_promocion = {$id_promocion}");
      foreach ($productos as $prod) {
        $tipo = "";
        list($tipo, $id_producto) = explode('-', $prod);
        $tipo = ucwords(mb_strtolower($tipo));
        $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipo}', {$id_producto}, 1)";
        $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
        if($exec2['ejecucion']==true ){}else{
          $errores++;
        }
      }

      // $exec2 = $lider->eliminar("DELETE FROM premios_promocion WHERE id_promocion = {$id_promocion}");
      foreach ($premios as $prem) {
        $tipo = "";
        list($tipo, $id_premio) = explode('-', $prem);
        $tipo = ucwords(mb_strtolower($tipo));
        $query3 = "INSERT INTO premios_promocion (id_premio_promocion, id_campana, id_promocion, tipo_premio, id_premio, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipo}', {$id_premio}, 1)";
        $exec3 = $lider->registrar($query3, "premios_promocion", "id_premio_promocion");
        if($exec3['ejecucion']==true ){}else{
          $errores++;
        }
      }
      // $response = "1";
    }else{
      $errores++;
      // $response = "2";
    }

    if($errores==0){
      $response = "1";
    }else{
      $response = "2";
    }
    // echo "RESPUESTA DE EJECUCION: ".$response."<br>";

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

    $productos=$lider->consultarQuery("SELECT * FROM productos");
    $premios=$lider->consultarQuery("SELECT * FROM premios");

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