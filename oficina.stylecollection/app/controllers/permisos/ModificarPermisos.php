<?php 

  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();


if(!empty($_POST['validarData'])){
  $nombre = ucwords(mb_strtolower($_POST['nombre']));
  $query = "SELECT * FROM permisos WHERE id_permiso = $id";
  $res1 = $lider->consultarQuery($query);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
        $response = "1";
    }else{
      $response = "9"; //echo "Registro ya guardado.";
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
  
  $query = "UPDATE permisos SET nombre_permiso='$nombre', estatus=1 WHERE id_permiso = $id";
  $exec = $lider->modificar($query);
  // print_r($exec);
  if($exec['ejecucion']==true){
    $response = "1";

            if(!empty($modulo) && !empty($accion)){
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Permisos', 'Editar', '{$fecha}', '{$hora}')";
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            }
  }else{
    $response = "2";
  }

    $permisos = $lider->consultarQuery("SELECT * FROM permisos WHERE estatus = 1 and id_permiso = $id");
      $datas = $permisos[0];
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
    
  $permisos = $lider->consultarQuery("SELECT * FROM permisos WHERE estatus = 1 and id_permiso = $id");
  if(Count($permisos)>1){
      $datas = $permisos[0];
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