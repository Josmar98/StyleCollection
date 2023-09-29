<?php 
  $catalogos = $lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 ORDER BY catalogos.nombre_producto_catalogo ASC;");
  $lineas=$lider->consultarQuery("SELECT * FROM lineas WHERE lineas.estatus = 1 ORDER BY lineas.posicion_linea ASC;");
  if(!empty($_POST['linea'])){
    $linea = ucwords(mb_strtolower($_POST['linea']));
    $productos = [];
    if(!empty($_POST['productos'])){
      $productos = $_POST['productos'];
    }
    // print_r($_POST);
    // echo "<br><br>";
    $totalProducto = count($productos);
    // $buscar = $lider->consultarQuery("SELECT * FROM lineas_productos WHERE id_linea = {$linea}");
    $borrar = $lider->eliminar("DELETE FROM lineas_productos WHERE id_linea = {$linea}");
    $errEstatus = 0;
    foreach ($productos as $codigo) {
      $query = "INSERT INTO lineas_productos (id_linea_producto, id_linea, codigo_producto_catalogo, posicion, estatus) VALUES (DEFAULT, {$linea}, '{$codigo}', 0, 1)";
      $exec = $lider->registrar($query, "lineas_productos", "id_linea_producto");
      if($exec['ejecucion']==true){
        // $response = "1";
      }else{
        $errEstatus++;
      }
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