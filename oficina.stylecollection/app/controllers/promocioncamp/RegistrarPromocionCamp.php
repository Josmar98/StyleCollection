<?php 
$amPromociones = 0;
$amPromocionesR = 0;
$amPromocionesC = 0;
$amPromocionesE = 0;
$amPromocionesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Promociones"){
	  $amPromociones = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amPromocionesR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amPromocionesC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amPromocionesE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amPromocionesB = 1;
	  }
	}
  }
}
if($amPromocionesR == 1){
  $limitesOpciones = 10;
  $limitesElementos = 50;
  
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

  if( !empty($_POST['promo']) && !empty($_POST['name_opcion']) ){
    // print_r($_POST);
    $id_promocioninv = $_POST['promo'];
    $cantOpciones = $_POST['cantidad_opciones'];
    $precio_opcion = $_POST['precio_opcion'];
    $promosinv = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE estatus=1 and id_promocioninv={$id_promocioninv}");
    $nombrePromoInv = "";
    foreach ($promosinv as $key) {
      if(!empty($key['nombre_promocioninv'])){
        $nombrePromoInv=$key['nombre_promocioninv'];
      }
    }
    
    $errores = 0;
    for ($x=0; $x < $cantOpciones; $x++) {
      $nombre_premio = ucwords(mb_strtolower($_POST['name_opcion'][$x]));
      $elementos = $_POST['cantidad_elementos'][$x];
      $unidades[$x] = [];
      $inventarios[$x] = [];
      $tipos[$x] = [];
      $precioss[$x] = [];
      for ($z=0; $z <$elementos; $z++) {
        $unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
        // $unidades[$x][count($unidades[$x])] = $_POST['unidades'][$x][$z];
        $inventarios[$x][count($inventarios[$x])] = $_POST['inventarios'][$x][$z];
        $tipos[$x][count($tipos[$x])] = $_POST['tipos'][$x][$z];
        $precioss[$x][count($precioss[$x])] = $_POST['precio'][$x][$z];
      }

      // AQUI HASTA AQUI
      $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
      // echo "<br>".$query."<br><br>"; $execPremio=['ejecucion'=>true, 'id'=>222];
      $execPremio = $lider->registrar($query, "premios", "id_premio");
      if($execPremio['ejecucion']==true){
        // print_r($execPremio);
        $id_premio = $execPremio['id'];
        $tipoPremio = "Premio";
        for ($z=0; $z < $elementos; $z++){
          $unidad = $unidades[$x][$z];
          $tipo = $tipos[$x][$z];
          $id_inventario = $inventarios[$x][$z];
          $precio_inventario = (float) number_format($precioss[$x][$z],2,'.','');
          $posMercancia = strpos($id_inventario,'m');
          if(strlen($posMercancia)==0){
            $id_element = $id_inventario;
          }else{
            $id_element = preg_replace("/[^0-9]/", "", $id_inventario);
          }
          $query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, precio_inventario, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidad}, '{$tipo}', {$precio_inventario}, 1)";
          // echo "<br>".$query."<br><br>";
          $execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
          if($execPI['ejecucion']==true){
          }else{
            $errores++;
          }
        }
        
        $nombre_promocion = $nombrePromoInv." (".$nombre_premio.")";
        $precio_promocion = $precio_opcion[$x];
        $query = "INSERT INTO promocion (id_promocion, id_campana, id_promocioninv, nombre_promocion, precio_promocion, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocioninv}, '{$nombre_promocion}', {$precio_promocion}, 1)";
        // echo "<br>".$query."<br><br>"; $exec=['ejecucion'=>true, 'id'=>5555];
        $exec = $lider->registrar($query, "promocion", "id_promocion");
        if($exec['ejecucion']==true ){
          $id_promocion = $exec['id'];
          $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipoPremio}', {$id_premio}, 1)";
          // echo "<br>".$query2."<br><br>";
          $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
          if($exec2['ejecucion']==true ){}else{
            $errores++;
          }
        }else{
          $errores++;
        }
      }else{
        $errores++;
      }
      // AQUI HASTA AQUI
    }
    // echo "Errores: ".$errores;
    // die();

    if($errores==0){
      $response = "1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Promociones de Campaña', 'Registrar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response = "2";
    }

    // echo "Response: ".$response."<br>";
    // die();
    // $nombre = ucwords(mb_strtolower($_POST['nombre']));
    // $precio = (Float) $_POST['precio'];
    // $productos = $_POST['productos'];
    // $premios = $_POST['premios'];
    // $query = "INSERT INTO promocion (id_promocion, id_campana, nombre_promocion, precio_promocion, estatus) VALUES (DEFAULT, {$id_campana}, '{$nombre}', {$precio}, 1)";
    // $errores = 0;
    // $exec = $lider->registrar($query, "promocion", "id_promocion");
    // if($exec['ejecucion']==true ){
    //   $id_promocion = $exec['id'];
    //   // $exec2 = $lider->eliminar("DELETE FROM productos_promocion WHERE id_promocion = {$id_promocion}");
    //   foreach ($productos as $prod) {
    //     $tipo = "";
    //     list($tipo, $id_producto) = explode('-', $prod);
    //     $tipo = ucwords(mb_strtolower($tipo));
    //     $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipo}', {$id_producto}, 1)";
    //     $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
    //     if($exec2['ejecucion']==true ){}else{
    //       $errores++;
    //     }
    //   }

    //   // $exec2 = $lider->eliminar("DELETE FROM premios_promocion WHERE id_promocion = {$id_promocion}");
    //   foreach ($premios as $prem) {
    //     $tipo = "";
    //     list($tipo, $id_premio) = explode('-', $prem);
    //     $tipo = ucwords(mb_strtolower($tipo));
    //     $query3 = "INSERT INTO premios_promocion (id_premio_promocion, id_campana, id_promocion, tipo_premio, id_premio, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipo}', {$id_premio}, 1)";
    //     $exec3 = $lider->registrar($query3, "premios_promocion", "id_premio_promocion");
    //     if($exec3['ejecucion']==true ){}else{
    //       $errores++;
    //     }
    //   }
    //   // $response = "1";
    // }else{
    //   $errores++;
    //   // $response = "2";
    // }

    // echo "RESPUESTA DE EJECUCION: ".$response."<br>";

    $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    
    $promocionesinv = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE estatus=1 ORDER BY nombre_promocioninv ASC");

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

    $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    
    $promocionesinv = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE estatus=1 ORDER BY nombre_promocioninv ASC");
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