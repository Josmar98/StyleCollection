<?php 

  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();
if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Conciliador"){


  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $query = "SELECT * FROM rutas WHERE nombre_ruta = '$nombre'";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $response = "9"; //echo "Registro ya guardado.";

        $res2 = $lider->consultarQuery("SELECT * FROM rutas WHERE nombre_ruta = '$nombre' and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE rutas SET estatus = 1 WHERE nombre_ruta = '$nombre'");
            if($res3['ejecucion']==true){
              $response = "1";
            }
          }else{
            $response = "9"; //echo "Registro ya guardado.";
          }
        }

      }else{
          $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(!empty($_POST['nombre']) && empty($_POST['validarData'])){

    // print_r($_POST);
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    // $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
    
    $query = "INSERT INTO rutas (id_ruta, nombre_ruta, estatus) VALUES (DEFAULT, '$nombre', 1)";
    $exec = $lider->registrar($query, "rutas", "id_ruta");
    // print_r($exec);
    if($exec['ejecucion']==true){
      $response = "1";
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