<?php 


if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

  
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  if(!empty($_POST['validarData'])){
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $query = "SELECT * FROM desperfectos WHERE id_campana = $id_campana and estatus = 1";
    $res1 = $lider->consultarQuery($query);
    // print_r($res1);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
       //    if($res2['ejecucion']==true){
       //      if(Count($res2)>1){
       //        $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
       //        if($res3['ejecucion']==true){
       //          $response = "1";
       //        }
       //      }else{
       //        $response = "9"; //echo "Registro ya guardado.";
       //      }
       //    }


        $response = "1";
      }else{
        $response = "9"; //echo "Registro ya guardado.";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }

  if(!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_final']) && empty($_POST['validarData']) ){
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];

            $query = "UPDATE desperfectos SET fecha_inicio_desperfecto='{$fecha_inicio}', fecha_fin_desperfecto='{$fecha_final}', estatus=1 WHERE id_desperfecto={$id}";
            $exec = $lider->modificar($query);
            if($exec['ejecucion']==true ){
              $response = "1";
        if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Desperfectos', 'Editar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
            }else{
              $response = "2";
            }
            $desperfectos = $lider->consultarQuery("SELECT * FROM desperfectos, campanas WHERE desperfectos.id_campana = campanas.id_campana and desperfectos.estatus = 1 and desperfectos.id_campana = {$id_campana} and  desperfectos.id_desperfecto = {$id}");
      $desperfectos = $desperfectos[0];
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

    $desperfectos = $lider->consultarQuery("SELECT * FROM desperfectos, campanas WHERE desperfectos.id_campana = campanas.id_campana and desperfectos.estatus = 1 and desperfectos.id_campana = {$id_campana} and  desperfectos.id_desperfecto = {$id}");

    if(count($desperfectos)>1){
      $desperfectos = $desperfectos[0];
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