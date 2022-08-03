<?php 

$amPlanesCamp = 0;
$amPlanesCampR = 0;
$amPlanesCampC = 0;
$amPlanesCampE = 0;
$amPlanesCampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Planes De Campaña"){
      $amPlanesCamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPlanesCampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPlanesCampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPlanesCampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPlanesCampB = 1;
      }
    }
  }
}
if($amPlanesCampR == 1){
  
    $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];



    if(!empty($_POST['planes']) ){
      // print_r($_POST);

      // $planes = ucwords(mb_strtolower($_POST['planes']));
      $id_plan = $_POST['planes'];
      $color_plan = $_POST['color_plan'];

      $descuento_directo = $_POST['descuento_directo'];
      $descuento_primer = $_POST['descuento_primer'];
      $descuento_segundo = $_POST['descuento_segundo'];
      // $exec = $lider->eliminar("DELETE FROM planes_campana WHERE id_campana = $id_campana");
      // if($exec['ejecucion'] == true){
      //   foreach ($planes as $id_plan) {
              $query = "INSERT INTO planes_campana (id_plan_campana, id_plan, id_campana, color_plan, descuento_directo, primer_descuento, segundo_descuento, estatus) VALUES (DEFAULT, $id_plan, $id_campana, '{$color_plan}', $descuento_directo, $descuento_primer, $descuento_segundo, 1)";
              $exec = $lider->registrar($query, "planes_campana", "id_plan_campana");
              if($exec['ejecucion']==true ){
                $response = "1";
                if(!empty($modulo) && !empty($accion)){
                  $fecha = date('Y-m-d');
                  $hora = date('H:i:a');
                  $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
                  $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                }
              }else{
                $response = "2";
              }
      //   }
      // }else{
      //   $response="2";
      // }



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

      $planes=$lider->consultar("planes");
      $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.estatus = 1 and planes_campana.id_campana = {$id_campana}");


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