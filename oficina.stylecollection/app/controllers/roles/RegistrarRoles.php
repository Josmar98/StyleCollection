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
  $query = "SELECT * FROM roles WHERE nombre_rol = '$nombre'";
  $res1 = $lider->consultarQuery($query);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
      
      $res2 = $lider->consultarQuery("SELECT * FROM roles WHERE nombre_rol = '$nombre' and estatus = 0");
      if($res2['ejecucion']==true){
        if(Count($res2)>1){
          $res3 = $lider->modificar("UPDATE roles SET estatus = 1 WHERE nombre_rol = '$nombre'");
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

  // print_r($_POST['accesos']);
  $nombre = ucwords(mb_strtolower($_POST['nombre']));
  // $descripcion = ucwords(mb_strtolower($_POST['descripcion']));

  // if(!empty($_POST['accesos'])){
  //   $accesos = $_POST['accesos'];
  //   print_r($accesos);
  // }
  // foreach ($accesos as $key) {
  //     echo " | ";
  //     echo $key.": ";
  //     echo " | ";
  //     echo "Permiso: ".$_POST["permiso".$key];
  //     echo " | ";
  //     echo "Modulo: ".$_POST["modulo".$key];
  //     echo " | ";
  //     echo "<br><br>";
  // }

  $query = "INSERT INTO roles (id_rol, nombre_rol,  estatus) VALUES (DEFAULT, '$nombre', 1)";
  $exec = $lider->registrar($query, "roles", "id_rol");
  if($exec['ejecucion']==true){
    
    if(!empty($_POST['accesos'])){
        $accesos = $_POST['accesos'];
        $id_rol = $exec['id'];
        foreach ($accesos as $key) {
            $id_permiso = $_POST["permiso".$key];
            $id_modulo = $_POST["modulo".$key];
            $query = "INSERT INTO accesos (id_acceso, id_rol, id_permiso, id_modulo) VALUES (DEFAULT, $id_rol, $id_permiso, $id_modulo)";
            $exec = $lider->registrar($query, "accesos", "id_acceso");
            if($exec['ejecucion']==true ){
              $response = "1";
            }else{
              $response = "2";
            }
        }

      }else{
        $response = "1";
      }
            if(!empty($modulo) && !empty($accion)){
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Roles', 'Registrar', '{$fecha}', '{$hora}')";
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            }

  }else{
    $response = "2";
  }

  $modulos = $lider->consultar("modulos");
  $permisos = $lider->consultar("permisos");
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
  $modulos = $lider->consultar("modulos");
  $permisos = $lider->consultar("permisos");
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