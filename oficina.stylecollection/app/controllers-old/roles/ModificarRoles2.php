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
  $query = "SELECT * FROM roles WHERE id_rol = $id";
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

  // print_r($_POST['accesos']);
  $nombre = ucwords(mb_strtolower($_POST['nombre']));
  // $descripcion = ucwords(mb_strtolower($_POST['descripcion']));

  // if(!empty($_POST['accesos'])){
  //   $accesos = $_POST['accesos'];
  //   foreach ($accesos as $key) {
  //       echo " | ";
  //       echo $key.": ";
  //       echo " | ";
  //       echo "Permiso: ".$_POST["permiso".$key];
  //       echo " | ";
  //       echo "Modulo: ".$_POST["modulo".$key];
  //       echo " | ";
  //       echo "<br><br>";
  //   }
  // }

  $query = "UPDATE roles SET nombre_rol='$nombre', estatus=1 WHERE id_rol = $id";
  $exec = $lider->modificar($query);
  if($exec['ejecucion']==true){
    $exec = $lider->eliminar("DELETE from accesos WHERE id_rol = $id");
    if($exec['ejecucion']==true){
        
        if(!empty($_POST['accesos'])){
            $accesoss = $_POST['accesos'];
            foreach ($accesoss as $key) {
                $id_permiso = $_POST["permiso".$key];
                $id_modulo = $_POST["modulo".$key];
                $query = "INSERT INTO accesos (id_acceso, id_rol, id_permiso, id_modulo) VALUES (DEFAULT, $id, $id_permiso, $id_modulo)";
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
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Roles', 'Editar', '{$fecha}', '{$hora}')";
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            }

    }else{
      $response = "2";
    }
  }else{
    $response = "2";
  }

  $rol2 = $lider->consultarQuery("SELECT * FROM roles WHERE id_rol = $id");
  $data = $rol2[0];
  $modulos = $lider->consultar("modulos");
  $permisos = $lider->consultar("permisos");
  $accesoss = $lider->consultarQuery("SELECT * from accesos WHERE id_rol = $id");
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
  $rol2 = $lider->consultarQuery("SELECT * FROM roles WHERE id_rol = $id");
  $modulos = $lider->consultar("modulos");
  $permisos = $lider->consultar("permisos");
  $accesoss = $lider->consultarQuery("SELECT * from accesos WHERE id_rol = $id");
  if(Count($rol2)>1){
      $data = $rol2[0];
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