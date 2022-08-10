<?php 

  
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


?>