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
if($amTasasE == 1){
      if(!empty($_POST['validarData'])){

        $fecha = $_POST['fecha'];
        $tasa=0;
        $tasa_tarde=0;
        if(!empty($_POST['tasa'])){
          $tasa = (float) $_POST['tasa'];
        }
        if(!empty($_POST['tasa_tarde'])){
          $tasa_tarde = (float) $_POST['tasa_tarde'];
        }
        $query = "SELECT * FROM eficoin WHERE fecha_tasa = '$fecha'";
        $res1 = $lider->consultarQuery($query);
        // if($res1['ejecucion']==true){
        //   if(Count($res1)>1){

        //     $response = "1";
        //   }else{
        //     // $response = "1";
        //     // echo "No existe ningun con esta fecha";
        //     $response = "1"; //echo "Registro ya guardado.";
        //   }
        // }else{
        //   $response = "5"; // echo 'Error en la conexion con la bd';
        // }
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM eficoin WHERE fecha_tasa = '$fecha' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE eficoin SET estatus = 1 WHERE fecha_tasa = '$fecha'");
                if($res3['ejecucion']==true){
                  $response = "1";
                }
              }else{
                if($res1[0]['id_eficoin']==$id){
                  $response = "1";
                }else{
                  $response = "9"; //echo "Registro ya guardado.";
                }
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
        $tasa=0;
        $tasa_tarde=0;
        if(!empty($_POST['tasa'])){
          $tasa = (float) $_POST['tasa'];
        }
        if(!empty($_POST['tasa_tarde'])){
          $tasa_tarde = (float) $_POST['tasa_tarde'];
        }
        
        $query = "UPDATE eficoin SET monto_tasa = {$tasa}, fecha_tasa = '{$fecha}', monto_tasa_tarde = {$tasa_tarde}, estatus = 1 WHERE id_eficoin = {$id}";
        $exec = $lider->modificar($query);
        if($exec['ejecucion']==true){
          $response = "1";

          if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Eficoin', 'Editar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
        }else{
          $response = "2";
        }


        $eficoins = $lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 and id_eficoin = $id");
        $eficoin = $eficoins[0];
        // print_r($tasa);
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
        $eficoins = $lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 and id_eficoin = $id");
        if(!empty($action)){
          $eficoin = $eficoins[0];
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