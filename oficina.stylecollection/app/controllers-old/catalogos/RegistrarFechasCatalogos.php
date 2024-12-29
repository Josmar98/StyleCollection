<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

      if(!empty($_POST['validarData'])){
        $apertura = $_POST['apertura'];
        $cierre = $_POST['cierre'];

        $query = "SELECT * FROM fechas_catalogo WHERE fecha_apertura_catalogo = '{$apertura}' and fecha_cierre_catalogo = '{$cierre}' and id_fecha_catalogo = 1 and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
             // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE fecha_apertura_catalogo = '{$apertura}' and fecha_cierre_catalogo = '{$cierre}' and id_fecha_catalogo = 1 and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE fechas_catalogo SET estatus = 1, fecha_apertura_catalogo = '{$apertura}', fecha_cierre_catalogo = '{$cierre}' WHERE id_fecha_catalogo = 1");
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


      if(empty($_POST['validarData']) && isset($_POST['apertura']) && isset($_POST['cierre'])){
        $apertura = $_POST['apertura'];
        $cierre = $_POST['cierre'];
        $buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
        if(count($buscar)>1){
          $query = "UPDATE fechas_catalogo SET fecha_apertura_catalogo='$apertura', fecha_cierre_catalogo='$cierre', estatus=1 WHERE id_fecha_catalogo=1";
          $exec = $lider->modificar($query);
          if($exec['ejecucion']==true){
            $response = "1";
          }else{
            $response = "2";
          }
        }else{
          $query = "INSERT INTO fechas_catalogo (id_fecha_catalogo, fecha_apertura_catalogo, fecha_cierre_catalogo, estatus) VALUES (1, '$apertura', '$cierre', 1)";
          $exec = $lider->registrar($query, "fechas_catalogo", "id_fecha_catalogo");
          if($exec['ejecucion']==true){
            $response = "1";
          }else{
            $response = "2";
          }
        }
        $buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
        $apertura = "";
        $cierre = "";
        if(count($buscar)>1){
          $apertura = $buscar[0]['fecha_apertura_catalogo'];
          $cierre = $buscar[0]['fecha_cierre_catalogo'];
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
        $buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
        $apertura = "";
        $cierre = "";
        if(count($buscar)>1){
          $apertura = $buscar[0]['fecha_apertura_catalogo'];
          $cierre = $buscar[0]['fecha_cierre_catalogo'];
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

}else{
    require_once 'public/views/error404.php';
}


?>