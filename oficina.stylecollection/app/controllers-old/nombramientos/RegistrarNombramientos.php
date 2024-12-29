<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){
      // if(!empty($_POST['validarData'])){
      //   $clausula = ucwords(mb_strtolower($_POST['clausula']));
      //   $query = "SELECT * FROM configuraciones WHERE clausula = '$clausula'";
      //   $res1 = $lider->consultarQuery($query);
      //   if($res1['ejecucion']==true){
      //     if(Count($res1)>1){
      //       // $response = "9"; //echo "Registro ya guardado.";

      //       $res2 = $lider->consultarQuery("SELECT * FROM configuraciones WHERE clausula = '$clausula' and estatus = 0");
      //       if($res2['ejecucion']==true){
      //         if(Count($res2)>1){
      //           $res3 = $lider->modificar("UPDATE configuraciones SET estatus = 1 WHERE clausula = '$clausula'");
      //           if($res3['ejecucion']==true){
      //             $response = "1";

      //           }
      //         }else{
      //           $response = "9"; //echo "Registro ya guardado.";
      //         }
      //       }


      //     }else{
      //         $response = "1";
      //     }
      //   }else{
      //     $response = "5"; // echo 'Error en la conexion con la bd';
      //   }
      //   echo $response;
      // }

      if(!empty($_POST['lider']) && !empty($_POST['liderazgo']) && !empty($_POST['campana']) ){

        $id_cliente = $_POST['lider'];
        $id_confignombramientos = $_POST['liderazgo'];
        $id_campana = $_POST['campana'];
        $liderazgos = $lider->consultarQuery("SELECT * FROM confignombramientos WHERE id_confignombramientos = {$id_confignombramientos}");
        $id_liderazgo = $liderazgos[0]['id_liderazgo'];
        $cantidad = $liderazgos[0]['cantidad_correspondiente'];
        $fecha = date('Y-m-d');
        $hora = date('h:i a');
        // echo $id_cliente." - ".$id_confignombramientos." - ".$id_liderazgo." - ".$cantidad." - 1";
        $buscar = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente} and id_liderazgo = {$id_liderazgo}");
        if(count($buscar)>1){
          $response = "9";
        }else{
          $query = "INSERT INTO nombramientos (id_nombramiento, id_campana, id_cliente, id_confignombramientos, id_liderazgo, cantidad_gemas, fecha_nombramiento, hora_nombramiento, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$id_confignombramientos}, {$id_liderazgo}, '{$cantidad}', '{$fecha}', '{$hora}', 1)";
          $exec = $lider->registrar($query, "nombramientos", "id_nombramiento");
          if($exec['ejecucion']==true){
            $response = "1";
                    if(!empty($modulo) && !empty($accion)){
                      $fecha = date('Y-m-d');
                      $hora = date('H:i:a');
                      $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Nombramiento', 'Registrar', '{$fecha}', '{$hora}')";
                      $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                    }
          }else{
            $response = "2";
          }
        }
        echo $response;


        // if(!empty($action)){
        //   if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
        //     require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
        //   }else{
        //       require_once 'public/views/error404.php';
        //   }
        // }else{
        //   if (is_file('public/views/'.$url.'.php')) {
        //     require_once 'public/views/'.$url.'.php';
        //   }else{
        //       require_once 'public/views/error404.php';
        //   }
        // } 

      }

      if(empty($_POST)){
        $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, confignombramientos WHERE liderazgos.id_liderazgo=confignombramientos.id_liderazgo and confignombramientos.estatus = 1");
        $campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and campanas.visibilidad = 1 and despachos.estatus = 1 ORDER BY campanas.id_campana DESC");
        // print_r($liderazgos);
        $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
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