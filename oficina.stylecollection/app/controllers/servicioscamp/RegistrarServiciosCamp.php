<?php 
$amServicios = 0;
$amServiciosR = 0;
$amServiciosC = 0;
$amServiciosE = 0;
$amServiciosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Servicios"){
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
if($amServiciosR == 1){
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
        $response = "9"; //echo "Registro ya guardado.";
      }else{
        $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }

  if( !empty($_POST['servicio']) && !empty($_POST['name_opcion']) ){
    // print_r($_POST);
    $id_servicioss = $_POST['servicio'];
    $cantOpciones = $_POST['cantidad_opciones'];
    // $precio_opcion = $_POST['precio_opcion'];
    // $name_opcion = $_POST['name_opcion'];
    
    $serviciosss = $lider->consultarQuery("SELECT * FROM servicioss WHERE estatus=1 and id_servicioss={$id_servicioss}");
    $nombreServicioss = "";
    foreach ($serviciosss as $key) {
      if(!empty($key['nombre_servicioss'])){
        $nombreServicioss=$key['nombre_servicioss'];
      }
    }
    // echo $nombreServicioss;
    // die();
    
    $errores = 0;
    for ($x=0; $x < $cantOpciones; $x++) {
      $nombre_opcion = ucwords(mb_strtolower($_POST['name_opcion'][$x]));
      $precio_opcion = $_POST['precio_opcion'][$x];
      // $elementos = $_POST['cantidad_elementos'][$x];
      // for ($z=0; $z <$elementos; $z++) {
      //   $unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
      //   // $unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
      //   $inventarios[$x][count($inventarios[$x])] = $_POST['inventarios'][$x][$z];
      //   $tipos[$x][count($tipos[$x])] = $_POST['tipos'][$x][$z];
      //   $precioss[$x][count($precioss[$x])] = $_POST['precio'][$x][$z];
      // }
      // $nombre_promocion = $nombreServicioss." (".$nombre_premio.")";
      $nombre_servicio = $nombre_opcion;
      $precio_servicio = $precio_opcion;
      $query = "INSERT INTO servicio (id_servicio, id_campana, id_servicioss, nombre_servicio, precio_servicio, estatus) VALUES (DEFAULT, {$id_campana}, {$id_servicioss}, '{$nombre_servicio}', {$precio_servicio}, 1)";
      $exec = $lider->registrar($query, "servicio", "id_servicio");
      if($exec['ejecucion']==true ){
      }else{
        $errores++;
      }
      
    }

    // die();

    if($errores==0){
      $response = "1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Servicios de Campaña', 'Registrar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response = "2";
    }
    $servicioss = $lider->consultarQuery("SELECT * FROM servicioss WHERE estatus=1 ORDER BY nombre_servicioss ASC");
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
    // $premios=$lider->consultarQuery("SELECT * FROM premios");

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