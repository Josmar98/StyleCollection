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
if($amPromocionesE == 1){
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

  if(!empty($_POST['promo']) && !empty($_POST['precio']) ){
    // print_r($_POST);

    $id_promocioninv = $_POST['promo'];
    $precio_opcion = $_POST['precio_opcion'];
    $promosinv = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE estatus=1 and id_promocioninv={$id_promocioninv}");
    $nombrePromoInv = "";
    foreach ($promosinv as $key) {
      if(!empty($key['nombre_promocioninv'])){
        $nombrePromoInv=ucwords(mb_strtolower($key['nombre_promocioninv']));
      }
    }
    
    $errores = 0;
    $nombre_premio = ucwords(mb_strtolower($_POST['name_opcion']));
    $elementos = $_POST['cantidad_elementos'];
    $unidades = [];
    $inventarios = [];
    $tipos = [];
    $precioss = [];
    for ($z=0; $z <$elementos; $z++) {
      $unidades[count($unidades)] = $_POST['unidades'][$z];
      // $unidades[count($unidades)] = $_POST['unidades'][$z];
      $inventarios[count($inventarios)] = $_POST['inventarios'][$z];
      $tipos[count($tipos)] = $_POST['tipos'][$z];
      $precioss[count($precioss)] = $_POST['precio'][$z];
    }

    $promocionesinv = $lider->consultarQuery("SELECT * FROM promocion, productos_promocion WHERE promocion.id_promocion=productos_promocion.id_promocion and id_promocioninv={$id_promocioninv}");
    $id_premioB = 0;
    foreach ($promocionesinv as $key) {
      if(!empty($key['id_producto'])){
        if($key['id_promocion']==$_GET['id']){
          // echo $key['id_promocion'];
          $id_premioB=$key['id_producto'];
        }
      }
    }
    // die();
    // AQUI HASTA AQUI
    // $borrado = $lider->eliminar("DELETE FROM premios WHERE id_premio={$id_premioB}");
    // $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
    // $execPremio = $lider->registrar($query, "premios", "id_premio");
    // echo "ID DEL PREMIO DEBE SER 522, VEAMOS = ".$id_premioB;
    
    // die();

    $query="UPDATE premios SET nombre_premio='{$nombre_premio}', descripcion_premio='{$nombre_premio}', estatus=1 WHERE id_premio={$id_premioB}";
    // echo "<br>".$query."<br><br>"; $execPremio=['ejecucion'=>true];
    $execPremio = $lider->modificar($query); 
    if($execPremio['ejecucion']==true){
      // $id_premio = $execPremio['id'];
      $id_premio = $id_premioB;
      $tipoPremio = "Premio";
      $borradoxd = $lider->eliminar("DELETE FROM premios_inventario WHERE id_premio={$id_premioB}");
      for ($z=0; $z < $elementos; $z++){
        $unidad = $unidades[$z];
        $tipo = $tipos[$z];
        $precio_inventario = (float) number_format($precioss[$z],2,'.','');
        $id_inventario = $inventarios[$z];
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
      
      $nombre_promocion = $nombrePromoInv."(".ucwords(mb_strtolower($nombre_premio)).")";
      $precio_promocion = $precio_opcion;
      $query = "UPDATE promocion SET nombre_promocion='{$nombre_promocion}', precio_promocion={$precio_promocion}, estatus=1 WHERE id_promocion={$id}";
      // echo "<br>".$query."<br><br>"; $exec=['ejecucion'=>true];
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true ){
        $id_promocion = $id;
        $exec2 = $lider->eliminar("DELETE FROM productos_promocion WHERE id_promocion = {$id}");
        $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id_promocion}, '{$tipoPremio}', {$id_premio}, 1)";
        // echo "<br>".$query2."<br><br>";
        $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
        if($exec2['ejecucion']==true ){}else{
          $errores++;
          // echo "productos_promocion";
        }
      }else{
        // echo "Promocion";
        $errores++;
      }
    }else{
      $errores++;
    }

    // AQUI HASTA AQUI

    // die();
    // $nombre = ucwords(mb_strtolower($_POST['nombre']));
    // $precio = (Float) $_POST['precio'];
    // $productos = $_POST['productos'];
    // $premios = $_POST['premios'];
    // $query = "UPDATE promocion SET nombre_promocion='{$nombre}', precio_promocion={$precio}, estatus=1 WHERE id_promocion={$id}";
    // // // $exec = ['ejecucion'=>true, 'id'=>1];
    // $errores = 0;
    // $exec = $lider->modificar($query);
    // if($exec['ejecucion']==true ){
    //   $exec2 = $lider->eliminar("DELETE FROM productos_promocion WHERE id_promocion = {$id}");
    //   foreach ($productos as $prod) {
    //     $tipo = "";
    //     list($tipo, $id_producto) = explode('-', $prod);
    //     $tipo = ucwords(mb_strtolower($tipo));
    //     $query2 = "INSERT INTO productos_promocion (id_producto_promocion, id_campana, id_promocion, tipo_producto, id_producto, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, '{$tipo}', {$id_producto}, 1)";
    //     $exec2 = $lider->registrar($query2, "productos_promocion", "id_producto_promocion");
    //     if($exec2['ejecucion']==true ){}else{
    //       $errores++;
    //     }
    //   }

    //   $exec2 = $lider->eliminar("DELETE FROM premios_promocion WHERE id_promocion = {$id}");
    //   foreach ($premios as $prem) {
    //     $tipo = "";
    //     list($tipo, $id_premio) = explode('-', $prem);
    //     $tipo = ucwords(mb_strtolower($tipo));
    //     $query3 = "INSERT INTO premios_promocion (id_premio_promocion, id_campana, id_promocion, tipo_premio, id_premio, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, '{$tipo}', {$id_premio}, 1)";
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
    // die();
    if($errores==0){
      $response = "1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Promociones de Campaña', 'Modificar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response = "2";
    }
    // echo "RESPUESTA DE EJECUCION: ".$response."<br>";

    $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $promocionesinv = $lider->consultarQuery("SELECT * FROM promocionesinv WHERE estatus=1 ORDER BY nombre_promocioninv ASC");
    $ppromo = $lider->consultarQuery("SELECT * FROM promocionesinv, promocion, productos_promocion, premios WHERE promocionesinv.id_promocioninv=promocion.id_promocioninv and promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1 and productos_promocion.id_promocion=promocion.id_promocion and productos_promocion.id_producto=premios.id_premio");
    // $promocion = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1");
    $promocion = $ppromo[0];
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
    $ppromo = $lider->consultarQuery("SELECT * FROM promocionesinv, promocion, productos_promocion, premios WHERE promocionesinv.id_promocioninv=promocion.id_promocioninv and promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1 and productos_promocion.id_promocion=promocion.id_promocion and productos_promocion.id_producto=premios.id_premio");
    // print_r($ppromo);
    // $promocion = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_promocion = {$id} and promocion.id_campana = {$id_campana} and promocion.estatus = 1");
    if($ppromo['ejecucion']==true){
      $promocion = $ppromo[0];

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