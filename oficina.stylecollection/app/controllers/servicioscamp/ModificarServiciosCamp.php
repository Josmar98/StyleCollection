<?php 
$amServicios = 0;
$amServiciosR = 0;
$amServiciosC = 0;
$amServiciosE = 0;
$amServiciosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Promociones"){
	  $amServicios = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amServiciosR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amServiciosC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amServiciosE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amServiciosB = 1;
	  }
	}
  }
}
if($amServiciosE == 1){
  $limitesOpciones = 10;
  
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $precio = (Float) $_POST['precio'];

    $query = "SELECT * FROM promocion WHERE nombre_promocion = '{$nombre}' and precio_promocion = {$precio} and id_campana = {$id_campana} and estatus = 1";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        $res1 = $res1[0];
        if($res1['id_promocion']==$id){
          $response = "1";
        }else{
          $response = "9";
        }
      }else{
        $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }

  if(!empty($_POST['servicio']) && !empty($_POST['precio_opcion']) ){
    // print_r($_POST);
    $id_servicioss = $_POST['servicio'];
    $name_opcion = $_POST['name_opcion'];
    $precio_opcion = $_POST['precio_opcion'];
    
    // $nombre_promocion = $nombrePromoInv."(".ucwords(mb_strtolower($nombre_premio)).")";
    // $precio_promocion = $precio_opcion;
    $query = "UPDATE servicio SET id_servicioss={$id_servicioss}, nombre_servicio='{$name_opcion}', precio_servicio={$precio_opcion}, estatus=1 WHERE id_servicio={$id}";
    // echo "<br>".$query."<br><br>"; $exec=['ejecucion'=>true];
    // die();
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true ){
      $response = "1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Servicios de Campaña', 'Modificar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response = "2";
    }

    $servicioss = $lider->consultarQuery("SELECT * FROM servicioss WHERE estatus=1 ORDER BY nombre_servicioss ASC");
    $servicio = $lider->consultarQuery("SELECT * FROM servicioss, servicio WHERE servicioss.id_servicioss=servicio.id_servicioss and servicio.id_servicio = {$id} and servicio.id_campana = {$id_campana} and servicio.estatus = 1");
    $servicio = $servicio[0];
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
    $servicioss = $lider->consultarQuery("SELECT * FROM servicioss WHERE estatus=1 ORDER BY nombre_servicioss ASC");
    $servicio = $lider->consultarQuery("SELECT * FROM servicioss, servicio WHERE servicioss.id_servicioss=servicio.id_servicioss and servicio.id_servicio = {$id} and servicio.id_campana = {$id_campana} and servicio.estatus = 1");
    // $servicio = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1");
    if($servicio['ejecucion']==true){
      $servicio = $servicio[0];

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