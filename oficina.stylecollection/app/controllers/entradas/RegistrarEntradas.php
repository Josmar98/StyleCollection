<?php 

$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
      $amInventario = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amInventarioR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amInventarioC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amInventarioE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amInventarioB = 1;
      }
    }
    
  }
}
if($amInventarioR == 1){
  $limiteElementos=20;

  if(!empty($_POST['tipoInv']) && !empty($_POST['transaccion']) && empty($_POST['validarData'])){
    // print_r($_POST);
    $fecha_operacion = date('Y-m-d H:i:s');
    $tipo_operacion="Entrada";
    $tipo_inventario = $_POST['tipoInv'];
    $transaccion = $_POST['transaccion'];
    if($transaccion=="Averia"){
      $id_persona = $_POST["proveedorClientes"];
      $tipo_persona = "Cliente";
    }else{
      $id_persona = $_POST["proveedor{$tipo_inventario}"];
      $tipo_persona = "Proveedor";
    }
    
    $id_almacen = $_POST['almacen'];
    $fecha_documento = $_POST['fecha_documento'];
    $numero_documento = $_POST['numero_documento'];
    $numero_lote = $_POST['numero_lote'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $descincorporar = $_POST['descincorporar'];

    $cantidad_elementos = $_POST['cantidad_elementos'];

    $stocks = $_POST['stock'];
    $id_elementoInvs = $_POST["inventario{$tipo_inventario}"];
    $totales = $_POST['total'];
    $erroresEjecucion = 0;
    for ($i=0; $i < $cantidad_elementos; $i++){
      // echo "<br><br>".$i.":<br>";
      $stock = $stocks[$i];
      $id_elementoInv = $id_elementoInvs[$i];
      if($totales[$i]==""){
        $total = -1;
      }else{
        $total = $totales[$i];
      }
      $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
      $stock_total = 0;
      $total_total = 0;
      if(count($buscar)>1){
        if(!empty($buscar[0])){
          $lasted = $buscar[0];
          $stock_total = $lasted['stock_operacion_total'];
          $total_total = $lasted['total_operacion_total'];
          if($total==(-1)){
            $total = ($total_total/$stock_total);
            $total = $total*$stock;
          }
        }
      }
      if($tipo_operacion=="Entrada"){
        $stock_total += $stock;
        $total_total += $total;
      }
      $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
      $stock_totalAl = 0;
      $total_totalAl = 0;
      if(count($buscar)>1){
        if(!empty($buscar[0])){
          $lasted = $buscar[0];
          $stock_totalAl = $lasted['stock_operacion_almacen'];
          $total_totalAl = $lasted['total_operacion_almacen'];
        }
      }
      if($tipo_operacion=="Entrada"){
        $stock_totalAl += $stock;
        $total_totalAl += $total;
      }
      $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_lote, fecha_vencimiento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', '$numero_documento', '$numero_lote', '$fecha_vencimiento', $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, 1)";
      // echo $query."<br><br>";
      // $exec = ['ejecucion'=>true];
      // $descincorporar="Si";
      $exec = $lider->registrar($query, "operaciones", "id_operacion");
      if($exec['ejecucion']==true){
        $responseR = "1";
        if($descincorporar=="Si"){
          $fecha_operacion = date('Y-m-d H:i:s', time()+1);
          $tipo_operacion="Salida";
          $transaccion = "Desincorporar";
          $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
          $stock_total = 0;
          $total_total = 0;
          if(count($buscar)>1){
            if(!empty($buscar[0])){
              $lasted = $buscar[0];
              $stock_total = $lasted['stock_operacion_total'];
              $total_total = $lasted['total_operacion_total'];
            }
          }
          if($tipo_operacion=="Salida"){
            $stock_total -= $stock;
            $total_total -= $total;
          }
          $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
          $stock_totalAl = 0;
          $total_totalAl = 0;
          if(count($buscar)>1){
            if(!empty($buscar[0])){
              $lasted = $buscar[0];
              $stock_totalAl = $lasted['stock_operacion_almacen'];
              $total_totalAl = $lasted['total_operacion_almacen'];
            }
          }
          if($tipo_operacion=="Entrada"){
            $stock_totalAl += $stock;
            $total_totalAl += $total;
          }
          $query2 = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_lote, fecha_vencimiento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', '$numero_documento', '$numero_lote', '$fecha_vencimiento', $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, 1)";
          // echo "<br><br>".$query2."<br>";
          $exec2 = $lider->registrar($query2, "operaciones", "id_operacion");
          if($exec2['ejecucion']==true){
            $responseR = "1"; 
          }else{
            $responseR = "2";
            $erroresEjecucion++;
          }
        }
      }else{
        $responseR = "2";
        $erroresEjecucion++;
      }
    }
    if($erroresEjecucion==0){
      $response="1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Operaciones (Entrada)', 'Registrar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response="2";
    }
    // die();


    foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){
      $proveedoress = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE proveedores_inventarios.tipoInventario LIKE '%{$tp['id']}%' and  proveedores_inventarios.estatus = 1 ORDER BY proveedores_inventarios.nombreProveedor ASC;");
      $proveedores[$tp['id']] = $proveedoress;
    } }
    $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    // die();
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
    foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){
      $proveedoress = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE proveedores_inventarios.tipoInventario LIKE '%{$tp['id']}%' and  proveedores_inventarios.estatus = 1 ORDER BY proveedores_inventarios.nombreProveedor ASC;");
      $proveedores[$tp['id']] = $proveedoress;
    } }
    $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");

    // print_r($proveedores);
    // $proveedores = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE estatus = 1 ORDER BY nombreProveedor ASC;");
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