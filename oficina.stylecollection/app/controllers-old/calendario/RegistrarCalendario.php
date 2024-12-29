<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
// $amTasas = 0;
// $amTasasR = 0;
// $amTasasC = 0;
// $amTasasE = 0;
// $amTasasB = 0;
// foreach ($accesos as $access) {
//   if(!empty($access['id_acceso'])){
//     if($access['nombre_modulo'] == "Tasas"){
//       $amTasas = 1;
//       if($access['nombre_permiso'] == "Registrar"){
//         $amTasasR = 1;
//       }
//       if($access['nombre_permiso'] == "Ver"){
//         $amTasasC = 1;
//       }
//       if($access['nombre_permiso'] == "Editar"){
//         $amTasasE = 1;
//       }
//       if($access['nombre_permiso'] == "Borrar"){
//         $amTasasB = 1;
//       }
//     }
//   }
// }
// if($amTasasR == 1){

      if(!empty($_POST['validarData'])){
        
        $fecha = $_POST['fecha'];
        $tipo = $_POST['tipoEvento'];
        $nombre = $_POST['nombreEvento'];
        // $query = "SELECT * FROM festividades WHERE fecha_festividad = '{$fecha}' and nombre_festividad = '{$nombre}'";
        $query = "SELECT * FROM festividades WHERE fecha_festividad = '{$fecha}'";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $res2 = $lider->consultarQuery("SELECT * FROM festividades WHERE fecha_festividad = '{$fecha}' and nombre_festividad = '{$nombre}' and estatus = 0");
            $res2 = $lider->consultarQuery("SELECT * FROM festividades WHERE fecha_festividad = '{$fecha}' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                // $res3 = $lider->modificar("UPDATE festividades SET estatus = 1 WHERE fecha_festividad = '{$fecha}' and nombre_festividad = '{$nombre}'");
                $res3 = $lider->modificar("UPDATE festividades SET estatus = 1 WHERE fecha_festividad = '{$fecha}'");
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

      if(!empty($_POST['fecha']) && !empty($_POST['nombreEvento']) && empty($_POST['validarData'])){

        $fecha = $_POST['fecha'];
        $year = substr($fecha, 0, 4);
        $tipo = ucwords(mb_strtolower($_POST['tipoEvento']));
        $nombre = ucwords(mb_strtolower($_POST['nombreEvento']));

        
        $query = "INSERT INTO festividades (id_festividad, fecha_festividad, year_festividad, tipo_festividad, nombre_festividad, estatus) VALUES (DEFAULT, '{$fecha}', '{$year}', '{$tipo}', '{$nombre}', 1)";

        $exec = $lider->registrar($query, "festividades", "id_festividad");
        if($exec['ejecucion']==true){
          $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Festividad de Calendario', 'Registrar', '{$fecha}', '{$hora}')";
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