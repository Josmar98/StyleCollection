<?php 
$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Inventarios"){
      $amInventario = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amInventarioR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amInventarioC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amInventarioE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amInventarioB = 1;
      }
    }
  }
}
  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();

if($amInventarioC){
  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $query = "SELECT * FROM almacenes WHERE id_almacen = $id";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
          $response = "1";

          if(!empty($modulo) && !empty($accion)){
                $fecha = date('Y-m-d');
                $hora = date('H:i:a');
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Almacenes', 'Editar', '{$fecha}', '{$hora}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
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
    $direccion = ucwords(mb_strtolower($_POST['direccion']));
    
    $query = "UPDATE almacenes SET nombre_almacen='{$nombre}', direccion_almacen='{$direccion}', estatus=1 WHERE id_almacen = $id";
    $exec = $lider->modificar($query);
    // print_r($exec);
    if($exec['ejecucion']==true){
      $response = "1";
    }else{
      $response = "2";
    }

      $modulos = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus = 1 and id_almacen = $id");
      $datas = $modulos[0];
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
      
    $modulos = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus = 1 and id_almacen = $id");
    if(Count($modulos)>1){
        $datas = $modulos[0];
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
}else{
  require_once 'public/views/error404.php';
}
?>