<?php 

$amCampanas = 0;
$amCampanasR = 0;
$amCampanasC = 0;
$amCampanasE = 0;
$amCampanasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Campañas"){
      $amCampanas = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amCampanasR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amCampanasC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amCampanasE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amCampanasB = 1;
      }
    }
  }
}
if($amCampanasR == 1){

      if(!empty($_POST['validarData'])){
        $nombre_campana = ucwords(mb_strtolower($_POST['nombre_campana']));
        $numero_campana = $_POST['numero_campana'];
        $query = "SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 1
        ";
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

      if(!empty($_POST['nombre_campana']) && !empty($_POST['num_campana'])){

        // print_r($_POST);
        $nombre_campana = ucwords(mb_strtolower($_POST['nombre_campana']));
        $num_campana = $_POST['num_campana'];
        $anio = $_POST['anio'];
        
        $query = "INSERT INTO campanas (id_campana, nombre_campana, anio_campana, numero_campana, visibilidad, estado_campana, estatus) VALUES (DEFAULT, '$nombre_campana', '$anio', $num_campana, 0, 1, 1)";

        $exec = $lider->registrar($query, "campanas", "id_campana");
        if($exec['ejecucion']==true){
          $response = "1";
            if(!empty($modulo) && !empty($accion)){
              $id = $exec['id'];
              $elementos = array(
                "Nombres"=> [0=>"Id", 1=>ucwords("Nombre De Campaña"), 2=> ucwords("Anio De Campaña"), 3=> ucwords("Numero De Campaña"), 4=>"Visibilidad", 5=>"Estatus"],
                "Anterior"=> "",
                "Actual"=> [ 0=> $id, 1=> $nombre_campana, 2=> $anio , 3=>$num_campana, 4=>"0", 5=>"1"]
              );
              $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Registrar', '{$fecha}', '{$hora}', '{$elementosJson}')";
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