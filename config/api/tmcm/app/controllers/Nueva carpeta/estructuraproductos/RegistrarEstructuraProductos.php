<?php 
  $catalogos = $lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1");
  
  if(!empty($_POST['nombre_camp']) && empty($_POST['validarData'])){
    $nombre_camp = ucwords(mb_strtolower($_POST['nombre_camp']));
    $productos = [];
    if(!empty($_POST['productos'])){
      $productos = $_POST['productos'];
    }
    $totalProducto = count($productos);
    $borrar = $lider->eliminar("DELETE FROM estructura_catalogo WHERE estatus=1");
    $errEstatus = 0;
    $nnindex = 0;
    foreach ($productos as $codigo) {
      $query = "INSERT INTO estructura_catalogo (id_estructura_catalogo, nombre_campana, codigo_producto_catalogo, estatus) VALUES ($nnindex, '{$nombre_camp}', '{$codigo}', 1)";
      $exec = $lider->registrar($query, "estructura_catalogo", "id_estructura_catalogo");
      if($exec['ejecucion']==true){
        // $response = "1";
      }else{
        $errEstatus++;
      }
      $nnindex++;
    }
    if($errEstatus==0){
      $response="1";
    }else{
      $response="2";
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