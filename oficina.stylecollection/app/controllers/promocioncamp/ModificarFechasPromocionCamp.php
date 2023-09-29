<?php 
if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){
  
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  // if(!empty($_POST['validarData'])){
  //   $nombre = ucwords(mb_strtolower($_POST['nombre']));
  //   $precio = (Float) $_POST['precio'];

  //   $query = "SELECT * FROM promocion WHERE nombre_promocion = '{$nombre}' and precio_promocion = {$precio} and id_campana = {$id_campana} and estatus = 1";
  //   $res1 = $lider->consultarQuery($query);
  //   if($res1['ejecucion']==true){
  //     if(Count($res1)>1){
  //       $response = "9"; //echo "Registro ya guardado.";
  //       // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
  //       // if($res2['ejecucion']==true){
  //       //   if(Count($res2)>1){
  //       //     $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
  //       //     if($res3['ejecucion']==true){
  //       //       $response = "1";
  //       //     }
  //       //   }else{
  //       //     $response = "9"; //echo "Registro ya guardado.";
  //       //   }
  //       // }
  //     }else{
  //       $response = "1";
  //     }
  //   }else{
  //     $response = "5"; // echo 'Error en la conexion con la bd';
  //   }
  //   echo $response;
  // }

  if(!empty($_POST['fechaA']) && !empty($_POST['fechaC']) && !empty($_POST['fechaPago'])){
    // print_r($_POST);
    $fechaA = $_POST['fechaA'];
    $fechaC = $_POST['fechaC'];
    $fechaPago = $_POST['fechaPago'];
    $exec2 = $lider->eliminar("DELETE FROM fechas_promocion WHERE fechas_promocion.id_campana = {$id_campana}");
    if($exec2['ejecucion']==true){
      $query = "INSERT INTO fechas_promocion (id_fecha_promocion, id_campana, fecha_apertura_promocion, fecha_cierre_promocion, fecha_pago_promocion, estatus) VALUES (DEFAULT, {$id_campana}, '{$fechaA}', '{$fechaC}', '{$fechaPago}', 1)";
      $exec = $lider->registrar($query, "fechas_promocion", "id_fecha_promocion");
      if($exec['ejecucion']==true ){
        $response = "1";
      }else{
        $response = "2";
      }
    }else{
      $response = "5";
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
  }


  if(empty($_POST)){
    $fechas = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE fechas_promocion.id_campana = {$id_campana} and fechas_promocion.estatus = 1");
    if(count($fechas)>1){
      $fechas=$fechas[0];
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