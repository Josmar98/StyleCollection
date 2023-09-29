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
if($amCampanasE == 1){
  
    if(!empty($_POST['validarData'])){
      // $nombre_producto = $_POST['nombre_producto'];
      $query = "SELECT * FROM campanas WHERE id_campana = $id";
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

    if(!empty($_POST['nombre_campana']) && !empty($_POST['num_campana'])){
      // print_r($_POST);

    	$nombre_campana = ucwords(mb_strtolower($_POST['nombre_campana']));
      $num_campana = $_POST['num_campana'];
      $anio = $_POST['anio'];
      $campAnt = $lider->consultarQuery("SELECT * FROM campanas WHERE id_campana = $id");

      $query = "UPDATE campanas SET nombre_campana = '$nombre_campana', anio_campana = '$anio', numero_campana=$num_campana, estatus=1 WHERE id_campana = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";

          if(!empty($modulo) && !empty($accion)){
            $campAnt = $campAnt[0];
            $elementos = array(
              "Nombres"=> [0=>"Id", 1=>ucwords("Nombre De Campaña"), 2=> ucwords("Anio De Campaña"), 3=> ucwords("Numero De Campaña"), 4=>"Estatus"],
              "Anterior"=> [ 0 =>$id, 1 =>$campAnt['nombre_campana'], 2 =>$campAnt['anio_campana'], 3 =>$campAnt['numero_campana'], 4 =>$campAnt['estatus'] ],
              "Actual"=> [ 0=> $id, 1=> $nombre_campana, 2=> $anio , 3=>$num_campana, 4=>"1"]
            );
            $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Campañas', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
      }else{
        $response = "2";
      }


      $campanas=$lider->consultarQuery("SELECT * from campanas WHERE id_campana = $id and estatus = 1");
      $campana = $campanas[0];
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

      $campanas=$lider->consultarQuery("SELECT * from campanas WHERE id_campana = $id and estatus = 1");
      if(Count($campanas)>1){

    	  $campana = $campanas[0];
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