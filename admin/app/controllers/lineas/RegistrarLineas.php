<?php 
  $catalogos = $lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1");
  if(!empty($_POST['linea']) && !empty($_POST['posicion']) && empty($_POST['validarData'])){
    $linea = ucwords(mb_strtolower($_POST['linea']));
    $pos = $_POST['posicion'];
    $buscar = $lider->consultarQuery("SELECT * FROM lineas WHERE nombre_linea = '{$linea}'");
    if($buscar['ejecucion']==1){
      if(count($buscar) > 1){
        // print_r($_POST);
        // echo "<br><br>";
        // print_r($buscar);
        if($buscar[0]['estatus']==0){
          $ids = $buscar[0]['id_linea'];
          $query = "UPDATE lineas SET nombre_linea='{$linea}', posicion_linea={$pos}, estatus=1 WHERE id_linea={$ids}";
          $exec = $lider->modificar($query);
          if($exec['ejecucion']==true){
            $response = "1";
          }else{
            $response = "2";
          }
        }else{
          $response = "9";
        }
      }else{
        $query = "INSERT INTO lineas (id_linea, nombre_linea, posicion_linea, estatus) VALUES (DEFAULT, '{$linea}', {$pos}, 1)";
        $exec = $lider->registrar($query, "lineas", "id_linea");
        if($exec['ejecucion']==true){
          $response = "1";
        }else{
          $response = "2";
        }
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
    $lineas = $lider->consultarQuery("SELECT * FROM lineas, lineas_productos WHERE lineas.id_linea = lineas_productos.id_linea and lineas.estatus = 1 and lineas_productos.estatus = 1");
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