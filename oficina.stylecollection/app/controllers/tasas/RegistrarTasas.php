<?php 

$amTasas = 0;
$amTasasR = 0;
$amTasasC = 0;
$amTasasE = 0;
$amTasasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Tasas"){
      $amTasas = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amTasasR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amTasasC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amTasasE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amTasasB = 1;
      }
    }
  }
}
if($amTasasR == 1){

      if(!empty($_POST['validarData'])){
        
        $fecha = $_POST['fecha'];
        $tasa = $_POST['tasa'];
        $query = "SELECT * FROM tasa WHERE fecha_tasa = '$fecha'";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$fecha' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE tasa SET estatus = 1 WHERE fecha_tasa = '$fecha'");
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

      if(!empty($_POST['fecha']) && !empty($_POST['tasa']) && empty($_POST['validarData'])){

        // print_r($_POST);
        $fecha = $_POST['fecha'];
        $tasa = $_POST['tasa'];
        $buscar = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$fecha'");
        if(count($buscar)>1){
          $query = "UPDATE tasa SET monto_tasa = '{$tasa}', estatus = 1 WHERE fecha_tasa = '$fecha'";
          $exec = $lider->modificar($query);
        }else{
          $query = "INSERT INTO tasa (id_tasa, monto_tasa, fecha_tasa, estatus) VALUES (DEFAULT, '$tasa', '$fecha', 1)";
          $exec = $lider->registrar($query, "tasa", "id_tasa");
        }

        if($exec['ejecucion']==true){
          $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Tasas', 'Registrar', '{$fecha}', '{$hora}')";
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