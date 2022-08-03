<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
      if(!empty($_POST['validarData'])){
        $clausula = ucwords(mb_strtolower($_POST['clausula']));
        $query = "SELECT * FROM configuraciones WHERE clausula = '$clausula'";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";

            $res2 = $lider->consultarQuery("SELECT * FROM configuraciones WHERE clausula = '$clausula' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE configuraciones SET estatus = 1 WHERE clausula = '$clausula'");
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


      if(!empty($_POST['nombre']) && !empty($_POST['cantidadGemas']) && !empty($_POST['condicion']) ){

        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $cantidad = $_POST['cantidadGemas'];
        $condicion = ucwords(mb_strtolower($_POST['condicion']));
          
        $buscar = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = '{$nombre}'");

        if(count($buscar)>1){
          $buscar = $buscar[0];
          if($buscar['id_configgema']==$id){
            $query = "UPDATE configgemas SET nombreconfiggema='{$nombre}', cantidad_correspondiente='{$cantidad}', condicion='{$condicion}', estatus=1 WHERE id_configgema = $id";
            $exec = $lider->modificar($query);
            if($exec['ejecucion']==true){
              $response = "1";
                      if(!empty($modulo) && !empty($accion)){
                        $fecha = date('Y-m-d');
                        $hora = date('H:i:a');
                        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion de Gemas', 'Editar', '{$fecha}', '{$hora}')";
                        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                      }
            }else{
              $response = "2";
            }
          }else{
            $response = "9";
          }
        }else{
            $query = "UPDATE configgemas SET nombreconfiggema='{$nombre}', cantidad_correspondiente='{$cantidad}', condicion='{$condicion}', estatus=1 WHERE id_configgema = $id";
            $exec = $lider->modificar($query);
            if($exec['ejecucion']==true){
              $response = "1";
                      if(!empty($modulo) && !empty($accion)){
                        $fecha = date('Y-m-d');
                        $hora = date('H:i:a');
                        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion de Gemas', 'Editar', '{$fecha}', '{$hora}')";
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

        $configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE id_configgema = {$id}");
        if(count($configgemas)>1){
          $configgema=$configgemas[0];
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