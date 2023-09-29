<?php 
  $catalogos = $lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 ORDER BY catalogos.nombre_producto_catalogo ASC;");
  $lineas=$lider->consultarQuery("SELECT * FROM lineas WHERE lineas.estatus = 1 ORDER BY lineas.posicion_linea ASC;");
  if(!empty($_POST['linea'])){
    $linea = ucwords(mb_strtolower($_POST['linea']));
    $idss = [];
    if(!empty($_POST['id'])){
      $idss = $_POST['id'];
    }
    $productos = [];
    if(!empty($_POST['productos'])){
      $productos = $_POST['productos'];
    }
    $posiciones = [];
    if(!empty($_POST['posiciones'])){
      $posiciones = $_POST['posiciones'];
    }
    // print_r($_POST);
    // echo "<br><br>";
    // $buscar = $lider->consultarQuery("SELECT * FROM lineas_productos WHERE id_linea = {$linea}");
    // $borrar = $lider->eliminar("DELETE FROM lineas_productos WHERE id_linea = {$linea}");
    $errEstatus = 0;
    $nI = 0;
    foreach ($idss as $id) {
    // foreach ($productos as $codigo) {
      $query = "UPDATE lineas_productos SET posicion={$posiciones[$nI]} WHERE id_linea_producto={$id}";
      // echo $id." ".$productos[$nI]." ".$posiciones[$nI]." | ";
      // echo $query;
      // echo "<br>";
      // $query = "INSERT INTO lineas_productos (id_linea_producto, id_linea, codigo_producto_catalogo, estatus) VALUES (DEFAULT, {$linea}, '{$codigo}', 1)";
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        // $response = "1";
      }else{
        $errEstatus++;
      }
      $nI++;
    }
    if($errEstatus==0){
      $response="1";
    }else{
      $response="2";
    }
    $lineasp = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1");
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
    $lineasp = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1");
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



?>