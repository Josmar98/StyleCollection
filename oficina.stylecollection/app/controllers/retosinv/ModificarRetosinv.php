<?php 
$amRetos = 0;
$amRetosR = 0;
$amRetosC = 0;
$amRetosE = 0;
$amRetosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Retos"){
      $amRetos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amRetosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amRetosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amRetosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amRetosB = 1;
      }
    }
  }
}
if($amRetosE == 1){
  
    if(!empty($_POST['validarData'])){
      // $nombre_producto = $_POST['nombre_producto'];
      $query = "SELECT * FROM retosinv WHERE id_retoinv = {$id}";
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

    if(empty($_POST['validarData']) && !empty($_POST['nombre_reto']) && !empty($_POST['num_colecciones'])){

    	$nombre_reto = ucwords(mb_strtolower($_POST['nombre_reto']));
      $num_colecciones = $_POST['num_colecciones'];
      $campAnt = $lider->consultarQuery("SELECT * FROM retosinv WHERE id_retoinv = $id");

      $query = "UPDATE retosinv SET nombre_retoinv='{$nombre_reto}', num_coleccionesreto={$num_colecciones}, estatus=1 WHERE id_retoinv = {$id}";

      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";

          if(!empty($modulo) && !empty($accion)){
            $campAnt = $campAnt[0];
            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Retos de inventario', 'Editar', '{$fecha}', '{$hora}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
      }else{
        $response = "2";
      }


      $retos=$lider->consultarQuery("SELECT * from retosinv WHERE id_retoinv = $id and estatus = 1");
      $reto = $retos[0];
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

      $retos=$lider->consultarQuery("SELECT * from retosinv WHERE id_retoinv = {$id} and estatus = 1");
      if(Count($retos)>1){
    	  $reto = $retos[0];
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