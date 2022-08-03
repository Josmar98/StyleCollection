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
if($amPlanesR == 1){

      if(!empty($_POST['validarData'])){
        $nombre_plan = ucwords(mb_strtolower($_POST['nombre_plan']));
        $query = "SELECT * FROM planes WHERE nombre_plan = '$nombre_plan'";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";

            $res2 = $lider->consultarQuery("SELECT * FROM planes WHERE nombre_plan = '$nombre_plan' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE planes SET estatus = 1 WHERE nombre_plan = '$nombre_plan'");
                if($res3['ejecucion']==true){
                  $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes', 'Registrar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
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

      if(!empty($_POST['nombre_plan']) && empty($_POST['validarData']) ){
        // print_r($_POST);

        $nombre_plan = ucwords(mb_strtolower($_POST['nombre_plan']));
        // $descuento_directo = $_POST['descuento_directo'];
        // $descuento_primer = $_POST['descuento_primer'];
        // $descuento_segundo = $_POST['descuento_segundo'];
        $cantidad = $_POST['cantidad'];
        
        // $query = "INSERT INTO planes (id_plan, nombre_plan, descuento_directo, primer_descuento, segundo_descuento, cantidad_coleccion, estatus) VALUES (DEFAULT, '$nombre_plan', $descuento_directo, $descuento_primer, $descuento_segundo, $cantidad, 1)";
        $query = "INSERT INTO planes (id_plan, nombre_plan, cantidad_coleccion, estatus) VALUES (DEFAULT, '$nombre_plan', $cantidad, 1)";

        $exec = $lider->registrar($query, "planes", "id_plan");
        if($exec['ejecucion']==true){
          $response = "1";
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

        // $fragancias = $lider->consultarQuery("SELECT  * from fragancias WHERE estatus = 1");
        // $fragancias = $register2[0];
        // print_r($fragancias);
        
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