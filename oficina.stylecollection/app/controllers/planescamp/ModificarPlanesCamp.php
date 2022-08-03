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
if($amPlanesCampE == 1){

        
        $id_campana = $_GET['campaing'];
        $numero_campana = $_GET['n'];
        $anio_campana = $_GET['y'];

        $planess=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = $id_campana and campanas.estatus = 1 and planes.estatus = 1;");

      if(!empty($_POST['planes']) ){
        // print_r($_POST);

        // $planes = ucwords(mb_strtolower($_POST['planes']));
        $planes = $_POST['planes'];
        $color_plan = $_POST['color_plan'];
        $descuento_directo = $_POST['descuento_directo'];
        $descuento_primer = $_POST['descuento_primer'];
        $descuento_segundo = $_POST['descuento_segundo'];
        $query = "UPDATE planes_campana SET id_campana=$id_campana, id_plan=$planes, color_plan = '{$color_plan}', descuento_directo=$descuento_directo, primer_descuento=$descuento_primer, segundo_descuento=$descuento_segundo WHERE id_plan_campana=$id";
        $exec = $lider->modificar($query);
        if($exec['ejecucion']==true ){
          $response = "1";
                if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Campaña', 'Editar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
        }else{
          $response = "2";
        }
        // echo $query;
          $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana=$id and planes_campana.estatus = 1");

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

        // $planes=$lider->consultar("planes");
        $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana=$id and planes_campana.estatus = 1");

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