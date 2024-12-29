<?php 

  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();
$amPromociones = 0;
$amPromocionesR = 0;
$amPromocionesC = 0;
$amPromocionesE = 0;
$amPromocionesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Promociones"){
      $amPromociones = 1;
      if($access['nombre_permiso'] == "Registrar"){
      $amPromocionesR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
      $amPromocionesC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
      $amPromocionesE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
      $amPromocionesB = 1;
      }
    }
  }
}
if($amPromocionesR){

  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $query = "SELECT * FROM promocionesinv WHERE nombre_promocioninv = '$nombre'";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $response = "9"; //echo "Registro ya guardado.";

        $res2 = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE nombre_promocioninv = '$nombre' and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE promocionesinv SET estatus = 1 WHERE nombre_promocioninv = '$nombre'");
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
    
    $query = "INSERT INTO promocionesinv (id_promocioninv, nombre_promocioninv, estatus) VALUES (DEFAULT, '$nombre', 1)";
    $exec = $lider->registrar($query, "promocionesinv", "id_promocioninv");
    // print_r($exec);
    if($exec['ejecucion']==true){
      $response = "1";

              if(!empty($modulo) && !empty($accion)){
                $fecha = date('Y-m-d');
                $hora = date('H:i:a');
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Promociones de inventario', 'Registrar', '{$fecha}', '{$hora}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
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