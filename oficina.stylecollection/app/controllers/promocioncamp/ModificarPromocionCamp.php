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
        $res1 = $res1[0];
        if($res1['id_promocion']==$id){
          $response = "1";
        }else{
          $response = "9";
        }
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
    $query = "UPDATE promocion SET nombre_promocion='{$nombre}', precio_promocion={$precio}, estatus=1 WHERE id_promocion={$id}";
    // // $exec = ['ejecucion'=>true, 'id'=>1];
    $errores = 0;
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true ){
      $exec2 = $lider->eliminar("DELETE FROM productos_promocion WHERE id_promocion = {$id}");
      foreach ($productos as $prod) {
        $tipo = "";
        list($tipo, $id_producto) = explode('-', $prod);
        $tipo = ucwords(mb_strtolower($tipo));
        $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, '{$tipo}', {$id_producto}, 1)";
        $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
        if($exec2['ejecucion']==true ){}else{
          $errores++;
        }
      }

      $exec2 = $lider->eliminar("DELETE FROM premios_promocion WHERE id_promocion = {$id}");
      foreach ($premios as $prem) {
        $tipo = "";
        list($tipo, $id_premio) = explode('-', $prem);
        $tipo = ucwords(mb_strtolower($tipo));
        $query3 = "INSERT INTO premios_promocion (id_premio_promocion, id_campana, id_promocion, tipo_premio, id_premio, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, '{$tipo}', {$id_premio}, 1)";
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

    $promocion = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1");
    $promocion = $promocion[0];
      $promocion_productos = $lider->consultarQuery("SELECT * FROM productos_promocion WHERE productos_promocion.id_promocion = {$id} and productos_promocion.id_campana = {$id_campana} and productos_promocion.estatus = 1");
      $promocion_premios = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_promocion = {$id} and premios_promocion.id_campana = {$id_campana} and premios_promocion.estatus = 1");
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


  if(empty($_POST)){
    $promocion = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1");
    if($promocion['ejecucion']==true){
      $promocion = $promocion[0];
      $promocion_productos = $lider->consultarQuery("SELECT * FROM productos_promocion WHERE productos_promocion.id_promocion = {$id} and productos_promocion.id_campana = {$id_campana} and productos_promocion.estatus = 1");
      $promocion_premios = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_promocion = {$id} and premios_promocion.id_campana = {$id_campana} and premios_promocion.estatus = 1");
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
    }else{
      require_once 'public/views/error404.php';
    }
  }

}else{
  require_once 'public/views/error404.php';
}

?>