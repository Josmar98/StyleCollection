<?php 
  
  $clientes=$lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");

  if(empty($_POST)){
    if($clientes['ejecucion']==1){
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