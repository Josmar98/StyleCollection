<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

  
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  if(!empty($_POST['promocion']) && !empty($_POST['cantidad_existencia']) ){
    $id_promocion = $_POST['promocion'];
    $existencia = $_POST['cantidad_existencia'];

    $query = "INSERT INTO existencias_promocion (id_existencia_promocion, id_campana, id_promocion, existencia_total, existencia_actual, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, {$existencia}, {$existencia}, 1)";
    $exec = $lider->registrar($query, "existencias_promocion", "id_existencia_promocion");
    if($exec['ejecucion']==true ){
      $response = "1";

      // if(!empty($modulo) && !empty($accion)){
      //   $fecha = date('Y-m-d');
      //   $hora = date('H:i:a');
      //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Existencias', 'Registrar', '{$fecha}', '{$hora}')";
      //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
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

    $promociones = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.estatus = 1 and promocion.id_campana = {$id_campana}"); 
    $existencias = $lider->consultarQuery("SELECT * FROM promocion, existencias_promocion WHERE existencias_promocion.id_promocion = promocion.id_promocion and  existencias_promocion.estatus = 1 and existencias_promocion.id_campana = {$id_campana}");

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