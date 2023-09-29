<?php 

$amPremioscamp = 0;
$amPremioscampR = 0;
$amPremioscampC = 0;
$amPremioscampE = 0;
$amPremioscampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Premios De Campaña"){
      $amPremioscamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPremioscampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPremioscampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPremioscampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPremioscampB = 1;
      }
    }
  }
}


if($amPremioscampE == 1){
  
  $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];

    // print_r($_POST);
    if(!empty($_POST['premios']) ){

      $id_reto = $_POST['premios'];
      $cantidad = $_POST['cantidad'];      
      $query = "UPDATE retos_campana SET id_premio=$id_reto, id_campana=$id_campana, cantidad_coleccion = $cantidad, estatus=1 WHERE id_reto_campana=$id";
      $exec = $lider->registrar($query, "retos_campana", "id_reto_campana");
      if($exec['ejecucion']==true ){
        $response = "1";
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

      $premios=$lider->consultar("premios");
      $retos_campanaId = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} and retos_campana.id_reto_campana = $id");
      $retos_campana = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana}");


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