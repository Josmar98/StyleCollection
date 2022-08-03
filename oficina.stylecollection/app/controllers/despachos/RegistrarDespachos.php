<?php 

$amDespachos = 0;
$amDespachosR = 0;
$amDespachosC = 0;
$amDespachosE = 0;
$amDespachosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Despachos"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amDespachosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amDespachosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amDespachosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amDespachosB = 1;
      }
    }
  }
}
if($amDespachosR == 1){


  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];


  if(!empty($_POST['validarData'])){
    $numero_despacho = $_POST['numero_despacho'];
    $query = "SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $response = "9"; //echo "Registro ya guardado.";

        $res2 = $lider->consultarQuery("SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE despachos SET estatus = 1 WHERE numero_despacho = $numero_despacho and id_campana = $id_campana");
            if($res3['ejecucion']==true){
              $response = "1";

            }
          }else{
            $response = "9"; //echo "Registro ya guardado.";
          }
        }

        
      }else{
          $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(!empty($_POST['numero_despacho']) && empty($_POST['validarData'])){
    // print_r($_POST);
    $numero_despacho = $_POST['numero_despacho'];
    $fecha_inicial = $_POST['inicial'];
    $primer_pago = $_POST['primer_pago'];
    $segundo_pago = $_POST['segundo_pago'];
    $limite_pedido = $_POST['limite_pedido'];
    $limite_seleccion_plan = $_POST['limite_seleccion_plan'];
    
    $precio_coleccion = $_POST['precio_coleccion'];
    $primer_precio = $_POST['precio1'];
    $segundo_precio = $_POST['precio2'];
    $inicial_precio = $_POST['precioInn'];
      $precio_contado = $_POST['precioContado'];

    $fecha_inicial_senior = $_POST['inicial_senior'];
    $primer_pago_senior = $_POST['primer_pago_senior'];
    $segundo_pago_senior = $_POST['segundo_pago_senior'];
    /*-----------------------------------------------------------*/
    $cantidad_productos = $_POST['cantidad_productos'];
    $elementosid = $_POST['elementosid'];
    $cheking = $_POST['cheking'];
    $precios = $_POST['precios'];
    
    /*-----------------------------------------------------------*/
    // $numIndex = 0;
    // foreach ($elementosid as $key1) {
    //   foreach ($cheking as $key2) {
    //     if($key1 == $key2){

    //       echo "Despacho: 1 | ";
    //       echo "Producto: ".$key1." | ";
    //       echo "numero: ".$numIndex." | ";
    //       echo "Cantidad: ".$cantidad_productos[$numIndex]."<br>";
    //     }   
    //   }
    //   $numIndex++;
    // }
    // echo "<br><br>";
    // echo "<br><br>Cantidad de los productos: ";
    // print_r($cantidad_productos);
    // echo "<br><br>los cheking marcados: ";
    // print_r($cheking);
    // echo "<br><br>Ids de los productos: ";
    // print_r($elementosid);

    /*-----------------------------------------------------------*/

    $query = "INSERT INTO despachos (id_despacho, id_campana, numero_despacho, fecha_inicial, fecha_primera, fecha_segunda, limite_pedido, limite_seleccion_plan, precio_coleccion, primer_precio_coleccion, segundo_precio_coleccion, inicial_precio_coleccion, fecha_inicial_senior, fecha_primera_senior, fecha_segunda_senior, contado_precio_coleccion, estatus) VALUES (DEFAULT, $id_campana, $numero_despacho, '$fecha_inicial', '$primer_pago', '$segundo_pago', '$limite_pedido', '$limite_seleccion_plan', '$precio_coleccion', '$primer_precio', '$segundo_precio', '$inicial_precio', '$fecha_inicial_senior', '$primer_pago_senior', '$segundo_pago_senior', '$precio_contado', 1)";

    $exec = $lider->registrar($query, "despachos", "id_despacho");
    // print_r($exec);
    if($exec['ejecucion']==true){
      $response = "1";
      $id_despacho = $exec['id'];
      $numIndex = 0;
      foreach ($elementosid as $id_producto_key) {
          foreach ($cheking as $id_cantidad_key) {
              if($id_producto_key == $id_cantidad_key){
                $cantidad = $cantidad_productos[$numIndex];
                $precio_producto = $precios[$numIndex];
          	  	$query = "INSERT INTO colecciones (id_coleccion, id_despacho, id_producto, cantidad_productos, precio_producto, estatus) VALUES (DEFAULT, $id_despacho, $id_producto_key, $cantidad, $precio_producto, 1)";
          	  	$exec = $lider->registrar($query, "colecciones", "id_coleccion");
          	  	if($exec['ejecucion']==true ){
          	  		$response = "1";
          	  	}else{
          	  		$response = "2";
          	  	}
              }   
          }
          $numIndex++;
      }
      if($response=="1"){
                if(!empty($modulo) && !empty($accion)){
                  $fecha = date('Y-m-d');
                  $hora = date('H:i:a');
                  $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Registrar', '{$fecha}', '{$hora}')";
                  $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                }
      }

    }else{
      $response = "2";
    }

    $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    $despachosActual = Count($despachosActual)-1;
    $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1");
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
    $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    $despachosActual = Count($despachosActual)-1;
    $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");
    
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