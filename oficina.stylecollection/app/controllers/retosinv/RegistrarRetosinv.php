<?php 

$amRetos = 0;
$amRetosR = 0;
$amRetosC = 0;
$amRetosE = 0;
$amRetosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Retos"){
      $amRetos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amRetosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amRetosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amRetosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amRetosB = 1;
      }
    }
  }
}
if($amRetosR == 1){

      if(!empty($_POST['validarData'])){
        $nombre_reto = ucwords(mb_strtolower($_POST['nombre_reto']));
        $num_colecciones = $_POST['num_colecciones'];
        $query = "SELECT * FROM retosinv WHERE nombre_retoinv='{$nombre_reto}' and num_coleccionesreto={$num_colecciones} and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            $response = "9"; //echo "Registro ya guardado.";
            // $res2 = $lider->consultarQuery("SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 0");
            // if($res2['ejecucion']==true){
            //   if(Count($res2)>1){
            //     $res3 = $lider->modificar("UPDATE campanas SET estatus = 1 WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana");
            //     if($res3['ejecucion']==true){
            //       $response = "1";

            //     }
            //   }else{
            //     $response = "9"; //echo "Registro ya guardado.";
            //   }
            // }
            
          }else{
              $response = "1";
          }
        }else{
          $response = "5"; // echo 'Error en la conexion con la bd';
        }
        echo $response;
      }

      if(empty($_POST['validarData']) && !empty($_POST['nombre_reto']) && !empty($_POST['num_colecciones'])){

        // print_r($_POST);
        $nombre_reto = ucwords(mb_strtolower($_POST['nombre_reto']));
        $num_colecciones = $_POST['num_colecciones'];
        
        $query = "INSERT INTO retosinv (id_retoinv, nombre_retoinv, num_coleccionesreto, estatus) VALUES (DEFAULT, '{$nombre_reto}', $num_colecciones, 1)";
        $exec = $lider->registrar($query, "retosinv", "id_retoinv");
        // die();
        // print_r($exec);
        if($exec['ejecucion']==true){
          $response = "1";
            if(!empty($modulo) && !empty($accion)){
              $id = $exec['id'];
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Retos de inventario', 'Registrar', '{$fecha}', '{$hora}')";
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