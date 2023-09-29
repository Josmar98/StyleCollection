<?php 
  $lineas=$lider->consultarQuery("SELECT * FROM lineas WHERE lineas.estatus = 1 and lineas.id_linea = {$id}");
  if(!empty($_POST['linea']) && !empty($_POST['posicion']) && empty($_POST['validarData'])){
    $linea = ucwords(mb_strtolower($_POST['linea']));
    $pos = $_POST['posicion'];
    $query = "UPDATE lineas SET nombre_linea='{$linea}', posicion_linea={$pos}, estatus=1 WHERE id_linea={$id}";
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true){
      $response = "1";
    }else{
      $response = "2";
    }
    
    if(count($lineas)>1){
      $linea = $lineas[0];
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
  
  if(empty($_POST)){
    // $lineas = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1");
    if(count($lineas)>1){
      $linea = $lineas[0];
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



?>