<?php 
$amPlanes = 0;
$amPlanesR = 0;
$amPlanesC = 0;
$amPlanesE = 0;
$amPlanesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Planes"){
      $amPlanes = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPlanesR = 1;
      }
      if
        ($access['nombre_permiso'] == "Ver"){
        $amPlanesC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPlanesE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPlanesB = 1;
      }
    }
  }
}
if($amPlanesE == 1){

        if(!empty($_POST['validarData'])){
          // $nombre_plan = $_POST['nombre_plan'];
          $query = "SELECT * FROM planes WHERE id_plan = '$id'";
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

        if(!empty($_POST['nombre_plan']) && empty($_POST['validarData']) ){

          // print_r($_POST);
          $nombre_plan = ucwords(mb_strtolower($_POST['nombre_plan']));
          $cantidad = $_POST['cantidad'];
          
          $query = "UPDATE planes SET nombre_plan = '$nombre_plan', cantidad_coleccion = $cantidad, estatus = 1 WHERE id_plan = $id";

          $exec = $lider->modificar($query);
          if($exec['ejecucion']==true){
            $response = "1";
                    if(!empty($modulo) && !empty($accion)){
                      $fecha = date('Y-m-d');
                      $hora = date('H:i:a');
                      $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes', 'Editar', '{$fecha}', '{$hora}')";
                      $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                    }
          }else{
            $response = "2";
          }


          $planes = $lider->consultarQuery("SELECT  * from planes WHERE id_plan = $id and estatus = 1");
          $plan = $planes[0];
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

          $planes = $lider->consultarQuery("SELECT  * from planes WHERE id_plan = $id and estatus = 1");
          if(Count($planes)>1){
            $plan = $planes[0];
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
          } else {
            require_once 'public/views/error404.php';
          } 
        }

}else{
   require_once 'public/views/error404.php';
}


?>